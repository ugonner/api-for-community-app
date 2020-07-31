<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/cors.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/inputsanitizer.php';

/*header("Access-Control-Allow-Origin: *");*/
require_once $_SERVER['DOCUMENT_ROOT'].'/api/article/article.class.php';

//view moretakes;
//getprevious takes;
//view previoustakes;
//get article;
//$input = $_GET;
if(isset($input["getcategories"])){
    $article = new article();
    if(!$results = $article->getCategories()){
        $error = "No categories found Or Is Not Sanctioned";
        $message = $error;
        $results = "0";
    }else{
        $message = "categories found";
    }
    echo json_encode(array("results"=>$results,"message" => $message));
    exit;

}

//$input = $_GET;
if(isset($input["gaid"])){
    $aid = $input["gaid"];
    $amtperpage = 15;
    if(isset($input["pgn"])){
        $pgn = $input["pgn"];
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
        $message = $error.": ".$error2;
        $results = "0";
        echo json_encode(array("results"=>$results,"message" => $message));
        exit;

    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $num_of_pages = (empty($no_of_pages)? 1: $no_of_pages);
    $article = new article();
    if(!$results = $article->getarticle($aid,$amtperpage,$pgn)){
        $error = "article Must Have Been Deleted Or Is Not Sanctioned";
        $message = $error;
        $results = "0";
    }else{
        $message = "article found";
    }
    echo json_encode(array("results"=>$results,"message" => $message,"noofpages"=>$num_of_pages));
    exit;
}

//get all article
//get articles by categories;
if(isset($input["getarticles"])){
    $amtperpage = 10;
    if(isset($input["pgn"])){
        $pgn = $input["pgn"];
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
        $message = $error2.": ".$error;
        $results = "0";
        echo json_encode(array("results"=>$results,"message" => $message));
        exit;
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    $output = (!empty($input["output"])? $input["output"]: "");
    $title = "articles posted";
    if($results = $article->getarticles($amtperpage,$pgn)){
        if(!isset($_SESSION)){
            session_start();
        }
        $userid = (empty($_SESSION["userid"])? 1 : $_SESSION["userid"]);
        $article->updateLastArticlesCount($userid);
        $message = $title;

    }else{
        $results = "0";
        $message = "No articles found";
    }
    echo json_encode(array("results"=>$results,"message" => $message, "no_of_pages"=>$no_of_pages));
    exit;

}



//get articles by categories;
//$input = $_GET;
if(isset($input["gabp"])){
    $value = htmlspecialchars($input['value']);
    $property = htmlspecialchars($input['property']);
    $property_alias = (empty($input['property-alias'])? " Posts ": htmlspecialchars($input['property-alias']));
    if(($property == 'dateofbirth') || ($property == 'all') || $property == 'all'){
        $property = 'wq';
        $value = 'user.id > 0';
    }

    $pgn = (empty($input["pgn"])? 0: htmlspecialchars($input["pgn"]));
    $amtperpage = 10;

    $presql = 'SELECT count(*) FROM article INNER JOIN user ON userid = user.id
	   INNER JOIN category ON categoryid = category.id
	   INNER JOIN grouplevel1article ON grouplevel1article.articleid = article.id
	   INNER JOIN grouplevel1 ON grouplevel1.id = grouplevel1article.groupid
	   INNER JOIN grouplevel2article ON grouplevel2article.articleid = article.id
	   INNER JOIN grouplevel2 ON grouplevel2.id = grouplevel2article.groupid
	   INNER JOIN grouplevel3article ON grouplevel3article.articleid = article.id
	   INNER JOIN grouplevel3 ON grouplevel3.id = grouplevel3article.groupid
	   WHERE ';

    if(($property == 'wq') ){
        $sql = $presql.$value;
    }else{
        $sql = $presql.$property.' = '.$value.' GROUP BY article.id';
    }

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
        $message = $error2.": ".$error." SQL=".$sql;
        $results = "0";
        echo json_encode(array("results"=>$results,"message" => $message));
        exit;
    }
    $no_of_pages = ceil($counter[0] / $amtperpage);

    $article = new article();
    //$category = $article->getCategory($cid);
    $output = (!empty($input["output"])? $input["output"]: "");
    $title = "Welcome to ".$property_alias." section";
    if($results = $articles = $article->getarticlesByProperty($property,$value,$amtperpage,$pgn)){
        $message = $title;
        echo json_encode(array("results"=>$results,"message" => $message, "noofpages"=>$no_of_pages));
        exit;
    }else{
        $output = "No More articles In This Category Or It's Not Sanctioned";
        $message = $output;
        $results = "0";
        echo json_encode(array("results"=>$results,"message" => $message));
        exit;
    }
}



?>