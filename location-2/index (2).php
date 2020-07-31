<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/cors.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/inputsanitizer.php';

include_once $_SERVER["DOCUMENT_ROOT"]."/api/state/state.class.php";

//get users in a state by role;
if(isset($input["getbystate"])&& isset($input["role"])){
    $sid = $input["state"];
    $rid = $input["role"];
    $users = new State();

    $users = $users -> getStateusersByRole($sid,$rid);
    $title = $users[0]["role.name"]." In ". $users[0]["state.name"]." In Anambra Nigeria";
    include_once $_SERVER["DOCUMENT_ROOT"]."/bona/state/stateusers.html.php";
    exit();
}

//get users in a state by role;
if(isset($input["getbylga"])&& isset($input["role"])){
    $lid = $input["lga"];
    $rid = $input["role"];
    $users = new LGA();
    $users = $users ->getLGAUsersByRole($lid,$rid);
    $title = $users[0]["role.name"]." In ". $users[0]["lga.name"]." In Anambra Nigeria";
    include_once $_SERVER["DOCUMENT_ROOT"]."/bona/state/stateusers.html.php";
    exit();
}

//get LGAs OF a STATE;
if(isset($input["getstates"])){
    $state = new State();
    $message = "lgss got successfully";
    if(!$results = $state -> getStates()){
        $message="no states "/*.$GLOBALS["ApiInput"]["log"]*/;
        $results = "0";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit();
}

//get LGAs OF a STATE;
if(isset($input["getlgas"])){
    $id = $input["sid"];
    $state = new State();
    $message = "lgss got successfully";
    if(!$results = $state -> getStateLGAs($id)){
        $message="no lgas "/*.$GLOBALS["ApiInput"]["log"]*/;
        $results = "0";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit();
}


?>