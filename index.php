<?php
require_once 'includes/dbconfig.php';
  date_default_timezone_set('Europe/Dublin');
  $time=date('Y-m-d H:i:s'); //Storing time in variable
  $max_time_in_seconds = 10; //set max amount of time for attemped logins 600 mean 10 minutes 10*60, 5*60 = 5mins, 60*60 = 1hr, to set to 2hrs change it to 2*60*60
  $max_attempts = 3;
  $condition = "True"; //show login form

if (isset($_POST['btn-login'])) {
    if ($user->login_attempt_count($max_time_in_seconds) <= $max_attempts) {
        if (isset($_POST['txt_uname']) && isset($_POST['txt_password'])) {
            $username = strip_tags($_POST['txt_uname']);
            $upass = strip_tags($_POST['txt_password']);
        }
 
        $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address

        if ($user->login($username, $upass, $ip, $time)) {
            $role = $_SESSION['user_role'];
            $user->redirect("{$role}/index.php");
        }
    } else {
        $_SESSION['error'] = 'Too many login attempts. Please wait '. $max_time_in_seconds.' seconds';
          $condition = "False"; //hide login form
          header("Refresh: $max_time_in_seconds");
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SchoolCloud | Log in</title>
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
        <a href="index.php"><p class="app-logo">School Cloud</p></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
     


          <p class="login-box-msg">Sign in to start your session</p>
          <?php
             $user->show_login_form($condition);

            ?>       
         
    
          <?php
            if (isset($_SESSION['error'])) {
                ?>
                    <div class="alert alert-danger text-center"  style="margin-top:20px;">
                    <?php echo $_SESSION['error']; ?>
                    </div>
                    <?php

                    unset($_SESSION['error']);
            }

            ?> 
  
          <a href="password_reset.php">I forgot my password</a><br>   


      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

<script>
  setTimeout(function() {
    $('#alertdiv').fadeOut('fast');
}, 3000); // <-- time in milliseconds

</script>

  </body>
</html>









