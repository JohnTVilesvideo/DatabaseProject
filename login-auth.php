<?php

include_once('db_connect.php');

$username = $_POST['username'];
$password = md5($_POST['password']);
//$referer = $_POST['referer'];
$redirect = null;
$append = null;
if($_POST['location'] != '') {
    $redirect = $_POST['location'];
}
if (array_key_exists('append', $_POST) ){
    $append = $_POST['append'];
}
$result = $db->prepare("SELECT * FROM user WHERE username=? AND password=?;");
$result->execute(array($username, $password));
session_start();

if ($result->rowCount() != 0) {
    $user = $result->fetch();
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['users_name'] = $user['fname'] . " " . $user['lname'];

    if($redirect) {
        header("Location:". $redirect);
    }
    else {
        header("Location:index.php");
    }

} else {
    $_SESSION['login_failed'] = true;

    if($redirect) {
        header("Location:login.php?location=". $redirect);
    }
    else {
        header("Location:login.php");
    }
}
?>
<html>
<head>
    <script type="text/javascript"> sessionStorage.clear()</script>
</head>
</html>

