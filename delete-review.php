<?php
/**
 * delete-review.php
 * Script to delete a professor or a course review from the database.
 * No authentication is required since this option is only available
 * in the user profile page. Additional confirmation prompt is displayed
 * in the profile page before deleting the review.
 */

include_once('db_connect.php');
session_start();
$user_id = $_POST['userID'];
$course_id = $_POST['courseID'];
$prof_id = $_POST['profID'];

if (array_key_exists('deleteProfReview', $_POST)) {
    $query = "DELETE FROM prof_review WHERE user_id=? AND prof_id=? AND course_id=?;";
    $query = $db->prepare($query);
    $result = $query->execute(array($user_id, $prof_id, $course_id));

}
else if (array_key_exists('deleteCourseReview', $_POST)) {
    $query = "DELETE FROM course_review WHERE user_id=? AND prof_id=? AND course_id=?;";
    $query = $db->prepare($query);
    $result = $query->execute(array($user_id, $prof_id, $course_id));
}


$_SESSION['delete-success'] = true;
header("Location:profile.php");
