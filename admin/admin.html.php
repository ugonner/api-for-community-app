<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/donation/donation.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/admin/admin.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/advert/advert.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/helpers/htmler.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';
$admin = new admin();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php if(isset($_GET["output"])){
                $output = $_GET["output"];
                echo "<h4 class='text-center'>".$output."</h4>";
            }
            if(isset($error)){
                $output = $error;
                echo "<h4 class='text-center'>".$output."</h4>";
            }?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
                <div>
                    <h2 class="text-center text-capitalize">Welcome to admin panel</h2>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                    
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <form class="form-group form-inline" action="/api/admin/index.php"
                                method="post">
                                <div class="form-group">
                                    <label for="nemsearch">Search For User By Firstname or surname or mobile or email</label>
                                    <input type="search" class="form-control" name="nem" id="nemsearch"
                                        placeholder="Enter User Search KeyWord"/>

                                    <button class="btn-success" type="submit" name="gubnem">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div>
                <h4 id="outputh" class="text-center text-capitalize"></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div>
                <?php if(isset($users)):?>
                    <h5 class="text-center">Select A User For Action/Edit</h5>
                    <?php for($i=0; $i<count($users); $i++):?>
                        <div class="row">
                            <div class="col-sm-1">
                            <img src="<?php echo $users[$i]["profilepic"];?>"
                                style="width:35px; height: 40px;" />
                            </div>
                            <div class="col-sm-2">
                                <h6 class="text-capitalize"><?php echo $users[$i]["firstname"]
                                    .", ".$users[$i]["surname"];?></h6>
                                <a href="/api/admin/index.php?sufa&uid=<?php echo $users[$i][0];?>">
                                    <button class="btn-success" type="button">
                                        Select Me
                                    </button>
                                </a>
                            </div>
                            <div class="col-sm-10">

                            </div>
                        </div>

                     <?php endfor;?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <h5 class="page-header text-capitalize">User admin</h5>
            <?php if(isset($user)):?>
            <div class="row">
                <div class="col-sm-4">
                    <img src="<?php echo $user["profilepic"];?>"
                        style="width: 60px; height: 70px; "/>
                </div>
                <div class="col-sm-8">
                    <h5 class="text-capitalize">
                        <?php echo $user["firstname"].". ".$user["surname"];?>
                        <br/> Selected for actions
                    </h5>
                </div>
            </div>
            <div>
            <button type="button" class="btn-success btn-block btn-lg" id="AURbtn" data-toggle="collapse"
                data-target="#AURdiv">
               Certify User A Role
            </button>
            <div class="collapse" id="AURdiv">
                <div>
                    <h5>Select A Role/Profession From The Role Selector And Click Assign</h5>
                    <div class="form-group">
                        <form class="form-group" action="/api/admin/index.php"
                              method="post">
                            <div class="form-group">
                                <label for="roleselect1">Select Role/Profession Name</label>
                                <select name="rid" id="roleselect1" class="form-control">
                                    
                                </select>
                                <input type="hidden" name="uid" value="<?php echo $user[0];?>">
                                <label for="rolenotetextarea">Required. A Brief On User's Profession</label>
                                <textarea id="rolenotetextarea" class="form-control" name="rolenote">

                                </textarea>
                            </div>
                            <button type="submit" class="btn-success" name="aur">
                                Certify Role/Profession
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            <div>
                <button type="button" id="MUSAbtn" class="btn-success btn-block btn-lg" data-toggle="collapse"
                        data-target="#MUSAdiv">
                    Make User A Super Admin
                </button>
                <div id="MUSAdiv" class="collapse">
                    <h5> Click Make SuperAdmin</h5>
                    <a id="MUSAa" href="/api/admin/index.php?musa&uid=<?php echo $user[0];?>">
                        <button type="button" class="btn-success">
                            Make SuperAdmin
                        </button>
                    </a>
                    <a id="MUSAa" href="/api/admin/index.php?umusa&uid=<?php echo $user[0];?>">
                        <button type="button" class="btn-success">
                            Remove As SuperAdmin
                        </button>
                    </a>
                </div>
            </div>

            <div>
                <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                    data-target="#BUdiv">
                    Block User
                </button>
                <div id="BUdiv" class="collapse">
                    <h5> Click Block This User</h5>
                    <a id="BUa" href="/api/admin/index.php?blockuser&uid=<?php echo $user[0];?>">
                        <button type="button" class="btn-success">
                            Block This User
                        </button>
                    </a>
                    <a id="BUa" href="/api/admin/index.php?unblockuser&uid=<?php echo $user[0];?>">
                        <button type="button" class="btn-success">
                            Un-Block This User
                        </button>
                    </a>
                </div>
            </div>

            <div>
                <div class="btn btn-block btn-success btn-lg" data-toggle="collapse" data-target="#AUCdiv">
                    Add User To <br> Social Welfare Packages
                </div>
                <div class="collapse" id="AUCdiv">
                    <div class="form-group">
                        <form method="POST" action="/api/admin/">

                            <h5>Tick The Social Welfare to Add This Person To</h5>
                            <div class="form-group">
                            <?php
                               $userid = $user[0];
                               for($i=0; $i<count($head_clusters); $i++):?>
                                <?php if(!$admin->isClusterMember($userid,$head_clusters[$i]['id'])):?>
                                       <input type="checkbox" id="cluster<?php echo($i);?>" name="cluster<?php echo($i);?>" value="<?php echo($head_clusters[$i]['id']);?>" />
                                       <label for="cluster<?php echo($i);?>"><?php echo($head_clusters[$i]['name']);?></label>
                                        <br>
                               <?php endif; ?>
                             <?php endfor; ?>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="cluster-count" value="<?php echo(count($head_clusters)); ?>">
                                <input type="hidden" name="userid" value="<?php echo($userid); ?>">
                                <button class="btn btn-danger btn-lg btn-block" type="submit" name="addusertoclusters">
                                    Add User
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php endif;?>
        </div>
        <div class="col-sm-3">
            <div class="row">

                <h5 class="page-header text-capitalize">post admin</h5>
                <?php $newarticles = $headarticle->checkNewArticles($_SESSION["userid"]);?>
                <div class="btn btn-lg btn-block btn-success">
                    <a class="btn" href="/api/article/?getallarticles">
                        view posted articles <span class="btn btn-danger"><?php echo($newarticles); ?></span>
                    </a>

                </div>

                <div>
                    <a href="/api/article/specialpost.html.php" class="btn btn-success btn-lg btn-block">
                        Post Organisation's Activity
                    </a>
                </div>

                <div>

                    <button type="button" class="btn-block btn-success btn-lg" data-toggle="collapse"
                        data-target="#PACdiv" id="PABCbtn">
                        Post Article In Any Category
                    </button>
                    <div class="collapse" id="PACdiv">
                        <div class="form-group">
                            <form class="form-group" action="/api/article/adminarticleform.html.php" method="GET">

                                <div class="form-group">
                                    <button type="submit" class="btn-lg btn-success">
                                        Post Article
                                    </button>
                                </div>
                           </form>
                        </div>

                    </div>
                </div>


                <div>
                    <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                            data-target="#ACdiv">
                        Add New Article Category
                    </button>
                    <div class="collapse" id="ACdiv">
                        <h5> Click Add New Category</h5>
                        <div class="form-group">
                            <form class="form-group" action="/api/admin/index.php"
                                  method="post">
                                <div class="form-group">
                                    <label for="categoryname">Category Name</label>
                                    <input type="text" name="name" id="categoryname" class="input-lg form-control"
                                           placeholder="New Category Name" required/>
                                </div>
                                <div class="form-group">
                                    <label for="categorynote">Category Description</label>
                                    <input type="text" name="categorynote" id="categorynote" class="input-lg form-control"
                                           placeholder="New Category Brief" />
                                </div>
                                <div class="form-group">
                                    <label for="parent_categoryname">Parent Category (If any?)</label>
                                    <select name="parent_categoryid" id="parent_categoryname" class="input-lg btn-block">
                                        <option value="">Select Parent Category</option>
                                        <?php foreach($head_all_categories as $headcat):?>
                                            <option value="<?php echo($headcat[0]);?>"><?php echo($headcat[1]);?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <button type="submit" class="btn-success btn-lg btn-block" name="addcategory">
                                    Add New Article Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div>
                    <a class="btn btn-lg btn-block btn-success" href="/api/gallery/galleryform.php">
                        Upload Gallery Files
                    </a>
                </div>

        </div>
        <div class="row">
            <h4 class="page-header text-capitalize">Cluster And Thematic Areas </h4>
            <div>
                <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                        data-target="#FAdiv">
                    Add New Cluster
                </button>
                <div class="collapse" id="FAdiv">
                    <h5> Click Add New Cluster</h5>
                    <div class="form-group">
                        <form class="form-group" action="/api/admin/index.php"
                              method="post">
                            <div class="form-group">
                                <label for="categoryname">Name</label>
                                <input type="text" name="name" id="categoryname" class="form-control"
                                       placeholder="New Thematic-Area Name" required />
                            </div>
                            <div class="form-group">
                                <label for="CLnote">Brief Note:</label>
                                <textarea class="form-control" id="CLnote" name="note" placeholder="Notes About Focal Area" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-lg btn-block btn-success" name="addcluster">
                                    Add New Cluster
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div>
                <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                        data-target="#FAdiv">
                    Add New Organization's Priority Area
                </button>
                <div class="collapse" id="FAdiv">
                    <h5> Click Add New Theamatic Area</h5>
                    <div class="form-group">
                        <form class="form-group" action="/api/admin/index.php"
                              method="post">
                            <div class="form-group">
                                <label for="categoryname">Name</label>
                                <input type="text" name="name" id="categoryname" class="form-control"
                                       placeholder="New Thematic-Area Name" required />
                            </div>
                            <div class="form-group">
                                <label for="FAnote">Brief Note:</label>
                                <textarea class="form-control" id="FAnote" name="note" placeholder="Notes About Focal Area" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-lg btn-block btn-success" name="addfocalarea">
                                    Add New Thematic Area
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                        data-target="#Gdiv">
                    Add New Group (family)
                </button>
                <div class="collapse" id="Gdiv">
                    <h5> Click Add New Group</h5>
                    <div class="form-group">
                        <form class="form-group" action="/api/group/index.php"
                              method="post">
                            <div class="form-group">
                                <label for="groupname">Name</label>
                                <input type="text" name="name" id="groupname" class="form-control"
                                       placeholder="New Group's Name" required />
                            </div>
                            <div class="form-group">
                                <label for="Gnote">Group's Brief:</label>
                                <textarea class="form-control" style="min-height: 400px;" id="Tnote" name="note" placeholder="Notes About Focal Area" required></textarea>
                            </div>

                            <div class="form-group">
                                <?php
                                require_once $_SERVER["DOCUMENT_ROOT"].'/api/group/group.class.php';
                                $group = new Group();
                                $grouplevel1s = $group->getGroupLevel1s();
                                $grouplevel2s = $group->getGroupLevel2s();
                                $grouplevel3s = $group->getGroupLevel3s();
                                ?>
                                <div class="text-capitalize btn btn-lg btn-block" data-target="#grouplevel2div" data-toggle="collapse">
                                    Only if this is a village or kindred,<br> select it's ward
                                </div>

                                <div class="collapse" id="grouplevel2div">
                                    <label for="grouplevel1select">select a ward</label>
                                    <select id="grouplevel1select" class="form-control" name="grouplevel1id">
                                        <option value="">select ward</option>
                                        <?php foreach($grouplevel1s as $g1):?>
                                            <option value="<?php echo($g1['id']);?>"><?php echo($g1['name']);?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text-capitalize btn btn-lg btn-block" data-target="#grouplevel3div" data-toggle="collapse">
                                    Only if this is a kindred, select it's village
                                </div>

                                <div class="collapse" id="grouplevel3div">
                                    <label for="grouplevel2select">select the village</label>
                                    <select class="form-control" id="grouplevel2select" name="grouplevel2id">
                                        <option value="">select village</option>
                                        <?php foreach($grouplevel2s as $g2):?>
                                            <option value="<?php echo($g2['id']);?>"><?php echo($g2['name']);?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-lg btn-block btn-success" name="addgroup">
                                    Add New Group
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        </div>


        <div class="col-sm-6">
            <div>
                <h5 class="page-header">Staff / Users Management</h5>
            </div>

            <div>
                <button type="button" class="btn-success btn-block btn-lg" data-toggle="collapse"
                        data-target="#ANRdiv">
                    Add New Staff Role
                </button>
                <div id="ANRdiv" class="collapse">
                    <h5> Add Staff Role</h5>
                    <div class="form-group">
                        <form class="form-group" action="/api/admin/index.php"
                              method="post">
                            <div class="form-group">
                                <label for="rolename">Role/Profession Name</label>
                                <input name="name" id="rolename" class="form-control" type="text"
                                       placeholder="Enter the Name Of The Role/Profession"/>
                            </div>
                            <button type="submit" class="btn-success" name="addrole">
                                Add Role
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div>

            <div>
                <span class="btn btn-lg btn-success btn-block" data-toggle="collapse" data-target="#editrolesdiv">
                    Modify User Roles/Positions
                </span>
            </div>
            <div class="collapse" id="editrolesdiv">
                <?php foreach($headroles as $adr):?>
                    <div class="form-group form-horizontal">
                        <form class="form-inline" action="/api/admin/index.php" method="POST">
                            <label for="rolename">Role</label>
                            <input type="text" name="value" value="<?php echo($adr['name']);?>" class="form-horizontal input-lg" id="rolename"/>
                            <input type="hidden" name="roleid" value="<?php echo($adr['id']);?>"/>
                            <input type="hidden" name="pty" value="name"/>
                            <button type="submit" name="editrole" class="btn bg-transparent">
                                Update
                            </button>
                        </form>
                    </div>
                <?php endforeach;?>
            </div>
            <a href="/api/admin/adminregistration.html.php">
                <button type="button" class="btn-success btn-block btn-lg">
                    Add A User / Staff
                </button>
            </a>
            </div>
            <div class="btn btn-success btn-lg btn-block" data-toggle="collapse" data-target="#sortusersdiv">
                View Registered Users
            </div>
            <div class="collapse" id="sortusersdiv">
                <a href="/api/user/?gubp&property=all&value=all&property-alias=All" class="btn btn-block btn-primary" >
                    All Persons
                </a>
                <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bygender">
                    Sort by Gender
                </button>
                <div class="form-group collapse" id="bygender">
                    <form method="get" action="/api/user/">
                        <input type="hidden" name="property" value="gender">
                        <input type="hidden" name="property-alias" value="gender">
                        <div class="form-group">
                            <label for="selectgender">Gender</label>
                            <select id="selectgender" class="form-control input-lg" name="value">
                                <option value="F">female</option>
                                <option value="M">Male</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block" name="gubp">
                                View Users
                            </button>
                        </div>
                    </form>
                </div>



                <!--sort by location-->
                <?php
                require_once $_SERVER["DOCUMENT_ROOT"].'/api/location/location.class.php';
                $location = new location();
                $locations = $location->getLocations();
                $sublocations = $location->getSubLocations();

                ?>
                <!--sort by location-->
                <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bylocation">
                    Sort by Location
                </button>
                <div class="form-group collapse" id="bylocation">
                    <form method="get" action="/api/user/">
                        <input type="hidden" name="property" value="locationid">
                        <input type="hidden" name="property-alias" value="Location">
                        <div class="form-group">
                            <label for="selectlocation">Major Location</label>
                            <select id="selectlocation" class="form-control input-lg" name="value">
                                <option value="">Select</option>
                                <?php foreach($locations as $l):?>
                                        <option value="<?php echo($l['locationid'])?>"><?php echo($l['locationname'])?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block" name="gubp">
                                View Users
                            </button>
                        </div>
                    </form>
                </div>


                <!--sortby sublocation-->
                <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bysublocation">
                    Sort by Sub-Locations
                </button>
                <div class="form-group collapse" id="bysublocation">
                    <form method="get" action="/api/user/">
                        <input type="hidden" name="property" value="sublocationid">
                        <input type="hidden" name="property-alias" value="Sub-Locations">
                        <div class="form-group">
                            <label for="selectgender">Sub-Location</label>
                            <select id="selectgender" class="form-control input-lg" name="value">
                                <option value="">Select</option>
                                <?php foreach($sublocations as $sl):?>
                                    <option value="<?php echo($sl['sublocationid'])?>"><?php echo($sl['sublocationname'])?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block" name="gubp">
                                View Users
                            </button>
                        </div>
                    </form>
                </div>


                <!--sortby date of birth-->
                <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bydateofbirth">
                    Sort by Birthday
                </button>
                <div class="form-group collapse" id="bydateofbirth">
                    <form method="get" action="/api/user/">
                        <input type="hidden" name="property" value="dateofbirth">
                        <input type="hidden" name="property-alias" value="Birth-Days">
                        <input type="hidden" name="value" value="<?php echo(date('Md'));?>">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block" name="gubp">
                                View Users
                            </button>
                        </div>
                    </form>
                </div>


            </div>
            <duv>

                <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bycluster">
                    Sort by Cluster
                </button>
                <div class="form-group collapse" id="bycluster">
                    <form method="get" action="/api/user/">
                        <input type="hidden" name="property" value="clusterid">
                        <input type="hidden" name="property-alias" value="cluster">
                        <div class="form-group">
                            <label for="selectgender">Cluster</label>
                            <select id="selectgender" class="form-control input-lg" name="value">
                                <?php foreach($head_clusters as $hcl):?>
                                    <option value="<?php echo($hcl['id']);?>"><?php echo($hcl['name']);?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block" name="gubp">
                                View Users
                            </button>
                        </div>
                    </form>
                </div>
            </duv>
            <div class="">
                <a href="/api/text/text.html.php" class="btn btn-success btn-lg btn-block">
                    Send Custom SMS To Members
                </a>
            </div>


            <!--check new donations-->
            <h4 class="page-header">Donations:</h4>
            <?php
                $donation = new Donation();
                $newdonations = $donation->checkForNewDonations($_SESSION["userid"]);
            ?>
            <a href="/api/donation/index.php?getdonations" class="btn btn-success btn-lg btn-block">
                See Donations <span class="btn btn-primary"><?php echo $newdonations; ?></span>
            </a>
            <a href="/api/donation/makedonation.html.php" class="btn btn-success btn-lg btn-block">
                Add Donor
            </a>

    </div>
    </div>
    <!--end of row in the fluid;-->
</div>


<!-- script for lgaselecthp-->
<script type="text/javascript">
    $("#stateselecthp").change(function(){displayLgashp()});
    function displayLgashp(){
        var sid = document.getElementById('stateselecthp')
            .options[document.getElementById('stateselecthp').selectedIndex].value;
        $.get('/api/state/index.php?sid='+sid, function(responseText) {
            $("#lgaselecthp").empty();
            $("#lgaselecthp").append(responseText);
        });
    }
<!-- end script for lgaselecthp-->
    <!-- script for roleselect -->
        $("#AURbtn").click(function(){displayroles()});
    function displayroles(){
        $.get('/api/user/index.php?getroles', function(responseText) {
            $("#roleselect1").empty();
            $("#roleselect1").append(responseText);
        });
    }
    <!-- end script for roleselect-->
    <!-- end script for productcategoryselect for productcategoryadmin-->
    <!-- script for roleselect -->
    <!-- end script for productcategoryadmin-->
    <!-- script for select postarticleinany category -->
    
    <!-- end script for productcategoryselect for productcategoryadmin-->
    <!-- script for roleselect -->
    <!-- script for link to make productcategory admin -->
    <!-- end script for build link to make productcategory admin-->
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/footer2.html.php';?>
