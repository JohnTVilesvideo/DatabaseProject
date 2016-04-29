<?php
/**
 * Author: Amrit
 * Date: 4/16/16
 * Time: 7:36 PM
 */
include_once('db_connect.php');
session_start();
$userID = $_SESSION['user_id'];
$courseID = $_POST['courseID'];
$profID = $_POST['profID'];
$result = $db->prepare("SELECT * FROM prof_review WHERE user_id=? AND course_id=? AND prof_id=?;");
$result->execute(array($userID, $courseID, $profID));
if ($result->rowCount() > 0) {
    $_SESSION['add-failed'] = true;
    $_SESSION['professorID'] = $_POST['profID'];
    $_SESSION['courseID'] = $_POST['courseID'];
    $_SESSION['easiness'] = $_POST['easiness'];
    $_SESSION['helpfulness'] = $_POST['helpfulness'];
    $_SESSION['clarity'] = $_POST['clarity'];
    $_SESSION['professor_review'] = $_POST['professor_review'];
    $_SESSION['overall_rating'] = $_POST['overall_rating'];
    header("Location:professor-review.php");
} else {
    $easiness = $_POST['easiness'];
    $helpfulness = $_POST['helpfulness'];
    $clarity = $_POST['clarity'];
    $review = $_POST['professor_review'];
    $overallRating = $_POST['overall_rating'];
    $query = $db->prepare("INSERT INTO prof_review VALUES(?, ? , ?, ?, ?, ?, ?, ?);");
    $query->execute(array($userID, $profID, $courseID, $review, $helpfulness, $easiness, $clarity, $overallRating));
    $_SESSION['review_added'] = true;
    header("Location:professor.php?id=$profID");
}
?>