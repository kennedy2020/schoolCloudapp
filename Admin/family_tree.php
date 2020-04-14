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
      include_once '../includes/navbar_left.php';
      include_once '../includes/navbar_right.php';

      ?>


    </nav>
  </header>


  <?php

  include_once '../includes/sidebar.php';

  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Students

      </h1>
      <ol class="breadcrumb">
        <li><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Students</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-lg-12">

          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active" >
              <h3 class="widget-user-username">John Doe</h3>
              <h5 class="widget-user-desc">Classroom 1</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="../dist/img/user1-128x128.jpg" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">DOB</h5>
                    <span class="description-text">01/01/2001</span>
                  </div><!-- /.description-block -->
                </div><!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">Gender</h5>
                    <span class="description-text">Male</span>
                  </div><!-- /.description-block -->
                </div><!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">Start Date</h5>
                    <span class="description-text">25/10/2015</span>
                  </div><!-- /.description-block -->
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div>
          </div><!-- /.widget-user -->
        </div><!-- /.col -->
        <div class="col-xs-12">


          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Family Details for John Doe</h3>
            </div><!-- /.box-header -->
            <div class="box-body ">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Second Name</th>
                  <th>Relation</th>
                  <th>Contact No</th>
                  <th>Email</th>
                  <th>Primary</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>John</td>
                  <td>Doe</td>
                  <td>MOM</td>
                  <td>04198546455</td>
                  <td>mom@example.com</td>
                  <td><div class="radio">
                    <label>
                      <input type="radio" checked="checked" >
                    </label>
                  </div></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>John</td>
                  <td>Doe</td>
                  <td>DAD</td>
                  <td>04124556885</td>
                  <td>dad@example.com</td>
                  <td><div class="radio">
                    <label>
                      <input type="radio">
                    </label>
                  </div></td>
                </tr>


                </tfoot>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php

  include_once '../includes/footer.php';

  ?>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
</body>
</html>
