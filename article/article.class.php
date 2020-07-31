<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/helpers/mediafilehandler.php';

class article{
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

    public function getarticle($articleid,$amtperpage,$pgn){
        $article = array();
        $takes = array();
        $files = array();
        $replies = array();
        $level3replies = array();

        if($pgn== 0){
            $offset = 0;
            $limit = $amtperpage;
        }else{
            $offset = $pgn * $amtperpage;
            $limit = $amtperpage;
        }


        $sql = '(SELECT article.id, title, detail, articleimagedisplayname,
	   dateofpublication, userid, user.firstname,user.surname,
	   category.name as categoryname,nooffollows,noofcomments,profilepic,article.public as public,category.id AS categoryid
	   FROM article INNER JOIN user ON
	   article.userid = user.id INNER JOIN category ON
	   article.categoryid = category.id
	   WHERE article.id = :articleid)
 UNION (SELECT id, title, filename , displayname, type,
	articleid, id ,"files","files",1,2,"files2","F","categoryid"
	FROM file
	WHERE articleid = :articleid2)';

        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);
            $stmt -> bindParam(":articleid", $articleid);
            $stmt -> bindParam(":articleid2", $articleid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $articleandfiles = $stmt -> fetchAll();


        }
        catch(PDOException $e){
            $error = 'no article found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }


//get comments;

        $sql2 = '(SELECT reply.id, detail, commentimagedisplayname,
	   dateofpublication,articleid,commentid, userid, user.firstname,user.surname,
	   nooffollows,noofcomments,replylevel,user.profilepic FROM reply INNER JOIN user ON
	   reply.userid = user.id
	   WHERE reply.articleid = :articleid AND replylevel = 1
	   ORDER BY reply.id LIMIT '.$offset.', '.$limit.')
 UNION (SELECT reply.id, detail, commentimagedisplayname,
	   dateofpublication,articleid,commentid, userid, user.firstname,user.surname,
	   nooffollows,noofcomments,replylevel,user.profilepic FROM reply INNER JOIN user ON
	   reply.userid = user.id
	   WHERE reply.articleid = :articleid2 AND replylevel = 2
	   ORDER BY reply.id LIMIT '.$offset.', '.$limit.')
 UNION (SELECT reply.id, detail, commentimagedisplayname,
	   dateofpublication,articleid,commentid, userid, user.firstname,user.surname,
	   nooffollows,noofcomments,replylevel,user.profilepic FROM reply INNER JOIN user ON
	   reply.userid = user.id
	   WHERE reply.articleid = :articleid3 AND replylevel = 3
	   ORDER BY reply.id LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $dbh -> prepare($sql2);
            $stmt -> bindParam(":articleid", $articleid);
            $stmt -> bindParam(":articleid2", $articleid);
            $stmt -> bindParam(":articleid3", $articleid);

            $stmt -> execute();
            $takesrowscount = $stmt -> rowCount();

            $takeandreplies = $stmt -> fetchAll();


        }
        catch(PDOException $e){
            $error = 'no comments found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        //sort takes for replies;
        if($takesrowscount > 0){
            for($i=0; $i<count($takeandreplies); $i++){
                //replace empty comment images;
                if(empty($takeandreplies[$i]["profilepic"])){
                    $takeandreplies[$i]["profilepic"] = "/api/img/users/user.jpg";
                }
                if($takeandreplies[$i]["replylevel"] == 1){
                    $takes[] = $takeandreplies[$i];
                }elseif($takeandreplies[$i]["replylevel"] == 2){
                    $replies[] = $takeandreplies[$i];
                }else{
                    $level3replies[] = $takeandreplies[$i];
                }
            }
        }


        //sort article for files;
        if($rowscount > 0){
            $article[] = $articleandfiles[0];
        }

        if($rowscount > 1){
            for($i=1; $i<count($articleandfiles); $i++){

                //replace empty article images;
                if(empty($article[$i]["articleimagedisplayname"])){
                    $article[$i]["articleimagedisplayname"] = "/api/img/articles/article.jpg";
                }   $files[] = $articleandfiles[$i];
                }
            }



        $this -> increaseNoOfProperty("article",$articleid,"noofviews");


        return array("article" => $article, "files" => $files,
            "takes" => $takes, "replies2" => $replies, "replies3" => $level3replies);

    }
