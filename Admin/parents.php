
<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
$user->isAdmin();
include_once '../includes/header.php';

if(isset($_POST['addParent'])){
    $name = $_POST['parent_name'];
    $surname = $_POST['parent_surname'];
    $parentID =  $_POST['id'];
    if (isset($_POST['primary'])) {

        // Checkbox is selected
        $primary = 1;
    }
    else{
        $primary = 0;
    }
    $parent_contactNo = $_POST['parent_contactNo'];
    $email = $_POST['parent_email'];

  $parents->AddParent($parentID, $roleNo, $name, $surname, $primary, $parent_contactNo, $email);
  header("Refresh:0");



}


if (isset($_POST['AssignPupil'])) {

    $pupilID = $_POST['pupils'];
    $parentID =  $_POST['id'];


   $pupil->AssignPupilToFamily($roleNo, $pupilID, $parentID);
  header("Refresh:0");

}


?>
<body class="hold-transition skin-blue sidebar-mini">

<!--add parent modal -->
<div class="example-modal">
    <div class="modal fade " id="add_parent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add a parent</h4>
                </div>
                <div class="modal-body">
                    <form name="alias" method="post">

                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input class="form-control " type="text" required="required" name="parent_name">
                        </div>

                        <div class="form-group">
                            <label for="usr">Surname:</label>
                            <input class="form-control " type="text" required="required" name="parent_surname">
                        </div>


                        <div class="form-group">
                            <label>Primary Parent:</label>
                            <input type="checkbox" value="1" name="primary">
                        </div>

                        <div class="form-group">
                            <label for="usr">Contact No:</label>
                            <input class="form-control " type="number"  min="0" max="9999999999" required="required" name="parent_contactNo">
                        </div>

                        <div class="form-group">
                            <label for="usr">Parent Email:</label>
                            <input class="form-control " type="email" required="required" name="parent_email">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="addParent">Add Parent</button>
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

    <!--assign pupil to family modal -->
    <div class="example-modal">
        <div class="modal fade " id="assign_pupil">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add a pupil to family</h4>
                    </div>
                    <div class="modal-body">
                        <form name="alias" method="post">

                            <div class="form-group">
                                <label for="usr">Classroom:</label>
                                <select class="form-control" name="pupils">
                                    <?php
                                    $pupil->getPupils($roleNo);
                                    ?>
                                </select>
                            </div>

                            <input type="hidden" name="id" value="" id="ParentId"/>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="AssignPupil">Add</button>
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
            <?php
            include_once '../includes/navbar_left.php';
            include_once '../includes/navbar_right.php';

            ?>
        </nav>
    </header>

    <?php

    include_once("../includes/sidebar.php");


    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">

                <div class="col-lg-4 col-md-4 ">

                    <h1>
                        Parents / Guardians

                    </h1>

                </div>

                <div class="col-lg-8 col-md-8 ">

                    <div class="right-menu pull-right">
                        <!-- Navbar Right Menu -->

                        <!-- Application buttons -->
                        <div class="">

                            <div class="">
<!--
                                <a class="btn btn-app" data-toggle="modal"
                                   data-target="#add_parent">
                                    <i class="fa fa-user-plus"></i> Add Parent / Guardian
                                </a>
-->
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

                        <div class="box-body ">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>

                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Primary</th>

                                    <th>Contact No.</th>
                                    <th>Email</th>
                                    <th>Edit / Delete / View Family</th>
                                </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $parents->getAllParents($roleNo);

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
<!-- page script -->
            <script type="text/javascript">
                $('#assign_pupil').on('show.bs.modal', function(e) {
                    var Id = $(e.relatedTarget).data('id');
                    $(e.currentTarget).find('input[name="id"]').val(Id);


                });
            </script>
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
