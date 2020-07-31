<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/htmler.php';?>

<div class="container-fluid" xmlns="http://www.w3.org/1999/html">

    <div class="row">
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12">
                <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>
            </div>
        </div>
    </div>

    <div class='col-sm-6'>
            <h5 class="text-capitalize">
                <?php if(isset($_GET["output"])){
                    $output = $_GET["output"];
                }else if(isset($output)){
                    echo $output;
                }
                ?>
            </h5>
            <?php if(isset($takes)):?>
                <?php $RL = $takes[0]["replylevel"];?>
                <h4 class="text-center text-capitalize page-header">Reply <?php echo $takes[0]["firstname"];?>!</h4>

                <div>
                <div>
                    <h6 class="text-capitalize;"><a style="color: #ffffff;" href="/api/user/index.php?guid=<?php echo $takes[0]["userid"];?>">
                            <?php echo $takes[0]["firstname"]." ".$takes[0]["surname"]."'s ";?>
                        </a> Take On This:<br>
                        <small style="color: #ffffff;"><?php echo date("'y M d h:i a", strtotime($takes[0]["dateofpublication"]));?></small>
                    </h6>

                    <div style="padding: 10px; background-color: #006600;">
                        <p><?php shout($takes[0]["detail"]);?></p>
                        <?php if(!empty($takes[0]["commentimagedisplayname"])):?>
                            <div>
                                <img src="<?php echo $takes[0]["commentimagedisplayname"]; ?>" class="img-responsive" />
                            </div>
                        <?php endif;?>
                        <div>
                            <?php if(isset($_SESSION["userid"]) && ($_SESSION["userid"]==$takes[0]['userid'])):?>
                                <div style="border-top: 2px solid #ffff00;">
                                    <button type="button" data-toggle="collapse"
                                            data-target="<?php echo("#edittkdiv".$takes[0][0])?>"
                                            style="background-color: transparent; border: 0;" >
                                        Edit
                                    </button>
                                    <a style="color: #ffffff;" href= "/api/article/index.php?deletetake&takeid=<?php echo($takeid)?>&tid=<?php echo($takes[0][0]);?>&aid=<?php echo($takes[0]["articleid"]);?>&RL=<?php echo($RL); ?>&pgn=<?php echo($pgn);?>">
                                        <button style="background-color: transparent; border: 0;"
                                                type="button">
                                            <b> Delete</b>
                                        </button>
                                    </a>
                                </div>
                                <div class="collapse" id="<?php echo("edittkdiv".$takes[0][0])?>">
                                    <div class="form-group">
                                        <form action="/api/article/index.php" method="post"
                                              class="form-group" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="hidden" name="RL" value="<?php echo($RL)?>"/>
                                                <input type="hidden" name="aid" value="<?php echo $takes[0]["articleid"];?>"/>
                                                <input type="hidden" name="tid" value="<?php echo $takes[0][0];?>"/>
                                                <input type="hidden" name="takeid" value="<?php echo $takes[0][0];?>"/>
                                                <input type="hidden" name="pgn" value="<?php if(isset($pgn)){echo $pgn;}else{echo 0;}?>"/>
                                                <input type="hidden" name="artidreply" value=""/>

                                                <label for="<?php echo("edittkta".$takes[0][0])?>">Edit Take:</label>
                                                <textarea name="detail" id="<?php echo("edittkta".$takes[0][0])?>"
                                                          class="form-control"><?php echo $takes[0]["detail"];?>
                                                </textarea>
                                            </div>
                                            <div class="form-group">
                                               <input type="file" name="cidn">
                                                <input type="hidden" name="commentfile" value="<?php if(isset($takes[0]["commentimagedisplayname"])){echo $takes[0]["commentimagedisplayname"];}else{echo NULL; }?>"/>

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
                                $postid = $takes[0][0];
                                if($RL == 1){$nottypid = 5;}else{$nottypid = 6;}
                                if($headnotification->checkUserPostAction($userid,$postid,$nottypid,"commentnotification")):?>
                                    <a href="/api/article/?deleteaction&artpty=nooffollows&artidreply&aid=<?php echo $takes[0]["articleid"];?>&pid=<?php echo $postid?>&POid=<?php echo $takes[0]["userid"];?>&takeid=<?php echo $takes[0][0];?>&nottypid=<?php echo($nottypid);?>">
                                        <span class="glyphicon glyphicon-thumbs-down"></span>
                                        Unfollow &nbsp;&nbsp; &nbsp;
                                    </a>
                                <?php else:?>
                                    <a href="/api/article/?addaction&artidreply&artpty=nooffollows&aid=<?php echo $takes[0]["articleid"];?>&pid=<?php echo $postid?>&POid=<?php echo $takes[0]["userid"];?>&takeid=<?php echo $takes[0][0];?>&nottypid=<?php echo($nottypid);?>">
                                        <span class="glyphicon glyphicon-thumbs-up"></span> Follow &nbsp; &nbsp; &nbsp;
                                    </a>
                                <?php endif;?>

                                Following: <span class="badge"> <?php echo($takes[0]["nooffollows"])?></span>
                                Comments: <span class="badge"> <?php echo($takes[0]["noofcomments"])?></span>
                            </div>


                        </div>
                    </div>

                </div>
            <?php if(count($takes) > 0):?>
                <div style="padding: 30px;">
                <?php for($i=1; $i<count($takes); $i++):?>
            <div>

                <h6 class="text-capitalize;"><a style="color: #ffffff;" href="/api/user/index.php?guid=<?php echo $takes[$i]["userid"];?>">
                        <?php echo $takes[$i]["firstname"]." ".$takes[$i]["surname"]."'s ";?>
                    </a> Take On This:<br>
                    <small style="color: #ffffff;"><?php echo date("'y M d h:i a", strtotime($takes[$i]["dateofpublication"]));?></small>
                </h6>

                <div style="padding: 10px;  background-color: #005510;">
                    <?php shout($takes[$i]["detail"]);?>
                    <?php if(!empty($takes[$i]["commentimagedisplayname"])):?>
                        <div>
                            <img src="<?php echo $takes[$i]["commentimagedisplayname"]; ?>" class="img-responsive" />
                        </div>
                    <?php endif;?>
                    <div style="border-top: 2px solid yellowgreen;">
                        <?php if(isset($_SESSION["userid"]) && ($_SESSION["userid"]==$takes[$i]['userid'])):?>
                            <div>
                                <button type="button" data-toggle="collapse"
                                        data-target="<?php echo("#edittkdiv".$takes[$i][0])?>"
                                        style="background-color: transparent; border: 0;" >
                                    Edit
                                </button>
                                <a style="color: #ffffff;" href= "/api/article/index.php?deletetake&artidreply&takeid=<?php echo($takes[$i]["commentid"]); ?>&tid=<?php echo($takes[$i][0]);?>&aid=<?php echo($takes[0]["articleid"]);?>&RL=<?php echo($RL+1); ?>&pgn=<?php if(isset($pgn)){echo $pgn;}else{echo 0;}?>">
                                    <button style="background-color: transparent; border: 0;"
                                            type="button">
                                        <b> Delete</b>
                                    </button>
                                </a>
                            </div>
                            <div class="collapse" id="<?php echo("edittkdiv".$takes[$i][0]);?>">
                                <div class="form-group">
                                    <form action="/api/article/index.php" method="post"
                                          class="form-group" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="hidden" name="aid" value="<?php echo $takes[$i]["articleid"];?>"/>
                                            <input type="hidden" name="takeid" value="<?php echo $takes[0][0];?>"/>
                                            <input type="hidden" name="tid" value="<?php echo $takes[$i][0];?>"/>

                                            <!--values for retching the replies back-->
                                            <input type="hidden" name="artidreply" value=""/>
                                            <input type="hidden" name="pgn" value="<?php if(isset($pgn)){echo $pgn;}else{echo 0;}?>"/>

                                            <input type="hidden" name="RL" value="<?php echo($RL+1)?>"/>
                                            <input type="hidden" name="artidreply" value=""/>

                                            <label for="<?php echo("edittkta".$takes[$i][0])?>">Edit Take:</label>
                                            <textarea name="detail" id="<?php echo("edittkta".$takes[$i][0])?>"
                                                      class="form-control"><?php echo $takes[$i]["detail"];?>
                                            </textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="file" name="cidn">
                                            <input type="hidden" name="commentfile" value="<?php if(isset($takes[$i]["commentimagedisplayname"])){echo $takes[$i]["commentimagedisplayname"];}else{echo NULL;}?>"/>

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
                            $postid = $takes[$i][0];
                            if($RL == 1){$nottypid = 6; }else{$nottypid = 7;}
                            if($headnotification->checkUserPostAction($userid,$postid,$nottypid,"commentnotification")):?>
                                <a href="/api/article/?deleteaction&artpty=nooffollows&artidreply&takeid=<?php echo $takes[0][0];?>&pid=<?php echo $postid?>&POid=<?php echo $takes[$i]["userid"];?>&nottypid=<?php echo($nottypid);?>&RL=<?php echo($RL+1);?>&pgn=<?php echo($pgn);?>">
                                    <span class="glyphicon glyphicon-thumbs-down"></span> Unfollow &nbsp;&nbsp; &nbsp;

                                </a>
                            <?php else:?>
                                <a href="/api/article/?addaction&artpty=nooffollows&artidreply&takeid=<?php echo $takes[0][0];?>&pid=<?php echo $postid?>&POid=<?php echo $takes[$i]["userid"];?>&nottypid=<?php echo($nottypid);?>&pgn=<?php echo($pgn);?>">
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Follow &nbsp; &nbsp; &nbsp;
                                </a>
                            <?php endif;?>

                            <?php if($RL < 2):?>
                                <a href="/api/article/?reply&takeid=<?php echo $takes[$i][0];?>">
                                        <button type="submit" name="reply" style="background-color: transparent; border: 0;" >
                                            Reply
                                        </button>
                                 </a>
                            <?php endif; ?>
                            <?php $takeRL = $takes[$i]["replylevel"];?>
                            <a href="/api/article/?postfollowers&nottypid=<?php if($takeRL == 2){echo 6;}elseif($takeRL == 3){echo 7;}?>&pid=<?php echo($takes[$i][0])?>"> Followers</a>:<span class="badge"> <?php echo($takes[$i]["nooffollows"])?></span>
                            Comments: <span class="badge"> <?php echo($takes[$i]["noofcomments"])?></span>
                        </div>


                    </div>
                </div><br><br>
                <?php endfor;?>

                <?php endif;?>
                <div>
                        <div class="form-group">
                        <form class="form-group" action="/api/article/index.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" name="aid" value="<?php echo $takes[0]["articleid"];?>"/>
                                <input type="hidden" name="RL" value="<?php echo($RL+1);?>"/>

                                <!--values for retching the replies back-->
                                <input type="hidden" name="artidreply" value=""/>
                                <input type="hidden" name="pgn" value="<?php if(isset($pgn)){echo $pgn;}else{echo 0;}?>"/>
                                <input type="hidden" name="takeid" value="<?php echo $takes[0][0];?>"/>
                                <input type="hidden" name="POid" value="<?php echo $takes[0]["userid"];?>"/>


                                <label for="taketextarea">Reply:</label>
                                <textarea id="taketextarea" class="form-control" name="detail">

                                </textarea>
                                <label for="takeimage">Add Image On Your Take:</label>
                                <input type="file" name="cidn" />
                                <button type="submit" name="addtake" style="background-color: transparent; border: 0;" >
                                    Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
    </div>


        <div>
            <ul class="pagination">
                <?php for($i = 0; $i < $no_of_pages; $i++):?>
                    <li>
                        <a href="/api/article/?reply&takeid=<?php echo($takes[0][0]);?>&pgn=<?php echo $i; ?>&RL=<?php echo($RL);?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
</div>
        <?php endif;?>

</div>

    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12" style="height: 100px;">

            </div>
        </div>
    </div>
</div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php'?>
