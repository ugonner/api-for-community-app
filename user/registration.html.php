<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';?>
<?php
$sql = "SELECT id,name FROM location ";
try{
    $regdb = new Dbconn();
    $stmt = $regdb->dbcon->prepare($sql);
    $stmt ->execute();
    $locations = $stmt->fetchAll();
}catch(PDOException $e){
    $error= "unable to get locations";
    $error2 = $e->getMessage();
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
    exit;
}
?>
<?php
$sql = "SELECT id,name FROM grouplevel1 ";
try{
    $regdb = new Dbconn();
    $stmt = $regdb->dbcon->prepare($sql);
    $stmt ->execute();
    $locations = $stmt->fetchAll();
}catch(PDOException $e){
    $error= "unable to get grouplevel1";
    $error2 = $e->getMessage();
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
    exit;
}
?>

<div class="container-fluid">
    <div class="col-sm-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

    </div>
    <div class="col-sm-6">
        <div class="row">
            <h2>Welcome To Kpakpando Media Group! ...<small><i><b>Happy Family</b></i></small></h2>
               <h4>SIGN UP WITH US HERE</h4>
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
            <form action="/api/user/index2.php" method="post">
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
                    <label for="password" id="pwd-label">Passeord</label>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div>
                    <!-- show password
                    <script type="text/javascript">
                        var pwd = document.getElementById("password");
                        var pwd_label =  document.getElementById("pwd-label");
                        function showPassword(){
                            pwd_label.innerHTML = pwd.value;
                        }
                    </script>-->
                </div>
                    <div class="form-group">
                        <label for="password2">Confirm Password</label>
                        <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password2" type="password" class="form-control" name="password2"
                           placeholder="Re-enter Password">
                </div>
                </div>

                <div class="form-group">
                    <label for="firstname">Name</label>
                    <input id="firstname" type="text" class="form-control"
                           name="firstname" placeholder="fullname"
                           value="<?php if(isset($_POST['firstname'])){
                               echo $_POST['firstname'];
                           }?>">
                </div>


                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input id="mobile" type="tel" class="form-control"
                               name="mobile" placeholder="0800123456"
                               value="<?php if(isset($_POST['mobile'])){
                                   echo $_POST['mobile'];
                               }?>">
                </div>
                

                    <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="public">Do You Allow Your Mobile Visible To Others?</label>
                            <div class="input-group">
                        <span>Na! I Don't Want People To View My Mobile In This Site.
                        <input id="public" type="checkbox"
                               name="public" value="N"></span>
                            </div>
                        </div>
                    </div>


                <div class="col-sm-6">
                <div class="dropdown-toggle" data-toggle="collapse" data-target="#zipdiv">
                <div class="form-group">
                    <label for="foreigner">Do You Reside Outside Nigeria?</label>
                    <div class="input-group">
                        <span>Ya! I live Outside Nigeria
                        <input id="foreigner" type="checkbox"
                               name="foreigner" value="Y"></span>
                    </div>
                </div>
                </div>
                    <div class="collapse" id="zipdiv">
                        <div class="form-group">
                            <label for="zip">Zipcode</label>
                            <div class="input-group">
                                <input id="zip" type="number" class="form-control"
                                       name="zip" placeholder="+001"
                                       value="<?php if(isset($_POST['zip'])){
                                           echo $_POST['zip'];
                                       }?>">
                            </div>
                        </div>

                    </div>
                </div>
                </div>


                <div class="form-group">
                    <div class="input-group">
                        <div class="form-group">
                            <label for="firstname">By signing up I agree with the
                            THE TERMS AND CONDITIONS of this organisation</label>
                            <button class="btn btn-block btn-lg" type="submit" name="register" style='background: transparent;'>
                                Sign Me Up
                            </button>
                                   
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>


    </div>
    <div class="col-sm-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>
    </div>
</div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
<script type="text/javascript">
    $("#locationselectrg").change(function(){displaysublocationsrg()});
    function displaysublocationsrg(){
        var sid = document.getElementById('locationselectrg')
            .options[document.getElementById('locationselectrg').selectedIndex].value;
        $.get('/api/location/index.php?get_sublocations&locationid='+sid, function(responseText) {
            $("#sublocationselectrg").empty();
            $("#sublocationselectrg").append(responseText);
        });
    }

</script>
</body>
</html>