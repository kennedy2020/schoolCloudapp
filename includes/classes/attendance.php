<?php
class Attendance
{

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function will_not_attend($student_id, $roleNo)
    {
        $this->db->beginTransaction();
        $date = date('Y-m-d', strtotime('+1 days'));
        try {
            $stmt = $this->db->prepare("INSERT INTO attendance(pupil_id, date, school_role_no)
		                                               VALUES(:id_pupil, :date, :role)");

            $stmt->bindparam(":id_pupil", $student_id);
            $stmt->bindparam(":date", $date);
            $stmt->bindparam(":role", $roleNo);
            $stmt->execute();

              $this->db->commit();

                return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
             $this->db->rollback();
            return false;
        }
    }
}




?>