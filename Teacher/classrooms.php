<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
include_once 'header.php';

if(isset($_POST['add_classroom'])){
  $class_name= $_POST['classroom_name'];

  $classroom ->addClassroom($roleNo, $class_name);
  header("Refresh:0");
}


?>
<body class="hold-transition skin-blue sidebar-mini">


<!--add classroom modal -->
<div class="example-modal">
  <div class="modal fade " id="add_classroom">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add a Classroom</h4>
        </div>
        <div class="modal-body">
          <form name="alias" method="post">

            <div class="form-group">
              <label for="usr">Name of classroom:</label>
              <input class="form-control " type="text" required="required" name="classroom_name">
            </div>



            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" name="add_classroom">Save changes</button>
            </div>
          </form>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </div>
  <!-- /.example-modal -->

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

  include_once 'sidebar.php';

  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">

        <div class="col-lg-4 col-md-4 ">

          <h1>
           Classrooms

          </h1>

        </div>

        <div class="col-lg-8 col-md-8 ">

          <div class="right-menu pull-right">
            <!-- Navbar Right Menu -->

            <!-- Application buttons -->
            <div class="">

              <div class="">

                <a class="btn btn-app">
                  <i class="fa fa-book" data-toggle="modal" data-target="#add_classroom"></i> Add a Classroom
                </a>




              </div><!-- /.box-body -->

            </div><!-- /.box -->
          </div><!--breadcrumb-->

        </div>


      </div>
    </section>
        <!-- Main content -->
        <section class="content">
<div class="row">

  <?php


    $classroom->getClassrooms($roleNo);


  ?>





</div><!--row-->




          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->







    <?php

  include_once 'footer.php';

  ?>
  </body>
</html>
