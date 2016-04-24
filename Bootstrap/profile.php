<html lang="en">
<head>
    <?php
    /**
     * User: Amrit Dhakal
     * Date: 3/20/16
     * Time: 3:16 PM
     */
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect'] = $_SERVER['HTTP_REFERER'];
        //TODO:Some sort of message in login page telling them that they need to log in
        header('Location:login.php');
    }
    ?>
</head>
<body>
<?php
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id=$user_id;";
$result = $db->query($query);
$user = $result->fetch();
$editFailed = array_key_exists('edit-failed', $_SESSION);
if (array_key_exists('edit', $_POST) || $editFailed) {
    if ($editFailed) {
        unset($_SESSION['edit-failed']);
        printf($_SESSION['error-message']);
        unset($_SESSION['error-message']);
    }
    printf("<h1><p align='center'>Profile</p></h1>");
    printf("<form class='form' method='post' action='edit-profile.php'>");
    printf("<table class='table'>");
    printf("<tr><td><h3>First Name:</h3></td><td><h3><input type='text' placeholder='First name' name='fname' value='%s' required></h3></td></tr>", $user['fname']);
    printf("<tr><td><h3>Last Name:</h3></td><td><h3><input type='text' placeholder='Last name' name='lname' value='%s' required></h3></td></tr>", $user['lname']);
    printf("<tr><td><h3>Username:</h3></td><td><h3><input type='text' placeholder='Username' name='username' value='%s' required></h3></td></tr>", $user['username']);
    printf("<tr><td><h3>Email:</h3></td><td><h3><input type='email' placeholder='Email' name='email' value='%s' required></h3></td></tr>", $user['email']);
    printf("<tr><td><h3>Password:</h3></td><td><h3><input type='password' name='password' placeholder='Leave blank if unchanged'></h3></td></tr>");
    printf("<tr><td><h3>Password:</h3></td><td><h3><input type='password' name='confirm_password' placeholder='Leave blank if unchanged'></h3></td></tr>");
    printf("<tr><td></td><td>");
    printf("<div class='btn-group'>");
    printf("<input type='submit' class='btn btn-success' name='submit_button' value='Save'>");
    printf("<input type='submit' class='btn btn-danger' name='submit_button' style='margin-left: 5px;' value='Cancel'></td></tr>");
    printf("</table>");
    printf("</form>");
    exit(0);
}
if (array_key_exists('edit-success', $_SESSION)) {
    unset($_SESSION['edit-success']);
    printf("<div class='alert alert-success'> <strong>Your Profile update was successful !</strong></div>");
}
printf("<h1><p align='center'>Profile</p></h1>");
printf("<table class='table'>");
printf("<tr><td><h3>Name:</h3></td><td><h3>%s %s</h3></td></tr>", $user['fname'], $user['lname']);
printf("<tr><td><h3 >Username:</h3></td><td><h3>%s</h3></td></tr>", $user['username']);
printf("<tr><td><h3>Email:</h3></td><td><h3>%s</h3></td></tr>", $user['email']);
printf("<tr><td><h3>Password:</h3></td><td><h3>**********</h3></td></tr>");
printf("<tr><td></td><td><form method='post' action='profile.php'><input type='hidden' name='edit' value='true'>" .
    "<input type='submit' class='btn btn-default' value='Edit Profile'></form></td></tr>");
printf("</table>");
?>

<h2><p align="center">Course Reviews</p></h2>
<table class="table">
    <tr>
        <th>Details</th>
        <th>Reviews</th>
        <th>Ratings</th>
        <th>Operations</th>
    </tr>
    <?php
    $query = "Select * from course_review WHERE user_id=$user_id";
    $result = $db->query($query);
    foreach ($result as $row) {
        $prof_id = $row['prof_id'];
        $query = "SELECT name FROM professor WHERE id=$prof_id;";
        $prof = $db->query($query)->fetch();
        $book_required = "";
        if ($row['textbook_required'] == null) {
            $book_required = "N/A";
        } elseif ($row['textbook_required'] == 0) {
            $book_required = "No";
        } else {
            $book_required = "Yes";
        }
        printf("<tr>");
        printf("<td><p><b>Instructor:</b> <a href='professor.php?id=%s'>%s</a></p><p><b>Textbook Required:</b> %s</p></td>",
            $prof_id, $prof['name'], $book_required);
        printf("<td><p><b>Review:</b> %s</p> <p><b>Usefulness:</b> %s</p> <p><b>Tips:</b> %s</p></td>", $row['review'], $row['usefulness'], $row['tips']);
        printf("<td><p><b>Easiness:</b> %s</p> <p><b>Overall Rating:</b> %s</p>", $row['easiness'], $row['overall_rating']);
        printf("<td><a href='%s'>Edit</a>  <a href='%s' >Delete</a> </td>", '#', '#');
        printf("</tr>");
    }
    ?>
</table>

<h2><p align="center">Professor Reviews</p></h2>
<table class="table">
    <tr>
        <th>Details</th>
        <th>Reviews</th>
        <th>Ratings</th>
        <th>Operations</th>
    </tr>
    <?php
    $query = "SELECT * FROM prof_review WHERE user_id=$user_id";
    $result = $db->query($query);
    foreach ($result as $row) {
        $course_id = $row['course_id'];
        $query = "SELECT name FROM course WHERE id=$course_id;";
        $course = $db->query($query)->fetch();
        printf("<tr>");
        printf("<td><a href='course.php?id=%s'>%s</a></td>", $course_id, $course['name']);
        printf("<td>%s</td>", $row['review']);
        printf("<td><p><b>Helpfulness:</b> %s</p><p><b>Easiness:</b> %s</p><p><b>Clarity:</b> %s</p> <p><b>Overall Rating:</b> %s</p>",
            $row['helpfulness'], $row['easiness'], $row['clarity'], $row['overall_rating']);
        printf("<td><a href='%s'>Edit</a>  <a href='%s' >Delete</a> </td>", '#', '#');
        printf("</tr>");
    }
    ?>
</table>
</body>

</html>