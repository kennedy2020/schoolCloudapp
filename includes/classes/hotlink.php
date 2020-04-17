<?php


class hotlink
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function get_pupil($id)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM tblstudents JOIN parents_pupils ON parents_pupils.pupil_id = tblstudents.StudentID WHERE  parent_id=:id ");
            $stmts->execute(array(':id' => $id));
            while ($row = $stmts->fetch()) {
                echo '

                        <option value="' . $row['StudentID'] . '">' . $row['StudentFN'] . ' ' . $row['StudentSN'] . '</option>

                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function send_message($studentid, $message, $user_email)
    {
        try {
           
            
        $stmt = $this->db->prepare("INSERT INTO hotlinks (id_pupil, messages, user_email) VALUES(:id_pupil, :messages, :email)");
            $stmt->bindparam(":id_pupil", $studentid);
            $stmt->bindparam(":messages", $message);         
            $stmt->bindparam(":email", $user_email);
            $stmt->execute();  
           
         return true;
    

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function showHotPointA($roleNo, $read)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM hotlinks JOIN tblStudents ON hotlinks.id_pupil = tblStudents.StudentID WHERE  hotlinks.school_role_no=:roleNo and hotlinks.readAdmin=:readA");
            $stmts->execute(array(':roleNo' => $roleNo, ':readA' => $read));
            while ($row = $stmts->fetch()) {
                $time = date("H:i", strtotime($row['timestamp']));

                echo '

                       <!-- chat item -->
                  <div class="">

                    <p class="message">
                      <a href="read-mail.php?mailId=' . $row['id'] . '" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ' . $time . '</small>
                        ' . $row['StudentFN'] . ' ' . $row['StudentSN'] . '
                      </a>
                      <p>
                      ';
                $str = $row['message'];
                $this->getNWordsFromString($str, 10);


                echo '...
                    </p>
                    </p>

                  </div><!-- /.item -->
                  <hr />
                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function showHotPointT($roleNo, $read, $classroomId)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM hotlinks JOIN tblStudents ON HotLinks.id_pupil = tblStudents.StudentID WHERE  hotlinks.school_role_no=:roleNo and hotlinks.readTeacher=:readA and tblStudents.Classroom=:classroomId");
            $stmts->execute(array(':roleNo' => $roleNo, ':readA' => $read, ':classroomId' => $classroomId));
            while ($row = $stmts->fetch()) {
                $time = date("H:i", strtotime($row['timestamp']));

                echo '

                       <!-- chat item -->
                  <div class="">

                    <p class="message">
                      <a href="read-mail.php?mailId=' . $row['id'] . '" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ' . $time . '</small>
                        ' . $row['StudentFN'] . ' ' . $row['StudentSN'] . '
                      </a>
                      <p>
                      ';
                $str = $row['message'];
                $this->getNWordsFromString($str, 10);


                echo '...
                    </p>
                    </p>

                  </div><!-- /.item -->
                  <hr />
                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getNWordsFromString($str, $no)
    {
        $arr = explode(" ", str_replace(",", ", ", $str));
        for ($index = 0; $index < $no; $index++) {
            echo $arr[$index] . " ";
        }
    }


    public function readMail($roleNo, $id)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM hotlinks JOIN tblStudents ON hotlinks.id_pupil = tblStudents.StudentID WHERE  hotlinks.school_role_no=:roleNo and hotlinks.id=:id");
            $stmts->execute(array(':roleNo' => $roleNo, ':id' => $id));
            while ($row = $stmts->fetch()) {
                $id_message = $row['id'];
                $time = date("m/d/Y H:i", strtotime($row['timestamp']));

                echo '
     <div class="box-body no-padding">
                  <div class="mailbox-read-info">
                    <h3>Message Subject: ' . $row['StudentFN'] . ' ' . $row['StudentSN'] . '</h3>
                    <h5>From: '.$row['From'].'
                <span class="mailbox-read-time pull-right">' . $time . '</span></h5>
                  </div><!-- /.mailbox-read-info -->
                  <div class="mailbox-controls with-border text-center">
                    <div class="btn-group">
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button>
                      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Forward"><i class="fa fa-share"></i></button>
                    </div><!-- /.btn-group -->
                    <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></button>
                  </div><!-- /.mailbox-controls -->
                  <div class="mailbox-read-message">
                    <p>

                    ' . $row['message'] . '


</p>
                  </div><!-- /.mailbox-read-message -->
                </div><!-- /.box-body -->

                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function UpdateReadAdmin($emailId, $read)
    {
        try {
            $sqlUpdate = 'UPDATE hotlinks set readAdmin=:read WHERE id=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':read' => $read, ':id' => $emailId));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function UpdateReadTeacher($emailId, $read)
    {
        try {
            $sqlUpdate = 'UPDATE hotlinks set readTeacher=:read WHERE id=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':read' => $read, ':id' => $emailId));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>