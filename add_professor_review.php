<?php
include_once('db_connect.php');
session_start();

//print_r($_POST);
echo "user id: \n" . $_SESSION['user_id'];
$user_id = $_SESSION['user_id'];
$prof_id = $_POST['prof_id'];
$dept_id = $_POST['dept_id'];
$course = $_POST['course'];
$profReview = $_POST['professorReview'];
$helpfulness = $_POST['helpfulness'];
$clarity = $_POST['clarity'];
$easiness = $_POST['easiness'];
$overall = $_POST['overall'];

printf("Department id: %d\n", $_POST['dept_id']);
printf("Professor id: %d\n", $_POST['prof_id']);

// course id
$getCourse = $db->query("SELECT id FROM course WHERE name = '$course'  AND dept_id='$dept_id'");
$resultCourse = $getCourse->fetch();
$course_id = $resultCourse['id'];
printf("Course id: %d\n", $course_id);

/* Add review to professor */
$query = $db->prepare("INSERT INTO prof_review VALUES(?, ?, ?, ?, ?, ?, ?, ?);");
$result = $query->execute(array($user_id, $prof_id, $course_id, $profReview, $helpfulness, $easiness, $clarity, $overall));

// handle if the user already write a review of this course for this professor
if ($result) {
	printf("<p>You have reviewed professor <b>%s</b>! If you have not reviewed the course <b>%s</b> yet, please take some minutes to <a href='course_review.php'>review</a> or click <a href='main.html'>here</a> to go back to main page</p>", $_SESSION['prof'], $course);
}
else {
	printf("<p>You have reviewed professor <b>%s</b> for the course <b>%s</b> already. Please <a href='main.html'>update</a> your review or <a href='professor_review.php'>review</a> a new professor</p>", $_SESSION['prof'], $course);
}
?>

<html>
<head>
<title>Review added</title>

</head>
<body>
<script type="text/javascript">
	//console.log("college: " + "<?php echo $college ?>");
	sessionStorage.setItem('college', "<?php echo $college ?>");
	sessionStorage.setItem('department', "<?php echo $department ?>");
	sessionStorage.setItem('course', "<?php echo $course ?>");
	sessionStorage.setItem('professor', "<?php echo $professor ?>");
	sessionStorage.setItem('courseID', "<?php echo $courseID ?>");
	sessionStorage.setItem('profID', "<?php echo $profID ?>");

</script>
	<?php ?>

</body>
</html>
