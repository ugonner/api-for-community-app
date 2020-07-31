<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/cors.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/inputsanitizer.php';

require_once $_SERVER["DOCUMENT_ROOT"]."/api/cluster/cluster.class.php";


//add article category;
if(isset($_POST["addusertoclusters"])){
    $userid = htmlspecialchars($_POST["userid"]);
    $admin = new Cluster();

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
    $admin = new Cluster();

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
if(isset($input["getuserclusters"])){
    $userid = htmlspecialchars($input["userid"]);
    $cluster = new Cluster();

    if($results=$cluster->getUserClusters($userid)){
        $output = "User packages got Successfully";
        $message = $output;
    }else{
        $results = "0";
        $message = "failed to get packages";
    }
    echo json_encode(array("results"=>$results, "message"=> $message));
    exit();
}

//get articles by categories;
if(isset($input["getclusters"])){

    $cluster = new Cluster();
    if($results = $cluster = $cluster->getClusters()){
        //$title = "Welcome ";
        $output = "packages got Successfully";
        $message = $output;
    }else{
        $results = "0";
        $message = "failed to get package";
    }
    echo json_encode(array("results"=>$results, "message"=> $message));
    exit();
}
//get more or next page;

//get articles by categories;
if(isset($input["getcluster"])){
    $cid = $input["clusterid"];

    $cluster = new Cluster();
    if($results = $cluster = $cluster->getCluster($cid)){
        //$title = "Welcome to ".$cluster["cluster"]["clustername"]." section";
        $output = "User packages got Successfully";
        $message = $output;
    }else{
        $results = "0";
        $message = "failed to get package";
    }
    echo json_encode(array("results"=>$results, "message"=> $message));
    exit();
}
//get more or next page;


//get articles by clusters;
if(isset($input["gabcl"])){
    $clusterid = $input["clid"];
    $amtperpage = 10;
    if(isset($input["pgn"])){
        $pgn = $input["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(id) FROM article WHERE clusterid = :clid';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":clid",$clusterid);

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        $results = "0";
        $message = $error2.": ".$error;
        echo (json_encode(array("results"=>$results, "message"=>$message)));
        exit;
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $cluster = new Cluster();
    if($results = $cluster = $cluster->getOneCluster($clusterid)){
        $output = (!empty($input["output"])? $input["output"]: "");
        $article = new article();
        $title = " ".$results["clustername"]." Posts";
        $message = $title;
        if($articles = $article->getarticlesByProperty("cluster.id",$clusterid,$amtperpage,$pgn)){
            $message = "Package got, No Notifications Yet ";
        }
        echo json_encode(array("results"=>$results, "message"=>$message, "articles"=>$articles, "no_of_pages"=>$no_of_pages));
        exit;
    }else{
        $message = " ".$results["clustername"]." Posts";
        $results = "0";
        echo json_encode(array("results"=>$results, "message"=>$message));
        exit;
    }
}


//get articles by clusters;
if(isset($_GET["gabcl"])){
    $clusterid = $_GET["clid"];
    $amtperpage = 10;
    if(isset($_GET["pgn"])){
        $pgn = $_GET["pgn"];
    }else{
        $pgn = 0;
    }

    $sql = 'SELECT count(id) FROM article WHERE clusterid = :clid';

    $db = new Dbconn();
    $dbh = $db->dbcon;
    try{
        $stmt = $dbh -> prepare($sql);
        $stmt -> bindParam(":clid",$clusterid);

        $stmt -> execute();
        $counter = $stmt -> fetch();

    }
    catch(PDOException $e){
        $error = "Unable TO Count article";
        $error2 = $e -> getMessage();
        include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
        exit;
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $cluster = new Cluster();
    $cluster = $cluster->getOneCluster($clusterid);
    $output = (!empty($_GET["output"])? $_GET["output"]: "");
    $article = new article();
    $title = " ".$cluster["clustername"]." Posts";
    if($articles = $article->getarticlesByProperty("clusterid",$clusterid,$amtperpage,$pgn)){
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit;
    }else{
        $output = "No More articles In This Category Or It's Not Sanctioned";
        include_once $_SERVER["DOCUMENT_ROOT"]."/api/article/articles.html.php";
        exit;
    }
}

$input = $_GET;
//get articles by categories;
if(isset($input["getcluster"])){
    $cid = $input["clusterid"];

    $cluster = new Cluster();
    if($cluster = $cluster->getCluster($cid)){
        //$title = "Welcome to ".$cluster["cluster"]["clustername"]." section";
        $output = "User packages got Successfully";
        $message = $output;
    }else{
        $results = "0";
        $message = "failed to get package";
    }
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/cluster/cluster.html.php";
    exit();
}
//get more or next page;

?>