<?php
include_once('db_connect.php');
$col = $_POST['col'];
$dept = $_POST['dept'];
$name = $_POST['name'];
$code = $_POST['code'];

$result = $db->query("SELECT department.id FROM college JOIN department ON college.id=department.college_id WHERE college.name='$col' AND department.name='$dept';");
if ($result->rowCount() > 0) {
	$dept_id = $result->fetch();
	$dept_id = $dept_id['id'];
	echo "$dept_id";
	$result = $db->query("INSERT INTO course VALUES(DEFAULT, $dept_id, '$code', '$name');");
	if ($result) {
		echo '<script language="javascript">
			alert("The course is successfully added");
			window.location.href = "main.html";
		</script>';
	}
	else {
		echo '<script language="javascript">
				alert("Error adding course. Are you sure that the course is not already available?");
				window.location.href = "main.html";
			</script>';
	}
}

?>