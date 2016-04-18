<?php
/**
 * Author: Amrit
 * Date: 4/17/16
 * Time: 4:58 PM
 */
include_once('db_connect.php');
session_start();
$courseName = $_POST['courseName'];
$courseCode = $_POST['courseCode'];
if (array_key_exists('dept_id', $_POST)) {
    $deptID = $_POST['dept_id'];
    $result = $db->query("SELECT * FROM course WHERE dept_id=$deptID AND name='$courseName';");
    if ($result->rowCount() > 0) {
        $_SESSION['add-failed'] = true;
        $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Course Failed !</strong> Course with the given name already exists in the department.</div>";
    }
    if (!array_key_exists('add-failed', $_SESSION)) {
        $result = $db->query("SELECT * FROM course WHERE dept_id=$deptID AND code='$courseCode';");
        if ($result->rowCount() > 0) {
            $_SESSION['add-failed'] = true;
            $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Course Failed !</strong> Course with the given code already exists in the department.</div>";
        }
    }
} else {
    $collegeName = $_POST['collegeName'];
    $deptName = $_POST['deptName'];
    $result = $db->query("SELECT * FROM college WHERE  name='$collegeName';");
    if ($result->rowCount() == 0) {
        $_SESSION['add-failed'] = true;
        $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Course Failed !</strong> " .
            "We could not find the college with the name: $collegeName.</div>";
    } else {
        $result = $result->fetch();
        $collegeID = $result['id'];
        $result = $db->query("SELECT * FROM department WHERE college_id=$collegeID AND name='$deptName'");
        if ($result->rowCount() == 0) {
            $_SESSION['add-failed'] = true;
            $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Course Failed !</strong> " .
                "We could not find $deptName department in $collegeName.</div>";
        } else {
            $result = $result->fetch();
            $deptID = $result['id'];
        }
    }
}

if (!array_key_exists('add-failed', $_SESSION)) {
    $db->query("INSERT INTO course VALUES(DEFAULT, $deptID, '$courseCode', '$courseName');");
    header("Location:index.php"); //TODO: redirect to review page if user came to add-course from add review page
} else {
    $_SESSION['collegeName'] = $_POST['collegeName'];
    $_SESSION['deptName'] = $_POST['deptName'];
    $_SESSION['courseName'] = $_POST['courseName'];
    $_SESSION['courseCode'] = $_POST['courseCode'];
    if (array_key_exists('dept_id', $_POST)) {
        header("Location:add-course.php?deptID=$deptID");
    } else {
        header("Location:add-course.php");
    }
}