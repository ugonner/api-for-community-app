<?php
    class callIt{
        public  function __construct(){

        }

        public function call(){

//code to send sms;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://google.com");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type"=>'application/json'));
            //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            //curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $postmsg);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);

            curl_close($ch);
            $responsebody = json_decode($response);

            if($httpcode >= 200 && $httpcode < 300){
                //$smscount = count($responsebody["message"]);
                return "YA YA reach";
            }else{
                return "no no NO";
            }
        }
    }

$c = new callIt();
echo($c->call());
?>