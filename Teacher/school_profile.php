<?php

require_once '../includes/dbconfig.php';

$user->is_loggedin();

include_once 'header.php';


if(isset($_POST['school_name'])){
    $name = $_POST['school_new_name'];
    $school ->updateName($roleNo, $name);
    header("Refresh:0");
}

if(isset($_POST['school_alias'])){
    $alias = $_POST['school_new_alias'];
    $school ->updateAlias($roleNo, $alias);
    header("Refresh:0");
}

if(isset($_POST['roleNumber'])){
    $role = $_POST['school_new_role'];
    $school ->updateRole($roleNo, $role);
    header("Refresh:0");
}


if(isset($_POST['schoolPrincipal'])){
    $principal = $_POST['school_new_principal'];
    $school ->updatePrincipal($roleNo, $principal);
    header("Refresh:0");
}

if(isset($_POST['schoolEmail'])){
    $email = $_POST['school_new_email'];
    $school ->updateEmail($roleNo, $email);
    header("Refresh:0");
}



if(isset($_POST['schoolWebsite'])){
    $web = $_POST['school_new_website'];
    $school ->updateWebsite($roleNo, $web);
    header("Refresh:0");
}

if(isset($_POST['schoolPhone'])){
    $phone= $_POST['school_new_phone'];
    $school ->updatePhone($roleNo, $phone);
    header("Refresh:0");
}

if(isset($_POST['schoolFax'])){
    $fax= $_POST['school_new_fax'];
    $school ->updateFax($roleNo, $fax);
    header("Refresh:0");
}


if(isset($_POST['schoolAddress'])){
    $address1= $_POST['address1'];
    $address2= $_POST['address2'];
    $address3= $_POST['address3'];
    $address4= $_POST['address4'];
    $county= $_POST['county'];

    $school ->updateAddress($roleNo, $address1, $address2,$address3,$address4, $county);
    header("Refresh:0");
}

if(isset($_POST['schoolEircode'])){
    $eircode= $_POST['school_new_eircode'];
    $school ->updateEircode($roleNo, $eircode);
    header("Refresh:0");
}