//end of getarticle;
//get take;

    public function getTake($takeid,$amtperpage,$pgn){
            $takes = array(); $replies = array();
        if($pgn== 0){
            $offset = 0;
            $limit = $amtperpage;
        }else{
            $offset = $pgn * $amtperpage;
            $limit = $amtperpage;
        }

//get comments;

        $sql2 = '(SELECT reply.id, detail, commentimagedisplayname,
	   dateofpublication,articleid, commentid, userid, user.firstname,user.surname,
	   nooffollows,noofcomments,replylevel,user.profilepic  FROM reply
	    INNER JOIN user ON reply.userid = user.id
	   WHERE reply.id = :commentid)
 UNION (SELECT reply.id, detail, commentimagedisplayname,
	   dateofpublication,articleid, commentid, userid, user.firstname,user.surname,
	   nooffollows,noofcomments,replylevel,user.profilepic  FROM reply
	    INNER JOIN user ON reply.userid = user.id
	   WHERE commentid = :commentid2
	   ORDER BY reply.id LIMIT '.$offset.', '.$limit.')';

        try{
            $dbh = $this->db;
            $stmt = $dbh -> prepare($sql2);
            $stmt -> bindParam(":commentid", $takeid);
            $stmt -> bindParam(":commentid2", $takeid);

            $stmt -> execute();
            $takesrowscount = $stmt -> rowCount();

            $takeandreplies = $stmt -> fetchAll();

        }
        catch(PDOException $e){
            $error = 'no comments found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
       if($takesrowscount > 0){
           /*//substitute empty take images;
           if(!empty($takeandreplies)){
               for($i=0; $i<count($takeandreplies); $i++){
                   if(empty($takeandreplies[$i]['commentimagedisplayname'])){
                       $takeandreplies[$i]['commentimagedisplayname'] = "/api/img/takes/take.jpg";
                   }
               }
           }*/

           return $takeandreplies;
       }

        return false;
    }
//end of getarticle;

//getMORETAKES;
//end getmorearticle;
//get previous articlestakes;
//end getPreviousrticletakes;


