<?php include_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php"; ?>

<?php
//fetch products articles and facilities;
$sql = "SELECT article.id, title, articleimagedisplayname as productimagedisplayname, dateofpublication, category.id as categoryid,
        category.name as categoryname  FROM article INNER JOIN category ON categoryid = category.id
        ORDER BY article.id DESC LIMIT 30";

try{
    $dbh = new Dbconn();
    $stmt = $dbh ->dbcon->prepare($sql);
    $stmt->execute();
    $articles = $stmt->fetchAll();

}catch(PDOException $e){
    $error = "Components not fetched";
    $error2 = $e->getMessage();
    include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/errors/error.html.php";
    exit;
}

?>
<style>
    .firstcontentdiv{
        border: 5px solid #404040;
        width: 100%;
        height: 300px;
        z-index: 6;
        position: relative;
    }
    .title{
        border-bottom: 5px solid red;
        clear: both;
        margin: 50px 0 50px 0;
    }
    .contentimg{
        position: relative;
        overflow: hidden;
    }
    .productimg{
        float: left;
        width: 50px;
        height: 50px;
        border: 5px solid #404040;
        margin: 5px;
    }
    .contenth{
        background: #222222;
        position: absolute;
        top: 50%;
    }
    .contenth h4{
        font-size: 0.95em;
    }
    .contenttopicsdiv{
        padding: 30px 5px 0 40px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <!--for articles-->
        <div class="title text-center" style="" >
            <span style="padding: 10px; background: red">Articles</span>
        </div>


        <span style="padding: 10px; background: red;"><?php echo $articles[0]["categoryname"];?></span>
        <div class="firstcontentdiv" style="">

            <img src="<?php echo $articles[0]["productimagedisplayname"];?>"
                 style="width: 100%; height: 100%;" class="contentimg">
            <div class="text-capitalize contenth">
                <h6 class="page-header">
                    <span class="glyphicon glyphicon-time"></span> <?php echo date("Y M d l h:i:s a", strtotime($articles[0]["dateofpublication"]));?></h6>
                <h4>
                    <a href='/api/article/?gaid=<?php echo $articles[0][0];?>'>
                    <?php echo $articles[0]["title"];?>
                    </a>
                </h4>
            </div>

        </div>
        <div class="contenttopicsdiv">
            <div class="col-sm-6">
                <?php for($i=1; $i < 15; $i++):?>
                    <?php if(isset($articles[$i])):?>
                        <div>
                            <div style=" border-bottom: 2px solid red;">
                                   <span style="padding: 5px; background: red;">
                                   <?php echo $articles[$i]["categoryname"];?>
                                   </span>
                            </div>
                            <h5>
                                <a href="/api/article/?gaid=<?php echo $articles[$i][0]; ?>">
                                    <span class="glyphicon glyphicon-comment"></span> <?php echo $articles[$i]["title"];?>
                                </a>
                                <br>
                                <small>
                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("Y M d l h:i:s a", strtotime($articles[$i]["dateofpublication"]));?>
                                </small>
                            </h5>

                            <h6 class="text-right">
                                <a href="/api/article/articleform.html.php?cid=<?php echo $articles[$i]["categoryid"]; ?>">
                                    Post Article In This Category
                                </a>
                            </h6>

                        </div>
                        <br>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>



            <!--second row topics-->
            <div class="col-sm-6">
                <?php for($i=15; $i<count($articles); $i++):?>
                    <?php if(isset($articles[$i])):?>
                        <div>
                            <div style=" border-bottom: 2px solid red;">
                                   <span style="padding: 5px; background: red;">
                                   <?php echo $articles[$i]["categoryname"];?>
                                   </span>
                            </div>
                            <h5>
                                <a href="/api/article/?gaid=<?php echo $articles[$i][0]; ?>">
                                    <span class="glyphicon glyphicon-comment"></span> <?php echo $articles[$i]["title"];?>
                                </a>
                                <br>
                                <small>
                                    <span class="glyphicon glyphicon-time"></span> <?php echo date("Y M d l h:i:s a", strtotime($articles[$i]["dateofpublication"]));?>
                                </small>
                            </h5>
                            <h6 class="text-right">
                                <a href="/api/article/articleform.html.php?cid=<?php echo $articles[$i]["categoryid"]; ?>">
                                    Post Article In This Category
                                </a>
                            </h6>

                        </div>
                        <br>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php"; ?>
        </div>
    </div>
</div>