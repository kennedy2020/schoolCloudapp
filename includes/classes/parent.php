<?php



class Parents
{

    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function getAllParents($roleNo)
    {
        try {
            $stmts = $this->db->prepare("SELECT * FROM tblParents WHERE  SchoolRoleNo=:id ");

            $stmts->execute(array(':id' => $roleNo));
            while ($row = $stmts->fetch()) {
                $pparent = $row['PrimaryParent'];


                echo '
<tr>
                  <td>' . $row['ParentFN'] . '</td>
                  <td>' . $row['ParentSN'] . '</td>
                  <td><div class="checkbox">
  <label><input type="checkbox" value="1"
  ';

                if ($pparent == 1) {
                    echo 'checked="checked"';
                }
                echo '
                ></label>
</div></td>
                  <td>' . $row['ParentContactNo'] . '</td>
                  <td>' . $row['ParentEMail'] . '</td>

                  <td>
                    <a class="btn btn-sm btn-primary " type="button"
                       data-toggle="modal"
                       data-target="#edit_parent" data-id="' . $row['ParentsID'] . '"><i class="fa fa-pencil"></i> Edit</a>



                    <a class="btn btn-sm btn-danger " type="button"
                       data-toggle="modal"
                       data-target="#delete_parent" data-id="' . $row['ParentsID'] . '"><i class="fa fa-trash"></i> Delete</a>

                    <a class="btn btn-sm btn-warning " type="button" href="family_tree.php?parentID=' . $row['ParentsID'] . '" ><i class="fa fa-users"></i> View Family Members</a>

                    <a class="btn btn-sm btn-info " type="button"
                       data-toggle="modal"
                       data-target="#assign_pupil" data-id="' . $row['ParentsID'] . '"><i class="fa fa-user-times"></i> Add Pupil to family</a>



                  </td>
                </tr>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function AddParent($id, $roleNo, $name, $surname, $primary, $parent_contactNo, $email)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tblParents(ParentsID, SchoolRoleNo, ParentFN, ParentSN, ParentContactNo, ParentEMail, PrimaryParent) VALUES(:parentId, :roleNo, :name, :surname, :ParentContactNo, :ParentEMail, :PrimaryParent)");

            $stmt->bindparam(":parentId", $id);
            $stmt->bindparam(":roleNo", $roleNo);
            $stmt->bindparam(":name", $name);
            $stmt->bindparam(":surname", $surname);
            $stmt->bindparam(":ParentContactNo", $parent_contactNo);
            $stmt->bindparam(":ParentEMail", $email);
            $stmt->bindparam(":PrimaryParent", $primary);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} //end class parent

?>