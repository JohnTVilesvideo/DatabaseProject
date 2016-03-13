<?php
/**
 * Author: Amrit
 * Date: 3/12/16
 * Time: 3:18 PM
 */
include_once('db_connect.php');
if (!array_key_exists('id', $_GET)) {
    exit("Invalid url syntax. Please append ?id=x to the url, where x is the college id");
}
$id = $_GET['id'];
$query = "SELECT * FROM college WHERE id=$id;";
$result = $db->query($query);
if ($result->rowCount() == 0) {
    exit("College with the given id does not exist.");
}
$college = $result->fetch();
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

    <title><?php echo 'Rate my Professor | ' . $college['name'] ?></title>
</head>
<body>
<?php
printf("<table align='center' cellspacing='0' cellpadding='4'>");
printf("<tr><td><h1>%s</h1></td></tr>", $college['name']);
printf("<tr><td><h2>%s, %s</h2></td></tr>", $college['city'], $college['state']);
printf("<tr><td><h2> Website : <a href='http://%s'>%s</a></h2></td></tr>", $college['website'], $college['website']);
printf("</table>");
?>

<table align="center" cellspacing="0" cellpadding="4" border="1">
    <tr>
        <td><h2><b>Professor</b></h2></td>
        <td><h2><b>Department</b></h2></td>
    </tr>
    <?php
    $query = "SELECT * FROM professor WHERE college_id=$id";
    $result = $db->query($query);
    foreach($result as $row){
        $dept_id = $row['dept_id'];
        $result = $db->query("SELECT * FROM department WHERE id=$dept_id");
        $dept = $result->fetch();
        printf("<tr><td><a href='professor.php?id=%s'>%s</a></td><td><a href='department.php?id=%s'>%s</a> </td></tr>",
            $row['id'], $row['name'], $dept_id, $dept['name']);
    }
    ?>
</table>
</body>
</html>
