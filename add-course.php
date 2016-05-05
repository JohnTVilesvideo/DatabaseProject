<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add a Course | Rate my Course</title>
    <?php
    /**
     * add-course.php
     * Access from Professor Review page, when user can't find the course they took with that professor
     * Add new course to the database with given college and department (user can't change those two information)
     * Author: Amrit, Dung
     */
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect'] = $_SERVER['HTTP_REFERER'];
        header('Location:login.php');
    }
    $userID = $_SESSION['user_id'];
    $deptGiven = array_key_exists('deptID', $_GET);
    if ($deptGiven) {
        $deptID = $_GET['deptID'];
        $result = $db->prepare("SELECT department.name AS deptName, college.id AS collegeID, college.name AS collegeName FROM department JOIN college ON department.college_id=college.id WHERE department.id=?;");
        $result->execute(array($deptID));
        $result = $result->fetch();
        $deptName = $result['deptName'];
        $collegeID = $result['collegeID'];
        $collegeName = $result['collegeName'];
    }

    $addFailed = false;
    if (array_key_exists('add-failed', $_SESSION)) {
        unset($_SESSION['add-failed']);
        $addFailed = true;
        if (!$deptGiven) {
            $collegeName = $_SESSION['collegeName'];
        }
        unset($_SESSION['collegeName']);
        if (!$deptGiven) {
            $deptName = $_SESSION['deptName'];
        }
        unset($_SESSION['deptName']);
        $courseName = $_SESSION['courseName'];
        unset($_SESSION['courseName']);
        $courseCode = $_SESSION['courseCode'];
        unset($_SESSION['courseCode']);
    }
    ?>
</head>

<body style="background: url('img/pattern.png');">
<div class="jumbotron">
    <h3 align="center">Add new Course</h3>
    <form class="form-horizontal" role="form" method="POST" action="add-course-auth.php">
        <?php
        if ($addFailed) {
            printf($_SESSION['error-message']);
            unset($_SESSION['error-message']);
        }
        if ($deptGiven) {
            printf("<input type='hidden' name='dept_id' value='$deptID'>");
        }
        ?>
        <div class="form-group">
            <label class="control-label col-sm-2">College:</label>
            <div class="col-sm-4">
                <input type="hidden" name="location" value="<?php echo $_GET['location']?>">
                <input type="hidden" name="append" value="<?php echo $_GET['id']?>">
                <input type="text" class="form-control" name="collegeName"
                    <?php if ($deptGiven) {
                        echo "value='$collegeName' disabled";
                    } else if ($addFailed) {
                        echo "value='$collegeName'";
                    }
                    ?> >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Department:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="deptName"
                    <?php if ($deptGiven) {
                        echo "value='$deptName' disabled";
                    } else if ($addFailed) {
                        echo "value='$deptName'";
                    }
                    ?> >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Course Name:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                       name="courseName" <?php if ($addFailed) echo "value='$courseName''"; ?> required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Course Code:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control"
                       name="courseCode" <?php if ($addFailed) echo "value='$courseCode''"; ?> required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-4" align="center">
                <input class="btn btn-default" type="submit" value="Submit">
                <input class="btn btn-danger" type="reset" value="Reset">
            </div>

        </div>
    </form>
    <div class="container">
    </div> <!-- /container -->

</body>
</html>
