<?php

include_once('db_connect.php');

$username     =     $_POST['username'];
$password =     $_POST['password'];

$query = "SELECT username FROM user WHERE username='$username' AND password=MD5('$password');";
$result = $db->query($query);
if ($result->rowCount() != 0) {
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
