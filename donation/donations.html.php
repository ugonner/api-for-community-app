<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php"; ?>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/admin/admin.class.php";


if(empty($_SESSION)){
    session_start();
}
$userid = (empty($_SESSION['userid'])? null : $_SESSION['userid']);

?>

<div class="page-heading text-center">

    <div class="container zoomIn animated">

        <h1 class="page-title">Donations<span class="title-under"></span></h1>
        <p class="page-description">
            Donations <?php $output = (empty($_GET['output'])? "": $_GET['output']);
            echo($output);
            ?>
        </p>

    </div>

</div>


    <div class="container">

        <div class="row">

            <div class="col-md-2 col-md-offset-1">
                <?php $admin = new admin();
                $IsAdmin = $admin->isAdmin($userid);
                if($IsAdmin):?>
                    <a class="btn btn-block btn-lg btn-primary" href="/api/donation/makedonation.html.php">
                        Add New Donor
                    </a>
                <?php endif; ?>

            </div>

            <div class="col-md-6 col-sm-12">

                <h2 class="title-style-2">DONATIONS <span class="title-under"></span></h2>

                <?php if(!empty($donations)):?>
                    <?php
                    include_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/pagination.html.php";
                    ?>
                    <?php foreach($donations as $d):?>
                        <div class="row">
                            <div class="col-xs-8">
                                Donor: <b><?php echo $d["firstname"];?></b>
                                <br>Amount: <b><?php echo $d["amount"];?></b>
                                <br>For: <b><?php echo $d["focalareaname"];?></b>
                                <br>Pledged On: <b><?php echo $d["dateofpledge"];?></b>

                                <h5><b>Contact:</b></h5>
                                <span class="fa fa-mail-forward"></span><b><?php echo $d["email"];?></b>
                                <br><span class="fa fa-phone"></span><b><?php echo $d["mobile"];?></b>

                                <h5><b>Comment:</b></h5>
                                <b><?php echo $d["note"];?></b>
                            </div>
                            <div class="col-xs-4">
                                <div>
                                    <img src="<?php echo($d['profilepic'])?>" class="img-responsive" alt="image of donor, <?php echo($d['firstname'])?>">
                                </div>
                            </div>
                        </div>
                        <?php if($IsAdmin):?>
                            <div>
                                <button class="btn btn-lg btn-primary btn-block" data-target="#d<?php echo($d['donationid'])?>" data-toggle="collapse">
                                    Edit Donation
                                </button>

                                <div class="collapse" id="d<?php echo($d['donationid'])?>">
                                    <form class="form-donation" action="/api/donation/index.php" method="POST" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="form-group col-md-12 ">
                                                <label for="amount">Amount <i>( Please put only digits no other characters OR symbols)</i></label>
                                                <input type="tel" name="amount" class="form-control" id="amount" value="<?php echo($d['amount']);?>" placeholder="">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="firstname" value="<?php echo($d['firstname']);?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="surname" value="<?php echo($d['surname']);?>">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="email" class="form-control" name="email" value="<?php echo($d['email']);?>" >
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="tel" class="form-control" name="mobile" value="<?php echo($d['mobile']);?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div>
                                                    <label for="faid">Please Select Our Priority Area You Are Donating To:</label>
                                                    <select class="form-control" id="faid" name="faid">
                                                        <option value="">Select Priority Area</option>
                                                        <?php foreach($headfocalareas as $dfa):?>
                                                            <option value="<?php echo $dfa[0]; ?>"><?php echo $dfa[1]; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <textarea cols="30" rows="4" class="form-control" name="note" placeholder="Additional note">
                                                    <?php echo($d['note']);?>
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <input type="hidden" name="focalareaid-original" value="<?php echo($d['focalareaid']);?>">
                                                <input type="hidden" name="pgn" value="<?php echo($pgn);?>">
                                                <input type="hidden" name="profilepic-original" value="<?php echo($d['profilepic']);?>">
                                                <input type="hidden" name="donationid" value="<?php echo($d[0]);?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group">
                                                <label for="#profilepic">Display Picture</label>
                                                <input type="file" name="profilepic" id="profilepic" style="background: transparent;">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <button type="submit" class="btn btn-primary pull-right" name="updatedonation" >DONATE NOW</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>
                        <h3 class="text-center">
                            No Donations Yet.
                        </h3>
                    </div>
                <?php endif;?>

            </div>
            <div class="col-md-2 col-md-offset-1">

            </div>

        </div> <!-- /.row -->


    </div>


<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/footer2.html.php"; ?>
