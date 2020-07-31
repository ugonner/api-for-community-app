<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
class advert{

    protected $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }


    public function getadverts($property, $value,$pgn,$amtperpage){
        $limit = ((!empty($pgn)) ? ($pgn*$amtperpage): $amtperpage);


//$presql = 'SELECT advert.id as advertid FROM advert INNER JOIN user ON advert.userid = user.id INNER JOIN focalarea ON advert.focalareaid = focalarea.id INNER JOIN placement ON advert.placementid = placement.id WHERE advert.id>0';

$presql = 'SELECT advert.id as advertid, advert.title,
                adverturl, advert.advertimagedisplayname,
                advert.dateofpublication, amount, paid,advert.
                duration,advert.public AS advertpublic,
                categoryid,focalareaid,placementid,
                user.id as userid, user.firstname AS firstname,
                category.name AS categoryname, focalarea.name AS focalareaname,
                placement.name AS placementname
                FROM advert INNER JOIN user ON advert.userid = user.id
                INNER JOIN category ON advert.categoryid = category.id
                INNER JOIN focalarea ON advert.focalareaid = focalarea.id
                INNER JOIN placement ON advert.placementid = placement.id
                WHERE ';


        //IF property is a wq wherw-query , add the where-query else normal where-clause
        if(($property == 'wq') ){
            $sql = $presql.$value." ORDER BY advert.id DESC LIMIT ".$pgn.", ".$limit;
        }else{
            $sql = $presql.' advert.'.$property.' = :value
	            ORDER BY advert.id DESC LIMIT '.$pgn. ' , '.$limit;
        }

        try{
            $dbh = $this -> db;

            $stmt = $dbh -> prepare($sql);
            if(!($property == 'wq')){
                $stmt->bindParam(":value",$value);
            }

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $adverts = $stmt -> fetchAll();


        }
        catch(PDOException $e){
            $error = ' no adverts found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit;
        }

        if($rowscount > 0){
            return $adverts;
        }
        return false;
    }



    //get published adverts;

    public function getPublishdedAdverts($property, $value,$pgn,$amtperpage){
        $limit = ((!empty($pgn)) ? ($pgn*$amtperpage): $amtperpage);


//$presql = 'SELECT advert.id as advertid FROM advert INNER JOIN user ON advert.userid = user.id INNER JOIN focalarea ON advert.focalareaid = focalarea.id INNER JOIN placement ON advert.placementid = placement.id WHERE advert.id>0';

        $presql = 'SELECT advert.id as advertid, advert.title,
                adverturl, advert.advertimagedisplayname,
                advert.dateofpublication, amount, paid,advert.
                duration,advert.public AS advertpublic,
                categoryid,focalareaid,placementid,
                user.id as userid, user.firstname AS firstname,
                category.name AS categoryname, focalarea.name AS focalareaname,
                placement.name AS placementname
                FROM advert INNER JOIN user ON advert.userid = user.id
                INNER JOIN category ON advert.categoryid = category.id
                INNER JOIN focalarea ON advert.focalareaid = focalarea.id
                INNER JOIN placement ON advert.placementid = placement.id
                WHERE advert.public = "Y" AND ';


        //IF property is a wq wherw-query , add the where-query else normal where-clause
        if(($property == 'wq') ){
            $sql = $presql.$value." ORDER BY advert.id DESC LIMIT ".$pgn.", ".$limit;
        }else{
            $sql = $presql.' advert.'.$property.' = :value
	            ORDER BY advert.id DESC LIMIT '.$pgn. ' , '.$limit;
        }

        try{
            $dbh = $this -> db;

            $stmt = $dbh -> prepare($sql);
            if(!($property == 'wq')){
                $stmt->bindParam(":value",$value);
            }

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $adverts = $stmt -> fetchAll();


        }
        catch(PDOException $e){
            $error = ' no published adverts found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit;
        }

        if($rowscount > 0){
            return $adverts;
        }
        return false;
    }

    public function checkForNewadverts($userid){


        $sql = "SELECT (SELECT count(*) FROM advert) - (SELECT lastadvertcount FROM user WHERE user.id = ".$userid.") AS newadverts";


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $adverts = $stmt -> fetch();


        }
        catch(PDOException $e){
            $error = 'SQL unable to check for new adverts';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        if($adverts["newadverts"] > 0){
            return $adverts["newadverts"];
        }
        return false;
    }


    public function placeAd($title,$adverturl,$detail,$imagefile,$advertimagedisplayname,
	$dateofpublication,$amount,$userid,$categoryid,$placementid,
	$focalareaid){


        $sql = 'INSERT INTO advert (
	title,adverturl,detail,imagefile,advertimagedisplayname,
	dateofpublication,amount,userid,categoryid,placementid,
	focalareaid )
	VALUES (
	:title,:adverturl,:detail,:imagefile,:advertimagedisplayname,
	:dateofpublication,:amount,:userid,:categoryid,:placementid,
	:focalareaid )';



                try{
                    $dbh = $this -> db;
                    $stmt = $dbh -> prepare($sql);

                    $stmt->bindParam(":title", $title);
                    $stmt->bindParam(":adverturl", $adverturl);
                    $stmt->bindParam(":detail", $detail);
                    $stmt->bindParam(":imagefile", $imagefile);
                    $stmt->bindParam(":advertimagedisplayname", $advertimagedisplayname);
                    $stmt->bindParam(":dateofpublication", $dateofpublication);
                    $stmt->bindParam(":amount", $amount);
                    $stmt->bindParam(":userid", $userid);
                    $stmt->bindParam(":categoryid", $categoryid);
                    $stmt->bindParam(":placementid", $placementid);
                    $stmt->bindParam(":focalareaid", $focalareaid);


                    $stmt -> execute();
                    $rowscount = $stmt -> rowCount();

                }
                catch(PDOException $e){
                    $error = $e -> getMessage().' advert not recorded ';
                    $error2 = $e -> getMessage();
                    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                    exit;
                }

        if($rowscount > 0){
            return true;
        }
        return false;
    }

    public function updateAdvertProperty($advertid,$property,$value){
        $sql = "UPDATE advert SET ".$property." = :value
         WHERE advert.id = :advertid";


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt->bindParam(":value", $value);
            $stmt->bindParam(":advertid", $advertid);
            $stmt -> execute();

            return true;
        }
        catch(PDOException $e){
            $error = 'no adverts not updated';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }

    }

    public function updateAdminLastAdvertsCount($userid){
        $sql = "UPDATE user SET lastadvertcount =
         (SELECT count(*) FROM advert)
         WHERE user.id = ".$userid;


        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt -> execute();

            return true;
        }
        catch(PDOException $e){
            $error = 'no adverts not updated';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }

    }
//end of getarticle;
}
?>