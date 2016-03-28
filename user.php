<?php
$id = $_GET['id'];
	

?>
<html>
<head>
<title>User Profile</title>
</head>
<body>
<h1 style="text-align: center">Login</h1>
<form name='fmAdd' method='POST' action='logincheck.php'>
<table style="float:center">
	<tr>
		<td><input type='text' name='username' placeholder='Username'></td>
	</tr>
	<tr>
		<td><input type='password' name='password' placeholder='Password'></td>
	</tr>
</table>
<br>
<input type='submit' value='Login'>
</form>
<button onclick="location.href = 'signup.html';">Sign Up</button>
</body>
</html>
