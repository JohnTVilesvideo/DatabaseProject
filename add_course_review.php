<?php
include_once('db_connect.php');

session_start();

//print_r($_POST);
$user_id = $_SESSION['user_id'];
$course_id = $_SESSION['course_id'];
$dept_id = $_SESSION['dept_id'];
$course = $_SESSION['course'];

$professor = $_POST['professor'];
$textbook = $_POST['isTextRequired'];
//echo "textbook require value: " . $textbook;
$easiness = $_POST['easiness'];
$courseReview = $_POST['review'];
$usefulness = array_key_exists('usefulness', $_POST) ? $_POST['usefulness'] : 'NULL';
$tips = array_key_exists('usefulness', $_POST) ? $_POST['tips'] : 'NULL';
$overall = $_POST['overall'];

echo "user id: " . $user_id;
printf("Department id: %d\n", $dept_id);
printf("Course id: %d\n", $course_id);

/* get professor id */
$getProf = $db->query("SELECT id, name FROM professor WHERE name = '$professor'  AND dept_id='$dept_id'");
$resultProf = $getProf->fetch();
$prof_id = $resultProf['id'];
$prof = $resultProf['name'];
printf("Professor id: %d\n", $prof_id);


/* Add review to course */
$query = $db->prepare("INSERT INTO course_review VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);");
$result = $query->execute(array($user_id, $course_id, $prof_id, $easiness, $textbook, $courseReview, $usefulness, $tips, $overall));

if ($result) {
	printf("<p>You have reviewed course <b>%s</b>! If you have not reviewed professor <b>%s</b> yet, please take some minutes to <a href='professor_review.php'>review</a> or click <a href='main.html'>here</a> to go back to main page</p>", $course, $prof);
}
else {
	printf("<p>You have already reviewed course <b>%s</b> with professor <b>%s</b>. Please <a href='main.html'>update</a> your review or <a href='course_review.php'>review</a> a new course</p>", $course, $prof);
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
	sessionStorage.setItem('profID', "<?php echo $profID ?>");
	sessionStorage.setItem('courseID', "<?php echo $courseID ?>");

</script>

</body>
</html>
