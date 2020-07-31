<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/article.class.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/notification/notification.class.php";

//view moretakes;
//getprevious takes;
//view previoustakes;
//get article;
if(isset($_GET["gaid"])){
    $aid = $_GET["gaid"];
    $amtperpage = 15;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(id) FROM reply WHERE articleid = :articleid';
    $conn = new Dbconn();
    $conn_cursor = $conn ->dbcon;
    try{
        $stmt = $conn_cursor -> prepare($sql);
        $stmt->bindParam(":articleid",$aid);
        $stmt -> execute();
        $counter = $stmt -> fetch();
    }
    catch(PDOException $e){
        $error = "Unable TO Count Comment";
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $no_of_pages = $counter[0] / $amtperpage;

    $article = new article();
    if(!$articles = $article->getarticle($aid,$amtperpage,$pgn)){
        $error = "article Must Have Been Deleted Or Is Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }else{
        if(isset($_GET["notification"])){
            session_start();
            $uid = $_SESSION["userid"];
            session_write_close();
            $nid = $_GET["nid"];
            $notification = new Notification();
            $notification->markNotificationsOnUserPosts($nid,$uid,"commentnotification");
        }
        $title = $articles["article"][0]["title"];
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/article.html.php";
        exit();
    }
}

//get all article
//get articles by categories;
if(isset($_GET["getallarticles"])){
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(id) FROM article';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    $output = (!empty($_GET["output"])? $_GET["output"]: "");
    $title = "articles posted";
    if($articles = $article->getarticles($amtperpage,$pgn)){
        if(!isset($_SESSION)){
            session_start();
        }
        $article->updateLastArticlesCount($_SESSION["userid"]);
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit();
    }else{
        $output = "No More articles Yet psoted";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit();
    }
}


//get articles by categories;
if(isset($_GET["gabc"])){
    $cid = $_GET["cid"];
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(id) FROM article WHERE categoryid = :cid';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":cid",$cid);

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    $category = $article->getCategory($cid);
    $output = (!empty($_GET["output"])? $_GET["output"]: "");
    $title = "Welcome to ".$category["categoryname"]." section";
    if($articles = $article->getarticlesByCategory($cid,$amtperpage,$pgn)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit();
    }else{
        $output = "No More articles In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit();
    }
}


//get articles by categories;
if(isset($_GET["gfa"])){
    $faid = $_GET["faid"];

    $article = new article();
    if($focalarea = $article->getFocalArea($faid)){
        $title = "Welcome to ".$focalarea["focalarea"]["focalareaname"]." section";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/focalarea/focalarea.html.php";
        exit();
    }else{
        $output = "No More activitiss In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/focalarea/focalarea.html.php";
        exit();
    }
}
//get more or next page;

//get useractedarticles;
if(isset($_GET["guaa"])){
    $notificationtypeid = $_GET["nottypid"];
    session_start();
    $userid = $_SESSION["userid"];
    $amtperpage = 3;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(id) FROM notification WHERE notificationtypeid = :notificationtypeid AND userid = :userid';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$userid);
        $stmt -> bindParam(":notificationtypeid",$notificationtypeid);

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new Notification();
    if($articles = $article->getUserNotificationPostsByType($userid,$notificationtypeid,$amtperpage,$pgn)){
        $title = "Articles:  You Have A ".$articles[0]["actionname"]." On The Article(s) Below";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit();
    }else{
        $output = "Sorry, You Are Not Following Any Article, Or The Articles Have Been Proscribed";
        header("Location: /api/user/?guid=".$userid."&output=".$output);
        exit();
    }
}

//get more or next page;


//get articles by categories;
//getprevious page;

//get articles by categories;

//get to blog;
if(isset($_GET["visitblog"])){
    $article = new article();
    if($articles = $article->getarticles()){
        $title = "Health Care System, News, Strikes, Latest Breakthrough In HealthCars in Nigeria";

        if(count($articles)>50){
            $mores = "<a href='/api/article/index.php?gma&n=".$articles[49][0]."'>
            <button class='btn-success'>Next Page</button></a>";
        }
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/blog.html.php";
        exit();
    }else{
        $error = "No More articles In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}


//GET ALL ARTICLSE COMMENTED;
if(isset($_GET["gca"])){

    session_start();
    $uid = $_SESSION["userid"];
    session_write_close();
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $sql = 'SELECT count(*) FROM reply INNER JOIN article ON articleid = article.id WHERE reply.userid = :userid AND replylevel = 1';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":userid",$uid);

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    if($articles = $article->getCommentedarticles($uid,$amtperpage,$pgn)){
        $title = "articles You Commented On";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/userarticles.html.php";
        exit();
    }else{
        $error = "No More articles In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/userarticles.html.php";
        exit();
    }
}
//GET USER ARTICLE;

if(isset($_GET["getuserarticles"])){
    $uid = $_GET["uid"];
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $amtperpage = 10;
    $sql = 'SELECT count(id) FROM article WHERE userid = :userid';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt->bindParam(":userid",$uid);
        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count the articles";
        $error2 = $e -> getMessage();
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }

    $no_of_pages = ceil($counter[0] / $amtperpage);

    $user = new article();
    if($articles = $user->getUserArticles($uid,$amtperpage,$pgn)){
        $title = $articles[0]["firstname"]."'s Posts";
        include_once $_SERVER['DOCUMENT_ROOT']."/api/article/userarticles.html.php";
        exit();
    }else{
        $output = "This Person Probably Has No articlee To His Name OR It  Has Been deleted";
        include_once $_SERVER['DOCUMENT_ROOT']."/api/article/userarticles.html.php";
        exit();
    }
}


//get latest article;
//GET ALL ARTICLSE COMMENTED;
if(isset($_GET["getarticles"])){

    session_start();
    $uid = $_SESSION["userid"];
    session_write_close();
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $sql = 'SELECT count(*) FROM article';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);;

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }

    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    if($articles = $article->getarticles($amtperpage,$pgn)){
        $title = "Latest Posts";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit();
    }else{
        $error = "No More articles In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}

//get take ;
if(isset($_GET["reply"])){
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $takeid = $_GET["takeid"];

    $sql = 'SELECT count(id) FROM reply WHERE commentid = :takeid';
    $conn = new Dbconn();
    $conn_cursor = $conn ->dbcon;
    try{
        $stmt = $conn_cursor -> prepare($sql);
        $stmt ->bindParam(":takeid",$takeid);
        $stmt -> execute();
        $counter = $stmt -> fetch();
    }
    catch(PDOException $e){
        $error = "Unable TO Count Takes";
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    if($takes = $article->getTake($takeid,$amtperpage,$pgn)){
        if(isset($_GET["notification"])){
            session_start();
            $uid = $_SESSION["userid"];
            session_write_close();
            $nid = $_GET["nid"];
            $notification = new Notification();
            $notification->markNotificationsOnUserPosts($nid,$uid,"commentnotification");
        }
        $title = "";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/take.html.php";
        exit();
    }else{
        $error = "No More articles In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}

//get post folloewers;

//get take ;
if(isset($_GET["postfollowers"])){
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }
    $nottypid = $_GET["nottypid"];
    $pid = $_GET["pid"];

    //check table uset acted on;
    if($nottypid == 4){
        $tableactedon = "notification";
    }elseif($nottypid <= 7){
        $tableactedon = "commentnotification";
    }else{
        $error = "INVALID ACTION: GET OFF NERD";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit;
    }


    $sql = 'SELECT count(id) FROM '.$tableactedon.' WHERE postid = :postid AND notificationtypeid = :nottypid';
    $conn = new Dbconn();
    $conn_cursor = $conn ->dbcon;
    try{
        $stmt = $conn_cursor -> prepare($sql);
        $stmt ->bindParam(":postid",$pid);
        $stmt ->bindParam(":nottypid",$nottypid);

        $stmt -> execute();
        $counter = $stmt -> fetch();
    }
    catch(PDOException $e){
        $error = $e -> getMessage()." Unable TO Count Actions users";
        $error2 = $e -> getMessage();
        include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit();
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $notification = new Notification();
    if($users = $notification->getUsersOnPostByType($pid,$nottypid,$amtperpage,$pgn)){
        $small = "1";
        $title = "Followers Of This Post";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/users.html.php";
        exit();
    }else{
        $error = "No Persona  Yet";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}

//end of get post followers;

//getprevious page;
//GET ALL ARTICLSE COMMENTED;
//getprevious page;

//get articles by categories;

//get categories;
if(isset($_GET["getcategories"])){
    $article = new article();
    $categories = $article ->getCategories();
    $options = "<option value=''>Please Select</option> ";
    for($i = 0; $i < count($categories); $i++){
        $option = " "."<option value='".$categories[$i][0]."'>".$categories[$i][1]."</option>";
        $options .= $option;
    }
    echo($options);
    exit();
}

$user = new user();
if(!$user->isLoggedIn()){
    $error = "Please Login With Correct Email / Password Pair";
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/user/forms/loginform.html.php";
    exit();
}

//delete file;
if(isset($_POST["deletefile"])){
    $aid = $_POST["aid"];

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&error=".$error);
        exit();
    }
    //check if user is owner of post or an admin;
    $uid = $_SESSION["userid"];
    $admin = new admin();
    if(!($uid == $_POST["uid"] OR $admin->isAdmin($uid))){
        $error = 'Please You Are Not The Owner Of This Post Nor An Admin';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
    $fid = $_POST["fid"];
    $fn = $_POST["fn"];
    session_write_close();
    $article = new article();
    if($deleteFile = $article->deleteFile($fid,$fn,$uid)){
        $output = "You Have Deleted Your File Successfully";
        header("Location:/api/article/index.php?gaid=".$aid."&output=".$output);
        exit();
    }else{
        $error = "You Are Not The Original Owner Of This article, So  You Can Not Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}

//add a5rticle;
if(isset($_POST["addarticle"])){
    session_start();
    if(!isset($_SESSION["userid"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/user/index.php");
        exit();
    }
    $uid = $_SESSION["userid"];

    $admin = new admin();
    if($admin->isBlocked($uid)){
        $error = 'You Have Been Blocked And Can NOT Post articles For NOW';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
    if(!isset($_POST["cid"])){
        $error = "You Must Post article Under A Particular Category";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
    $cid = $_POST["cid"];

    $isAdmin = $admin->isAdmin($uid);

    if($isAdmin){
        $title = $_POST["title"];
        $detail = $_POST["detail"];
    }else{
        $title = htmlspecialchars($_POST["title"]);
        $detail = ($_POST["detail"]);
    }
    if(preg_match('/^[12]$/', $cid)){
            if(!$isAdmin){
                $error = "Only Admins Can Post In This Category Or You Might Have Been In The Wrong
              Category";
                include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
                exit;
            }


    }

    if((empty($_POST["title"]) || empty($_POST["detail"]))){
        $error = "You Cannot Submit Empty article";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articleform.html.php";
        exit();
    }
//validate article image file;
    $folder = "/api/img/articles/";
    $uploadfileformname = "aidn";
    $filetitle = "Article Image Title";

    if($file= storeImageFile($uploadfileformname,$folder,$filetitle)){
        $aidn = $file["displayname"];
        $aif = $file["filename"];
    }else{
        $aidn = NULL;
        $aif = NULL;
    }


    $public = "N";
    $dop = date("YmdHis");
    session_write_close();
    //assign focalarea;
    $faid = (!empty($_POST['faid'])? htmlspecialchars($_POST['faid']): null );
    $clusterid = (!empty($_POST['clusterid'])? htmlspecialchars($_POST['clusterid']): null );

    $article = new article();
    if($savearticle = $article->addarticle($title,$detail,$aif ,$aidn,$dop,$uid,$cid,$public,$faid,$clusterid)){
        $output = "article Posted Successfully";
        $url = "Location: /api/article/index.php?gabc&pgn=0&cid=".$cid;
        header($url);
        exit();
    }
}

//add take;
if(isset($_POST["addtake"])){
    $aid = $_POST["aid"];

    $folder = "/api/img/takes/";
    $uploadfileformname = "cidn";
    if($file= storeImageFile($uploadfileformname,$folder,$articlefilecaption)){
        $aidn = $file["displayname"];
    }else{
        $aidn = NULL;
    }
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    $admin = new admin();
    if($admin->isBlocked($uid)){
        $error = 'You Have Been Blocked And Can NOT Post articles For NOW';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }

    if((trim($_POST["detail"])=="")){
        $error = "You Cannot Submit Empty article";
        header("Location:/api/article/index.php?gaid=".$aid."&output=".$error);
        exit();
    }

    $detail = htmlspecialchars($_POST["detail"]);
    $RL = $_POST["RL"];

    // coincedentally replylevel corresponds to notificationtypeid so;
    $nottypid = $_POST["RL"];

    $dop = date("YmdHis");
    $postownerid = $_POST["POid"];

    if(($RL == 1)){
        $commentid = NULL;
    }elseif($RL <=3){
        $commentid = htmlspecialchars($_POST["takeid"]);
    }else{
        $error = "Bad Operation! Get OFF, Nerd";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }

        $article = new article();
        if($savetake = $article->addComment($detail,$dop,$aidn,$aid,$commentid,$uid,$RL,$nottypid,$postownerid)){
            if(isset($_POST["artidreply"])){
                $pgn = $_POST["pgn"];
                $takelevel--;
                $output = "Your Take Has Posted Successfully";
                header("Location:/api/article/index.php?reply&takeid=".$commentid."&RL=".$takelevel."&pgn=".$pgn."&output=".$output);
                exit();
            }else{
                $output = "Your Take Has Posted Successfully";
                header("Location:/api/article/index.php?gaid=".$aid."&pgn=".$pgn."&output=".$output);
                exit();
            }
        }

}

//add action;
if(isset($_GET["addaction"])){
    $pid = $_GET["pid"];

    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    //parameters for increment value;
    $property = $_GET["artpty"];

//parameters for notification;
    $notificationtypeid = $_GET["nottypid"];
    $postownerid = $_GET["POid"];
    $dop = date("YmdHis");

    if(($notificationtypeid  == 4)){
        $incrementtable = "article";
        $notificationtable = "notification";
    }else{
        $incrementtable = "reply";
        $notificationtable = "commentnotification";
    }

    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    session_write_close();
    $notification = new Notification();
    $nooffollow = $notification->addNotification($notificationtable,$pid,$postownerid,$uid,$notificationtypeid,$dop);

    $article = new article();
    if($newptyvalue = $article->increaseNoOfProperty($incrementtable,$pid,$property)){
        if(isset($_GET["artidreply"])){
            $takeid = $_GET["takeid"];
            $output = "you are now following this comment";
            header("Location:/api/article/?reply&takeid=".$takeid."&pgn=".$pgn);
            exit;
        }else{
            if(isset($_GET["aid"])){
                $aid = $_GET["aid"];
            }
            $output = "you are now following this post";
            header("Location:/api/article/?gaid=".$aid."&pgn=".$pgn."&output=".$output);
            exit;
        }
    }
}

//add a5rticle
//follow take;

if(isset($_POST["editarticle"])){
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/forms/articleform.html.php";
        exit();
    }
    if((trim($_POST["title"])=="") || (trim($_POST["detail"])=="")){
        $error = "You Cannot Submit Empty article without Title Or Detail ";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/forms/articleform.html.php";
        exit();
    }
//validate article image file;
    if(isset($_POST["articlefilecaption"])){
        $articlefilecaption = htmlspecialchars($_POST["articlefilecaption"]);
    }else{
        $articlefilecaption = "Article's Picture";
    }
    $folder = "/api/img/articles/";
    $uploadfileformname = "aidn";
    if($file= storeImageFile($uploadfileformname,$folder,$articlefilecaption)){
        $aidn = $file["displayname"];
    }else{
        $aidn = $_POST['artfile'];
    }

    $aid = $_POST["aid"];
    $dop = date("YmdHis");

    //check if user is owner of post or an admin;
    $uid = $_SESSION["userid"];

    $admin = new admin();
    $isAdmin = $admin->isAdmin($uid);
    if($isAdmin){
        $title = $_POST["title"];
        $detail = $_POST["detail"];
    }else{
        $title = htmlspecialchars($_POST["title"]);
        $detail = htmlspecialchars($_POST["detail"]);
    }
    if(!($uid == $_POST["uid"] OR $isAdmin)){
        $error = 'Please You Are Not The Owner Of This Post Nor An Admin';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
    session_write_close();

    $article = new article();
    if($savearticle = $article->editarticle($aid,$uid,$title,$detail,$dop,$aidn)){
        $filenamearray = array("articlefile1","articlefile2","articlefile3","articlefile4");
        if(trim($_POST["articlefile1caption"]) == ''){
            $articlefile1caption = ' ';
        }else{
            $articlefile1caption = htmlspecialchars($_POST["articlefile1caption"]);
        }
        if(trim($_POST["articlefile2caption"]) == ''){
            $articlefile2caption = ' ';
        }else{
            $articlefile2caption = htmlspecialchars($_POST["articlefile2caption"]);
        }
        if(trim($_POST["articlefile3caption"]) == ''){
            $articlefile3caption = ' ';
        }else{
            $articlefile3caption = htmlspecialchars($_POST["articlefile3caption"]);
        }

        if(trim($_POST["articlefile4caption"]) == ''){
            $articlefile4caption = ' ';
        }else{
            $articlefile4caption = htmlspecialchars($_POST["articlefile4caption"]);
        }

        $filetitlearray = array($articlefile1caption,$articlefile2caption,$articlefile3caption,$articlefile4caption);
        $folder = "/api/img/articlefiles/";
        $article->addarticleFile($filenamearray,$folder,$filetitlearray,$aid,$uid);
        $output = "article Edited Successfully";
        header("Location:/api/article/index.php?gaid=".$aid."&output=".$output);
        exit();
    }
}
//edit take;

if(isset($_POST["edittake"])){
    $aid = $_POST["aid"];
    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }

    if((trim($_POST["detail"])=="")){
        $error = "You Cannot Submit Empty Comment";
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }
    $takelevel = $_POST["RL"];

    $detail = $_POST["detail"];
    $takeid = $_POST["takeid"];
    $tid = $_POST["tid"];
    $dop = date("YmdHis");
    $uid = $_SESSION["userid"];
    session_write_close();

//validate article image file;
    $articlefilecaption = "Comment's Picture";

    $folder = "/api/img/takes/";
    $uploadfileformname = "cidn";
    if($file= storeImageFile($uploadfileformname,$folder,$articlefilecaption)){
        $aidn = $file["displayname"];
    }else{
        $aidn = $_POST['commentfile'];
    }
    $article = new article();
        if($savetake = $article->editTake($tid,$uid,$detail,$dop,$aidn)){
            if(isset($_POST["artidreply"])){
                $takelevel--;
                $output = "You Have Edited Take Successfully";
                $pgn = $_POST["pgn"];
                header("Location:/api/article/index.php?reply&RL=".$takelevel."&takeid=".$takeid."&pgn=".$pgn."&output=".$output);
                exit();
            }else{
                $pgn = $_POST["pgn"] OR 0;
                $output = "You Have Edited Take Successfully";
                header("Location:/api/article/index.php?gaid=".$aid."&pgn=".$pgn."&output=".$output);
                exit();
            }
    }

}
//delete take
if(isset($_GET["deletearticle"])){
    $aid = $_GET["aid"];
    $rqst = "<a href='/api/article/index.php?confirmdeletearticle&aid=".$aid."&uid=".$_GET["uid"]."'>
    <button class='btn-danger' type='button'> Yes! Delete article
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

    //check if user is owner of post or an admin;
    $uid = $_SESSION["userid"];
    $admin = new admin();
    if((!$uid == $_GET["uid"]) OR !$admin->isAdmin($uid)){
        $error = 'Please You Are Not The Owner Of This Post Nor An Admin';
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
    session_write_close();
    $article = new article();
    if($savetake = $article->deletearticle($aid,$uid)){
        $output = "You Have Deleted Your article Successfully";
        header("Location:/api/article/index.php?aid=".$aid."&output=".$output);
        exit();
    }else{
        $error = "You Are Not The Original Owner Of This article, So  You Can Not Delete It";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
        exit();
    }
}
//delete take
if(isset($_GET["deletetake"])){
    $aid = $_GET["aid"];
    $tid = $_GET["tid"];
    $takeid = $_GET["takeid"];
    $takelevel = $_GET["RL"];
    session_write_close();


    if(isset($_GET["artidreply"])){
        $pgn = $_GET["pgn"];

        $rqst = "<a href='/api/article/index.php?confirmdeletetake&artidreply&aid=".$aid."&RL=".$takelevel."&tid=".$tid."&takeid=".$takeid."&artidreply&pgn=".$pgn."'>
    <button class='btn-danger' type='button'> Yes! Complete Action: Delete
    </button></a>";
        $qxn = "<h5>Do You Really Want To Proceed With Your Action?</h5>";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/confirmaction.html.php";
        exit();
    }else{
        $rqst = "<a href='/api/article/index.php?confirmdeletetake&aid=".$aid."&RL=".$takelevel."&tid=".$tid."&takeid=".$takeid."'>
    <button class='btn-danger' type='button'> Yes! Comlete Action: Delete
    </button></a>";
        $qxn = "<h5>Do You Really Want To Proceed With Your Action?</h5>";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/confirmaction.html.php";
        exit();
    }

}
//confirm delete;
//delete take
if(isset($_GET["confirmdeletetake"])){
    $aid = $_GET["aid"];
    $tid = $_GET["tid"];
    $decrementtableid = $_GET["takeid"];

    session_start();
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }
    $takelevel = $_GET["RL"];
    $RL = $_GET["RL"];

    $uid = $_SESSION["userid"];

    session_write_close();
    $article = new article();
    if($deletetake = $article->deleteTake($tid,$uid,$RL,$decrementtableid)){
        if(isset($_GET["artidreply"])){
            $output = "You Have Deleted Take Successfully";
            $pgn = $_GET["pgn"];
            header("Location:/api/article/index.php?reply&takeid=".$decrementtableid."&pgn=".$pgn."&output=".$output);
            exit();
        }else{
            $output = "You Have Deleted Take Successfully";
            header("Location:/api/article/index.php?gaid=".$aid."&pgn=".$pgn."&output=".$output);
            exit();
        }
    }else{
            $error = "You Are Not The Original Owner Of This article, So  You Can Not Delete It";
            include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
            exit();
    }

}
//delete action on post;
//delete action;

if(isset($_GET["deleteaction"])){
    $pid = $_GET["pid"];
    if(isset($_GET["pgn"])){
        $pgn = 0;
    }else{
        $pgn = $_GET["pgn"];
    }
    //parameters for increment value;

    $property = $_GET["artpty"];

//parameters for notification;
    $notificationtypeid = $_GET["nottypid"];

    if(($notificationtypeid  == 4)){
        $incrementtable = "article";
        $notificationtable = "notification";
    }else{
        $incrementtable = "reply";
        $notificationtable = "commentnotification";
    }
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION["userdata"])){
        $error = 'Please Login First With Correct Email And Password Pair';
        header("Location:/api/article/index.php?aid=".$aid."&output=".$error);
        exit();
    }
    $uid = $_SESSION["userid"];

    session_write_close();
    $notification = new Notification();
    $nooffollow = $notification->deleteNotification($notificationtable,$pid,$uid,$notificationtypeid);

    $article = new article();
    if($newptyvalue = $article->decreaseNoOfProperty($incrementtable,$pid,$property)){
        if(isset($_GET["artidreply"])){
            $takeid = $_GET["takeid"];
            $output = "you Have Unfollowed this post";
            header("Location:/api/article/?reply&takeid=".$takeid."&pgn=".$pgn);
            exit;
        }else{
            if(isset($_GET["aid"])){
                $aid = $_GET["aid"];
            }
            $output = "you have now Unfollowed this post";
            header("Location:/api/article/?gaid=".$aid."&pgn=".$pgn."&output=".$output);
            exit;
        }
    }
}
//end deleste attion;
?>