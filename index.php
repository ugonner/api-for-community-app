<?php
$title = "The Official site of the Joint Association of Persons With Disabilities (JONAPWD) Anambra state chapter";
$description = "The Joint Association of Persons With Disabilities is the umbrella body covering all other sub-groups /
clusters of Persons With Disabilities, including; Association Of the Deaf, Association of the Blind and Association of Persons With Physically Challenged.
 JONAPWD provides for coherence by cordinating all projects and programs for
Persons With Disabilities and providing synergy in the efforts by all stakeholders / external partners in the affairs of
 disability community in state-wide programs at the state level. This page keeps updates on JONAPWD Anambra State";
require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/api/donation/donation.class.php";

$articles = $headarticle->getPublishedArticles("id",20,0);

$articles_1 = $headarticle->getarticlesByCategory(1,4,0);
$articles_2 = $headarticle->getarticlesByCategory(2,4,0);
$articles_3 = $headarticle->getarticlesByCategory(3,4,0);
$articles_4 = $headarticle->getarticlesByCategory(4,4,0);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <!--dyna text up-dwon-->
            <script type="text/javascript">

                //new pausescroller(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds)

                new pausescroller(pausecontent, "pscroller1", "someclass", 3000)
                document.write("<br />")

            </script>
            <!--end up-down dyna-->

        </div>
        <div class="col-sm-6"></div>
    </div>
</div>

<div class="banner-jonapwd">
    <!-- start slider -->
    <div id="fwslider">
        <div class="slider_container">
            <div class="slide">
                <!-- Slide image -->
                <img src="/api/img/banner-1.jpg" style="width: 100%; height: 748px;" alt=""/>
                <!-- /Slide image -->
                <!-- Texts container -->
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <!-- Text title -->
                        <h3 class="title">JONAPWD Cares About Persons With Disability</h3>
                        <!-- /Text title -->
                    </div>
                </div>
                <!-- /Texts container -->
            </div>
            <!-- /Duplicate to create more slides -->
            <div class="slide">
                <img src="/api/img/banner-3.jpg" style="width: 100%; height: 748px;" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">JONAPWD cares for the rights of persons with Disability </h4>
                        <div class="button"><a href="#">-JONAPWD</a></div>
                    </div>
                </div>
            </div>
            <!--/slide -->
        </div>
        <div class="timers"></div>
        <div class="slidePrev"><span></span></div>
        <div class="slideNext"><span></span></div>
    </div>
    <!--/slider -->
</div>


