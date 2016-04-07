<?php
/**
 * Author: Amrit
 * Date: 3/12/16
 * Time: 3:18 PM
 */
include_once('db_connect.php');
if (!array_key_exists('id', $_GET)) {
    exit("Invalid url syntax. Please append ?id=x to the url, where x is the department id");
}
$id = $_GET['id'];
$query = "SELECT * FROM department WHERE id=$id;";
$result = $db->query($query);
if ($result->rowCount() == 0) {
    exit("Department with the given id does not exist.");
}
$department = $result->fetch();
?>

<html>
<head>
    <style>

        p {
            text-align: center;
        }

        h2 {
            font-weight: normal;
        }
    </style>

    <title><?php echo 'Rate my Professor | ' . $department['name'] . ' (' . $department['code'] . ')' ?></title>
</head>
<body>
<?php
printf("<table align='center' cellspacing='0' cellpadding='4'>");
printf("<tr><td><h1>%s (%s)</h1></td></tr>", $department['name'], $department['code']);
$query = "SELECT * FROM college WHERE id=" . $department['college_id'] . ';';
$result = $db->query($query);
$college = $result->fetch();
printf("<tr><td><h2><a href='college.php?id=%s'>%s</a> </h2></td></tr>", $department['college_id'], $college['name']);
printf("<tr><td><h2>%s, %s</h2></td></tr>", $college['city'], $college['state']);
$website = $department['website'];
if (!(substr($website, 0, 4) == "http")) {
    $website = "http://" . $website;
}
printf("<tr><td><h2> Department Website : <a href='%s'>%s</a></h2></td></tr>", $website, $website);
printf("<tr><td><h3> Don't find your professor or course? Add your <a href='add_prof.php'>professor</a> or <a href='add_course.php'>course</a></tr>");
printf("</table>");
?>


<table align="center" cellspacing="0" cellpadding="4" border="1"> <!-- Courses table -->
    <tr>
        <td><h2><b>Courses</b></h2></td>
        <td><h2><b>Average Rating</b></h2></td>
    </tr>

    <?php
    $query = "SELECT * FROM course WHERE dept_id = $id;";
    $result = $db->query($query);
    foreach ($result as $row) {
        $course_id = $row['id'];
        $query = "SELECT AVG(overall_rating) AS avgRating FROM course_review WHERE course_id=$course_id;";
        $result = $db->query($query)->fetch();
        $avgRating = $result['avgRating'];
        if($avgRating == 0){
            $avgRating = 'N/A';
        }
        else{
            $avgRating = sprintf("%.1f", $avgRating);
        }
        printf("<tr><td><a href='course.php?id=%s'>%s</a></td> <td>%s</td></tr>", $row['id'], $row['name'], $avgRating);
    }
    ?>

</table>

<br>

<table align="center" cellspacing="0" cellpadding="4" border="1"> <!-- Instructor table -->
    <tr>
        <td><h2><b>Professors</b></h2></td>
        <td><h2><b>Average Rating</b></h2></td>
    </tr>

    <?php
    $query = "SELECT * FROM professor WHERE dept_id = $id;";
    $result = $db->query($query);
    foreach ($result as $row) {
        $prof_id = $row['id'];
        $query = "SELECT AVG(overall_rating) AS avgRating FROM prof_review WHERE prof_id=$prof_id;";
        $result = $db->query($query)->fetch();
        $avgRating = $result['avgRating'];
        if($avgRating == 0){
            $avgRating = 'N/A';
        }
        else{
            $avgRating = sprintf("%.1f", $avgRating);
        }
        printf("<tr><td><a href='professor.php?id=%s'>%s</a></td> <td>%s</td></tr>", $row['id'], $row['name'], $avgRating);
    }
    ?>

</table>
</body>
</html>
