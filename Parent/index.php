<?php /** * Created by PhpStorm. * User: Danny * Date: 25/11/15 * Time: 11:28 PM */ ?>

<?php
require_once '../includes/dbconfig.php';
$user->is_loggedin();
$user->isParent();
$id = $_SESSION['user_session'];
if (isset($_POST['submitForm'])) {
	$studentid = $_POST['student_id'];
	$message = strip_tags($_POST['contact']);
	$email = $_SESSION['email'];
	if (isset($_POST['attend'])) {
		$attendance = 0;
	} else {
		$attendance = 1;
    }
   
    $studentid = '1';
    $message = 'test';
    $email = 'email@test.ie';

	if ($hot_link->send_message($studentid, $message, $email)) {
     // 
		$user->redirect("index.php");
		$success = "Your message was sent successfully !";
	} else {
		$error = "There was an error sending your message !";
	}
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SchoolCloud | Parents</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
                                                          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
-->
    <!-- custom css-->
    <link rel="stylesheet" href="../custom/custom_style.css">

    <link rel="stylesheet" href="../dist/css/skins/skin-green.min.css">
    <!-- Date Picker -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->

<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>dm</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Parents</b></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->

                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- Notifications Menu -->
                        <li class="dropdown notifications-menu">
                            <!-- Menu toggle button -->
                            <a href="#" title="Settings">

                                <i class="fa fa-gears"></i>

                            </a>

                        </li>

                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="../logout.php?logout=true" title="Log Out">
                                <i class="fa fa-sign-out"></i>

                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="logo">
                        <?php $school ->schoolLogo($roleNo); ?>
                    </div>

                </div>

                <!-- Sidebar Menu -->
                <?php $school ->schoolName($roleNo); ?>

                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">

                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><span class="red big">Hot</span><span class="blue big">Point</span></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form method="post">
                            <div class="box-body">

                                <!-- select -->
                                <div class="groupform-">
                                    <label>Please select your child's name:</label>
                                    <select class="form-control" name="student_id">
                                        <?php $hot_link ->get_pupil($id); ?>

                                    </select>
                                </div>
  
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Contact the School</label>

                                    <textarea class="form-control" rows="10" style="resize: none;" placeholder="Please enter your message here..." maxlength="255" name="contact" required="required"></textarea>
                                </div>

                                <!--
                                                  <div class="form-group ">
                                                 <label>
                                                    <input type="checkbox" name="attend"> Please tick this box if your child will not attend school tomorrow.
                                                    </label>
                                                 </div>

-->

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right" name="submitForm">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                    <?php if(isset($error)) { ?>
                    <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp;
                        <?php echo $error; ?>
                    </div>
                    <?php } ?>

                    <?php if(isset($success)) { ?>
                    <div class="alert alert-success">
                        <i class="glyphicon  glyphicon-send"></i> &nbsp;
                        <?php echo $success; ?>
                    </div>
                    <?php } ?>

                </div>
                <!-- /.row -->

        </div>
        <!-- /.row (main row) -->

        <!-- Your Page Content Here -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            All rights reserved.
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2020 Daniel Chende</strong>
    </footer>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
</body>

</html>