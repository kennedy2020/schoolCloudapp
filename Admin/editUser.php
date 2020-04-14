<?php

require_once '../includes/dbconfig.php';
$user->is_loggedin();


if(isset($_POST['submit'])){
    $name = $_POST['user_name'];
    $surname = $_POST['user_surname'];
    $status = $_POST['status'];
    $email = $_POST['user_email'];
    $username = $_POST['username'];
    $roleNo = $_POST['SchoolRole'];
    $user_id = $_POST['User_id'];

    $user->editUser($roleNo, $name, $surname, $status, $username, $email, $user_id);

    header("Refresh:0; url=../Admin/users.php");

    die();


}




if (isset($_GET['id']))
{
    $id = $_GET['id'];
}

$drivers = 'SELECT * FROM users WHERE id =:id ';
$drive = $DB_con->prepare($drivers);
$drive->bindParam(':id', $id, PDO::PARAM_INT);
$drive->execute();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php

while ($d = $drive->fetch()):

    ?>
    <form method="post" action="../includes/editUser.php" role="form">
        <div class="modal-body">


            <div class="form-group">
                <label for="usr">Name:</label>
                <input class="form-control " type="text" required="required" value="<?php echo $d['user_name']; ?>" name="user_name">
            </div>

            <div class="form-group">
                <label for="usr">Surname:</label>
                <input class="form-control " type="text" required="required" value="<?php echo $d['user_surname']; ?>" name="user_surname">
            </div>

            <div class="form-group">
                <label for="usr">Username:</label>
                    <input class="form-control " type="text" required="required" value="<?php echo $d['user_username']; ?>" name="username">
                </div>

            <div class="form-group">
                <label for="usr">Email:</label>
                <input class="form-control " type="email" required="required" value="<?php echo $d['user_email']; ?>" name="user_email">
            </div>

       

            <div class="form-group">
                <label for="usr">School Name:</label>
                <select class="form-control" name="SchoolRole">
                    <?php
                    $school->getSchoolsByRole();
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="usr">Status:</label>
                <select class="form-control" name="status">
                    <option value="Admin">Admin</option>
                    <option value="Parent">Parent</option>
                    <option value="Teacher">Teacher</option>
                </select>
            </div>

            <input type="hidden" name="User_id" value="<?php

            echo $d['id'];

            ?>" />


            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success" name="submit" value="Update" />&nbsp;

            </div>
    </form>
    <?php

endwhile;

?>
<script src="../dist/js/password2.js"></script>
</body>
</html>

