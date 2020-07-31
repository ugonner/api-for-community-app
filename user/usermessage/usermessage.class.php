<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/db/connect2.php";
class Usermessage{
protected $db;

public function __construct(){
    $dbh = new Dbconn();
    $this -> db = $dbh->dbcon;
}

//get unread msgs;

//get unmarked messages;
    public function getUnreadMessages($userid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }
        $sql = '(SELECT usermessage.id as id,senderid ,firstname,profilepic,detail,dateofpublication,marked FROM
                usermessage INNER JOIN user ON user.id = usermessage.senderid
                WHERE receiverid = :userid AND marked = "N" GROUP BY senderid ORDER BY usermessage.id DESC LIMIT '.$offset.' , '.$limit.' )';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt->bindParam(":userid",$userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $messages = $stmt->fetchAll();
        }
        catch(PDOException $e){
            $error = 'SQL ERROR Unable To Get  Messages';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return array("messages"=>$messages,"count"=>$rowscount);
        }
        else{
            return FALSE;
        }
    }
//end of getunmarked n;
//get inbox messages;
public function getInboxMessages($userid,$amtperpage,$pgn){
    if($pgn == 0){
        $limit = $amtperpage;
        $offset = 0;
    }else{
        $limit = $amtperpage;
        $offset = $pgn * $amtperpage;
    }
    $sql = '(SELECT usermessage.id,senderid ,firstname,profilepic,detail,dateofpublication,marked FROM
                usermessage INNER JOIN user ON user.id = usermessage.senderid
                WHERE receiverid = :userid GROUP BY senderid ORDER BY usermessage.id DESC LIMIT '.$offset.' , '.$limit.' )';
    try{
        $stmt = $this -> db -> prepare($sql);
        $stmt->bindParam(":userid",$userid);
        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        $messages = $stmt->fetchAll();
    }
    catch(PDOException $e){
        $error = 'SQL ERROR Unable To Get Inbox Messages';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    if($rowscount > 0){
        return $messages;
    }
    else{
        return FALSE;
    }
}
//end of getunmarked n;

//getmoreinbox;
//get unmarked messages;

//end of getunmarked n;

//getpreviousinbox;
//get unmarked messages;
 //end of getprevious inbox;

//get conversation;

    public function getConversation($userid,$senderid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        {
            $sql = 'UPDATE usermessage SET marked = "Y"
                WHERE receiverid = :userid AND marked = "N" AND senderid = :senderid ';
            try{
                $stmt = $this -> db -> prepare($sql);
                $stmt -> bindParam(":senderid", $senderid);
                $stmt -> bindParam(":userid", $userid);


                $stmt -> execute();
                $rowscount = $stmt -> rowCount();
            }
            catch(PDOException $e){
                $error = 'SQL ERROR Unable TO Update marked';
                $error2 = $e -> getMessage();
                include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                exit();
            }

        }
        //end of update marked;


        $sql = '(SELECT usermessage.id,firstname,profilepic,detail,dateofpublication,
                senderid,receiverid,edited FROM
                usermessage INNER JOIN user ON user.id = usermessage.senderid
                WHERE usermessage.receiverid = :userid AND usermessage.senderid = :senderid
                ORDER BY usermessage.id DESC LIMIT '.$offset.' , '.$limit.')
          UNION (SELECT usermessage.id,firstname,profilepic,detail,dateofpublication,
                senderid,receiverid,edited FROM
                usermessage INNER JOIN user ON user.id = usermessage.senderid
                WHERE usermessage.receiverid = :senderid2 AND usermessage.senderid = :userid2
                ORDER BY usermessage.id DESC LIMIT '.$offset.' , '.$limit.')
                ORDER BY dateofpublication ASC';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":senderid", $senderid);
            $stmt -> bindParam(":userid2", $userid);
            $stmt -> bindParam(":senderid2", $senderid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $conversation = $stmt->fetchAll();
        }
        catch(PDOException $e){
            $error = 'SQL ERROR Unable to get conversation';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return $conversation;
        }
        else{
            return FALSE;
        }
    }
//end of getconversation;

//getmoreconversation;
//end of getmoreconversation;
//get previousconcersation;
//end getpreviousmsgs;

//send message;
public function sendMessageToUser($detail,$dateofpublication,$senderid,$rxid,$marked){
    $sql = 'INSERT INTO usermessage (detail,dateofpublication,senderid,receiverid,marked)
            VALUES(:detail,:dop,:senderid,:rxid,:marked)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":detail", $detail);
            $stmt -> bindParam(":dop", $dateofpublication);
            $stmt -> bindParam(":senderid", $senderid);
            $stmt -> bindParam(":rxid", $rxid);
            $stmt -> bindParam(":marked", $marked);


            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO SEND MESSAGE';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of getconversation;

//editnessage;
    public function editMessage($messageid,$detail,$senderid){
        $sql = 'UPDATE usermessage SET detail = :detail, edited = "Y"
                WHERE id = :msgid AND senderid = :senderid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":msgid", $messageid);
            $stmt -> bindParam(":detail", $detail);
            $stmt -> bindParam(":senderid", $senderid);


            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO EDIT MESSAGE';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of getconversation;

//delete message;

//editnessage;
    public function deleteMessage($messageid,$senderid){
        $sql = 'DELETE FROM usermessage
                WHERE id = :msgid AND senderid = :senderid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":msgid", $messageid);
            $stmt -> bindParam(":senderid", $senderid);


            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO DELETE MESSAGE';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}
//end class;


?>