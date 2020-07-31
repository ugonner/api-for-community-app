           <!--Beginning of send message block-->
           <div>
               <button class="btn btn-success" type="button"
                       data-toggle="collapse" data-target="#chatdiv<?php echo($user[0]);?>">
                   Chat
               </button>
               <button class="btn btn-success" type="button"
                       data-toggle="collapse" data-target="#SMSdiv<?php echo($user[0]);?>">
                   SMS To Phone
               </button>
           </div>
           <div class="row">
               <div class="col-sm-6">
               <div class="collapse" id="chatdiv<?php echo($user[0]);?>">
                   <div class="form-group">
                       <form action="/api/user/usermessage/index.php" class="form-group"
                           method="post">
                           <div class="form-group">
                               <label for="chattextarea">Chat Message</label>
                               <textarea class="form-control" id="chattextarea"
                                         name="message">

                               </textarea>
                               <input type="hidden" name="rxid"
                                   value="<?php echo($user[0]);?>">
                           </div>
                           <div class="form-group">

                               <button type="submit" name="sendmessage" class="btn-success">
                                   Send Chat
                               </button>
                           </div>
                       </form>
                   </div>
               </div>
               </div>
               <div class="col-sm-6">
               <div class="collapse" id="SMSdiv<?php echo($user[0]);?>">
                   <div class="form-group">
                       <form action="/api/text/index.php" class="form-group" method="post">
                           <div class="form-group">
                               <label for="SMStextarea">SMS Message</label>
                               <textarea class="form-control" id="SMStextarea"
                                         name="message">

                               </textarea>
                               <input type="hidden" name="userid"
                                      value="<?php echo($user[0]);?>">
                           </div>
                           <div class="form-group">

                               <button type="submit" name="sendSMS" class="btn-success">
                                   Send SMS
                               </button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           </div>
           <!--End of send message block-->
