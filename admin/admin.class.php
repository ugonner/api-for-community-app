<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/user/user.class.php';
class admin extends user{
    protected $adminfunction;


//get users for action;
    public function getUsersByNameEmailMobile($name_email_or_mobile){
        $sql = '(SELECT id,firstname,surname,profilepic FROM user
	       WHERE (firstname = :nem OR surname = :nem2 OR email = :nem3
	       OR mobile = :nem4))';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":nem", $name_email_or_mobile);
            $stmt -> bindParam(":nem2", $name_email_or_mobile);
            $stmt -> bindParam(":nem3", $name_email_or_mobile);
            $stmt -> bindParam(":nem4", $name_email_or_mobile);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $users = $stmt -> fetchAll();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No match found";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return $users;
        }
        else{
            return FALSE;
        }
    }
//end get users;
//selectuserforaction;
    public function selectUserForAction($userid){
        $sql = '(SELECT id,firstname,surname,profilepic FROM user
	       WHERE id = :userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $user = $stmt -> fetchAll();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No match found";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return $user;
        }
        else{
            return FALSE;
        }
    }
//end select user;
//is productcategoryadminby nameemailmobile;
 public function isproductcategoryAdmin($userid,$productcategoryid){
        $sql = '(SELECT userid FROM productcategoryadminuser
	       WHERE userid = :userid AND productcategoryid = :productcategoryid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":productcategoryid", $productcategoryid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $row = $stmt -> fetch();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($row[0] > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of isproductcategoryAdmin;
//is an admin any;
    public function isAdmin($userid){
        $sql = '(SELECT userid FROM superadmin
	       WHERE userid = :userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $row = $stmt -> fetch();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function isClusterMember($userid,$clusterid){
        $sql = '(SELECT userid FROM clusteruser
	       WHERE clusterid = :clusterid AND userid = :userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":clusterid", $clusterid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $row = $stmt -> fetch();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//
//een of is admin of any sort;

    public function getUserClusters($userid){
        $sql = '(SELECT cluster.id AS clusterid, cluster.name AS clustername
          FROM cluster INNER JOIN clusteruser
          WHERE userid = :userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $clusters = $stmt -> fetch();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return $clusters;
        }
        else{
            return FALSE;
        }
    }
//
//een of is admin of any sort;

//is superadmin;
    public function isSuperAdmin($userid){
        $sql = '(SELECT userid FROM superadmin
	       WHERE userid = :userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $row = $stmt -> fetch();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($row[0] > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of hasRoleAdmin;
//isblocked;
    public function isBlocked($userid){
        $sql = '(SELECT userid FROM blockeduser
	       WHERE userid = :userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $row = $stmt -> fetch();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($row[0] > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of idblocked;
//certify or assign a role;
    public function assignUserRole($userid , $roleid,$rolenote){
        $sql = 'UPDATE user SET roleid = :roleid,
                rolenote = :rolenote
                WHERE id = :userid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":roleid", $roleid);
            $stmt -> bindParam(":rolenote", $rolenote);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            if($error2 == "SQLlocation[HY000]: General error"){
                return $error2;
            }else{
                $error = "SQL: No check for user is a productcategory admin";
                include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                exit();
            }
        }
        if($row[0] > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of assign a role to user;
//confirm transaction;

//update noofviews;
    public  function editRoleProperty($roleid,$property,$value){

        $sql = "UPDATE role SET ".$property."= :value WHERE id = :roleid";
        try{
            $stmt = $this ->db->prepare($sql);
            $stmt->bindParam(":value",$value);
            $stmt->bindParam(":roleid",$roleid);

            $stmt -> execute();
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }


//make productcategory admin;

    public function joinClusters($userid,$clusterids){
        //build values string;
        $value_str = "";
        for($i=0; $i<count($clusterids); $i++){
            $value_str .= ("(".$userid.",".$clusterids[$i] .'),');
        }
        $str_length = strlen($value_str) - 1;
        $value_str = substr($value_str,0,$str_length);

        $sql = 'INSERT INTO clusteruser (userid,clusterid) VALUES'.$value_str;
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: error ".$error2;
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

//make productcategory admin;
    public function makeUserproductcategoryAdmin($userid,$productcategoryid){
        $sql = 'INSERT INTO productcategoryadminuser (productcategoryid,userid) VALUES(:productcategoryid,:userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":productcategoryid", $productcategoryid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            if($error2 == "SQLlocation[HY000]: General error"){
                return $error2;
            }else{
                $error = "SQL: User Has Already Been A productcategory Admin For This productcategory";
                include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                exit();
            }
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of makeproductcategoryAdmin;
//makeuser a super admin;

    public function makeUserSuperAdmin($userid){
        $sql = 'INSERT INTO superadmin (userid) VALUES(:userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: User alreay a super user. unable to make user superadmin";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of superAdmin;

//block user;
    public function blockUser($userid){
        $sql = 'INSERT INTO blockeduser (userid) VALUES(:userid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to block user";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of blockuser;
//add a role;
    public function addRole($rolename){
        $sql = 'INSERT INTO role (name) VALUES(:rolename)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":rolename", $rolename);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: role alreay exists. unable to addarole";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of addrole;
//add article category;
    public function addCategory($categoryname){
        $sql = 'INSERT INTO category (name) VALUES(:categoryname)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":categoryname", $categoryname);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: category already exists. unable to addcategory";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of addcategory;;


//add article subcategory;
    public function addNewCategory($categoryname,$categorynote,$parentcategoryid){
        $sql = 'INSERT INTO category (name,note, parentcategoryid) VALUES(:categoryname, :categorynote,:parentcategoryid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":categoryname", $categoryname);
            $stmt -> bindParam(":categorynote", $categorynote);
            $stmt -> bindParam(":parentcategoryid", $parentcategoryid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: subcategory already exists. unable to addsubcategory";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit;
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of add subcategory;;

//add article category;
    public function addFocalArea($categoryname, $note){
        $sql = 'INSERT INTO focalarea (name, note) VALUES(:categoryname, :note)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":categoryname", $categoryname);
            $stmt -> bindParam(":note", $note);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: category already exists. unable to add focal area";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of addcategory;;


//add article category;
    public function addCluster($clustername, $note){
        $sql = 'INSERT INTO cluster (name, note) VALUES(:clustername, :note)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":clustername", $clustername);
            $stmt -> bindParam(":note", $note);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: category already exists. unable to add cluster";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of addcategory;;

//unmake superadmin user;
    public function editCategory($categoryid,$categoryname,$categorynote,$parentcategoryid){
        $sql = 'UPDATE category
          SET name = :categoryname,
          note = :categorynote,
          parentcategoryid = :parentcategoryid
          WHERE id = :categoryid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":categoryname", $categoryname);
            $stmt -> bindParam(":categorynote", $categorynote);
            $stmt -> bindParam(":categoryid", $categoryid);
            $stmt -> bindParam(":parentcategoryid", $parentcategoryid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to edit category";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

//unmake superadmin user;
    public function editFocalArea($focalareaid,$focalareaname,$focalareanote){
        $sql = 'UPDATE focalarea
         SET name = :focalareaname,
          note = :focalareanote
          WHERE id = :focalareaid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":focalareaname", $focalareaname);
            $stmt -> bindParam(":focalareanote", $focalareanote);
            $stmt -> bindParam(":focalareaid", $focalareaid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to redit focal area";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }


//unmake edit cluster;
    public function editCluster($clusterid,$clustername,$clusternote){
        $sql = 'UPDATE cluster
         SET name = :clustername,
          note = :clusternote
          WHERE id = :clusterid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":clustername", $clustername);
            $stmt -> bindParam(":clusternote", $clusternote);
            $stmt -> bindParam(":clusterid", $clusterid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to redit cluster";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

//unmake superadmin user;
    public function unMakeUserSuperAdmin($userid){
        $sql = 'DELETE FROM superadmin WHERE userid = :userid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to remove user as a superadmin user";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of unmake superadmin;

//leave cluster
    public function leaveCluster($userid,$clusterid){
        $sql = 'DELETE FROM clusteruser WHERE (userid = :userid AND clusterid = :clusterid)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":clusterid", $clusterid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to remove user from cluster";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

//unmake productcategory admin;
    public function unMakeUserproductcategoryAdmin($userid){
        $sql = 'DELETE FROM productcategoryadminuser WHERE userid = :userid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to remove user as a superadmin user";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of unmake productcategory admin;
//unblock;
//unmake superadmin user;
    public function unBlockUser($userid){
        $sql = 'DELETE FROM blockeduser WHERE userid = :userid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> execute();
            $rowscount = $stmt->rowCount();
        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to unblock user";
            include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
//end of unblockuser;
//editarticle;
    public function editArticle($articleid, $title, $detail, $dateofpublication,
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
        catch(PBOException $e){
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

//end of editarticle;
//deletearticle;
    public function deleteArticle($articleid){
        $this -> deleteArticleFiles($articleid);
        $sql = 'DELETE FROM article
	   WHERE id = :articleid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":articleid", $articleid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE YOUR ARTICLE';
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
//delete articlefiles;

//delete article files;
    public function deleteArticleFiles($articleid){
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
        $sql = 'DELETE FROM file WHERE articleid = :articleid';
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

}
//end of admin class;
?>