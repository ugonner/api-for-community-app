<?php
//require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/cors.php';
header('Access-Control-Allow-Origin: *');
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/inputsanitizer.php';
require_once $_SERVER["DOCUMENT_ROOT"]. "/api/user/user.class.php";
if(!isset($_SESSION)){
    session_start();
}
$formname = (empty($_FILES['userprofilepic']['name'])? $_POST['name']: $_FILES['userprofilepic']['name']);
$destination = $_SERVER["DOCUMENT_ROOT"].'/api/img/users/'.time().$formname;
$imageurl = "/api/img/users/".time().$formname;
$userid = (empty($_SESSION["userid"])? $_POST["userid"] : $_SESSION["userid"]);
/*$results = "0";
$message = $userid." the userid ".$_POST["userid"]." input";
echo json_encode(array('results'=>$results, "message"=>$message));
exit;*/

if($results = move_uploaded_file($_FILES['userprofilepic']['tmp_name'],$destination)){
    $user = new user();


    $sql = 'SELECT profilepic FROM user WHERE user.id = '.$userid;

    try{
        //$stmt = $user->db -> prepare($sql);

        $db = new Dbconn();
        $dbh = $db->dbcon;
        $stmt = $dbh->prepare($sql);
        $stmt -> execute();
        $user_profilepic = $stmt -> fetch()[0];
    }
    catch(PDOException $e){
        $error = $e -> getMessage();
        return false;
    }
    if(!empty($user_profilepic)){
        if(file_exists($_SERVER["DOCUMENT_ROOT"].$user_profilepic)){
            unlink($_SERVER["DOCUMENT_ROOT"].$user_profilepic);
        }
    }

    if($results = $user->editUser($userid,"profilepic", $imageurl)){
        $message = 'file uploaded and saved';
    }else{
        $message = 'file not uploaded';
    }

}else{
    $results = 0;
    $message = 'no upload'. $_FILES['userprofilepic']['name'];
}

echo json_encode(array('results'=>$results, "message"=>$message));
exit;
?>