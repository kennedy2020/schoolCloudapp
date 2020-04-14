<?php



class School
{


    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }


    public function schoolDetails($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role LIMIT 1");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                echo '
                <ul class="sidebar-schoolName">
                 <li class="header">' . $userRow['SchoolName'] . '</li>
                 <li class="reg_number">' . $userRow['RoleID'] . '</li>
                </ul>
                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function schoolName($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role LIMIT 1");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                echo '
                <ul class="sidebar-schoolName">
                 <li class="header">' . $userRow['SchoolName'] . '</li>

                </ul>
                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function schoolNameOnly($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role LIMIT 1");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $name =  $userRow['SchoolName']   ;
                return $name;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function schoolLogo($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role LIMIT 1");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                echo '
                      <img src="' . $userRow['SchoolLogo'] . '" class="img-logo" width="160" height="160" alt="' . $userRow['SchoolName'] . ' Logo">


                </ul>
                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function schoolLogoBig($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role LIMIT 1");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                echo '


                      <img class="logo_big" src="' . $userRow['SchoolLogo'] . '" class="img-logo" width="600px" height="600px"
                         alt="' . $userRow['SchoolName'] . ' Logo">



                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function schoolLogoNews($roleNo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role ");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                echo '


                      <img class="img-circle" src="' . $userRow['SchoolLogo'] . '" class="img-logo"
                         alt="' . $userRow['SchoolName'] . ' Logo">


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function getDetails($roleNo, $detail)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool WHERE  RoleID=:role ");
            $stmt->execute(array(':role' => $roleNo));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                echo $userRow[$detail];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //update the name
    public function updateName($roleNo, $name)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolName=:name where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':name' => $name, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //update the alias
    public function updateAlias($roleNo, $knownAs)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set KnownAs=:knownAs where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':knownAs' => $knownAs, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

//update the alias
    public function updateRole($roleNo, $role)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set RoleID=:role where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE users set school_role_no=:role where school_role_no=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE HotLinks set school_role_no=:role where school_role_no=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE attendance set school_role=:role where school_role=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE LatestNews set SchoolRoleNo=:role where SchoolRoleNo=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE parents_pupils set SchoolRoleNo=:role where SchoolRoleNo=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE tblClassroom set RoleNumber=:role where RoleNumber=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE tblParents set SchoolRoleNumber=:role where SchoolRoleNumber=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE tblStudents set school_role_no=:role where school_role_no=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            $sqlUpdate = 'UPDATE Teachers set School_role_no=:role where School_role_no=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':role' => $role, ':id' => $roleNo));

            header("Location: ../index.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //update the principal
    public function updatePrincipal($roleNo, $principal)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolPrincipal=:principal where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':principal' => $principal, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //update the email
    public function updateEmail($roleNo, $email)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolEMail=:email where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':email' => $email, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //update the email
    public function updateEmail2($roleNo, $email)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set ArchiveEmail=:email where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':email' => $email, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //update the website
    public function updateWebsite($roleNo, $web)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolWeb=:web where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':web' => $web, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //update the phone
    public function updatePhone($roleNo, $phone)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolPhone01=:phone where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':phone' => $phone, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    //update the fax
    public function updateFax($roleNo, $fax)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolFax=:fax where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':fax' => $fax, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    //update the address
    public function updateAddress($roleNo, $address1, $address2, $address3, $address4, $county)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolAddress01=:address01, SchoolAddress02=:address02, SchoolAddress03=:address03, SchoolAddress04=:address04, County=:county where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':address01' => $address1,
                ':address02' => $address2,
                ':address03' => $address3,
                ':address04' => $address4,
                ':county' => $county, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


//update the eircode
    public function updateEircode($roleNo, $eircode)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolEircode=:eircode where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':eircode' => $eircode, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

//update the logo
    public function updateLogo($roleNo, $logoPath)
    {
        try {
            $sqlUpdate = 'UPDATE tblSchool set SchoolLogo=:logoPath where RoleID=:id';
            $update = $this->db->prepare($sqlUpdate);
            $update->execute(array(':logoPath' => $logoPath, ':id' => $roleNo));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllSchools()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                echo '
<tr>
                <td>' . $row['RoleID'] . '</td>
                <td>' . $row['SchoolName'] . '</td>
                <td>' . $row['SchoolAddress04'] . '</td>

                <td>' . $row['SchoolPhone01'] . '</td>

                <td>' . $row['SchoolEMail'] . '</td>
                <td>' . $row['ArchiveEmail'] . '</td>

                <td>' . $row['SchoolPrincipal'] . '</td>

                 <td>
                    <a class="btn btn-sm btn-primary " type="button"
                       data-toggle="modal"
                       data-target="#school_edit" data-id="' . $row['RoleID'] . '"><i class="fa fa-pencil"></i> Edit</a>



                    <a class="btn btn-sm btn-danger " type="button"
                       data-toggle="modal"
                       data-target="#school_delete" data-id="' . $row['RoleID'] . '"><i class="fa fa-trash"></i> Delete</a>


                  </td>
                  </tr>


                ';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getSchoolsByRole()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tblSchool Group By RoleID");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                echo '<option value = "'.$row['RoleID'].'">'.$row['RoleID'].'- '.$row['SchoolName'].'</option>';
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function SetNewSchool($roleNo, $name, $KnownAs, $address1, $address2, $address3, $address4, $county, $Eircode, $Phone, $Fax, $email, $email2, $website, $principal, $logo)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tblSchool(RoleID, SchoolName, KnownAs, SchoolAddress01, SchoolAddress02, SchoolAddress03, SchoolAddress04, County, SchoolEircode, SchoolPhone01, SchoolFax, SchoolEMail, ArchiveEmail, SchoolWeb, SchoolPrincipal,SchoolLogo)VALUES(:role, :Sname, :alias, :address1, :address2, :address3, :address4, :county, :eircode, :phone, :fax, :email, :archiveemail, :web, :principal, :logo)");

            $stmt->bindparam(":role", $roleNo);
            $stmt->bindparam(":Sname", $name);
            $stmt->bindparam(":alias", $KnownAs);
            $stmt->bindparam(":address1", $address1);
            $stmt->bindparam(":address2", $address2);
            $stmt->bindparam(":address3", $address3);
            $stmt->bindparam(":address4", $address4);
            $stmt->bindparam(":county", $county);
            $stmt->bindparam(":eircode", $Eircode);
            $stmt->bindparam(":phone", $Phone);
            $stmt->bindparam(":fax", $Fax);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":archiveemail", $email2);
            $stmt->bindparam(":web", $website);
            $stmt->bindparam(":principal", $principal);
            $stmt->bindparam(":logo", $logo);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function DeleteSchool($SchoolRole)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tblSchool WHERE  RoleID=:roleNo");

            $stmt->bindparam(":roleNo", $SchoolRole);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}//end of school class




?>