<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/donation/donation.class.php';
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';

if(isset($_GET["getdonations"])){

    session_start();
    $uid = $_SESSION["userid"];
    session_write_close();
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(*) FROM donation';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);;

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count donations";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $no_of_pages = ceil($counter[0] / $amtperpage);

    $donation = new Donation();
    if($donations = $donation->getDonations($amtperpage,$pgn)){
        $donation->updateAdminLastDontionCount($uid);
    }
    require_once $_SERVER['DOCUMENT_ROOT'].'/api/donation/donations.html.php';
    exit;
}

if(isset($_POST["makedonation"])){
    //validate name;
    if((trim($_POST["firstname"]) == "")){
        $error = "first name or surname is empty";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit;
    }

    //validate email
    if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        $error = "Invalid Email, please put a valid email";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit;
    }

    //validate amount

    if(!preg_match("/^[0-9]+(\.[0-9]*)?$/", $_POST["amount"])){
        $error = "Invalid Amount, please put only digits in amount";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit;
    }

    //validate mobile
    if(!preg_match("/^[0-9]+$/", $_POST["mobile"])){
        $error = "Invalid Mobile Number, please put only digits in Number";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit;
    }

    //for focal area id
    if(!empty($_POST["faid"])){
        $faid = htmlspecialchars($_POST["faid"]);
    }else{
        $faid = 1;
    }


//validate article image file;

    require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";
    $imagefilecaption = "donors image";
    $folder = "/api/img/donors/";
    $uploadfileformname = "profilepic";
    if($file= storeImageFile($uploadfileformname,$folder,$imagefilecaption)){
        $profilepic = $file["displayname"];
    }else{
        $profilepic = null;
    }

    $fullname = htmlspecialchars($_POST["firstname"]);
    $surname = null;
    $email = htmlspecialchars($_POST["email"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $note = htmlspecialchars($_POST["note"]);

    $donation = new Donation();
    if($donation->makeDonation($firstname,$surname,$email,$mobile,$profilepic,$amount,$faid,$note)){
        $output = "Thanks For Your Donation, Donation Recorded";
        header("Location: /api/donation/index.php?getdonations&pgn=".$pgn."&output=".$output);
        exit;
    }
    $error = "Sorry, Donation not recorded";
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit;
}


if(isset($_POST["updatedonation"])){
    //validate name;
    $donationid = (empty($_POST['donationid'])? 1 : htmlspecialchars($_POST['donationid']));
    $pgn = (empty($_POST['pgn'])? 0 : htmlspecialchars($_POST['pgn']));

    if((trim($_POST["firstname"]) == "") || (trim($_POST["surname"]) == "")){
        $error = "first name or surname is empty";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/donation/?getdonations&pgn='.$pgn;
        exit;
    }

    //validate email
    if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        $error = "Invalid Email, please put a valid email";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/donation/?getdonations&pgn='.$pgn;
        exit;
    }

    //validate amount

    if(!preg_match("/^[0-9]+(\.[0-9]*)?$/", $_POST["amount"])){
        $error = "Invalid Amount, please put only digits in amount";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/donation/?getdonations&pgn='.$pgn;
        exit;
    }

    //validate mobile
    if(!preg_match("/^[0-9]+$/", $_POST["mobile"])){
        $error = "Invalid Mobile Number, please put only digits in Number";
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/donation/?getdonations&pgn='.$pgn;
        exit;
    }

    //for focal area id
    if(!empty($_POST["faid"])){
        $faid = htmlspecialchars($_POST["faid"]);
    }else{
        $faid = $_POST['focalareaid-original'];
    }

    require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";

//validate article image file;
    $imagefilecaption = "donors image";
    $folder = "/api/img/donors/";
    $uploadfileformname = "profilepic";
    if($file= storeImageFile($uploadfileformname,$folder,$imagefilecaption)){
        $profilepic = $file["displayname"];
    }else{
        $profilepic = $_POST['profilepic-original'];
    }

    $fullname = htmlspecialchars($_POST["firstname"]);
    $email = htmlspecialchars($_POST["email"]);
    $mobile = htmlspecialchars($_POST["mobile"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $note = htmlspecialchars($_POST["note"]);

    $donation = new Donation();
    if($donation->updateDontion($fullname,$email,$mobile,$profilepic,$amount,$faid,$note,$donationid)){
        $output = "Update Donation Recorded";
        header("Location: /api/donation/index.php?getdonations&pgn=".$pgn."&output=".$output);
        exit;
    }

    $error = "Sorry, Donation not recorded";
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit;
}
?>