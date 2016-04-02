<?php
/**
 * Author: Amrit
 * Date: 3/12/16
 * Time: 3:18 PM
 */
include_once('db_connect.php');
session_start();
if (!array_key_exists('id', $_GET)) {
    exit("Invalid url syntax. Please append ?id=x to the url, where x is the course id");
}
$id = $_GET['id'];
$query = "SELECT * FROM course WHERE id=$id;";
$result = $db->query($query);
if ($result->rowCount() == 0) {
    exit("Course with the given id does not exist.");
}
$course = $result->fetch();
?>

<html xmlns="http://www.w3.org/1999/html">
<head>
    <style>

        h2 {
            font-weight: normal;
        }
    </style>

    <title><?php echo 'Rate my Professor | ' . $course['name'] ?></title>
</head>
<body>
<?php
printf("<table align='center' cellspacing='0' cellpadding='4'>");
printf("<tr><td><h1>%s (%s)</h1></td></tr>", $course['name'], $course['code']);
$query = "SELECT college.id AS col_id, college.name AS col_name, department.id AS dept_id, department.name AS dept_name".
    " FROM (course JOIN department ON dept_id = department.id) JOIN college ON college_id = college.id".
    " WHERE course.id = $id;";
$result = $db->query($query);
$course_info = $result->fetch();

/**
* I added these to your code since I need these information for the review parts
* I don't want to do query again each time I want to get these information
*/
$_SESSION['col'] = $course_info['col_name'];
$_SESSION['col_id'] = $course_info['col_id'];
$_SESSION['dept'] = $course_info['dept_name'];
$_SESSION['dept_id'] = $course_info['dept_id'];
$_SESSION['course'] = $course['name'];
$_SESSION['course_id'] = $id;
/*************************************************************************************/

printf("<tr><td><h2><a href='college.php?id=%s'>%s</a> </h2></td></tr>", $course_info['col_id'], $course_info['col_name']);
printf("<tr><td><h2><a href='department.php?id=%s'>%s</a> </h2></td></tr>", $course_info['dept_id'], $course_info['dept_name']);
printf("<tr><td><a href='course_review.php'><button >Rate this Course</button></a></td></tr>");
printf("</table>");
?>
<h2><p align="center">Reviews for <?php printf("%s", $course['name']); ?></p></h2>
<table align="center" cellspacing="0" cellpadding="4" border="1">
    <tr>
        <td><h2><b>Details</b></h2></td>
        <td><h2><b>Reviews</b></h2></td>
        <td><h2><b>Ratings</b></h2></td>
    </tr>
    <?php
    $query = "Select * from course_review WHERE course_id=$id";
    $result = $db->query($query);
    foreach($result as $row){
        $prof_id = $row['prof_id'];
        $query = "SELECT name FROM professor WHERE id=$prof_id;";
        $prof = $db->query($query)->fetch();
        $book_required = "";
        if($row['textbook_required'] == null){
            $book_required = "N/A";
        }
        elseif ($row['textbook_required'] == 0){
            $book_required = "No";
        }
        else{
            $book_required = "Yes";
        }
        printf("<tr>");
        printf("<td><p><b>Instructor:</b> <a href='professor.php?id=%s'>%s</a></p><p><b>Textbook Required:</b> %s</p></td>",
            $prof_id, $prof['name'], $book_required);
        printf("<td><p><b>Review:</b> %s</p> <p><b>Usefulness:</b> %s</p> <p><b>Tips:</b> %s</p></td>", $row['review'], $row['usefulness'], $row['tips']);
        printf("<td><p><b>Easiness:</b> %s</p> <p><b>Overall Rating:</b> %s</p>", $row['easiness'], $row['overall_rating']);
        printf("</tr>");
    }
    ?>
</table>
</body>
</html>
