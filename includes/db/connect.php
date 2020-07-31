<?php
/*$link = mysqli_connect($_SERVER['SERVER_NAME'], 'agmallco_bona','thanks198915');*/

$link = mysqli_connect($_SERVER['SERVER_NAME'], 'root');
if(!$link){
  $error = 'unable to connect to mysql';
  include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
  exit();
  }

if(!mysqli_select_db($link, 'ihite')){
  $error = 'unable to select database';
  include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
  exit();
 }
?>