<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
include_once '../includes/header.php';



?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->

      <?php
      include_once 'navbar_left.php';
      include_once 'navbar_right.php';

      ?>


    </nav>
  </header>


  <?php

  include_once '../includes/sidebar.php';

  ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-lg-4 col-md-6  col-xs-6 col-lg-offset-4 col-md-offset-3 col-xs-offset-3 text-center">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="../dist/img/user1-128x128.jpg" alt="User profile picture">
                  <h3 class="profile-username text-center">John Doe</h3>
                  <p class="text-muted text-center">Drogheda</p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Classroom</b> <a class="pull-right">1</a>
                    </li>
                    <li class="list-group-item">
                      <b>Students</b> <a class="pull-right">53</a>
                    </li>

                  </ul>
                  <a href="#" class="btn btn-primary btn-block"><b>Change Details</b></a>

                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">About Me</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-book margin-r-5"></i>  Education</strong>
                  <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                  <p class="text-muted">Malibu, California</p>

                  <hr>

                  <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                  <p>
                    <span class="label label-danger">UI Design</span>
                    <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span>
                  </p>

                  <hr>

                  <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->

          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  <?php

  include_once '../includes/footer.php';

  ?>
  </body>
</html>
