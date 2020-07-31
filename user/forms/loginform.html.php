<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<div class="container-fluid">
<div class="col-sm-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

</div>
<div class="col-sm-6">
<div class="row">
    <h2 class="text-center"> SIGN IN OR <a href="/api/user/registration.html.php">
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
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/user/facebookloginbtn.html.php';?>
<div style="padding: 30px;">
<form action="/api/user/" method="POST" class="form-group">
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
    <label for="password">Passeord</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
    </div>
</div>
<div class="form-group">
    <button class="btn-block btn-lg btn-success" name="enter" type="submit">
        SIGN IN
    </button>
</div>
</form>
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


</div>
<div class="col-sm-3">
    <div class="row">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>
    </div>
</div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
</body>
</html>