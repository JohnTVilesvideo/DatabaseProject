<?php
include_once('db_connect.php');

session_start();

//print_r($_POST);
$user_id = $_SESSION['user_id'];
$course_id = $_POST['courseID'];
$dept_id = $_POST['deptID'];

$prof_id = $_POST['profID'];
$textbook = $_POST['textbook_required'];
$textbookRequired = $textbook == 'on' ? 1 : 0;
//echo "textbook require value: " . $textbook;
$easiness = $_POST['easiness'];
$courseReview = $_POST['course_review'];
$usefulness = array_key_exists('helpfulness', $_POST) ? $_POST['helpfulness'] : 'NULL';
$tips = array_key_exists('tips', $_POST) ? $_POST['tips'] : 'NULL';
$overall = $_POST['overall_rating'];
//echo $user_id;
//echo $course_id;
//echo $dept_id;
//echo $prof_id;

echo $easiness;
echo $courseReview;
echo $usefulness;
echo $tips;
echo $overall;
//exit(0);

//echo "user id: " . $user_id;
//printf("Department id: %d\n", $dept_id);
//printf("Course id: %d\n", $course_id);

/* get professor id */
//$getProf = $db->query("SELECT id, name FROM professor WHERE name = '$professor'  AND dept_id='$dept_id'");
//$resultProf = $getProf->fetch();
//$prof_id = $resultProf['id'];
//$prof = $resultProf['name'];
//printf("Professor id: %d\n", $prof_id);


/* Add review to course */
$query = $db->prepare("UPDATE course_review SET easiness=?, textbook_required=?, review=?, usefulness=?, tips=?, overall_rating=? WHERE user_id=? AND course_id=? AND prof_id=?;");
$result = $query->execute(array($easiness, $textbookRequired, $courseReview, $usefulness, $tips, $overall,$user_id, $course_id, $prof_id));
if ($result) {
    echo "Success";
    $_SESSION['update-success'] = true;
    header("Location:profile.php");
}
else {
    $errors = $query->errorInfo();
    echo($errors[2]);
}




