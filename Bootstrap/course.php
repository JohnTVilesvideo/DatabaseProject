<?php
/**
 * Author: Amrit
 * Date: 3/12/16
 * Time: 3:18 PM
 */
include_once('db_connect.php');
include_once('links.html');
include('nav.php');
if (!array_key_exists('id', $_GET)) {
    exit("Invalid url syntax. Please append ?id=x to the url, where x is the course id");
}
$id = $_GET['id'];
$query = "SELECT * FROM course WHERE id=$id;";
$result = $db->query($query);
if ($result->rowCount() == 0) {
    exit("Course with the given id does not exist.");
}
$course = $result->fetch();
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <title><?php echo 'Rate my Professor | ' . $course['name'] ?></title>
</head>
<body style="background: url('img/pattern.png');">

<!-- sidebar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="jumbotron">
        <h4><p align="left">Other Courses
                from <?php
                $query = "SELECT college.id AS col_id, college.name AS col_name, department.id AS dept_id, department.name AS dept_name" .
                    " FROM (course JOIN department ON dept_id = department.id) JOIN college ON college_id = college.id" .
                    " WHERE course.id = $id;";
                $result = $db->query($query);
                $course_info = $result->fetch();
                printf("<a href='department.php?id=%s'>%s</a> Department", $course_info['dept_id'], $course_info['dept_name']); ?></p>
        </h4>
        <table class="table">
            <?php
            $deptID = $course_info['dept_id'];
            $query = "SELECT * FROM course WHERE dept_id=$deptID;";
            $result = $db->query($query);
            foreach ($result as $row) {
                $courseID = $row['id'];
                if ($courseID != $id) {
                    $courseName = $row['name'];
                    printf("<tr><td><a href='course.php?id=$courseID'>$courseName</a> </td></tr>");
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- main area -->
<div class="col-xs-12 col-sm-9">
    <div class="container">
        <?php
        if (array_key_exists('review_added', $_SESSION)) {
            unset($_SESSION['review_added']);
            printf("<div class='alert alert-success'> <strong>Review Added successfully!</strong> Thank you.<br></div>");
        }
        if (array_key_exists('reported', $_SESSION)) {
            unset($_SESSION['reported']);
            printf("<div class='alert alert-success'> <strong>Review successfully reported !</strong>Our moderators will take appropriate action. Thank you.<br></div>");
        }
        printf("<table align='center'>");
        printf("<tr><td><h2>%s (%s)</h2></td></tr>", $course['name'], $course['code']);
        $query = "SELECT college.id AS col_id, college.name AS col_name, department.id AS dept_id, department.name AS dept_name" .
            " FROM (course JOIN department ON dept_id = department.id) JOIN college ON college_id = college.id" .
            " WHERE course.id = $id;";
        $result = $db->query($query);
        $course_info = $result->fetch();

        printf("<tr><td><h3><a href='college.php?id=%s'>%s</a> </h3></td></tr>", $course_info['col_id'], $course_info['col_name']);
        printf("<tr><td><h3><a href='department.php?id=%s'>%s</a> </h3></td></tr>", $course_info['dept_id'], $course_info['dept_name']);
        printf("<tr><td><form class='navbar-form' method='POST' action='course-review.php'><input type='hidden' name='course_id' value='$id'><button type='success'class='btn btn-success btn-lg'>Rate this Course</button></form></a></td></tr>");
        printf("</table>");
        ?>
    </div>
    <h2><p align="center">Reviews for <?php printf("%s", $course['name']); ?></p></h2>
    <table class="table">
        <tr>
            <td><h2><b>Details</b></h2></td>
            <td><h2><b>Reviews</b></h2></td>
            <td><h2><b>Ratings</b></h2></td>
        </tr>
        <?php
        $query = "Select * from course_review WHERE course_id=$id";
        $result = $db->query($query);
        foreach ($result as $row) {
            $prof_id = $row['prof_id'];
            $user_id = $row['user_id'];
            $course_id = $row['course_id'];
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
            printf("<td><p><b>Easiness:</b> %s</p> <p><b>Overall Rating:</b> %s</p><p><form method='post' action='report-review.php'>" .
                "<span class='glyphicon glyphicon-exclamation-sign'></span>" .
                "<input type='hidden' name='review_type' value='1'>" .
                "<input type='hidden' name='user_id' value='$user_id'>" .
                "<input type='hidden' name='course_id' value='$course_id'>" .
                "<input type='hidden' name='prof_id' value='$prof_id'>" .
                "<input type='submit' class='btn btn-link' value='report'></form></p></td>", $row['easiness'], $row['overall_rating']);
            printf("</tr>");
        }
        ?>
    </table>
</div>
</body>
</html>
