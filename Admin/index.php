<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
$user->isAdmin();

include_once '../includes/header.php';

if (isset($_POST['publishNews'])){
  $message = $_POST['message'];
  $start = $_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day'];
  $end =   $_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day'];

  $news ->setLatestNews($roleNo, $message, $start, $end);
}

?>

  <body class="hold-transition skin-blue sidebar-mini">

  <!--add news modal -->
  <div class="example-modal">
    <div class="modal fade " id="addNews">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add News</h4>
          </div>
          <div class="modal-body">
            <form  method="post">

              <div class="form-group">
                <label for="usr">News:</label>
                <textarea class="form-control" rows="10" style="resize: none;" placeholder="Please enter your news here..." maxlength="255" name="message" required="required"></textarea>
              </div>

              <div class="form-group">
                <label>Start Date:</label>
                <div class="input-group">
                  <?php make_calendar_pulldownsStart(); ?>
                </div><!-- /.input group -->
              </div><!-- /.form group -->

              <div class="form-group">
                <label>End Date:</label>
                <div class="input-group">
                  <?php make_calendar_pulldownsEnd(); ?>
                </div><!-- /.input group -->
              </div><!-- /.form group -->

              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" name="publishNews">Publish</button>
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
</div>


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


        <!-- Main content -->
        <section class="content">

          <!-- Small boxes (Stat box) -->
          <div class="row">


            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <a href="classrooms.php">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Classrooms</h3>

                </div>
                <div class="icon">
                  <p class="icon-info"></p>
                </div>
                <p class="small-box-footer"></p>
              </div>
                </a>
            </div><!-- ./col -->



            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <a href="teachers.php">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>Teachers</h3>

                </div>
                <div class="icon">
                  <p  class="icon-teachers"></p>
                </div>
                <p class="small-box-footer"></p>
              </div>
                </a>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <a href="parents.php">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>Parents</h3>

                </div>
                <div class="icon">
                  <p class="icon-parents"></p>

                </div>
                <p class="small-box-footer"></p>
              </div>
              </a>
            </div><!-- ./col -->



            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <a href="students.php">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>Pupils</h3>

                </div>
                <div class="icon">
                  <p class="icon-pupils"></p>
                </div>
                <p class="small-box-footer"></p>
              </div>
                </a>
            </div><!-- ./col -->

          </div><!-- /.row -->





          <div class="row">


            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <a href="school_profile.php">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>School Info</h3>

                  </div>
                  <div class="icon">
                    <p class="icon-info"></p>
                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </a>
            </div><!-- ./col -->


            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <a href="users.php">
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>Users</h3>

                  </div>
                  <div class="icon">
                    <p class="icon-parents"></p>

                  </div>
                  <p class="small-box-footer"></p>
                </div>
              </a>
            </div><!-- ./col -->


          </div><!-- /.row -->


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

                    $hot_link->showHotPointA($roleNo, 0);
                  ?>




                </div><!-- /.chat -->

              </div><!-- /.box (chat box) -->





            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">




              


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

                <div class="box-footer">
                  <a class="btn btn-app pull-right" data-toggle="modal"
                     data-target="#addNews">
                    <i class="fa fa-newspaper-o"></i> Add News
                  </a>

                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->





          </div><!-- /.row (main row) -->




          <!-- Your Page Content Here -->

        </section><!-- /.content -->




    <?php

  include_once '../includes/footer.php';

    ?>

    <?php
    function make_calendar_pulldownsStart() {

      // Make the months array:
      $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');



      // Make the days pull-down menu:
      echo '<select required="required" name="start_day" id="day" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Day</option>\n';
      for ($day = 1; $day <= 31; $day++) {
        echo "<option value=\"$day\">$day</option>\n";
      }
      echo '</select>';


// Make the months pull-down menu:
      //echo '<p><label for="dob" style="font-family: Verdana, Arial; font-size: 1.0em; font-weight: 600; color: #595959; line-height: 1.9em;">Date of Birth</label></p>';
      echo '<select required="required" name="start_month" id="month" style="width: 33%; display: inline; float: left; margin-left: 1%; margin-right: 0%">';
      echo '<option selected value="">Month</option>\n';
      foreach ($months as $key => $value) {
        echo "<option value=\"$key\" >$value</option>\n";
      }
      echo '</select>';


      // Make the years pull-down menu:
      echo '<select required="required" name="start_year" id="year" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Year</option>\n';
      for ($year = 2015; $year <= 2030; $year++) {
        echo "<option value=\"$year\">$year</option>\n";
      }
      echo '</select>';
    }


    function make_calendar_pulldownsEnd() {

      // Make the months array:
      $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');



      // Make the days pull-down menu:
      echo '<select required="required" name="end_day" id="day" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Day</option>\n';
      for ($day = 1; $day <= 31; $day++) {
        echo "<option value=\"$day\">$day</option>\n";
      }
      echo '</select>';


// Make the months pull-down menu:
      //echo '<p><label for="dob" style="font-family: Verdana, Arial; font-size: 1.0em; font-weight: 600; color: #595959; line-height: 1.9em;">Date of Birth</label></p>';
      echo '<select required="required" name="end_month" id="month" style="width: 33%; display: inline; float: left; margin-left: 1%; margin-right: 0%">';
      echo '<option selected value="">Month</option>\n';
      foreach ($months as $key => $value) {
        echo "<option value=\"$key\" >$value</option>\n";
      }
      echo '</select>';


      // Make the years pull-down menu:
      echo '<select required="required" name="end_year" id="year" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Year</option>\n';
      for ($year = 2015; $year <= 2030; $year++) {
        echo "<option value=\"$year\">$year</option>\n";
      }
      echo '</select>';
    }



    ?>

  </body>
</html>
