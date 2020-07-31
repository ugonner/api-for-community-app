<?php 

/*$results = "0";
$message = $_SERVER['REQUEST_METHOD'];
echo json_encode(array("results"=>$results, "message"=>$message));
exit;*/
/*if($_SERVER['REQUEST_METHOD'] == "GET") {

  header('Content-Type: text/plain');
  echo "This HTTP resource is designed to handle POSTed XML input";
  echo "from arunranga.com and not be retrieved with GET"; 
  exit;
  
} else*/

if($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
  // Tell the Client we support invocations from arunranga.com and 
  // that this preflight holds good for only 20 days

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-type');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 1728000');
    header("Content-Length: 0");
    header("Content-Type: text/plain");
    exit;
    
} elseif($_SERVER['REQUEST_METHOD'] == "POST") {    
    // do something with POST data
    header('Access-Control-Allow-Credentials: true');
    session_start();
    header('Access-Control-Allow-Origin: *');
/*    header('Content-Type: text/plain');*/
    }
?>



