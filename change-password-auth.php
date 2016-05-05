<?php
/**
 * change-password-auth.php
 * Script to authenticate resetting the password.
 * Appropriate errors will be produced in case the password
 * and the confirm password do not match.
 */
include_once('db_connect.php');
session_start();
if ($_POST['password'] != $_POST['confirm_password']) {
    $_SESSION['password_mismatch'] = true;
    header("Location:password-reset.php?auth=" . $_POST['auth']);
    exit(0);
}
$find_user = $db->prepare("SELECT * FROM password_reset_auth WHERE auth=?;");
$find_user->execute(array($_POST['auth']));
$find_user = $find_user->fetch();
$userID = $find_user['user_id'];
$change_pass = $db->prepare("UPDATE user SET password=? WHERE id=?;");
$change_pass->execute(array(md5($_POST['password']), $userID));
$_SESSION['pass_change_success'] = true;
$remove_auth = $db->prepare("DELETE FROM password_reset_auth WHERE auth=?;");
$remove_auth->execute(array($_POST['auth']));
header("Location:login.php");