<div class="main">
    <div class="content-top thumbnail">
        <h2>WHAT WE STAND FOR IN JONAPWD?</h2>
        <p>
            The Joint National Association of Persons With Disability (JONAPWD) seeks to disseminate timely and useful information, build capacity, provide social services, and
            conduct research that will enhance productivity and quality of life for Persons with Disability.
        </p><br><br><br>&nbsp;
    </div>

        <div class="row" style="background: url(/api/img/banner-4.jpg) no-repeat 100% 100%;">
            <div class="col-sm-6 doubledivs">
                <div class="content-top" style="color: cyan;">
                    <h2 style="color: red;">WHY JONAPWD WAS FORMED</h2>
                    <p class="m_1" style="color: cyan;">

                        Generally, the attitude of the public towards Persons with Disabilities (PWDs) has not
                        been very helpful to their development. Consequently, PWDs have found it very difficult
                        to make the kind of positive contributions they would have loved to make to societal
                        development. Public attitude towards PWDS are often negative, discriminatory,
                        condescending, and full of misconceptions that stem from lack of proper understanding
                        of persons with disabilities and issues that affect them. It is towards this end that
                        the Joint National Association of Persons with Disabilities (JONAPWD) Anambra state
                        chapter came into being

                    </p>

                    <a class="btn btn-lg btn-block btn-danger" href="/api/donation/makedonation.html.php">
                        Make Donation
                    </a>

                 </div>
            </div>
            <div class="col-sm-6 doubledivs">
                <h1 class="text-capitalize" style="font-family: 'Courier 10 Pitch', Courier, monospace;
                 text-align: center; font-size: 4em; font-weight: bolder; background: #222223; margin-top: 50px;">
                    friends let's join hands <br> and push further
                    <br> fight for one, fight for all
                </h1>
            </div>
        </div>


        <div class="close_but"><i class="close1"> </i></div>
        <div style="background: #000000;">
        <ul id="flexiselDemo3">
            <?php if(!empty($articles)):?>
                <?php for($a=0; $a<count($articles); $a++):?>
                    <li><a  href="/api/article/?gaid=<?php echo($articles[$a][0]);?>">
                            <img src="<?php echo($articles[$a]["articleimagedisplayname"]);?>"
                                 style="width: 100%; height: 170px;" />
                        </a></li>

                    <li>
                        <a  href="/api/article/?gaid=<?php echo($articles[$a][0]);?>">
                            <b style="text-align: left;">
                                <span class="">
                                <span class="btn glyphicon glyphicon-time"
                                      style="margin: 0;  background: brown;"></span>
                                    <?php $timestr = strtotime($articles[$a]["dateofpublication"]);?>
                                    <span class="btn" style="margin: 0; background: #000000;">
                                        <?php echo(date("M d, h:i a", $timestr));?> </span>
                                </span>
                              </b>
                              <h5 style="text-align: left; padding: 25px 25px 0 25px;"><?php echo($articles[$a]["title"]);?></h5>

                        </a>
                    </li>
                <?php endfor;?>
            <?php else:?>
                <li><a  href="/api/article/?gaid=1">
                        <img src="/api/img/banner-4.jpg" style="width: 100%; height: 250px;" /></a></li>
                <li><a href="/api/article/?gaid=1">
                        <div style="width: 100%; height: 250px;" >
                            <p>this is the head news</p>
                        </div></a></li>
                <li><a href="/api/article/?gaid=1">
                        <img src="/api/img/banner-3.jpg" style="width: 100%; height: 250px;" /></a></li>
                <li><a  href="/api/article/?gaid=1">
                        <img src="/api/img/banner-1.jpg"  style="width: 100%; height: 250px;" /></a></li>
                <li><a  href="/api/article/?gaid=1">
                        <img src="/api/img/f2.jpg" style="width: 100%; height: 250px;" /></a></li>
                <!--<li><img src="images/board5.jpg" /></li>-->
            <?php endif;?>
        </ul>
        </div>

    <h3></h3>
        <script type="text/javascript">
            $(window).load(function() {
                $("#flexiselDemo3").flexisel({
                    visibleItems: 6,
                    animationSpeed: 1500,
                    autoPlay: true,
                    autoPlaySpeed: 3000,
                    pauseOnHover: true,
                    enableResponsiveBreakpoints: true,
                    responsiveBreakpoints: {
                        portrait: {
                            changePoint:480,
                            visibleItems: 1
                        },
                        landscape: {
                            changePoint:640,
                            visibleItems: 2
                        },
                        tablet: {
                            changePoint:768,
                            visibleItems: 3
                        }
                    }
                });

            });
        </script>
        <script type="text/javascript" src="js/jquery.flexisel.js"></script>
    </div>
</div>

<div class="content-bottom">
    <div class="container">
        <div class="row content_bottom-text">
            <div class="col-md-7">
                <h3>JONAPWD<br>INTRODUCTION</h3>
                <p class="m_2">
                    JONAPWD is a not for profit and non-governmental organization formed in 2001 in Anambra State
                    but has been in existence in Nigeria since 1987. The Anambra State Chapter registered under
                    the CAC in 2008 with registration number 28709. The Association is being managed by persons
                    with disabilities with support from the Ministry of Women Affairs and Social Development.
                    It is an umbrella body that oversees the activities of all other cluster associations of
                    persons with disabilities in Anambra State. At present, JONAPWD in Anambra State consist of
                    six (6) cluster groups, namely:
                    <br><br>
                    &nbsp;&nbsp;&nbsp;<b>1.</b>The Association of the Physically Impaired
                    <br>&nbsp;&nbsp;&nbsp;<b>2.</b>	 The Association of the Visually impaired
                    <br>&nbsp;&nbsp;&nbsp;<b>3.</b>	 The Association of hearing and speech impaired
                    <br>&nbsp;&nbsp;&nbsp;<b>4.</b>  The Association of Spinal Cord Injuries
                    <br>&nbsp;&nbsp;&nbsp;<b>5.</b>  The Association of the down syndrome
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>   The Association of the Leprosy victims
                    <br><br><br>
                </p>
                <p class="m_2">

                    The Association offers humanitarian and social development services to persons with disabilities
                    and also provides a link between them and the larger society.
                </p>

                <br><br><br>&nbsp;
                <h3>THEMATIC<br> AREAS</h3>
                <p class="m_2 text-uppercase">
                    JONAPWD activities and programs are targeted towards the following thematic areas
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Accessibility
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Inclusion (fighting discrimination)
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Job creation
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Legislation
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Promoting Networking of PWDs
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Social empowerment
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Economic empowerment
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Political empowerment
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>	   Personal development
                    <br>&nbsp;&nbsp;&nbsp;<b>6.</b>    Awareness creation and sensitization on disability issues

                </p>

                <br><br><a href="/api/aims.html.php" class="btn btn-primary btn-lg btn-block">Read All</a>

            </div>
            <!--<div class="col-md-5">
                <img src="images/mission.jpg" style="width: 100%; height: 100%;">
            </div>-->
        </div>
    </div>