//add article files article;
    public function addarticleFile($articlefilesarray,$folder,$filetitlesarray,$articleid,$userid){
        //storefile and gather file details in an array code;
        for($i=0; $i<count($articlefilesarray); $i++){
            if($row = storeFile($articlefilesarray[$i], $folder,$filetitlesarray[$i])){
                $imgs[]= $row;
            }
        }
        // make an sql value string of each file's deatail;
        if(!empty($imgs)){
            for($i=0; $i<count($imgs); $i++){
                $value='( "'.$imgs[$i]["title"].'","'.$imgs[$i]["filename"].'",
"'.$imgs[$i]["displayname"].'","'.$imgs[$i]["type"].'","'.$articleid.'","'.$userid.'")';

                $filevalues[] = $value;
            }
            //convert all to string;
            $filevalues=implode(",", $filevalues);

            $sql = 'INSERT INTO file
        (title,filename,displayname,type,articleid,userid)
        VALUES '. $filevalues;

            try{
                $stmt = $this -> db -> prepare($sql);

                $stmt -> execute();
                $rowscount = $stmt -> rowCount();

            }
            catch(PDOException $e){
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
        return FALSE;
    }
//end of addarticle;

//create article;
    public function addarticle($title , $detail,$articleimagefile, $articleimagedisplayname,
                               $dateofpublication, $userid, $categoryid,$public,$focalareaid,$clusterid){
//echo($_POST["countgrouplevel1s"]." and ". $_POST["grouplevel1id2"]); exit;

        $sql = 'INSERT INTO article (title,detail,articleimagefile,articleimagedisplayname,
	   dateofpublication, userid, categoryid,public,focalareaid, clusterid)
	  VALUES(:title , :detail ,:articleimagefile ,:articleimagedisplayname,
	   :dateofpublication, :userid, :categoryid, :public, :focalareaid, :clusterid)';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":title", $title);
            $stmt -> bindParam(":detail", $detail);

            $stmt -> bindParam(":articleimagefile", $articleimagefile);
            $stmt -> bindParam(":articleimagedisplayname", $articleimagedisplayname);
            $stmt -> bindParam(":dateofpublication", $dateofpublication);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":categoryid", $categoryid);
            $stmt -> bindParam(":public", $public);
            $stmt -> bindParam(":focalareaid", $focalareaid);

            $stmt -> bindParam(":clusterid", $clusterid);


            $stmt -> execute();
            $articleid = $this->db->lastInsertId();

            /*add into warda*/

            //add product category;
            if(!empty($_POST["countgrouplevel1s"])){
                $g1count = $_POST["countgrouplevel1s"];
                $value_str = '';
                for($i=0; $i<$g1count; $i++){
                    $group_postname = "grouplevel1id".$i;
                    if(!empty($_POST[$group_postname])){
                        $g = htmlspecialchars($_POST[$group_postname]);
                        $value_str .= "(".$articleid.",".$g."),";
                        //echo($g ." and ".$group_postname);
                    }
                }

                //echo($_POST[$group_postname] ." and ".$group_postname);
                if($value_str == ''){
                    $value_str = "(".$articleid.", 1),";
                }
                $strlen = (strlen($value_str))-1;
                $value_str = substr($value_str,0,$strlen);

                $clustersql = "INSERT INTO grouplevel1article (articleid , groupid)
                        VALUES".$value_str;


                try{
                    $db = $this -> db;
                    $stmt =  $db-> prepare($clustersql);
                    $stmt -> execute();

                }
                catch(PDOException $e){
                    $error = $e -> getMessage().' sql= '.$clustersql.' '.'unable to associate to a cluster';
                    $error2 = $e -> getMessage();
                    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                    exit;
                }
            }
            /*end add into ward*/

            //add into grop2
            if(!empty($_POST["countgrouplevel2s"])){
                $g1count = $_POST["countgrouplevel2s"];
                $value_str = '';
                for($i=0; $i<$g1count; $i++){
                    $group_postname = "grouplevel2id".$i;
                    if(!empty($_POST[$group_postname])){
                        $g = htmlspecialchars($_POST[$group_postname]);
                        $value_str .= "(".$articleid.",".$g."),";
                    }
                }
                if($value_str == ''){
                    $value_str = "(".$articleid.", 1),";
                }
                $strlen = (strlen($value_str))-1;
                $value_str = substr($value_str,0,$strlen);

                $clustersql = "INSERT INTO grouplevel2article (articleid , groupid)
                        VALUES".$value_str;


                try{
                    $db = $this -> db;
                    $stmt =  $db-> prepare($clustersql);
                    $stmt -> execute();
                }
                catch(PDOException $e){
                    $error = $e -> getMessage().' '.$clustersql.' '.'unable to associate to a cluster';
                    $error2 = $e -> getMessage();
                    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                    exit;
                }
            }
            //end add into grop2

            //add group into group3

            //add product category;
            if(!empty($_POST["countgrouplevel3s"])){
                $g1count = $_POST["countgrouplevel3s"];
                $value_str = '';
                for($i=0; $i<$g1count; $i++){
                    $group_postname = "grouplevel3id".$i;
                    if(!empty($_POST[$group_postname])){
                        $g = htmlspecialchars($_POST[$group_postname]);
                        $value_str .= "(".$articleid.",".$g."),";
                    }
                }
                if($value_str == ''){
                    $value_str = "(".$articleid.", 1),";
                }
                $strlen = (strlen($value_str))-1;
                $value_str = substr($value_str,0,$strlen);

                $clustersql = "INSERT INTO grouplevel3article (articleid , groupid)
                        VALUES".$value_str;


                try{
                    $db = $this -> db;
                    $stmt =  $db-> prepare($clustersql);
                    $stmt -> execute();
                }
                catch(PDOException $e){
                    $error = $e -> getMessage().' '.$clustersql.' '.'unable to associate to a cluster';
                    $error2 = $e -> getMessage();
                    include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                    exit;
                }
            }

            //end add into group3

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = "article Not Created";
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }




        return true;
    }

//end of addarticle;

