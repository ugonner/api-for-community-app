<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";
//pass only admins;
$admin = new admin();

if(!$admin->isLoggedIn()){
    $error = 'login first';
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/login.html.php";
    exit;
}

if(!$admin->isAdmin($_SESSION["userid"])){
    $error = 'You Are Not An Admin, login As Admin first';
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/login.html.php";
    exit;
}
include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";
//get transactions by cartid or status;
//make product public;

//make a productcategory admin;
if(isset($_GET["makeproductpublic"])){
    $pid = $_GET["pid"];
    $sql = "UPDATE product SET public = 'Y' WHERE id = :productid";
    try{
        $db = new Dbconn();
        $stmt = $db->dbcon->prepare($sql);
        $stmt->bindParam(":productid",$pid);
        $stmt->execute();
        $rowscount = $stmt->rowCount();
    }catch (PDOException $e){
        $error = "unable to make product unpublic, if there's a thing like that in english";
        $error2 = $e->getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
        exit;
    }
    if($rowscount>0){
        $output = "Product Made Public ";
        header("Location:/api/product/?gpid=".$pid."&output=".$output);
        exit();
    }else{
        $output = "Product Deleted Not Made Public";
        header("Location:/api/product/?gpid=".$pid."&output=".$output);
        exit();
    }
}

//make a productcategory admin;
if(isset($_GET["makearticlepublic"])){
    $aid = $_GET["aid"];
    $sql = "UPDATE article SET public = 'Y' WHERE id = :articleid";
    try{
        $db = new Dbconn();
        $stmt = $db->dbcon->prepare($sql);
        $stmt->bindParam(":articleid",$aid);
        $stmt->execute();
        $rowscount = $stmt->rowCount();
    }catch (PDOException $e){
        $error = "unable to make article unpublic, if there's a thing like that in english";
        $error2 = $e->getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
        exit;
    }
    if($rowscount>0){$output = "Article Made Public ";
        header("Location:/api/article/?gaid=".$aid."&output=".$output);
        exit();
    }else{
        $output = "Article Deleted Not Made Public";
        header("Location:/api/article/?gaid=".$aid."&output=".$output);
        exit();
    }
}
//end of assign as productcategoryadmin;

//UNMAKE PRODUCT PUBLIC;

//make a productcategory admin;
if(isset($_GET["unmakeproductpublic"])){
    $pid = $_GET["pid"];
    $sql = "UPDATE product SET public = 'N' WHERE id = :productid";
    try{
        $db = new Dbconn();
        $stmt = $db->dbcon->prepare($sql);
        $stmt->bindParam(":productid",$pid);
        $stmt->execute();
        $rowscount = $stmt->rowCount();
    }catch (PDOException $e){
        $error = "unable to make product unpublic, if there's a thing like that in english";
        $error2 = $e->getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
        exit;
    }
    if($rowscount>0){
        $output = "public Made UnPublic ";
        header("Location:/api/product/?gpid=".$pid."&output=".$output);
        exit();
    }else{
        $output = "Public Not Made UNPublic";
        header("Location:/api/product/?gpid=".$pid."&output=".$output);
        exit();
    }
}
//uunmake article publuc;

if(isset($_GET["unmakearticlepublic"])){
    $aid = $_GET["aid"];
    $sql = "UPDATE article SET public = 'N' WHERE id = :articleid";
    try{
        $db = new Dbconn();
        $stmt = $db->dbcon->prepare($sql);
        $stmt->bindParam(":articleid",$aid);
        $stmt->execute();
        $rowscount = $stmt->rowCount();
    }catch (PDOException $e){
        $error = "unable to make article unpublic, if there's a thing like that in english";
        $error2 = $e->getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"].'/api/includes/errors/error.html.php';
        exit;
    }
    if($rowscount>0){
        $output = "Article Made UnPublic ";
        header("Location:/api/article/?gaid=".$aid."&output=".$output);
        exit();
    }else{
        $output = "Article Not Made UNPublic";
        header("Location:/api/article/?gaid=".$aid."&output=".$output);
        exit();
    }
}
//end of assign as productcategoryadmin;



