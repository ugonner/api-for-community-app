
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
                            <h4 class="modal-title" id="donateModalLabel">DONATE NOW</h4>
                        </div>
                        <div>

                            <form class="form-donation" action="/api/donation/index.php" method="POST" enctype="multipart/form-data">

                                <h3 class="title-style-1 text-center">Thank you for your donation <span class="title-under"></span>  </h3>

                                <div class="row">

                                    <p>
                                        <b>
                                            Bearing limitations in Fund, Time and Human resource,
                                            JONAPWD Anambra State,
                                            provides her services: Advocacy, human resource development programs
                                            according to set priority areas to maximize available resources.

                                            We will welcome any suggestions or donations made towards this priority areas.
                                        </b>
                                    </p>

                                    <div class="form-group col-md-12 ">
                                        <label for="amount">Amount <i>( Please put only digits no other characters OR symbols)</i></label>
                                        <input type="tel" name="amount" class="form-control" id="amount" placeholder="AMOUNT(N)">
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control" name="firstname" value="<?php (empty($_POST["firstname"])? "full name": $_POST["firstname"] );?>" required="true">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input disabled style="background: transparent" type="text" class="form-control" >
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <input type="email" class="form-control" name="email"  value="<?php (empty($_POST["email"])? "email": $_POST['email'] );?>" required="true">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input type="tel" class="form-control" name="mobile"  value="<?php (empty($_POST["mobile"])? "phone number": $_POST["mobile"] );?>" required="true">
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
                                        <textarea cols="30" rows="4" class="form-control" name="note">
                                            <?php (empty($_POST["note"])? "brief note": $_POST["note"] );?>
                                        </textarea>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <input type="file" name="profilepic">
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary pull-right" name="makedonation" >DONATE NOW</button>
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