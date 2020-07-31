<div class="row">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/advert.class.php';
    $advert = new advert();
    $top_adverts = $advert->getPublishdedAdverts("placementid",1,0,4);
    ?>
    <?php if(!empty($top_adverts)):?>
        <?php foreach($top_adverts as $tca):?>
            <div class="col-sm-4 ad-column-divs">
                <a href="<?php echo($tca['adverturl']);?>">
                    <img src="<?php echo($tca['advertimagedisplayname']);?>" alt="image on <?php echo($tca['title']);?>"
                         class="img-responsive">
                </a>
                <h6><?php echo($tca['title']);?></h6>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>