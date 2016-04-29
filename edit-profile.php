<?php
/**
 * Author: Amrit
 * Date: 4/24/16
 * Time: 2:48 AM
 */

include_once('db_connect.php');
session_start();
if (!array_key_exists('user_id', $_SESSION)) {
    header("Location:index.php");
}
$id = $_SESSION['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
if ($password != $confirm_password) {
    $_SESSION['edit-failed'] = true;
    $_SESSION['error-message'] = "<div class='alert alert-danger'> <strong>Edit Profile Failed !</strong>Your password and confirmation password do not match.</div>";
    header("Location:profile.php");
}
$keepPassword = $password == '';
$query = "UPDATE user SET username=?, ";
if (!$keepPassword) {
    $password = md5($password);
    $query = $query . "password=?, ";
}
$query = $query . "fname=?, lname=?, email=? WHERE id=?;";
$query = $db->prepare($query);
if (!$keepPassword) {
    $query->execute(array($username, $password, $fname, $lname, $email, $id));
}
else{
    $query->execute(array($username, $fname, $lname, $email, $id));
}
$_SESSION['edit-success'] = true;
$_SESSION['users_name'] = $_POST['fname'] . " " . $_POST['lname'];
header("Location:profile.php");
