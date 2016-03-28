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
printf("<h1><p align='center'>Profile</p></h1>");
printf("<table align='center' cellspacing='0' cellpadding='4'>");
printf("<tr><td><h3 style='text-align: right'>Name:</h3></td><td><h3>%s %s</h3></td></tr>", $user['fname'], $user['lname']);
printf("<tr><td><h3 style='text-align: right'>Username:</h3></td><td><h3>%s</h3></td></tr>", $user['username']);
printf("<tr><td><h3 style='text-align: right'>Email:</h3></td><td><h3>%s</h3></td><td><h3><a href='#'>Edit</a> </h3></td></tr>", $user['email']);
printf("<tr><td><h3 style='text-align: right'>Password:</h3></td><td><h3>**********</h3></td><td><h3><a href='#'>Change</a> </h3></td></tr>");
printf("</table>");
?>

<table align="center" cellspacing="0" cellpadding="4" border="1">
    <tr>
        <td><h2><b>Course</b></h2></td>
        <td><h2><b>Professor</b></h2></td>
        <td><h2><b>Course Review</b></h2></td>
        <td><h2><b>Course Rating</b></h2></td>
        <td><h2><b>Professor Review</b></h2></td>
        <td><h2><b>Professor Rating</b></h2></td>
    </tr>
    <?php
    $query = "SELECT * ".
             "FROM (review JOIN course_review ON course_review_id = course_review.id) JOIN prof_review ON prof_review_id =  prof_review.id WHERE reviewer_id = $user_id;";
    $result = $db->query($query);
    ?>
</table>
