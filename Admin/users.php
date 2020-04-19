<?php require_once '../includes/dbconfig.php';
 $user->is_loggedin();
 $user->isAdmin();
  include_once '../includes/header.php';
  if (isset($_POST['addUser'])) {
    $name = strip_tags($_POST['user_name']);
    $surname = strip_tags($_POST['user_surname']);
    $username = strip_tags($_POST['username']);
    $status = strip_tags($_POST['status']);
    $email = filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL);
    $password = strip_tags($_POST['UserPassword']);
    $repeatPassword = strip_tags($_POST['RepeatPassword']);
    if (($password == $repeatPassword) || (strlen($password) > 12)) {
        $hashedpassword = password_hash($password, PASSWORD_ARGON2I);
        $user -> addUser($roleNo, $name, $surname, $username, $status, $email, $hashedpassword);
        $last_inserted_id = $user -> getLastUser($roleNo, $email, $status);
        if ($status == "Parent") {
            $primary = 0;
            $parent_contactNo = Null;
            $parents -> AddParent($last_inserted_id, $roleNo, $name, $surname, $primary, $parent_contactNo, $email);
        } else if ($status == "Teacher") {
            $alias = NULL;
            $photo = "../dist/img/avatar5.png";
            $teacher -> AddTeacher($last_inserted_id, $roleNo, $name, $surname, $alias, $photo);
        }
        header("Refresh:0");
    }
}


if (isset($_POST['user_delete'])) {

    $id = $_POST['id'];
    $user->DeleteUser($id);
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
                        All Users

                    </h1>

                    </div>

                    <div class="col-lg-8 col-md-8 ">

                        <div class="right-menu pull-right">
                            <!-- Navbar Right Menu -->

                            <!-- Application buttons -->
                            <div class="">

                                <div class="">

                                    <a class="btn btn-app" data-toggle="modal" data-target="#user_add">
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
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Status</th>

                                            <th>Edit / Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $user->getUsers($roleNo); ?>

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
        <!-- Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="memberModalLabel">Edit User Details</h4>
                    </div>
                    <div class="ct">

                    </div>

                </div>
            </div>
        </div>


        <!--add users modal -->
        <div class="example-modal">
            <div class="modal fade " id="user_add">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
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
                                    <label for="usr">Username:</label>
                                    <input class="form-control " type="text" required="required" name="username">
                                </div>

                                <div class="form-group">
                                    <label for="usr">Email:</label>
                                    <input class="form-control " type="email" required="required" name="user_email">
                                </div>

                                <div class="form-group">
                                    <label for="usr">Password:</label>
                                    <input class="form-control" type="password" id="UserPassword" name="UserPassword" required="required" value="" />

                                    <div class="pwstrength_viewport_progress"></div>
                                </div>
                                <div class="form-group">
                                    <label for="usr">Repeat Password:</label>
                                    <input class="form-control" type="password" name="RepeatPassword" required="required" id="RepeatPassword" value="" onChange="checkPasswordMatch();" />


                                    <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                                    <div class="registrationFormAlert" id="divCheckPasswordLength"></div>
                                </div>

                                <div class="form-group">
                                    <label for="usr">Status:</label>
                                    <select class="form-control" name="status">
                                        <option value="Parent">Parent</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Teacher">Admin</option>
                                    </select>
                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                    <button type="submit" id="submitBtn" class="btn btn-success" name="addUser">Add User</button>
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

            <div class="modal fade  modal-danger" id="user_delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                            <h4 class="modal-title custom_align" id="Heading">Delete</h4>
                        </div>
                        <div class="modal-body">
                            <form class="" name="commentform" method="post">
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete the selected user?</div>
                                <input type="hidden" name="id" value="" />
                        </div>
                        <div class="modal-footer ">
                            <button type="submit" value="Submit" name="user_delete" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
                            </form>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                    </div>


                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


            <!-- check password strenght -->

            <script src="../dist/js/password2.js"></script>

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



                // $('#dp2').datepicker()
            </script>

            <!-- check if passwords match-->

            <script type="text/javascript">
                function checkPasswordMatch() {
                    var password = $("#UserPassword").val();
                    var passwordLength = $("#UserPassword").val().length;
                    var confirmPassword = $("#RepeatPassword").val();
                    var confirmPasswordLength = $("#RepeatPassword").val().lenght;

                    if (password != confirmPassword) {
                        $("#divCheckPasswordMatch").html("Passwords do not match!");
                        $("#divCheckPasswordMatch").css("background-color", "red");
                        $('#resetBtn').attr('disabled', true);

                        if (passwordLength < 12 || confirmPasswordLength < 12) {
                            $("#divCheckPasswordLength").html("Passwords is too short!");
                            $("#divCheckPasswordLength").css("background-color", "red");
                            $('#resetBtn').attr('disabled', true);
                        }
                    } else {
                        if (password == confirmPassword) {
                            $("#divCheckPasswordMatch").html("Passwords match.");
                            $("#divCheckPasswordMatch").css("background-color", "green");

                            if (passwordLength >= 12 || confirmPasswordLength >= 12) {
                                $("#divCheckPasswordLength").html("Password length ok.");
                                $("#divCheckPasswordLength").css("background-color", "green");
                                $('#resetBtn').attr('disabled', false)
                            }
                        }



                    }
                }

                $(document).ready(function() {
                    $("#UserPassword, #RepeatPassword").keyup(checkPasswordMatch);
                });
            </script>

            <script type="text/javascript">
                $('#user_delete').on('show.bs.modal', function(e) {
                    var Id = $(e.relatedTarget).data('id');
                    $(e.currentTarget).find('input[name="id"]').val(Id);


                });
            </script>
            <script>
                $('#editUser').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var recipient = button.data('id') // Extract info from data-* attributes
                    var modal = $(this);
                    var dataString = 'id=' + recipient;

                    $.ajax({
                        type: "GET",
                        url: "editUser.php",
                        data: dataString,
                        cache: false,
                        success: function(data) {
                            console.log(data);
                            modal.find('.ct').html(data);
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                })
            </script>
</body>

</html>