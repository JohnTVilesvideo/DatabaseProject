<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	echo '<script language="javascript">
	alert("Please login to review a course or professor");
	window.location.href = "login.html";
	</script>';
}
?>

<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<title>Course Review</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
//  Check Radio-box
    $(".rating input:radio").attr("checked", false);
    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    $('input:radio').change(
    function(){
        var userRating = this.value;
    }); 
});

</script>

</head>
<body>

<h2 style="text-align: center">Review of</h2>
<h1 style="text-align: center"><?php printf("%s",$_SESSION['course']); ?></h1>
<h2 style="text-align: center"><?php printf("%s Department, %s", $_SESSION['dept'], $_SESSION['col']); ?></h2>
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

<a href="logout.php">Logout</a>
<script>
document.getElementById("usePrev").addEventListener("click", function(){
	if (sessionStorage.getItem('course') != null) {
		var college = sessionStorage.getItem('college');
		var dept = sessionStorage.getItem('department');
		var course = sessionStorage.getItem('course');
		var prof = sessionStorage.getItem('professor');
		var profID = sessionStorage.getItem('profID');
		var courseID = sessionStorage.getItem('courseID');
		//console.log(document.getElementById("profReview")["college"].value);
		//console.log(college);
		document.getElementById("courseReview").elements["college"].value = college;
		document.getElementById("courseReview").elements["department"].value = dept;
		document.getElementById("courseReview").elements["course"].value = course;
		document.getElementById("courseReview").elements["professor"].value = prof;
		//document.getElementById("courseReview").elements["profID"].value = profID;
		//document.getElementById("courseReview").elements["courseID"].value = courseID;
	}
});


</script>
</body>
</html>
