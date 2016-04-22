<?php

include_once('db_connect.php');

$username = $_POST['username'];
$password = $_POST['password'];
//$referer = $_POST['referer'];
$redirect = null;
$append = null;
if($_POST['location'] != '') {
    $redirect = $_POST['location'];
}
if ($_POST['append'] != '') {
    $append = $_POST['append'];
}
$query = "SELECT * FROM user WHERE username='$username' AND password=MD5('$password');";
$result = $db->query($query);
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
        header("Location:index.php");
    }
}
?>
<html>
<head>
    <script type="text/javascript"> sessionStorage.clear()</script>
</head>
</html>

