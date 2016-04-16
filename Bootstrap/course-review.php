<html>
<head>
    <?php

    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');


    $id = NULL;
    if (!isset($_SESSION['user_id'])) {
        $id = $_POST['course_id'];  // TODO might have to check this again
        header("Location:login.php?location=" . urlencode($_SERVER['REQUEST_URI']) . "&id=" . urlencode($id));
    }
    if (isset($_GET['id'])) {
           $id = $_GET['id'];
    }
    $query = "SELECT course.name AS courseName, course.dept_id AS deptID, department.name AS deptName, college.name AS collegeName, college.id FROM (course JOIN department on course.dept_id=department.id) JOIN college ON department.college_id=college.id WHERE course.id=$id;";
    $result = $db->query($query);
    $result = $result->fetch();  
    $courseName = $result['courseName'];
    $deptName = $result['deptName'];
    $colName = $result['collegeName'];
    ?>
    <title>
        Add a review for <?php echo "" . $name ?>
    </title>
</head>
<body>

<h2 style="text-align: center">Review of</h2>
<h1 style="text-align: center"><?php printf("%s",$courseName); ?></h1>
<h2 style="text-align: center"><?php printf("%s Department, %s", $deptName, $colName); ?></h2>
<form id='courseReview' method='POST' action='add_course_review.php' accept-charset="UTF-8">
<table style="float:center">
	<tr>
		<td>
		<table>
		<tr>
			<td><input type='text' id='professor' name='professor' placeholder='Taken with Professor' required></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><p>Easiness:</p></td>
			<td align='left'>
				<input type='radio' name='easiness' value=1 required>
				<input type='radio' name='easiness' value=2 required>
				<input type='radio' name='easiness' value=3 required>
				<input type='radio' name='easiness' value=4 required>
				<input type='radio' name='easiness' value=5 required>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><p>Textbook required:</p></td>
			<td><input type="radio" name="isTextRequired" value=1 required>Yes
		    	    <input type="radio" name="isTextRequired" value=0 required> No</td>
		</tr>
		</table>
		</td>
	</tr>

	<tr>
		<td><textarea rows=10 cols=50 form='courseReview' name='review' placeholder="Course Review" required></textarea></td>
	</tr>
	<tr>
		<td><textarea rows=5 cols=50 form='courseReview' name='usefulness' placeholder="(Optional) How helpful was the course to you? (e.g. matter to your major, teach you a new skill, ...)"></textarea></td>
	</tr>
	<tr>
		<td><textarea rows=5 cols=50 form='courseReview' name='tips' placeholder="(Optional) What are some tips you might have for other people who are going to take the course?"></textarea></td>
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><p>Overall Rating:</p></td>
			<td align='left'>
				<input type='radio' name='overall' value=1 required>
				<input type='radio' name='overall' value=2 required>
				<input type='radio' name='overall' value=3 required>
				<input type='radio' name='overall' value=4 required>
				<input type='radio' name='overall' value=5 required>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td><input type='submit' value='Submit'></td>
					<td align="center"><input type="reset" value="Clear all"/></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>