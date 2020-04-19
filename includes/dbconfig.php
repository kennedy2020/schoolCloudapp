<?php

session_start();
session_regenerate_id();

date_default_timezone_set('Europe/Dublin');


error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

ini_set('ignore_repeated_errors', TRUE); // always use TRUE

ini_set('display_errors', TRUE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment

ini_set('log_errors', TRUE); // Error/Exception file logging engine.
ini_set('error_log', '../logs/errors.log'); // Logging file path
ini_set('log_errors_max_len', 1024); // Logging file size



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
include_once 'classes/log.php';

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
$logs = new LOG($DB_con);

?>