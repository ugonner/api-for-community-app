<?php
class Dbconn{
    public $dbcon;
public function  __construct(){
  $hostname = $_SERVER["SERVER_NAME"];
  /*$dbname = 'agmallco_bona';
  $dbh = new PDO("mysql:host=".$hostname.";dbname=".$dbname."; charset=utf8" , 'agmallco_bona','thanks198915');*/

    $dbname = 'ihite';
    $dbh = new PDO("mysql:host=".$hostname.";dbname=".$dbname."; charset=utf8" , 'root');
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh -> setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, 1);
  $this-> dbcon = $dbh;
}
}
?>