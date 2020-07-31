<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<?php session_write_close();?>
<div class="container-fluid">
<div class="col-md-3">

    <?php if(isset($_GET["output"])){
        $output = $_GET["output"];
        echo "<h4 class='text-center text-capitalize'>".$output."</h4>";
    }
    if(isset($error)){
        $output = $error;
        echo "<h4 class='text-center'>".$output."</h4>";
    }?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

</div>
<div class="col-md-6">
    <div class="page-header">
        <h2 class="text-right">The Chat Box</h2>
    </div>
    <div class="col-md-6">
    <?php if(isset($conversation)):?>
        <div>
            <ul class="pagination">
                <?php $url = preg_replace("/&pgn=([0-9])*/","", $_SERVER["REQUEST_URI"]);?>
                <?php for($i=0; $i < $no_of_pages; $i++):?>
                    <li <?php if($i == $pgn){echo("class='active';"); }?>>
                        <a href="<?php echo $url;?>&pgn=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a> </li>
                <?php endfor;?>
            </ul>
        </div>

        <?php for($i=0; $i<count($conversation); $i++):?>
    <div>
        <p>
        <div class="row">
            <a class="text-capitalize" href='/api/user/index.php?guid=<?php echo $conversation[$i]["senderid"];?>'>
                <h6><b><?php echo $conversation[$i]["firstname"];?></b></h6>
            </a>

            <div class="col-md-2">
                <img src="<?php echo $conversation[$i]["profilepic"];?>"style='width:50px; height:50px;'
                class="img-circle"/>
            </div>
            <div class="col-md-10" style="padding-left: 20px;">

            <?php echo $conversation[$i]["detail"];?>
                <?php if($conversation[$i]["edited"] == "Y"){
                    echo('<br><span class="glyphicon"><i> Edited </i></span>');
                }?>
        <?php if(isset($_SESSION["userid"])&&($_SESSION["userid"]==$conversation[$i]["senderid"])):?>
        <p>
                <a href='/api/user/usermessage/index.php?deletemessage&mid=<?php echo($conversation[$i][0]);?>&rid=<?php echo($conversation[$i]["receiverid"]);?>'>
                    <button id='deletemsgbtn' class='btn' style="background: transparent; color: red; border: 0;">
                         <b>Delete</b>
                    </button>
                </a>
            <button id='editmsgbtn' class='btn' data-toggle='collapse'
                    data-target='<?php echo "#".$i."editmsgdiv";?>' style="background: transparent; border: 0;">
                <b>Edit</b>
            </button>
        <div class='collapse' id='<?php echo $i."editmsgdiv";?>'>
            <div class='form-group'>
                <form class='form-group' action='/api/user/usermessage/index.php' method='POST'>
                    <div class="form-group">
                    <input type='hidden' name='mid' value='<?php echo $conversation[$i][0];?>'/>
                    <input type='hidden' name='rxid' value='<?php echo $conversation[$i]["receiverid"];?>'/>
                    <input type='hidden' name='pgn' value='<?php echo $pgn;?>'/>

                    <label for='editmsgtextarea'>Message</label>
                    <textarea id='editmsgtextarea' name='detail' class='form-control'>
                        <?php echo $conversation[$i]["detail"];?>
                    </textarea>
                    </div>
                    <button type='submit' class='btn-block btn-success' name='editmessage'>Save</button>
                </form>
            </div>
        </div>
        </p>
        <?php endif;?>
    </div>
    </div>
</div>
    <?php endfor;?>
    <div class="form-group">
        <form action="/api/user/usermessage/index.php" method="post"
              class="form-group">
            <div class="form-group">
                <input type='hidden' name='pgn' value='<?php echo $pgn;?>'/>
                <label for="msgtextarea">Message</label>
                <textarea name='message' id='msgtextarea' class="form-control">

                </textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="rxid" value="<?php echo $senderid;?>"/>
                <button type="submit" name="sendmessage" class="btn-block btn-success">
                    Send
                </button>
            </div>
        </form>
    </div>
    <?php else:?>
    <div class="col-md-6">
        <div class="glyphicon ">
                <button id="backbtn" type="button" class="btn-success btn-lg">
                    Go Back
                </button>

            <script type="text/javascript">
                $("#backbtn").click(function(){
                    window.history.go(-1);
                });
            </script>
        </div>
    </div>
    <?php endif; ?>
    </div>
    <div class="col-md-6">
        <div class="glyphicon ">
        <span class="glyphicon-envelope"></span>
        <a href="/api/user/usermessage/index.php?getinboxmessages">
            <button type="button" class="btn-success btn-lg">
                My Inbox
            </button>
        </a>
        </div>
   </div>
</div>


<div class="col-md-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>
</div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
