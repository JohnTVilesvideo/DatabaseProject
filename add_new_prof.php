<?php
include_once('db_connect.php');
$col = $_POST['col'];
$dept = $_POST['dept'];
$name = $_POST['name'];

$result = $db->query("SELECT department.id FROM college JOIN department ON college.id=department.college_id WHERE college.name='$col' AND department.name='$dept';");
if ($result->rowCount() > 0) {
	$dept_id = $result->fetch();
	$dept_id = $dept_id['id'];
	echo "$dept_id";
	$result = $db->query("INSERT INTO professor VALUES(DEFAULT,  '$name', $dept_id);");
	if ($result) {
		echo '<script language="javascript">
			alert("New professor is successfully added");
			window.location.href = "main.html";
		</script>';
	}
	else {
		echo '<script language="javascript">
				alert("Error adding professor. Are you sure that the professor is not already in the database?");
				window.location.href = "main.html";
			</script>';
	}
}

?>