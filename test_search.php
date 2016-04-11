<html lang="en">
<head>
    <?php
    print_r($_POST);
    ?>
    <meta charset="UTF-8">
    <title>Search test</title>
</head>
<body>
<form method="POST" action="Search.php">
    <input type="text" name="query" placeholder="Professor/College">
    <input type="submit" value="Search">
</form>
<form method="POST" action="Search.php">
    <input type="text" name="College" placeholder="College">
    <input type="text" name="Department" placeholder="Department">
    <input type="submit" value="Search">
</form>
</body>
</html>