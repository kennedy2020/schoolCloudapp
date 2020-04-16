<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
$user->isAdmin();
include_once '../includes/header.php';

$classroom_id = $_GET['classID'];



if(isset($_POST['AssignTeacher'])) {

    $prof = $_POST['teacher'];
    $class = $_POST['classroom'];


    $teacher->assignTeacher($roleNo, $prof, $class);

    // header("Refresh:0");


}


?>
<body class="hold-transition skin-blue sidebar-mini">
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
     <div class="row">

          <div class="col-lg-4 col-md-4 ">

              <h1>
                  <?php
                  $classroom->getClassroomName($roleNo, $classroom_id);

                  ?>

              </h1>

          </div>

         <div class="col-lg-8 col-md-8 ">

             <div class="right-menu pull-right">
                 <!-- Navbar Right Menu -->
                 <div class="navbar-custom-menu" id="classroom_menu">
                     <ul class="nav navbar-nav">
                         <!-- Messages: style can be found in dropdown.less-->
                         <li class="dropdown messages-menu">
                             <!-- Menu toggle button -->
                             <a href="#" class="dropdown-toggle" >

                                 <span data-toggle="tooltip"  data-original-title="Hot Link">  <i class="fa fa-envelope-o"></i></span>

                                 <span class="label label-success">4</span>
                             </a>

                         </li><!-- /.messages-menu -->

                         <!-- Notifications Menu -->
                         <li class="dropdown notifications-menu">
                             <!-- Menu toggle button -->
                             <a href="ClassroomCalendar.php?classroomID=<?php echo $classroom_id; ?>" class="dropdown-toggle" >

                                 <span data-toggle="tooltip"  data-original-title="Class Calendar">  <i class="fa fa-calendar"></i></span>


                             </a>

                         </li>


                         <!-- Notifications: style can be found in dropdown.less -->
                         <li class="dropdown notifications-menu">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                 <span data-toggle="tooltip"  data-original-title="News">  <i class="fa fa-bell-o"></i></span>

                                 <span class="label label-warning">10</span>
                             </a>
                         </li>


                         <!-- Notifications Menu -->
                         <li class="dropdown notifications-menu">
                             <!-- Menu toggle button -->
                             <a href="#" class="dropdown-toggle" >
                                 <span data-toggle="tooltip"  data-original-title="Homework"><i class="fa fa-book"></i></span>


                             </a>

                         </li>


                         <!-- Notifications Menu -->
                         <li class="dropdown notifications-menu">
                             <!-- Menu toggle button -->
                             <a href="#" class="dropdown-toggle" >
                                 <span data-toggle="tooltip"  data-original-title="Today Photo"> <i class="fa fa-photo"></i></span>



                             </a>

                         </li>



                         <!-- Notifications Menu -->
                         <li class="dropdown notifications-menu">
                             <!-- Menu toggle button -->
                             <a href="#" class="dropdown-toggle">

                                 <span data-toggle="tooltip"  data-original-title="eCard">  <i class="fa fa-birthday-cake"></i></span>

                             </a>

                         </li>


                     </ul>
                 </div>
             </div><!--breadcrumb-->

         </div>


     </div>


    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">


          <div class="box box-danger">

            <div class="box-body">

              <div class="row">
                <div class="col-lg-12 col-lg-offset-4 col-md-offset-4 col-xs-offset-4 text-center">
                  <ul class="users-list clearfix">
                    <li>
                        <?php
                        $teacher ->getTeachersPicture($roleNo, $classroom_id);
                        ?>




                    </li>
                    </ul>
                  </div>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Second Name</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Attendance</th>

                </tr>
                </thead>
                <tbody>

                <?php
                $classroom->getClassroomStudents($roleNo, $classroom_id);
                ?>

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
