
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/inc/htmls/header.html.php"; ?>

<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">

            <!-- Donate Modal -->

            <div>

                <div class=""  >
                    <div class="">
                        <div>

                            <div class="text-right">
                                <span class="btn btn-danger" id="donatamodalclosebtn">Thanks</span>
                            </div>
                            <h4 class="modal-title" id="donateModalLabel">Place Ad</h4>
                        </div>
                        <div>

                            <form class="form-donation" action="/api/advert/index.php" method="POST" enctype="multipart/form-data">

                                <h3 class="title-style-1 text-center">Thank you for your patronage <span class="title-under"></span>  </h3>

                                <div class="row">

                                    <p>
                                        <p><?php $output = (isset($error)? ($error):("no error"));?></p>
                                    <p><?php $output = (isset($output)? ($output):("no output"));
                                        echo($output);
                                        ?></p>
                                        <b>
                                            Adverts must conform to kpakpando media standards, no vulgarities.
                                            <h3>And You must be logged in to proceed</h3>
                                            <a class="btn" href="/api/user/">Log in / Register</a>
                                            We will welcome any suggestions or donations made towards this priority areas.
                                        </b>

                                    </p>

                                    <div class="form-group col-md-12 ">
                                        <label for="amount">Amount <i>( Please put only digits no other characters OR symbols)</i></label>
                                        <input type="tel" name="amount" class="form-control input-lg" id="amount" placeholder="AMOUNT(N)"
                                            value="<?php if(isset($_POST['amount'])){echo $_POST['amount'];}?>">
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control input-lg" name="title" required placeholder="Adverts title*"
                                               value="<?php if(isset($_POST['title'])){echo $_POST['title'];}?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control input-lg" name="detail" placeholder="a bit more detail"
                                               value="<?php if(isset($_POST['detail'])){echo $_POST['detail'];}?>">
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <input type="url" class="form-control input-lg" name="adverturl" placeholder="redirect Url" required="true"
                                               value="<?php if(isset($_POST['advert'])){echo $_POST['adverturl'];}?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label form="adimg">Add your advert image, important</label>
                                        <input type="file" class="form-control" name="advertimagedisplayname" placeholder="" required="true" accept="image/*" >
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <div>
                                            <label for="cid">Please Select Category Your Product Belong:</label>
                                            <select class="form-control" id="cid" name="cid" required>
                                                <option value="">Select Category</option>
                                                <?php foreach($head_all_categories as $dc):?>
                                                    <option value="<?php echo $dc['id']; ?>"><?php echo $dc['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div>
                                            <label for="faid">Please Select Placement Plan:</label>
                                            <select class="form-control" id="faid" name="placementid">
                                                <option value="">Select Placement Plan</option>
                                                <option value="1">Home Page Top</option>
                                                <option value="2">Home Page Side</option>
                                                <option value="3">Other Page Top</option>
                                                <option value="4">Other Page Side</option>

                                            </select>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label>By placing Ad you agree to the terms and conditions of Kpakpando Media</label>
                                        <button type="submit" class="btn btn-primary pull-right" name="placead" >Place Ad</button>
                                    </div>

                                </div>





                            </form>

                        </div>
                    </div>
                </div>

            </div> <!-- /.modal -->
        </div>
        <div class="col-sm-3"></div>
    </div>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/api/includes/htmlpages/footer.html.php"; ?>