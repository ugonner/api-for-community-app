<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/cors.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/inputsanitizer.php';


include_once $_SERVER['DOCUMENT_ROOT'].'/api/group/group.class.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/admin/admin.class.php';


//update token;
if(isset($input['getgroups'])){
//echo 'got here at groups'; exit;
    $group = new Group();
    $message = "got the groups";
    if(!$results = $group->getGroups()){
        $results = "0";
        $message = 'unable to get groups';
    }

    echo json_encode(array("results"=>$results,"message" => $message));
    exit;
}


//get articles by categories;
if(isset($input["getgroup"])){
    $groupid = $input["groupid"];
    $tableid = $input["gltn"];

    $groupleveltablename = 'grouplevel'.$tableid;
    $group = new Group();
    if(!$results = $group->getGroup($groupleveltablename,$groupid)){
        $message = "group not found";
        $results = "0";
    }else{
        $output = "No More activitiss In This Category Or It's Not Sanctioned";
        $message = "Welcome to ".$results["group"]["groupname"]." section";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit;
}
//get more or next page;


//edit productcategory;
if(isset($input["editgroup"])){
    $groupid = $input["groupid"];
    $groupname = htmlspecialchars($input["groupname"]);
    $groupnote = htmlspecialchars($input["groupnote"]);
    $groupleveltablename = 'grouplevel'.$input['gltn'];
    $group = new Group();

    if(!$results=$group->editGroup($groupleveltablename,$groupid,$groupname,$groupnote)){
        $message = "group not edited";
        $results = "0";
    }else{
        $message = "Group successfully edited";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit;
}


//add article category;
if(isset($input["addgroup"])){
    $gn = htmlspecialchars($input["name"]);
    $gnote = htmlspecialchars($input["note"]);
    $grouplevel1id = (empty($input['grouplevel1id'])? null : $input['grouplevel1id']);
    $grouplevel2id = (empty($input['grouplevel2id'])? null : $input['grouplevel2id']);
    $grouplevel3id = (empty($input['grouplevel3id'])? null : $input['grouplevel3id']);

    $ids = array("grouplevel1id"=>$grouplevel1id, "grouplevel2id"=>$grouplevel2id,"grouplevel3id"=>$grouplevel3id);
    $group = new Group();
    if(!$results = $group ->addGroup($gn, $gnote,$ids)){
        $message = "group not added";
        $results = "0";
    }else{
        $message = "Group successfully created";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit;
}


//get articles by categories;
if(isset($_GET["getgroup"])){
    $groupid = $_GET["groupid"];
    $groupleveltablename = 'grouplevel'.$_GET["gltn"];

    $grp = new Group();
    if($group = $grp->getGroup($groupleveltablename,$groupid)){
        $title = "Welcome to ".$group["group"]["groupname"]." section";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/group/group.html.php";
        exit();
    }else{
        $output = "No More activitiss In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/group/group.html.php";
        exit();
    }
}
//get more or next page;


//edit productcategory;
if(isset($_POST["editgroup"])){
    $fid = $_POST["groupid"];
    $fn = htmlspecialchars($_POST["groupname"]);
    $fnote = htmlspecialchars($_POST["groupnote"]);
    $tableid = $_POST['gltn'];
    $groupleveltablename = "grouplevel".$tableid;

    $group = new Group();

    if($group->editGroup($groupleveltablename,$fid,$fn,$fnote)){
        $output = "Group Successfully Edited";
        header("Location: /api/group/index.php?getgroup&groupid=".$fid."&gltn=".$tableid."&output=".$output);
        exit;
    }
}


//for post on website version;
//add article category;
if(isset($_POST["addgroup"])){
    $gn = htmlspecialchars($_POST["name"]);
    $gnote = htmlspecialchars($_POST["note"]);
    $grouplevel1id = (empty($_POST['grouplevel1id'])? null : $_POST['grouplevel1id']);
    $grouplevel2id = (empty($_POST['grouplevel2id'])? null : $_POST['grouplevel2id']);
    $grouplevel3id = (empty($_POST['grouplevel3id'])? null : $_POST['grouplevel3id']);

    $ids = array("grouplevel1id"=>$grouplevel1id, "grouplevel2id"=>$grouplevel2id,"grouplevel3id"=>$grouplevel3id);
    //echo($grouplevel2id."ID".$_POST['grouplevel2id']." it ".$ids["grouplevel2id"] ." group ".$ids["grouplevel1id"]); exit;
    $group = new Group();
    if($group ->addGroup($gn, $gnote,$ids)){
        $output = $gn." Group Added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "group Already been Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//LOGIN;
if(isset($input["log"])){
    $user = new user();
    $message = "successful log in";
    if(!$results = $user->isLoggedIn()){
        $message="Please Login First With Correct Email And Password Pair ".$GLOBALS["ApiInput"]["log"];
        $results = "0";

    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit;
}
?>