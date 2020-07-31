<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/htmler.php';

$input = json_decode(file_get_contents('php://input'),TRUE);
/*$results = "0";
$message = file_get_contents('php://input');
echo json_encode(array("results"=>$results, "message"=>$message));
exit;*/

//sanitize inputs;

/*$input = array_map('shout', $input);*/

$GLOBALS["ApiInput"] = $input;

?>