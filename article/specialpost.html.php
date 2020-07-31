<?php

//login;
include_once $_SERVER['DOCUMENT_ROOT'].'/api/admin/admin.class.php';
if(!isset($_SESSION)){
    session_start();
}
$uid = (empty($_SESSION["userid"])? 0 : $_SESSION["userid"]);
$admin= new admin();
if($admin->isAdmin($uid)){
    $isadmin = true;
}else{
    $error="Please Login First as an ADMIN With Correct Email And Password Pair";
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/loginform.html.php";
    exit;
}
if(isset($_POST["cid"])){
    $cid = $_POST["cid"];
}
if(isset($_GET["cid"])){
    $cid = $_GET["cid"];
}

include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';

?>

<div class="container-fluid">
    <div class="container">
        <div class="col-sm-3">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="page-header">
                    <h1 class="text-center">Admin Special / Activity Post Pad</h1>
                </div>
                <h2 class="text-center"> Hi ADMIN! Welcome To Desk</h2>
            </div>

            <div class="row">
                <?php if(isset($_GET["output"]) OR isset($error)){
                    $output = $_GET["output"] OR $error;
                    echo "<h4 class='text-center'>".$output."</h4>";
                }?>
                <?php if(isset($_GET["categoryname"])){
                    $category = $_GET["categoryname"];
                    echo "<h4 class='text-center'> <B> CATEGORY: </N>".$category."</h4>";
                }?>
            </div>
            <div class="row">
                <div class="form-group">
                    <form action="/api/article/index.php" method="post"
                          enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                <input id="title" type="text" class="form-control input-lg" name="title"
                                       placeholder="Your Title"
                                       value="<?php if(isset($_POST['title'])){
                                           echo $_POST['title'];
                                       }?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aidn">Image For Your Write-Up</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-camera"></i></span>
                                <input id="aidn" type="file" name="aidn"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="elm1">Detail Of Your Post</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                <textarea  style="height: 250px;" id="elm1" class="form-control" name="detail">
                                    <?php if(isset($_POST["detail"])){echo $_POST["detail"];}?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="cid" value="2" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="faid">Select a focal area <b>(important)</b></label>
                                <select name="faid" id="faid" class="form-control input-lg">
                                    <?php foreach($headfocalareas as $fa):?>
                                        <option value="<?php echo $fa[0];?>"><?php echo $fa[1];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div><br><br>&nbsp;
                        <?php if(isset($_POST["editarticle"])):?>

                            <h4 class="text-center">Additional Files For Your Post</h4>
                            <div class="form-group">
                                <label for="articlefile1caption">Caption For File</label>
                                <div class="input-group">
                                    <input id="articlefile1caption" type="text"  name="articlefile1caption" placeholder="File Caption"/>
                                </div>
                                <label for="articlefile1">Not More Than 256KB</label>
                                <div class="input-group">
                                    <input id="articlefile1" type="file"  name="articlefile1"/>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="articlefile2caption">Caption For File</label>
                                <div class="input-group">
                                    <input id="articlefile2caption" type="text"  name="articlefile2caption" placeholder="File Caption"/>
                                </div>
                                <label for="articlefile2">Not More Than 256KB</label>
                                <div class="input-group">
                                    <input id="articlefile2" type="file"  name="articlefile2"/>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="articlefile3caption">Caption For File</label>
                                <div class="input-group">
                                    <input id="articlefile3caption" type="text"  name="articlefile3caption" placeholder="File Caption"/>
                                </div>
                                <label for="articlefile3">Not More Than 256KB</label>
                                <div class="input-group">
                                    <input id="articlefile3" type="file" name="articlefile3"/>
                                </div>
                            </div><br>
                            <div class="form-group">
                                <label for="articlefile4caption">Caption For File</label>
                                <div class="input-group">
                                    <input id="articlefile4caption" type="text"  name="articlefile4caption" placeholder="File Caption"/>
                                </div>
                                <label for="articlefile4">Not More Than 256KB</label>
                                <div class="input-group">
                                    <input id="articlefile4" type="file" name="articlefile4"/>
                                </div>
                            </div>
                            <input type="hidden" name="aid" value="<?php echo $_POST["aid"];?>"/>
                            <input type="hidden" name="artfile" value="<?php echo $_POST["aidn"];?>"/>
                            <input type="hidden" name="uid" value="<?php echo $_POST["uid"];?>"/>

                            <div class="form-group">
                                <button class="btn-block btn-success btn-lg" name="editarticle" type="submit">
                                    Save Edited
                                </button>
                            </div>
                        <?php else:?>
                            <div class="form-group">
                                <button class="btn-success btn-block btn-lg" name="addarticle" type="submit">
                                    Post Article
                                </button>
                            </div>
                        <?php endif;?>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-sm-3">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>

        </div>
    </div>
</div>
<script type="text/javascript">
    $("#backbtn").click(function(){
        window.history.go(-1);
    })
</script>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/footer2.html.php';?>
