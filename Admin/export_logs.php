<?php require_once '../includes/dbconfig.php';
 $user->is_loggedin();
 $user->isAdmin();


if (isset($_POST['download'])) {  

  $logs->download_logs();

}