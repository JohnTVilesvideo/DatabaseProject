<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    /*
     * admin/login.php
     * Login page for moderators used for accessing Administrative section.
     */
    ?>
    <meta charset="utf-8">
    <title>Log in | Rate my Professor</title>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">


    <script src="../js/jquery.min.js"></script>

    <!-- bootstrap Javascript flie -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/signin.css" rel="stylesheet">

    <?php
    include_once('../db_connect.php');
    include('nav.php');

    if (array_key_exists('login_failed', $_SESSION)) {
        $loginFailed = true;
        unset($_SESSION['login_failed']);
    } else {
        $loginFailed = false;
    }
    ?>
</head>

<body>

<div class="container">

    <form class="form-signin" method="POST" action="login-auth.php">
        <?php
        if ($loginFailed) {
            printf("<div class='alert alert-danger'> <strong>Login Failed !</strong> Either your username or password do not match or you are not authorized to access this area.<br> Please try again.</div>");
        }
        ?>

        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="username" name='username' class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div> <!-- /container -->

</body>
</html>
