<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/advert/advert.class.php';
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';


//get adverts by property;

if(isset($_GET['getadverts'])){
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['userid'])){
        $error = 'please login as admin first';
        header("Location: /api/user/");
        exit;
    }
    $userid = $_SESSION['userid'];
    $value = htmlspecialchars($_GET['value']);
    $property = htmlspecialchars($_GET['pty']);
    $property_alias = htmlspecialchars($_GET['property-alias']);

    if(($property == 'all')){
        $property = 'wq';
        $value = 'advert.id > 0 ';
    }

    $pgn = (empty($_GET["pgn"])? 0: htmlspecialchars($_GET["pgn"]));
    $amtperpage = 10;



    $presql = 'SELECT count(*) FROM advert INNER JOIN user ON advert.userid = user.id
                INNER JOIN focalarea ON advert.focalareaid = focalarea.id
                INNER JOIN placement ON advert.placementid = placement.id WHERE ';

    if(($property == 'wq') ){
        $sql = $presql.$value;
    }else{
        $sql = $presql.'advert.'.$property.' = :value';
    }

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt->bindParam(":value",$value);
        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count the adverts";
        $error2 = $e -> getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit;
    }

    $no_of_pages = ceil($counter[0] / $amtperpage);

    $advert = new advert();
    if($adverts = $advert -> getadverts($property, $value,0,10)){
        $advert->updateAdminLastAdvertsCount($userid);
        $title = "Welcome";
    }
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/adverts.html.php';
    exit;
}

if(isset($_POST["placead"])){

    require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";
    //for focal area id
    if(!isset($_SESSION)){
        session_start();
    }

    //check log in;
    if(!isset($_SESSION['userid'])){
        $output = "you are not logged in";
        header("Location: /api/user/index.php");
        exit;
    }
    //check login
    //validate name;
    if((trim($_POST["title"]) == "")){
        $error = "title is empty";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/placead.html.php';
        exit;
    }

    //validate ad url
    if((!empty($_POST['adverturl'])) && !filter_var($_POST["adverturl"],FILTER_VALIDATE_URL)){
        $error = "Invalid url, please put a valid web url";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/placead.html.php';
        exit;
    }

    //validate categoryid
    if(!preg_match("/^[0-9]+$/", $_POST["cid"])){
        $error = "Invalid category, please select a category";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/placead.html.php';
        exit;
    }
    //validate amount
    if(!preg_match("/^[0-9]+(\.[0-9]*)?$/", $_POST["amount"])){
        $error = "Invalid Amount, please put only digits in amount";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/placead.html.php';
        exit;
    }



    $userid = $_SESSION["userid"];
    $title = htmlspecialchars($_POST["title"]);
    $adverturl = (empty($_POST["adverturl"])? null : htmlspecialchars($_POST["adverturl"]));
    $detail = (empty($_POST["detail"])? null : htmlspecialchars($_POST["detail"]));
    $faid = 1;
    $amount = htmlspecialchars($_POST["amount"]);
    $categoryid = htmlspecialchars($_POST["cid"]);
    $placementid = (empty($_POST["placementid"])? 4 : htmlspecialchars($_POST["placementid"]));
    $dateofpublication = date("Ymdhis");

//validate article image file;
    $folder = "/api/img/adverts/";
    $uploadfileformname = "advertimagedisplayname";
    $filetitle = $title;

    if($file= storeImageFile($uploadfileformname,$folder,$filetitle)){
        $advertimagedisplayname = $file["displayname"];
        $imagefile = $file["filename"];
    }else{
        $error = "No image stored or unsupported image format, please add an advert image";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/placead.html.php';
        exit;
    }

    $advert = new advert();
    if($advert->placeAd($title,$adverturl,$detail,$imagefile,$advertimagedisplayname,$dateofpublication,$amount,$userid,$categoryid,$placementid,$faid)){
        $output = "Thanks For Your advert, advert Recorded";
        header("Location: /api/user/index.php?output=".$output);
        exit;
    }
    $error = "Sorry, advert not recorded";
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit;
}


if(isset($_POST['editadvert'])){
    $value = htmlspecialchars($_POST['value']);
    $property = htmlspecialchars($_POST['pty']);
    $advertid = htmlspecialchars($_POST['advertid']);

    $advert= new advert();
    if($advert->updateAdvertProperty($advertid, $property,$value)){
        $output = "Advert successfully updated";
    }else{
        $output = "No changes made";
    }
    header("Location: /api/advert/?getadverts&pty=all&value=all&property-alias=all&output=".$output);
    exit;
}
?>