//get users for edit;
if(isset($_POST["gubnem"])){
    $nem = $_POST["nem"];
    $admin = new admin();
    if($users = $admin ->getUsersByNameEmailMobile($nem)){
        $error = "Users returned for the search";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }else{
        $error = "No user matched the search";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}

//search a user for action;
if(isset($_GET["sufa"])){
    $uid = $_GET["uid"];
    $admin = new admin();
    if($user = $admin ->selectUserForAction($uid)){
        $user = $user[0];
        $error = $user["firstname"].", ".$user["surname"]." successfully selected for actions";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }else{
        $error = "User Not Selected";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of add article categoryn;

//make a productcategory admin;
if(isset($_POST["aur"])){
    $uid = $_POST["uid"];
    $rid = $_POST["rid"];
    $rn = $_POST["rolenote"];
    if("" == trim($rn)){
        $error = "No Briefs About The User's Profession/Role, Please Add Add A brief";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
    $admin = new admin();
    if($updateresult = $admin ->assignUserRole($uid,$rid,$rn)){
        $output = "User successfully certified and assigned to the role/profession ".$updateresult;
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Already been assigned to the role/profession";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of assign a role;
//make productcategory admin;
//make a productcategory admin;
if(isset($_GET["muwa"])){
    $uid = $_GET["uid"];
    $wid = $_GET["wid"];
    $admin = new admin();
    if($rslt=$admin ->makeUserproductcategoryAdmin($uid,$wid)){
        $output = "User successfully assigned as eardadmin for the productcategory ".$rslt;
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Already been assigned as a productcategory admin for this productcategory";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of assign as productcategoryadmin;
//make superadmin;

if(isset($_GET["musa"])){
    $uid = $_GET["uid"];
    $admin = new admin();
    if($admin ->makeUserSuperAdmin($uid)){
        $output = "User successfully assigned as Superadmin";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Already been assigned as a super admin";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of assign as superadmin;
//block user;
if(isset($_GET["blockuser"])){
    $uid = $_GET["uid"];
    $admin = new admin();
    if($admin ->blockUser($uid)){
        $output = "User Blocked Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Already been blocked";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of block user;

if(isset($_GET["umusa"])){
    $uid = $_GET["uid"];
    $admin = new admin();
    if($admin ->unMakeUserSuperAdmin($uid)){
        $output = "User successfully remaoved as Superadmin";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Already been removed as a super admin";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of remove as superadmin;
//unmake a productcategoryadmin;
if(isset($_GET["umuwa"])){
    $uid = $_GET["uid"];
    $wid = $_GET["productcategoryid"];
    $admin = new admin();
    if($admin ->unMakeUserproductcategoryAdmin($uid,$wid)){
        $output = "User successfully removed as eardadmin for the productcategory";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Was Not A productcategory admin earlier Or Already been removed as a productcategory admin for this productcategory";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of unassign as productcategoryadmin;
//unblock user;

if(isset($_GET["unblockuser"])){
    $uid = $_GET["uid"];
    $admin = new admin();
    if($admin ->unBlockUser($uid)){
        $output = "User unBlocked Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "User Already been unblocked Or Wasn't Blocked At All";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of assign as productcategoryadmin;
//edit article;
if(isset($_POST["editarticle"])){
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/forms/articleform.html.php";
        exit();
    }
    if((trim($_POST["title"])=="") || (trim($_POST["detail"])=="")){
        $error = "You Cannot Submit Empty Article";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/forms/articleform.html.php";
        exit();
    }
//validate article image file;
    $folder = "/api/img/articles/";
    $uploadfileformname = "aidn";
    if($file= storeFile($uploadfileformname,$folder)){
        $aidn = $file["displayname"];
    }else{
        $aidn = $_POST['aidn'];
    }
    $title = $_POST["title"];
    $detail = $_POST["detail"];
    $aid = $_POST["aid"];
    $dop = date("Ymdhms");
    $uid = $_SESSION["userid"];
    session_write_close();

    $article = new article();
    $admin = new admin();

    if($savearticle = $admin->editArticle($aid,$title,$detail,$dop,$aidn)){
        $filenamearray = array("articlefile1","articlefile2","articlefile3","articlefile4");
        $folder = "/api/img/articlefiles/";
        $article->addArticleFile($filenamearray,$folder,$aidn);
        $output = "Article Posted Successfully";
        $url = "Location: /api/article/index.php?aid=".$aid;
        header($url);
        exit();
    }
}
//delete article;
//delete
if(isset($_GET["deletearticle"])){
    $aid = $_GET["aid"];
    $rqst = "<a href='/api/admin/index.php?confirmdeletearticle&aid=".$aid."'>
    <button class='btn-danger' type='button'> Yes! Delete Article
    </button></a>";
    $qxn = "<h5>Do You Really Want To Proceed With Your Action?</h5>";
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/confirmaction.html.php";
    exit();
}
//confirm delete;
//delete article;
if(isset($_GET["confirmdeletearticle"])){
    $aid = $_GET["aid"];
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }
    session_write_close();
    $admin = new admin();
    if($savetake = $admin->deleteArticle($aid)){
        $output = "You Have Deleted Article Successfully";
        header("Location:/api/article/index.php?aid=".$aid."&output=".$output);
        exit();
    }else{
        $error = "You Are Not The Original Owner Of This Article, So  You Can Not Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}

//add a role;

if(isset($_POST["addrole"])){
    $rolename = $_POST["name"];
    $admin = new admin();
    if($admin ->addRole($rolename)){
        $output = $rolename. " Role/Profession Added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "Role/Prefession Already been Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of assign as productcategoryadmin;
//add article category;
if(isset($_POST["addcategory"])){
    $cn = htmlspecialchars($_POST["name"]);
    $admin = new admin();
    $parent_categoryid = (!empty($_POST["parent_categoryid"])? htmlspecialchars($_POST["parent_categoryid"]): 0);
    $categorynote = (!empty($_POST["categorynote"])? htmlspecialchars($_POST["categorynote"]): "Great Dynamic Article Category");
    if($admin ->addNewCategory($cn,$categorynote,$parent_categoryid)){
        $output = $cn." Category Added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "category Already been Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of add article categoryn;

//add article category;
if(isset($_POST["addusertoclusters"])){
    $userid = htmlspecialchars($_POST["userid"]);
    $admin = new user();

    if($admin ->addUserToClusters($userid)){
        $output = "User added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "user Not Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}

//add article category;
if(isset($_POST["removeuserfromclusters"])){
    $userid = htmlspecialchars($_POST["userid"]);
    $admin = new user();

    if($admin ->removeUserFromClusters($userid)){
        $output = "User added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "user Not Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//add article category;
if(isset($_POST["addfocalarea"])){
    $cn = htmlspecialchars($_POST["name"]);
    $cnote = htmlspecialchars($_POST["note"]);
    $admin = new admin();
    if($admin ->addFocalArea($cn, $cnote)){
        $output = $cn." Focal Area Added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "category Already been Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of add article categoryn;

//add article category;
if(isset($_POST["addcluster"])){
    $cn = htmlspecialchars($_POST["name"]);
    $cnote = htmlspecialchars($_POST["note"]);
    $admin = new admin();
    if($admin ->addCluster($cn, $cnote)){
        $output = $cn." cluster Added Successfully";
        header("Location:/api/admin/admin.html.php?output=".$output);
        exit();
    }else{
        $error = "cluster Already been Added";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
        exit();
    }
}
//end of add article categoryn;

//edit productcategory;
if(isset($_POST["editcategory"])){

    $cid = $_POST["categoryid"];
    $cn = htmlspecialchars($_POST["categoryname"]);
    $cnote = ($_POST["categorynote"] ? htmlspecialchars($_POST["categorynote"]): 'Post Category' );

    $parent_categoryid = (empty($_POST["parent_categoryid"]) ? 0: htmlspecialchars($_POST["oldparent_categoryid"]));

    $admin = new admin();

    if($admin->editCategory($cid,$cn,$cnote,$parent_categoryid)){
        $output = "Category Successfully Edited";
        header("Location: /api/article/index.php?gabc&cid=".$cid."&output=".$output);
        exit;
    }
}

//edit productcategory;
if(isset($_POST["editfocalarea"])){
    $fid = $_POST["focalareaid"];
    $fn = htmlspecialchars($_POST["focalareaname"]);
    $fnote = htmlspecialchars($_POST["focalareanote"]);

    $admin = new admin();

    if($admin->editFocalArea($fid,$fn,$fnote)){
        $output = "Focal Area Successfully Edited";
        header("Location: /api/article/index.php?gfa&faid=".$fid."&output=".$output);
        exit;
    }
}

//edit productcategory;
if(isset($_POST["editcluster"])){
    $fid = $_POST["clusterid"];
    $fn = htmlspecialchars($_POST["clustername"]);
    $fnote = htmlspecialchars($_POST["clusternote"]);

    $admin = new admin();

    if($admin->editCluster($fid,$fn,$fnote)){
        $output = "Cluster Successfully Edited";
        header("Location: /api/cluster/index.php?getcluster&clusterid=".$fid."&output=".$output);
        exit;
    }
}


//edit role;
if(isset($_POST["editrole"])){

    $rid = $_POST["roleid"];
    $value = htmlspecialchars($_POST["value"]);
    $pty = ((!empty($_POST["pty"]))? htmlspecialchars($_POST["pty"]): 'name');
    $admin = new admin();

    if($admin->editRoleProperty($rid,$pty,$value)){
        $output = "Role / Position  Successfully updated";
        header("Location: /api/admin/admin.html.php?output=".$output);
        exit;
    }
}

//registration data validation;
if(isset($_POST['register'])){
    session_start();
    if(($_POST['password'])!== ($_POST['password2'])){
        $error='Sorry Passwords Didn\'t match:
        Re-enter your passwords';
        include $_SERVER['DOCUMENT_ROOT'].'/api/admin/adminregistration.html.php';
        exit();
    }
    //validate email;
    if(!preg_match('/[-!\.,@#\$%\^\&\*\()_\+=\/a-z0-9]+@[-a-z0-9\_\.,]+\.[-a-z0-9\_\.,]+/i'
        , $_POST["email"])){
        $error = 'This Email Is Not Set, Please Put A valid Email Address';
        include $_SERVER['DOCUMENT_ROOT'].'/api/sdmin/adminregistration.html.php';
        exit();
    }else{
        $email = $_POST['email'];
    }
    //validate roleid;
    if(!preg_match('/^[0-9]+$/i', $_POST["roleid"])){
        $error = 'No Professional Specialty Selected, Please Select A Profession For User';
        include $_SERVER['DOCUMENT_ROOT'].'/api/admin/adminregistration.html.php';
        exit();
    }else{
        $roleid = $_POST['roleid'];
    }
    if($roleid != 2){
        $displayname = NULL;
    }else{
        $displayname = NULL;
    }
    //validate rolenote;
    if(trim($_POST["rolenote"])==''){
        $error = 'The Brief On User Is Empty, Please Put A Brief Information';
        include $_SERVER['DOCUMENT_ROOT'].'/api/admin/adminregistration.html.php';
        exit();
    }else{
        $rolenote = $_POST['rolenote'];
    }

    $day = $_POST['day'];
    $month = $_POST['month'];
    if((strlen($_POST['year'])==4) and ($_POST['year']!== '')){
        $year =  $_POST['year'];
    } else { $year = '2019';
    }
    $DOB= $year.'-'.$month.'-'.$day;

    //validate mobile number;
    if(isset($_POST["mobile"]) && (trim($_POST["mobile"])!= "")){
        if(isset($_POST["foreigner"])){
            if(empty($_POST["zip"])){
                $error = 'Zip code is empty, if you reside outside Nigeria Please enter a zipxode
           for your country of residence';
                include $_SERVER['DOCUMENT_ROOT'].'/api/admin/adminregistration.html.php';
                exit();
            }else{
                $mobile = $_POST["zip"].substr($_POST["mobile"],1);
            }
        }else{
            $mobile = "234".substr($_POST["mobile"],1);
        }
    }else{
        $error = 'Mobile Number Is Not Set';
        include $_SERVER['DOCUMENT_ROOT'].'/api/admin/adminregistration.html.php';
        exit();
    }
//validate public for mobile;
    if(isset($_POST["public"]) && ($_POST["public"] == "N")){
        $public = "N";
    }else{
        $public = "Y";
    }
//category is added in the class method;


    $password = encodePassword($_POST["password"]);
    $firstname = $_POST['firstname'];
    $surname = ((empty($_POST['surname']))? null : htmlspecialchars($_POST['surname']));
    $dateofbirth = $DOB;
    $gender = ((empty($_POST['gender']))? "M" : htmlspecialchars($_POST['gender']));
    $about = ((empty($_POST['about']))? "A big fan" : htmlspecialchars($_POST['about']));
    $school = "N/A";
    $dateofregistration = date('Ymd');

    $grouplevel1id = ((empty($_POST['grouplevel1id']))? 1 : htmlspecialchars($_POST['grouplevel1id']));
    $grouplevel2id = ((empty($_POST['grouplevel2id']))? 1 : htmlspecialchars($_POST['grouplevel2id']));
    $grouplevel3id = ((empty($_POST['grouplevel3id']))? 1 : htmlspecialchars($_POST['grouplevel3id']));
    $locationid = ((empty($_POST['locationid']))? 38 : htmlspecialchars($_POST['locationid']));
    $sublocationid = ((empty($_POST['sublocationid']))? 768 : htmlspecialchars($_POST['sublocationid']));

    $cluster_count = (empty($_POST["cluster-count"])? 3 : htmlspecialchars($_POST["cluster-count"]));
    for($i=0; $i<$cluster_count; $i++){
        $postname = "cluster".$i;
        if(isset($_POST[$postname])){
            $cluster_ids[] = $_POST[$postname];
        }
    }
//call to user class;
    $register = new user();
    if($register ->registerProUser($firstname,$surname,$email,$password,$mobile,$gender,
        $dateofbirth,$dateofregistration,$about,$locationid,$sublocationid,$school,$displayname,
        $roleid,$rolenote,$public,$grouplevel1id,$grouplevel2id,$grouplevel3id)){
        $output = "Congrats! ".$firstname." , Have Successfully Registered";


    }else{
        $output = "User Not Registered Try Again";
    }
    $url="Location: /api/admin/adminregistration.html.php?output=".$output;
    header($url);
    exit();
}
//above is the end of the rtgister;

include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.html.php";
exit();
?>