<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once 'user.php';

class LOG extends USER
{

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function get_logs()
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM logs");

            $stmts->execute();
            while ($row = $stmts->fetch()) {  

                echo '
<tr>
                  <td>' . $row['id'] . '</td>
                  <td>' . $row['ip'] . '</td>
                  <td>' . $row['action_time'] . '</td>
                  <td>' . $row['username'] . '</td>
                  <td>' . $row['user_action'] . '</td>
                
                  <td>
                           <a class="btn btn-sm btn-danger " type="button"
                       data-toggle="modal"
                       data-target="#log_delete" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i> Delete</a>


                  </td>
                </tr>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function log_delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM logs WHERE id=:id");

            $stmt->bindparam(":id", $id);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


public function download_logs(){

    try {
        //get records from database
    
        $stmts = $this->db->prepare("SELECT * FROM logs ORDER BY id DESC");
    
        $stmts->execute();
        if($stmts->rowCount() > 0)
        {
        $delimiter = ",";
        $filename = "logs_" . date('Y-m-d') . ".csv";        
        //create a file pointer
        $f = fopen('php://memory', 'w');        
        //set column headers
        $fields = array('Id', 'IP', 'Date / Time', 'Username', 'Action taken');
        fputcsv($f, $fields, $delimiter);        
        //output each row of the data, format line as csv and write to file pointer
        while($row = $stmts->fetch())
        {
            $lineData = array($row['id'], $row['ip'], $row['action_time'], $row['username'], $row['user_action']);
            fputcsv($f, $lineData, $delimiter);
        }        
        //move back to beginning of file
        fseek($f, 0);        
        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        
        //output all remaining data on a file pointer
        fpassthru($f);
    
        } 
  } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

public function notify_admin(){
    
    try {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE  user_role = 'Admin'");
        $stmt->execute();      
   
     while ($row = $stmt->fetch()) {
            
            $email = $row['user_email'];
            $subject = 'Failed authentication notification';
            $message = 'Failed notification occured on the School Cloud application';
            $this->send_mail($email,$message,$subject);
        }
    }
    catch (PDOEXCEPTION $e) {
        echo "Error: ".$e;
    }                
}

}
?>