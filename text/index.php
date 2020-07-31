<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/api/admin/admin.class.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/api/user/user.class.php';
include_once $_SERVER["DOCUMENT_ROOT"].'/api/text/text.class.php';

$user = new user();
if(!$user->isLoggedIn()){
    $error = "Please Login With Correct Email / Password Pair";
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/forms/loginform.html.php";
    exit();
}
$admin = new admin();
if($admin->isBlocked($_SESSION["userid"])){
    $error = "You Have Been Blocked From Using This Service, Sorry";
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
    exit();
}



if(isset($_GET['gubp'])){
    //add wuotes for gender values string value;
    $formmatted_value = (htmlspecialchars($_GET['property']) == 'gender' ? "'".htmlspecialchars($_GET['value'])."'" : htmlspecialchars($_GET['value']));
    $value = " ".htmlspecialchars($_GET['property'])." = ".$formmatted_value;
    $property = htmlspecialchars($_GET['property']);

    $property_alias = htmlspecialchars($_GET['property-alias']);

    if(($property == 'dateofbirth') || ($property == 'all')){
        $value = (($property == 'dateofbirth')? 'RIGHT("dateofbirth",5) = '.date("m-d") : 'user.id > 0');
    }else{
        $property = 'wq';
    }

    $pgn = (empty($_GET["pgn"])? 0: htmlspecialchars($_GET["pgn"]));
    $amtperpage = 0;
    $user = new User();
    if($users = $user -> getUsersByProperty($property, $value,$pgn,$amtperpage)){
        $title = "Welcome to ".$property." Room";
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/api/text/text.html.php';
    exit;
}

if(isset($_POST["sendSMSes"])){

    $text = new Text();
    $rxnames = htmlspecialchars($_POST['receiversnames']);
    $rxmobiles = htmlspecialchars($_POST['receiversmobiles']);
    $sendername = htmlspecialchars($_POST['sendername']);

    $message = htmlspecialchars($_POST['message']);
    $names = explode(",",$rxnames);
    $mobiles = explode(",",$rxmobiles);

   // echo $names[2].' count '.count($mobiles).'<br>'.$mobiles[2]."<br>".$rxmobiles;

    $output = $text->sendToMany($sendername,$mobiles,$names,$message);

    //echo $output; exit;

    header("Location: /api/text/text.html.php?output=".$output);
    exit;
}

//send sms to user;
if(isset($_POST["sendSMS"])){
    $rxid = $_POST["userid"];
    $msg = $_POST["message"];
    $senderid = $_SESSION["userid"];
    $text = new Text();
    if($text ->sendToOne($rxid,$msg,$senderid)){
        $output = "SMS sent successfully";
        header("Location:/api/user/index.php?guid=".$rxid);
        exit();
    }else{
        $error = "SMS not sent in index";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}
session_write_close();

?>