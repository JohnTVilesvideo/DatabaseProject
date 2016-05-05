<?php
/**
 * edit-prof-review-auth.php
 * Authorizing updating review for a professor
 * Author: Dung Truong
 */
include_once('db_connect.php');

session_start();

$user_id = $_SESSION['user_id'];
$course_id = $_POST['courseID'];
$dept_id = $_POST['deptID'];

$prof_id = $_POST['profID'];

$easiness = $_POST['easiness'];
$profReview = $_POST['prof_review'];
$helpfulness = array_key_exists('helpfulness', $_POST) ? $_POST['helpfulness'] : 'NULL';
$overall = $_POST['overall_rating'];
$clarity = $_POST['clarity'];

/* Add review to course */
$query = $db->prepare("UPDATE prof_review SET review=?, helpfulness=?, easiness=?, clarity=?, overall_rating=? WHERE user_id=? AND course_id=? AND prof_id=?;");
$result = $query->execute(array( $profReview, $helpfulness, $easiness, $clarity, $overall, $user_id, $course_id, $prof_id));
if ($result) {
    echo "Success";
    $_SESSION['update-success'] = true;
    header("Location:profile.php");
}
else {
    $errors = $query->errorInfo();
    echo($errors[2]);
}





