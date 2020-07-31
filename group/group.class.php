<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
class Group{

    protected $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }


    public function getGroup($groupleveltablename,$groupid){

        $group = array();
        $articles = array();

        $sql = '(SELECT id AS groupid, name AS groupname, description AS groupnote,tableid
         FROM '.$groupleveltablename.'
         WHERE id = :groupid)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> bindParam(":groupid", $groupid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

            if($rowscount > 0){
                $group = $stmt -> fetch(PDO::FETCH_ASSOC);

                //get articles;
                //$articles = $this->getArticlesByGrouplevel($groupid,12,0);
                return array("group"=> $group, "articles"=>$group);
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET group';
            $error2 = $e -> getMessage();
            $results = "0";
            $message = $error2.": ".$error;
            echo json_encode(array("results"=>$results, "message"=>$message));
            exit;
        }
    }
//end of GET FOCAL AREA;


//unmake superadmin user;
    public function editGroup($groupleveltablename,$groupid,$groupname,$groupnote){
        $sql = 'UPDATE '.$groupleveltablename.'
         SET name = :groupname,
          description = :groupnote
          WHERE id = :groupid';
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":groupname", $groupname);
            $stmt -> bindParam(":groupnote", $groupnote);
            $stmt -> bindParam(":groupid", $groupid);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: unable to redit group";
            $results = "0";
            $message = $error2.": ".$error;
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


//add article category;
    public function addGroup($groupname, $groupnote, Array $ids){
        if(!empty($ids["grouplevel2id"])){
            //for group third lwvel
            $grouplevel2id = $ids["grouplevel2id"];
            $grouplevel1id = $ids["grouplevel1id"];

             $sql = 'INSERT INTO grouplevel3 (name, description, grouplevel1id, grouplevel2id)
             VALUES(:groupname, :groupnote, '.$grouplevel1id.' , '.$grouplevel2id.' )';

        }elseif(!empty($ids["grouplevel1id"])){
            //for level two grp
            $grouplevel1id = $ids["grouplevel1id"];

            $sql = 'INSERT INTO grouplevel2 (name, description, grouplevel1id)
             VALUES(:groupname, :groupnote, '.$grouplevel1id.' )';
        }else{
            //for lwvel one group
            $sql = 'INSERT INTO grouplevel1 (name, description) VALUES(:groupname, :groupnote)';
        }
        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":groupname", $groupname);
            $stmt -> bindParam(":groupnote", $groupnote);

            $stmt -> execute();
            $rowscount = $stmt->rowCount();

        }
        catch(PDOException $e){
            $error2 =  $e -> getMessage();
            $error = "SQL: category already exists. unable to add cluster";
            $results = "0";
            $message = $error2.": ".$error;
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
//end of addcategory;;

    public function getGroups(){
        $grouplevel1s = $this->getGroupLevel1s();
        $grouplevel2s = $this->getGroupLevel2s();
        $grouplevel3s = $this->getGroupLevel3s();

        return (array("grouplevel1s"=>$grouplevel1s,"grouplevel2s"=>$grouplevel2s,"grouplevel3s"=>$grouplevel3s));
    }

    public function getGroupLevel1s(){
        $sql = '(SELECT id, name,description,tableid FROM grouplevel1 ORDER BY name ASC)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $grouplevel1s = $stmt -> fetchAll();
                return $grouplevel1s;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET grouplevells';
            $error2 = $e -> getMessage();
            $message = $error .": ".$error2;
            echo json_encode(array("results"=>"0", "message"=>$message));
            exit;

        }
    }

    public function getGroupLevel2s(){
        $sql = '(SELECT id, name,description, grouplevel1id,tableid FROM grouplevel2 ORDER BY name ASC)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $grouplevel2s = $stmt -> fetchAll();
                return $grouplevel2s;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET grouplevel2s';
            $error2 = $e -> getMessage();
            $message = $error .": ".$error2;
            echo json_encode(array("results"=>"0", "message"=>$message));
            exit;

        }
    }

    public function getGroupLevel3s(){
        $sql = '(SELECT id, name, description, grouplevel1id, grouplevel2id,tableid FROM grouplevel3 ORDER BY name ASC)';

        try{

            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            if($rowscount > 0){
                $grouplevel3s = $stmt -> fetchAll();
                return $grouplevel3s;
            }else{
                return FALSE;
            }
        }
        catch(PDOException $e){
            $error = 'SQL ERROR UNABLE TO GET grouplevel3s';
            $error2 = $e -> getMessage();
            $message = $error .": ".$error2;
            echo json_encode(array("results"=>"0", "message"=>$message));
            exit;

        }
    }
//end of get categories;


    public function getOneCluster($clusterid){
        $sql = '(SELECT id AS clusterid, name AS clustername FROM cluster WHERE id = :clusterid)';

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
//end of GET FOCAL AREA;

}
?>