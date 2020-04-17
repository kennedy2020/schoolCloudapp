<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class USER
{

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

   

    public function addUser($roleNo, $name, $surname, $username, $status, $email, $password)
    {

        try {
            $stmt = $this->db->prepare("INSERT INTO users(user_name, user_surname, user_username, user_email, user_pass, user_role, school_role_no)
		                                               VALUES(:uname, :surname, :username, :email, :pass, :urole, :srole)");

            $stmt->bindparam(":uname", $name);
            $stmt->bindparam(":surname", $surname);
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":pass", $password);
            $stmt->bindparam(":urole", $status);
            $stmt->bindparam(":srole", $roleNo);

            $stmt->execute();

            $message = "User Created";
            $datetime=date('Y-m-d H:i:s'); //Storing time in variable
            $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
            $this->log_in_db($ip, $datetime, $username, $message);

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login($username, $upass, $ip, $datetime)
    {
       
      
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE  user_username=:uname");
            $stmt->execute(array(':uname' => $username));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $hasspass = $data['user_pass'];
                 
                if (password_verify($upass, $hasspass)) {
                          $_SESSION['user_session'] = $data['id'];
                          $_SESSION['user_role'] = $data['user_role'];
                          $_SESSION['role_no'] = $data['school_role_no'];
                          $_SESSION['email'] = $data['user_email'];
                        

                          //keep track of loggins
                          $message = 'Log in';
                          $this->log_in_db($ip, $datetime, $username, $message);
                            
                          return true;
                }
            } else {
                  //keep this in logs too
                   $message = "Log in attempt";
                   $this->log_in_db($ip, $datetime, $username, $message);
                                      
                  //$this ->login_attempt_count($max_time_in_seconds, $max_attempts, $ip, $datetime);
                   $_SESSION['error'] = 'Invalid Username or Password  ';
                       
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    function login_attempt_count($max_time_in_seconds)
    {
        try {
            date_default_timezone_set('Europe/Dublin');
            $datetime=date('Y-m-d H:i:s'); //Storing time in variable
            $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address

            // First we delete old attempts from the table

  
            $oldest = strtotime(date("Y-m-d H:i:s")." - ".$max_time_in_seconds." seconds");
            $oldest = date("Y-m-d H:i:s", $oldest);
            $stmt = $this->db->prepare("DELETE FROM loginattempts WHERE  action_time < :setgracetime AND ip =:ip");
            $stmt->execute(array(':setgracetime' => $oldest, ':ip' => $ip));
            $stmt->execute();
         
              
            // Next we insert this attempt into the table
         
            $stmt = $this->db->prepare("INSERT INTO loginattempts(ip, user_action, action_time)
                    VALUES(:ip, :user_action, :action_time)");

            $stmt->execute([
                'ip' => $ip,
                'user_action' =>'Log in attempt',
                'action_time'=>$datetime
               
            ]);
            
                   
            // Finally we count the number of recent attempts from this ip address

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM loginattempts WHERE  ip=:ip");
            $stmt->execute(array(':ip' => $ip));
            $rowCount = $stmt->fetchColumn(0);
            return $rowCount;
        } catch (PDOEXCEPTION $e) {
            echo "Error: ".$e;
        }
    }


    function log_in_db($ip, $datetime, $username, $message)
    {
        try {
               $stmt = $this->db->prepare("INSERT INTO logs(ip, action_time, username, user_action)
                            VALUES(:ip, :action_time, :username, :user_action)");
                        $stmt->execute([
                            'ip' => $ip,
                            'action_time' => $datetime,
                            'username' =>$username,
                            'user_action' =>$message
                        ]);
        
                return true;
        } catch (PDOEXCEPTION $e) {
            echo "Error: ".$e;
        }
    }


    public function show_login_form($condition)
    {
        if ($condition== 'True') {
            echo'
         <form method="post">
            <div class="form-group has-feedback">
              <input type="username" class="form-control" placeholder="Username" required="required" name="txt_uname">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password" required="required" name="txt_password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
              <div class="col-xs-8">
  
              </div><!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-login">Log In</button>
              </div><!-- /.col -->
            </div>
          </form>';
        } else {
            echo'';
        }
    }


    public function is_loggedin()
    {
        if (isset($_SESSION['user_session'])) {
            return true;
        }else{
           header('Location: ../index.php');
        }
    }

   public function isAdmin()
    {
        if (isset($_SESSION['user_session']) && $_SESSION['user_role'] == 'Admin' ) {
            return true;
           
        }else{
      
           header('Location: ../'.$_SESSION['user_role'].'/index.php');
           
        }
    }

    public function isParent()
    {
        if (isset($_SESSION['user_session']) && $_SESSION['user_role'] == 'Parent' ) {
            return true;
           
        }else{
      
           header('Location: ../'.$_SESSION['user_role'].'/index.php');
           
        }
    }
    public function isTeacher()
    {
        if (isset($_SESSION['user_session']) && $_SESSION['user_role'] == 'Teacher' ) {
            return true;
           
        }else{
      
           header('Location: ../'.$_SESSION['user_role'].'/index.php');
           
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['user_session']);
        unset($_SESSION['user_role']);
        unset($_SESSION['role_no']);
        unset($_SESSION['email']);
        return true;
    }


    public function getUsers($roleNo)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM users WHERE  school_role_no=:id ");

            $stmts->execute(array(':id' => $roleNo));
            while ($row = $stmts->fetch()) {
                echo '

<tr>
                  <td>' . $row['id'] . '</td>
                  <td>' . $row['user_name'] . '</td>
                  <td>' . $row['user_surname'] . '</td>

                  <td>' . $row['user_email'] . '</td>
                  <td>' . $row['user_role'] . '</td>
                  <td>
                    <a class="btn btn-sm btn-primary " type="button"
                       data-toggle="modal"
                       data-target="#editUser" data-id="' . $row['id'] . '"><i class="fa fa-pencil"></i> Edit</a>



                    <a class="btn btn-sm btn-danger " type="button"
                       data-toggle="modal"
                       data-target="#deleteUser" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i> Delete</a>


                  </td>
                </tr>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getAllUsers()
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM users ");

            $stmts->execute();
            while ($row = $stmts->fetch()) {
                echo '

<tr>
                  <td>' . $row['id'] . '</td>
                  <td>' . $row['user_name'] . '</td>
                  <td>' . $row['user_surname'] . '</td>

                  <td>' . $row['user_email'] . '</td>
                  <td>' . $row['user_role'] . '</td>
                  <td>
                    <a class="btn btn-sm btn-primary " type="button"
                       data-toggle="modal"
                       data-target="#editUser" data-id="' . $row['id'] . '"><i class="fa fa-pencil"></i> Edit</a>



                    <a class="btn btn-sm btn-danger " type="button"
                       data-toggle="modal"
                       data-target="#deleteUser" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i> Delete</a>


                  </td>
                </tr>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getLastUser($roleNo, $email, $status)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE  school_role_no=:role AND user_email =:email AND user_role=:status");

            $stmt->execute(array(':role' => $roleNo, ':email' => $email, ':status' => $status));
            while ($row = $stmt->fetch()) {
                $last_id = $row['id'];
                return $last_id;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function DeleteUser($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id=:id");
            $stmt->bindparam(":id", $id);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function editUser($roleNo, $name, $surname, $status, $username, $email,  $id)
    {
        try {
            $sqlUpdate = 'UPDATE users set user_name=:user_name, user_surname=:user_surname, user_email=:user_email, user_role=:user_role, user_username=:user_username, school_role_no=:school_role_no where id=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':user_name' => $name,
            ':user_surname' => $surname,
            ':user_email' => $email,
            ':user_role' => $status,
            ':user_username' => $username,
            ':school_role_no' => $roleNo,
            ':id' => $id));

            $message = "User Modified";
            $datetime=date('Y-m-d H:i:s'); //Storing time in variable
            $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
            $this->log_in_db($ip, $datetime, $username, $message);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function checkEmailofuser($email)
    {
       
      
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE  user_email=:email");
            $stmt->execute(array(':email' => $email));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                
                $databaseemail = $data['user_email'];
                $uname = $data['user_name'];
                $usurname = $data['user_surname'];               
                $id = base64_encode($data['id']);           
                if ($databaseemail == $email){
                    // generate a unique random token of length 100

                    $token = bin2hex(random_bytes(50));
                    date_default_timezone_set('Europe/Dublin');
                    $time = strtotime(date("Y-m-d H:i:s")." + 1 hour");
                    $timeout = date("Y-m-d H:i:s", $time);
                   
                    try {
                        $stmt = $this->db->prepare("INSERT INTO password_resets(email, token, reset_timeout)
                                     VALUES(:email, :token, :reset_timeout)");
                                 $stmt->execute([
                                     'email' => $email,
                                     'token' => $token,
                                     'reset_timeout' => $timeout
                                   
                                 ]);



                        $message="Hello ".$uname." ".$usurname.",";
                        $message.= " <br /><br />";
                        $message.= "To reset your password please, just click following link<br/><br /><br />";
                        $message.= "<a href=\"localhost/schoolCloud/verify.php?id=".$id."&token=".$token."\">Click HERE to Reset the password</a>"; 
                        $message.="<br /><br /> Thie link will expire in 1 hour,";             
                        $message.="<br /><br /> Regards,";   
                        $message.="<br /><br /> SchoolCloud";           
                        $subject='Password Reset';         
                        $this->send_mail($email,$message,$subject);

                        
                 } catch (PDOEXCEPTION $e) {
                     echo "Error: ".$e;
                 }                
                } 
            }else {
                    //keep this in logs too
                     $message = "Password reset failed";
                     date_default_timezone_set('Europe/Dublin');
                     $datetime=date('Y-m-d H:i:s'); //Storing time in variable
                     $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
                     $this->log_in_db($ip, $datetime, $email, $message);
        
                     $_SESSION['error'] = 'Sorry, no user exists on our system with that email';                        
               
              }
          
        }catch (PDOException $e) {
              echo $e->getMessage();
          }
                
     }

     private function send_mail($email,$message,$subject)
     {      
       
        require 'plugins/PHPMailer/src/Exception.php';
        require 'plugins/PHPMailer/src/PHPMailer.php';
        require 'plugins/PHPMailer/src/SMTP.php';
       
      $mail = new PHPMailer();
      $mail->IsSMTP(); 
      $mail->SMTPDebug  = 0;                     
      $mail->SMTPAuth   = true;                  
      $mail->SMTPSecure = "ssl";                 
      $mail->Host       = "smtp.gmail.com";      
      $mail->Port       = 465;             
      $mail->AddAddress($email);
      $mail->Username="tt519917@gmail.com";  
      $mail->Password="Alcatelpop4!";            
      $mail->SetFrom('noreply@schoolcloud.ie','School Cloud');
      $mail->AddReplyTo("noreply@schoolcloud.ie","School Cloud");
      $mail->Subject    = $subject;
      $mail->MsgHTML($message);
     
      if(!$mail->send()){
       
       // echo 'Mailer Error: ' . $mail->ErrorInfo;
        $_SESSION['error'] = "Message could not be sent";
        }else{
          
            $_SESSION['success'] = "Message has been sent";
        } 
    }

    public function check_token($token){
        try{
         
            $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE  token=:token");
            $stmt->execute(array(':token' => $token));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
             
                $timeout = $data['reset_timeout'];
                date_default_timezone_set('Europe/Dublin');
                $datetime=date('Y-m-d H:i:s'); //Storing time in variable
                $today_dt =  strtotime($datetime);
                $expire_dt =  strtotime($timeout);
                             
                if ($expire_dt < $today_dt){
                    $_SESSION['error'] = "Reset link has expired";
                                

                }else{
                    echo'
                    <form method="post">
                        
                    <div class="form-group">
                    <label for="usr">Password:</label>
                    <input class="form-control" type="password" id="UserPassword" name="UserPassword" required="required" value="" />

                    <div class="pwstrength_viewport_progress"></div>
                </div>
                <div class="form-group">
                    <label for="usr">Repeat Password:</label>
                    <input class="form-control" type="password" name="RepeatPassword" required="required" id="RepeatPassword" value=""  onChange="checkPasswordMatch();"/>
                </div>

                <div class="form-group">
                    <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                    <div class="registrationFormAlert" id="divCheckPasswordLength"></div>
                    
                </div>
                
                   

                    <div class="row">
                    <div class="col-xs-6">
        
                    </div><!-- /.col -->
                    <div class="col-xs-6">
                      <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-reset" id="resetBtn">Reset Password</button>
                    </div><!-- /.col -->
                  </div>
                 
                    </form>';
                }
            }
        }catch (PDOException $e) {
                echo $e->getMessage();
            }

    }

    public function password_reset($id, $hashedpassword){
        try{
            $stmt = $this->db->prepare("SELECT * FROM users WHERE  id=:id LIMIT 1");
            $stmt->execute(array(':id' => $id));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $username = $data['user_username'];
                $email = $data['user_email'];
                $uname = $data['user_name'];
                $usurname = $data['user_surname'];

                $sqlUpdate = 'UPDATE users set user_pass=:user_pass where id=:id';
                $update = $this->db->prepare($sqlUpdate);
                $update->execute(array(':user_pass' => $hashedpassword, ':id' => $id));

                //keep this in logs too
                $message = "Password reset";
                date_default_timezone_set('Europe/Dublin');
                $datetime=date('Y-m-d H:i:s'); //Storing time in variable
                $ip = $_SERVER['REMOTE_ADDR']; //getting the IP Address
                $this->log_in_db($ip, $datetime, $username, $message);

                

                $message="Hello ".$uname." ".$usurname.",";
                $message.= " <br /><br />";
                $message.= "This is to inform you that your password has been updated.<br/>";
                $message.= "If you did not perform this action, please contact us immediately"; 
                $message.="<br /><br /> Regards,";   
                $message.="<br /><br /> SchoolCloud";           
                $subject='Password reset confirmation';         
                $this->send_mail($email,$message,$subject);

                $_SESSION['success'] = "Password has been updated succesfully";
                header('Location: index.php');
                            
            }
            else{
                $_SESSION['error'] = "There has been a problem updating your password.";
            }

        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
}
?>