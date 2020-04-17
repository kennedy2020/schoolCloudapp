<?php

session_start();


$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "SchoolCloud";


if (isset($_SESSION['role_no'])){
    $roleNo =  $_SESSION['role_no'];
}

if (isset($_SESSION['user_session'])){
    $id = $_SESSION['user_session'];
}

if (isset($_SESSION['email'])){
    $user_email= $_SESSION['email'];
}


try
{
    $con = mysqli_connect($DB_host,$DB_user,$DB_pass,$DB_name);
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}


include_once 'classes/attendance.php';
include_once 'classes/calendar.php';
include_once 'classes/classroom.php';
include_once 'classes/dailyemail.php';
include_once 'classes/ecard.php';
include_once 'classes/hotlink.php';
include_once 'classes/news.php';
include_once 'classes/parent.php';
include_once 'classes/pupil.php';
include_once 'classes/school.php';
include_once 'classes/teacher.php';
include_once 'classes/user.php';

$user = new USER($DB_con);
$hot_link = new hotlink($DB_con);
$school = new School($DB_con);
$attendance = new attendance($DB_con);
$pupil = new PUPIL($DB_con);
$classroom = new Classroom($DB_con);
$teacher = new teacher($DB_con);
$parents = new Parents($DB_con);
$news = new News($DB_con);
$dailyEmail = new DailyEmail($DB_con);
$calendar = new Calendar($DB_con);

?>