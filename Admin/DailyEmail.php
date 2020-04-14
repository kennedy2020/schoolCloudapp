<?php

require_once '../includes/dbconfig.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../plugins/PHPMailer/class.phpmailer.php');
include("../plugins/PHPMailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 06/12/15
 * Time: 11:36 AM
 */


/*

I need the email to be contained, if possible to one page.

An email will be automatically sent to each child's Parent/Guardian at 4pm each day, Monday to Friday.

The email will contain the following:

School Name - done
Classroom & Teacher- done
Child's Name-done
Any private information that the Teacher entered on the child.
Class News
Class Calendar for the next 7 days
School News
School Calendar for the next 7 days

Once the email is sent I need all the information to be deleted except for the School and Classroom Diaries.

Layout and the use of colour will be really important.

*/

//$dailyEmail-> GetClassrooms($roleNo);
?>

<style type="text/css">
    body {
    padding-top: 0 !important;
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin:0 !important;
            width: 100% !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
        }
    .tableContent img {
        border: 0 !important;
        display: block !important;
        outline: none !important;
    }
    a{
        color:#382F2E;
    }

    p, h1,h2,ul,ol,li,div{
        margin:0;
        padding:0;
    }

    h1,h2{
        font-weight: normal;
        background:transparent !important;
        border:none !important;
    }

    .contentEditable h2.big,.contentEditable h1.big{
        font-size: 26px !important;
    }

    .contentEditable h2.bigger,.contentEditable h1.bigger{
        font-size: 37px !important;
    }

    td,table{
        vertical-align: top;
    }
    td.middle{
        vertical-align: middle;
    }

    a.link1{
        font-size:13px;
        color:#27A1E5;
        line-height: 24px;
        text-decoration:none;
    }
    a{
        text-decoration: none;
    }

    .link2{
        color:#ffffff;
        border-top:10px solid #27A1E5;
        border-bottom:10px solid #27A1E5;
        border-left:18px solid #27A1E5;
        border-right:18px solid #27A1E5;
        border-radius:3px;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        background:#27A1E5;
    }

    .link3{
        color:#555555;
        border:1px solid #cccccc;
        padding:10px 18px;
        border-radius:3px;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        background:#ffffff;
    }

    .link4{
        color:#27A1E5;
        line-height: 24px;
    }

    h2,h1{
        line-height: 20px;
    }
    p{
        font-size: 14px;
        line-height: 21px;

    }

    .contentEditable li{

    }

    .appart p{

    }
    .bgItem{
        background: #ffffff;
    }
    .bgBody{
        background: #ffffff;
    }

    img {
        outline:none;
        text-decoration:none;
        -ms-interpolation-mode: bicubic;
        width: auto;
        max-width: 100%;
        clear: both;
        display: block;
        float: none;
    }
</style>

<?php
$html="<body paddingwidth=\"0\" paddingheight=\"0\"   style=\"padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;\" offset=\"0\" toppadding=\"0\" leftpadding=\"0\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tableContent bgBody\" align=\"center\"  style='font-family:Helvetica, sans-serif;'>";



//get schools role no
try{
$sql= "SELECT * FROM tblSchool";
$stmt = $DB_con->prepare($sql);
$stmt->execute();

while ($row=$stmt->fetch()){

    $roleNo = $row['RoleID'];
    $schoolName = $row['SchoolName'];
    $logo = $row['SchoolLogo'];

$html.="<table width=\"580\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
                                                        <tr>
                                                            <td width='60'>
                                                                <div class='contentEditableContainer contentImageEditable'>
                                                                    <div class='contentEditable'>
                                                                        <a target='_blank' href=\"[CLIENTS.WEBSITE]\"><img src=\"{$logo}\" alt=\"Logo\" width='60' height='60' data-default=\"placeholder\" data-max-width=\"200\"></a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td width='10'></td>
                                                            <td valign=\"middle\" style='vertical-align: middle;'>
                                                                <div class='contentEditableContainer contentTextEditable'>
                                                                    <div class='contentEditable' style='text-align: left;font-weight: light; color:#555555;font-size:26;line-height: 39px;font-family: Helvetica Neue;'>
                                                                        <h1 class='big' style='color:#444444'>{$schoolName}</h1>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td width='10'></td>
                                                            <td valign=\"middle\" style='vertical-align: middle;' width='150'>
                                                                <div class='contentEditableContainer contentTextEditable'>
                                                                    <div class='contentEditable' style='text-align: right;'>

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>";

   // echo $schoolName;

// get classroom id for each school
    try {
        $stmt2 = $DB_con->prepare("SELECT * FROM tblClassroom JOIN Teachers ON tblClassroom.TeachersID = Teachers.TeachersID WHERE  RoleNumber=:role ");
        $stmt2->execute(array(':role' => $roleNo));

        while ($row2 = $stmt2->fetch()) {
            $classroomId= $row2['ClassroomID'];

            $className = $row2['Class'];
             $teacherName = $row2['Name'].' '.$row2['Surname'];








            try {
                $today = date("Y-m-d");
                $stmt4 = $DB_con->prepare("SELECT * FROM LatestNews WHERE  ClassroomID =:classroom AND end>=:today");
                $stmt4->execute(array(':classroom' => $classroomId, ':today' => $today ));
$news="";
                while ($row4 = $stmt4->fetch()) {
                    $news .= "

 <div class='movableContent'>
              <table width=\"580\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
                <tr><td height='40' colspan=\"3\"></td></tr>
                <tr>
                  <td width='410'>
                    <table width=\"410\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">
                      <tr><td height='15'></td></tr>
                      <tr>
                        <td>
                          <div class='contentEditableContainer contentTextEditable'>
                            <div class='contentEditable' style='text-align: left;'>
                              <h2 style='font-size:16px;'><b>Class News</b></h2>
                              <br>
                              <p>{$row4['content']}</p>
                              <br>

                    </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width='20'></td>
                  <td width='150'>
                    <div class='contentEditableContainer contentImageEditable'>
                      <div class='contentEditable'>
                        <img src=\"images/side2.png\" alt=\"side image\" width='142' height='142' data-default=\"placeholder\" data-max-width=\"150\">
                      </div>
                    </div>
                  </td>
                </tr>
                <tr><td height='40' colspan=\"3\"></td></tr>
                <tr><td colspan=\"3\"><hr style='height:1px;background:#DDDDDD;border:none;'></td></tr>
              </table>
            </div>";

                }
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }



        //get pupils details for each class
            try {
                $stmt3 = $DB_con->prepare("SELECT * FROM tblStudents WHERE  Classroom =:classroom ");
                $stmt3->execute(array(':classroom' => $classroomId));

                while ($row3 = $stmt3->fetch()) {
                      $studentId =array( $row3['StudentID']);


                    foreach( $studentId as $value )
                    {

                        $html2="  <div class='movableContent'>
                                        <table width=\"580\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
                                            <tr><td height='40'></td></tr>
                                            <tr>
                                                <td style='border: 1px solid #EEEEEE; border-radius:6px;-moz-border-radius:6px;-webkit-border-radius:6px'>
                                                    <table width=\"480\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
                                                        <tr><td height='25'></td></tr>
                                                        <tr>
                                                            <td>
                                                                <div class='contentEditableContainer contentTextEditable'>
                                                                    <div class='contentEditable' style='text-align: center;'>
                                                                        <h2 style=\"font-size: 20px;\">Student Name: {$row3['StudentFN']} {$row3['StudentSN']}</h2>
                                                                        <br>
                                                                        <h4>Classroom Name: {$className}</h4>
                                                                         <h4>Teacher Name: {$teacherName}</h4>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr><td height='24'></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>";




                        try {
                            $stmt5 = $DB_con->prepare("SELECT * FROM parents_pupils
                            INNER JOIN tblStudents ON tblStudents.StudentID = parents_pupils.pupil_id
                            INNER JOIN tblParents ON tblParents.ParentsID = parents_pupils.parent_id
                            WHERE  parents_pupils.pupil_id=:student  ");
                            $stmt5->execute(array(':student' => $value));

                            while ($row5 = $stmt5->fetch()) {




                                $parentEmail = $row5['ParentEMail'];
                                $parentName = $row5['ParentFN'].' '.$row5['ParentSN'];

                                //echo $studentId;                   echo $parentEmail;

                                $html3="</table></body>";
                                $body = $html.$html2.$news.$html3;

                                echo $body;


                                $subject="Daily Email";
                                $from ="chendedaniel@yahoo.com";
                                $name = "Daniel chednde";


                                $mail=new PHPMailer();
                                $mail->IsSMTP();
                                $mail->Host       = 'smtp.gmail.com';

                                $mail->SMTPSecure = 'tls';
                                $mail->Port       = 587;
                                $mail->SMTPDebug  = 1;
                                $mail->SMTPAuth   = true;

                                $mail->Username   = 'chendedaniel@gmail.com';
                                $mail->Password   = 'Arad07xup';

                                $mail->SetFrom($from, $name);
                                //$mail->AddReplyTo('no-reply@mycomp.com','no-reply');
                                $mail->Subject = $subject;
                                $mail->MsgHTML($body);
/*
                                                            $mail->AddAddress($parentEmail, $parentName);

                                                                                        if(!$mail->Send()) {
                                                                                            echo "Mailer Error: " . $mail->ErrorInfo;
                                                                                        } else {
                                                                                            echo "Message sent!";
                                                                                        }


                          */


                            }
                        }
                        catch (PDOException $e) {
                            echo $e->getMessage();
                        }


                    }

                  //  $studentName = $row3['StudentFN'].' '.$row3['StudentSN'].'<br /> ';



                    //$body.=  $studentName;
           //   echo $studentId;

/*


*/



              //      $body.=$footer;
                    //get pupils parents email





                }
            }
            catch (PDOException $e) {
                echo $e->getMessage();


                          //  $body = $header1.$schoolLogo.$header2.$schoolName.$header3.$body1.$body2.$body3.$newsContent.$footer;



            }







        }
    }
     catch (PDOException $e) {
        echo $e->getMessage();
    }




}

}
catch (PDOException $e) {
    echo $e->getMessage();
}





    ?>