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
<title>Professor Review</title>
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

<h2 style="text-align: center">Review of Professor </h2>
<h1 style="text-align: center"><?php printf("%s",$_POST['prof']); ?></h1>
<h2 style="text-align: center"><?php printf("%s Department, %s", $_POST['dept'], $_POST['col']); ?></h2>
<form id='profReview' method='POST' action='add_professor_review.php' accept-charset="UTF-8">
<!--<input type="hidden" name="profID">
<input type="hidden" name="courseID">-->
<table style="float:center">
	<tr>
		<td>
		<table>
		<tr>
			<td><input type='text' id='course' name='course' placeholder="Course Taken" required></td>
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
			<td><p>Helpfulness:</p></td>
			<td align='left'>
				<input type='radio' name='helpfulness' value=1 required>
				<input type='radio' name='helpfulness' value=2 required>
				<input type='radio' name='helpfulness' value=3 required>
				<input type='radio' name='helpfulness' value=4 required>
				<input type='radio' name='helpfulness' value=5 required>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table>
		<tr>
			<td><p>Clarity:</p></td>
			<td align='left'>
				<input type='radio' name='clarity' value=1 required>
				<input type='radio' name='clarity' value=2 required>
				<input type='radio' name='clarity' value=3 required>
				<input type='radio' name='clarity' value=4 required>
				<input type='radio' name='clarity' value=5 required>
			</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><textarea rows=10 cols=50 form='profReview' name="professorReview" placeholder="Professor Review" required></textarea></td>	
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
<?php
printf("<input type='hidden' name='prof_id' value='%s'>",$_POST['prof_id']);
printf("<input type='hidden' name='dept_id' value='%s'>",$_POST['dept_id']);
?>
</form>
</body>
</html>

