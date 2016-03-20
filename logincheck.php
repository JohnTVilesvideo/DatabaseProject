<?php

include_once('db_connect.php');

$username     =     $_POST['username'];
$password =     $_POST['password'];

$query = "SELECT * FROM user WHERE username='$username' AND password=MD5('$password');";
$result = $db->query($query);
if ($result->rowCount() != 0) {
	$user = $result->fetch();
	session_start();
	$_SESSION['username'] = $user['username'];
	$_SESSION['user_id'] = $user['id'];

	echo '<script language="javascript">
	alert("Login successfully");
	window.location.href = "main.html";
	</script>';
}
else {
	echo '<script language="javascript">
	alert("Wrong username and/or password");
	window.location.href = "login.html";
	</script>';
}
?>
