<html>
<head>
    <?php

    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');
    $id = 0;
    if (array_key_exists('professor_id', $_POST)) {
        $id = $_POST['professor_id'];
    }
    if (!isset($_SESSION['user_id'])) {
        header("Location:login.php?location=" . urlencode($_SERVER['REQUEST_URI']) . "&id=" . urlencode($id));
    }
  
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    $query = "SELECT professor.name AS professorName, professor.dept_id AS deptID, department.name AS deptName, college.name AS collegeName, college.id AS collegeID FROM (professor JOIN department ON professor.dept_id=department.id) JOIN college ON department.college_id=college.id WHERE professor.id=$id;";
    $result = $db->query($query);
    $result = $result->fetch();
    $professorName = $result['professorName'];
    $deptID = $result['deptID'];
    $deptName = $result['deptName'];
    $collegeName = $result['collegeName'];
    $collegeID = $result['collegeID'];

    $addFailed = false;
    if (array_key_exists('add-failed', $_SESSION)) {
        unset($_SESSION['add-failed']);
        $addFailed = true;
        $courseID = $_SESSION['courseID'];
        unset($_SESSION['courseID']);
        $easiness = $_SESSION['easiness'];
        unset($_SESSION['easiness']);
        $helpfulness = $_SESSION['helpfulness'];
        unset($_SESSION['helpfulness']);
        $clarity = $_SESSION['clarity'];
        unset($_SESSION['clarity']);
        $professorReview = $_SESSION['professor_review'];
        unset($_SESSION['professor_review']);
        $overallRating = $_SESSION['overall_rating'];
        unset($_SESSION['overall_rating']);
    }

    ?>
    <link rel="stylesheet" href="css/star-rating.css">
    <script src="js/star-rating.js"></script>
    <script>
        function reset_star() {
            $('#star1').rating('reset');
            $('#star2').rating('reset');
            $('#star3').rating('reset');
        }
    </script>
    <link rel="stylesheet" href="css/bootstrap-toggle.css">
    <script src="js/bootstrap-toggle.js"></script>

    <title>
        <?php
        printf("Add a review for %s professor of %s Department, %s ", $professorName, $deptName, $collegeName);
        ?>
    </title>

<body style="background: url('img/pattern.png');">
<div class="container">
    <?php
    printf("<h3 style='text-align: center'>Add a review for<br> <a href='professor.php?id=$id'>$professorName</a><br>" .
        "<a href='department.php?id=$deptID'>$deptName</a>, <a href='college.php?id=$collegeID'>$collegeName</a>")
    ?>
</div>

<div class="jumbotron" style="text-align: left">
    <form class="form-horizontal" role="form" method="POST" action="add-professor-review.php">
        <?php
        if ($addFailed) {
            printf("<div class='alert alert-danger'> <strong>Add review failed !</strong> Your have already reviewed this professor for the selected course. Please select a different course or edit your review for this professor associated with the selected course in your profile page.</div>");
        }
        ?>
        <input type="hidden" name="profID" value="<?php echo $id; ?>">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">Course not on the list? <a href="add-course.php?deptID=<?php echo $deptID; ?>">Click here to add.</a></div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email" >Course:</label>
            <div class="col-sm-4">
                <select class="form-control" name="courseID" required>
                    <?php
                    $query = "SELECT * FROM course WHERE dept_id=$deptID;";
                    $result = $db->query($query);
                    foreach ($result as $row) {
                        if ($addFailed && $row['id'] == $courseID) {
                            printf("<option value='%d' selected>%s</option>", $row['id'], $row['name']);
                        } else {
                            printf("<option value='%d'>%s</option>", $row['id'], $row['name']);
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Easiness:</label>
            <div class="col-sm-4">
                <input type="number" id='star1' name="easiness" class="rating" min=0 max=5 step=0.5 data-size="sm" data-rtl="false"
                    <?php if ($addFailed) {
                        echo "value=" . $easiness;
                    } ?> required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Helpfulness:</label>
            <div class="col-sm-4">
                <input type="number" id="star2" name="helpfulness" class="rating rating-loading" min=0 max=5 step=0.5 data-size="sm"
                       data-rtl="false"
                    <?php if ($addFailed) {
                        echo "value=" . $helpfulness;
                    } ?> required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Clarity:</label>
            <div class="col-sm-4">
                <input type="number" id='star3' name="clarity" class="rating" min=0 max=5 step=0.5 data-size="sm" data-rtl="false"
                    <?php if ($addFailed) {
                        echo "value=" . $clarity;
                    } ?> required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Professor Review:</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="professor_review" rows="5" placeholder="Professor Review"
                          required><?php if ($addFailed) {
                        echo $professorReview;
                    } ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Overall rating:</label>
            <div class="col-sm-4">
                <input type="number" id='last' name="overall_rating" class="rating" min=0 max=5 step=0.5 data-size="sm"
                       data-rtl="false"
                    <?php if ($addFailed) {
                        echo "value=" . $overallRating;
                    } ?> required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4" align="right">
                <input class="btn btn-success" type="submit" value="Submit">
                <input class="btn btn-default" id='reset' type="reset"  onclick="reset_star()" value="Reset">
            </div>

        </div>
    </form>


</div>


</body>
</head>
</html>