//add take to article;
    public function addTake($detail, $dateofpublication,
                            $articleid,$userid,$inserttable,$incrementtable,$takelevel,$postownerid){

        if($takelevel ==1){
            $sql = 'INSERT INTO '.$inserttable.' (detail, dateofpublication,
 	  articleid,userid)
	  VALUES(:detail, :dateofpublication,
 	  :articleid, :userid)';

            try{
                $stmt = $this -> db -> prepare($sql);
                $stmt -> bindParam(":detail", $detail);
                $stmt -> bindParam(":dateofpublication", $dateofpublication);
                $stmt -> bindParam(":articleid", $articleid);
                $stmt -> bindParam(":userid", $userid);

                $stmt -> execute();
                $rowscount = $stmt -> rowCount();
                $postid = $this->db->lastInsertId();
            }
            catch(PDOException $e){
                $error = "unable to insert take ". $sql;
                $error2 = $e -> getMessage();
                include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                exit();
            }

            $this->increaseNoOfProperty($incrementtable,$articleid,"noofcomments");
            $notification = new Notification();
            $notification ->addNotification("commentnotification",$postid, $postownerid,$userid,1,$dateofpublication);



        }else{
            $sql = 'INSERT INTO '.$inserttable.' (detail, dateofpublication,
 	  articleid,userid,takeid)
	  VALUES(:detail, :dateofpublication,
 	  :articleid, :userid,:takeid)';

            try{
                $stmt = $this -> db -> prepare($sql);
                $stmt -> bindParam(":detail", $detail);
                $stmt -> bindParam(":dateofpublication", $dateofpublication);
                $stmt -> bindParam(":articleid", $articleid);
                $stmt -> bindParam(":userid", $userid);
                $stmt -> bindParam(":takeid", $takeid);

                $stmt -> execute();
                $rowscount = $stmt -> rowCount();
                $postid = $this->db->lastInsertId();
            }
            catch(PDOException $e){
                $error = "unable to insert take ". $sql;
                $error2 = $e -> getMessage();
                include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                exit();
            }

            $this->increaseNoOfProperty($incrementtable,$takeeid,"noofcomments");
            $notification = new Notification();
            $notification ->addNotification($inserttable."notification" ,$postid, $postownerid,$uid,1,$dop);

        }
        return true;

    }
//end of addtake;
//add new comment;

//add take to article;
    public function addComment($detail, $dateofpublication,$commentimagedisplayname,
                            $articleid,$commentid,$userid,$replylevel,$notificationtypeid,$postownerid){

            $sql = 'INSERT INTO reply (detail, dateofpublication, commentimagedisplayname,
 	  articleid,commentid,userid,replylevel)
	  VALUES(:detail, :dateofpublication, :commentimagedisplayname,
 	  :articleid, :commentid, :userid, :replylevel)';

            try{
                $stmt = $this -> db -> prepare($sql);
                $stmt -> bindParam(":detail", $detail);
                $stmt -> bindParam(":dateofpublication", $dateofpublication);
                $stmt -> bindParam(":commentimagedisplayname", $commentimagedisplayname);
                $stmt -> bindParam(":articleid", $articleid);
                $stmt -> bindParam(":commentid", $commentid);
                $stmt -> bindParam(":userid", $userid);
                $stmt -> bindParam(":replylevel", $replylevel);

                $stmt -> execute();
                $rowscount = $stmt -> rowCount();
                $postid = $this->db->lastInsertId();
            }
            catch(PDOException $e){
                $error = "unable to insert take";
                $error2 = $e -> getMessage()." ".$sql;
                include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                exit();
            }

        if($replylevel == 1){
            $this->increaseNoOfProperty("article",$articleid,"noofcomments");
        }else{
            $this->increaseNoOfProperty("reply",$commentid,"noofcomments");
        }
            $notification = new Notification();
            $notification ->addNotification("commentnotification",$commentid, $postownerid,$userid,$notificationtypeid,$dateofpublication);


        return true;

    }
//end of addcomment;
//add level3comment;

