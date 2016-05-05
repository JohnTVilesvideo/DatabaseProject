<?php
/**
 * add-course-auth.php
 * Script to authenticate addition of new course into the database.
 * In case the department and the college were entered by user themselves (not auto filled by us),
 * checks are done to make sure that the college exists and the department exists in the given college.
 * Appropriate errors are produced when the college or department does not exist or the course already exists
 * in the given department.
 */
include_once('db_connect.php');
session_start();
$courseName = $_POST['courseName'];
$courseCode = $_POST['courseCode'];
$redirect = $_POST['location'] . '?id=' . $_POST['append'];

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
    header("Location:$redirect");
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