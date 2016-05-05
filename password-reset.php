<html>
<head>
    <title>
        Reset Password | Rate my Professor
    </title>
    <?php
    /**
     * password-reset.php
     * Password reset form.
     * If the url contains the authentication token and the token is valid and has not expired,
     * a form will be shown for entering new password. Otherwise, a form will be displayed asking user
     * to enter their username or password associated with their account.
     */
    include_once('db_connect.php');
    include_once('links.html');
    include('nav.php');
    $validAuth = false;
    if (array_key_exists('auth', $_GET)) {
        $auth = $_GET['auth'];
        $auth_check = $db->prepare("SELECT * FROM password_reset_auth WHERE auth=?;");
        $auth_check->execute(array($auth));
        if ($auth_check->rowCount() == 0) {
            $_SESSION['invalid_auth'] = true;
            header("Location:password-reset.php");
        }
        $auth_check = $auth_check->fetch();
        $request_time = $auth_check['request_time'];
        $current_time = date('Y-m-d H:i:s');
        $hours = (strtotime($current_time) - strtotime($request_time)) / 3600;
        if ($hours > 2) {
            $_SESSION['invalid_auth'] = true;
            header("Location:password-reset.php");
        }
        $validAuth = true;
    }
    ?>
</head>
<body>
<div class='jumbotron'>
    <?php
    if ($validAuth) {
        printf("<form class='form-horizontal' method='post' action='change-password-auth.php'>\n");
        if (array_key_exists('password_mismatch', $_SESSION)) {
            unset($_SESSION['password_mismatch']);
            printf("<div class='alert alert-danger'> <strong>Password Reset Failed !</strong> Password and Confirm Password " .
                "that you provided do not match. Please try again.</div>\n");
        }
        printf("<input type='hidden' name='auth' value='$auth'>");
        printf("<div class='container' > <label class='control-label'>Enter your new Password.<br><br></label></div>");
        printf("<div class='form-group'>\n");
        printf("<label class='control-label col-sm-2'>Password:</label>\n" .
            "<div class='col-sm-4'>\n" .
            "<input type='password' class='form-control'name='password' placeholder='Password' required>\n");
        printf("</div>\n");
        printf("</div>\n");
        printf("<div class='form-group'>\n");
        printf("<label class='control-label col-sm-2'>Confirm Password:</label>\n" .
            "<div class='col-sm-4'>\n" .
            "<input type='password' class='form-control'name='confirm_password' placeholder='Confirm Password' required>\n");
        printf("</div>\n");
        printf("</div>\n");
        printf("<div class='form-group'>\n");
        printf("<label class='control-label col-sm-2'></label>\n" .
            "<div class='col-sm-4'>\n" .
            "<input type='submit' class='btn btn-default' value='Submit'>\n");
        printf("</div>\n");
        printf("</div>\n");
//        <div class="form-group">
//            <label class="control-label col-sm-2">Professor:</label>
//            <div class="col-sm-4">
    } else {
        printf("<form class='form-horizontal' method='post' action='reset-password-auth.php'>\n");
        if (array_key_exists('no_account', $_SESSION)) {
            unset($_SESSION['no_account']);
            printf("<div class='alert alert-danger'>Account with the given username or email does not exist. Please try again.</div>\n");
        }
        if (array_key_exists('invalid_auth', $_SESSION)) {
            unset($_SESSION['invalid_auth']);
            printf("<div class='alert alert-danger'>The password reset request has either expired or was never initiated." .
                " Please use the form below to request again.</div>\n");
        }
        printf("<label class='control-label' style='margin-left: 30px'>Please enter the username you use to sign in to Rate my Professor" .
            " or the email address assciated with your account.<br><br></label>\n");
        printf("<div class='form-group'>\n");
        printf("<label class='control-label col-sm-2'>Username or Email:</label>\n" .
            "<div class='col-sm-4'>\n" .
            "<input type='text' class='form-control'name='username_or_email' placeholder='Username or Email' required>\n");
        printf("</div>\n");
        printf("</div>\n");
        printf("<div class='form-group'>\n");
        printf("<label class='control-label col-sm-2'></label>\n" .
            "<div class='col-sm-4'>\n" .
            "<input type='submit' class='btn btn-default' value='Submit'>\n");
        printf("</div>\n");
        printf("</div>\n");
    }
    ?>

    </form>
</div>
</body>
</html>

