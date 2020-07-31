
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/htmler.php';
 include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>

<!-- style for replies div -->
<style>
    .replies2div{
        padding: 10px 20px 10px 20px;
    }
    .replies3div{
        padding: 10px 50px 10px 50px;
    }
</style>


<div class="container-fluid" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
 <div class="row">
    <div class="col-sm-12">
    <?php if(isset($_GET["output"])){
            $output = $_GET["output"];
            echo "<h4 class='text-center'>".$output."</h4>";
        }
          if(isset($error)){
            $output = $error;
            echo "<h4 class='text-center'>".$output."</h4>";
        }?>

    </div>
</div>


<div class="container-fluid">
<div class="row">
    <div class="col-sm-5">
        <div class="row">
            <div class="col-sm-12">
            <?php $article = $articles["article"][0];?>
                <h3 class="page-header text-center"><?php echo $article['title']; ?></h3>
                <h6>View Author: <a style="color: lightgreen; font-weight: strong;" href="/api/user/index.php?guid=<?php echo $article['userid'];?>">
                        <?php echo $article['firstname'].", ".$article['surname'];?>
                </a> <br/>
                <small><?php echo date("'y F d, l h:i a", strtotime($article['dateofpublication'])); ?></small>
                </h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div><p>
                    <img src="<?php echo $article["articleimagedisplayname"];?>"
                        style="width: 100%; height: 150px;" alt="image on <?php echo $article["title"];?>"/>
                </p>
                
  <!-- Load Facebook SDK for JavaScript -->
            <!-- Your share button code -->
                <div class="fb-share-button" 
                    data-href="<?php echo 'https://agmall.com.ng'.$_SERVER['REQUEST_URI']; ?>" 
                    data-layout="button_count">
                </div>
             </div>
        </div>
        <div class="row">
            <div><?php $admin = new admin();
                if(isset($_SESSION["userid"]))
                {
                    $isadmin = $admin->isAdmin($_SESSION["userid"]);
                }else{
                    $isadmin = false;
                } ?>
                <?php if((isset($_SESSION["userid"]) && ($isadmin
                        OR ($_SESSION["userid"]==$article["userid"])))):?>
                <div style="border-bottom: 2px solid red;">
                    <div style="display: inline-block;">
                    <form action="<?php if($isadmin){echo '/api/article/adminarticleform.html.php'; }else{ echo('/api/article/articleform.html.php');}?>" method="POST">
                        <input type="hidden" name="uid" value="<?php echo $article["userid"];?>"/>
                        <input type="hidden" name="aid" value="<?php echo($article[0]);?>"/>
                        <input type="hidden" name="title" value="<?php echo $article["title"];?>"/>
                        <input type="hidden" name="detail" value="<?php shout($article["detail"]);?>" >
                        <input type="hidden" name="cid" value="<?php echo $article["categoryid"];?>"/>
                        <input type="hidden" name="aidn" value="<?php echo $article["articleimagedisplayname"];?>"/>

                        <button type="submit" name="editarticle"
                            class="btn btn-info">
                            Edit
                        </button>
                    </form>
                    </div>
                    <a href="/api/article/index.php?deletearticle&aid=<?php echo $article[0];?>&uid=<?php echo $article["userid"];?>"
                        class="btn btn-info">
                        Delete
                    </a>
                </div>
            </div>
            <?php if($isadmin):?>
                <div>
                    <?php if($article["public"]=="Y"):?>
                        <a href="/api/admin/?unmakearticlepublic&aid=<?php echo $article[0];?>">
                            <b> Remove Public</b>
                        </a>
                    <?php else: ?>
                        <a href="/api/admin/?makearticlepublic&aid=<?php echo $article[0];?>">
                            <b>Make Public</b>
                        </a>
                    <?php endif; ?>

            <?php endif;?>


            <?php endif;?>



                <?php if(isset($_SESSION["userid"])){ $userid = $_SESSION["userid"];}else{$userid = 0;}
                $postid = $article[0];
                if($headnotification->checkUserPostAction($userid,$postid,4,"notification")):?>
                    <a href="/api/article/?deleteaction&artpty=nooffollows&aid=<?php echo $article[0];?>&pid=<?php echo $postid?>&POid=<?php echo $article["userid"];?>&nottypid=4&pgn=<?php echo($pgn);?>">
                        <span class="glyphicon glyphicon-thumbs-down"></span> Unfollow &nbsp;&nbsp; &nbsp;

                    </a>
                <?php else:?>
                    <a href="/api/article/?addaction&artpty=nooffollows&aid=<?php echo $article[0];?>&pid=<?php echo $postid?>&POid=<?php echo $article["userid"];?>&nottypid=4&pgn=<?php echo($pgn);?>">
                        <span class="glyphicon glyphicon-thumbs-up"></span> Follow &nbsp; &nbsp; &nbsp;
                    </a>
                <?php endif;?>
                <a href="/api/article/?postfollowers&nottypid=4&pid=<?php echo($article[0])?>"> Followers</a>: <span class="badge"> <?php echo $article["nooffollows"]?></span>
                Comments: <span class="badge"><?php echo $article["noofcomments"]?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if($admin->isAdmin($article['userid'])): ?>
                    <p><?php echo $article["detail"];?></p>
                <?php else:?>
                    <p><?php shout($article["detail"]);?></p>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12">
            <?php if(isset($articles["files"])):?>
            <?php $files = $articles["files"];?>
                <h6 class="page-header text-center">Files On <?php echo $article["title"];?></h6>
            <div>
            <?php foreach($files as $file):?>
                <?php
                if(preg_match('/^image\/(x-)?png$/',$file[4]) OR
                    preg_match('/^image\/(p)?jpeg$/',$file[4]) OR
                    preg_match('/^image\/gif$/',$file[4])): ?>
                <div>
                    <img style='width:100%; height:100px;'
                         src='<?php echo($file[3]);?>'/>
                </div>
                <h6><?php echo($file[1]);?></h6>
                <?php else:?>
                    <h6> DOWNLOADABLE FILE</h6>
                    <a href= "<?php echo($file[3]);?>">
                        <?php echo($file[1]);?>
                    </a>
                <?php endif;?>
                <?php if(isset($_SESSION["userid"]) && (($_SESSION["userid"]==$article["userid"]) || $isadmin )):?>
                    <form action="/api/article/index.php" method="POST">
                        <input type="hidden" name="fn" value="<?php echo($file[2]);?>"/>
                        <input type="hidden" name="fid" value="<?php echo($file[0]);?>"/>
                        <input type="hidden" name="uid" value="<?php echo($article["userid"]);?>"/>
                        <input type="hidden" name="aid" value="<?php echo($article[0]);?>"/>

                        <button type="submit" class="btn btn-danger" name="deletefile"
                            style="border: 0px;">
                            Delete File
                        </button>
                    </form>
                <?php endif;?>
                <br>
            <?php endforeach; ?>
            </div>
            <?php endif;?>
            </div>
        </div>
    </div>



    <div class="col-sm-4">
                <h6 class="page-header text-center">Takes On <?php echo $article["title"];?></h6>
                <div class="form-group">
                    <form class="form-group" action="/api/article/index.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">

                            <label for="taketextarea">Your Take:</label>
                            <textarea id="taketextarea" name="detail" class="form-control"></textarea>

                            <label for="taketextarea">Any Picture On Your Take ? <br> Upload Below</label>
                            <input type="file" name="cidn">
                            <input type="hidden" name="aid" value="<?php echo $article[0];?>"/>
                            <input type="hidden" name="RL" value="1"/>
                            <input type="hidden" name="POid" value="<?php echo $article["userid"];?>"/>
                            <button type="submit" class="btn-success"
                                name="addtake">
                                Post Take
                            </button>
                        </div>
                    </form>
                </div>
                <?php if(isset($articles["takes"])):?>
                <?php $takes = $articles["takes"];?>
                    <div>
                        <ul class="pagination">
                            <?php for($i = 0; $i < $no_of_pages; $i++):?>
                            <li><a href="/api/article/?gaid=<?php echo($article[0]);?>&pgn=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <?php foreach($takes as $take):?>
                        <div>
                            <div>
                                <img src="<?php echo($take["profilepic"]); ?>"
                                     style="width: 30px; height: 30px;">
                            </div>
                            <h6 class="text-capitalize;">
                                RE: <?php echo $article["title"];?><br>
                                <a style="color: #ffffff;" href="/api/user/?guid=<?php echo $take["userid"];?>">
                                    by <?php echo $take["firstname"]." ".$take["surname"];?>
                                </a>:<br>
                            <small style="color: #ffffff;"><?php echo date("'y M d h:i a", strtotime($take["dateofpublication"]));?></small>
                            </h6>


                                <div style="background-color: #005510; padding: 10px;">
                                <?php shout($take["detail"]);?>
                                    <?php if(!empty($take["commentimagedisplayname"])):?>
                                    <div>
                                        <img src="<?php echo $take["commentimagedisplayname"]; ?>" class="img-responsive" />
                                    </div>
                                    <?php endif;?>
                                <div>
                                <?php if(isset($_SESSION["userid"]) && ($_SESSION["userid"]==$take["userid"])):?>
                                    <div style="border-top: 2px solid red;">
                                        <button type="button" data-toggle="collapse"
                                                data-target="<?php echo("#edittkdiv".$take[0])?>"
                                                style="background-color: transparent; border: 0;" >
                                            Edit
                                        </button>
                                        <a style="color: #ffffff;" href= "/api/article/index.php?deletetake&POid=<?php echo($article["userid"]);?>&takeid=<?php echo($article[0]);?>&pid=<?php echo($article[0]);?>&aid=<?php echo($take["articleid"]);?>&tid=<?php echo($take[0]);?>&RL=1&pgn=<?php echo($pgn);?>">
                                            <button style="background-color: transparent; border: 0;"
                                                    type="button">
                                                <b> Delete</b>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="collapse" id="<?php echo("edittkdiv".$take[0])?>">
                                        <div class="form-group">
                                        <form action="/api/article/index.php" method="post"
                                            class="form-group" enctype="multipart/form-data">
                                            <div class="form-group">
                                            <input type="hidden" name="RL" value="1"/>
                                                <input type="hidden" name="pid" value="<?php echo $take["articleid"];?>"/>
                                            <input type="hidden" name="aid" value="<?php echo $take["articleid"];?>"/>
                                            <input type="hidden" name="tid" value="<?php echo $take[0];?>"/>
                                            <input type="hidden" name="pgn" value="<?php if(isset($pgn)){echo $pgn;}else{echo 0;}?>"/>
                                            <input type="hidden" name="commentfile" value="<?php if(isset($take["articleimagedisplayaname"])){echo $take["commentimagedisplayaname"];}else{echo NULL;}?>"/>

                                            <label for="<?php echo("edittkta".$take[0])?>">Edit Take:</label>
                                            <textarea name="detail" id="<?php echo("edittkta".$take[0])?>"
                                                class="form-control"><?php echo $take[1];?>
                                            </textarea>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="cidn">
                                            </div>
                                            <button type="submit" name="edittake" class="btn-success"
                                                style="border: 0;">
                                                Edit Take
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                   <?php endif;?>
                                    <div>
                                        <?php if(isset($_SESSION["userid"])){ $userid = $_SESSION["userid"];}else{$userid = 0;}
                                        $postid = $take[0];
                                        if($headnotification->checkUserPostAction($userid,$postid,5,"commentnotification")):?>
                                            <a href="/api/article/?deleteaction&artpty=nooffollows&aid=<?php echo $article[0];?>&pid=<?php echo $postid?>&POid=<?php echo $take["userid"];?>&nottypid=5&RL=1&pgn=<?php echo($pgn);?>">
                                                <span class="glyphicon glyphicon-thumbs-down"></span> Unfollow &nbsp;&nbsp; &nbsp;

                                            </a>
                                        <?php else:?>
                                            <a href="/api/article/?addaction&artpty=nooffollows&aid=<?php echo $article[0];?>&pid=<?php echo $postid?>&POid=<?php echo $take["userid"];?>&nottypid=5&RL=1&pgn=<?php echo($pgn);?>">
                                                <span class="glyphicon glyphicon-thumbs-up"></span> Follow &nbsp; &nbsp; &nbsp;
                                            </a>
                                        <?php endif;?>



                                        <a href="/api/article/?reply&takeid=<?php echo $take[0];?>">
                                                        <button type="submit" name="reply" style="background-color: transparent; border: 0;" >
                                                            Reply
                                                        </button>
                                        </a>

                                        <a href="/api/article/?postfollowers&nottypid=5&pid=<?php echo($take["0"])?>">
                                            <span class="btn glyphicon glyphicon-comment"
                                                  style="background: transparent;">
                                                    : <span> <?php echo($take["noofcomments"])?></span>
                                             </span>
                                        </a>
                                        <span class="btn glyphicon glyphicon-thumbs-up"
                                              style="background: transparent;">
                                            <span> <?php echo($take["nooffollows"])?></span>
                                        </span>
                                    </div>


                            </div>


                            <?php if(!empty($articles["replies2"])):?>
                                <?php $replies2 = $articles["replies2"];?>
                                <?php
                                $replies = array();
                                for($i=0; $i<count($replies2); $i++){
                                    if($replies2[$i]["commentid"] == $take[0]){
                                        $replies[] = $replies2[$i];
                                    }
                                }
                                ?>

                                <?php for($i1=0; $i1<4; $i1++):?>
                                    <?php
                                    $R3s = array();
                                    if(!empty($replies[$i1])):?>

                                        <div>
                                        <div class="replies2div">
                                            <div>
                                                <img src="<?php echo($replies[$i1]["profilepic"]); ?>"
                                                     style="width: 20px; height: 20px;">
                                            </div>
                                            <h5>
                                                <a href="/api/user/?guid=<?php echo($replies[$i1]["userid"]);?>">
                                                    <?php echo($replies[$i1]["firstname"]); ?>'s Take On This <?php echo($take["firstname"]);?>'s Comment.
                                                </a>
                                                <br><?php echo(date("Y m d h:i:s", strtotime($replies[$i1]["dateofpublication"])));?>
                                            </h5>

                                            <h6>
                                                <?php shout($replies2[$i1]["detail"]); ?>
                                            </h6>

                                            <span class="btn glyphicon glyphicon-comment"
                                                style="background: transparent">
                                            <span><?php echo($replies[$i1]["noofcomments"]); ?></span>
                                            </span>
                                            <span class="btn glyphicon glyphicon-thumbs-up"
                                                  style="background: transparent">
                                                <span><?php echo($replies[$i1]["nooffollows"]); ?></span>
                                            </span>
                                        </div>

                                <!-- sSorting and displaying 3rd level replies-->
                                            <?php if(!empty($articles["replies3"])):?>
                                                <?php $replies3 = $articles["replies3"];?>
                                                <?php
                                                for($i2=0; $i2<count($replies3); $i2++){
                                                    if($replies3[$i2]["commentid"] == $replies[$i1][0]){
                                                        $R3s[] = $replies3[$i2];
                                                    }
                                                }?>
                                                <?php for($i22=0; $i22<4; $i22++):?>
                                                    <?php if(!empty($R3s[$i22])):?>
                                            <div class="replies3div">
                                                            <div>
                                                                <img src="<?php echo($R3s[$i22]["profilepic"]); ?>"
                                                                    style="width: 15px; height: 15px;">
                                                            </div>

                                                            <h5>
                                                                <a href="/api/user/?guid=<?php echo($R3s[$i22]["userid"]);?>">
                                                                    <?php echo($R3s[$i22]["firstname"]); ?>'s Take On <?php echo($replies[0]["firstname"]);?>'s Reply.
                                                                </a>
                                                                <br><?php echo(date("Y m d h:i:s", strtotime($R3s[$i22]["dateofpublication"])));?>
                                                            </h5>

                                                            <h6>
                                                                <?php shout($R3s[$i22]["detail"]); ?>
                                                            </h6>

                                                            <span class="btn glyphicon glyphicon-comment"
                                                                    style="background: transparent">
                                                                <span><?php echo($R3s[$i1]["noofcomments"]); ?></span>
                                                            </span>
                                                            <span class="btn glyphicon glyphicon-thumbs-up"
                                                                style="background: transparent">
                                                                <span><?php echo($R3s[$i1]["nooffollows"]); ?></span>
                                                            </span>

                                                        </div>

                                                    <?php endif;?>
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            <?php endif; ?>
                                </div><br><br>

                            <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
       </div>
</div>
        <?php session_write_close();?>

<div style="clear: both;">
</div>

 <div class="container-fluid">
     <div class="row" style="height: 100px;">

     </div>
 </div>
<div class="container-fluid">
    <div class="row">

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
    </div>
</div>
