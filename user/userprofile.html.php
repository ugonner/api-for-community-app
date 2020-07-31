<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/location/location.class.php';
?>

<div class="container-fluid">
   <div class="col-sm-3">
       <div class="col-sm-12">
   <?php if(isset($_GET["output"]) OR isset($error)){
         $output = (empty($_GET["output"]) ? $error : $_GET["output"]);
         echo "<h4 class='text-center'>".$output."</h4>";
         }?>
    </div>
       <div class="col-sm-12">
       </div>
   </div>
   <div class="col-sm-6">
   <?php if(isset($user)):?>
       <div class="row">
       <h2 class="text-center">Welcome To <?php echo $user["firstname"]."'s ";?> Profile &nbsp;

           <?php if(isset($user["lastactivity"])):?>
               <?php $lastactivity = $user["lastactivity"];
               $interval = time() - $lastactivity;
               if($interval <= 420){
                   echo "<br><small style='color: green;'><b>STATUS: Online</b></small>";
               }else if($interval <= 900){
                   echo "<br><small style='color: #ffff00;'><b>STATUS: Busy</b></small>";
               }else{
                   echo "<br><small style='color: lightcoral;'><b>STATUS: Offline</b></small>";
               }?>
           <?php endif;?>

       </h2>
           <!--Beginning of send message block-->
           <div>
               <a class="btn btn-success" href="/api/article/index.php?getuserarticles&uid=<?php echo $user[0];?>">
                   Articles By Me
               </a>

       <?php if(!isset($_SESSION["userid"])){
           $_SESSION["userid"] = NULL;
       }?>

       <?php if(($_SESSION["userid"]!= $user[0])):?>
               <button class="btn btn-success" type="button"
                       data-toggle="collapse" data-target="#chatdiv">
                   Chat
               </button>
           <?php else: ?>
               <button class="btn btn-success" type="button" data-toggle="collapse"
                   data-target="#profilepicdiv">
                   Upload/Change Profile Picture
               </button>
           <a href="/api/user/forms/resetpassword.html.php">
           <button class="btn btn-success" type="button">
               Reset Password
           </button>
           </a>
          <?php endif;?>

          <?php if($_SESSION["userid"]==NULL){
               unset($_SESSION["userid"]);
             }?>
          <?php session_write_close();?>
           </div>
           <div class="row">
               <div class="col-sm-6">
               <div class="collapse" id="chatdiv">
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
               <div class="collapse" id="profilepicdiv">
               <div class="form-group">
                   <form class="form-group" enctype="multipart/form-data"
                         action="/api/user/index.php" method="POST">
                       <div class="form-group">
                           <label for="profilepic">Upload Profile Picture</label>
                           <input class="form-control" name="profilepic" type="file"
                                  id="profilepic"/>
                           <input type="hidden" name="pty" value="profilepic"/>
                           <input type="hidden" name="value" value="profilepic"/>

                       </div>
                       <div class="form-group">
                           <button name='edituser'
                                   type="submit" class="btn-success">
                               Save
                           </button>
                       </div>
                   </form>
               </div>
            </div>
           </div>

           </div>
           <!--Beginning of send message block-->
       </div>

       <div class="row">
           <div class="col-sm-4">
               <div class="page-header">
                   About Me:
               </div>
               <div>
                   <img class="img-circle" src="<?php echo $user['profilepic'];?>" alt="picture of user"
                        style="width:100%; height:150px;"/>
               </div>
               <div>
                   <p>
                       <?php echo htmlspecialchars($user['about']);?>
                   </p>
                   <?php
                   if(isset($_SESSION["userid"])&& ($_SESSION["userid"] == $user[0])):?>
                       <div>
                           <button type="button"  data-toggle="collapse"
                                   data-target="#editformdiv1" class="btn-success">
                               Edit
                           </button>
                       </div>
                       <div class="collapse" id="editformdiv1">
                           <div class="form-group">
                               <form class="form-group"
                                     action="/api/user/index.php" method="POST">
                                   <div class="form-group">
                                       <label for="about" class="form-control">About</label>
                                       <textarea class="form-control" name="value" id="about">
      <?php echo $user["about"];?>
                                       </textarea>

                                       <input type="hidden" name="pty" value="about"/>
                                   </div>
                                   <div class="form-group">
                                       <button name='edituser' value="save"
                                               type="submit" class="btn-success">
                                           Save
                                       </button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   <?php endif; session_write_close(); ?>
               </div>
           </div>
           <div class="col-sm-8">
               <div class="panel-default">
                   <div class="page-header">
                       Personal Information
                   </div>
                   <div class="panel-body">
                   <p>
                       <b>Name:</b><?php echo $user["firstname"].' '.$user["surname"];?>
                       <?php
                       if(isset($_SESSION["userid"])&& ($_SESSION["userid"] == $user[0])):?>
                           <div>
                              <button type="button" data-target="#editformdiv2"
                                      data-toggle="collapse" class="btn-success">
                                  Edit
                              </button>
                           </div>
                           <div class="collapse" id="editformdiv2">
                               <div class="row">
                               <div class="col-sm-6">
                               <div class="form-group">
                                   <form class="form-group"
                                         action="/api/user/index.php" method="post">
                                   <div class="form-group">
                                       <label for="firstname">firstname</label>
                                       <input class="form-control" name="value" type="text"
                                              id="firstname" value="<?php echo $user['firstname'];?>"/>
                                       <input type="hidden" name="pty" value="firstname"/>
                                       </div>
                                       <div class="form-group">
                                       <button name='edituser'
                                               type="submit" class="btn-success">
                                            Save
                                       </button>
                                   </div>
                                   </form>
                               </div>
                               </div>
                           <div class="col-sm-6">
                               <div class="form-group">
                                   <form class="form-group"
                                         action="/api/user/index.php" method="post">
                                       <div class="form-group">
                                           <label for="surname">surname</label>
                                           <input class="form-control" name="value" type="text"
                                                  id="surname" value="<?php echo $user['surname'];?>"/>
                                           <input type="hidden" name="pty" value="surname"/>
                                       </div>
                                       <div class="form-group">
                                           <button name='edituser'
                                                   type="submit" class="btn-success">
                                               Save
                                           </button>
                                       </div>
                                   </form>
                               </div>

                           </div>
                           </div>
                           <!--end of row-->
                           </div>
                       <?php endif; session_write_close();?>
                       <!--end if userid== sessionid-->
                   <div>
                       <h6><b>Official: What We Know Of This Person</b></h6>

                       <ul style="list-style-type: none;">
                           <li><b>Role:</b><?php echo $user['rolename'];?></li>
                           <li><b>Role Information:</b><br/>
                               <?php echo $user['rolenote'];?></li>
                       </ul>
                   </div>
                   <p>
                       <b>Locality:</b>
                       <br/><?php echo $user["locationname"];?>
                   </p>
                   <p>
                       <b>Place Of Residence:</b>
                       <br/><?php echo $user["sublocationname"];?>
                   </p>
                   <?php
                   if(isset($_SESSION["userid"])&& ($_SESSION["userid"] == $user[0])):?>
                       <div>
                           <button type="button"  data-toggle="collapse"
                                   data-target="#editformdiv4" class="btn-success">
                               Edit
                           </button>
                       </div>
                       <div class="collapse" id="editformdiv4">
                           <div class="form-group">
                               <form class="form-group"
                                     action="/api/user/index.php" method="post">
                                   <?php
                                        $location = new location();
                                        $locations = $location->getLocations();
                                   ?>
                                   <div class="form-group">
                                       <label for="locationselectpf" class="form-control"></label>
                                       <select name='locationid' id='locationselectpf' class="form-control">
                                           <option value='0'>Select</option>
                                           <?php foreach($locations as $location):?>
                                               <option value="<?php echo $location[0];?>"><?php echo $location[1];?></option>
                                           <?php endforeach;?>
                                       </select>
                                       <label for="sublocationselectpf" class="form-control">Place</label>
                                       <select name='value' id='sublocationselectpf' class="form-control">
                                       </select>
                                       <input type="hidden" name="pty" value="sublocationid"/>
                                   </div>
                                   <div class="form-group">
                                       <button name='edituser'
                                               type="submit" class="btn-success">
                                           Save
                                       </button>
                                   </div>
                               </form>
                           </div>
                       </div>
                   <?php endif; session_write_close(); ?>

                   <p>
                       <b>Date Of Birth:</b>
                       <br/><?php echo date("Y M, d l ",strtotime($user["dateofbirth"]));?>

                       <?php
                       if(isset($_SESSION["userid"])&& ($_SESSION["userid"] == $user[0])):?>
                           <div class="btn btn-success" data-toggle="collapse" data-target="#dobdiv">
                                Edit
                           </div>
                           <div class="collapse" id="dobdiv">
                               <div class="form-group">
                                   <form action="/api/user/index.php" method="post">
                                       <div class="form-group">
                                           <label for="dayselect">Date Of Birth (Day Month Year)</label>
                                           <div class="input-group date" >
                                               <select name='day' class='form-control' id="dayselect">
                                                   <option  value='00'>Day</option>
                                                   <option  value='01'>1</option>
                                                   <option  value='02'>2</option>
                                                   <option  value='03'>3</option>
                                                   <option  value='04'>4</option>
                                                   <option  value='05'>5</option>
                                                   <option  value='06'>6</option>
                                                   <option  value='07'>7</option>
                                                   <option  value='08'>8</option>
                                                   <option  value='09'>9</option>
                                                   <option  value='10'>10</option>
                                                   <option  value='11'>11</option>
                                                   <option  value='12'>13</option>
                                                   <option  value='13'>13</option>
                                                   <option  value='14'>14</option>
                                                   <option  value='15'>15</option>
                                                   <option  value='16'>16</option>
                                                   <option  value='17'>17</option>
                                                   <option  value='18'>18</option>
                                                   <option  value='19'>19</option>
                                                   <option  value='20'>20</option>
                                                   <option  value='21'>21</option>
                                                   <option  value='22'>22</option>
                                                   <option  value='23'>23</option>
                                                   <option  value='24'>24</option>
                                                   <option  value='25'>25</option>
                                                   <option  value='26'>26</option>
                                                   <option  value='27'>27</option>
                                                   <option  value='28'>28</option>
                                                   <option  value='29'>29</option>
                                                   <option  value='30'>30</option>
                                                   <option  value='31'>31</option>

                                               </select>

                                               <select name='month' class='form-control' id="monthselect">
                                                   <option value='00'>Month</option>
                                                   <option value='01'>January</option>
                                                   <option value='02'>February</option>
                                                   <option value='03'>March</option>
                                                   <option value='04'>April</option>
                                                   <option value='05'>May</option>
                                                   <option value='06'>June</option>
                                                   <option value='07'>July</option>
                                                   <option value='08'>August</option>
                                                   <option value='09'>September</option>
                                                   <option value='10'>October</option>
                                                   <option value='11'>November</option>
                                                   <option value='12'>December</option>

                                               </select>

                                               <input class='form-control' type='year'
                                                      name='year' placeholder="YEAR (YYYY)"/>
                                       </div>
                                       </div>

                                       <div class="form-group">
                                           <input type="hidden" name="userid" value="<?php echo($user[0]);?>">
                                           <input type="hidden" name="pty" value="dateofbirth">
                                           <button type="submit" class="btn btn-success" name="edituser">
                                               update
                                           </button>
                                       </div>
                                   </form>
                               </div>
                           </div>
                        <?php endif;?>

                       <br/><b>Gender:</b>
                       <?php echo $user["gender"];?>
                   </p>

                   <p>
                       <b>Joined Since:</b>
                       <br/><?php echo date("Y M, d F",strtotime($user["dateofregistration"]));?>
                   </p>
                   <p>
                      <b> Mobile:</b><br/>
                       <?php if($user["public"]=="Y"){
                           echo $user["mobile"];
                       }else{
                           echo("<b><i>Does Not Wish To Disclose This Information</i></b>");
                       }?>
                   </p>
                   <?php
                   if(isset($_SESSION["userid"])&& ($_SESSION["userid"] == $user[0])):?>
                       <div>
                           <button type="button"  data-toggle="collapse"
                                   data-target="#editformdiv6" class="btn-success">
                               Edit
                           </button>
                       </div>
                       <div class="collapse" id="editformdiv6">
                           <div class="form-group">
                               <form class="form-group"
                                     action="/api/user/index.php" method="post">
                                   <div class="form-group">
                                       <label for="mobile" class="form-control">Mobile</label>
                                       <input class="form-control" name="value" id="mobile"
                                              value="<?php echo $user["mobile"];?>"/>

                                       <input type="hidden" name="pty" value="mobile"/>
                                   </div>
                                   <div class="form-group">
                                       <button name='edituser'
                                               type="submit" class="btn-success">
                                           Save
                                       </button>
                                   </div>
                               </form>
                           </div>
                       </div>

                   <?php endif; session_write_close(); ?>
               </div>
               </div>

           </div>
       </div>

   <?php endif?>
   <!-- end of if user-->
   </div>
   <div class="col-sm-3">
       <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar-2.html.php';?>
   </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>
<!-- script for sublocation select;-->
<script type="text/javascript">
    $("#locationselectpf").change(function(){displaysublocationspf()});
    function displaysublocationspf(){
        var sid = document.getElementById('locationselectpf')
            .options[document.getElementById('locationselectpf').selectedIndex].value;
        $.get('//<?php echo($_SERVER['HTTP_HOST']);?>/api/location/index.php?get_sublocations&locationid='+sid, function(responseText) {
            $("#sublocationselectpf").empty();
            $("#sublocationselectpf").append(responseText);
        });
    }

</script>
</body>
</html>