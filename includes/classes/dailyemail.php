<?php

include_once 'school.php';
class DailyEmail extends School
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }
}

?>