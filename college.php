<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    /**
     * college.php
     * Profile page for college.
     * Displays college information as well as professors and the departments associated with them.
     * The sidebar display the list of college from the same states.
     */
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');
    if (!array_key_exists('id', $_GET)) {
        exit("Invalid url syntax. Please append ?id=x to the url, where x is the college id");
    }
    $id = $_GET['id'];
    $result = $db->prepare("SELECT * FROM college WHERE id=?;");
    $result->execute(array($id));
    if ($result->rowCount() == 0) {

        exit("College with the given id does not exist.");
    }
    $college = $result->fetch();
    ?>

    <title><?php echo 'Rate my Professor | ' . $college['name'] ?></title>
</head>
<body style="background: url('img/pattern.png');">
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation" style="background: lightgray;">
        <h4><p align="left">Other Colleges from <?php echo $college['state'] ?></p></h4>
        <?php
        printf("<table class='table'>\n");
            $state = $college['state'];
            $result = $db->prepare("SELECT * FROM college WHERE  state=?;");
            $result->execute(array($state));
            foreach ($result as $row) {
                $colID = $row['id'];
                if ($colID != $id) {
                    $colName = $row['name'];
                    printf("\t\t\t<tr>\n");
                    printf("\t\t\t\t<td><a href='college.php?id=$colID'>$colName</a> </td>\n");
                    printf("\t\t\t</tr>\n");
                }
            }

        printf("\t</table>\n");
        ?>
</div>

<!-- main area -->
<div class="col-xs-12 col-sm-9" >
    <div class="container">
        <?php
        printf("<table align='center' cellspacing='0' cellpadding='4' style='color: dodgerblue'>\n");
        printf("\t<tr><td><h2>%s</h2></td></tr>\n", $college['name']);
        printf("\t<tr><td><h3>%s, %s</h3></td></tr>\n", $college['city'], $college['state']);
        $website = $college['website'];
        if (!(substr($website, 0, 4) == "http")) {
            $website = "http://" . $website;
        }
        printf("\t<tr><td><h3> Website : <a href='%s'>%s</a></h3></td></tr>\n", $website, $website);
        printf("</table>\n");
        ?>

        <table class="table">
            <tr>
                <td><h3><b>Professor</b></h3></td>
                <td><h3><b>Department</b></h3></td>
            </tr>
            <?php
            $result = $db->prepare("SELECT professor.id AS profID, dept_id, professor.name AS profName, department.name as deptName FROM professor JOIN department WHERE dept_id = department.id  AND department.college_id=?");
            $result->execute(array($id));
            foreach ($result as $row) {
                printf("\t\t\t<tr>\n");
                printf("\t\t\t\t<td><a href='professor.php?id=%s'>%s</a></td>\n", $row['profID'], $row['profName']);
                printf("\t\t\t\t<td><a href='department.php?id=%s'>%s</a></td>\n" , $row['dept_id'], $row['deptName']);
                printf("\t\t\t</tr>\n");
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
