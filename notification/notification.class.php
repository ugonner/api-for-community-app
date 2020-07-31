<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/helpers/mediafilehandler.php';

class Notification{
    protected $id;
    protected $title;
    protected $detail;
    protected $articleimagedisplayname;
    protected $user;
    protected $category;
    public $takes;
    public $files;

    protected $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }


    public function addNotification($notificationtable,$postid,$postownerid,$userid,$notificationtypeid,$dateofpublication){

    $sql = 'INSERT INTO '.$notificationtable.' (ownerid,postid,userid,notificationtypeid,dateofpublication)
	  VALUES(:postownerid,:postid, :userid, :notificationtypeid,:dateofpublication)';

    try{
        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":postid", $postid);
        $stmt -> bindParam(":postownerid", $postownerid);
        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":dateofpublication", $dateofpublication);
        $stmt -> bindParam(":notificationtypeid", $notificationtypeid);

        $stmt -> execute();
        $rowscount =     $stmt -> rowCount();

    }
    catch(PDOException $e){
        $error2 = $e -> getMessage();
        $error = "unable to add notification";
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    if($rowscount > 0){
        return true;
    }
    else{
        return FALSE;
    }

}
//end of addnotification;

//delete notification;
public function deleteNotification($notificationtable,$postid, $userid,$notificationtypeid){
    $sql = 'DELETE FROM '.$notificationtable.'
	   WHERE postid = :postid AND notificationtypeid = :notificationtypeid AND userid = :userid';

    try{
        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":postid", $postid);
        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":notificationtypeid", $notificationtypeid);

        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount>0){
            return true;
        }
    }
    catch(PDOException $e){
        $error2 = $e -> getMessage();
        $error = 'UNABLE TO DELETE YOUR notification';
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    return false;
}
//check user action;

//delete notification;

    public function deletePostNotifications($notificationtable,$postid){
        $sql = 'DELETE FROM '.$notificationtable.'
	   WHERE postid = :postid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":postid", $postid);

            $stmt -> execute();
            return true;

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE YOUR notification';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }

    }


//get categories;
public function checkUserPostAction($userid,$postid,$notificationtypeid,$notificationtable){
    $sql = 'SELECT count(id) FROM '.$notificationtable.' WHERE postid = :postid AND notificationtypeid = :notificationtypeid
        AND userid = :userid';

    try{

        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":notificationtypeid", $notificationtypeid);
        $stmt -> bindParam(":postid", $postid);

        $stmt -> execute();
        $id = $stmt -> fetch();
        if($id[0]>0){
            return true;
        }else{
            return FALSE;
        }
    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO check user action on post';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();

    }
}

//get actionedarticles;

public function getUsersOnPostByType($postid,$notificationtypeid,$amtperpage,$pgn){
    if($pgn == 0){
        $limit = $amtperpage;
        $offset = 0;
    }else{
        $limit = $amtperpage;
        $offset = $pgn * $amtperpage;
    }
    //check table uset acted on;
    if($notificationtypeid == 4){
        $tableactedon = "notification";
    }elseif($notificationtypeid == 5){
        $tableactedon = "commentnotification";
    }elseif($notificationtypeid == 6){
        $tableactedon = "commentnotification";
    }elseif($notificationtypeid == 7){
        $tableactedon = "commentnotification";
    }else{
        $error = "INVALID ACTION: GET OFF NERD";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit;
    }

    $sql = 'SELECT '.$tableactedon.'.userid,notificationtypeid,dateofpublication as date,
       firstname, surname, profilepic, role.name as rolename
	   FROM '.$tableactedon.' INNER JOIN user ON '.$tableactedon.'.userid = user.id
	   INNER JOIN role ON user.roleid = role.id
	   WHERE postid = :postid AND '.$tableactedon.'.notificationtypeid = :notificationtypeid
	   GROUP BY userid ORDER BY '.$tableactedon.'.id DESC LIMIT '.$offset.', '.$limit;

    try{

        $stmt = $this -> db -> prepare($sql);

        $stmt -> bindParam(":postid", $postid);
        $stmt -> bindParam(":notificationtypeid", $notificationtypeid);

        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount > 0){
            $users = $stmt -> fetchAll();
            return $users;
        }else{
            return FALSE;
        }
    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO GET users that acted on this post';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();

    }
}


