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
    $id = $_POST['professor_id'];
    $query = "SELECT professor.name AS professorName, professor.dept_id AS deptID, department.name AS deptName, college.name AS collegeName, college.id AS collegeID FROM (professor JOIN department ON professor.dept_id=department.id) JOIN college ON department.college_id=college.id WHERE professor.id=$id;";
    $result = $db->query($query);
    $result = $result->fetch();
    $professorName = $result['professorName'];
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
        printf("Add a review for %s professor of %s Department, %s ", $professorName, $deptName, $collegeName);
        ?>
    </title>

<body>
<div class="container">
    <?php
    printf("<h3 style='text-align: center'>Add a review for<br> <a href='professor.php?id=$id'>$professorName</a><br>" .
        "<a href='department.php?id=$deptID'>$deptName</a>, <a href='college.php?id=$collegeID'>$collegeName</a>")
    ?>
</div>

<div class="jumbotron">
    <form class="form-horizontal" role="form" method="POST" action="add-professor-review.php">
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Course:</label>
            <div class="col-sm-4">
                <select class="form-control" name="profID" required>
                    <?php
                    $query = "SELECT * FROM course WHERE dept_id=$deptID;";
                    $result = $db->query($query);
                    foreach ($result as $row) {
                        printf("<option value='%d'>%s</option>", $row['id'], $row['name']);
                    }
                    ?>
                </select>
            </div>
            <label class="control-label">Course not on the list? <a href="add-course.php?deptID=<?php echo $deptID; ?>">Click
                    here to
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
            <label class="control-label col-sm-2">Helpfulness:</label>
            <div class="col-sm-4">
                <input type="number" name="helpfulness" class="rating" min=0 max=5 step=1 data-size="sm"
                       data-rtl="false"
                       required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Clarity:</label>
            <div class="col-sm-4">
                <input type="number" name="clarity" class="rating" min=0 max=5 step=1 data-size="sm" data-rtl="false"
                       required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Professor Review:</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="review" rows="5" placeholder="Professor Review"
                          required></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Overall rating:</label>
            <div class="col-sm-4">
                <input type="number" name="overall_rating" class="rating" min=0 max=5 step=1 data-size="sm"
                       data-rtl="false"
                       required>
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
