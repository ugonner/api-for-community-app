<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";

$galleryfiles = $headarticle->getGalleryFiles(1,24,0);
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
                    <div class="clearfix"> </div>

                    <?php if(!empty($galleryfiles)):?>
                        <?php foreach(array_chunk($galleryfiles,2) as $gfiles):?>
                            <div class="gallery-grid">
                                <?php foreach($gfiles as $gfile):?>
                                    <a href="/api/article/?gaid=<?php echo($gfile['articleid']);?>" class="wow fadeInUp animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                                        <img src="<?php echo($gfile['displayname'])?>" alt=" " class="img-responsive zoom-img">
                                    </a>
                                    <h6><?php echo($gfile['filetitle']); ?></h6>
                                <?php endforeach;?>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>


                    <?php if(!empty($articles)):?>
                        <?php foreach(array_chunk($articles,2) as $afiles):?>
                            <div class="gallery-grid">
                                <?php foreach($afiles as $afile):?>
                                    <a href="/api/article/?gaid=<?php echo($afile[0]);?>" class="wow fadeInUp animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                                        <img src="<?php echo($afile['articleimagedisplayname'])?>" alt=" " class="img-responsive zoom-img">
                                    </a>
                                    <h6><?php echo($afile['title']); ?></h6>
                                <?php endforeach;?>
                            </div>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>

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