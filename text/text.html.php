<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php";?>

    <div class="banner-1">
        <h2 class="text-center banner-fadein" style="padding: 20px;">SMS Portal For JONAPWD</h2>
    </div>

    <div class="container banner" >
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <?php
                $property_alias = (isset($property_alias)? $property_alias : ' ');
                $output_text = (isset($_GET["output"]) ? $_GET["output"]: ' ');
                ?>
                <div class="panel" style="background: transparent;">
                    <h3 class="panel-heading"><?php echo($output_text)?></h3>
                    <h5 class="panel-body">Selected: <?php echo($property_alias);?></h5>
                </div>

                <div class="btn btn-success btn-lg btn-block" data-toggle="collapse" data-target="#sortusersdiv">
                    Select People To Send SMS
                </div>

                <div class="collapse" id="sortusersdiv">
                    <a href="/api/text/?gubp&property=all&value=all&property-alias=All" class="btn btn-block btn-primary" >
                        All Persons
                    </a>

                    <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bycluster">
                        Sort by Cluster
                    </button>
                    <div class="form-group collapse" id="bycluster">
                        <form method="get" action="/api/text/">
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

                    <button class="btn btn-block btn-primary" data-toggle="collapse" data-target="#bygender">
                        Sort by Gender
                    </button>
                    <div class="form-group collapse" id="bygender">
                        <form method="get" action="/api/text/">
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
                        <form method="get" action="/api/text/">
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
                        <form method="get" action="/api/text/">
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
                        <form method="get" action="/api/text/">
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
            </div>
            <div class="col-sm-3"></div>
        </div>


        <div class="row">

            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="banner-1">
                    <h3 class="btn btn-lg">
                        <span class="page-header">SMS Portal</span>
                    </h3>
                </div>
                <div class="form-group">
                    <form class="form-group" action="/api/text/index.php" method="POST">
                        <div class="form-group">
                            <div>
                                <h4 class="btn btn-lg">Sender Name</h4>
                                <label for="senfername">Sender Name</label>
                                <input class="form-control" type="text" name="sendername" placeholder="Enter Sender Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <h4 class="btn btn-lg">Receivers' Mobile No(s)</h4>
                                <label for="receiversmobiles">Receiver's Mobile No(s)</label>
                                <textarea name="receiversmobiles" rows="15" id="receiversmobiles" class="form-control">
                                    <?php if(!empty($users)):?>
                                        <?php
                                        $usersmobiles = ' ';
                                        for($i=0; $i<count($users); $i++){
                                            $usersmobiles .= $users[$i]["mobile"].',';
                                            substr($usersmobiles,0,-1);
                                            echo($usersmobiles);
                                        }?>
                                    <?php endif; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <h4 class="btn btn-lg">Receivers' Names</h4>
                                <label for="usersfirstnames">Receiver's Name(s)</label>
                                <textarea id="usersfirstnames" name="receiversnames" rows="15" class="form-control">
                                    <?php if(!empty($users)):?>
                                        <?php
                                        $usersfirstnames = ' ';
                                        for($i=0; $i<count($users); $i++){
                                            $usersfirstnames .= $users[$i]["firstname"].',';
                                            substr($usersfirstnames,0,-1);
                                            echo($usersfirstnames);
                                        }?>
                                    <?php endif; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <h4 class="btn btn-lg">Message</h4>
                            <label for="message">Message</label>
                            <textarea placeholder="Type In Message" id="message" rows="5" class="form-control" name="message"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="sendSMSes" class="btn btn-lg btn-success">
                                <span class="glyphicon glyphicon-envelope"></span> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
    <!-- technology-left -->

<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php";?>