<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php'?>

<div class="container-fluid">
    <div class="row">
        <?php if(isset($title)){
            echo "<h4 class='text-capitalize text-center'>".$title."</h4>";
        }?>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-12">
                    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>
                </div>
            </div>
        </div>

        <div class='col-sm-6'>

            <?php if(!empty($articles)):?>
            <div class="row" style="border: 30px solid #224422;">
                <div>
                        <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/api/includes/htmlpages/pagination.html.php"; ?>
                </div>

                    <?php foreach($articles as $p):?>
                        <div style="border-bottom: 1px solid green; margin: 10px; ">
                            <?php if(empty($p['categoryname'])):?>
                                <span style="background: green; padding: 5px;">Poats</span>
                            <?php else:?>
                                <span style="background: green; padding: 5px;"><?php echo $p["categoryname"];?>"</span>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty($p["articleimagedisplayname"])):?>
                            <div>
                                <img src="<?php echo $p["articleimagedisplayname"];?>" alt="" style="float: left;
                    width: 80px; height: 80px; margin: 10px;">
                            </div>
                        <?php endif;?>
                        <div>
                            <h5>
                                <a href="/api/product/?gpid=<?php echo $p[0];?>">
                                    <?php echo $p["title"];?>
                                </a>
                            </h5>
                            <h6>
                                &nbsp; <span class="glyphicon glyphicon-comment"></span> <?php echo $p["noofcomments"];?>
                                &nbsp; Views: <?php echo $p["noofviews"];?>

                            </h6>
                        </div>

                        <div style="clear: both"></div>
                        <br><br>
                    <?php endforeach; ?>
            </div>
            <?php else: ?>
                    <div class="row">
                        <h4 class="text-center text-capitalize">
                            No Articles yet or it's not sanctioed yet.
                        </h4>
                    </div>
            <?php endif; ?>
            <div class="row" style="border: 15px solid #224422;">
                <h5 class="text-center text-capitalize">
                    <?php if(isset($error)){
                        echo $error;
                    }?>
                </h5>
            </div>
            <div>
                <div style="margin: 10px;">
                    <button id="backbtn" type="button" class="btn" style="border: 10px solid #224422; border-radius: 50%; background: transparent;">
                        <b> Hit <br>Back!</b>
                    </button>
                </div>
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
<script type="text/javascript">
    $("#backbtn").click(function(){
        window.history.go(-1);
    })
</script>

<?php include $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php'?>
</body>
</html>