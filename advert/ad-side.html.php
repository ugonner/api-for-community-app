<div class="row">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/advert.class.php';
    $advert = new advert();
    $side_adverts = $advert->getadverts("placementid",2,0,4);
    ?>
    <?php if(!empty($side_adverts)):?>
        <?php foreach($side_adverts as $tca):?>
            <div class="col-sm-4">
                <a href="<?php echo($tca['adverturl']);?>">
                    <img src="<?php echo($tca['advertimagedisplayname']);?>" alt="image on <?php echo($tca['title']);?>" class="img-responsive">
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
