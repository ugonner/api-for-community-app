<?php include $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php'?>
 <div class="container-fluid">

 <div class="row">
  <div class='col-sm-12 text-centert'>
    <?php if(isset($qxn)){
      echo $qxn;
    }?>
  </div>
 </div>

 <div class="row">
  <div class="col-sm-12 text-right">
    <?php if(isset($rqst)){
      echo $rqst;
    }?>
  </div>
 </div>
 </div>


 <?php include $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php'?>
 </body>
 </html>