<?php include $_SERVER['DOCUMENT_ROOT'].'/ugonna/includes/htmlpages/homeheader.html.php'?>

<div class="container-fluid">
    <div class='col-lg-3'>
    </div>

    <div class="col-lg-6">
        <?php if(!empty($users)):?>
            <?php foreach($users as $user):?>
                <div class="thumbnail">
                    <img src="<?php echo($user["profilepic"]);?>" alt="picture of
                    <?php echo " ". $user["firstname"]." ". $user["surname"];?>"/>
                    <h5><?php echo " ". $user["firstname"]." ". $user["surname"];?></h5>
                    <?php echo " ". $user["role.name"];?><br/>
                    <?php echo " ". $user["state"];?><br/>

                    <div>
                        <button class="btn-info" data-toggle="collapse"
                            data-target="#textdiv">
                            SEND FREE SMS TO HIS PHONE <span class="caret"></span>
                            </button>
                        <div class="collapse" id="textdiv">
                            <div class="form-group">
                                <form class="form-group">
                                    <div class="form-group">
                                    <label for="smstextarea">Type Message</label>
                                    <textarea class="form-control" id="smstextarea">

                                    </textarea>
                                    <input type="hidden" name="userid"
                                           value="<?php echo $user[0];?>">
                                    </div>
                                    <div class="form-group">
                                    <input class="form-control" name="sendmessage"
                                        type="submit" value="SEND TEXT"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php else:?>
            <h1>NO USER YET FOR THIS SEARCH, PLEASE CHECK BACK AGAIN SOON</h1>
        <?php endif;?>
    
    </div>

    <div class="col-lg-3">
    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/ugonna/includes/htmlpages/footer.html.php'?>
</body>
</html>