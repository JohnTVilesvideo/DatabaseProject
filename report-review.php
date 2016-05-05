<?php
/**
 * report-review.php
 * Script to add a report associated with a review to the database.
 * Appropriate confirmation message is produced after successful reporting.
 * Reviews can be reported without logging in. So, no authentication is required.
 */
include_once("db_connect.php");
session_start();
if (!array_key_exists('user_id', $_SESSION)) {
    header("Location:index.php");
}
$review_type = $_POST['review_type'];
$user_id = $_POST['user_id'];
$prof_id = $_POST['prof_id'];
$course_id = $_POST['course_id'];
$result = $db->query("SELECT report_count FROM reported_review WHERE type=$review_type AND user_id=$user_id AND prof_id=$prof_id AND course_id=$course_id;");
if ($result->rowCount() == 0) {
    $db->query("INSERT INTO reported_review VALUES ($review_type, $user_id, $prof_id, $course_id, 1);");
} else {
    $report = $result->fetch();
    $report_count = $report['report_count'] + 1;
    $db->query("UPDATE reported_review SET report_count=$report_count WHERE type=$review_type AND user_id=$user_id AND prof_id=$prof_id AND course_id=$course_id;");
}
$_SESSION['reported'] = true;
header("Location:" . $_SERVER['HTTP_REFERER']);