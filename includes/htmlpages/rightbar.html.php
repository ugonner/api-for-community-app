

<style>
    .board-imgs{
        width: 80px;
        height: 60px;
    }
</style>
<div class="blo-top1">
    <div class="tech-btm">

    <!--original html with login-->
    <div style="color: #000000; font-weight: bolder;">

        <div style="clear: both;">
            <br><br>
            <button id="getactiveusersbutton" type="button" class="btn btn-lg btn-info btn-block" >
                <span class="glyphicon glyphicon-comment"></span> Chat Online Users
            </button>

            <div style="padding: 10px;" id="getactiveusersdiv">

            </div>

        </div>
        <br>
        <?php

        $rightbar_articles = $headarticle->getPublishedArticles('article.id DESC',10,0);
        $rightbar_Most_viewed_articles = $headarticle->getPublishedArticles('article.noofviews DESC',10,0);

        ?>
        <div class="row">

            <h4>Latest News / Articles</h4>

        <?php if(!empty($rightbar_articles)):?>
            <?php foreach($rightbar_articles as $ras):?>
                <a href="/api/article/?gaid=<?php echo($ras[0]);?>">
                    <div style="clear: both;">
                        <img src="<?php echo($ras["articleimagedisplayname"]);?>" style="width: 70px;
                            height: 70px; float: left; margin: 5px;"/>
                        <h5><?php echo($ras["title"]);?></h5>
                        <h6><?php echo(date("M d. h:i a", strtotime($ras["dateofpublication"])));?></h6>

                    </div>
                </a>

            <?php endforeach;?>
        <?php endif; ?>
            <br><br>
            <a href="/api/article/?getarticles" class="btn btn-lg btn-info btn-block">More</a>
        </div>


        <div class="row">

            <h4>Most Viewed </h4>
            <?php if(!empty($rightbar_Most_viewed_articles)):?>
            <?php foreach($rightbar_Most_viewed_articles as $ras):?>
                <a href="/api/article/?gaid=<?php echo($ras[0]);?>">
                    <div style="clear: both;">
                        <img src="<?php echo($ras["articleimagedisplayname"]);?>" style="width: 70px;
                            height: 70px; float: left; margin: 5px;"/>
                        <h5><?php echo($ras["title"]);?></h5>
                        <h6><?php echo(date("M d. h:i a", strtotime($ras["dateofpublication"])));?></h6>

                    </div>
                </a>

            <?php endforeach;?>
            <?php endif; ?>
            <br><br>
            <a href="/api/article/?getarticles" class="btn btn-lg btn-info btn-block">More</a>
        </div>
    </div>


    <!--end of original with login-->


    <div class="search-1 wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
            <form action="#" method="post">
                <input type="search" name="Search" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" required="">
                <input type="submit" value=" ">
            </form>
    </div>

        <h4>Popular Posts </h4>
        <?php if(!empty($articles_1)):?>
            <?php foreach(array_chunk($articles_1,2) as $populars):?>

                <div class="blog-grids wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
                    <?php foreach($populars as $pop):?>
                        <div class="blog-grid-left">
                            <a href=""><img src="<?php echo($pop['articleimagedisplayname']);?>" class="img-responsive" alt="<?php echo($pop['title']);?>"></a>
                        </div>
                        <div class="blog-grid-right">
                            <h5>
                                <a href="/api/article/index.php?gaid=<?php echo($pop[0]);?>">
                                    <?php echo($pop['title']);?>
                                </a>
                            </h5>
                        </div>
                        <div class="clearfix"> </div><br>
                    <?php endforeach;?>
                    <div class="clearfix"> </div>
                </div>
            <?php endforeach;?>
        <?php endif; ?>




        <div class="blog-grids wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
            <div class="blog-grid-left">
                <a href=""><img src="/api/img/m3.jpg" class="img-responsive" alt=""></a>
            </div>
            <div class="blog-grid-right">

                <h5><a href="">JONAPWD<b style="color: tomato"> Anambra</b></a> </h5>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="insta wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
            <h4>THE STRENGTH IN UNION</h4>
            <ul>

                <li><a href="/api/board.html.php"><img src="/api/img/site-imgs/sunrise-with-poles.jpg" class="img-responsive board-imgs" alt=""></a></li>
                <li><a href="/api/board.html.php"><img src="/api/img/site-imgs/african-dance.jpeg" class="img-responsive board-imgs" alt=""></a></li>
                <li><a href="/api/board.html.php"><img src="/api/img/site-imgs/sunrise-with-poles.jpg" class="img-responsive board-imgs" alt=""></a></li>
            </ul>
        </div>

        <p></p>
        <div class="twt">

            <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" class="twitter-hashtag-button twitter-hashtag-button-rendered twitter-tweet-button" title="Twitter Tweet Button" src="https://platform.twitter.com/widgets/tweet_button.b7de008f493a5185d8df1aedd62d77c6.en.html#button_hashtag=TwitterStories&amp;dnt=false&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=https%3A%2F%2Fp.w3layouts.com%2Fdemos%2Fduplex%2Fweb%2F&amp;size=l&amp;time=1467721486626&amp;type=hashtag" style="position: static; visibility: visible; width: 166px; height: 28px;" data-hashtag="TwitterStories"></iframe>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        </div>
        <h4 id="contactdiv">Contact Info</h4>
        <h6 class="text-danger"><i class="glyphicon glyphicon-envelope"></i> jonapwdsupport@jonapwdanambra.org.ngm</h6>
        <h6 class="text-danger"><i class="glyphicon glyphicon-phone"></i>
            07034667861,
        </h6>

    </div>



</div>

<script type="text/javascript">
    $("#getactiveusersbutton").click(function(){
        $("#getactiveusersdiv").empty();
        $("#getactiveusersdiv").append("Loading Users...");
        $("#getactiveusersdiv").load("/api/user/?getactiveusers");
    });
</script>