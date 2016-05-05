<?php
/**
 * edit-course-review-auth.php
 * Authorizing updating review for a course
 * Author: Dung Truong
 */
include_once('db_connect.php');

session_start();

$user_id = $_SESSION['user_id'];
$course_id = $_POST['courseID'];
$dept_id = $_POST['deptID'];

$prof_id = $_POST['profID'];
$textbook = $_POST['textbook_required'];
$textbookRequired = $textbook == 'on' ? 1 : 0;
$easiness = $_POST['easiness'];
$courseReview = $_POST['course_review'];
$usefulness = array_key_exists('helpfulness', $_POST) ? $_POST['helpfulness'] : 'NULL';
$tips = array_key_exists('tips', $_POST) ? $_POST['tips'] : 'NULL';
$overall = $_POST['overall_rating'];


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




