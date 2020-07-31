<?php
//validate and store filss jpg,png,gif,pdf,doc,mp3,mp4,3gp;
function storeFile($file, $folder,$filetitle){

    if(isset($_FILES[$file])
        && is_uploaded_file($_FILES[$file]['tmp_name'])){
        if($_FILES[$file]["tmp_name"]['size'] >= (256 * 1048)){
            $error = "File Sixe EXCEEDED Max Value";
            include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
            return false;
        }
        $type=  $_FILES[$file]['type'];
        $title = $filetitle;
        if(preg_match('/^image\/p?jpeg$/i' ,
            $_FILES[$file]['type'])){
            $ext= '.jpg';
        }else
            if(preg_match('/^image\/gif$/i' ,
                $_FILES[$file]['type'])){
                $ext= '.gif';
        }else
                if(preg_match('/^image\/(x-)?png$/i' ,
                    $_FILES[$file]['type'])){
                    $ext= '.png';
         }else
                if(preg_match('/^video\/(x-)?3gp$/i' ,
                        $_FILES[$file]['type'])){
                        $ext= '.3gp';
         } else
                if(preg_match('/^video\/(x-)?mpeg(4)?$/i' ,
                            $_FILES[$file]['type'])){
                            $ext= '.mp4';
         } else
                if(preg_match('/^audio\/(x-)?mpeg(3)?$/i' ,
                                $_FILES[$file]['type'])){
                                $ext= '.mp3';
         }else
                if(preg_match('/^application\/(x-)?pdf$/i' ,
                                    $_FILES[$file]['type'])){
                                    $ext= '.pdf';
         } else
                if(preg_match('/^application\/(x-)?(ms)?doc$/i' ,
                                        $_FILES[$file]['type'])){
                                        $ext= '.doc';
         } else {
                 $ext = $_FILES[$file]["type"];
                 $error = "You Uploaded An Unsupported File Format ".$ext;
                 include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
                 exit();
         }

        $filename = $_SERVER['DOCUMENT_ROOT'] . $folder
            . $_FILES[$file]['name'].time(). $ext;
        $displayname = $folder . $_FILES[$file]['name'] .time().$ext;

//didnt use file_get_contents of the tmp file cos it returns
// and COPY don't accept string but valid path as param1
// unlike file_put_contents and is slightly faster then;
        if(!copy($_FILES[$file]['tmp_name'], $filename)){
            unlink($filename);
            $error = 'unable to save file';
            include $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
            exit();
        }
        $returner = array('title'=> $title , 'filename' => $filename ,
            'displayname'=> $displayname , 'type' => $type);

        return $returner;
    } else {
        return FALSE;
    }
}


//validate and store filss jpg,png,gif only;
function storeImageFile($file, $folder,$filetitle){

    if(isset($_FILES[$file])
        && is_uploaded_file($_FILES[$file]['tmp_name'])){
        if($_FILES[$file]['size'] >= (1048 * 1048)){
            $error = "File Sixe EXCEEDED Max Value";
            return false;
        }

        $type=  $_FILES[$file]['type'];
        $title = $filetitle;
        if(preg_match('/^image\/p?jpeg$/i' ,
            $_FILES[$file]['type'])){
            $ext= '.jpg';
        }elseif(preg_match('/^image\/gif$/i' ,
                $_FILES[$file]['type'])){
                $ext= '.gif';
            }elseif(preg_match('/^image\/(x-)?png$/i' ,
                    $_FILES[$file]['type'])){
                    $ext= '.png';
                }else{
                       $ext = $_FILES[$file]["type"];
                       $error = "You Uploaded An Unsupported File Format ".$ext;
                       return false;
                }

        $filename = $_SERVER['DOCUMENT_ROOT'] . $folder
            . $_FILES[$file]['name'].time(). $ext;
        $displayname = $folder . $_FILES[$file]['name'] .time().$ext;

//didnt use file_get_contents of the tmp file cos it returns
// and COPY don't accept string but valid path as param1
// unlike file_put_contents and is slightly faster then;
        if(!copy($_FILES[$file]['tmp_name'], $filename)){
            unlink($filename);
            $error = 'unable to save file';
            return false;
        }
        $returner = array('title'=> $title , 'filename' => $filename ,
            'displayname'=> $displayname , 'type' => $type);

        return $returner;
    } else {
        return FALSE;
    }
}

?>