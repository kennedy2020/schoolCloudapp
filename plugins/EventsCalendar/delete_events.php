<?php
/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 10/12/15
 * Time: 12:10 AM
 */
$sql = "DELETE from evenement WHERE id=".$id;
$q = $bdd->prepare($sql);
$q->execute();

?>