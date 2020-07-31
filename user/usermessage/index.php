<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/api/user/usermessage/usermessage.class.php';

if(isset($_GET["getconversation"])){
    if(!isset($_SESSION)){
        session_start();
    }


    if(!isset($_SESSION["userid"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/forms/loginform.html.php?output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];
    session_write_close();
    $senderid = $_GET["senderid"];
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = '(SELECT count(*) FROM usermessage WHERE receiverid = :senderid AND senderid = :userid)
            UNION (SELECT count(*) FROM usermessage WHERE receiverid = :userid2 AND senderid = :senderid2)';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$uid);
        $stmt -> bindParam(":senderid",$senderid);
        $stmt -> bindParam(":userid2",$uid);
        $stmt -> bindParam(":senderid2",$senderid);

        $stmt -> execute();
        $takescount = $stmt -> fetchAll();

    }
    catch(PDOException $e){
        $error = "Unable TO Count conversation";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $msgcount = 0;
    for($i=0; $i<count($takescount); $i++){
        $msgcount += $takescount[$i][0];
    }
    $no_of_pages = ceil($msgcount / $amtperpage);

    $usermsg = new Usermessage();
    if($conversation = $usermsg->getConversation($uid,$senderid,$amtperpage,$pgn)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/usermessage/conversation.html.php";
        exit();
    }else{
        $error2 = "No Conversation Yet Between You And This Person";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/usermessage/conversation.html.php";
        exit();
    }
}
//get unreadmessages;
//get more conversation;
//get previous conversation;
//get inbox messages;
if(isset($_GET["getunreadmessages"])){
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?error=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];
    session_write_close();
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(*) FROM usermessage WHERE receiverid = :userid AND marked = "N"';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$uid);

        $stmt -> execute();
        $takescount = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count unmarked messages";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $msgcount = $takescount[0];
    $no_of_pages = ceil($msgcount / $amtperpage);


    $usermsg = new Usermessage();
    if($messages = $usermsg->getUnreadMessages($uid,$amtperpage,$pgn)){
        $count = $messages["count"];
        $messages = $messages["messages"];
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/usermessage/inbox.html.php";
        exit();
    }else{
        $error = "No Unread Messages";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/usermessage/inbox.html.php";
        exit();
    }
}

//get inbox messages;
if(isset($_GET["getinboxmessages"])){
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?error=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];
    session_write_close();

    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = '(SELECT count(*) FROM usermessage WHERE receiverid = :userid)';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$uid);
        $stmt -> execute();
        $takescount = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count inbox";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $msgcount = $takescount[0];
    $no_of_pages = ceil($msgcount / $amtperpage);


    $usermsg = new Usermessage();
    if($messages = $usermsg->getInboxMessages($uid,$amtperpage,$pgn)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/usermessage/inbox.html.php";
        exit();
    }else{
        $error = "No Messages Found";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/usermessage/inbox.html.php";
        exit();
    }

}
//getmore from inbox;
//get previous from inbox;

//getmore from inbox;

