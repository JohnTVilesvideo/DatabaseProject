<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    /**
     * Author: Amrit
     * Date: 3/12/16
     * Time: 3:18 PM
     */
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');
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

    <title><?php echo 'Rate my Professor | ' . $college['name'] ?></title>
</head>
<body style="background: url('img/pattern.png');">
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">

    <div class="jumbotron">
        <h4><p align="left">Other Colleges from <?php echo $college['state'] ?></p>
        </h4>
        <table class="table">
            <?php
            $state = $college['state'];
            $query = "SELECT * FROM college WHERE state='$state';";
            $result = $db->query($query);
            foreach ($result as $row) {
                $colID = $row['id'];
                if ($colID != $id) {
                    $colName = $row['name'];
                    printf("<tr><td><a href='college.php?id=$colID'>$colName</a> </td></tr>");
                }
            }
            ?>
        </table>
    </div>
</div>

<!-- main area -->
<div class="col-xs-12 col-sm-9" >
    <div class="container">
        <?php
        printf("<table align='center' cellspacing='0' cellpadding='4' style='color: dodgerblue'>");
        printf("<tr><td><h2>%s</h2></td></tr>", $college['name']);
        printf("<tr><td><h3>%s, %s</h3></td></tr>", $college['city'], $college['state']);
        $website = $college['website'];
        if (!(substr($website, 0, 4) == "http")) {
            $website = "http://" . $website;
        }
        printf("<tr><td><h3> Website : <a href='%s'>%s</a></h3></td></tr>", $website, $website);
        printf("</table>");
        ?>

        <table class="table">
            <tr>
                <td><h3><b>Professor</b></h3></td>
                <td><h3><b>Department</b></h3></td>
            </tr>
            <?php
            $query = "SELECT professor.id AS profID, dept_id, professor.name AS profName, department.name as deptName FROM professor JOIN department WHERE dept_id = department.id  AND department.college_id=$id";
            $result = $db->query($query);
            foreach ($result as $row) {
                printf("<tr><td><a href='professor.php?id=%s'>%s</a></td><td><a href='department.php?id=%s'>%s</a> </td></tr>",
                    $row['profID'], $row['profName'], $row['dept_id'], $row['deptName']);
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
