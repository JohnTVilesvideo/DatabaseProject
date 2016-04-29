<?php
include_once('../db_connect.php');
session_start();

if (!array_key_exists('user_id', $_SESSION)) {
    header("Location:login.php");
}
$userID = $_SESSION['user_id'];
$result = $db->prepare("SELECT usergroup FROM user WHERE id = ?;");
$result->execute(array($userID));
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
    $query = $db->prepare("DELETE FROM reported_review WHERE type=? AND user_id = ? AND prof_id=? AND course_id=?;");
    $query->execute(array($type, $reviewer, $professor, $course));
} else if ($action == 'Delete Review') {
    $query = $db->prepare("DELETE FROM reported_review WHERE type=? AND user_id = ? AND prof_id=? AND course_id=?;");
    $query->execute(array($type, $reviewer, $professor, $course));
    if ($type == 0) {
        $query = $db->prepare("DELETE FROM prof_review WHERE user_id = ? AND prof_id=? AND course_id=?;");
        $query->execute(array($reviewer, $professor, $course));
    } else if ($type == 1) {
        $query = $db->prepare("DELETE FROM course_review WHERE user_id = ? AND prof_id=? AND course_id=?;");
        $query->execute(array($reviewer, $professor, $course));
    }
}
header("Location:index.php");