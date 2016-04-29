<html>
<head>
    <title>
        Rate My Professors Administration
    </title>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">


    <script src="../js/jquery.min.js"></script>

    <!-- bootstrap Javascript flie -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/signin.css" rel="stylesheet">
    <?php
    include_once('../db_connect.php');

    include_once("nav.php");
    if (!array_key_exists('user_id', $_SESSION)) {
        header("Location:login.php");
    }
    $userID = $_SESSION['user_id'];
    $result = $db->prepare("SELECT usergroup FROM user WHERE id = ?;");
    $result->execute(array($userID));
    $user = $result->fetch();
    if ($user['usergroup'] != 'MOD') {
        header("Location:login.php");
    }
    printf("<h3 align='center'>Reported Reviews</h3></br>");
    $query = "SELECT * FROM reported_review ORDER  BY report_count DESC;";
    $result = $db->query($query);
    if ($result->rowCount() == 0) {
        printf("<h2 align='center'>There are no reported reviews.</h2>");
    } else {
        printf("<table class='table'>");
        printf("<tr><th style='width:10%%;'>Review Type</th><th style='width:50%%;'>Review</th><th style='width:10%%;'>Number of reports</th><th style='width:20%%;'>Actions</th></tr>");
        foreach ($result as $row) {
            $reviewer = $row['user_id'];
            $professor = $row['prof_id'];
            $course = $row['course_id'];
            $type = $row['type'];
            if ($type == 0) {
                $data = $db->prepare("SELECT * FROM prof_review WHERE  user_id=? AND prof_id=? AND  course_id=?;");
                $data->execute(array($reviewer, $professor, $course));
                $data = $data->fetch();

            } else {
                $data = $db->prepare("SELECT * FROM course_review WHERE  user_id=? AND prof_id=? AND  course_id=?;");
                $data->execute(array($reviewer, $professor, $course));
                $data = $data->fetch();
            }
            printf("<tr>");
            $typeString = $type == 0 ? 'Professor' : 'Course';
            printf("<td>$typeString</td>");
            if ($type == 0) {
                printf("<td>%s</td>", $data['review']);
            } else {
                printf("<td><p><b>Review:</b> %s</p> <p><b>Usefulness:</b> %s</p> <p><b>Tips:</b> %s</p></td>", $data['review'], $data['usefulness'], $data['tips']);
            }
            printf("<td>%d</td>", $row['report_count']);
            printf("<td><form method='post' action='moderate-review-action.php'>");
            printf("<input type='hidden' name='review_type' value='$type'>");
            printf("<input type='hidden' name='user_id' value='$reviewer'>");
            printf("<input type='hidden' name='prof_id' value='$professor'>");
            printf("<input type='hidden' name='course_id' value='$course'>");
            printf("<input class='btn btn-success' name='btn' type='submit' value='Dismiss Report'>");
            printf("<input class='btn btn-danger' style='margin-left: 5px' name='btn' type='submit' value='Delete Review'>");
            printf("</form>");
        }
        printf("</table>");
    }
    ?>
</head>
</html>
