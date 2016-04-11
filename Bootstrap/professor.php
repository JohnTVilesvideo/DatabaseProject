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
    exit("Invalid url syntax. Please append ?id=x to the url, where x is the professor id");
}
$id = $_GET['id'];
$query = "SELECT * FROM professor WHERE id=$id;";
$result = $db->query($query);
if ($result->rowCount() == 0) {
    exit("Professor with the given id does not exist.");
}
$professor = $result->fetch();
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <style>
        h2 {
            font-weight: normal;
        }
    </style>

    <title><?php echo 'Rate my Professor | ' . $professor['name'] ?></title>
</head>
<body>

<!-- sidebar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="jumbotron">
        <h4><p align="left">Other Professors
                from <?php
                $query = "SELECT college.id AS col_id, college.name AS col_name, department.id AS dept_id, department.name AS dept_name" .
                    " FROM (professor JOIN department ON dept_id = department.id) JOIN college ON department.college_id = college.id" .
                    " WHERE professor.id = $id;";
                $result = $db->query($query);
                $professor_info = $result->fetch();
                printf("<a href='department.php?id=%s'>%s</a> Department", $professor_info['dept_id'], $professor_info['dept_name']); ?></p>
        </h4>
        <table class="table">
            <?php
            $deptID = $professor_info['dept_id'];
            $query = "SELECT * FROM professor WHERE dept_id=$deptID;";
            $result = $db->query($query);
            foreach ($result as $row) {
                $profID = $row['id'];
                if ($profID != $id) {
                    $profName = $row['name'];
                    printf("<tr><td><a href='professor.php?id=$profID'>$profName</a> </td></tr>");
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
        printf("<table align='center' cellspacing='0' cellpadding='4'>");
        printf("<tr><td><h2>%s</h2></td></tr>", $professor['name']);

        printf("<tr><td><h3><a href='college.php?id=%s'>%s</a> </h3></td></tr>", $professor_info['col_id'], $professor_info['col_name']);
        printf("<tr><td><h3><a href='department.php?id=%s'>%s</a> </h3></td></tr>", $professor_info['dept_id'], $professor_info['dept_name']);
        printf("<tr><td><form class='navbar-form' method='POST' action='professor-review.php'><input type='hidden' name='professor_id' value='$id'><button type='success'class='btn btn-success btn-lg'>Rate this Professor</button></form></a></td></tr>");
        printf("</table>");
        ?>
    </div>
    <br>
    <h3><p align="center">Reviews for <?php printf("%s", $professor['name']); ?></p></h3>
    <table class="table">
        <tr>
            <td><h4><b>Course</b></h4></td>
            <td><h4><b>Review</b></h4></td>
            <td><h4><b>Ratings</b></h4></td>
        </tr>
        <?php
        $query = "SELECT * FROM prof_review WHERE prof_id=$id";
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
            printf("</tr>");
        }
        ?>
    </table>
</div>

</body>
</html>
