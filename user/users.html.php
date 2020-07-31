<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";?>

    <div class="banner-1">
    </div>

    <!-- technology-left -->

    <div class="technology">
        <div class="container">
            <div>
                <?php include_once $_SERVER['DOCUMENT_ROOT'] ."/api/includes/htmlpages/pagination.html.php"; ?>
            </div>
            <div class="col-md-9 technology-left">
                <div class="w3agile-1">
                    <div class="team">
                        <h3 class="team-heading">
                            <?php if(!empty($property_alias)):?>
                                Meet Users By <?php echo $property_alias;?>
                            <?php else:?>
                                <?php $rolename = (empty($users[0]['rolename'])? 'No members ' : "Meet ".$users[0]['rolename']); echo $rolename;?>
                            <?php endif;?>
                        </h3>
                        <div class="team-grids">
                            <?php if(!empty($users)):?>
                                <?php foreach(array_chunk($users,2)as $users_2):?>
                                    <div class="col-md-6 team-grid">
                                        <?php foreach($users_2 as $user):?>
                                            <div class="team-grid1">
                                                <img src="<?php echo($user['profilepic']);?>" alt=" " class="img-responsive">
                                                <div class="p-mask">
                                                    <p><i class="glyphicon glyphicon-phone"></i> :<?php echo($user['mobile']);?>
                                                        <i class="glyphicon glyphicon-user"></i><?php echo($user['gender']);?>
                                                        <span ><i class="glyphicon glyphicon-map-marker"></i><?php echo($user['locationname']);?></span>

                                                    </p>
                                                </div>
                                            </div>
                                            <h5><a href="/api/user/?guid=<?php echo($user[0]);?>">
                                                    <?php echo($user['firstname']);?>
                                            </a><span><?php
                                                    $userrole = (isset($user['rolenote'])? $user['rolenote'] : 0);
                                                    echo($userrole);?></span>
                                            </h5>
                                            <ul class="social">
                                                <li><a class="social-facebook" href="#">
                                                        <i></i>
                                                        <div class="tooltip"><span>Facebook</span></div>
                                                    </a>
                                                </li>
                                                <li><a class="social-twitter" href="#">
                                                        <i></i>
                                                        <div class="tooltip"><span>Twitter</span></div>
                                                    </a>
                                                </li>
                                                <li><a class="social-google" href="#">
                                                        <i></i>
                                                        <div class="tooltip"><span>Google+</span></div>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach;?>
                            <?php else:?>
                                <div class="col-md-6 team-grid">
                                    <img src="/api/img/user.jpg" class="img-responsive">
                                </div>
                                <div class="col-md-6 team-grid">
                                    <h2 class="text-center">No Users in this category</h2>
                                </div>
                            <?php endif; ?>
                            <div class="clearfix"> </div>
                        </div>
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
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php";?>