<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
include_once 'header.php';


if(isset($_POST['addUser'])){
    $name = $_POST['user_name'];
    $surname = $_POST['user_surname'];
    $status = $_POST['status'];
    $email = $_POST['user_email'];
    $password = md5($_POST['UserPassword']);

    $user->addUser($roleNo, $name, $surname, $status, $email, $password);

    $last_inserted_id = $user->getLastUser($roleNo, $email, $status);
    //echo $last;

     if($status =="Parent"){

$primary = 0;
         $parent_contactNo = Null;
      $parents->AddParent($last_inserted_id, $roleNo, $name, $surname, $primary, $parent_contactNo, $email);


    }
    else if($status =="Teacher")
    {
        $alias = NULL;
       $photo = "../dist/img/avatar5.png";

      $teacher->AddTeacher($last_inserted_id, $roleNo, $name, $surname, $alias, $photo);

    }




  //  header("Refresh:0");
}





?>

<body class="hold-transition skin-blue sidebar-mini">



    <!--add users modal -->
    <div class="example-modal">
        <div class="modal fade " id="user_add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add a new User</h4>
                    </div>
                    <div class="modal-body">
                        <form name="alias" method="post">

                            <div class="form-group">
                                <label for="usr">Name:</label>
                                <input class="form-control " type="text" required="required" name="user_name">
                            </div>

                            <div class="form-group">
                                <label for="usr">Surname:</label>
                                <input class="form-control " type="text" required="required" name="user_surname">
                            </div>

                            <div class="form-group">
                                <label for="usr">Email:</label>
                                <input class="form-control " type="email" required="required" name="user_email">
                            </div>

                            <div class="form-group">
                                <label for="usr">Password:</label>
                                <input class="form-control" type="password" name="UserPassword" required="required" value="" />

                                <div class="pwstrength_viewport_progress"></div>
                            </div>

                            <div class="form-group">
                                <label for="usr">Status:</label>
                                <select class="form-control" name="status">
                                    <option value="Parent">Parent</option>
                                    <option value="Teacher">Teacher</option>
                                </select>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="addUser">Add User</button>
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





        <!--delete user modal-->

        <div class="modal fade  modal-danger" id="users_delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Delete</h4>
                    </div>
                    <div class="modal-body">
                        <form class="" name="commentform" method="post" >
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>  Are you sure you want to delete the selected pupil?</div>
                            <input type="hidden" name="id" value="" />
                    </div>
                    <div class="modal-footer ">
                        <button type="submit" value="Submit" name = "pupil_delete" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                    </div>
                </div>


                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
            <?php
            include_once 'navbar_left.php';
            include_once 'navbar_right.php';

            ?>
        </nav>
    </header>

    <?php

    include_once("sidebar.php");


    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">

                <div class="col-lg-4 col-md-4 ">

                    <h1>
                        All Users

                    </h1>

                </div>

                <div class="col-lg-8 col-md-8 ">

                    <div class="right-menu pull-right">
                        <!-- Navbar Right Menu -->

                        <!-- Application buttons -->
                        <div class="">

                            <div class="">

                                <a class="btn btn-app" data-toggle="modal"
                                   data-target="#user_add">
                                    <i class="fa fa-user-plus"></i> Add User
                                </a>

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!--breadcrumb-->

                </div>


            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">


                    <div class="box box-danger">

                        <!-- /.box-header -->
                        <div class="box-body ">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Second Name</th>
                                    <th>Email</th>
                                    <th>Status</th>

                                    <th>Edit / Delete</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $user->getUsers($roleNo);

                                ?>

                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->






        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->









            <?php

            include_once 'footer.php';

            ?>
            <!-- page script -->

    <script src="../dist/js/password2.js"></script>

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



                // $('#dp2').datepicker()

            </script>

            <script type="text/javascript">
                $('#pupil_delete').on('show.bs.modal', function(e) {
                    var Id = $(e.relatedTarget).data('id');
                    $(e.currentTarget).find('input[name="id"]').val(Id);


                });
            </script>
            <script type="text/javascript">
                $('#pupil_edit').on('show.bs.modal', function(e) {
                    var Id = $(e.relatedTarget).data('id');
                    $(e.currentTarget).find('input[name="id"]').val(Id);


                });
            </script>

</body>
</html>