</div>

<div class="features">
    <div class="container">
        <h3 class="m_3 text-danger">Featured news</h3>
        <div class="close_but"><i class="close1"> </i></div>
        <div class="row">
            <div class="col-sm-3 thumbnail panel-body">
                <?php if(!empty($articles_1)):?>
                    <h3 class="panel-body text-danger"><?php echo($articles_1[0]["categoryname"]);?></h3>
                    <?php foreach($articles_1 as $art_1):?>
                        <a href="/api/article/?gaid=<?php echo($art_1[0])?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo($art_1["articleimagedisplayname"]);?>" class="img-responsive">
                            </div>
                            <div class="col-sm-9">
                                <h6 class="text-danger"><?php echo( date("M D h:i a", strtotime($art_1["dateofpublication"])));?></h6>
                                <p  style="color: #000000 !important; font-weight: bolder;">
                                    <?php echo($art_1["title"]);?>.
                                </p>
                            </div>
                        </div>
                        </a>
                        <br>
                    <?php endforeach; ?>
                <?php else:?>
                    <div class="row">
                        <h3 class="panel-body text-danger">CATEGORY ONE</h3>
                        <div class="col-sm-3">
                            <img src="/api/img/banner-4.jpg" class="img-responsive">
                        </div>
                        <div class="col-sm-9">
                            <h6 class="text-danger">sat, 08 13:00</h6>
                            <p  style="color: #000000 !important; font-weight: bolder;">
                                this is the text for a test site for jonapwd
                                but i can always upload more credible articles to replace these
                                rubbish oo.
                            </p>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <div class="col-sm-3 thumbnail panel-body">
                <?php if(!empty($articles_2)):?>
                    <h3 class="panel-body text-danger"><?php echo($articles_2[0]["categoryname"]);?></h3>
                    <?php foreach($articles_2 as $art_2):?>
                <a href="/api/article/?gaid=<?php echo($art_2[0])?>">
                    <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo($art_2["articleimagedisplayname"]);?>" class="img-responsive">
                            </div>
                            <div class="col-sm-9">
                                <h6 class="text-danger"><?php echo( date("M D h:i a", strtotime($art_2["dateofpublication"])));?></h6>
                                <p  style="color: #000000 !important; font-weight: bolder;">
                                    <?php echo($art_2["title"]);?>.
                                </p>
                            </div>
                        </div>
                    </a>
                        <br>
                    <?php endforeach; ?>
                <?php else:?>
                    <div class="row">
                        <div class="panel-body"><h3 class="text-danger">CATEGORY TWO</h3> </div>
                        <div class="col-sm-3 thumbnail panel-body">
                            <img src="/api/img/banner-4.jpg" class="img-responsive">
                        </div>
                        <div class="col-sm-9">
                            <h6 class="text-danger">sat, 08 13:00</h6>
                            <p  style="color: #000000 !important; font-weight: bolder;">
                                this is the text for a test site for jonapwd
                                but i can always upload more credible articles to replace these
                                rubbish oo.
                            </p>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <div class="col-sm-3 thumbnail panel-body">
                <?php if(!empty($articles_3)):?>
                    <h3 class="panel-body text-danger"><?php echo($articles_3[0]["categoryname"]);?></h3>
                    <?php foreach($articles_3 as $art_3):?>
                <a href="/api/article/?gaid=<?php echo($art_3[0])?>">
                    <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo($art_3["articleimagedisplayname"]);?>" class="img-responsive">
                            </div>
                            <div class="col-sm-9">
                                <h6 class="text-danger"><?php echo( date("M D h:i a", strtotime($art_3["dateofpublication"])));?></h6>
                                <p  style="color: #000000 !important; font-weight: bolder;">
                                    <?php echo($art_3["title"]);?>.
                                </p>
                            </div>
                        </div>
                    </a>
                        <br>
                    <?php endforeach; ?>
                <?php else:?>
                    <div class="row">
                        <h3 class="panel-body text-danger">CATEGORY THREE</h3>
                        <div class="col-sm-3 thumbnail panel-body">
                            <img src="/api/img/banner-4.jpg" class="img-responsive">
                        </div>
                        <div class="col-sm-9">
                            <h6 class="text-danger">sat, 08 13:00</h6>
                            <p  style="color: #000000 !important; font-weight: bolder;">
                                this is the text for a test site for jonapwd
                                but i can always upload more credible articles to replace these
                                rubbish oo.
                            </p>
                        </div>
                    </div>
                <?php endif;?>
            </div>

            <div class="col-sm-3 thumbnail panel-body">
                <?php if(!empty($articles_4)):?>
                    <h3 class="panel-body text-danger"><?php echo($articles_4[0]["categoryname"]);?></h3>
                    <?php foreach($articles_4 as $art_4):?>
                <a href="/api/article/?gaid=<?php echo($art_4[0])?>">
                    <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo($art_4["articleimagedisplayname"]);?>" class="img-responsive">
                            </div>
                            <div class="col-sm-9">
                                <h6 class="text-danger"><?php echo( date("M D h:i a", strtotime($art_4["dateofpublication"])));?></h6>
                                <p  style="color: #000000 !important; font-weight: bolder;">
                                    <?php echo($art_4["title"]);?>.
                                </p>
                            </div>
                        </div>
                    </a>
                        <br>
                    <?php endforeach; ?>
                <?php else:?>
                    <div class="row">
                        <h3 class="panel-body text-danger">CATEGORY FOUR</h3>
                        <div class="col-sm-3">
                            <img src="/api/img/banner-4.jpg" class="img-responsive">
                        </div>
                        <div class="col-sm-9">
                            <h6 class="text-danger">sat, 08 13:00</h6>
                            <p>
                                this is the text for a test site for jonapwd
                                but i can always upload more credible articles to replace these
                                rubbish oo.
                            </p>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<div class="features thumbnail">
    <div class="container">
        <h3 class="m_3 text-danger">Recent Donors</h3>
        <div class="close_but"><i class="close1"> </i></div>
        <?php
        $donation = new Donation();
        $donors = $donation->getDonations(4,0);
        if(!empty($donors)):?>
            <?php /*foreach(array_chunk($galleryfiles,4) as $gfs):*/?>
                <div class="row">
                    <?php foreach($donors as $donor):?>
                        <div class="col-md-3 top_box">
                            <div class="view view-ninth">
                                <a href="">
                                    <img src="<?php echo($donor['profilepic']);?>" class="img-responsive" alt=""
                                         style="width: 100%; height: 200px;"/>
                                    <div class="mask mask-1"> </div>
                                    <div class="mask mask-2"> </div>
                                    <div class="content">
                                        <h2><?php echo(date("M d, l", strtotime($donor['dateofpledge'])));?></h2>
                                        <p><?php echo($donor['note']);?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php /*endforeach; */?>
        <?php else: ?>
        <div class="row">
            <div class="col-sm-3 top_box">
                <div class="view view-ninth"><a href="">
                        <img src="/api/img/jonapwd/radio-1.jpg" class="img-responsive" alt=""/>
                        <div class="mask mask-1"> </div>
                        <div class="mask mask-2"> </div>
                        <div class="content">
                            <h2>Chief Ume Ugonna</h2>
                            <p>Made a financial donation towards The Disability Day Celebration</p>
                        </div>
                    </a>
                </div>
            </div>
            <h4 class="m_4"><a href="#">Chief Ume Ugonna</a></h4>
            <p class="m_5"><?php echo date("M d, l");?></p>


        <div class="col-sm-3 top_box">
            <div class="view view-ninth"><a href="">
                    <img src="/api/img/jonapwd/radio-1.jpg" class="img-responsive" alt=""/>
                    <div class="mask mask-1"> </div>
                    <div class="mask mask-2"> </div>
                    <div class="content">
                        <h2>Chief Ume Ugonna</h2>
                        <p>Made a financial donation towards The Disability Day Celebration</p>
                    </div>
                </a>
            </div>
        </div>
        <h4 class="m_4"><a href="#">Chief Ume Ugonna</a></h4>
        <p class="m_5"><?php echo date("M d, l");?></p>


    <div class="col-sm-3 top_box">
        <div class="view view-ninth"><a href="">
                <img src="/api/img/jonapwd/radio-1.jpg" class="img-responsive" alt=""/>
                <div class="mask mask-1"> </div>
                <div class="mask mask-2"> </div>
                <div class="content">
                    <h2>Chief Ume Ugonna</h2>
                    <p>Made a financial donation towards The Disability Day Celebration</p>
                </div>
            </a>
        </div>
    </div>
    <h4 class="m_4"><a href="#">Chief Ume Ugonna</a></h4>
    <p class="m_5"><?php echo date("M d, l");?></p>


    <div class="col-sm-3 top_box">
        <div class="view view-ninth"><a href="">
                <img src="/api/img/jonapwd/radio-1.jpg" class="img-responsive" alt=""/>
                <div class="mask mask-1"> </div>
                <div class="mask mask-2"> </div>
                <div class="content">
                    <h2>Chief Ume Ugonna</h2>
                    <p>Made a financial donation towards The Disability Day Celebration</p>
                </div>
            </a>
        </div>
    </div>
    <h4 class="m_4"><a href="#">Chief Ume Ugonna</a></h4>
    <p class="m_5"><?php echo date("M d, l");?></p>
    </div>
    <?php endif; ?>
    </div>
</div>

</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php";?>
</body>
</html>
