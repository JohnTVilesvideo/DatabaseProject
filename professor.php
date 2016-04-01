<?php
/**
 * Author: Amrit
 * Date: 3/12/16
 * Time: 3:18 PM
 */
include_once('db_connect.php');
if (!array_key_exists('id', $_GET)) {
    exit("Invalid url syntax. Please append ?id=x to the url, where x is the professor id");
}
$id = $_GET['id'];
$query = "SELECT * FROM professor WHERE id=$id;";
$result = $db->query($query);
if ($result->rowCount() == 0) {
    exit("Professor with the given id does not exist.");
}
$professor = $result->fetch();
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <style>
        h2 {
            font-weight: normal;
        }
    </style>

    <title><?php echo 'Rate my Professor | ' . $professor['name'] ?></title>
</head>
<body>
<?php
printf("<table align='center' cellspacing='0' cellpadding='4'>");
printf("<tr><td><h1>%s</h1></td></tr>", $professor['name']);
$query = "SELECT college.id AS col_id, college.name AS col_name, department.id AS dept_id, department.name AS dept_name".
    " FROM (professor JOIN department ON dept_id = department.id) JOIN college ON department.college_id = college.id".
    " WHERE professor.id = $id;";
$result = $db->query($query);
$professor_info = $result->fetch();
printf("<tr><td><h2><a href='college.php?id=%s'>%s</a> </h2></td></tr>", $professor_info['col_id'], $professor_info['col_name']);
printf("<tr><td><h2><a href='department.php?id=%s'>%s</a> </h2></td></tr>", $professor_info['dept_id'], $professor_info['dept_name']);
printf("<tr><td><button >Rate this professor</button></td></tr>");
printf("</table>");
?>
<h2><p align="center">Reviews for <?php printf("%s", $professor['name']); ?></p></h2>
<table align="center" cellspacing="0" cellpadding="4" border="1">
    <tr>
        <td><h2><b>Course</b></h2></td>
        <td><h2><b>Review</b></h2></td>
        <td><h2><b>Ratings</b></h2></td>
    </tr>
    <?php
    $query = "SELECT * FROM prof_review WHERE prof_id=$id";
    $result = $db->query($query);
    foreach($result as $row){
        $course_id = $row['course_id'];
        $query = "SELECT name FROM course WHERE id=$course_id;";
        $course = $db->query($query)->fetch();
        printf("<tr>");
        printf("<td><a href='course.php?id=%s'>%s</a></td>",$course_id, $course['name']);
        printf("<td>%s</td>", $row['review']);
        printf("<td><p><b>Helpfulness:</b> %s</p><p><b>Easiness:</b> %s</p><p><b>Clarity:</b> %s</p> <p><b>Overall Rating:</b> %s</p>",
            $row['helpfulness'], $row['easiness'], $row['clarity'], $row['overall_rating']);
        printf("</tr>");
    }
    ?>
</table>
</body>
</html>
