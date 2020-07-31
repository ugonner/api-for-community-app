<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php'?>

<?php
if(!isset($_SESSION)){
    session_start();

}
$uid = $_SESSION["userid"];
$notificationcount = $headnotification->getCountNotificationOnUserPosts($uid);
$sql = 'UPDATE user SET lastuserpostnotificationcount = '.$notificationcount.' WHERE id = '.$uid;

$db = new Dbconn();
$dbh = $db->dbcon;
try{
    $stmt = $dbh -> prepare($sql);;

    $stmt -> execute();
    $takescount = $stmt -> fetch();

}
catch(PDOException $e){
    $error = "Unable TO Update notification counter";
    $error2 = $e -> getMessage();
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
    exit();
}

?>
<!--style for notification divs-->
<style>
    .commentnotificationdiv{
        margin: 5px 5px 5px 5px ;
        padding: 5px 5px 5px 5px ;
    }
    .img-circle{
        margin: 5px 10px 5px 5px ;
    }
</style>
<div class="container-fluid">

    <div class="row">
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12">
                <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>
            </div>
        </div>
    </div>

    <div class='col-sm-6'>
        <div class="row">
            <h4 class="text-center page-header">Notifications</h4>

            <?php if(isset($notifications)):?>
                <div>
                    <ul class="pagination">
                        <?php for($i=0; $i < $no_of_pages; $i++):?>
                            <li <?php if($i == $pgn){echo("class='active';"); }?>>
                                <a href="/api/notification/?getuserpostnotifications&&pgn=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a> </li>
                        <?php endfor;?>
                    </ul>
                </div>
            <?php foreach($notifications as $n):?>
                    <?php if($n["firstname"] != $_SESSION["userdata"]["firstname"]):?>
                    <?php if($n["notificationtypeid"] == 1):?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block">
                            <?php if($n["marked"] == "N"):?>
                                <h5 class="commentnotificationh5"><b>
                                    <?php echo($n["firstname"]); ?> Also Commented On
                                    <a href="/api/article/?notification&nid=<?php echo($n[0]);?>&gaid=<?php echo($n["postid"]);?> ">
                                        <i>This Post</i>
                                    </a>
                                    </b>
                                </h5>
                            <?php else: ?>
                                <h5 class="commentnotificationh5">
                                    <?php echo($n["firstname"])?> Also Commented On
                                    <a href="/api/article/?notification&nid=<?php echo($n[0]);?>&gaid=<?php echo($n["postid"]);?>">
                                        <i>This Post</i>
                                    </a>

                                </h5>

                            <?php endif; ?>
                        </div>
                        </div>


                    <?php elseif($n["notificationtypeid"] == 2): ?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block" class="notificationdiv">
                            <?php if($n["marked"] == "N"):?>
                               <h5><b>
                                        <?php echo($n["firstname"])?> Also Replied To
                                        <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=1">
                                            <i>This Comment</i>
                                        </a>
                                    </b>
                                </h5>
                            <?php else: ?>
                                <h5>
                                    <?php echo($n["firstname"])?> Also Replied To
                                    <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=1">
                                        <i>This Comment</i>
                                    </a>

                                </h5>
                            <?php endif; ?>
                        </div>
                        </div>
                    <?php elseif($n["notificationtypeid"] == 3):?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block" class="notificationdiv">
                                <?php if($n["marked"] == "N"):?>
                                    <h5><b>
                                            <?php echo($n["firstname"])?> Also Replied To
                                            <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=2">
                                                <i>This Reply</i>
                                            </a>
                                        </b>
                                    </h5>
                                <?php else: ?>
                                    <h5>
                                        <?php echo($n["firstname"])?> Also Replied To
                                        <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=2">
                                            <i>This Reply</i>
                                        </a>

                                    </h5>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php elseif($n["notificationtypeid"] == 4):?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block" class="notificationdiv">
                                <?php if($n["marked"] == "N"):?>
                                    <h5><b>
                                            <?php echo($n["firstname"])?> Also Liked And Followed
                                            <a href="/api/article/?gaid=<?php echo($n["postid"]);?>&notification&nid=<?php echo($n[0]);?>">
                                                <i>This Post</i>
                                            </a>
                                        </b>
                                    </h5>
                                <?php else: ?>
                                    <h5>
                                        <?php echo($n["firstname"])?> Also Liked And Followed
                                        <a href="/api/article/?gaid=<?php echo($n["postid"]);?>&notification&nid=<?php echo($n[0]);?>">
                                            <i>This Post</i>
                                        </a>

                                    </h5>
                                <?php endif; ?>
                            </div>
                        </div>


                    <?php elseif($n["notificationtypeid"] == 5):?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block" class="notificationdiv">
                                <?php if($n["marked"] == "N"):?>
                                    <h5><b>
                                            <?php echo($n["firstname"])?> Also Liked And Followed
                                            <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=1">
                                                <i>This Comment</i>
                                            </a>
                                        </b>
                                    </h5>
                                <?php else: ?>
                                    <h5>
                                        <?php echo($n["firstname"])?> Also Liked And Followed
                                        <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=1">
                                            <i>This Comment</i>
                                        </a>

                                    </h5>
                                <?php endif; ?>
                            </div>
                        </div>


                    <?php elseif($n["notificationtypeid"] == 6):?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block" class="notificationdiv">
                                <?php if($n["marked"] == "N"):?>
                                    <h5><b>
                                            <?php echo($n["firstname"])?> Also Liked And Followed
                                            <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=2">
                                                <i>This Reply</i>
                                            </a>
                                        </b>
                                    </h5>
                                <?php else: ?>
                                    <h5>
                                        <?php echo($n["firstname"])?> Also Liked And Followed
                                        <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=2">
                                            <i>This Reply</i>
                                        </a>

                                    </h5>
                                <?php endif; ?>
                            </div>
                        </div>


                    <?php elseif($n["notificationtypeid"] == 7):?>
                        <div class="commentnotificationdiv">
                            <div style="display: inline-block;">
                                <img class="img-circle" style="width: 50px; height: 50px;" src="<?php echo($n["profilepic"]); ?>" />
                            </div>
                            <div style="display: inline-block" class="notificationdiv">
                                <?php if($n["marked"] == "N"):?>
                                    <h5><b>
                                            <?php echo($n["firstname"])?> Also Liked And Followed A Reply To
                                            <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=3">
                                                <i>This Reply</i>
                                            </a>
                                        </b>
                                    </h5>
                                <?php else: ?>
                                    <h5>
                                        <?php echo($n["firstname"])?> Also Liked And Followed A Reply To
                                        <a href="/api/article/?reply&notification&nid=<?php echo($n[0]);?>&takeid=<?php echo($n["postid"]);?>&RL=1">
                                           <i> This Reply</i>
                                        </a>

                                    </h5>
                                <?php endif; ?>
                            </div>
                        </div>


                    <?php endif; ?>
                    <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <div style=" border: 40px solid #000000;">
                <div style="background-image: url("/api/img/emptycart4.jpg") 100% 100%; background-repeat: no-repeat;
                     ">
                    <img src="/api/img/emptycart4.jpg" style="width: 100%; height: 100%; position: relative;">
                    <h3 style="position: absolute; top: 40%; color: darkgrey;">
                        <i><b><?php echo($output);?></b></i>
                    </h3>
                </div>
            </div>
            <?php endif;?>

        </div>
    </div>
    <div class="col-sm-3">
        <div class="row">
            <div class="col-sm-12">
                <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>
            </div>
        </div>
    </div>
</div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php'?>
</body>
</html>