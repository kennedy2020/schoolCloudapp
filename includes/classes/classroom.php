<?php



class Classroom
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function getClassrooms($roleNo)
    {
        try {
            $colors = array("green", "yellow", "red", "aqua", "green", "yellow", "red", "aqua", "green", "yellow", "red", "aqua", "green", "yellow", "red", "aqua", "green", "yellow", "red", "aqua", "green", "yellow", "red", "aqua", "green", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua", "yellow", "red", "aqua");
            $key = 0;
            $stmt = $this->db->prepare("SELECT * FROM tblClassroom Left JOIN Teachers ON tblClassroom.TeachersID = Teachers.TeachersID WHERE  RoleNumber=:role ");

            $stmt->execute(array(':role' => $roleNo));
            while ($row = $stmt->fetch()) {
                $key++;


                echo '

  <div class="col-md-4">

            <!-- Info Boxes Style 2 -->
            <div class="info-box bg-' . $colors[$key] . '">
              <a href="classroom_students.php?classID=' . $row['ClassroomID'] . '" class="classroomLink">
              <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
              <div class="info-box-content">
                <span class="info-box-number">' . $row['Class'] . '</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 50%"></div>
                </div>
                  <span class="info-box-number">
                    ' . $row['Name'] . ' ' . $row['Surname'] . '
                  </span>
              </div><!-- /.info-box-content -->
                </a>
            </div><!-- /.info-box -->

    </div><!--col-->
                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getClassroomsName($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblClassroom  WHERE  RoleNumber=:role ");

            $stmt->execute(array(':role' => $roleNo));
            while ($row = $stmt->fetch()) {
                echo '

                       <option value=" ' . $row['ClassroomID'] . '"> ' . $row['Class'] . '</option>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getClassroomStudents($roleNo, $classID)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblStudents  WHERE  school_role_no=:role AND Classroom=:classID");

            $stmt->execute(array(':role' => $roleNo, ':classID' => $classID));
            while ($row = $stmt->fetch()) {
                $DOB = date("d/m/Y", strtotime($row['StudentDOB']));

                echo '



                <tr>
                  <td>' . $row['StudentID'] . '</td>
                  <td>' . $row['StudentFN'] . '</td>
                  <td>' . $row['StudentSN'] . '</td>
                  <td>' . $DOB . '</td>
                  <td>' . $row['Gender'] . '</td>
                    <td>

                    <form method="post">




                        <div class="btn-group attendance" data-toggle="buttons">
                            <label class="btn btn-success">
                                <input type="radio" id="yes" name="present" value="1" />
                            </label>
                            <label class="btn btn-danger">
                                <input type="radio" id="no"  name="absent" value="0" />
                            </label>





                    </form>


                    </td>
                </tr>


';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getClassroomName($roleNo, $classID)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblClassroom  WHERE  RoleNumber=:role AND ClassroomID=:classID");

            $stmt->execute(array(':role' => $roleNo, ':classID' => $classID));
            while ($row = $stmt->fetch()) {
                echo $row['Class'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function teacherToclass($roleNo)
    {

        //update the
        try {
            $stmts = $this->db->prepare("SELECT * FROM Teachers WHERE  School_role_no=:id ");

            $stmts->execute(array(':id' => $roleNo));
            while ($row = $stmts->fetch()) {
                $teacherId = $row['TeachersID'];
                $classroom = $row['ClassID'];

                $sqlUpdate = 'UPDATE tblClassroom set TeachersID=:teacherId where RoleNumber=:id and ClassroomID=:classroomId';
                $update = $this->db->prepare($sqlUpdate);
                $update->execute(array(':teacherId' => $teacherId, ':id' => $roleNo, ':classroomId' => $classroom));
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }





    public function getClassroomId($roleNo, $teacherId)
    {

        //update the
        try {
            $stmts = $this->db->prepare("SELECT * FROM tblClassroom WHERE  RoleNumber=:roleNo and TeachersID=:teacherId");

            $stmts->execute(array(':roleNo' => $roleNo, ':teacherId'=> $teacherId));
            while ($row = $stmts->fetch()) {
                $classroom_id=$row['ClassroomID'];
                return $classroom_id;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }





    public function addClassroom($roleNo, $class_name)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tblClassroom(RoleNumber, Class) VALUES(:roleNo, :class)");

            $stmt->bindparam(":roleNo", $roleNo);
            $stmt->bindparam(":class", $class_name);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}//end of class classroom

?>