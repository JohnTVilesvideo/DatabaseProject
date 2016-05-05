<?php
/**
 * admin/nav.php
 * Navigation bar for Administrative Area.
 * Displays logo, Session information along with buttons to login,
 * logout, access profile and homepage
 */

include_once('../db_connect.php');
session_start();
if (array_key_exists('user_id', $_SESSION)) {
    $isLoggedIn = true;
    $name = $_SESSION['users_name'];
} else {
    $isLoggedIn = false;
}

?>
<link rel="stylesheet" href="../css/navbar-fixed-top.css">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php"><img alt="Brand" src="../img/Picture2.png"></a>
            <a class="navbar-brand">Administration</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($isLoggedIn) {
                    printf("<p class='navbar-text'>You are logged in as</p><li><a href='../profile.php'>$name</a></li>\n");
                    printf("<a href='logout.php'><button type='button' onclick='' class='btn btn-default navbar-btn'>Logout</button></a>\n");
                } else {
                    printf("<a href='login.php'><button type='button' class='btn btn-default navbar-btn'>Log in</button></a>\n");
                }
                ?>
                <a href='../index.php'>
                    <button type='button' class='btn btn-default navbar-btn'>Homepage</button>
                </a>
            </ul>
        </div>
    </div>
</nav>
