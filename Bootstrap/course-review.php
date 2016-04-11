<html>
<head>
    <?php

    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');

    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect'] = $_SERVER['HTTP_REFERER'];
        //TODO:Some sort of message in login page telling them that they need to log in
        header('Location:login.php');
    }
    $id = $_POST['course_id'];
    $query = "SELECT course.name AS courseName, course.dept_id AS deptID, department.name AS deptName college.name AS collegeName, college.id AS college.id FROM (course JOIN department on course.dept_id=department.id) JOIN college ON department.college_id=college.id WHERE course.id=$id;";
    $result = $db->query($query);
    $result = $result->fetch();
    $name = $result['name'];

    ?>
    <title>
        Add a review for
    </title>

<body>

</body>
</head>
</html>