//get actionedarticles;

public function getUserNotificationPosts($userid,$amtperpage,$pgn){
    if($pgn == 0){
        $limit = $amtperpage;
        $offset = 0;
    }else{
        $limit = $amtperpage;
        $offset = $pgn * $amtperpage;
    }
    $sql = '(SELECT  commentnotification.id as notificationid, postid,dateofpublication ,user.id as userid,firstname,profilepic,notificationtypeid,marked
       FROM commentnotification INNER JOIN user ON userid = user.id
	   WHERE userid != :userid AND ( postid IN ( SELECT DISTINCT postid FROM commentnotification WHERE userid = :userid2))
	   ORDER BY commentnotification.id DESC )
	UNION (SELECT  notification.id, postid,dateofpublication ,user.id as userid,firstname,profilepic,notificationtypeid,marked
       FROM notification INNER JOIN user ON notification.userid = user.id
	   WHERE ( userid != :userid7 AND ownerid = :userid8) ORDER BY notification.id )
	   ORDER BY dateofpublication DESC LIMIT '.$offset.' , '.$limit;

    try{

        $stmt = $this -> db -> prepare($sql);

        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":userid2", $userid);
        $stmt -> bindParam(":userid7", $userid);
        $stmt -> bindParam(":userid8", $userid);


        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount > 0){
            $articles = $stmt -> fetchAll();
            return $articles;
        }else{
            return FALSE;
        }
    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO GET USER NOTIFICATION POST you acted on';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();

    }
}

//get notifications on users posts;

public function getNotificationOnUserPosts($userid,$amtperpage,$pgn){
    if($pgn == 0){
        $limit = $amtperpage;
        $offset = 0;
    }else{
        $limit = $amtperpage;
        $offset = $pgn * $amtperpage;
    }
    $sql = '(SELECT  commentnotification.id as notificationid, postid,dateofpublication ,user.id as userid,firstname,profilepic,notificationtypeid,marked
       FROM commentnotification INNER JOIN user ON userid = user.id
	   WHERE ownerid = :userid AND userid != :userid2 ORDER BY commentnotification.id DESC LIMIT '.$offset.' ,'.$limit.')
	UNION (SELECT  notification.id, postid,dateofpublication ,user.id as userid, firstname, profilepic, notificationtypeid,marked
       FROM notification INNER JOIN user ON userid = user.id
	   WHERE ownerid = :userid7 AND userid != :userid8 ORDER BY notification.id ASC LIMIT '.$offset.' ,'.$limit.')
	   ORDER BY dateofpublication DESC
	   ';

    try{

        $stmt = $this -> db -> prepare($sql);

        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":userid2", $userid);
        $stmt -> bindParam(":userid7", $userid);
        $stmt -> bindParam(":userid8", $userid);


        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount > 0){
            $articles = $stmt -> fetchAll();
            return $articles;
        }else{
            return FALSE;
        }
    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO GET NOTIFICATION ON USER POST';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();

    }
}

//COUNT USER UMREAD REACTED POSTS;

public function getCountNotificationOnUserPosts($userid){

    $sql = '(SELECT count(*) FROM commentnotification
	   WHERE ownerid = :userid AND userid != :userid2)
	UNION (SELECT count(*) FROM notification WHERE ownerid = :userid7 AND userid != :userid8)';

    try{

        $stmt = $this -> db -> prepare($sql);

        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":userid2", $userid);
        $stmt -> bindParam(":userid7", $userid);
        $stmt -> bindParam(":userid8", $userid);

        $stmt -> execute();
        $rowscount = $stmt->rowCount();
        $notifications = $stmt -> fetchAll();
   //count notifications;
        if($rowscount > 0){
            $totalcount = 0;
               for($i=0; $i<count($notifications); $i++){
                $counts = $notifications[$i][0];
                $totalcount += $counts;
            }

            return $totalcount;
        }

    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO GET COUNT OF ALL NOTIFICATIONS on user posts';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        return false;

    }
    return false;
}



