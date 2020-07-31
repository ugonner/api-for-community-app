
<?php
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
                    <h1 class="text-center">Admin Post Pad</h1>
                </div>
                <h2 class="text-center"> Hi ADMIN! Welcome To Desk <a href="/api/user/registration.html.php">
                        <small>Not Registered? REGISTER With Us Here</small></a> Otherwise Post Below</h2>
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
                            <input id="title" type="text" class="form-control" name="title"
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
                            <textarea style="height: 250px;" id="elm1" class="form-control" name="detail">
<?php if(isset($_POST["detail"])){echo $_POST["detail"];}?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="cid">Select a Category <b>(important)</b></label>
                            <select name="cid" id="cid" class="form-control">
                                <?php foreach($headcategories as $c):?>
                                <option value="<?php echo $c[0];?>"><?php echo $c[1];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <label for="clusterid">Select Target Cluster <b>(important)</b></label>
                            <select name="clusterid" id="clusterid" class="form-control">
                                <option value="">Select Target Cluster</option>
                                <?php foreach($head_clusters as $hcl):?>
                                    <option value="<?php echo $hcl[0];?>"><?php echo $hcl[1];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <?php require_once $_SERVER['DOCUMENT_ROOT'].'/api/group/group.class.php';
                        $group = new Group();
                    $grouplevel1s = $group->getGroupLevel1s();
                    $grouplevel2s = $group->getGroupLevel2s();
                    $grouplevel3s = $group->getGroupLevel3s();
                    $countgroup1 = count($grouplevel1s);
                    $countgroup2 = count($grouplevel2s);
                    $countgroup3 = count($grouplevel3s);
                    ?>

                    <div class="form-group">
                        <input type="hidden" name="countgrouplevel1s" value="<?php echo($countgroup1); ?>" />
                        <input type="hidden" name="countgrouplevel2s" value="<?php echo($countgroup2); ?>" />
                        <input type="hidden" name="countgrouplevel3s" value="<?php echo($countgroup3); ?>" />
                    </div>

                    <div class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#grp1div">
                        Associate Post To Wards
                    </div>
                    <div class="form-group collapse" id="grp1div">
                        <label class="page-header" for="grouplevel1">Concerned Ward</label>
                        <br>
                        <?php for($g1=0; $g1<$countgroup1; $g1++):?>
                            <input type="checkbox" name="grouplevel1id<?php echo($g1);?>" value="<?php echo($grouplevel1s[$g1]['id']); ?>" id="grouplevel1"> <?php echo($grouplevel1s[$g1]['name']);?>
                            <br><br/>
                        <?php endfor; ?>
                    </div>

                    <div class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#grp2div">
                        Associate Post To Kindreds / Villages
                    </div>
                    <div class="form-group collapse" id="grp2div">
                        <label class="page-header" for="grouplevel1">Concerned Village</label>
                        <br>
                        <?php for($g2=0; $g2<$countgroup2; $g2++):?>
                            <input type="checkbox" name="grouplevel2id<?php echo($g2);?>" value="<?php echo($grouplevel2s[$g2]['id']); ?>" id="grouplevel1"> <?php echo($grouplevel2s[$g2]['name']);?>
                            <br><br/>
                        <?php endfor; ?>
                    </div>


                    <div class="btn btn-block btn-lg btn-primary" data-toggle="collapse" data-target="#grp3div">
                        Associate News To Families
                    </div>
                    <div class="form-group collapse" id="grp3div">
                        <label class="page-header" for="grouplevel1">Concerned Kindred</label>
                        <br>
                        <?php for($g3=0; $g3<$countgroup3; $g3++):?>
                            <input type="checkbox" name="grouplevel3id<?php echo($g3);?>" value="<?php echo($grouplevel3s[$g3]['id']); ?>" id="grouplevel1"> <?php echo($grouplevel3s[$g3]['name']);?>
                            <br><br/>
                        <?php endfor; ?>
                    </div>




                    <div class="form-group">
                        <div>
                            <label for="faid">Select a focal area <b>(important)</b></label>
                            <select name="faid" id="faid" class="form-control">
                                <option value="">Select Target Area</option>
                                <?php foreach($headfocalareas as $fa):?>
                                <option value="<?php echo $fa[0];?>"><?php echo $fa[1];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <br><br>&nbsp;
                    <?php if(isset($_POST["editarticle"])):?>

                        <h4 class="text-center">Additional Files For Your Post</h4>
                    <div class="form-group">
                        <label for="articlefile1caption">Caption For File</label>
                        <div class="input-group">
                            <input id="articlefile1caption" type="text"  class="input-lg form-control" name="articlefile1caption" placeholder="File Caption"/>
                        </div>
                        <label for="articlefile1">Not More Than 256KB</label>
                        <div class="input-group">
                            <input id="articlefile1" type="file"  name="articlefile1"/>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <label for="articlefile2caption">Caption For File</label>
                        <div class="input-group">
                            <input id="articlefile2caption" type="text"  class="input-lg form-control" name="articlefile2caption" placeholder="File Caption"/>
                        </div>
                        <label for="articlefile2">Not More Than 256KB</label>
                        <div class="input-group">
                            <input id="articlefile2" class="input-lg form-control" type="file"  name="articlefile2"/>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <label for="articlefile3caption">Caption For File</label>
                        <div class="input-group">
                            <input id="articlefile3caption" type="text"  class="input-lg form-control" name="articlefile3caption" placeholder="File Caption"/>
                        </div>
                        <label for="articlefile3">Not More Than 256KB</label>
                        <div class="input-group">
                            <input id="articlefile3" type="file" name="articlefile3"/>
                        </div>
                    </div><br>
                    <div class="form-group">
                        <label for="articlefile4caption">Caption For File</label>
                        <div class="input-group">
                            <input id="articlefile4caption" type="text" class="input-lg form-control" name="articlefile4caption" placeholder="File Caption"/>
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
            <?php /*include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';*/?>

        </div>
    </div>
</div>
<script type="text/javascript">
    $("#backbtn").click(function(){
        window.history.go(-1);
    })
</script>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/footer2.html.php';?>
