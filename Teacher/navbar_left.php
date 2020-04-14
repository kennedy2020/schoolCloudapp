<?php
/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 30/11/15
 * Time: 10:34 PM
 */

?>

<!--Navbar left menu-->

<div class="navbar-left-menu">
    <ul class="nav navbar-nav">

        <!--dashboard -->
        <li>
            <a href="index.php" >
                <i class="fa fa-dashboard"></i> Home

            </a>
        </li>
        <!--classrooms -->
        <li>
            <a href="classroom_students.php?teacherId=<?php echo $id; ?>" >
                <i class="fa fa-book"></i> Classroom

            </a>
        </li>



    </ul>



</div>


<!--end left navbar  -->
