<div class="row">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/advert.class.php';
    $advert = new advert();
    $categoryid = (empty($category['categoryid'])? 1 : $category['categoryid']);
    $top_cat_adverts = $advert->getadverts("wq",' (advert.public = "Y" AND placementid = 3) AND categoryid='.$categoryid,0,4);

    ?>
    <?php if(!empty($top_cat_adverts)):?>
        <?php foreach($top_cat_adverts as $tca):?>
            <div class="col-sm-4 ad-column-divs">
                <a href="<?php echo($tca['adverturl']);?>">
                    <img src="<?php echo($tca['advertimagedisplayname']);?>" alt="image on <?php echo($tca['title']);?>"
                         class="img-responsive" style="height: 80px;">
                </a>
                <h6><?php echo($tca['title']);?></h6>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<br>