//mark notifications on user posts as read;

//COUNT USER UMREAD REACTED POSTS;

public function markNotificationsOnUserPosts($notificationid,$userid,$notificationtable){

    $sql = 'UPDATE '.$notificationtable.' SET marked = "Y"
	   WHERE (ownerid = :userid AND '.$notificationtable.'.id = :notificationid AND marked = "N")';

    try{

        $stmt = $this -> db -> prepare($sql);

        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":notificationid", $notificationid);


        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount > 0){
            return true;
        }else{
            return FALSE;
        }
    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO MARK NOTIFICATIONS ON USER POST';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();

    }
}

//update noofviews;

//get all notifications when other users also act;

public function getCountAllUserNotifications($userid){

    $sql = '(SELECT count(*) FROM commentnotification
	   WHERE userid != :userid AND postid IN (SELECT DISTINCT postid FROM commentnotification WHERE userid = :userid2))
	UNION (SELECT count(*) FROM notification WHERE userid != :userid7 AND ownerid = :userid8)';

    try{

        $stmt = $this -> db -> prepare($sql);

        $stmt -> bindParam(":userid", $userid);
        $stmt -> bindParam(":userid2", $userid);
        $stmt -> bindParam(":userid7", $userid);
        $stmt -> bindParam(":userid8", $userid);


        $stmt -> execute();
        $notifications = $stmt -> fetchAll();
        if(count($notifications) > 0){
            $totalcount = 0;
            for($i=0; $i<count($notifications); $i++){
                $counts = $notifications[$i][0];
                $totalcount += $counts;
            }

            return $totalcount;
        }

    }
    catch(PDOException $e){
        $error = 'SQL ERROR UNABLE TO GET COUNT OF ALL USER NOTIFICATIONS';
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        return false;

    }
    return false;
  }

//FOR PRODUCT NOTIFICATION;

//FOR PRODUCT NOTIFICATION;
//FOR PRODUCT NOTIFICATION;
//FOR PRODUCT NOTIFICATION;
//FOR PRODUCT NOTIFICATION;
//FOR PRODUCT NOTIFICATION;


//COUNT USER UMREAD REACTED POSTS;

    public function getCountNotificationOnUserProductPosts($userid){

        $sql = '(SELECT count(*) FROM productnotification
	   WHERE ownerid = :userid AND userid != :userid2)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":userid2", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $totalcount = $stmt -> fetchAll();
            if($rowscount > 0){
                return $totalcount;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET COUNT OF ALL NOTIFICATIONS on user PRODUCT posts';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;

        }
        return false;
    }



//GET COUNT OF ALL USER NOTIFICATIONS ON PRODUCTS;
    public function getCountAllUserProductNotifications($userid){

        $sql = '(SELECT count(*) FROM productnotification
	   WHERE userid != :userid AND postid IN (SELECT DISTINCT postid FROM commentnotification WHERE userid = :userid2))';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":userid2", $userid);

            $stmt -> execute();
            $totalcount = $stmt -> fetchAll();
            if(count($notifications) > 0){

                return $totalcount;
            }

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET COUNT OF ALL USER PRODUCT NOTIFICATIONS';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;

        }
        return false;
    }


//get notifications on users Product posts;

    public function getNotificationOnUserProductPosts($userid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }
        $sql = '(SELECT  productnotification.id as notificationid, postid,dateofpublication ,
        user.id as userid,firstname,profilepic,notificationtypeid,marked,statusid,statusnote,status.name as statusname
       FROM productnotification INNER JOIN user ON userid = user.id
       INNER JOIN status ON statusid = status.id
	   WHERE ownerid = :userid AND userid != :userid2 ORDER BY productnotification.id DESC LIMIT '.$offset.' ,'.$limit.')
	   ';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":userid2", $userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $notifications = $stmt -> fetchAll();
                return $notifications;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET NOTIFICATION ON YOUR PRODUCT POSTS';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }


