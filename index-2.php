<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";
$articles_1 = $headarticle->getarticlesByCategory(1,4,0);
$articles_2 = $headarticle->getarticlesByCategory(2,4,0);
$articles_3 = $headarticle->getarticlesByCategory(3,4,0);
$articles_4 = $headarticle->getarticlesByCategory(4,4,0);
?>

<div class="banner">
    <div class="container">
        <h2 class="secondary-color">Kpakpando Media brings up the light from the deeps of the rural communities</h2>
        <p class="secondary-color">We are committed to throwing up the veils on what live and greatness
            is in our rural community. Showcasing the beauty and affairs of the people</p>
        <!--<a href="singlepage.html">READ MORE</a>-->
    </div>
</div>

<div class="services w3l wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
    <div class="container-fluid" style="background: url(img/banner-1.jpg) 100% 100% fixed no-repeat;">

        <br>
        <!--add adverts-->
        <div>
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/ad-top.html.php'; ?>
        </div>
        <br>

        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center text-capitalize">Our Portfolio / Diversity </h3>
            </div>
        </div>
        <div class="grid_3 grid_5">
            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#expeditions" id="expeditions-tab" role="tab" data-toggle="tab" aria-controls="expeditions" aria-expanded="true">Radio</a></li>
                    <li role="presentation" class=""><a href="#safari" role="tab" id="safari-tab" data-toggle="tab" aria-controls="safari">Print</a></li>
                    <li role="presentation" class=""><a href="#trekking" role="tab" id="trekking-tab" data-toggle="tab" aria-controls="trekking">TV</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade fade active in" id="expeditions" aria-labelledby="expeditions-tab">
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="/api/img/kpakpandomediapictures/mrs-okechukwu.jpg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="/api/img/kpakpandomediapictures/banner-studio-with-tv.jpg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="/api/img/kpakpandomediapictures/banner-in-studio.jpg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="clearfix"></div>
                    </div>


                    <div role="tabpanel" class="tab-pane fade" id="safari" aria-labelledby="safari-tab">
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="img/kpakpandomediapictures/kp-newpaper.jpg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="img/kpakpandomediapictures/kp-newpaper.jpg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="img/kpakpandomediapictures/kp-newpaper.jpg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="clearfix"></div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="trekking" aria-labelledby="trekking-tab">
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="/api/img/site-imgs/african-dance.jpeg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="/api/img/site-imgs/african-dance.jpeg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="col-md-4 col-sm-5 tab-image">
                                <img src="/api/img/site-imgs/african-dance.jpeg" class="img-responsive" alt="Wanderer">
                            </div>
                            <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- technology-left -->
