<?php

include_once('db_connect.php');
session_start();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$referer = $_POST['referer'];

if ($password != $confirm_password) {
    $_SESSION['signup_failed'] = true;
    $_SESSION['password_mismatch'] = true;
}

$query = "Select * FROM user WHERE username='$username';";
$result = $db->query($query);
if ($result->rowCount() > 0) {
    $_SESSION['signup_failed'] = true;
    $_SESSION['invalid_username'] = true;
}
$query = "Select * FROM user WHERE email='$email';";
$result = $db->query($query);
if ($result->rowCount() > 0) {
    $_SESSION['signup_failed'] = true;
    $_SESSION['invalid_email'] = true;
}

if (array_key_exists('signup_failed', $_SESSION)) {
    $_SESSION['redirect'] = $_POST['referer'];
    header('Location:signup.php');
} else {
    unset($_SESSION['signup_failed']);
    unset($_SESSION['invalid_username']);
    unset($_SESSION['invalid_email']);
    $password = md5($password);
    $query = "INSERT INTO user VALUES(DEFAULT, '$username', '$password', '$fname', '$lname', '$email', 'USER');";
    $result = $db->query($query);
    if ($result) {
        if (substr($referer, 0, 35) != "http://cs.gettysburg.edu/~dhakam01/") {
            $url = 'Location:index.php';
        } else {
            $url = 'Location:' . $referer;
        }
        $_SESSION['signup_success'] = true;
        $_SESSION['redirect'] = $_POST['referer'];
        header('Location:login.php');
    } else {
        $_SESSION['redirect'] = $_POST['referer'];
        header('Location:signup.php');
    }
}
?>
<html>
<head>
    <script type="text/javascript"> sessionStorage.clear()</script>
</head>
</html>

