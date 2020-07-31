<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/location/location.class.php";

//get sublocations OF a location;
if(isset($_GET["get_sublocations"])){
    $locationid = $_GET["locationid"];
    $locations = new location();
    $sublocations = $locations -> getLocationSubLocations($locationid);
    $options = "<option value=''>Please Select</option> ";
    for($i = 0; $i < count($sublocations); $i++){
        $option = " "."<option value='".$sublocations[$i][0]."'>".$sublocations[$i][1]."</option>";
        $options .= $option;
    }
    echo($options);
    exit;
}

/*
//get users in a location by role;
if(isset($_POST["getbylocation"])&& isset($_POST["role"])){
    $sid = $_POST["location"];
    $rid = $_POST["role"];
    $users = new location();

    $users = $users -> getlocationusersByRole($sid,$rid);
    $title = $users[0]["role.name"]." In ". $users[0]["location.name"]." In Anambra Nigeria";
    include_once $_SERVER["DOCUMENT_ROOT"]."/ntytr/location/locationusers.html.php";
    exit();
}

//get users in a location by role;
if(isset($_POST["getbysublocation"])&& isset($_POST["role"])){
    $lid = $_POST["sublocation"];
    $rid = $_POST["role"];
    $users = new sublocation();
    $users = $users ->getsublocationUsersByRole($lid,$rid);
    $title = $users[0]["role.name"]." In ". $users[0]["sublocation.name"]." In Anambra Nigeria";
    include_once $_SERVER["DOCUMENT_ROOT"]."/ntytr/location/locationusers.html.php";
    exit();
}*/

?>