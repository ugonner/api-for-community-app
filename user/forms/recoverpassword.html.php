<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<div class="container-fluid">
        <div class="col-sm-3">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

        </div>
        <div class="col-sm-6">
            <div class="row">
                <h2 class="text-center"> RECOVER PASSWORD DOWN HERE</h2>
                <h5 class="text-capitalize">An email will be sent to the email you registered
                with us here. so visit your mail box or spam and click on the recovery link</h5>
            </div>

            <div class="row">
                <?php if(isset($_GET["output"])){
                    $output = $_GET["output"];
                    echo "<h4 class='text-center'>".$output."</h4>";
                }
                if(isset($error)){
                    $output = $error;
                    echo "<h4 class='text-center'>".$output."</h4>";
                }?>
                <div style="padding: 30px;">
                <form action="/api/user/index.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="email" class="form-control" name="email" placeholder="Your Email"
                                   value="<?php if(isset($_POST['email'])){
                                       echo $_POST['email'];
                                   }?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn-block btn-lg btn-success" name="recoverpassword" type="submit">
                            RECOVER MY PASSWORD
                        </button>
                    </div>
                </form>
                </div>

            </div>


        </div>
        <div class="col-sm-3">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>

        </div>
    </div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
</body>
</html>