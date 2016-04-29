<?php

include_once('db_connect.php');
session_start();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
//$referer = $_POST['referer'];

$redirect = null;
$append = null;
if($_POST['location'] != '') {
    $redirect = $_POST['location'];
}
if ($_POST['append'] != '') {
    $append = $_POST['append'];
}

if ($password != $confirm_password) {
    $_SESSION['signup_failed'] = true;
    $_SESSION['password_mismatch'] = true;
}

$result = $db->prepare("Select * FROM user WHERE username=?;");
$result->execute(array($username));
if ($result->rowCount() > 0) {
    $_SESSION['signup_failed'] = true;
    $_SESSION['invalid_username'] = true;
}
$result = $db->prepare("Select * FROM user WHERE email=?;");
$result->execute(array($email));
if ($result->rowCount() > 0) {
    $_SESSION['signup_failed'] = true;
    $_SESSION['invalid_email'] = true;
}

if (array_key_exists('signup_failed', $_SESSION)) {
    header('Location:signup.php'.$append);
} else {
    unset($_SESSION['signup_failed']);
    unset($_SESSION['invalid_username']);
    unset($_SESSION['invalid_email']);
    $password = md5($password);
    $result = $db->prepare("INSERT INTO user VALUES(DEFAULT, ?, ?, ?, ?, ?, 'USER');");
    $result->execute(array($username, $password, $fname, $lname, $email));
    if ($result) {
        $result = $db->prepare("SELECT * FROM user WHERE username=? AND password=?;");
        $result->execute(array($username, $password));
        $user = $result->fetch();
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['users_name'] = $fname . " " . $lname;

        if ($redirect == null) {
            header('Location:index.php');
        } else {
            header('Location:login.php' . $append);
        }

    } else {
        header('Location:signup.php' . $append);
    }
}
?>
<html>
<head>
    <script type="text/javascript"> sessionStorage.clear()</script>
</head>
</html>

