<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/db/connect2.php';
class location{

    //public $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }

    //get sublocations;
    public function getLocations(){
        $sql = 'SELECT location.id as locationid, location.name AS locationname
       FROM location
	   ORDER BY location.id ASC';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $locations = $stmt -> fetchAll();
                return $locations;
            }else{
                return FALSE;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO get locations';
            $error2 = $e -> getMessage();
            echo "<h1 style='background: brown; color: white;'>".$e -> getMessage()." this is error id() </h1>";

            echo $error ."<br> ". $error2;
            //include $_SERVER['DOCUMENT_ROOT'].'/ntytr/includes/errors/error.html.php';
            exit();

        }
    }
//end of getlocations;

    //get sublocations;
    public function getSubLocations(){
        $sql = 'SELECT sublocation.id as sublocationid,
       sublocation.name AS sublocationname, sublocation.locationid as locationid
       FROM sublocation ORDER BY sublocation.name ASC';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $sublocations = $stmt -> fetchAll();
                return $sublocations;
            }else{
                return FALSE;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO get sublocations';
            $error2 = $e -> getMessage();
            echo "<h1 style='background: brown; color: white;'>".$e -> getMessage()." this is error id() </h1>";

            echo $error ."<br> ". $error2;
            //include $_SERVER['DOCUMENT_ROOT'].'/ntytr/includes/errors/error.html.php';
            exit;

        }
    }
//end of getsublocations;
//get sublocations;
    public function getLocationSubLocations($locationid){
        $sql = 'SELECT sublocation.id as sublocationid, sublocation.name AS sublocationname
       FROM sublocation
	   INNER JOIN location ON sublocation.locationid = location.id
	   WHERE location.id = :locationid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":locationid", $locationid);
            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $sublocations = $stmt -> fetchAll();
                return $sublocations;
            }else{
                return FALSE;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET THIS sublocations';
            $error2 = $e -> getMessage();
            echo "<h1 style='backgrond: brown; color: white;'>".$error2."hi here</h1>";      //include $_SERVER['DOCUMENT_ROOT'].'/ntytr/includes/errors/error.html.php';
            exit();

        }
    }
//end of getlaga;

//get locationusers;
    public function getlocationusersByRole($locationid, $roleid){
        $sql = 'SELECT user.id, firstname, surname, profilepic,role.name,location.name FROM user
	   INNER JOIN role ON user.roleid = role.id
	   INNER JOIN location ON user.locationid = location.id
	   WHERE (location.id = :locationid AND role.id = :roleid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":locationid", $locationid);
            $stmt -> bindParam(":roleid", $roleid);

            $stmt -> execute();

            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $users = $stmt -> fetchAll();
                return $users;
            }else{
                return FALSE;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET location USERs BY ROLES';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/ntytr/includes/errors/error.html.php';
            exit();

        }
    }
//end of getlocationusersbyrole;


}

//end of location class;

//class sublocation;
class sublocation extends location{

//get locationusers;
    public function getsublocationUsersByRole($sublocationid, $roleid){
        $sql = 'SELECT user.id, firstname, surname, profilepic,role.name FROM user
	   INNER JOIN role ON user.roleid = role.id
	   INNER JOIN sublocation ON user.sublocationid = sublocation.id
	   WHERE (sublocation.id = :sublocationid AND role.id = :roleid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":sublocationid", $sublocationid);
            $stmt -> bindParam(":roleid", $roleid);

            $stmt -> execute();

            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $sublocations = $stmt -> fetchAll();
                return $sublocations;
            }else{
                return FALSE;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET sublocation USERs BY ROLES';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/ntytr/includes/errors/error.html.php';
            exit();

        }
    }
//end of getlocationusersbyrole;

}
//end of sublocation class;
/*$lo = new location();

echo "<h1 style='backgrond: brown; color: white;'>".$lo->getLocationSubLocations(1)."hi here</h1>";*/
?>