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
$query = "UPDATE user SET username='$username', ";
if (!$keepPassword) {
    $password = md5($password);
    $query = $query . "password='$password', ";
}
$query = $query . "fname='$fname', lname='$lname', email='$email' WHERE id=$id;";
$db->query($query);
$_SESSION['edit-success'] = true;
header("Location:profile.php");
