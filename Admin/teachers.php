<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
$user->isAdmin();
include_once '../includes/header.php';

if(isset($_POST['addTeacher'])) {
  $name = $_POST['teacher_name'];
  $surname = $_POST['teacher_surname'];

  $alias = $_POST['teacher_alias'];


   //This is the directory where images will be saved
   $target = "../dist/img/";
   $target = $target . basename($_FILES['fileToUpload']['name']);

   //This gets all the other information from the form

  $file = ($_FILES['fileToUpload']['name']);

   //Writes the photo to the server
 move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);


  if ($file == NULL){
    $target_file = "../dist/img/avatar5.png";
  }
  else{
    $target_file = $target;
  }

 $teacher->AddTeacher($roleNo, $name, $surname, $alias, $target_file);
  header("Refresh:0");


}


if(isset($_POST['AssignTeacher'])) {

$prof = $_POST['teacher'];
  $classroom = $_POST['classroom'];

  $teacher->assignTeacher($roleNo, $prof, $classroom);

  header("Refresh:0");


}

?>
<body class="hold-transition skin-blue sidebar-mini">



<!--add teacher modal -->
<div class="example-modal">
  <div class="modal fade" id="add_teacher" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add a new Teacher</h4>
        </div>
        <div class="modal-body">
          <form  method="post" enctype="multipart/form-data" >

            <div class="form-group">
              <label for="usr">Teacher name:</label>
              <input class="form-control " type="text" required="required" name="teacher_name">
            </div>

            <div class="form-group">
              <label for="usr">Teacher Surname:</label>
              <input class="form-control " type="text" required="required" name="teacher_surname">
            </div>

            <div class="form-group">
              <label for="usr">Teacher known as:</label>
              <input class="form-control " type="text"  name="teacher_alias">
            </div>



            <div class="form-group">
              <label for="my-file-selector">
                <input class="btn btn-primary" type="file"   name="fileToUpload">

              </label>
            </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="addTeacher">Save changes</button>
        </div>
        </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div><!-- /.example-modal -->




<!--assign teacher to classroom modal -->
<div class="example-modal">
  <div class="modal fade" id="assign_teacher" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Assign a Teacher to a Classroom</h4>
        </div>
        <div class="modal-body">
          <form  method="post"  >


            <div class="form-group">
              <label for="usr">Teacher:</label>
              <select class="form-control" name="teacher">
                <?php
                $teacher->getTeachers($roleNo);
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="usr">Classroom:</label>
              <select class="form-control" name="classroom">
                <?php
                $classroom->getClassroomsName($roleNo);
                ?>
              </select>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" name="AssignTeacher">Assign</button>
        </div>
        </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div><!-- /.example-modal -->





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
      <div class="row">

        <div class="col-lg-4 col-md-4 ">

          <h1>
          Teachers

          </h1>

        </div>

        <div class="col-lg-8 col-md-8 ">

          <div class="right-menu pull-right">
            <!-- Navbar Right Menu -->

            <!-- Application buttons -->
            <div class="">

              <div class="">
<!--
                <a class="btn btn-app">
                  <i class="fa fa-user-plus" data-toggle="modal" data-target="#add_teacher"></i> Add Teacher
                </a>

-->

                <a class="btn btn-app">
                  <i class="fa fa-arrows-h" data-toggle="modal" data-target="#assign_teacher"></i> Assign Teacher To Classroom
                </a>

              </div><!-- /.box-body -->

            </div><!-- /.box -->
          </div><!--breadcrumb-->

        </div>


      </div>
    </section>

        <!-- Main content -->
        <section class="content clearfix">

          <div class="col-md-12 ">

            <!-- USERS LIST -->
            <div class="box box-danger">

              <div class="box-body no-padding">
                <ul class="users-list clearfix">

                  <?php

                  $teacher ->getAllTeachers($roleNo);

                  ?>

                </ul><!-- /.users-list -->
                <br clear="all" />
              </div><!-- /.box-body -->

            </div><!--/.box -->

          </div><!-- /.col -->

          <?php
          if(isset($error))
          {
            ?>
            <div class="alert alert-danger">
              <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
            </div>
            <?php
          }
          ?>

          <?php
          if(isset($success))
          {
            ?>
            <div class="alert alert-success">
              <i class="glyphicon  glyphicon-send"></i> &nbsp; <?php echo $success; ?>
            </div>
            <?php
          }
          ?>
          <!-- Your Page Content Here -->


        </section><!-- /.content -->

</div ><!-- /.content-wrapper -->





  <?php

  include_once '../includes/footer.php';

  ?>




  </body>
</html>