//get conversation by ajax;
if(isset($_GET["getconversationbyajax"])){
    $senderid = $_GET["senderid"];
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?uid=".$senderid."&error=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];
    session_write_close();
    $senderid = $_GET["senderid"];
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = '(SELECT count(*) FROM usermessage WHERE receiverid = :senderid AND senderid = :userid)
            UNION (SELECT count(*) FROM usermessage WHERE receiverid = :userid2 AND senderid = :senderid2)';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$uid);
        $stmt -> bindParam(":senderid",$senderid);
        $stmt -> bindParam(":userid2",$uid);
        $stmt -> bindParam(":senderid2",$senderid);

        $stmt -> execute();
        $takescount = $stmt -> fetchAll();

    }
    catch(PDOException $e){
        $error = "Unable TO Count conversation";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $msgcount = $takescount[0] + $takescount[1];
    $no_of_pages = ceil($msgcount / $amtperpage);

    $usermsg = new Usermessage();
    $conversation = $usermsg->getConversation($uid,$senderid);
    $thread = " ";

    session_start();
    for($i=0; $i<count($conversation); $i++){
        $t = "<div class='thumbnail'><p><a href='/api/user/index.php?uid=".$conversation[$i][5]."'>
        <h6>".$conversation[$i][0]."</h6></a>
        <img src='".$conversation[$i][1]."' style='width:50px; height=40px;'/>
        <span>".$conversation[$i][3]."</span></p>
        ";
        if(isset($_SESSION["userid"])&&($_SESSION["userid"]==$conversation[$i][5])){
            $t = $t."<p><button id='deletemsgbtn' class='btn-danger'>
            <a href='/api/user/usermesage/index.php?deletemessage&mid=".$conversation[$i][2]."'>
            Delete</a></button>
            <button id='editmsgbtn' class='btn-warning' data-toggle='collapse' data-target='#editmsgdiv'>
            Edit</button>
            <div class='collapse' id='editmsgdiv'>
               <div class='form-group'>
                   <form class='form-group' action='/api/user/usermessage/index.php' method='POST'>
                        <imput type='hidden' name='mid' value='".$conversation[$i][2]."'/>
                        <imput type='hidden' name='rxid' value='".$conversation[$i][5]."'/>
                        <label for='editmsgtextarea'>Message</label>
                        <textarea id='editmsgtextarea' name='detail' class='form-control'>
                           ".$conversation[$i][3]."
                        </textarea>
                        <button type='submit' class='form-control' name='editmessage'>Save</button>
                   </form>
               </div>
            </div></p></div>";
        }else{
            $t = $t."</div>";
        }
        $thread .=$t;
    }
session_write_close();
 echo $thread;
}
//end of getmessagebyajax;
//send jmessage;

