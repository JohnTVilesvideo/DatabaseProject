<?php

include_once('../db_connect.php');

$username = $_POST['username'];
$password = md5($_POST['password']);
$result = $db->prepare("SELECT * FROM user WHERE username=? AND password=?;");
$result->execute(array($username, $password));
session_start();

if ($result->rowCount() != 0) {
    $user = $result->fetch();
    if ($user['usergroup'] != 'MOD') {
        $_SESSION['login_failed'] = true;
        header("Location:login.php");
    }
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['users_name'] = $user['fname'] . " " . $user['lname'];
    header("Location:index.php");
} else {
    $_SESSION['login_failed'] = true;
    header("Location:login.php");
}
?>