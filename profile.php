<?php
/**
 * User: Amrit Dhakal
 * Date: 3/20/16
 * Time: 3:16 PM
 */

include_once("db_connect.php");

session_start();
if(!array_key_exists('user_id', $_SESSION)){
    include("login.html");
    exit(0);
}
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id=$user_id;";
$result = $db->query($query);
$user = $result->fetch();
printf("<h1><p align='center'>%s %s's Profile</p></h1>", $user['fname'], $user['lname']);
printf("<table align='center' cellspacing='0' cellpadding='4'>");
printf("</table>");


?>