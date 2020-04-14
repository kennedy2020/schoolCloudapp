<?php

class Calendar
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

    public function getSchoolEvents($roleNo)
    {
        try {
            $events = array();
            $stmt = $this->db->prepare("SELECT * FROM schoolcalendar WHERE SchoolRoleNo=:role ");

            $stmt->execute(array(':role' => $roleNo));
            while ($row = $stmt->fetch()) {
                $e = array();
                $e['id'] = $row['id'];
                $e['title'] = $row['title'];
                $e['start'] = $row['startdate'];
                $e['end'] = $row['enddate'];
            
                $allday = ($row['allDay'] == "true") ? true : false;
                $e['allDay'] = $allday;
            
                array_push($events, $e);
            }
               echo json_encode($events);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
    public function setNewSchoolEvent($title, $startdate, $enddate, $roleNo, $false)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO schoolcalendar(`title`, `startdate`, `enddate`, `SchoolRoleNo`, `allDay`) VALUES (:title, :startdate, :startdate, :roleNo, :false )");

            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":startdate", $startdate);
            $stmt->bindparam(":startdate", $enddate);
            $stmt->bindparam(":roleNo", $roleNo);
             $stmt->bindparam(":false", $false);
            $stmt->execute();
            
           
            //  $lastid = mysqli_insert_id($con);
                 $lastid = $this->db->lastInsertId();
            //  echo json_encode(array('status'=>'success','eventid'=>$lastid));
                     json_encode(array('status'=>'success','eventid'=>$lastid));
            

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateTitle($eventid, $title)
    {
        try {
            $sqlUpdate = "UPDATE schoolcalendar SET title=:title where id=:eventid";
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':title' => $title, ':eventid' => $eventid));
            return $update->rowCount() ? true : false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>