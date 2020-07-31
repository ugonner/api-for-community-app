
<div style=" font-weight: bolder;">

    <div style="clear: both;">
        <br><br>
        <button id="getactiveusersbutton" type="button" class="btn btn-lg btn-info btn-block" >
            <span class="glyphicon glyphicon-comment"></span> Chat Online Users
        </button>

        <div style="padding: 10px;" id="getactiveusersdiv">

        </div>
        <?php if(isset($_SESSION["userid"])):?>
            <div class="page-header">
                <h4 class="text-capitalize">Welcome, <?php echo $_SESSION["userdata"]["firstname"];?></h4>

                <h6 class="text-right">
                    <a href="/api/user/index.php?logout" class="btn btn-sm btn-danger">
                        Logging Out!
                    </a>
                </h6>
            </div>

            <div style="float: left; margin: 10px;">
                <img src="<?php echo $_SESSION["userdata"]["profilepic"];?>" class="img-circle"
                     style="width:80px; height: 80px;"/>
            </div>
            <div style="font-size: 0.8em;">
                <?php $rusermsg = new Usermessage();
                if($unreadmsgs = $rusermsg ->getUnreadMessages($_SESSION["userid"],10,0)){
                    $count = $unreadmsgs["count"];
                }else{
                    $count = 0;
                }?>
                <?php
                $uid = $_SESSION["userid"];

                //check user notifications for posts/articles/comments;
                $notificationcount = $headnotification->getCountAllUserNotifications($uid);
                $sql = 'SELECT lastnotificationcount FROM user WHERE id = '.$uid;

                $db = new Dbconn();
                $dbh = $db->dbcon;
                try{
                    $stmt = $dbh -> prepare($sql);;

                    $stmt -> execute();
                    $notificationcount2 = $stmt -> fetch();

                }
                catch(PDOException $e){
                    $error = "Unable TO count notification counter";
                    $error2 = $e -> getMessage();
                    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                    exit();
                }
                $notifs = $notificationcount - $notificationcount2[0];

                //check for notifications on user posts;
                $userpostnotificationcount = $headnotification->getCountNotificationOnUserPosts($uid);
                $sql = 'SELECT lastuserpostnotificationcount FROM user WHERE id = '.$uid;

                $db = new Dbconn();
                $dbh = $db->dbcon;
                try{
                    $stmt = $dbh -> prepare($sql);;

                    $stmt -> execute();
                    $userpostnotificationcount2 = $stmt -> fetch();

                }
                catch(PDOException $e){
                    $error = "Unable TO count notification counter";
                    $error2 = $e -> getMessage();
                    include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/errors/error.html.php';
                    exit();
                }
                $userpostnotifs = $userpostnotificationcount - $userpostnotificationcount2[0];


                ?>

                <?php if($notifs > 0):?>
                    <a href="/api/notification/?getusernotifications" style="color: #f5f5f5;">
                        <span class="glyphicon glyphicon-folder-close"></span>
                        New Notifications <span class="badge"><?php echo($notifs);?></span>
                    </a><br>
                <?php endif;?>
                <?php if($userpostnotifs > 0):?>
                    <a href="/api/notification/?getuserpostnotifications" style="color: #f5f5f5;">
                        <span class="glyphicon glyphicon-filter"></span>
                        New Notifications On My Posts <span class="badge"><?php echo($userpostnotifs);?></span>
                    </a><br>
                <?php endif;?>
                <a href="/api/user/usermessage/index.php?getunreadmessages" style="color: #f5f5f5;">
                    <span class="glyphicon glyphicon-envelope"></span>
                    Unread Messages <span class="badge"><?php echo($count);?></span>
                </a><br>



                <a href="/api/article/index.php?getuserarticles&uid=<?php echo $_SESSION["userid"];?>" style="color: #f5f5f5;">
                    <span class="glyphicon glyphicon-pencil"></span>
                    My Articles
                </a><br>

                <a href="/api/article/index.php?gca" style="color: #f5f5f5;">
                    <span class="glyphicon glyphicon-pencil"></span>
                    Commented Articles

                </a><br>
            </div>
        <?php else:?>
            <h4 class="page-header" style="clear: both;">Welcome Guest!</h4>
            <h5>You Can Register Here</h5>
            <b><a href="/api/user/registration.html.php" style="color: #f5f5f5;">
                    <span class="glyphicon glyphicon-user"></span>
                    <i>Easy!</i> Just Click
                </a></b>
            <h5 class="text-center">OR</h5>
            <b><a href="/api/user/index.php" style="color: #f5f5f5;">
                    <span class="glyphicon glyphicon-log-in"></span> Sign In
                </a></b>
        <?php endif;?>
        <script type="text/javascript">
            $("#getactiveusersbutton").click(function(){
                $("#getactiveusersdiv").empty();
                $("#getactiveusersdiv").append("Loading Users...");
                $("#getactiveusersdiv").load("/api/user/?getactiveusers");
            });
        </script>

    </div>
</div>