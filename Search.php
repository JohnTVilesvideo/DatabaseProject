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
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/dataTables.scrollingPagination.js"></script>

    <title>Search Result</title>
</head>
<body style="background: url('img/pattern.png');">

<?php
$isDepartment = array_key_exists('Department', $_POST);
$isCourse = array_key_exists('Course', $_POST);
$count = 0;
if ($isCourse) {
    $count = search($db, "course");
} else if ($isDepartment) {
    $count = search($db, "department");
} else {
    if (!(array_key_exists('collegeOnly', $_POST))) {
        $count += search($db, "professor");
    }
    if (!(array_key_exists('professorOnly', $_POST))) {
        $count += search($db, "college");
    }
}
if ($count <= 0) {
    echo "<h3><p align='center'>Sorry, Your search didn't return any results.</p></h3>";
}

function search($db, $target) {
    $query = "SELECT * FROM $target WHERE name LIKE ?;";
    $param = null;
    if ($target == "course") {
        $course = $_POST['Course'];
        $college = $_POST['College'];
        $query = "SELECT course.id AS id, course.name AS name, department.id AS dept_id, department.name AS deptName, " .
            "college.id AS collegeID, college.name AS collegeName" .
            " FROM (course JOIN department ON course.dept_id=department.id) JOIN college ON college_id=college.id" .
            " WHERE (course.name LIKE ? OR course.code LIKE ?) AND college.name LIKE ?;";
        $param = array("%$course%", "%$course", "%$college%");
    }
    else {
        $searchQuery = null;
        if ($target == "department") {
            $query = "SELECT * FROM college WHERE name LIKE ?;";
            $searchQuery = $_POST['College'];
            $param = array("%$searchQuery%");
        }
        else { // professor and college
            if (array_key_exists('state', $_POST)) {
                $searchQuery = $_POST['state'];
                $query = "SELECT * FROM college WHERE state=?;";
                $param = array($searchQuery);
            }
            else {
                $searchQuery = $_POST['query'];
                $param = array("%$searchQuery%");
            }
        }
    }
    $result = $db->prepare($query);
    $result->execute($param);
    $rowCount = $result->rowCount();
    $deptCount = 0;
    if ($rowCount > 0) {
        echo "<h2 align='center' style='color: dodgerblue;'>" . strtoupper($target) . "</h2><br>\n";
        echo "<table id='search' class='table-striped table-bordered' align='center' width='80%' cellspacing='0'>\n";

        foreach ($result as $row) {
            $name = $row['name'];
            $id = $row['id'];
            $deptCol = $row;
            $deptName = null; $collegeID = null; $collegeName = null; $city = null; $state = null; $website = null;
            if ($target == "professor") {
                $deptCol = $db->prepare("SELECT department.name AS deptName, college.name AS collegeName, college.id AS collegeID" .
                    " FROM department JOIN college ON department.id=? AND college_id=college.id;");
                $deptCol->execute(array($row['dept_id']));
                $deptCol = $deptCol->fetch();
            }
            if ($target == "course" || $target == "professor") {
                $deptName = $deptCol['deptName'];
                $collegeID = $deptCol['collegeID'];
                $collegeName = $deptCol['collegeName'];
            }
            else {
                $city = $row['city'];
                $state = $row['state'];
                $website = $row['website'];
                if (!(substr($website, 0, 4) == "http")) {
                    $website = "http://" . $website;
                }
                $collegeAddress = $city . ", " . $state;
            }

            if ($target == "department") {
                $dept = $_POST['Department'];
                $depts = $db->prepare("SELECT * FROM department WHERE college_id=? AND name LIKE ?;");
                $depts->execute(array($id, "%$dept%"));
                $deptCount += $depts->rowCount();
                if ($depts->rowCount() != 0) {
                    foreach ($depts as $dep) {
                        printf("\t<tr>\n");
                        printf("\t\t<td><b><h3><a href='department.php?id=%s'>%s</a></h3></b>" .
                            "<h4><p><a href='college.php?id=$id'>$name</a></p>" .
                            "<p>$collegeAddress</p></h4></td>\n", $dep['id'], $dep['name']);
                        printf("\t</tr>\n");
                    }
                }
                $rowCount = $deptCount;
            }
            else {
                printf("\t<tr>\n");
                printf("\t\t<td><b><h3><a href='$target.php?id=$id'>$name</a></h3></b>");
                if ($target == "college") {
                    printf("<h4><p>$city, $state</p> <p><a href='$website'>$website</a></p></h4></td>\n");
                } else {
                    printf("<h4><p><a href='department.php?id=%s'>$deptName</a></p>", $row['dept_id']);
                    printf("<p><a href='college.php?id=$collegeID'>$collegeName</a></p></h4></td>\n");
                    printf("\t\t<td><form class='navbar-form' method='POST' action='$target-review.php'><input type='hidden' name='$target" . "_id' value='$id'>" .
                        "<button type='success' class='btn btn-primary btn-md'>Rate this " . strtoupper(substr($target,0,1)).substr($target,1));
                    printf("</button></form></td>\n");
                }
                printf("\t</tr>\n");
            }
        }
        printf("</table>\n");
    }
    return $rowCount;
}
?>
</body>
</html>