if(isset($_POST['school_logo'])){
    $target_dir = "../dist/img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $error =  "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $error =  "File is not an image.";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        $error =  "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        $error =  "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error =  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $school ->updateLogo($roleNo, $target_file);
           $success = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded successfully.";


        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }
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
            <h1>
                School Information

            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-md-6">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">Profile</a></li>
                            <li><a href="#timeline" data-toggle="tab">Contact</a></li>
                            <li><a href="#settings" data-toggle="tab">Address</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <!-- Profile Image -->
                                    <div class=" ">
                                        <div class="box-body box-profile">


                                            <ul class="list-group list-group-unbordered">
                                                <li class="list-group-item">
                                                    <b class="red">School Name:</b> <b
                                                        class="blue tab10"> <?php $school->getDetails($roleNo, "SchoolName"); ?> </b><a
                                                        class="btn btn-sm btn-primary pull-right" type="button"
                                                        data-toggle="modal" data-target="#name_edit"><i class="fa fa-pencil"></i> Edit</a>

                                                </li>

                                                <li class="list-group-item">
                                                    <b class="red">Known As: </b>

                                                    <b class="blue tab10"><?php $school->getDetails($roleNo, "KnownAs"); ?></b>


                                                    <a class="btn btn-sm btn-primary pull-right" type="button"
                                                                                     data-toggle="modal"
                                                                                     data-target="#alias_edit"><i class="fa fa-pencil"></i> Edit</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b class="red">Role Number: </b>

                                                    <b class="blue tab10"><?php echo $roleNo; ?></b>


                                                    <a class="btn btn-sm btn-primary pull-right" type="button"
                                                       data-toggle="modal"
                                                       data-target="#role_edit"><i class="fa fa-pencil"></i> Edit</a>





                                                </li>
                                                <li class="list-group-item">
                                                    <b class="red">School Principal: </b>


                                                    <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolPrincipal"); ?></b>

                                                    <a class="btn btn-sm btn-primary pull-right" type="button"
                                                       data-toggle="modal"
                                                       data-target="#principal_edit"><i class="fa fa-pencil"></i> Edit</a>



                                                </li>
                                            </ul>


                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <!-- /.post -->


                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">


                                <!-- About Me Box -->
                                <div class=" ">

                                    <div class="box-body">

                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b class="red">Email:</b>
                                                <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolEMail"); ?></b>
                                                <a class="btn btn-sm btn-primary pull-right" type="button"
                                                   data-toggle="modal"
                                                   data-target="#email_edit"><i class="fa fa-pencil"></i> Edit</a>



                                            </li>

                                            <li class="list-group-item">
                                                <b class="red">Website:</b>


                                                <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolWeb"); ?></b>
                                                <a class="btn btn-sm btn-primary pull-right" type="button"
                                                   data-toggle="modal"
                                                   data-target="#website_edit"><i class="fa fa-pencil"></i> Edit</a>


                                            </li>
                                            <li class="list-group-item">
                                                <b class="red">Phone:</b>

                                                <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolPhone01"); ?></b>
                                                <a class="btn btn-sm btn-primary pull-right" type="button"
                                                   data-toggle="modal"
                                                   data-target="#phone_edit"><i class="fa fa-pencil"></i> Edit</a>



                                            </li>
                                            <li class="list-group-item">
                                                <b class="red">Fax:</b>

                                                <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolFax"); ?></b>
                                                <a class="btn btn-sm btn-primary pull-right" type="button"
                                                   data-toggle="modal"
                                                   data-target="#fax_edit"><i class="fa fa-pencil"></i> Edit</a>

                                            </li>
                                        </ul>

                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->


                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">

                                <!-- About Me Box -->
                                <div class=" ">

                                    <div class="box-body">


                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b class="red">Address:</b>


                                                <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolAddress01"); ?>
                                                    , <?php $school->getDetails($roleNo, "SchoolAddress02"); ?>
                                                    , <?php $school->getDetails($roleNo, "County"); ?></b>
                                                <a class="btn btn-sm btn-primary pull-right" type="button"
                                                   data-toggle="modal"
                                                   data-target="#address_edit"><i class="fa fa-pencil"></i> Edit</a>





                                            </li>

                                            <li class="list-group-item">
                                                <b class="red">Eircode:</b>


                                                <b class="blue tab10"><?php $school->getDetails($roleNo, "SchoolEircode"); ?></b>
                                                <a class="btn btn-sm btn-primary pull-right" type="button"
                                                   data-toggle="modal"
                                                   data-target="#eircode_edit"><i class="fa fa-pencil"></i> Edit</a>




                                            </li>


                                        </ul>


                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <?php

                    $school ->schoolLogoBig($roleNo);


                    ?>



                    <form method="post" enctype="multipart/form-data" class="uploadForm">

                        <div class="form-group">
                            <label for="my-file-selector">
                                <input class="btn btn-primary" type="file"   name="fileToUpload">

                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="school_logo">Upload Logo</button>


                        </form>
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


                </div>

            </div>

    </div>
    <!-- /.row -->

    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--edit name modal -->
<div class="example-modal">
    <div class="modal fade" id="name_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Name</h4>
                </div>
                <div class="modal-body">
                    <form name="new_name" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter new name:</label>
                            <input class="form-control " type="text" required="required" name="school_new_name">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="school_name">Save changes</button>
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


<!--edit known as modal -->
<div class="example-modal">
    <div class="modal fade" id="alias_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Alias</h4>
                </div>
                <div class="modal-body">
                    <form name="alias" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter new alias:</label>
                            <input class="form-control " type="text" required="required" name="school_new_alias">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="school_alias">Save changes</button>
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


<!--edit role modal -->
<div class="example-modal">
    <div class="modal fade" id="role_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Role Number</h4>
                </div>
                <div class="modal-body">
                    <form name="role" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter new role number:</label>
                            <input class="form-control " type="text" required="required" name="school_new_role">
                        </div>
                        <div class="alert alert-warning">
                            <strong>Attention!</strong> You will need to login again. Are you sure you want to continue?
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="roleNumber">Save changes</button>
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


<!--edit school principal modal -->
<div class="example-modal">
    <div class="modal fade" id="principal_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Principal</h4>
                </div>
                <div class="modal-body">
                    <form name="principal" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the name of the new School principal:</label>
                            <input class="form-control " type="text" required="required" name="school_new_principal">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolPrincipal">Save changes</button>
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


