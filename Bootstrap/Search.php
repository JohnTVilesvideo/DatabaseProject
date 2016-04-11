<html>
<head>
    <?php
    /**
     * Author: Amrit
     * Date: 4/1/16
     * Time: 4:51 PM
     */
    include_once('db_connect.php');
    include_once('links.html');
    include_once('nav.php');
    ?>
    <title>Search Result</title>
</head>
<body>

<?php
$isDepartment = array_key_exists('Department', $_POST);
$isCourse = array_key_exists('Course', $_POST);
if ($isCourse) {
    $course = $_POST['Course'];
    $college = $_POST['College'];
    $query = "SELECT course.id AS courseID, course.name AS courseName, department.id AS deptID, department.name AS deptName, " .
        "college.id AS collegeID, college.name AS collegeName" .
        " FROM (course JOIN department ON course.dept_id=department.id) JOIN college ON college_id=college.id" .
        " WHERE (course.name LIKE '%$course%' OR course.code LIKE '%$course%') AND college.name LIKE '%$college%';";
    $result = $db->query($query);
    $courseCount = $result->rowCount();
    if ($courseCount > 0) {
        echo "<h2><p align='center'>Courses</p></h2>";
        printf("<table  align='center' cellspacing='0' cellpadding='4'>");
    }
    foreach ($result as $row) {
        $courseID = $row['courseID'];
        $courseName = $row['courseName'];
        $deptID = $row['deptID'];
        $deptName = $row['deptName'];
        $collegeID = $row['collegeID'];
        $collegeName = $row['collegeName'];
        printf("<tr><td><h3><p><a href='course.php?id=$courseID'>$courseName</a></p></h3><h4><p><a href='department.php?id=$deptID'>$deptName</a>" .
            "</p><p><a href='college.php?id=$collegeID'>$collegeName</a> </p></h4></td><td><form class='navbar-form' method='POST' action='course_review.php'>" .
            "<input type='hidden' name='course_id' value='$courseID'><button type='success'class='btn btn-primary btn-md'>Rate this Course</button></form></td></tr>");
    }
    if ($courseCount > 0) {
        echo "</table>";
    } else {
        echo "<h3><p align='center'>Sorry, Your search didn't return any results.</p></h3>";
    }
} else if ($isDepartment) {
    $dept = $_POST['Department'];
    $college = $_POST['College'];
    $query = "SELECT * FROM college WHERE name LIKE '%$college%'";
    $result = $db->query($query);
    $collegeCount = $result->rowCount();
    $deptCount = 0;
    $headerSet = false;
    if ($collegeCount != 0) {
        foreach ($result as $col) {
            $colID = $col['id'];
            $colName = $col['name'];
            $collegeAddress = $col['city'] . ", " . $col['state'];
            $query = "SELECT * FROM department WHERE college_id=$colID AND name LIKE '%$dept%';";
            $depts = $db->query($query);
            $deptCount += $depts->rowCount();
            if ($depts->rowCount() != 0) {
                if (!$headerSet) {
                    $headerSet = true;
                    echo "<h2><p align='center'>Departments</p></h2>";
                    printf("<table  align='center' cellspacing='0' cellpadding='4'>");
                }
                foreach ($depts as $dep) {
                    $deptID = $dep['id'];
                    $deptName = $dep['name'];
                    $website = $dep['website'];
                    printf("<tr><td><h3><p><a href='department.php?id=$deptID'>$deptName</a></p></h3>" .
                        "<h4><p><a href='college.php?id=$colID'>$colName</a></p>" .
                        "<p>$collegeAddress</p></h4></td></tr>");
                }
            }
        }
    }
    if ($deptCount == 0) {
        echo "<h3><p align='center'>Sorry, Your search didn't return any results.</p></h3>";
    } else {
        printf("</table>");
    }

} else {
    $profCount = 0;
    if (!(array_key_exists('collegeOnly', $_POST))) {
        $searchQuery = $_POST['query'];
        $query = "SELECT * FROM professor WHERE name LIKE '%$searchQuery%';";
        $result = $db->query($query);
        $profCount = $result->rowCount();
        if ($profCount != 0) {
            printf("<h2><p align='center'>Professors</p></h2> <br>");
            printf("<table  class='table'");
            foreach ($result as $row) {
                $profName = $row['name'];
                $profId = $row['id'];
                $deptId = $row['dept_id'];
                $query = "SELECT department.name AS deptName, college.name AS colName, college.id AS colID" .
                    " FROM department JOIN college ON department.id=$deptId AND college_id=college.id;";
                $deptCol = $db->query($query);
                $deptCol = $deptCol->fetch();
                printf("<tr><td><h3><p><a href='professor.php?id=$profId'>$profName</a></p></h3>" .
                    "<h4><p><a href='department.php?id=$deptId'>%s Department</a></p>" .
                    "<p><a href='college.php?id=%d'>%s</a></p></h4></td>" .
                    "<td><form class='navbar-form' method='POST' action='professor-review.php'><input type='hidden' name='professor_id' value='$profId'>" .
                    "<button type='success'class='btn btn-primary btn-md'>Rate this Professor</button></form></td></tr>", $deptCol['deptName'], $deptCol['colID'], $deptCol['colName']);
            }
            printf("</table>");
        }
    }
    $colCount = 0;
    if (!(array_key_exists('professorOnly', $_POST))) {
        if (array_key_exists('state', $_POST)) {
            $searchQuery = $_POST['state'];
            $query = "SELECT * FROM college WHERE state='$searchQuery';";
        } else {
            $searchQuery = $_POST['query'];
            $query = "SELECT * FROM college WHERE name LIKE '%$searchQuery%';";
        }
        $result = $db->query($query);
        $colCount = $result->rowCount();
        if ($colCount != 0) {
            printf("<h2><p align='center'>Colleges</p></h2> <br>");
            printf("<table  class='table'>");
            foreach ($result as $row) {
                $colName = $row['name'];
                $colId = $row['id'];
                $city = $row['city'];
                $state = $row['state'];
                $website = $row['website'];
                if (!(substr($website, 0, 4) == "http")) {
                    $website = "http://" . $website;
                }
                echo "<tr><td><h3><a href='college.php?id=$colId'>$colName</a></h3><h4><p>$city, $state</p> <p><a href='$website'>$website</a></p></h4></td></tr>";
            }
            printf("</table>");
        }
    }
    if ($profCount + $colCount == 0) {
        echo "<h3><p align='center'>Sorry, Your search didn't return any results.</p></h3>";
    }
}

?>
</body>

</html>
