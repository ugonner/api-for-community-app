<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/cors.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/inputsanitizer.php';

include_once $_SERVER["DOCUMENT_ROOT"]."/api/location/location.class.php";

//get users in a location by role;
if(isset($input["getbylocation"])&& isset($input["role"])){
    $sid = $input["location"];
    $rid = $input["role"];
    $users = new location();

    $users = $users -> getlocationusersByRole($sid,$rid);
    $title = $users[0]["role.name"]." In ". $users[0]["location.name"]." In Anambra Nigeria";
    include_once $_SERVER["DOCUMENT_ROOT"]."/bona/location/locationusers.html.php";
    exit();
}

//get users in a location by role;
if(isset($input["getbysublocation"])&& isset($input["role"])){
    $lid = $input["sublocation"];
    $rid = $input["role"];
    $users = new sublocation();
    $users = $users ->getsublocationUsersByRole($lid,$rid);
    $title = $users[0]["role.name"]." In ". $users[0]["sublocation.name"]." In Anambra Nigeria";
    include_once $_SERVER["DOCUMENT_ROOT"]."/bona/location/locationusers.html.php";
    exit();
}

//get sublocations OF a location;
if(isset($input["getlocations"])){
    $location = new location();
    $message = "lgss got successfully";
    if(!$results = $location -> getlocations()){
        $message="no locations "/*.$GLOBALS["ApiInput"]["log"]*/;
        $results = "0";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit();
}

//get sublocations OF a location;
if(isset($input["getsublocations"])){
    $id = $input["lid"];
    $location = new location();
    $message = "lgss got successfully";
    if(!$results = $location -> getlocationsublocations($id)){
        $message="no sublocations "/*.$GLOBALS["ApiInput"]["log"]*/;
        $results = "0";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit();
}


?>