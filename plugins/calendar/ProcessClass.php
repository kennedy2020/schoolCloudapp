<?php
require_once '../../includes/dbconfig.php';

if (isset($_SESSION['role_no'])){
    $roleNo =  $_SESSION['role_no'];
}

$classroomId=$_POST['ClassroomID'];

$type = $_POST['type'];

if($type == 'new')
{
    $classroomId=$_POST['ClassroomID'];
	$startdate = $_POST['startdate'].'+'.$_POST['zone'];
	$title = $_POST['title'];
   	$insert = mysqli_query($con,"INSERT INTO classcalendar(`title`, `startdate`, `enddate`, `SchoolRoleNo`, 'ClassroomID', `allDay`) VALUES('$title','$startdate','$startdate', '$roleNo','$classroomId', 'false')");
	$lastid = mysqli_insert_id($con);
	echo json_encode(array('status'=>'success','eventid'=>$lastid));
}

if($type == 'changetitle')
{
	$eventid = $_POST['eventid'];
	$title = $_POST['title'];
	$update = mysqli_query($con,"UPDATE classcalendar SET title='$title' where id='$eventid'");
	if($update)
		echo json_encode(array('status'=>'success'));
	else
		echo json_encode(array('status'=>'failed'));
}

if($type == 'resetdate')
{
	$title = $_POST['title'];
	$startdate = $_POST['start'];
	$enddate = $_POST['end'];
	$eventid = $_POST['eventid'];
	$update = mysqli_query($con,"UPDATE classcalendar SET title='$title', startdate = '$startdate', enddate = '$enddate' where id='$eventid'");
	if($update)
		echo json_encode(array('status'=>'success'));
	else
		echo json_encode(array('status'=>'failed'));
}

if($type == 'remove')
{
	$eventid = $_POST['eventid'];
	$delete = mysqli_query($con,"DELETE FROM classcalendar where id='$eventid'");
	if($delete)
		echo json_encode(array('status'=>'success'));
	else
		echo json_encode(array('status'=>'failed'));
}

if($type == 'fetch')
{
	$events = array();
	$query = mysqli_query($con, "SELECT * FROM classcalendar WHERE SchoolRoleNo ='$roleNo' AND ClassroomID = '$classroomId'");
	while($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC))
	{
	$e = array();
    $e['id'] = $fetch['id'];
    $e['title'] = $fetch['title'];
    $e['start'] = $fetch['startdate'];
    $e['end'] = $fetch['enddate'];

    $allday = ($fetch['allDay'] == "true") ? true : false;
    $e['allDay'] = $allday;

    array_push($events, $e);
	}
	echo json_encode($events);
}


?>