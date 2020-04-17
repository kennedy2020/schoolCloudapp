<?php

class teacher
{

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

    public function getTeachersPicture($roleNo, $classID)
    {
        try
        {
            $stmt = $this
                ->db
                ->prepare("SELECT * FROM Teachers  WHERE  School_role_no=:role AND ClassID=:classID");

            $stmt->execute(array(
                ':role' => $roleNo,
                ':classID' => $classID
            ));
            //while ($row = $stmt->fetch()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0)
            {
                $picture = $row['Teacher_photo'];

                echo ' <img src="' . $picture . '" width="128" height="128" alt="' . $row['Name'] . ' ' . $row['Surname'] . '">

                  <a class="users-list-name" href="teacher_profile.php?teacherId=' . $row['TeachersID'] . '">' . $row['Name'] . ' ' . $row['Surname'] . '</a>
                    ';
            }
            else
            {
                echo ' <img src="../dist/img/avatar5.png" width="128" height="128" alt="Teacher Photo">

                <a class="users-list-name" data-toggle="modal" data-target="#assign_teacher">Assign Teacher to classroom</a>


 ';
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getAllTeachers($roleNo)
    {
        try
        {
            $stmt = $this
                ->db
                ->prepare("SELECT * FROM Teachers Left JOIN tblClassroom ON tblClassroom.TeachersID = Teachers.TeachersID WHERE  School_role_no=:role ");

            $stmt->execute(array(
                ':role' => $roleNo
            ));
            while ($row = $stmt->fetch())
            {
                echo '
               <li>
                    <img src="' . $row['Teacher_photo'] . '" width="128" height="128" alt="' . $row['Name'] . ' ' . $row['Surname'] . ' Photo">

                    <a class="users-list-name" href="teacher_profile.php?teacherId=' . $row['TeachersID'] . '">' . $row['Name'] . ' ' . $row['Surname'] . '</a>
                    <a class="" href="classroom_students.php?classID=' . $row['ClassID'] . '">' . $row['Class'] . '</a>

                  </li>


';
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function AddTeacher($id, $roleNo, $name, $surname, $alias, $target_file)
    {
        try
        {
            $stmt = $this
                ->db
                ->prepare("INSERT INTO Teachers( TeachersID, School_role_no, Name, Surname, Alias,  Teacher_photo) VALUES(:id, :role, :name, :surname, :alias, :photo)");

            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":role", $roleNo);
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":surname", $surname);
            $stmt->bindparam(":alias", $alias);
            $stmt->bindparam(":photo", $target_file);
            $stmt->execute();
            //    echo "ID of the last inserted record is: ". $stmt->lastInsertId();
            

            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getTeachers($roleNo)
    {
        try
        {
            $stmt = $this
                ->db
                ->prepare("SELECT * FROM Teachers WHERE  School_role_no=:role ");

            $stmt->execute(array(
                ':role' => $roleNo
            ));
            while ($row = $stmt->fetch())
            {
                echo '

                <option value="' . $row['TeachersID'] . '">' . $row['Name'] . ' ' . $row['Surname'] . '</option>


              ';
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function assignTeacher($roleNo, $prof, $classroom)
    {
        try
        {
            $sqlUpdate = 'UPDATE tblClassroom set TeachersID=:teacher WHERE RoleNumber=:role and ClassroomID=:classroom';
            $update = $this
                ->db
                ->prepare($sqlUpdate);
            $update->execute(array(
                ':classroom' => $classroom,
                ':teacher' => $prof,
                ':role' => $roleNo
            ));

            $sql = 'UPDATE Teachers set ClassID=:classroom WHERE School_role_no=:role and TeachersID=:teacher';
            $upd = $this
                ->db
                ->prepare($sql);
            $upd->execute(array(
                ':classroom' => $classroom,
                ':teacher' => $prof,
                ':role' => $roleNo
            ));
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
} //end of class teacher

?>
