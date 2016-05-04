<?php
/**
 * Author: Amrit
 * Date: 5/4/16
 * Time: 12:12 AM
 */
include_once('db_connect.php');
$info = $_POST['username_or_email'];
$user = $db->prepare("SELECT * FROM user WHERE username=? OR email=?;");
$user->execute(array($info, $info));
session_start();
if ($user->rowCount() == 0) {
    $_SESSION['no_account'] = true;
    header("Location:password-reset.php");
    exit(0);
}
//override previous password reset request if it is in database
$user = $user->fetch();
$userID = $user['id'];
$prev_request = $db->prepare("SELECT * FROM password_reset_auth WHERE user_id=?;");
$prev_request->execute(array($userID));
if ($prev_request->rowCount() > 0) {
    $delete_prev_request = $db->prepare("DELETE FROM password_reset_auth WHERE user_id=?");
    $delete_prev_request->execute(array($userID));
}
$unique = false;
while (!$unique) {
    $auth = generateRandomString(32);
    $auth_check = $db->prepare("SELECT * FROM password_reset_auth WHERE auth=?");
    $auth_check->execute(array($auth));
    $unique = $auth_check->rowCount() == 0;
}
$time = date('Y-m-d H:i:s');
$insert_reset_auth = $db->prepare("INSERT INTO password_reset_auth VALUES (?, ?, ?)");
$insert_reset_auth->execute(array($userID, $auth, $time));
sendResetEmail($user, $auth);
$_SESSION['reset_success'] = true;
header("Location:login.php");
function sendResetEmail($to_user, $auth_token)
{
    $to_address = $to_user['email'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $url_length = strlen($request_uri) - strrpos($request_uri, "/");
    $url = "http://" . $_SERVER['SERVER_NAME'] . substr($request_uri, 0, $url_length) .
        "/password-reset.php?auth=$auth_token"; //returns the current URL
    $subject = "Password Reset: Rate my Professor";
    $message = "<html>To initiate the password reset process for your Rate my Professor account, click on the link below:<br><br>" .
        "<a href='$url'>$url</a><br><br>" .
        "If clicking on the link above doesn't work, please copy and paste the URL in a new broswer window instead.<br><br>" .
        "If you did not make the request, you can safely disregard this email. <br><br> Sincerely,<br>Rate my Professors Team </html>";
    mail($to_address, $subject, $message, "Content-Type: text/html");
}

function generateRandomString($length = 10)
{
    $alphanumeric = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $alphanumeric[rand(0, 61)];
    }
    return $randomString;
}
