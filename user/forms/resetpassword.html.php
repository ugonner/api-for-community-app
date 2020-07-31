<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<div class="container-fluid">
        <div class="col-sm-3">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

        </div>
        <div class="col-sm-6">
            <div class="row">
                <h2 class="text-center"> RESET YOUR PASSWORD HERE  <a href="/api/user/registration.html.php">
                        <small>REGISTER HERE</small></a> WITH US DOWN HERE</h2>
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
                        <label for="oldpassword">Old Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="oldpassword" type="password" class="form-control" name="oldpassword" placeholder="Your Email"
                                   value="<?php if(isset($_POST['oldpassword'])){
                                       echo $_POST['oldpassword'];
                                   }?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Nev Passeord</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">ReEnter Nev Passeord</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password2" type="password" class="form-control" name="password2" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn-block btn-lg btn-success" name="resetpassword" type="submit">
                            RESET PASSWORD
                        </button>
                    </div>
                </form>
                </div>
                <div class="form-group">
                    <p> Forgot Password<span class="badge">?</span>
                        <a href="/api/user/forms/recoverpassword.html.php">
                            <button class="btn-lg btn-success" name="enter" type="submit">
                                Click Here
                            </button>
                        </a>
                    </p>
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