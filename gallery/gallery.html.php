<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/api/gallery/gallery.class.php";

$admin = new admin();

if(!empty($_SESSION['userid'])){
    $userid = $_SESSION['userid'];
}else{$userid = 0;}
$isadmin = $admin->isAdmin($userid);

$galleryobj = new Gallery();
if(empty($galleryfiles)){
    $galleryfiles = $galleryobj->getGalleryFiles(10,0);
}

$articlegalleryfiles = $headarticle->getGalleryFiles(1,24,0);
$articles = $headarticle->getarticles(24,0);
$imge = '
<img src="img/jonapwd/disability-law.jpg">
    <img src="img/jonapwd/meeting-conference.jpg">
    <img src="img/jonapwd/meeting.jpg">
    <img src="img/jonapwd/radio-1.jpg">
    <img src="img/jonapwd/g-with-yoruba,am.jpg">
    <img src="img/jonapwd/group-1.jpg">
    <img src="img/jonapwd/takk-with-white.JPG">
    <img src="img/jonapwd/group-with-ssa.jpg">
    <img src="img/jonapwd/group-2.jpg">';

$static_imgs = array("/api/img/jonapwd/disability-law.jpg",
    "/api/img/jonapwd/meeting-conference.jpg",
    "/api/img/jonapwd/takk-with-white.JPG",
    "/api/img/jonapwd/group-with-ssa.jpg",
    "/api/img/jonapwd/radio-1.jpg",
    "/api/img/jonapwd/meeting.jpg",
    "/api/img/jonapwd/group-1.jpg",
    "/api/img/jonapwd/group-2.jpg");
?>

    <div class="banner-1">

        <?php if($isadmin):?>
            <h5 class="text-right">
                <a href="/api/gallery/galleryform.php" class="btn btn-lg btn-primary">
                    Add Gallery Files
                </a>
            </h5>
        <?php endif;?>
    </div>


<div class="features">
    <div class="container">
    <h3 class="m_3">Gallery</h3>
    <div class="close_but"><i class="close1"> </i></div>
    <?php if(!empty($galleryfiles)):?>
        <?php foreach(array_chunk($galleryfiles,4) as $gfs):?>
            <div class="row">
                    <?php foreach($gfs as $gf):?>
                        <div class="col-md-3 top_box">
                            <div class="view view-ninth">
                            <a href="">
                                <img src="<?php echo($gf['displayname']);?>" class="img-responsive" alt=""
                                    style="width: 100%; height: 200px;"/>
                                <div class="mask mask-1"> </div>
                                <div class="mask mask-2"> </div>
                                <div class="content">
                                    <h2><?php echo(date("M d, l", strtotime($gf['dateofpublication'])));?></h2>
                                    <p><?php echo($gf['title']);?></p>
                                </div>
                            </a>
                        </div>
                        <?php if($isadmin):?>
                            <a class="btn-block btn-lg btn-danger"
                               href="/api/gallery/?deletegalleryfile&galleryfileid=<?php echo($gf['galleryfileid']);?>">
                                Delete File
                            </a>
                        <?php endif; ?>
                        </div>
                    <?php endforeach;?>

            </div>
        <?php endforeach; ?>
    <?php else: ?>

        <div class="row">
            <div class="col-md-3 top_box">
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
            <div class="col-md-3 top_box">
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
            <div class="col-md-3 top_box">
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
            <div class="col-md-3 top_box">
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
        </div>
    <?php endif;?>
    </div>
</div>
    <!-- technology-left -->
    <div class="technology">
        <div class="container">
            <div class="col-md-9 technology-left">
                <div class="gallery" id="gallery">

                    <h2 class="w3">GALLERY</h2>
                    <p>Welcome to JONAPWD Gallery, click to view story</p>
                    <div class="gallery-grids">


                        <?php foreach(array_chunk($static_imgs,2) as $stat_imgs):?>

                            <div class="gallery-grid">
                                <?php foreach($stat_imgs as $si):?>
                                    <a href="" class="wow fadeInUp animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                                        <img src="<?php echo($si)?>" alt=" " class="img-responsive zoom-img">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                        <!--<div class="clearfix"> </div>-->

                        <?php if(!empty($galleryfiles)):?>
                            <?php foreach(array_chunk($galleryfiles,2) as $gfiles):?>
                                <div class="gallery-grid">
                                    <?php foreach($gfiles as $gfile):?>
                                        <a href="/api/article/?gaid=<?php echo($gfile['articleid']);?>" class="wow fadeInUp animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                                            <img src="<?php echo($gfile['displayname'])?>" alt=" " class="img-responsive zoom-img">
                                        </a>
                                        <h6><?php echo($gfile['title']); ?></h6>
                                    <?php endforeach;?>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>

                    </div>
                    <div class="clearfix"> </div>

                </div>
            </div>
            <!-- technology-right -->
            <div class="col-md-3 technology-right">
            </div>
            <div class="clearfix"></div>
            <!-- technology-right -->
        </div>
    </div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php"; ?>