//add take to article;
//update noofviews
public  function increaseNoOfProperty($incrementtable,$tableid,$property){
    $sql = "UPDATE ".$incrementtable." SET ".$property." = ".$property." + 1 WHERE id = :tableid";
    try{
        $stmt = $this ->db->prepare($sql);
        $stmt ->bindParam(":tableid",$tableid);
        $stmt -> execute();
    }catch (PDOException $e){
        $error2 = $e->getMessage();
        $error = "Did not increase value";
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        return false;
    }
    return true;
}


    //decrease noofaction;
    public  function decreaseNoOfProperty($incrementtable,$tableid,$property){
        $sql = "UPDATE ".$incrementtable." SET ".$property." = ".$property." - 1 WHERE id = :tableid";
        try{
            $stmt = $this ->db->prepare($sql);
            $stmt ->bindParam(":tableid",$tableid);
            $stmt -> execute();
        }catch (PDOException $e){
            $error2 = $e->getMessage();
            $error = "Did not decrease value";
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;
        }
        return true;
    }


//update take property;
//editarticle;
    public function editarticle($articleid, $userid, $title, $detail, $dateofpublication,
                                $articleimagedisplayname){
        $sql = 'UPDATE article SET title = :title,
	   detail = :detail, dateofpublication = :dateofpublication,
 	   articleimagedisplayname = :articleimagedisplayname
	   WHERE id = :articleid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":title", $title);
            $stmt -> bindParam(":detail", $detail);
            $stmt -> bindParam(":dateofpublication", $dateofpublication);
            $stmt -> bindParam(":articleimagedisplayname", $articleimagedisplayname);
            $stmt -> bindParam(":articleid", $articleid);
            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

    return TRUE;

    }

//end of editarticle;

//edittake;


    public function editTake($commentid, $userid, $detail, $dateofpublication,$commentimagedisplayname){
        $sql = 'UPDATE reply SET
	   detail = :detail, dateofpublication = :dateofpublication,
	   commentimagedisplayname = :commentimagedisplayname
	   WHERE id = :commentid AND userid = :userid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":detail", $detail);
            $stmt -> bindParam(":dateofpublication", $dateofpublication);
            $stmt -> bindParam(":commentimagedisplayname", $commentimagedisplayname);
            $stmt -> bindParam(":commentid", $commentid);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO UPDATE YOUR COMMENT';
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

//end of edittake;


//deletearticle;
    public function deletearticle($articleid, $userid){
        $this -> deletearticleFiles($articleid);
        $sql = 'DELETE FROM article
	   WHERE id = :articleid AND userid = :userid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":articleid", $articleid);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE YOUR article';
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

//end of deletearticle;


//delete take;
    public function deleteTake($takeid, $userid,$replylevel,$decrementtableid){

        //DELETE IMAGE FILE;
        $sql = '(SELECT commentimagedisplayname FROM reply
	   WHERE reply.id = :takeid)
	   UNION (SELECT commentimagedisplayname FROM reply WHERE commentid = :takeid2)';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":takeid", $takeid);
            $stmt -> bindParam(":takeid2", $takeid);


            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $commentimage = $stmt->fetchAll();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO get comment image on YOUR COMMENT';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        if($rowscount>0){
            for($i=0; $i<count($commentimage); $i++){
                $image = $_SERVER["DOCUMENT_ROOT"].$commentimage[$i][0];
                if((!empty($commentimage)) AND file_exists($image)){
                    unlink($image);
                }
            }
        }

        $sql = 'DELETE FROM reply
	   WHERE reply.id = :takeid AND userid = :userid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":takeid", $takeid);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE YOUR COMMENT';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        //delete comments;

        $sql = 'DELETE FROM reply
	   WHERE (commentid = :takeid)';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":takeid", $takeid);


            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE Comments YOUR COMMENT';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($replylevel == 1){
            $this->decreaseNoOfProperty("article",$decrementtableid,"noofcomments");
        }else{
            $this->decreaseNoOfProperty("reply",$decrementtableid,"noofcomments");
        }
            return true;

    }

//end of deletetake;


