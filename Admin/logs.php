<?php require_once '../includes/dbconfig.php';
$user->is_loggedin();
 $user->isAdmin();
  include_once '../includes/header.php';

  if (isset($_POST['log_delete'])) {

    $id = $_POST['id'];
    $logs->log_delete($id);
    header("Refresh:0");

}




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
                <?php include_once '../includes/navbar_left.php'; include_once '../includes/navbar_right.php'; ?>
            </nav>
        </header>

        <?php include_once( "../includes/sidebar.php"); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="row">

                    <div class="col-lg-4 col-md-4 ">

                        <h1>
                        Logs

                    </h1>

                    </div>

                    <div class="col-lg-8 col-md-8 ">

                        <div class="right-menu pull-right">
                            <!-- Navbar Right Menu -->

                            <!-- Application buttons -->
                            <div class="">

                                <div class="">
                                <form class="" name="downloadForm" method="post" action="export_logs.php">
                                
                                    <button type="submit" value="Submit" name="download" class="btn btn-success"><i class="fa fa-download"></i> Download Logs</button>
                                </form>
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
                                            <th>IP</th>
                                            <th>Date / Time</th>
                                            <th>Username</th>
                                            <th>Action taken</th>

                                            <th>Edit / Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $logs->get_logs(); ?>

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

        <?php include_once '../includes/footer.php'; ?>
        <!-- page script -->
       
            <!--delete user modal-->

            <div class="modal fade  modal-danger" id="log_delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                            <h4 class="modal-title custom_align" id="Heading">Delete</h4>
                        </div>
                        <div class="modal-body">
                            <form class="" name="commentform" method="post">
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete the selected log?</div>
                                <input type="hidden" name="id" value="" />
                        </div>
                        <div class="modal-footer ">
                            <button type="submit" value="Submit" name="log_delete" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                            </form>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                    </div>


                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


        

            <script>
                $(function() {
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
         

             

            <script type="text/javascript">
                $('#log_delete').on('show.bs.modal', function(e) {
                    var Id = $(e.relatedTarget).data('id');
                    $(e.currentTarget).find('input[name="id"]').val(Id);


                });
            </script>
           
</body>

</html>