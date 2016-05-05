
<html>
<head>
    <?php

    /**
     * edit-course-review.php
     * Form to edit a course review already in the database.
     * This form can only be accessed from a user's profile page.
     */

    include_once('db_connect.php');
    include_once('links.html');
    $user_id = $_POST['userID'];
    $course_id = $_POST['courseID'];
    $course_name = $_POST['courseName'];
    $prof_id = $_POST['profID'];
    $prof_name = $_POST['profName'];
    $dept_id = $_POST['deptID'];
    $query = "SELECT department.name AS department, college.id AS collegeID, college.name AS college FROM department JOIN college ON department.college_id=college.id WHERE department.id=?;";
    $dept = $db->prepare($query);
    $dept->execute(array($dept_id));
    $dept = $dept->fetch();
    
    $review = $_POST['review'];
    $tips = $_POST['tips'];
    $textbook = "";
    if ($_POST['bookRequired'] == 'Yes') {
        $textbook = "checked";
    }

    $usefulness = $_POST['usefulness'];
    $easiness = $_POST['easiness'];
    $overall = $_POST['overall'];
    ?>
    <link rel="stylesheet" href="css/star-rating.css">
    <script src="js/star-rating.js"></script>
    <script>
        function reset_star() {
            $('#star1').rating('reset');
            $('#star2').rating('reset');
            $('#textbook').bootstrapToggle('off');
        }
    </script>

    <link rel="stylesheet" href="css/bootstrap-toggle.css">
    <script src="js/bootstrap-toggle.js"></script>

    <title>
        <?php
        printf("Update review for %s course of %s Department, %s ", $course_name, $dept['department'], $dept['college']);
        ?>
    </title>

<body style="background: url('img/pattern.png');">
<div class="container">
    <?php
    printf("<h3 style='text-align: center'>Update review for<br> <p><a href='course.php?id=$course_id'>$course_name</a></p>".
        "<p><a href='department.php?id=$dept_id'>%s</a>, <a href='college.php?id=%d'>%s</a></p></h3>",$dept['department'], $dept['collegeID'], $dept['college']);
    ?>
</div>

<div class="jumbotron">
    <form class="form-horizontal" role="form" method="POST" action="edit-course-review-auth.php">
        <input type="hidden" name="courseID" value=<?php echo $course_id; ?>>
        <input type="hidden" name="profID" value=<?php echo $prof_id; ?>>
        <input type="hidden" name="deptID" value=<?php echo $dept_id; ?>>
        <div class="form-group">
            <label class="control-label col-sm-2">Professor:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="professor" value='<?php echo $prof_name;?>' disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Easiness:</label>
            <div class="col-sm-4">
                <input type="number" id='star1' name="easiness" class="rating" min=0 max=5 step=0.5 data-size="sm" data-rtl="false" value='<?php echo $easiness;?>' required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Textbook required:</label>
            <div class="col-sm-4">
                <input type="checkbox" id='textbook' data-toggle="toggle" data-on="Yes" data-off="No"
                       name="textbook_required" <?php echo $textbook;?> formnovalidate>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Course Review:</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="course_review" rows="5" placeholder="Course Review"
                          required><?php echo $review;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Usefulness (Optional):</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="helpfulness"
                          placeholder="How helpful was the course? (Eg: Was the course helpful towards your major? Did you learn new skills?)"
                          rows="2" required><?php echo $usefulness;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Tips (Optional):</label>
            <div class="col-sm-4">
                <textarea class="form-control" name="tips"
                          placeholder="Any tips for students taking or planning to take this course?"
                          rows="2" required><?php echo $tips;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Overall Rating:</label>
            <div class="col-sm-4">
                <input type="number" id='star2' name="overall_rating" class="rating" min=0 max=5 step=0.5 data-size="sm"
                       data-rtl="false" value='<?php echo $overall;?>' required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-4" align="right">
                <input class="btn btn-success" type="submit" value="Submit">
                <input class="btn btn-default" type="reset" onclick="reset_star()" value="Reset">
            </div>

        </div>
    </form>


</div>


</body>
</head>
</html>
