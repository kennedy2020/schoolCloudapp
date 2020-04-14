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
          <span class="logo-lg"><b>Teacher</b></span>
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


        <!-- Main content -->
        <section class="content">








          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">


              <!-- Chat box -->
              <div class="box box-warning">
                <div class="box-header">
                  <i class="fa fa-comments-o"></i>
                  <h3 class="box-title">Hot Items</h3>

                </div>
                <div class="box-body chat" id="chat-box">

                  <?php
                $classroom_id = $classroom->getClassroomId($roleNo, $id);
                $hot_link->showHotPointT($roleNo, 0,  $classroom_id);
                  ?>




                </div><!-- /.chat -->

              </div><!-- /.box (chat box) -->





            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">




              <!-- Calendar -->
              <div class="box box-solid bg-green-gradient">
                <div class="box-header">
                  <i class="fa fa-calendar"></i>
                  <h3 class="box-title">Calendar</h3>
                  <!-- tools box -->
                  <div class="pull-right box-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                      <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                      <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="#">Add new event</a></li>
                        <li><a href="#">Clear events</a></li>
                        <li class="divider"></li>
                        <li><a href="#">View calendar</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <!--The calendar -->
                  <div id="calendar" style="width: 100%"></div>
                </div><!-- /.box-body -->


            </section><!-- right col -->





            <div class="col-md-12">

              <!-- Box Comment -->
              <div class="box  box-info"">
              <div class='box-header with-border'>
                <div class='user-block'>

                  <?php
                  $school->schoolLogoNews($roleNo);
                  ?>

                  <span class='username'><a href="#">School Latest News</a></span>
                  <h4><?php $school->getDetails($roleNo, 'SchoolName') ?></h4>
                </div><!-- /.user-block -->
                <div class='box-tools'>

                  <button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                  <button class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button>
                </div><!-- /.box-tools -->
              </div><!-- /.box-header -->

              <?php
              $news->getLatestNews($roleNo);

              ?>



            </div><!-- /.box -->
          </div><!-- /.col -->
      </div><!-- /.row -->






    </div><!-- /.row (main row) -->




          <!-- Your Page Content Here -->

        </section><!-- /.content -->




    <?php

  include_once '../includes/footer.php';

    ?>

  </body>
</html>
