<?php
/**
 * add-professor-auth.php
 * Authorizing inserting new professor to the database
 * Handling insertion errors when professor already exists in the database
 * or when department or college is not found
 * Author: Amrit, Dung
 */
include_once('db_connect.php');
session_start();
$professorName = $_POST['professorName'];
$redirect = $_POST['location'] . '?id=' . $_POST['append'];
if (array_key_exists('dept_id', $_POST)) {
    $deptID = $_POST['dept_id'];
    $result = $db->query("SELECT * FROM professor WHERE dept_id=$deptID AND name='$professorName';");
    if ($result->rowCount() > 0) {
        $_SESSION['add-failed'] = true;
        $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Professor Failed !</strong> Professor with the given name already exists in the department.</div>";
    }
} else {
    $collegeName = $_POST['collegeName'];
    $deptName = $_POST['deptName'];
    $result = $db->query("SELECT * FROM college WHERE  name='$collegeName';");
    if ($result->rowCount() == 0) {
        $_SESSION['add-failed'] = true;
        $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Professor Failed !</strong> " .
            "We could not find the college with the name: $collegeName.</div>";
    } else {
        $result = $result->fetch();
        $collegeID = $result['id'];
        $result = $db->query("SELECT * FROM department WHERE college_id=$collegeID AND name='$deptName'");
        if ($result->rowCount() == 0) {
            $_SESSION['add-failed'] = true;
            $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Professor Failed !</strong> " .
                "We could not find $deptName department in $collegeName.</div>";
        } else {
            $result = $result->fetch();
            $deptID = $result['id'];
            $result = $db->query("SELECT * FROM professor WHERE dept_id=$deptID AND name='$professorName';");
            if ($result->rowCount() > 0) {
                $_SESSION['add-failed'] = true;
                $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Add Professor Failed !</strong> Professor with the given name already exists in the department.</div>";
            }
        }
    }
}

if (!array_key_exists('add-failed', $_SESSION)) {
    $db->query("INSERT INTO professor VALUES(DEFAULT, '$professorName', $deptID);");
    header("Location:$redirect"); 
} else {
    $_SESSION['collegeName'] = $_POST['collegeName'];
    $_SESSION['deptName'] = $_POST['deptName'];
    $_SESSION['professorName'] = $_POST['professorName'];
    if (array_key_exists('dept_id', $_POST)) {
        header("Location:add-professor.php?deptID=$deptID");
    } else {
        header("Location:add-professor.php");
    }
}