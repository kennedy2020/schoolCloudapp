<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();
include_once 'header.php';


if(isset($_POST['pupil_add'])){
    $name = $_POST['pupil_name'];
    $surname = $_POST['pupil_surname'];
    $DOB = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
    $gender = $_POST['pupil_gender'];
    $classroom = $_POST['pupil_classroom'];
    $pupil->pupilAdd($roleNo, $name, $surname, $DOB, $gender, $classroom);
    header("Refresh:0");
}

if(isset($_POST['pupil_delete'])){
    $id= $_POST['id'];

    $pupil ->pupilDelete($roleNo, $id);
    header("Refresh:0");
}

if(isset($_POST['pupil_edit'])){
    $name = $_POST['pupil_name'];
    $surname = $_POST['pupil_surname'];
    $DOB = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
    $gender = $_POST['pupil_gender'];
    $classroom = $_POST['pupil_classroom'];
    $id= $_POST['id'];
    $pupil ->pupilEdit($roleNo, $id, $name, $surname, $DOB, $gender, $classroom);
    header("Refresh:0");
}



?>

<body class="hold-transition skin-blue sidebar-mini">

<!--edit pupil details modal -->
<div class="example-modal">
    <div class="modal fade" id="pupil_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit pupil's details</h4>
                </div>
                <div class="modal-body">
                    <form name="alias" method="post">

                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input class="form-control " type="text" required="required" name="pupil_name">
                        </div>

                        <div class="form-group">
                            <label for="usr">Surname:</label>
                            <input class="form-control " type="text" required="required" name="pupil_surname">
                        </div>
                        <input type="hidden" name="id" value="" id="pupilId"/>

                        <div class="form-group">
                            <label>DOB:</label>
                            <div class="input-group">
                                <?php make_calendar_pulldowns(); ?>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->


                        <div class="form-group">
                            <label>Gender:</label>
                            <select class="form-control" name="pupil_gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="usr">Classroom:</label>
                            <select class="form-control" name="pupil_classroom">
                                <?php
                                $classroom->getClassroomsName($roleNo);
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" name="pupil_edit">Save changes</button>
                        </div>
                        <input type="hidden" name="id" value=""/>

                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- /.example-modal -->



    <!--add pupil modal -->
    <div class="example-modal">
        <div class="modal fade " id="pupil_add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add pupil</h4>
                    </div>
                    <div class="modal-body">
                        <form name="alias" method="post">

                            <div class="form-group">
                                <label for="usr">Name:</label>
                                <input class="form-control " type="text" required="required" name="pupil_name">
                            </div>

                            <div class="form-group">
                                <label for="usr">Surname:</label>
                                <input class="form-control " type="text" required="required" name="pupil_surname">
                            </div>




                            <div class="form-group">
                                <label>DOB:</label>
                                <div class="input-group">
                                    <?php make_calendar_pulldowns(); ?>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->


                            <div class="form-group">
                                <label>Gender:</label>
                                <select class="form-control" name="pupil_gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="usr">Classroom:</label>
                                <select class="form-control" name="pupil_classroom">
                                    <?php
                                    $classroom->getClassroomsName($roleNo);
                                    ?>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" name="pupil_add">Save changes</button>
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







        <div class="modal fade  modal-danger" id="pupil_delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                        <h4 class="modal-title custom_align" id="Heading">Delete</h4>
                    </div>
                    <div class="modal-body">
                        <form class="" name="commentform" method="post" >
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>  Are you sure you want to delete the selected pupil?</div>
                            <input type="hidden" name="id" value="" id="pupilId"/>
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
                       All Pupils in School

                    </h1>

                </div>

                <div class="col-lg-8 col-md-8 ">

                    <div class="right-menu pull-right">
                        <!-- Navbar Right Menu -->

                        <!-- Application buttons -->
                        <div class="">

                            <div class="">

                                <a class="btn btn-app" data-toggle="modal"
                                   data-target="#pupil_add">
                                    <i class="fa fa-user-plus"></i> Add Pupil
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
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>Classroom</th>
                                    <th>Edit / Delete</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $pupil->get_pupils($roleNo);

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
            <?php
            function make_calendar_pulldowns() {

            // Make the months array:
            $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');



            // Make the days pull-down menu:
            echo '<select required="required" name="day" id="day" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
                echo '<option selected value="">Day</option>\n';
                for ($day = 1; $day <= 31; $day++) {
                echo "<option value=\"$day\">$day</option>\n";
                }
                echo '</select>';


// Make the months pull-down menu:
                //echo '<p><label for="dob" style="font-family: Verdana, Arial; font-size: 1.0em; font-weight: 600; color: #595959; line-height: 1.9em;">Date of Birth</label></p>';
                echo '<select required="required" name="month" id="month" style="width: 33%; display: inline; float: left; margin-left: 1%; margin-right: 0%">';
                echo '<option selected value="">Month</option>\n';
                foreach ($months as $key => $value) {
                    echo "<option value=\"$key\" >$value</option>\n";
                }
                echo '</select>';


            // Make the years pull-down menu:
            echo '<select required="required" name="year" id="year" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
                echo '<option selected value="">Year</option>\n';
                for ($year = 1980; $year <= 2015; $year++) {
                echo "<option value=\"$year\">$year</option>\n";
                }
                echo '</select>';
            }
?>
</body>
</html>
