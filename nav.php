<?php
// user log
if (!isset($_SESSION['user_id'])) {
	printf("<nav style='text-align: right'><a href='login.php'>Login</a> |	<a href='signup.html'>Sign Up</a></nav>");
}
else {
	printf("<nav style='text-align: right'><a href='profile.php'>Welcome %s</a> | <a href='logout.php'>Logout</a></nav>", $_SESSION['username']);
}
?>