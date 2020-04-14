<?php



class PUPIL
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function get_pupils($roleNo)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM tblStudents JOIN tblClassroom ON tblStudents.Classroom = tblClassroom.ClassroomID WHERE  school_role_no=:id ");

            $stmts->execute(array(':id' => $roleNo));
            while ($row = $stmts->fetch()) {
                $DOB = date("d/m/Y", strtotime($row['StudentDOB']));

                echo '



<tr>
                  <td>' . $row['StudentID'] . '</td>
                  <td>' . $row['StudentFN'] . '</td>
                  <td>' . $row['StudentSN'] . '</td>
                  <td>' . $DOB . '</td>
                  <td>' . $row['Gender'] . '</td>
                  <td>' . $row['Class'] . '</td>
                  <td>
                    <a class="btn btn-sm btn-primary " type="button"
                       data-toggle="modal"
                       data-target="#pupil_edit" data-id="' . $row['StudentID'] . '"><i class="fa fa-pencil"></i> Edit</a>



                    <a class="btn btn-sm btn-danger " type="button"
                       data-toggle="modal"
                       data-target="#pupil_delete" data-id="' . $row['StudentID'] . '"><i class="fa fa-trash"></i> Delete</a>


                  </td>
                </tr>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function pupilAdd($roleNo, $name, $surname, $DOB, $gender, $classroom)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tblStudents(school_role_no, StudentFN, StudentSN, StudentDOB, Gender, Classroom)
		                                               VALUES(:roleNo, :name, :surname, :DOB, :gender, :classroom)");

            $stmt->bindparam(":roleNo", $roleNo);
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":surname", $surname);
            $stmt->bindparam(":DOB", $DOB);
            $stmt->bindparam(":gender", $gender);
            $stmt->bindparam(":classroom", $classroom);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function pupilDelete($roleNo, $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tblStudents WHERE  school_role_no=:roleNo AND StudentID=:id");

            $stmt->bindparam(":roleNo", $roleNo);
            $stmt->bindparam(":id", $id);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //update pupil details
    public function pupilEdit($roleNo, $id, $name, $surname, $DOB, $gender, $classroom)
    {
        try {
            $sqlUpdate = 'UPDATE tblStudents set StudentFN=:fname, StudentSN=:sname, StudentDOB=:DOB, Gender=:gender, Classroom=:classroom where school_role_no=:role and StudentID =:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $roleNo, ':fname' => $name, ':sname' => $surname, ':DOB' => $DOB, ':gender' => $gender, ':classroom' => $classroom, ':id' => $id));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getPupils($roleNo)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM tblStudents JOIN tblClassroom ON tblStudents.Classroom = tblClassroom.ClassroomID WHERE  school_role_no=:id ");

            $stmts->execute(array(':id' => $roleNo));
            while ($row = $stmts->fetch()) {
                $DOB = date("d/m/Y", strtotime($row['StudentDOB']));

                echo '

   <option value=" ' . $row['StudentID'] . '">' . $row['StudentFN'] . ' ' . $row['StudentSN'] . ' - ' . $DOB . '</option>



                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function AssignPupilToFamily($roleNo, $pupilID, $parentID)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO parents_pupils(SchoolRoleNo, parent_id, Pupil_id)
		                                               VALUES(:roleNo, :parentID, :pupilID )");

            $stmt->bindparam(":roleNo", $roleNo);
            $stmt->bindparam(":pupilID", $pupilID);
            $stmt->bindparam(":parentID", $parentID);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}//class pupil


?>