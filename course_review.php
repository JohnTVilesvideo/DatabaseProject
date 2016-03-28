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

<h1 style="text-align: center">Course Review</h1>
<form id='courseReview' method='POST' action='add_course_review.php' accept-charset="UTF-8">
<!--<input type="hidden" name="profID">
<input type="hidden" name="courseID">-->
<table style="float:center">
	<tr> 
		<td>
			<table>
			<tr>
				<td><button type="button" id='usePrev'>Use previous information</button></td>
				<td align="center"><input type="reset" value="Clear all"/></td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><input type='text' id='college' name='college' placeholder="College Name"></td>
			<td><input type='text' id='dept' name='department' placeholder='Department'></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><input type='text' id='course' name='course' placeholder='Course'></td>
			<td><input type='text' id='professor' name='professor' placeholder='Professor'></td>
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
				<input type='radio' name='easiness' value=1>
				<input type='radio' name='easiness' value=2>
				<input type='radio' name='easiness' value=3>
				<input type='radio' name='easiness' value=4>
				<input type='radio' name='easiness' value=5>
			</td>
		</tr>
		</table>
		</td>
		<!--<td><div w3-include-html="star_rating.html"></div> <script src="include-HTML.js"></script> </td>-->
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><p>Textbook required:</p></td>
			<td><input type="radio" name="isTextRequired" value="Yes">Yes
		    <input type="radio" name="isTextRequired" value="No"> No</td>
		</tr>
		</table>
		</td>
	</tr>

	<tr>
		<td><textarea rows=10 cols=50 form='courseReview' name='review' placeholder="Course Review"></textarea></td>	
	</tr>
	<tr>	
		<td><textarea rows=5 cols=50 form='courseReview' name='usefulness' placeholder="How helpful was the course to you? (e.g. matter to your major, teach you a new skill, ...)"></textarea></td>
	</tr>
	<tr>
		<td><textarea rows=5 cols=50 form='courseReview' name='tips' placeholder="What are some tips you might have for other people who are going to take the course?"></textarea></td>
	</tr>
	<tr>
		<td><p>Overall Rating:</p></td>
<td></td>
		<!--<td><div w3-include-html="star_rating.html"></div> <script src="include-HTML.js"></script> </td>-->
	</tr>
</table>

<br>
<input type='submit' value='Submit'>
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
