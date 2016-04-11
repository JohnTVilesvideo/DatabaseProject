<?php
include_once('db_connect.php');
session_start();
/* Enable if finish redirect
if (!isset($_SESSION['user_id'])) {
	echo '<script language="javascript">
	alert("Please login to review a course or professor");
	window.location.href = "login.html";
	</script>';
}*/
?>

<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<title>Add Professor</title>
<style>
input[type=text] {
	width: 300px;
	height: 50px;
    
    margin: auto;
	font-size: 15px;
	
	box-sizing: border-box;
    border: 2px solid black;
    border-radius: 10px;	
}

.center {
	text-align:center
}
</style>
</head>
<body>
<?php include('nav.php'); ?>
<h1 style="text-align: center">Add a new Professor</h1>
<form method='POST' action='add_new_prof.php' accept-charset="UTF-8"
style='padding: 30px 0px 20px'>
<!--<input type="hidden" name="profID">
<input type="hidden" name="courseID">-->

<table align='center'>
	<tr>
		<td><p>College Name: </p></td>
		<td><input type='text' name='col' placeholder="College Name" required></td>
		
	</tr>
	<tr>
		<td><p>Department Name: </p></td>
		<td><input type='text' name='dept' placeholder="Department" required></td>
	</tr>
	<tr>
		<td><p>Professor Name: </p></td>
		<td><input type='text' name='name' placeholder="Professor Full Name" required></td>
	</tr>
	<tr>
		<td></td>
		<td style='text-align: center'><input type='submit' value='Submit'></td>
	</tr>
</table>
</form>
</body>
</html>




