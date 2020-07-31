<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
class Donation{

    protected $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }

    public function getDonations($amtperpage, $pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }


        $sql = '(SELECT donation.id as donationid, donation.email,
                donation.mobile, donation.firstname, donation.profilepic, amount,
                dateofpledge, donation.note as note, donation.focalareaid, focalarea.name as focalareaname
                FROM donation INNER JOIN focalarea ON donation.focalareaid = focalarea.id
                ORDER BY donation.id DESC LIMIT '.$offset.','.$limit.' )';

        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $donations = $stmt -> fetchAll();


        }
        catch(PDOException $e){
            $error = ' no donations found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        if($rowscount > 0){
            return $donations;
        }
    return false;
    }


    public function checkForNewDonations($userid){


        $sql = "SELECT (SELECT count(*) FROM donation) - (SELECT lastdonationcount FROM user WHERE user.id = ".$userid.") AS newdonations";


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $donations = $stmt -> fetch();


        }
        catch(PDOException $e){
            $error = 'SQL unable to check for new donations';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        if($donations["newdonations"] > 0 ){
            return $donations["newdonations"];
        }
        return false;
    }


    public function makeDonation($firstname,$surname,$email,$mobile,$profilepic,$amount,$focalareaid,$note){
        $sql = "INSERT INTO donation (firstname,surname,email,mobile,profilepic,amount,focalareaid,dateofpledge,note)
                VALUES (:firstname,:surname,:email,:mobile,:profilepic,:amount,:focalareaid,NOW(), :note)";


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt->bindParam(":firstname", $firstname);
            $stmt->bindParam(":surname", $surname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":mobile", $mobile);
            $stmt->bindParam(":profilepic", $profilepic);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":focalareaid", $focalareaid);
            $stmt->bindParam(":note", $note);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error = $e -> getMessage().' donations not recorded ';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        if($rowscount > 0){
            return true;
        }
        return false;
    }

    public function updateDontion($fullname,$email,$mobile,$profilepic,$amount,$focalareaid,$note,$donationid){
        $sql = "UPDATE donation SET
         firstname = :fullname,
         email = :email,
         mobile = :mobile,
         profilepic = :profilepic,
         amount = :amount,
         focalareaid = :focalareaid,
         note = :note
         WHERE donation.id = :donationid";


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":mobile", $mobile);
            $stmt->bindParam(":profilepic", $profilepic);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":focalareaid", $focalareaid);
            $stmt->bindParam(":note", $note);
            $stmt->bindParam(":donationid", $donationid);

            $stmt -> execute();

            return true;
        }
        catch(PDOException $e){
            $error = ' donation not updated';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }

    }
//end of update donation;

    public function updateAdminLastDontionCount($userid){
        $sql = "UPDATE user SET lastdonationcount =
         (SELECT count(*) FROM donation)
         WHERE user.id = ".$userid;


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt -> execute();

            return true;
        }
        catch(PDOException $e){
            $error = 'no donations not updated';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }

    }
//end of getarticle;
}
?>