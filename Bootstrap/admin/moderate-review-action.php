<?php
include_once('../db_connect.php');
session_start();

if (!array_key_exists('user_id', $_SESSION)) {
    header("Location:login.php");
}
$userID = $_SESSION['user_id'];
$query = "SELECT usergroup FROM user WHERE id = $userID;";
$result = $db->query($query);
$user = $result->fetch();
if ($user['usergroup'] != 'MOD') {
    header("Location:login.php");
}
$type = $_POST['review_type'];
$reviewer = $_POST['user_id'];
$professor = $_POST['prof_id'];
$course = $_POST['course_id'];
$action = $_POST['btn'];
if ($action == 'Dismiss Report') {
    $query = "DELETE FROM reported_review WHERE type=$type AND user_id = $reviewer AND prof_id=$professor AND course_id=$course;";
    $db->query($query);
} else if ($action == 'Delete Review') {
    $query = "DELETE FROM reported_review WHERE type=$type AND user_id = $reviewer AND prof_id=$professor AND course_id=$course;";
    $db->query($query);
    if ($type == 0) {
        $query = "DELETE FROM prof_review WHERE user_id = $reviewer AND prof_id=$professor AND course_id=$course;";
        $db->query($query);
    } else if ($type == 1) {
        $query = "DELETE FROM course_review WHERE user_id = $reviewer AND prof_id=$professor AND course_id=$course;";
        $db->query($query);
    }
}
header("Location:index.php");