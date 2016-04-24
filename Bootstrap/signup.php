<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign up | Rate my Professor</title>
    <!-- Custom styles for this template -->
    <link href="css/signup.css" rel="stylesheet">
    <?php
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');
    /*if (array_key_exists('redirect', $_SESSION)) {
        $lastPage = $_SESSION['redirect'];
    } else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $lastPage = $_SERVER['HTTP_REFERER'];
    } else {

        $lastPage = "http://cs.gettysburg.edu/~dhakam01/cs360/project/Bootstrap/index.php"; //TODO: dynamically figure out the home url
    }*/
    if (array_key_exists('signup_failed', $_SESSION)) {
        $signupFailed = true;
        $invalidUsername = array_key_exists('invalid_username', $_SESSION);
        $invalidEmail = array_key_exists('invalid_email', $_SESSION);
        $passwordMismatch = array_key_exists('password_mismatch', $_SESSION);
        unset($_SESSION['signup_failed']);
    } else {
        $signupFailed = false;
    }
    ?>
</head>

<body style="background: url('img/pattern.png');">
<div class="container">

    <form class="form-signup" method="POST" action="signup-auth.php">
        <?php
        if ($signupFailed) {
            printf("<div class='alert alert-danger'> <strong>Sign Up Failed !</strong> Please correct the following errors:");
            if ($passwordMismatch) {
                printf("<br>Your password and confirmation password do not match.");
            }
            if ($invalidUsername) {
                printf("<br>The username you entered is already in use or is invalid.");
            }
            if ($invalidEmail) {
                printf("<br>The email address you entered is already in use or is invalid.");
            }
            printf("</div>");
        }
        ?>
        <h2 class="form-signup-heading">Sign Up</h2>
        <!--<input type="hidden" name="referer" value="<?php echo $lastPage; ?>"> -->
        <?php
            // Test redirect from $_GET
            echo '<input type="hidden" name="location" value="';
            if(isset($_GET['location'])) {
                echo htmlspecialchars($_GET['location']);
            }
            if(isset($_GET['id'])) {
                echo "?id=" . htmlspecialchars($_GET['id']);
            }
            echo '">';
            printf("\n");
            echo '<input type="hidden" name="append" value="';
            if(isset($_GET['location'])) {
                echo "?location=" . htmlspecialchars($_GET['location']);
            }
            if(isset($_GET['id'])) {
                echo "&id=" . htmlspecialchars($_GET['id']);
            }
            echo '">';
        ?>
        <div class="form-inline">
            <input type="text" name='fname' class="form-control" placeholder="First Name"
                   style="width: 228px;!important;" required autofocus>
            <input type="text" name='lname' class="form-control" placeholder="Last Name"
                   style="width: 228px;!important;" required>
        </div>
        <input type="username" name='username' class="form-control" placeholder="Username" required>
        <input type="email" name='email' class="form-control" placeholder="Email Address" required>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
        <p align="center"><a href="login.php">Already Registered? Sign in</a></p>
    </form>
</div> <!-- /container -->
</body>
</html>