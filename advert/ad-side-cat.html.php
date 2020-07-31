<div class="row">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/advert.class.php';
    $advert = new advert();
    $categoryid = (empty($category['categoryid'])? 1 : $category['categoryid']);
    $side_cat_adverts = $advert->getadverts("wq",' placementid = 4 AND categoryid='.$categoryid,0,4);

    ?>
    <?php if(!empty($side_cat_adverts)):?>
        <?php foreach($side_cat_adverts as $tca):?>
            <div class="col-sm-4">
                <a href="<?php echo($tca['adverturl']);?>">
                    <img src="<?php echo($tca['advertimagedisplayname']);?>" alt="image on <?php echo($tca['title']);?>" class="img-responsive">
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>