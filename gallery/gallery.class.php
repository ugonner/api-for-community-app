<?php<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/api/includes/db/connect2.php';
class Gallery{

    protected $db;

    public function __construct(){
        $dbh = new Dbconn();
        $this -> db = $dbh->dbcon;
    }


    //get gallery files
    public function getGalleryFiles($amtperpage, $pgn){
        if($pgn == 0){
            $limit = $amtperpage;
            $offset = 0;
        }else{
            $limit = $amtperpage;
            $offset = $pgn * $amtperpage;
        }


        $sql = '(SELECT galleryfile.id as galleryfileid, galleryfile.filename,
                galleryfile.displayname, galleryfile.title, user.firstname,user.profilepic,
                galleryfile.dateofpublication, galleryfile.type
                FROM galleryfile INNER JOIN user ON galleryfile.userid = user.id
                ORDER BY galleryfile.id DESC LIMIT '.$offset.','.$limit.' )';

        try{
            $dbh = $this -> db;
            $stmt = $dbh -> prepare($sql);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();
            $galleryfiles = $stmt -> fetchAll();


        }
        catch(PDOException $e){
            $error = ' no galleryfiles found';
            $error2 = $e -> getMessage();
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        if($rowscount > 0){
            return $galleryfiles;
        }
        return false;
    }

    //delete an articleFILE;
    public function deleteFile($fileid,$filename,$userid){
        //delete file from memory.
        if(file_exists($filename)){
            unlink($filename);
            $error = 'PROBLEM DELETING FILE';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }

        //delete from database;
        $sql = 'DELETE FROM galleryfile
	   WHERE id = :fileid';

        try{
            $stmt = $this -> db -> prepare($sql);
            $stmt -> bindParam(":fileid", $fileid);

            $stmt -> execute();
            $rowscount = $stmt -> rowCount();

        }
        catch(PDOException $e){
            $error2 = $e -> getMessage();
            $error = 'UNABLE TO DELETE YOUR galleryFILE';
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


//add article files article;
    public function addGalleryFile($galleryfilesarray,$folder,$filetitlesarray,$dateofpublication,$userid){

        require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/mediafilehandler.php";
        //storefile and gather file details in an array code;
        for($i=0; $i<count($galleryfilesarray); $i++){
            if($row = storeFile($galleryfilesarray[$i], $folder,$filetitlesarray[$i])){
                $imgs[]= $row;
            }
        }
        // make an sql value string of each file's deatail;
        if(!empty($imgs)){
            for($i=0; $i<count($imgs); $i++){
                $value='( "'.$imgs[$i]["title"].'","'.$imgs[$i]["filename"].'",
"'.$imgs[$i]["displayname"].'","'.$imgs[$i]["type"].'","'.$dateofpublication.'","'.$userid.'")';

                $filevalues[] = $value;
            }
            //convert all to string;
            $filevalues=implode(",", $filevalues);

            $sql = 'INSERT INTO galleryfile
        (title,filename,displayname,type,dateofpublication,userid)
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



}