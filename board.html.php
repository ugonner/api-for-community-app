
<?php
$board_members = array(
    ['PresIdent', 'Chief Christian Ebede', '','/api/img/board/chris-ebede.jpg'],
    ['Vice President',' Chief and Lolo Ochiora Ebede', '',''],
    ['Chairman of The Board', 'Chief Dr Ben Obi', '',''],
    ['Vice Chairman of the board', ' Barr. Goodluck Okey Nwankwo', '',''],
    ['Communication Director', ' Assoc. Prof. Uche Victor Ebeze', '',''],
    ['Legal Adviser', 'Barr. Michelle Marchie', '',''],
    ['Chief Coordinator', 'Comrade Chris Adike', '',''],
    ['Finance manager', 'Mr Osita Nweke', '',''],
    ['General Manage/ Secretary', 'Comrade Monic Okechukwu', '',''],
    ['Publicity Director: ', ' Mr OJ Udemezue','','/api/img/board/oj-udemezue.jpg'],
    ['1st Board member', ' Jasmine Onyeka Ebede ', ' London',''],
    ['2nd Board member', 'Lovett Ogechukwu Ebede ', ' London','/api/img/kpakpandomediapictures/mrs-okechukwu.jpg'],
    ['3rd Board member', ' Mr Nnonso Marchie', '',''],
    ['4th Board Member', 'Dr Gozie Ebede', 'USA',''],
    [' ','Comrade Emma Ikwueze', ' ', '/api/img/board/ikwu.jpg',"is a veteran journalist and former staff of the Star Printing and Publishing Company
 where he held several positions including City Editor, Benin City, News Editor, Weekly Star, Group Features Editor and Deputy Editor.
  <p>
  He also served as Chairman of Daily Star from 1983 to 1987 after which he was elected Vice Chairman of the Nigerian Union of Journalists to,
   old Anambra State from 1987 to 1989.
   </p>
   <p>
   In 1990, he was elected State Chairman of the NUJ and in 1991, he became the first chairman of the Enugu State Council of the NUJ. At the end of his tenure in 1994, he voluntarily retired from the Daily Star for private journalism practice.
During his active journalism career, he introduced the first rural-based newsletter, the Rural Star, which won him the late Governor Sampson Omeruah  Cup for the best documentary  producer on the old Anambra State Rural Development Programme for the two consecutive years the award lasted.
On voluntary retirement from the Daily Star, he founded
 E – GLOBEMEDIA, a public relations and publishing organization based in Enugu, Enugu State, Nigeria with a branch office at Eke, in Udi local government area of Enugu State. The organization was established in 1994 and registered with the Nigerian Corporate Affairs Commission. Since inception, the organization has published several newspapers and business magazines among which were the Eastern Business Link, Enugu Business Journal, Third Tier Watch magazine, the Niger Voice newspaper and Enugu Rural News among others. The group has also published several books.
</p>
<p>
He has organized several workshops and delivered several papers on local government and community development issues at both state and national levels as well as served as consultants to several newspapers and magazines. He was also the Editorial Consultant and Editor-in-Chief of the historic 1000-page Enugu Centenary Documentary and Who is Who published in 2010 by Fona Communications Ltd. Enugu.
</p>"],
    [' ','Monic  Okechukwu ', ' ', '/api/img/board/monica.jpg ',"A Journalist. Studied Mass Communication and Pub Admin at both
 Federal Polytechnic, Oko and Nnamdi Azikiwe University, Awka.</p>
 <p>
Reporter/ Editor and former Head of News Section, ABS, Onitsha. Former Deputy Director, News And Current Affairs
Department, ABS, Awka.
Positions held
<ul>
    <li> Former Secretary, ABS NUJ Chapel.
    </li>
    <li>Former Treasurer, NUJ. Anambra State Council.
</li>
    <li>Two term  National Zonal Secretary, NUJ, South East.
</li>
    <li>Immediate Past National Treasurer, NUJ.
</li>
    <li>Member, Nigerian Guild of Editors.
</li>
    <li>Former Vice Chairperson, Nigeria Association of Women Journalists, Anambra State.
</li>
    <li>Former Chairperson, Nigeria Association of Women Journalists, Anambra State.
</li>
    <li>Member, Rotary Club of Awka GRA.
</li>
    <li>hief Press Secretary to  former Deputy Governor, Dame Virgie Etiaba.
Attachments area
    </li>
</ul>
"]
);

$property_alias = "Executives and Board Members of Kpakpando fm Radio and Kpakpando South East Television";

$title = "Executives and Board Members of Kpakpando fm Radio and Kpakpando South East Television";

?>
<!--<img src="img/board/monica.jpg">
<img src="img/board/ikwu.jpg">-->
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";?>

<div class="banner-1">
</div>

<!-- technology-left -->

<div class="technology">
    <div class="container">

        <div class="col-md-9 technology-left">
            <div class="w3agile-1">
                <div class="team">
                    <h3 class="team-heading">
                        <?php if(!empty($property_alias)):?>
                            Meet <?php echo $property_alias;?>
                        <?php endif;?>
                    </h3>
                    <div class="team-grids">
                        <?php if(!empty($board_members)):?>
                            <?php foreach(array_chunk($board_members,2)as $users_2):?>
                                <div class="col-md-6 team-grid">
                                    <?php foreach($users_2 as $user):?>
                                        <div class="team-grid1">
                                            <?php if(empty($user[3])):?>
                                                <img src="/api/img/board/board-member.png" alt="image of <?php echo($user[1]);?> as board of kpakpando media group" class="img-responsive">
                                            <?php else:?>
                                                <img src="<?php echo($user[3]);?>" alt="image of <?php echo($user[1]);?> as board of kpakpando media group " class="img-responsive">
                                            <?php endif; ?>
                                            <div class="p-mask">
                                                <p>
                                                    <span ><i class="glyphicon glyphicon-map-marker"></i><?php echo($user[2]);?></span>
                                                    <span ><i class="glyphicon glyphicon-user"></i><?php echo($user[1]);?></span>
                                                    <span ><i class="glyphicon glyphicon-map-marker"></i><?php echo($user[0]);?></span>

                                                </p>
                                            </div>
                                        </div>
                                        <h5>
                                            <?php echo($user[1]);?>
                                            <span><?php echo($user[0]);?></span>
                                        </h5>
                                        <?php if(!empty($user[4])):?>
                                            <h5 class="" style="color: #000000;" data-toggle="collapse" data-target="#aboutdiv<?php echo(array_search($user,$board_members));?>">
                                                More About
                                            </h5>
                                            <h6 class="collapse" id="aboutdiv<?php echo(array_search($user,$board_members));?>" style="background: gray;
                                             color: #000000; font-weight: bolder; text-align: left; padding: 15px;"><?php echo $user[4];?></h6>
                                        <?php endif;?>
                                        <h6></h6>
                                        <br>
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
                                <br>
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