<div class="technology">
<div class="container">
<div class="col-md-9 technology-left">
    <div class="tech-no">
        <!-- technology-top -->
        <div class="tc-ch wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
            <div class="tch-img">
                <a href="/api/article/index.php?gabc&cid=2"><img src="img/site-imgs/centered-sun-dark.jpg" class="img-responsive" alt="kpakpando Media Activities"></a>
            </div>

            <h3><a href=""> Kpakpando Media</a></h3>
            <h6><a href=""></a><?php echo(date("Y M d, l h:i:s a"));?>.</h6>
            <p>Kpakpando Media is here to promote life and light out of our rural communities</p>
            <p>There is a story yet untold, Life and Light in the rurals remain largely under-showcased or reported
            All the beauties, the traditions, the politics, the creativities and the people remain beneath the cameras
            of urban media. This is what <b>KPAKPANDO MEDIA</b> stands for</p>
            <div class="bht1">
                <a href="/api/about.html.php">Continue Reading</a>
            </div>
            <div class="soci">
                <ul>
                    <li class="hvr-rectangle-out"><a class="fb" href="#"></a></li>
                    <li class="hvr-rectangle-out"><a class="twit" href="#"></a></li>
                    <li class="hvr-rectangle-out"><a class="goog" href="#"></a></li>
                    <li class="hvr-rectangle-out"><a class="pin" href="#"></a></li>
                    <li class="hvr-rectangle-out"><a class="drib" href="#"></a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <!-- technology-top -->

        <!--first of articles-->
        <?php if(!empty($articles_2)):?>
        <a href="/api/article/index.php?gabc&cid=<?php echo($articles_2[0]['categoryid']);?>" class="btn btn-info btn-lg btn-block">
            <?php echo($articles_2[0]["categoryname"]);?>
        </a>
        <div class="wthree">

        <?php foreach($articles_2 as $art_2):?>

                    <div class="col-md-6 wthree-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                        <div class="tch-img">
                            <a href=""><img src="<?php echo($art_2['articleimagedisplayname']);?>" class="img-responsive" alt="image on <?php echo($art_2['title']);?>"></a>
                        </div>
                    </div>
                    <div class="col-md-6 wthree-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                        <h3><a href="/api/article/index.php?gaid=<?php echo($art_2[0]);?>">
                                <?php echo($art_2['title']);?></a></h3>
                        <h6>BY <a href="/api/user/index.php?guid=<?php echo($art_2['userid']); ?>">  <?php echo($art_2['firstname']);?></a>  <?php echo(date("M d, l h:i a", strtotime($art_2['dateofpublication'])));?>.</h6>
                        <p><?php echo($art_2['title']);?> </p>
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
                    <div class="clearfix"></div><br><br>
                <?php endforeach;?>
        </div>
        <?php endif; ?>


        <!-- second -->
        <?php if(!empty($articles_1)):?>
        <a href="/api/article/index.php?gabc&cid=<?php echo($articles_1[0]['categoryid']);?>" class="btn btn-info btn-lg btn-block">
            <?php echo($articles_1[0]["categoryname"]);?>
        </a>
        <div class="w3ls">
            <?php foreach(array_chunk($articles_1,2) as $activitys):?>
            <div class="col-md-6 w3ls-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                <?php foreach($activitys as $activity):?>
                <div class="tc-ch">
                    <div class="tch-img">
                        <a href="/api/article/index.php?gaid=<?php echo($activity[0]);?>">
                            <img src="<?php echo($activity['articleimagedisplayname']);?>" class="img-responsive" alt=""></a>
                    </div>

                    <h3><a href="/api/article/index.php?gaid=<?php echo($activity[0]);?>">
                            <?php echo($activity['title']);?></a></h3>
                    <h6>BY <a href="/api/user/index.php?guid=<?php echo($activity['userid']);?>">
                            <?php echo($activity['firstname']);?></a>   <?php echo(date("Y M d, l h:i:s a", strtotime($activity['dateofpublication'])));?></h6>
                    <p></p>
                    <!--<div class="bht1">
                        <a href="/api/article/index.php?gaid=<?php /*echo($activity['articleid']);*/?>">Read More</a>
                    </div>-->
                    <div class="soci">
                        <ul>
                            <li class="hvr-rectangle-out"><a class="fb" href="#"></a></li>
                            <li class="hvr-rectangle-out"><a class="pin" href="#"></a></li>
                        </ul>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach?>
        </div>
        <div class="clearfix"></div>
        <?php endif; ?>



        <!-- third  -->
        <?php if(!empty($articles_3)):?>
        <a href="/api/article/index.php?gabc&cid=<?php echo($articles_3[0]['categoryid']);?>">
            <h3 class="btn btn-warning"><?php echo($articles_3[0]['categoryname']);?></h3>
        </a>
        <div class="wthree">

        <?php foreach($articles_3 as $art_2):?>

                    <div class="col-md-6 wthree-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                        <div class="tch-img">
                            <a href=""><img src="<?php echo($art_2['articleimagedisplayname']);?>" class="img-responsive" alt="image on <?php echo($art_2['title']);?>"></a>
                        </div>
                    </div>
                    <div class="col-md-6 wthree-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                        <h3><a href="/api/article/index.php?gaid=<?php echo($art_2[0]);?>">
                                <?php echo($art_2['title']);?></a></h3>
                        <h6>BY <a href="/api/user/index.php?guid=<?php echo($art_2['userid']); ?>">  <?php echo($art_2['firstname']);?></a>  <?php echo(date("M d, l h:i a", strtotime($art_2['dateofpublication'])));?>.</h6>
                        <p><?php echo($art_2['title']);?> </p>
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
        </div>
        <?php endif; ?>


        <!--fourth articles-->
        <?php if(!empty($articles_4)):?>
        <a href="/api/article/index.php?gabc&cid=<?php echo($articles_4[0]['categoryid']);?>" class="btn btn-lg btn-info btn-block">
            <?php echo($articles_4[0]['categoryname']);?>
        </a>
        <div class="wthree">

        <?php foreach($articles_4 as $art_2):?>

                    <div class="col-md-6 wthree-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                        <div class="tch-img">
                            <a href=""><img src="<?php echo($art_2['articleimagedisplayname']);?>" class="img-responsive" alt="image on <?php echo($art_2['title']);?>"></a>
                        </div>
                    </div>
                    <div class="col-md-6 wthree-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                        <h3><a href="/api/article/index.php?gaid=<?php echo($art_2[0]);?>">
                                <?php echo($art_2['title']);?></a></h3>
                        <h6>BY <a href="/api/user/index.php?guid=<?php echo($art_2['userid']); ?>"><?php echo($art_2['firstname']);?></a>  <?php echo(date("M d, l h:i a", strtotime($art_2['dateofpublication'])));?>.</h6>
                        <p><?php echo($art_2['title']);?> </p>
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
            </div>
        <?php endif; ?>

    </div>
</div>


<!-- technology-right -->
<div class="col-md-3 technology-right">
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php'; ?>

</div>
<div class="clearfix"></div>
<!-- technology-right -->
</div>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] ."/api/inc/footer2.html.php"; ?>