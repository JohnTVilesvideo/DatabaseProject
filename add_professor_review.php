<?php
include_once('db_connect.php');

session_start();
error_reporting(E_ALL);
//print_r($_POST);

$userID = $_SESSION['user_id'];
echo "user id: " . $userID;
//$profID = $_POST['profID'];
//$courseID = $_POST['courseID'];
$college = $_POST['college'];
$department = $_POST['department'];
$professor = $_POST['professor'];
$course = $_POST['course'];
$profReview = $_POST['professorReview'];
$helpfulness = $_POST['helpfulness'];
$clarity = $_POST['clarity'];
$easiness = $_POST['easiness'];
$overall = $_POST['overall'];

/** search for prof id
 *  No checking for result to exist yet */
/* college id */
	$getCollege = $db->query("SELECT id FROM college WHERE name='$college'");
	$resultCollege = $getCollege->fetch();
	$collegeID = $resultCollege['id'];
	printf("College id: %d\n", $collegeID);

	/* department id */
	$getDept = $db->query("SELECT id FROM department WHERE name='$department' AND college_id=$collegeID");
	$resultDept = $getDept->fetch();
	$deptID = $resultDept['id'];
	printf("Department id: %d\n", $deptID);

	/* professor id */
	$getProf = $db->query("SELECT id FROM professor WHERE dept_id=$deptID AND name='$professor'");
	$resultProf = $getProf->fetch();
	$profID = $resultProf['id'];
	printf("Professor id: %d\n", $profID);

	/* course id */
	$getCourse = $db->query("SELECT id FROM course WHERE name = '$course'  AND dept_id='$deptID'");
	$resultCourse = $getCourse->fetch();
	$courseID = $resultCourse['id'];
	printf("Course id: %d\n", $courseID);

echo "".$profID;
echo "".$courseID;

/* Add review to professor */
$query = $db->prepare("INSERT INTO prof_review VALUES(?, ?, ?, ?, ?, ?, ?, ?);");
$result = $query->execute(array($userID, $profID, $courseID, $profReview, $helpfulness, $easiness, $clarity, $overall));

// handle if the user already write a review of this course for this professor
if ($result) {
	printf("<p>You have reviewed professor <b>%s</b>! If you have not reviewed the course <b>%s</b> yet, please take some minutes to <a href='course_review.php'>review</a> or click <a href='main.html'>here</a> to go back to main page</p>", $professor, $course);
}
else {
	printf("<p>You have reviewed professor <b>%s</b> already. Please <a href='main.html'>update</a> your review or <a href='professor_review.php'>review</a> a new professor</p>", $professor);
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