//dend messaagge by ajax;
if(isset($_POST["sendmessagebyajax"])){
    $rxid = $_POST["rxid"];


    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?error=".$error);
        exit();
    }
    $senderid = $_SESSION["userid"];

    $sql = '(SELECT count(*) FROM usermessage WHERE receiverid = :senderid AND senderid = :userid)
            UNION (SELECT count(*) FROM usermessage WHERE receiverid = :userid2 AND senderid = :senderid2)';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$uid);
        $stmt -> bindParam(":senderid",$senderid);
        $stmt -> bindParam(":userid2",$uid);
        $stmt -> bindParam(":senderid2",$senderid);

        $stmt -> execute();
        $takescount = $stmt -> fetchAll();

    }
    catch(PDOException $e){
        $error = "Unable TO Count conversation";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $msgcount = $takescount[0] + $takescount[1];
    $no_of_pages = ceil($msgcount / $amtperpage);

    $detail = htmlspecialchars($_POST["detail"]);
    $dop = date("YMDhms");
    $marked = "N";

    session_write_close();
    $usermsg = new Usermessage();
    if($usermsg->sendMessageToUser($detail,$dop,$senderid,$rxid,$marked)){
        $conversation = $usermsg->getConversation($senderid,$rxid,$amtperpage,$pgn);
        $thread = " ";

        session_start();
        for($i=0; $i<count($conversation); $i++){
            $t = "<div class='thumbnail'><p><a href='/api/user/index.php?uid=".$conversation[$i][5]."'>
        <h6>".$conversation[$i][0]."</h6></a>
        <img src='".$conversation[$i][1]."' style='width:50px; height=40px;'/>
        <span>".$conversation[$i][3]."</span></p>
        ";
            if(isset($_SESSION["userid"])&&($_SESSION["userid"]==$conversation[$i][5])){
                $t = $t."<p><button id='deletemsgbtn' class='btn-danger'>
            <a href='/api/user/usermesage/index.php?deletemessage&mid=".$conversation[$i][2]."'>
            Delete</a></button>
            <button id='editmsgbtn' class='btn-warning' data-toggle='collapse' data-target='#editmsgdiv'>
            Edit</button>
            <div class='collapse' id='editmsgdiv'>
               <div class='form-group'>
                   <form class='form-group' action='/api/user/usermessage/index.php' method='POST'>
                        <imput type='hidden' name='mid' value='".$conversation[$i][2]."'/>
                        <imput type='hidden' name='rxid' value='".$conversation[$i][5]."'/>
                        <label for='editmsgtextarea'>Message</label>
                        <textarea id='editmsgtextarea' name='detail' class='form-control'>
                           ".$conversation[$i][3]."
                        </textarea>
                        <button type='submit' class='form-control' name='editmessage'>Save</button>
                   </form>
               </div>
            </div></p></div>";
            }else{
                $t = $t."</div>";
            }
            $thread .=$t;
        }
        session_write_close();
        echo $thread;
        exit();
    }else{
        $error = "Message No Longer Exist OR You Cannot Be Identified Eith ThiS Message, So You Cannot Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}
//dend messaagge

//deletemsg;
if(isset($_GET["deletemessage"])){
    $mid = htmlspecialchars($_GET["mid"]);
    $rxid = htmlspecialchars($_GET["rid"]);
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?error=".$error);
        exit();
    }
    $senderid = $_SESSION["userid"];
    session_write_close();
    $usermsg = new Usermessage();
    if($usermsg->deleteMessage($mid,$senderid)){
        header("Location:/api/user/usermessage/index.php?getconversation&senderid=".$rxid."&error=".$error);
        exit();
    }else{
        $error = "Message No Longer Exist OR You Cannot Be Identified Eith ThiS Message, So You Cannot Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}

//dend messaagge
if(isset($_POST["sendmessage"])){
    $rxid = htmlspecialchars($_POST["rxid"]);

    session_start();
    if(!isset($_SESSION["userid"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?uid=".$rxid."&error=".$error);
        exit();
    }
    if((!isset($_POST["message"]))){
        $error = "Message Not Sent Or Empty";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();

    }
    if($_SESSION["userid"]== $rxid){
        $error = "You Are Trying To Send A Message To  Yourself";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
    if(isset($_POST["pgn"])){
        $pgn = htmlspecialchars($_POST["pgn"]);
    }else{
        $pgn = 0;
    }
    $senderid = $_SESSION["userid"];
    $detail = htmlspecialchars($_POST["message"]);
    $dop = date("Ymdhis");
    $marked = "N";

    session_write_close();
    $usermsg = new Usermessage();
    if($usermsg->sendMessageToUser($detail,$dop,$senderid,$rxid,$marked)){
        header("Location:/api/user/usermessage/index.php?getconversation&senderid=".$rxid."&pgn=".$pgn."&output=".$error);
        exit();
    }else{
        $error = "Message No Longer Exist OR You Cannot Be Identified Eith ThiS Message, So You Cannot Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}
//editmessage;
// messaagge
if(isset($_POST["editmessage"])){
    $rxid = $_POST["rxid"];

    session_start();
    if(!isset($_SESSION["userid"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php?error=".$error);
        exit();
    }
    $senderid = $_SESSION["userid"];
    $detail = htmlspecialchars($_POST["detail"]);
    $mid = htmlspecialchars($_POST["mid"]);

    session_write_close();
    $usermsg = new Usermessage();
    if($usermsg->editMessage($mid,$detail,$senderid)){
        if(isset($_POST["pgn"])){
            $pgn = htmlspecialchars($_POST["pgn"]);
        }else{
            $pgn = 0;
        }
        $error = "message edited successfully";
        header("Location:/api/user/usermessage/index.php?getconversation&senderid=".$rxid."&pgn=".$pgn."&output=".$error);
        exit();
    }else{
        $error = "Message No Longer Exist OR You Cannot Be Identified Eith ThiS Message, So You Cannot Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}
//edit messaagge
?>