<!--edit email modal -->
<div class="example-modal">
    <div class="modal fade" id="email_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Email</h4>
                </div>
                <div class="modal-body">
                    <form name="email" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the new email:</label>
                            <input class="form-control " type="text" required="required" name="school_new_email">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolEmail">Save changes</button>
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


<!--edit website modal -->
<div class="example-modal">
    <div class="modal fade" id="website_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Website Address</h4>
                </div>
                <div class="modal-body">
                    <form name="website" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the new address of the website:</label>
                            <input class="form-control " type="text" required="required" name="school_new_website">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolWebsite">Save changes</button>
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


<!--edit phone modal -->
<div class="example-modal">
    <div class="modal fade" id="phone_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Phone Number</h4>
                </div>
                <div class="modal-body">
                    <form name="phone" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the new phone number</label>
                            <input class="form-control " type="text" required="required" name="school_new_phone">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolPhone">Save changes</button>
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


<!--edit website modal -->
<div class="example-modal">
    <div class="modal fade" id="fax_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Fax Number</h4>
                </div>
                <div class="modal-body">
                    <form name="fax" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the new fax number:</label>
                            <input class="form-control " type="text" required="required" name="school_new_fax">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolFax">Save changes</button>
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


<!--edit address modal -->
<div class="example-modal">
    <div class="modal fade" id="address_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Address</h4>
                </div>
                <div class="modal-body">
                    <form name="address" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the new address:</label>
                            <input class="form-control " type="text" required="required" name="address1">
                        </div>

                        <div class="form-group">

                            <input class="form-control " type="text" required="required" name="address2">
                        </div>

                        <div class="form-group">

                            <input class="form-control " type="text"  name="address3">
                        </div>
                        <div class="form-group">

                            <input class="form-control " type="text" name="address4">
                        </div>

                        <div class="form-group">
                            <label>County:</label>
                             <select class="form-control" name="county">
                                 <option value="Antrim">Antrim</option>
                                 <option value="Armagh">Armagh</option>
                                 <option value="Carlow">Carlow</option>
                                 <option value="Cavan">Cavan</option>
                                 <option value="Clare">Clare</option>
                                 <option value="Cork">Cork</option>
                                 <option value="Derry">Derry</option>
                                 <option value="Donegal">Donegal</option>
                                 <option value="Down">Down</option>
                                 <option value="Dublin">Dublin</option>
                                 <option value="Fermanagh">Fermanagh</option>
                                 <option value="Galway">Galway</option>
                                 <option value="Kerry">Kerry</option>
                                 <option value="Kildare">Kildare</option>
                                 <option value="Kilkenny">Kilkenny</option>
                                 <option value="Laois">Laois</option>
                                 <option value="Leitrim">Leitrim</option>
                                 <option value="Limerick">Limerick</option>
                                 <option value="Longford">Longford</option>
                                 <option value="Louth">Louth</option>
                                 <option value="Mayo">Mayo</option>
                                 <option value="Meath">Meath</option>
                                 <option value="Monaghan">Monaghan</option>
                                 <option value="Offaly">Offaly</option>
                                 <option value="Roscommon">Roscommon</option>
                                 <option value="Sligo">Sligo</option>
                                 <option value="Tipperary">Tipperary</option>
                                 <option value="Tyrone">Tyrone</option>
                                 <option value="Waterford">Waterford</option>
                                 <option value="Westmeath">Westmeath</option>
                                 <option value="Wexford">Wexford</option>
                                 <option value="Wicklow">Wicklow</option>
                            </select>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolAddress">Save changes</button>
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


<!--edit eircode modal -->
<div class="example-modal">
    <div class="modal fade" id="eircode_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change School Eircode</h4>
                </div>
                <div class="modal-body">
                    <form name="eircode" method="post">

                        <div class="form-group">
                            <label for="usr">PLease enter the new eircode:</label>
                            <input class="form-control " type="text" required="required" name="school_new_eircode">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="schoolEircode">Save changes</button>
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


<?php

include_once 'footer.php';

?>


</body>
</html>
