<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/helpers/htmler.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";

if(!isset($_SESSION)){
    session_start();
}

$admin = new admin();
$fa = $cluster["cluster"];
$articles = $cluster['articles'];

if(isset($_GET["leavecluster"])){
    $clusterid = (empty($_GET['clusterid'])? 0 : htmlspecialchars($_GET['clusterid']));
    $userid = (isset($_SESSION['userid'])? $_SESSION['userid'] : 0);
    if($admin->leaveCluster($userid,$clusterid)){
        $output = "you have left this cluster";
    }
}

if(isset($_GET["joincluster"])){
    $clusterid = (empty($_GET['clusterid'])? 0 : htmlspecialchars($_GET['clusterid']));
    $userid = (isset($_SESSION['userid'])? $_SESSION['userid'] : 0);
    if($admin->joinClusters($userid,$clusterid)){
        $output = "you have joined this cluster";
    }
}
?>
<div class="page-heading text-center">

    <div class="container zoomIn animated">

        <h1 class="page-title"><?php echo $fa["clustername"]; ?> Page <span class="title-under"></span></h1>
        <p class="page-description">
            JONAPWD CLUSTER PAGE.
        </p>

    </div>

</div>

<div class="main-container fadeIn animated">

    <div class="container">

        <div class="row">

            <div class="col-md-7 col-sm-12 text-center" style="height: 500px; background: #000000;
                    color: wheat;">

                <h2 class="title-style-2"><span class="title-under"></span></h2>
                <div style="padding: 200px 0 0 0;">
                    <h1 style="font-family: cursive">
                        <b>JONAPWD</b> <br>
                        Cluster Page

                    </h1>
                    <h4>
                        JONAPWD
                    </h4>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-1 col-contact">

                <h2 class="title-style-2"><?php echo $fa['clustername']?> <span class="title-under"></span></h2>
                <div>
                    <?php
                    $userid = (isset($_SESSION['userid'])? $_SESSION['userid'] : 0);
                    if($admin->isClusterMember($userid,$fa["clusterid"])):?>
                        <a class="btn btn-lg btn-block btn-danger" href="/api/user/?leavecluster&clusterid=<?php echo($fa['clusterid']);?>">
                            Leave Cluster
                        </a>
                    <?php else:?>
                        <a class="btn btn-lg btn-block btn-primary" href="/api/user/?joincluster&clusterid=<?php echo($fa['clusterid']);?>">
                            Join Cluster
                        </a>
                    <?php endif; ?>
                    <?php shout($fa['clusternote']);?>
                </div>

                <div>
                    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/api/includes/htmlpages/leftbar.html.php"; ?>
                </div>



            </div>

        </div> <!-- /.row -->

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <?php
                if((!empty($_SESSION["userid"])) && $admin->isAdmin($_SESSION["userid"])):?>
                    <span data-toggle="collapse" data-target="#aboutdiv"
                           class="btn btn-lg btn-danger">
                        Edit Cluster
                    </span>
                    <div id="aboutdiv" class="collapse">
                        <div class="form-group">
                            <form action="/api/admin/index.php" method="POST">
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="clustername">Name:</label>
                                        <input type="text" name="clustername" value="<?php echo $fa["clustername"];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="about">Info:</label>

                                        <textarea class="form-control" id="about" name="clusternote"><?php echo $fa["clusternote"];?></textarea>

                                    <input type="hidden" name="clusterid" value="<?php echo $fa["clusterid"];?>" />
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <button name="editcluster" type="submit" class="btn btn-lg btn-block btn-info">
                                            Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row">
            <h2>
                News And Events On <?php echo $fa["clustername"];?>
            </h2>
        </div>
        <!--//for articles on this area-->
        <?php if(!empty($articles)):?>
            <?php foreach(array_chunk($articles,4) as $subarts):?>
                <div class="row">
                    <?php foreach($subarts as $a):?>
                        <div class="col-sm-3">
                            <?php
                            $aidn = $a["articleimagedisplayname"];
                            if(empty($aidn)){
                                $aidn = "/api/assets/images/articles/article.jpg";
                            }
                            ?>
                            <div class="articledivs">
                                <div>
                                    <span class="btn btn-danger">
                                        <?php echo $a["categoryname"];?> |
                                        <small><?php echo $fa["clustername"];?></small>
                                    </span>
                                    <img src="<?php echo $aidn; ?>" alt="<?php echo $a["title"];?>"
                                         title="<?php echo $a["title"];?>" style="width: 100%; height: 200px;">
                                    <p>
                                        <a href="/api/article/index.php?gaid=<?php echo $a['id'];?>">
                                            <?php shout($a["title"]); ?>
                                        </a>
                                    </p>
                                    <small><?php echo date("y M d, l h:i a", strtotime($a["dateofpublication"]));?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
                    <a class="btn btn-primary" href="/api/cluster/?gabcl&clid=<?php echo $fa['clusterid'];?>">
                        See All >>
                    </a>

        <?php endif;?>
    </div>



</div>

<div id="contact-map" class="contact-map">

</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php"; ?>