//get notifications ON Product posts;

    public function getUserNotificationOnProductPosts($userid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }
        $sql = '(SELECT  productnotification.id as notificationid, postid,dateofpublication ,
        user.id as userid,firstname,profilepic,notificationtypeid,marked,statusid,statusnote,status.name as statusname
       FROM productnotification INNER JOIN user ON userid = user.id
       INNER JOIN status ON statusid = status.id
	   WHERE userid != :userid AND postid IN (SELECT DISTINCT postid FROM productnotification WHERE userid = :userid2)
	   ORDER BY productnotification.id DESC LIMIT '.$offset.' ,'.$limit.')
	   ';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":userid2", $userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $notifications = $stmt -> fetchAll();
                return $notifications;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET NOTIFICATION ON PRODUCT POSTS';
            $error2 = $e -> getMessage();
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }

//update request notification status;
    public function updateSupplyRequestStatus($notificationid,$userid,$statusid,$statusnote){

        $sql = "UPDATE TABLE productnotification SET status = :statusid , statusnote = :statusnote WHERE id = :notificationid
        AND (ownerid = :userid OR userid = :userid2)";

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt->bindParam(":notificationid",$notificationid);
            $stmt->bindParam(":statusid",$statusid);
            $stmt->bindParam(":statusnote",$statusnote);
            $stmt->bindParam(":userid",$userid);
            $stmt->bindParam(":userid2",$userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $this->addNotification("productnotification",$postid,$ownerid,$userid,$notificationtypeid,$dateofpublication);
                return $mycart;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            echo $sql;
            $error = 'SQL ERROR UNABLE TO UPDATE SUPPLY REQUEST';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }
    }

//above is end of update status of request notification;

//get count of updates transaction;
//update request notification status;
    public function getCountUserSales($userid){

        $sql = "(SELECT count(*),SUM(updatecount) FROM producttransaction
                WHERE ownerid = :userid)";

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt->bindParam(":userid",$userid);

            $stmt -> execute();
            $transactioncount = $stmt->fetch();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                return $transactioncount;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO Count SALES';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }
    }

//above is end of update status of request notification;


//get count of updates transaction;
//update request notification status;
    public function getCountUserRequests($userid){

        $sql = "SELECT count(*),SUM(updatecount) FROM producttransaction
                WHERE userid = :userid";

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt->bindParam(":userid",$userid);

            $stmt -> execute();
            $transactioncount = $stmt->fetch();

                return $transactioncount;

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO Count requests';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }
    }

//above is end of update status of request notification;

//get transactions ;
    public function getUserSales($userid,$pgn,$amtperpage){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = "SELECT producttransaction.id,postid, userid, ownerid, marked, statusid, statusnote, statusdate,
                firstname, profilepic,transactionstatus.name as statusname,supplied_qty,suppliedprice FROM producttransaction
                INNER JOIN user ON userid = user.id INNER JOIN transactionstatus ON statusid = transactionstatus.id
                WHERE ownerid = :userid
                ORDER BY statusdate DESC LIMIT ".$offset." , ".$limit;

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt->bindParam(":userid",$userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            $transactions = $stmt->fetchAll();

            if($rowscount > 0){
                return $transactions;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = $error2.' SQL ERROR UNABLE TO get USER  sales transaction';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }
    }

//above is end of update status of request notification;

//get transactions ;
    public function getUserRequests($userid,$pgn,$amtperpage){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = "SELECT producttransaction.id,postid, userid, ownerid, marked, statusid, statusnote, statusdate,
                firstname, profilepic,transactionstatus.name as statusname,supplied_qty,suppliedprice FROM producttransaction
                INNER JOIN user ON ownerid = user.id INNER JOIN transactionstatus ON statusid = transactionstatus.id
                WHERE userid = :userid
                ORDER BY statusdate DESC LIMIT ".$offset." , ".$limit;

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt->bindParam(":userid",$userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            $transactions = $stmt->fetchAll();

            if($rowscount > 0){
                return $transactions;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO get USER  requests transaction';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }
    }

//above is end of update status of request notification;

}

?>