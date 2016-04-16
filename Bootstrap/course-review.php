<html>
<head>
    <?php

    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect'] = $_SERVER['HTTP_REFERER'];
        //TODO:Some sort of message in login page telling them that they need to log in
        header('Location:login.php');
    }
    $id = $_POST['course_id'];
    $query = "SELECT course.name AS courseName, course.dept_id AS deptID, department.name AS deptName, college.name AS collegeName, college.id AS collegeID FROM (course JOIN department ON course.dept_id=department.id) JOIN college ON department.college_id=college.id WHERE course.id=$id;";
    $result = $db->query($query);
    $result = $result->fetch();
    $courseName = $result['courseName'];
    $deptID = $result['deptID'];
    $deptName = $result['deptName'];
    $collegeName = $result['collegeName'];
    $collegeID = $result['collegeID'];
    ?>
    <link rel="stylesheet" href="css/star-rating.css">
    <script src="js/star-rating.js"></script>

    <link rel="stylesheet" href="css/bootstrap-toggle.css">
    <script src="js/bootstrap-toggle.js"></script>

    <title>
        <?php
        printf("Add a review for %s course of %s Department, %s ", $courseName, $deptName, $collegeName);
        ?>
    </title>

<body>
<div class="container">
    <?php
    printf("<h3 style='text-align: center'>Add a review for<br> <a href='course.php?id=$id'>$courseName</a><br>" .
        "<a href='department.php?id=$deptID'>$deptName</a>, <a href='college.php?id=$collegeID'>$collegeName</a>")
    ?>
</div>

<div class="jumbotron">
    <form class="form-horizontal" role="form" method="POST" action="add-course-review.php">
        <div class="form-group">
            <label class="control-label col-sm-2">Professor:</label>
            <div class="col-sm-4">
                <select class="form-control" name="profID" required>
                    <?php
                    $query = "SELECT * FROM professor WHERE dept_id=$deptID;";
                    $result = $db->query($query);
                    foreach ($result as $row) {
                        printf("<option value='%d'>%s</option>", $row['id'], $row['name']);
                    }
                    ?>
                </select>
            </div>
            <label class="control-label">Professor not on the list? <a
                    href="add-professor.php?deptID=<?php echo $deptID; ?>">Click here to
                    add.</a></label>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Easiness:</label>
            <div class="col-sm-4">
                <input type="number" name="easiness" class="rating" min=0 max=5 step=1 data-size="sm" data-rtl="false"
                       required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Textbook required:</label>
            <div class="col-sm-4">
                <input checked data-toggle="toggle" data-on="Yes" data-off="No" type="checkbox" name="textbook_required"
                       required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Course Review:</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="course_review" rows="5" placeholder="Course Review"
                          required></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Usefulness (Optional):</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="helpfulness"
                          placeholder="How helpful was the course? (Eg: Was the course helpful towards your major? Did you learn new skills?)"
                          rows="2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Tips (Optional):</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="tips"
                          placeholder="Any tips for students taking or planning to take this course?"
                          rows="2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Overall Rating:</label>
            <div class="col-sm-4">
                <input type="number" name="overall_rating" class="rating" min=0 max=5 step=1 data-size="sm"
                       data-rtl="false" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-4" align="center">
                <input class="btn default" type="submit" value="Submit">
                <input class="btn btn-danger" type="reset" value="Reset">
            </div>

        </div>
    </form>


</div>


</body>
</head>
</html>
