<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/db/connect2.php';

class Text{
  protected $db;
  protected $userpass = 'UgoFoundation2019:Thanks1989';
  protected $singletexturl = 'http://kexyx.api.infobip.com/sms/1/text/single';
  protected $multitexturl = 'http://api.infobip.com/sms/1/text/multi';

  protected $sendername = 'TheSite';
  protected $header = array("Content-type:application/json", "Accept-type:application/json");

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }

//check if user has exceeded sms unit for the month;
public function hasReachedSMSLimit($userid){
   $sql = 'SELECT smscount FROM user WHERE id = :userid';
try{
   $stmt = $this -> db -> prepare($sql);
   $stmt -> bindParam(":userid", $userid);
   $stmt -> execute();

   $smscount = $stmt -> fetch();
 }
  catch(PDOException $e){
     $error = 'SQL ERROR UNABLE TO GET THIS TO GET SMS UNIT COUNT';
     $error2 = $e -> getMessage();
     include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
     exit();

  }
  if(count($smscount > 0)){
      $smscount = intval($smscount[0]);
      if($smscount == null || 10 < $smscount){
        return $smscount;
      }
   }
return FALSE;
}
//end hasREACHEDSMSLIMIT;


//check if user has exceeded sms unit for the month;
    public function getMobile($userid){
        $sql = 'SELECT mobile FROM user WHERE id = :userid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> execute();

            $mobile = $stmt -> fetch();
            return $mobile;
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET THIS TO GET SMS UNIT COUNT';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return FALSE;
        }
    }
//end hasREACHEDSMSLIMIT;

//TEXT ONE TO ONE;
public function sendToOne($rxid, $message){
    $sql = 'SELECT firstname, mobile FROM user WHERE id = :rxid';
    try{
        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":rxid", $rxid);
        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        $mobile = $stmt -> fetch();
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET MOBILE NUMBER OF THIS USER';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return FALSE;
        }


        if($rowscount > 0){
            $to = $mobile["mobile"];
            $from = $this->sendername;
            $name = $mobile["firstname"];
            $message = 'Hi '.$name.", ".$message;
            $message = array("From" => $from , "to" => $to , "text" => $message);
            $message = array("messages" => $message);
            $postmsg = json_encode($message);

            $userpwd = $this -> userpass;
            $url = $this -> singletexturl;
            $header = $this -> header;

            //code to send sms;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postmsg);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
            $responsebody = json_decode($response);

            curl_close($ch);

            if($httpcode >= 200 && $httpcode < 300){
                //update number of smses sent by the user for the month;
                $sms = $responsebody["smscount"];
                return true;
            }
            else{
                $error = 'SMS WAS NOT SENT SORRY';
                include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                return FALSE;
            }
//END IF CURL200;
        }else{
                $error = 'USER DOES NOT HAVE A MOBILE NUMBER, SMS WAS NOT SENT SORRY';
                include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                return FALSE;
        }
//end of if count mobile;
}
//ABOVE IS end of textONE;

//send to many;
public function sendToMany($sendername,$to, $names,$message){



    $messages = array();
  $from = $sendername;
  $userpwd = $this -> userpass;
  $url = $this -> multitexturl;
  $header = $this -> header;


  /*
   * FOR THE NEW API, EDIT URL BEFORE USE
   * for($i=0; $i<count($to); $i++){
    $new_name = $names[$i];
    $new_to = $to[$i];
    $new_message = 'Hi '.$new_name.", ".$message;
    $msg = array("From" => $from , "destinations"=> array("to" => $new_to), "text" => $new_message);
    $messages[] = $msg;
  }

    //$message_array = array("bulkid"=>'bulkid'.time(),"messages" => $messages);
    //$postmsg = json_encode($message_array);

  */


    for($i=0; $i<count($to); $i++){
        $new_name = $names[$i];
        $new_to = $to[$i];
        $new_message = 'Hi '.$new_name.", ".$message;
        $msg = array("From" => $from , "to" => $new_to , "text" => $new_message);
        $messages[] = $msg;
    }

    $messagesArray = array("messages" => $messages);
    $postmsg = json_encode($messagesArray);

    /*echo "<div style='background:black; color: white;'>".count($to)."<br><br>"
        .$postmsg."<br><br>".$messages."<br><br>".$to."</div>";
    exit;*/
//code to send sms;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,300);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postmsg);
  $response = curl_exec($ch);
$httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);

    $response = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);
    $decoded_response = json_decode($response);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        if(isset($decoded_response->messages)){
            return ' Message Successfully Sent To :'.count($decoded_response->messages)." Persons";
        }else{
            return 'Format Error: Messages May Not Have Been Sent, Biko oo';
        }
    }

/*  curl_close($ch);
$responsebody = json_decode($response);

if($httpcode >= 200 && $httpcode < 300){
   $smscount = count($responsebody["message"]);
     return $smscount;
}
 else{
     return false;
 }*/
//END IF CURL200;
}
//end of sendtomany;

//send to anybody else;
//send to many;
public function sendToAnybody($to, $message){
  /*$to = explode("," , $to);
  $to = array_map("trim", $to);*/

  $from = $this -> sendername;
  $userpwd = $this -> userpass;
  $url = $this -> singletexturl;
  $header = $this -> header;

    $message = array("From" => $from , "to" => $to , "text" => $message);

    $message = array("messages" => $message);
    $postmsg = json_encode($message);

//code to send sms;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postmsg);
  $response = curl_exec($ch);
$httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);

  curl_close($ch);
$responsebody = json_decode($response);

if($httpcode >= 200 && $httpcode < 300){
   $smscount = count($responsebody["message"]);
     return true;
  
}
 else{
     return false;
 }
//END IF CURL200;
}
//end of sendtoanybody;

}
//end of textclass;
?>