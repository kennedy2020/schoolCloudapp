<?php

/* Values received via ajax */
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// connection to the database
try {
    $bdd = new PDO('mysql:host=localhost;dbname=SchoolCloud', 'root', '');
} catch(Exception $e) {
    exit('Unable to connect to database.');
}
// update the records
$sql = "UPDATE SchoolCalendar SET title=?, start=?, end=? WHERE id=?";
$q = $bdd->prepare($sql);
$q->execute(array($title,$start,$end,$id));
?>