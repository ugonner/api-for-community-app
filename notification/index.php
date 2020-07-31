<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/article.class.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/product/product.class.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/notification.class.php";



if(isset($_GET["getusernotifications"])){

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $notification = new Notification();
    $notcount = $notification->getCountAllUserNotifications($uid);

    $no_of_pages = ceil($notcount / $amtperpage);

    if(!$notifications = $notification->getUserNotificationPosts($uid,$amtperpage,$pgn)){
        $error = "article Must Have Been Deleted Or Is Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }else{
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/notifications.html.php";
        exit();
    }
}

//get notification on user post=;
if(isset($_GET["getuserpostnotifications"])){

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $notification = new Notification();
    $notcount = $notification->getCountNotificationOnUserPosts($uid);


    $no_of_pages = ceil($notcount / $amtperpage);
    if(!$notifications = $notification->getNotificationOnUserPosts($uid,$amtperpage,$pgn)){
        $error = "nO Notifications Found";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }else{
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/usernotifications.html.php";
        exit();
    }
}


if(isset($_GET["requests"])){

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $notification = new Notification();
    $notcounter = $notification->getCountUserRequests($uid);
    $notcount = $notcounter[0];

    $no_of_pages = ceil($notcount / $amtperpage);
    $trz = new Notification();
    if($notifications = $trz->getUserRequests($uid,$pgn,$amtperpage)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/requests.html.php";
        exit();
    }else{
        $error = "Transations notifications Must Have Been Deleted Or Is Not Sanctioned";
        $output = "No Transations notifications Must Have Been Deleted Or Is Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/requests.html.php";
        exit();
    }
}
//GET TRANSACTION NOTIFICATIONS;

if(isset($_GET["sales"])){

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $notification = new Notification();
    $notcounter = $notification->getCountUserSales($uid);

    $notcount = $notcounter[0];

    $no_of_pages = ceil($notcount / $amtperpage);
    if($notifications = $notification->getUserSales($uid,$pgn,$amtperpage)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/userproductnotifications.html.php";
        exit();
    }else{
        $error = "Transations notifications Must Have Been Deleted Or Is Not Sanctioned";
        $output = "No Transations notifications Must Have Been Deleted Or Is Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/userproductnotifications.html.php";
        exit();
    }

}

//GET PRODUCT NOTIFICATONS;
if(isset($_GET["getuserproductnotifications"])){

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $notification = new Notification();
    $notcount = $notification->getCountAllUserProductNotifications($uid);

    $no_of_pages = ceil($notcount / $amtperpage);

    if(!$notifications = $notification->getUserNotificationOnProductPosts($uid,$amtperpage,$pgn)){
        $error = "Products notifications Must Have Been Deleted Or Is Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }else{
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/productnotifications.html.php";
        exit();
    }
}


if(isset($_GET["getuserproductpostnotifications"])){

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $notification = new Notification();
    $notcount = $notification->getCountNotificationOnUserProductPosts($uid);

    $no_of_pages = ceil($notcount / $amtperpage);

    if(!$notifications = $notification->getNotificationOnUserProductPosts($uid,$amtperpage,$pgn)){
        $error = "Products notifications Must Have Been Deleted Or Is Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }else{
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/userproductnotifications.html.php";
        exit();
    }
}


?>