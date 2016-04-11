<html>
<head>
    <?php
    /**
     * Author: Amrit
     * Date: 4/1/16
     * Time: 4:51 PM
     */

    include_once('db_connect.php');
    ?>
    <title>Search Result</title>
</head>
<body>

<?php
$isDepartment = array_key_exists('Department', $_POST);
if ($isDepartment) {
    $dept = $_POST['Department'];
    $college = $_POST['College'];
    $query = "SELECT * FROM college WHERE name LIKE '%$college%'";
    $result = $db->query($query);
    $collegeCount = $result->rowCount();
    $deptCount = 0;
    $headerSet = false;
    if($collegeCount != 0){
        foreach ($result as $col){
            $colID = $col['id'];
            $colName = $col['name'];
            $collegeAddress = $col['city'] . ", " . $col['state'];
            $query = "SELECT * FROM department WHERE college_id=$colID AND name LIKE '%$dept%';";
            $depts = $db->query($query);
            $deptCount += $depts->rowCount();
            if($depts->rowCount() != 0){
                if(!$headerSet){
                    $headerSet = true;
                    echo "<h2><p align='center'>Departments</p></h2>";
                    printf("<table  align='center' cellspacing='0' cellpadding='4'>");
                }
                foreach($depts as $dep){
                    $deptID = $dep['id'];
                    $deptName = $dep['name'];
                    $website = $dep['website'];
                    printf("<tr><td><h3><p><a href='department.php?id=$deptID'>$deptName</a></p></h3>".
                        "<h4><p><a href='college.php?id=$colID'>$colName</a></p>".
                        "<p>$collegeAddress</p></h4></td></tr>");
                }
            }
        }
    }
    if($deptCount == 0){
        echo "<h3><p align='center'>Sorry, Your search didn't return any results.</p></h3>";
    }
    else{
        printf("</table>");
    }

}
else{
    $searchQuery = $_POST['query'];
    $query = "SELECT * FROM professor WHERE name LIKE '%$searchQuery%';";
    $result = $db->query($query);
    $profCount = $result->rowCount();
    if($profCount != 0){
        printf("<h2><p align='center'>Professors</p></h2> <br>");
		echo "<h3 style='text-align:center'>Can't find your professor? <a href='add_prof.php'>Add your own</a></h3>";
        printf("<table  align='center' cellspacing='0' cellpadding='4'>");
        foreach ($result as $row){
            $profName = $row['name'];
            $profId = $row['id'];
            $deptId = $row['dept_id'];
            $query = "SELECT department.name AS deptName, college.name AS colName, college.id AS colID".
                " FROM department JOIN college ON department.id=$deptId AND college_id=college.id;";
            $deptCol = $db->query($query);
            $deptCol = $deptCol->fetch();
            printf("<tr><td><h3><p><a href='professor.php?id=$profId'>$profName</a></p></h3>".
                "<h4><p><a href='department.php?id=$deptId'>%s Department</a></p>".
                "<p><a href='college.php?id=%d'>%s</a></p></h4></td>".
                "<td><form method='POST' action='professor_review.php'>
                 <input type='hidden' name='prof_id' value='$profId'>
                 <input type='submit' value='Rate this Professor'>
                </form> </td></tr>", $deptCol['deptName'], $deptCol['colID'], $deptCol['colName']);
        }
        printf("</table>");
    }
    $query = "SELECT * FROM college WHERE name LIKE '%$searchQuery%';";
    $result = $db->query($query);
    $colCount = $result->rowCount();
    if($colCount != 0){
        printf("<h2><p align='center'>Colleges</p></h2> <br>");
        printf("<table  align='center' cellspacing='0' cellpadding='4'>");
        foreach ($result as $row){
            $colName = $row['name'];
            $colId = $row['id'];
            $city = $row['city'];
            $state = $row['state'];
            $website = $row['website'];
            if (!(substr( $website, 0, 4 ) == "http")){
                $website = "http://" . $website;
            }
            echo "<tr><td><h3><a href='college.php?id=$colId'>$colName</a></h3><h4><p>$city, $state</p> <p><a href='$website'>$website</a></p></h4></td></tr>";
        }
        printf("</table>");
    }
    if($profCount + $colCount == 0){
        echo "<h3><p align='center'>Sorry, Your search didn't return any results.</p></h3>";
		echo "<h3 style='text-align:center'><a href='add_prof.php'>Add a new professor</a></h3>";
    }
}

?>
</body>

</html>
