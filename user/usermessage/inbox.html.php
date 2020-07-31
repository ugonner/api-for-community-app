<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<?php session_write_close();?>
<div class="container-fluid">
<div class="col-md-3">
        <?php if(isset($_GET["output"])){
            $output = $_GET["output"];
            echo "<h4 class='text-center'>".$output."</h4>";
        }elseif(isset($error)){
            echo "<h4 class='text-center'>".$error."</h4>";
        }?>

        <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

</div>
<div class="col-md-6">
    <div class="page-header">
        <h2 class="text-right">My Inbox Room</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?php if(!empty($messages)):?>
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

            <?php foreach($messages as $m):?>
                <div><h5 class="text-right">
                    <a class="text-capitalize text-right" style="color: #ffffff;"
                       href="/api/user/usermessage/index.php?getconversation&senderid=<?php echo $m["senderid"];?>">
                        Reply <?php echo " ".$m["firstname"];?>
                    </a></h5>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?php echo $m["profilepic"];?>"
                                 class="img-circle" style="width: 50px;
                                 height: 40px;"/>
                        </div>
                        <div class="col-md-10">
                            <?php if($m["marked"]=="N"):?>
                                <p><b><?php echo substr($m["detail"],0,80)."...";?></b><span class="glyphicon-envelope"></span>
                                <br/><?php echo date("'y M d, h:i:s a", strtotime($m["dateofpublication"]));?></p>
                            <?php else:?>
                                <p><?php echo substr($m["detail"],0,80)."...";?>
                                    <br/><?php echo date("'y M d, l", strtotime($m["dateofpublication"]));?></p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
             <?php endforeach; ?>
        <?php else:?>
            <h4 class="text-center text-capitalize">No Unread Messages In  Inbox</h4>
            <button id="backbtn" type="button" class="btn-success btn-lg">
                Go Back
            </button>

            <script type="text/javascript">
                $("#backbtn").click(function(){
                    window.history.go(-1);
                });
            </script>
        <?php endif;?>
        <!-- end of if msgs-->
        </div>
        <div class="col-md-6">

        </div>
        <!-- end of in2 div6-->
    </div>
    <!-- end of row-->
</div>
<!--end of divsix orig-->
<div class="col-md-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>
</div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
</body>
</html>