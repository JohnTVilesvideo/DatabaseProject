<?php
session_start();
session_destroy();
?>

<html>
<head>
<script type="text/javascript">
	sessionStorage.clear();
	alert("Logout successfully");
	window.location.href = "main.html";
</script>
</head>
</html>
