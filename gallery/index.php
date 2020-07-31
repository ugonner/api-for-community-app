<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/gallery/gallery.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";

//get articles by categories;

if(isset($_GET["getgalleryfiles"])){

    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(*) FROM galleryfile';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);;

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count galleryfiles";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $no_of_pages = ceil($counter[0] / $amtperpage);

    $gallery = new Gallery();
    if($galleryfiles = $gallery->getGalleryFiles($amtperpage,$pgn)){
        require_once $_SERVER['DOCUMENT_ROOT'].'/api/gallery/gallery.html.php';
        exit;
    }
}


if(isset($_GET["deletegalleryfile"])){

    if(empty($_SESSION)){
        session_start();
    }
    $uid = $_SESSION["userid"];
    $admin = new admin();
    if(!$isAdmin = $admin->isAdmin($uid)){
        $error = 'Please You are not looged in as an Admin';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/forms/loginform.html.php";
        exit;
    }

    $pgn = (empty($_GET["pgn"])? 0 : htmlspecialchars($_GET["pgn"]));
    $galleryfileid = (empty($_GET["galleryfileid"])? 0 : htmlspecialchars($_GET["galleryfileid"]));
    $galleryfilename = (empty($_GET["galleryfilename"])? '' : htmlspecialchars($_GET["galleryfilename"]));
    $gallery = new Gallery();
    if(!$deleted = $gallery->deleteFile($galleryfileid,$galleryfilename,1)){
        header("Location: /api/gallery/?getgalleryfiles&pgn=".$pgn);
    }
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/gallery/gallery.html.php";
    exit;
}



if(isset($_POST["addgalleryfiles"])){
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/forms/articleform.html.php";
        exit();
    }
    $dop = date("YmdHis");

    //check if user is owner of post or an admin;
    $uid = $_SESSION["userid"];

    $admin = new admin();
    if(!$isAdmin = $admin->isAdmin($uid)){
        $error = 'Please You are not looged in as an Admin';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/forms/login.html.php";
        exit;
    }


    $gallery = new Gallery();
    $filenamearray = array("articlefile1","articlefile2","articlefile3","articlefile4","articlefile5");

        if(trim($_POST["articlefile1caption"]) == ''){
            $articlefile1caption = 'No Title ';
        }else{
            $articlefile1caption = htmlspecialchars($_POST["articlefile1caption"]);
        }
        if(trim($_POST["articlefile2caption"]) == ''){
            $articlefile2caption = 'No title';
        }else{
            $articlefile2caption = htmlspecialchars($_POST["articlefile2caption"]);
        }
        if(trim($_POST["articlefile3caption"]) == ''){
            $articlefile3caption = 'No title ';
        }else{
            $articlefile3caption = htmlspecialchars($_POST["articlefile3caption"]);
        }

        if(trim($_POST["articlefile4caption"]) == ''){
            $articlefile4caption = 'No title ';
        }else{
            $articlefile4caption = htmlspecialchars($_POST["articlefile4caption"]);
        }

        if(trim($_POST["articlefile5caption"]) == ''){
            $articlefile5caption = 'No title ';
        }else{
            $articlefile5caption = htmlspecialchars($_POST["articlefile4caption"]);
        }

        $filetitlearray = array($articlefile1caption,$articlefile2caption,$articlefile3caption,$articlefile4caption,$articlefile5caption);
        $folder = "/api/img/gallery/";
        if($gallery->addGalleryFile($filenamearray,$folder,$filetitlearray,$dop,$uid)){

            $output = "files uploaded Successfully";
            header("Location:/api/gallery/index.php?getgalleryfiles&output=".$output);
            exit();
        }

}
//edit take;

?>