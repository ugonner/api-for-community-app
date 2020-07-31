<?php
$app_secret = 'ef29a678cd85384713c5bb9735a35af3';
$app_id = '1886093921631150';
$redirect_url = 'https://www.agmall.com.ng/api/user/facebooklogin.php';

//geting access token;
if(isset($_GET["code"])){
    $code = $_GET["code"];

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=" . $redirect_url. "&client_secret=" . $app_secret . "&code=" . $code."&scope=email" ;


    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $token_url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Accept-type: application/json'));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPGET,1);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($httpcode >= 200 && $httpcode < 400){
        $userparameters = json_decode($response);
        $access_token = $userparameters->access_token;

    }

//end of old code;

//get facebook data;
    $graph_url = "https://graph.facebook.com/me?access_token="
        . $access_token;


    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $graph_url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPGET,1);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpcode >= 200 && $httpcode < 400){
        $user = json_decode($response);
        
        
        //chech if user is already registered;
        $facebook_id = $user->id;
include_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/api/user/user.class.php';

if(!isset($_SESSION)){
    session_start();
}        
        $sql = 'SELECT id,facebookid FROM user WHERE facebookid = :facebookid';
        try{
            $dbh = new Dbconn();
            $stmt = $dbh ->dbcon -> prepare($sql);
            $stmt -> bindParam(":facebookid", $facebook_id);

            $stmt -> execute();
            $userdata = $stmt -> fetch();
        }
        catch(PDOException $e){
            $error = 'Not Registered sorry, probably facebook data was not fetched, try again later';
            $error2 = $e->getMessage();
            include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
            exit;
        }

        if($userdata[0] > 0){

            session_start();
            $_SESSION['facebookid'] = $userdata['facebookid'];
            
            $userlog = new user();
            $userlog->isLoggedIn();
            header("Location: /api/user/?guid=".$userdata[0]);
            exit;
        }else{
            //if not registered then register the user;
            $firstname = $user->first_name;
            $email = $user->email;
            $surname = $user->last_name;
            $profilepic = $user->picture;
            $gender = $user->gender;
            if(empty($firstname)){
                $firstname = $user->name;
            }
            if(preg_match('/female/i',$gender)){
                $gender = 'F';
            }else{
                $gender = 'M';
            }

            
            $password = NULL;
            $dateofregistration = date('YmdHis');
            $roleid = 2;
            $rolenote = 'Agro Enthusiast';
            $public = 'N';
            $LGAid = 1;
            $stateid = 1;
            MD5($password.'ugpn');
            if(empty($profilepic)){
                $profilepic = '//graph.facebook.com/'.$facebook_id.'/picture';
            }

            $sql = 'INSERT INTO user (firstname,surname,email,password,profilepic,gender,dateofregistration,facebookid,roleid,rolenote,public,stateid,LGAid)
                    VALUES (:firstname,:surname,:email,:password,:profilepic,:gender,:dateofregistration,:facebookid,:roleid,:rolenote,:public,:stateid,:LGAid)';
            try{
                $stmt = $dbh->dbcon->prepare($sql);
                $stmt->bindParam(":firstname",$firstname);
                $stmt->bindParam(":surname",$surname);
                $stmt->bindParam(":email",$email);
                $stmt->bindParam(":password",$password);
                $stmt->bindParam(":profilepic",$profilepic);
                $stmt->bindParam(":gender",$gender);
                $stmt->bindParam(":dateofregistration",$dateofregistration);
                $stmt->bindParam(":facebookid",$facebook_id);
                $stmt->bindParam(":roleid",$roleid);
                $stmt->bindParam(":rolenote",$rolenote);
                $stmt->bindParam(":public",$public);
                $stmt->bindParam(":stateid",$stateid);
                $stmt->bindParam(":LGAid",$LGAid);

                $stmt->execute();
                $userid = $dbh->dbcon->lastInsertId();

            }catch (PDOException $e){
                $error = 'Not Registered sorry, try again later';
                $error2 = $e->getMessage();
                include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
                exit;
            }
                $_SESSION["email"] = $email;
                $_SESSION["facebookid"] = $facebook_id;
                $userlog = new user();
                $userlog->isLoggedIn();
                header("Location: /api/user/?guid=".$userid."&output=please edit your phone number for biz contact");
                exit;

        }
}
}
        $error = $httpcode.' facebook login failed, please log in at <a href="/api/user/registration.html.php">Here</a> it is so easy ';
        include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
        exit;
    



?>