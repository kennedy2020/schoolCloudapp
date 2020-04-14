<?php


class News
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

    public function getLatestNews($roleNo)
    {
        try {
            $today = date("Y-m-d");

            $stmt = $this->db->prepare("SELECT * FROM LatestNews WHERE  SchoolRoleNo=:role AND end>=:today");

            $stmt->execute(array(':role' => $roleNo, ':today'=>$today));
            while ($row = $stmt->fetch()) {
                $start = date("d/m/Y", strtotime($row['start']));
                $end = date("d/m/Y", strtotime($row['end']));

                echo '

                <div class="box-body">
                 <span class="text-muted pull-right padding-20"><i class="fa fa-clock-o"></i> Start: '.$start.'</span><br />
                  <span class="text-muted pull-right padding-20"><i class="fa fa-clock-o"></i> End: '.$end.'</span>
                <!-- post text -->
                <p>'.$row['content'].'</p>

              </div><!-- /.box-body -->

               <hr class="blue_border" />

              ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function setLatestNews($roleNo, $message, $start, $end)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO LatestNews(content, start, end, SchoolRoleNo) VALUES (:content, :start, :end, :role )");

            $stmt->bindparam(":content", $message);
            $stmt->bindparam(":start", $start);
            $stmt->bindparam(":end", $end);
            $stmt->bindparam(":role", $roleNo);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getNewsByClassroom($roleNo, $ClassroomId)
    {
    }
}


?>