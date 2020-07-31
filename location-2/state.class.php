<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/db/connect2.php';

class State{

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }
//get LGAs;

    public function getStates(){
        $sql = 'SELECT state.id, state.name as name FROM state';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $states = $stmt -> fetchAll();
                return $states;
            }else{
                return FALSE;
            }

        }
        catch(PDOException $e){
            $message = 'SQL ERROR UNABLE TO GET STATES ' . $e -> getMessage();
            $results = "0";
            echo array("results"=> $results, "messagee"=> $message );
            exit();

        }
    }
//end of getlaga;

//get LGAs;
public function getStateLGAs($stateid){
   $sql = 'SELECT LGA.id, LGA.name FROM LGA 
	   INNER JOIN state ON LGA.stateid = state.id 
	   WHERE state.id = :stateid';
try{
   $stmt = $this -> db -> prepare($sql);
   $stmt -> bindParam(":stateid", $stateid);
   $stmt -> execute();
   $rowscount = $stmt -> rowCount();

   if($rowscount > 0){
     $LGAs = $stmt -> fetchAll();
     return $LGAs;
   }else{
      return FALSE;
   }
   
 }
  catch(PDOException $e){
      $message = 'SQL ERROR UNABLE TO GET STATES LGAS ' . $e -> getMessage();
      $results = "0";
      echo array("results"=> $results, "messagee"=> $message );
      exit();

  }
}
//end of getlaga;

//get stateusers;
public function getStateusersByRole($stateid, $roleid){
   $sql = 'SELECT user.id, firstname, surname, profilepic,role.name,state.name FROM user
	   INNER JOIN role ON user.roleid = role.id 
	   INNER JOIN state ON user.stateid = state.id 
	   WHERE (state.id = :stateid AND role.id = :roleid)';
try{
   $stmt = $this -> db -> prepare($sql);
   $stmt -> bindParam(":stateid", $stateid);
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
     $error = 'SQL ERROR UNABLE TO GET STATE USERs BY ROLES';
     $error2 = $e -> getMessage();
     include $_SERVER['DOCUMENT_ROOT'].'/bona/includes/errors/error.html.php';
     exit();

  }
}
//end of getstateusersbyrole;


}

//end of state class;

//class LGA;
class LGA extends State{

//get stateusers;
public function getLGAUsersByRole($LGAid, $roleid){
   $sql = 'SELECT user.id, firstname, surname, profilepic,role.name FROM user 
	   INNER JOIN role ON user.roleid = role.id 
	   INNER JOIN LGA ON user.LGAid = LGA.id 
	   WHERE (LGA.id = :LGAid AND role.id = :roleid)';
try{
   $stmt = $this -> db -> prepare($sql);
   $stmt -> bindParam(":LGAid", $LGAid);
   $stmt -> bindParam(":roleid", $roleid);

   $stmt -> execute();

   $rowscount = $stmt -> rowCount();

   if($rowscount > 0){
     $LGAs = $stmt -> fetchAll();
     return $LGAs;
   }else{
      return FALSE;
   }
   
 }
  catch(PDOException $e){
     $error = 'SQL ERROR UNABLE TO GET LGA USERs BY ROLES';
     $error2 = $e -> getMessage();
     include $_SERVER['DOCUMENT_ROOT'].'/bona/includes/errors/error.html.php';
     exit();

  }
}
//end of getstateusersbyrole;


}
/*$state = new State();
$state->getStates();*/
//end of LGA class;
?>