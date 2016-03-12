<?php

include_once('db_connect.php');

$username     =     $_POST['username'];
$password =     $_POST['password'];
$repassword = 	$_POST['repassword'];
$fname    =     $_POST['fname'];
$lname    =     $_POST['lname'];
$email    =     $_POST['email'];


if ($password != $repassword) {
	echo '<script language="javascript">
			alert("Password does not match");
			window.location.href = "signup.html";
			</script>';
	// improve: find a way so that user only need to fill password again
}
else { // validate and sign up
	// still need to implement email validation
	
	// check duplicate email
	$query = "SELECT email FROM user WHERE email='$email'";
	$result = $db->query($query);
	if ($result->rowCount() != 0) {
		echo '<script language="javascript">
			alert("Email has been used. Please sign up with a different email address");
			window.location.href = "signup.html";
			</script>';
	}
	else {
		// check duplicate username
		$query = "SELECT email FROM user WHERE username='$username'";
		$result = $db->query($query);
		if ($result->rowCount() != 0) {
			echo '<script language="javascript">
			alert("Username has been used. Please sign up with a different username");
			window.location.href = "signup.html";
			</script>';
		}
		else {
			// new valid user --> add to table
			$query = "INSERT INTO user VALUES(DEFAULT, '$username', MD5('$password'), '$fname', '$lname', '$email', 'USER')";
			//printf("Query = %s\n", $query);

			$result = $db->query($query);

			if ($result != false) {
				echo '<script language="javascript">';
				echo 'alert("Sign up successfully");';
				echo 'window.location.href = "main.html";';
				echo '</script>';
			}
			else {
				echo '<script language="javascript">';
				echo 'alert("Sign up unsuccessfully");';
				echo 'window.location.href = "main.html";';
				echo '</script>';
			}
		}
	}
}
?>
