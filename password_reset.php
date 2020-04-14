<?php require_once 'includes/dbconfig.php'; //$user->is_loggedin(); include_once 'includes/header.php'; if (isset($_POST['btn-reset'])) { $email = $_POST['user_email']; $user->checkEmailofuser($email); } ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SchoolCloud</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- custom css-->
    <link rel="stylesheet" href="custom/custom_style.css">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">
                <p class="app-logo">School Cloud</p>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">

            <p class="login-box-msg">Password Reset</p>
            <form method="post">
                <div class="form-group">
                    <label for="usr">Your email address:</label>
                    <input class="form-control " type="email" required="required" name="user_email">
                </div>
                <div class="row">
                    <div class="col-xs-8">

                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-reset">Reset</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


            <?php if (isset($_SESSION[ 'error'])) { ?>
            <div class="alert alert-danger text-center" style="margin-top:20px;" id="alertdiv">
                <?php echo $_SESSION[ 'error']; ?>
            </div>
            <?php unset($_SESSION[ 'error']); } else if (isset($_SESSION[ 'success'])) { ?>
            <div class="alert alert-success text-center" style="margin-top:20px;" id="alertdiv">
                <?php echo $_SESSION[ 'success']; ?>
            </div>
            <?php unset($_SESSION[ 'success']); } ?>



        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script>
        setTimeout(function() {
            $('#alertdiv').fadeOut('fast');
        }, 3000); // <-- time in milliseconds
    </script>
</body>

</html>