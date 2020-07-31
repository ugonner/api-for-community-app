<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
class Cluster{

    protected $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }


    public function getClusters(){
        $sql = '(SELECT id AS clusterid, cluster.name AS clustername, cluster.note AS clusternote  FROM cluster ORDER BY name ASC)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $clusters = $stmt -> fetchAll();
                return $clusters;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET clusters';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of get categories;


    public function getOneCluster($clusterid){
        $sql = '(SELECT id AS clusterid, name AS clustername,cluster.note AS clusternote  FROM cluster WHERE id = :clusterid)';

        try{

            $stmt = $this -> db -> prepare($sql);
            $stmt->bindParam(":clusterid", $clusterid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $cluster = $stmt -> fetchAll();
                return $cluster;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET cluster';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }
//end of get categories;

    public function getCluster($clusterid){
        require_once $_SERVER['DOCUMENT_ROOT']. '/api/article/article.class.php';

        $cluster = array();
        $articles = array();

        $sql = '(SELECT cluster.id AS clusterid,cluster.name AS clustername,
       cluster.note AS clusternote FROM cluster
       WHERE cluster.id = :clusterid)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":clusterid", $clusterid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $cluster = $stmt -> fetch(PDO::FETCH_ASSOC);

                //get articles;
                $article = new article();
                $articles = $article->getarticlesByProperty("clusterid",$clusterid,24,0);
                return array("cluster"=> $cluster, "articles"=>$articles);
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET cluster';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();

        }
    }


    public function getUserClusters($userid){
        $sql = '(SELECT cluster.id AS clusterid, cluster.name AS clustername
          FROM cluster INNER JOIN clusteruser
          INNER JOIN user ON clusteruser.userid = user.id
          WHERE user.socialid = :userid OR userid = :userid2
          GROUP BY cluster.id)';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":userid", $userid);
            $stmt -> bindParam(":userid2", $userid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();
            $clusters = $stmt -> fetchAll();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: No check for user is a productcategory admin";
            $results = "0";
            $message = $error.": ".$error2;
            echo json_encode(array("results"=>$results, "message"=>$message));
            exit;
        }
        if($rowscount > 0){
            return $clusters;
        }
        else{
            return FALSE;
        }
    }

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

//end of GET FOCAL AREA;

    public function addUserToClusters($userid){
        //add product category;
        if(!empty($_POST["cluster-count"])){
            $cluster_count = $_POST["cluster-count"];
            $value_str = '';
            for($i=0; $i<$cluster_count; $i++){
                $cluster_postname = "cluster".$i;
                if(!empty($_POST[$cluster_postname])){
                    $c = htmlspecialchars($_POST[$cluster_postname]);
                    $value_str .= "(".$userid.",".$c."),";
                }
            }
            if($value_str == ''){
                $value_str = "(".$userid.", 1),";
            }
            $strlen = (strlen($value_str))-1;
            $value_str = substr($value_str,0,$strlen);

            $clustersql = "INSERT INTO clusteruser (userid , clusterid)
                        VALUES".$value_str;


            try{
                $db = $this -> db;
                $stmt =  $db-> prepare($clustersql);
                $stmt -> execute();
                return true;
            }
            catch(PDOException $e){
                $error = $e -> getMessage().' '.$clustersql.' '.'unable to associate to a cluster';
                $error2 = $e -> getMessage();
                $results = "0";
                $message = $error.": ".$error2;
                echo json_encode(array("results"=>$results, "message"=>$message));
                exit;
            }
        }

        return false;
    }



    public function removeUserFromClusters($userid){
        //add product category;
        if(!empty($_POST["cluster-count"])){
            $cluster_count = $_POST["cluster-count"];
            $value_str = '';
            for($i=0; $i<$cluster_count; $i++){
                $cluster_postname = "cluster".$i;
                if(!empty($_POST[$cluster_postname])){
                    $c = htmlspecialchars($_POST[$cluster_postname]);
                    $this->leaveCluster($userid,$c);
                }
            }
            return true;
        }

        return false;
    }


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
            $results = "0";
            $message = $error.": ".$error2;
            echo json_encode(array("results"=>$results, "message"=>$message));
            exit;
        }
        if($rowscount > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }


}
?>