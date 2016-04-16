<?php

include_once('db_connect.php');

$username = $_POST['username'];
$password = $_POST['password'];
$courseID = $_POST['courseID'];
$referer = $_POST['referer'];

$query = "SELECT * FROM user WHERE username='$username' AND password=MD5('$password');";
$result = $db->query($query);
session_start();
$redirect = NULL;
if($_POST['location'] != '') {
    $redirect = $_POST['location'];
}

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

    /*if (substr($referer, 0, 35) != "http://cs.gettysburg.edu/~dhakam01/") {
        $url = 'Location:index.php';
    } else {
        $url = 'Location:' . $referer;
    }

    if (array_key_exists('redirect', $_SESSION)) {
        unset($_SESSION['redirect']);
    }
    header($url);***/
} else {
    $_SESSION['login_failed'] = true;
    $_SESSION['redirect'] = $_POST['referer'];
    header('Location:login.php');
}
?>
<html>
<head>
    <script type="text/javascript"> sessionStorage.clear()</script>
</head>
</html>

