<?php
 include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/htmler.php';
 require_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/advert.class.php';
 include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';
?>
<div class="container-fluid" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-sm-12 text-center text-capitalize">
            <h5>
                <?php if(isset($_GET["output"]) || (!empty($output))){
                    $outputtext = (!empty($_GET["output"])? $_GET["output"]: $output);
                    echo $outputtext;
                }?>
            </h5>

            <h1>
            <?php if(isset($title)){echo $title; }?>
                <?php if(!empty($category)):?>
                <h5><?php echo $category['categorynote']; ?></h5>
                <?php endif;?>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <?php if(!empty($category)):?>
            <?php
            require_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";
            $admin = new admin();
            if(!isset($_SESSION)){
                session_start();
            }
            if(isset($_SESSION['userid']) && $admin->isAdmin($_SESSION["userid"])):?>
                <div>
                    <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                            data-target="#ACdiv">
                        Edit Article Category
                    </button>
                    <div class="collapse" id="ACdiv">
                        <h5> Click Edit Category</h5>
                        <div class="form-group">
                            <form class="form-group" action="/api/admin/index.php"
                                  method="post">
                                <div class="form-group">
                                    <label for="categoryname">Category Name</label>
                                    <input type="text" name="categoryname" id="categoryname" class="form-control"
                                           placeholder="New Category Name" value="<?php echo $category['categoryname']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="categorynote">Category Brief</label>
                                    <textarea name="categorynote" id="categoryname" class="form-control">
                                        <?php echo $category['categorynote']; ?>
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="parent_categoryid">Parent Category (If any?)</label>
                                    <select name="parent_categoryid" id="parent_categoryid" class="input-lg">
                                        <option value="">Select Parent Category</option>
                                        <?php foreach($head_all_categories as $headcat):?>
                                            <option value="<?php echo($headcat[0]);?>"><?php echo($headcat[1]);?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div>
                                    <input type="hidden" name="categoryid" value="<?php echo $category['categoryid']; ?>">
                                    <input type="hidden" name="oldparent_categoryid" value="<?php echo $category['parentcategoryid']; ?>">
                                </div>
                                <button type="submit" class="btn btn-success form-control" name="editcategory">
                                    Save Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>


<br>
<div class="container">
    <?php /*require_once $_SERVER['DOCUMENT_ROOT']."/api/advert/ad-top-cat.html.php"; */?>
    <div class="row">
        <div class="col-sm-3">
            <?php if(!empty($category)):?>
            <?php
            //get or sorting categories subcategories;
            for($i=0; $i<count($headcategories); $i++){
                if($category['categoryid'] == $headcategories[$i]['id']){
                    if(!empty($headcategories[$i]["subcategories"])){
                        $art_sub_categories[]= $headcategories[$i]["subcategories"];
                    }
                }
            }?>
            <?php if(!empty($art_sub_categories)):?>
                <?php  foreach($art_sub_categories as $sub_sc):?>
                    <?php foreach($sub_sc as $sc):?>
                        <a class="btn btn-lg btn-block btn-info" href="/api/article/?gabc&cid=<?php echo $sc['categoryid']; ?>">
                            <?php echo $sc["name"]; ?>
                        </a>
                    <?php endforeach;?>
                <?php endforeach;?>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-6">

            <div class="wthree">
                <?php if(!empty($articles)):?>
                    <?php foreach($articles as $art_2):?>

                        <div class="col-md-6 wthree-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                            <div class="tch-img">
                                <a href=""><img src="<?php echo($art_2['articleimagedisplayname']);?>" class="img-responsive" alt="image on <?php echo($art_2['title']);?>"></a>
                            </div>
                        </div>
                        <div class="col-md-6 wthree-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                            <h3><a href="/api/article/index.php?gaid=<?php echo($art_2[0]);?>">
                                    <?php echo($art_2['title']);?></a></h3>
                            <h6>BY <a href="/api/user/index.php?guid=<?php echo($art_2['userid']); ?>">  <?php echo($art_2['firstname']);?></a>  <?php echo(date("M d, l h:i a", strtotime($art_2['dateofpublication'])));?>.</h6>
                            <h6 class="text-right">
                                &nbsp;<span class="glyphicon glyphicon-eye-open"></span> <?php echo($art_2['noofviews']);?>
                                &nbsp;<span class="glyphicon glyphicon-thumbs-up"></span> <?php echo($art_2['nooffollows']);?>
                                &nbsp;<span class="glyphicon glyphicon-comment"></span> <?php echo($art_2['noofcomments']);?>
                            </h6>

                            <div class="bht1">
                                <a href="/api/article/index.php?gaid=<?php echo($art_2[0]);?>">Read More</a>
                            </div>
                            <div class="soci">
                                <ul>

                                    <li class="hvr-rectangle-out"><a class="twit" href="#"></a></li>
                                    <li class="hvr-rectangle-out"><a class="pin" href="#"></a></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <div class="clearfix"></div>
                    <?php endforeach;?>
                    <div>
                        <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/api/includes/htmlpages/pagination.html.php"; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>

<?php if((empty($category['categoryid'])) || ($category['categoryid'] == 2)): ?>

<?php else:?>
    <div>
        <a href="/api/article/articleform.html.php?cid=<?php echo $category["categoryid"];?>&categoryname=<?php echo $category["categoryname"];?>">
            <button type="button" class="btn-success btn-lg">
                Post Article In This Category
            </button>
        </a>
    </div>
<?php endif; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
