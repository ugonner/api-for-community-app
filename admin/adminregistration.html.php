<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/location/location.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/api/group/group.class.php';?>

<?php
    $group = new Group();
    $grouplevel1 = $group->getGroupLevel1s();
    $grouplevel2 = $group->getGroupLevel2s();
    $grouplevel3 = $group->getGroupLevel3s();
?>

<div class="container-fluid" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<div class="container">
<div class="col-sm-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/leftbar.html.php';?>

</div>
<div class="col-sm-6">
<div class="row text-capitalize text-center">
    <h2>Welcome To JONAPWD Group! ...<small><i><b>Happy Family</b></i></small></h2>
    <h4>SIGN UP WITH US HERE</h4>
</div>

<div class="row">
<?php if(isset($_GET["output"])){
    $output = $_GET["output"];
    echo "<h4 class='text-center'>".$output."</h4>";
}
if(isset($error)){
    $output = $error;
    echo "<h4 class='text-center'>".$output."</h4>";
}?>
<form action="/api/admin/index.php" method="post">
<div class="form-group">
    <label for="email">Email</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input id="email" type="email" class="form-control" name="email" placeholder="Your Email"
               value="<?php if(isset($_POST['email'])){
                   echo $_POST['email'];
               }?>" required>
    </div>
</div>
<div class="form-group">
    <label for="password">Passeord</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password" type="password" class="form-control" name="password" placeholder="Password" require>
    </div>
</div>
<div class="form-group">
    <label for="password2">Confirm Password</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="password2" type="password" class="form-control" name="password2"
               placeholder="Re-enter Password" required>
    </div>
</div>

<div class="form-group">
    <label for="firstname">Full name</label>
    <div class="input-group">
        <span class="input-group-addon">Full Name</span>
        <input id="firstname" type="text" class="form-control"
               name="firstname" placeholder="Firstname Lastname"
               value="<?php if(isset($_POST['firstname'])){
                   echo $_POST['firstname'];
               }?>" required>
    </div>
</div>

<div class="form-group">
    <label for="professionselect">Position</label>
    <div class="input-group date" >
        <select name='roleid' class='form-control' id="professionselect">
            <option value="">Select Position</option>
            <?php foreach($headroles as $hrs):?>
                <option  value='<?php echo $hrs[0];?>'><?php echo $hrs[1];?></option>
            <?php endforeach;?>
        </select>
    </div>
</div>

<!--
<div class="form-group">
    <?php
/*    for($i=0; $i<count($head_clusters); $i++):*/?>
    <label for="cluster<?php /*echo($i);*/?>"><?php /*echo($head_clusters[$i]['name']);*/?></label>
    <input type="checkbox" id="cluster<?php /*echo($i);*/?>" name="cluster<?php /*echo($i);*/?>"
           value="<?php /*echo($head_clusters[$i]['id']);*/?>">
    <?php /*endfor; */?>
</div>
-->
<!--
<div class="form-group">
    <input type="hidden" name="cluster-count" value="<?php /*echo(count($head_clusters)); */?>">
</div>
-->

<div class="form-group">
    <label for="rolenote">A Brief Official Information On User <i>(Important)</i>:</label>
    <textarea class="form-control" rows="5" id="rolenote" required="required"
              placeholder="A Brief Official Information On User" name="rolenote">
        <?php if(isset($_POST['rolenote'])){
            echo $_POST['rolenote'];
        }?>
    </textarea>
</div>

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
    <?php
    $location = new location();
    $locations = $location->getLocations();
    ?>
    <label for="locationselectpf">Locality</label>
    <select name='locationid' id='locationselectpf' class="form-control">
        <option value=''>Select</option>
        <?php foreach($locations as $location):?>
            <option value="<?php echo $location[0];?>"><?php echo $location[1];?></option>
        <?php endforeach;?>
    </select>
    <label for="sublocationselectpf">Place</label>
    <select name='sublocationid' id='sublocationselectpf' class="form-control">
    </select>
</div>

<div class="form-group">
    <label for="grouplevel1selectpf">Ward</label>
    <select name='grouplevel1id' id='grouplevel1selectpf' class="form-control">
        <option value=''>Select</option>
        <?php foreach($grouplevel1 as $grp1):?>
            <option value="<?php echo $grp1[0];?>"><?php echo $grp1[1];?></option>
        <?php endforeach;?>
    </select>
    <label for="grouplevel2selectpf">Village</label>
    <select name='grouplevel2id' id='grouplevel2selectpf' class="form-control">
        <?php foreach($grouplevel2 as $grp2):?>
            <option value="<?php echo $grp2[0];?>"><?php echo $grp2[1];?></option>
        <?php endforeach;?>
    </select>

    <label for="grouplevel3selectpf">Kindred</label>
    <select name='grouplevel3id' id='grouplevel3selectpf' class="form-control">
        <?php foreach($grouplevel3 as $grp3):?>
            <option value="<?php echo $grp3[0];?>"><?php echo $grp3[1];?></option>
        <?php endforeach;?>
    </select>
</div>

<div class="form-group">
    <label for="mobile">Mobile</label>
    <div class="input-group">
        <span class="input-group-addon">Your Mobile Number</span>
        <input id="mobile" type="tel" class="form-control"
               name="mobile" placeholder="0800123456"
               value="<?php if(isset($_POST['mobile'])){
                   echo $_POST['mobile'];
               }?>" required>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="public">Do You Allow Your Mobile Visible To Others?</label>
            <div class="input-group">
                        <span>Na! I Don't Want People To View My Mobile In This Site.
                        <input id="public" type="checkbox" class="form-control"
                               name="public" value="N"></span>
            </div>
        </div>
    </div>


    <div class="col-sm-6">
        <div class="dropdown-toggle" data-toggle="collapse" data-target="#zipdiv">
            <div class="form-group">
                <label for="foreigner">Do You Reside Outside Nigeria?</label>
                <div class="input-group">
                        <span>Ya! I live Outside Nigeria
                        <input id="foreigner" type="checkbox" class="form-control"
                               name="foreigner" value="Y"></span>
                </div>
            </div>
        </div>
        <div class="collapse" id="zipdiv">
            <div class="form-group">
                <label for="zip">Zipcode</label>
                <div class="input-group">
                    <span class="input-group-addon">Your Zip Number</span>
                    <input id="zip" type="number" class="form-control"
                           name="zip" placeholder="+001"
                           value="<?php if(isset($_POST['zip'])){
                               echo $_POST['zip'];
                           }?>">
                </div>
            </div>

        </div>
    </div>
</div>

<div class="form-group">
    <div class="input-group">
        <label for="gender">Gender:</label>
        <select class="form-control" id="gender" name="gender">
            <option value="F">Female</option>
            <option value="M">Male</option>
        </select>
    </div>
</div>


    <div class="form-group">
            <label for="about">Brief Info:</label>
            <textarea class="form-control" rows="5" id="about"
                      placeholder="Brief About Yourself" name="about">
                <?php if(isset($_POST['about'])){
                    echo $_POST['about'];
                }?>
            </textarea>
        </div>
        <div class="form-group">
            <label for="firstname">By signing up I agree with the
                THE TERMS AND CONDITIONS of this organisation</label>
            <input class="form-control" type="submit" name="register"
                   value="SIGN ME UP"/>
        </div>

</form>
</div>
</div>

<div class="col-sm-3">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/rightbar.html.php';?>
</div>
</div>
</div>
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

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/footer2.html.php';?>