//delete article files;
    public function deletearticleFiles($articleid){
        $sql = '(SELECT filename FROM file WHERE articleid = :articleid)
	UNION (SELECT articleimagefile FROM article WHERE article.id = :articleid2)';

        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":articleid", $articleid);
        $stmt -> bindParam(":articleid2", $articleid);

        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount > 0){
            $files = $stmt -> fetchAll();

            for($i =0; $i < count($files); $i++){
                $file = $files[$i]["filename"];
                unlink($file);
            }
        }
        $sql = 'DWLETE FROM file WHERE articleid = :articleid';
        $stmt = $this -> db -> prepare($sql);
        $stmt -> bindParam(":articleid", $articleid);

        $stmt -> execute();
        $rowscount = $stmt -> rowCount();
        if($rowscount > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
//end of delete files;

//delete an articleFILE;
    public function deleteFile($fileid,$filename,$userid){
        if(file_exists($filename)){
            unlink($filename);
            $error = 'PROBLEM DELETING FILE';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
//delete from database;
        $sql = 'DELETE FROM file
	   WHERE id = :fileid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":fileid", $fileid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE YOUR FILE';
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
//end of delete a file;
//make article public;

//get categories;
    public function makeArticlePublic($articleid){
        $sql = 'UPDATE article SET public = "Y" WHERE id = :articleid';

        try{

            $stmt = $this -> db -> prepare($sql);
            $stmt->bindParam(":articleid",$articleid);
            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                return true;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO make article public';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of make public;
//get categories;
    public function getCategories(){
        $sql = '(SELECT id , name , note, parentcategoryid FROM category)';

        try{
            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $categories = $stmt -> fetchAll();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                //sort maincategories from subcategories
                $subcategories = array();
                $maincategories = array();

                for($i=0; $i<count($categories); $i++){
                    if($categories[$i]["parentcategoryid"] != 0){
                        $subcategories[]=$categories[$i];
                    }else{
                        $maincategories[] = $categories[$i];
                    }
                }

                //sort subcategories for each maincategory
                if(count($maincategories)>0){
                    for($i=0;  $i<count($maincategories); $i++){
                        for($l=0; $l<count($subcategories); $l++){
                            if($subcategories[$l]["parentcategoryid"] == $maincategories[$i]["id"]){
                                $maincategories[$i]["subcategories"][]= $subcategories[$l];
                            }
                        }

                    }
                }

                return array("allcategories"=>$categories,"maincategories"=>$maincategories, "subcategories"=>$subcategories);
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET article CATEGORIES';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
    }
//end of get categories;

//end of check user action;
//get articles by categories;
//end of getmorejobs;
//end of getprevious category;

    public function getarticlesByCategory($categoryid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }
        $sql = '(SELECT article.id, title, articleimagedisplayname,
	   dateofpublication,firstname, category.id as categoryid,
	   category.name as categoryname,noofviews,noofcomments,nooffollows,user.id as userid
	   FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   WHERE (category.id = :categoryid)
	   ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":categoryid", $categoryid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $articles = $stmt -> fetchAll();
            if($rowscount > 0){
                //substitute empty article images;
                for($i=0; $i<count($articles); $i++){
                    if(empty($articles[$i]['articleimagedisplayname'])){
                        $articles[$i]['articleimagedisplayname'] = "/api/img/articles/article.jpg";
                    }
                }
                return $articles;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET THIS TO GET article CATEGORY';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcategorys;


    public function getarticlesByProperty($pty,$value,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }
        $presql = '(SELECT article.id, title, articleimagedisplayname,
	   dateofpublication,firstname, category.id as categoryid,
	   category.name as categoryname,noofviews,noofcomments,
	   nooffollows, user.id as userid, grouplevel1.name As grouplevel1name
	   , grouplevel2.name As grouplevel2name, grouplevel3.name As grouplevel3name
	   FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   INNER JOIN grouplevel1article ON grouplevel1article.articleid = article.id
	   INNER JOIN grouplevel1 ON grouplevel1.id = grouplevel1article.groupid
	   INNER JOIN grouplevel2article ON grouplevel2article.articleid = article.id
	   INNER JOIN grouplevel2 ON grouplevel2.id = grouplevel2article.groupid
	   INNER JOIN grouplevel3article ON grouplevel3article.articleid = article.id
	   INNER JOIN grouplevel3 ON grouplevel3.id = grouplevel3article.groupid
	   WHERE ';


        if(($pty == 'wq') || $amtperpage == 0){
            $sql = $presql.' '.$value;
        }else{
            $sql = $presql.$pty .' = '.$value.' GROUP BY article.id ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';
        }
        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $articles = $stmt -> fetchAll();
            if($rowscount > 0){
                //substitute empty article images;
                for($i=0; $i<count($articles); $i++){
                    if(empty($articles[$i]['articleimagedisplayname'])){
                        $articles[$i]['articleimagedisplayname'] = "/api/img/articles/article.jpg";
                    }
                }
                return $articles;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET THIS TO GET article property';
            $error = $error.': '. $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcategorys;

//get published;
    public function getPublishedArticlesByCategory($categoryid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = '(SELECT article.id, title, articleimagedisplayname,
	   dateofpublication,firstname, category.id as categoryid,
	   category.name as categoryname,noofviews,noofcomments,nooffollows,user.id as userid
	   FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   WHERE (article.public = "Y" AND category.id = :categoryid)
	   ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":categoryid", $categoryid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $articles = $stmt -> fetchAll();
            if($rowscount > 0){
                //substitute empty article images;
                for($i=0; $i<count($articles); $i++){
                    if(empty($articles[$i]['articleimagedisplayname'])){
                        $articles[$i]['articleimagedisplayname'] = "/api/img/articles/article.jpg";
                    }
                }
                return $articles;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET published TO GET article CATEGORY';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcategorys;

    public function getCategory($categoryid){

        $sql = '(SELECT id as categoryid, category.name AS categoryname, category.note AS categorynote,
        (SELECT category.name FROM category
         WHERE category.id = (SELECT parentcategoryid FROM category WHERE id = :categoryid)) AS parentcategoryname
	     FROM category WHERE category.id = :categoryid2)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":categoryid", $categoryid);
            $stmt -> bindParam(":categoryid2", $categoryid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $category = $stmt -> fetch(PDO::FETCH_ASSOC);
                return $category;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET CATEGORY';
            $error2 = $e -> getMessage();
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit;
        }
    }
//end of getcategorys;


    public function getCategorySubcategory($categoryid){

        $sql = '(SELECT id as categoryid, category.name AS categoryname, category.note AS categorynote
	   FROM category WHERE parentcategoryid = :categoryid)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":categoryid", $categoryid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $category = $stmt -> fetch(PDO::FETCH_ASSOC);
                return $category;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET CATEGORY';
            $error2 = $e -> getMessage();
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit;
        }
    }
//end of getcategorys;

//update count articles
    public function updateLastArticlesCount($userid){
        $sql = 'UPDATE user SET lastarticlescount = (SELECT COUNT(*) FROM article) WHERE user.id = :userid';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt->bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                return true;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO update user count of articles';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcategorys;


    public function checkNewArticles($userid){


        $sql = 'SELECT (SELECT COUNT(*) FROM article) - lastarticlescount FROM user WHERE user.id = :userid';

        try{

            $stmt = $this -> db -> prepare($sql);
            $stmt->bindParam(":userid", $userid);

            $stmt -> execute();
            $no_of_articles = $stmt -> fetch();

            return $no_of_articles[0];

        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE get new articles count';
            $error = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            return false;

        }
    }
//end of check new articles;

    public function getarticles($amtperpage,$pgn){

        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = '(SELECT article.id, title, articleimagedisplayname,
	   dateofpublication,firstname, category.id as categoryid,
	   category.name as categoryname,noofviews,noofcomments,nooffollows
	   FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $articles = $stmt -> fetchAll();

            if($rowscount > 0){
                //substitute empty article images;
                for($i=0; $i<count($articles); $i++){
                    if(empty($articles[$i]['articleimagedisplayname'])){
                        $articles[$i]['articleimagedisplayname'] = "/api/img/articles/article.jpg";
                    }
                }
                return $articles;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET THIS TO GET articleS';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcategorys;

//GET PUBLISHED ARTICLED

    public function getPublishedArticles($orderBy,$amtperpage,$pgn){

        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = '(SELECT article.id, title, articleimagedisplayname,
	   dateofpublication,firstname, category.id as categoryid,
	   category.name as categoryname,noofviews,noofcomments
	   FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   WHERE article.public = "Y"
	   ORDER BY '.$orderBy.' LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $articles = $stmt -> fetchAll();

            if($rowscount > 0){
                //substitute empty article images;
                for($i=0; $i<count($articles); $i++){
                    if(empty($articles[$i]['articleimagedisplayname'])){
                        $articles[$i]['articleimagedisplayname'] = "/api/img/articles/article.jpg";
                    }
                }
                return $articles;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET PUBLISHED articleS';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getPUBLISHEDs;

    public function getGalleryFiles($filetypeid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }
        $filetype = "";
        if($filetypeid == 1){
            $filetype = "image";
        }elseif($filetypeid ==2){
            $filetype = "audio";
        }else{
            $filetype = "video";
        }

        $sql = "SELECT file.id as fileid, file.title as filetitle, displayname, type, articleid FROM file
         WHERE type LIKE '".$filetype."%' LIMIT ".$offset." , ".$limit;

        try{


            $stmt = $this -> db -> prepare($sql);


            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $galleryfiles = $stmt -> fetchAll();
                return $galleryfiles;


            }else{
                return FALSE;
            }
        }catch (PDOException $e){

            $error = 'SQL ERROR UNABLE TO GET all gallery contents';
            $error2 = $e -> getMessage();
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit;
        }
    }
//end of getcategorys;

    public function getUserArticles($userid,$amtperpage,$pgn){

        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = '(SELECT article.id, title, articleimagedisplayname,
	   dateofpublication,firstname, category.id as categoryid,
	   category.name as categoryname,noofviews,noofcomments
	   FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   WHERE userid = :userid ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $this -> db -> prepare($sql);
            $stmt->bindParam(":userid",$userid);
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
            $error = 'SQL ERROR UNABLE TO GET THIS TO GET articleS for user';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcategorys user;

//get commented articles;
    public function getCommentedarticles($userid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = '(SELECT article.id, article.title as title, article.articleimagedisplayname,
	   article.dateofpublication,firstname, categoryid,
	   article.noofviews,article.noofcomments,article.nooffollows
	   FROM reply INNER JOIN article ON article.id = articleid
	   INNER JOIN user ON article.userid = user.id
	   WHERE reply.userid = :userid
	   GROUP BY article.id ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';

        try{

            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);

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
            $error = 'SQL ERROR UNABLE TO GET THIS commented article';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of getcommented;
//get previous commented articles;
//end of getprevious commented articles;
//get more commented articles;
//end of getprevirgetfous cat
//get categories;
    public function getFocalAreas(){
        $sql = '(SELECT id, name FROM focalarea ORDER BY name ASC)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $focalareas = $stmt -> fetchAll();
                return $focalareas;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET focal areas';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of get categories;


    public function getFocalArea($focalareaid){

        $focalarea = array();
        $articles = array();

        $sql = '(SELECT focalarea.id AS focalareaid,focalarea.name AS focalareaname,
       focalarea.note AS focalareanote FROM focalarea
       WHERE focalarea.id = :focalareaid)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":focalareaid", $focalareaid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $focalarea = $stmt -> fetch(PDO::FETCH_ASSOC);

                //get articles;
                $articles = $this->getArticlesByFocalArea($focalareaid,12,0);
                return array("focalarea"=> $focalarea, "articles"=>$articles);
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET FOCAL AREA';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/aspwd/includes/errors/error.html.php';
            exit();

        }
    }
//end of GET FOCAL AREA;

    public function getArticlesByFocalArea($focalareaid,$amtperpage,$pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }

        $sql = '(SELECT article.id as articleid, title, articleimagedisplayname,
	            dateofpublication, category.id as categoryid,
	            category.name as categoryname, focalarea.name as focalareaname,
	            noofviews
	            FROM article INNER JOIN category ON categoryid = category.id
	            INNER JOIN focalarea ON article.focalareaid = focalarea.id
	            WHERE (focalareaid = :focalareaid)
	            ORDER BY article.id DESC LIMIT '.$offset.', '.$limit.')';


        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":focalareaid", $focalareaid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($rowscount > 0){
                //substitute empty article images;
                for($i=0; $i<count($articles); $i++){
                    if(empty($articles[$i]['articleimagedisplayname'])){
                        $articles[$i]['articleimagedisplayname'] = "/api/img/articles/article.jpg";
                    }
                }
                return $articles;
            }
        }catch (PDOException $e){
            $error2 = $e -> getMessage();
            $error = $error2. 'SQL ERROR UNABLE TO GET articles for focal area';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        return false;
    }


}
//end of article class;

?>