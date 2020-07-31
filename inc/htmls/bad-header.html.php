<div class="container-fluid" style="background: #000000;">
    <nav class="navbar navbar-inverse">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/api">
                <img src="/api/img/site-imgs/logo.jpg" style="width: 1.4em; height: 1em;" alt="JONAPWD logo">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active act"><a class="btn btn-sm" href="/api/index-2.php">Home</a></li>
                <li class="dropdown">
                    <a  class="dropdown-toggle btn btn-sm" data-toggle="dropdown" href="">
                        About Us <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a  class="btn btn-sm" href="/api/about.html.php">History, Mission & Goal</a></li>
                        <li><a class="btn btn-sm" href="/api/aims.html.php">Aims, Achievements & Challenges</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a  class="dropdown-toggle btn btn-sm" data-toggle="dropdown" href="">
                        Clusters <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($head_clusters as $hcl):?>
                            <li>
                                <a class="btn btn-sm" href="/api/cluster/?getcluster&clusterid=<?php echo $hcl["id"]; ?>">
                                    <?php echo $hcl["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li><a class="btn btn-sm" href="/api/article/?gabc&cid=2">Social Activities</a></li>
                <li class="dropdown">
                    <a  class="dropdown-toggle btn btn-sm" data-toggle="dropdown" href="">
                        News <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($headcategories as $headcategory):?>
                            <li>
                                <a class="btn-sm" href="/api/article/?gabc&cid=<?php echo $headcategory["id"]; ?>&categoryname=<?php echo $headcategory["name"]; ?>">
                                    <?php echo $headcategory["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a  class="dropdown-toggle btn btn-sm" data-toggle="dropdown" href="">
                        Members <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($headroles as $headrole):?>
                            <li>
                                <a class="btn btn-sm" href="/api/user/?gubr&rid=<?php echo $headrole["id"]; ?>">
                                    <?php echo $headrole["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a  class="dropdown-toggle btn btn-sm" data-toggle="dropdown" href="">
                        Target Areas <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($headfocalareas as $hfa):?>
                            <li>
                                <a class="btn btn-sm" href="/api/article/?gfa&faid=<?php echo $hfa["id"]; ?>">
                                    <?php echo $hfa["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <li><a class="btn btn-sm" href="/api/gallery/gallery.html.php">Gallery</a></li>
                <li><a class="btn btn-sm" href="#contactdiv">Contact</a></li>
            </ul>
            <?php if(!isset($_SESSION["userid"])):?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn btn-sm" href="/api/user/registration.html.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a class="btn btn-sm" href="/api/user/index.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn btn-sm" href="/api/user/index.php?logout"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
                </ul>
            <?php endif;?>
        </div>


    </nav>

</div>








<!-- collapsed nav-->
<div class="container-fluid" style="background: #000000;">
    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/api">
                <img src="/api/img/site-imgs/logo.jpg" style="width: 1.4em; height: 1em;" alt="JONAPWD logo">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active act"><a class="no-;btn-sm" href="/api/index-2.php">Home</a></li>

                <li><a class="no-;btn-sm" href="/api/gallery/gallery.html.php">Gallery</a></li>
                <li><a class="no-;btn-sm" href="#contactdiv">Contact</a></li>
                <li class="dropdown">
                    <a  class="dropdown-toggle " data-toggle="dropdown" href="">
                        About Us <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a  class="" href="/api/about.html.php">History, Mission & Goal</a></li>
                        <li><a class="" href="/api/aims.html.php">Aims, Achievements & Challenges</a></li>
                    </ul>
                </li>

                <li><a class="no-;btn-sm" href="/api/article/?gabc&cid=2">Social Activities</a></li>
                <li class="dropdown">
                    <a  class="dropdown-toggle no-;btn-sm" data-toggle="dropdown" href="">
                        News <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($headcategories as $headcategory):?>
                            <li>
                                <a class="btn-sm" href="/api/article/?gabc&cid=<?php echo $headcategory["id"]; ?>&categoryname=<?php echo $headcategory["name"]; ?>">
                                    <?php echo $headcategory["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </li>

                <li class="dropdown">
                    <a  class="dropdown-toggle no-;btn-sm" data-toggle="dropdown" href="">
                        Members <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($headroles as $headrole):?>
                            <li>
                                <a class="no-;btn-sm" href="/api/user/?gubr&rid=<?php echo $headrole["id"]; ?>">
                                    <?php echo $headrole["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </li>

                <li class="dropdown">
                    <a  class="dropdown-toggle no-;btn-sm" data-toggle="dropdown" href="">
                        Target Areas <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($headfocalareas as $hfa):?>
                            <li>
                                <a class="no-;btn-sm" href="/api/article/?gfa&faid=<?php echo $hfa["id"]; ?>">
                                    <?php echo $hfa["name"]; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

            </ul>
        </div>


    </nav>

</div>




<!--start-main-->
<!--<div class="header-bottom">
    <div class="container">
        <div class="logo wow fadeInDown"  data-wow-duration="8s" data-wow-delay="2s">
            <h2 class="secondary-color">JONAPWD<b style="color: mediumaquamarine">Media</b></h2>
            <p class="secondary-color"><label class="of"></label>LIFE AND VOICE TO THE RURALS<label class="on"></label></p>
        </div>
    </div>
</div>-->

<!-- banner -->
