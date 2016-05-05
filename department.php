
<html>
<head>
    <?php
    /**
     * department.php
     * Department profile page.
     * Display department information as well as list of the courses and professors
     * in the department along with their average rating.
     * Sidebar displays the list of other departments from the same college.
     */
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');
    if (!array_key_exists('id', $_GET)) {
        exit("Invalid url syntax. Please append ?id=x to the url, where x is the department id");
    }
    $id = $_GET['id'];
    $result = $db->prepare("SELECT * FROM department WHERE id=?;");
    $result->execute(array($id));
    if ($result->rowCount() == 0) {
        exit("Department with the given id does not exist.");
    }
    $department = $result->fetch();
    ?>

    <title><?php echo 'Rate my Professor | ' . $department['name'] . ' (' . $department['code'] . ')' ?></title>
</head>
<body style="background: url('img/pattern.png');">
<!-- sidebar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation" style="background: lightgray;">
        <h4><p align="left">Other departments
                from <?php
                $result = $db->prepare("SELECT *  FROM college WHERE id = ?;");
                $result->execute(array($department['college_id']));
                $college = $result->fetch();
                printf("<a href='college.php?id=%s'>%s</a> Department", $department['college_id'], $college['name']);
                ?></p>
        </h4>
        <table class="table">
            <?php
            $collegeID = $department['college_id'];
            $result = $db->prepare("SELECT * FROM department WHERE college_id=?;");
            $result->execute(array($collegeID));
            foreach ($result as $row) {
                $deptID = $row['id'];
                if($id != $deptID){
                    $deptName = $row['name'];
                    printf("\t\t\t<tr><td><a href='department.php?id=$deptID'>$deptName</a> </td></tr>\n");
                }
            }
            ?>
        </table>
</div>
<!-- main area -->
<div class="col-xs-12 col-sm-9">
<div class="container">
    <?php
    printf("<table align='center' cellspacing='0' cellpadding='4'>\n");
    printf("\t\t<tr><td><h2>%s (%s)</h2></td></tr>\n", $department['name'], $department['code']);
    printf("\t\t<tr><td><h3><a href='college.php?id=%s'>%s</a> </h3></td></tr>\n", $department['college_id'], $college['name']);
    printf("\t\t<tr><td><h3>%s, %s</h3></td></tr>\n", $college['city'], $college['state']);
    $website = $department['website'];
    if (!(substr($website, 0, 4) == "http")) {
        $website = "http://" . $website;
    }
    printf("\t\t<tr><td><h3> Department Website : <a href='%s'>%s</a></h3></td></tr>\n", $website, $website);
    printf("\t</table>");
    ?>
</div>

    <table class="table"> <!-- Courses table -->
        <tr>
            <td><h3><b>Courses</b></h3></td>
            <td><h3><b>Average Rating</b></h3></td>
        </tr>

        <?php
        $result = $db->prepare("SELECT * FROM course WHERE dept_id = ?;");
        $result->execute(array($id));
        foreach ($result as $row) {
            $course_id = $row['id'];
            $result = $db->prepare("SELECT AVG(overall_rating) AS avgRating FROM course_review WHERE course_id=?;");
            $result->execute(array($course_id));
            $result = $result->fetch();
            $avgRating = $result['avgRating'];
            if ($avgRating == 0) {
                $avgRating = 'N/A';
            } else {
                $avgRating = sprintf("%.1f", $avgRating);
            }
            printf("\t\t<tr><td><a href='course.php?id=%s'>%s</a></td> <td>%s</td></tr>\n", $row['id'], $row['name'], $avgRating);
        }
        ?>

    </table>

    <br>

    <table class="table"> <!-- Instructor table -->
        <tr>
            <td><h3><b>Professors</b></h3></td>
            <td><h3><b>Average Rating</b></h3></td>
        </tr>

        <?php
        $result = $db->prepare("SELECT * FROM professor WHERE dept_id = ?;");
        $result->execute(array($id));
        foreach ($result as $row) {
            $prof_id = $row['id'];
            $query = $db->prepare("SELECT AVG(overall_rating) AS avgRating FROM prof_review WHERE prof_id=?;");
            $query->execute(array($prof_id));
            $result = $query->fetch();
            $avgRating = $result['avgRating'];
            if ($avgRating == 0) {
                $avgRating = 'N/A';
            } else {
                $avgRating = sprintf("%.1f", $avgRating);
            }
            printf("\t\t<tr><td><a href='professor.php?id=%s'>%s</a></td> <td>%s</td></tr>\n", $row['id'], $row['name'], $avgRating);
        }
        ?>

    </table>
</div>
</body>
</html>
