<?php

//login;
include_once $_SERVER['DOCUMENT_ROOT'].'/api/admin/admin.class.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/inc/htmls/header.html.php';

if(!$headuser->isLoggedIn()){
    $error="Please Login First With Correct Email And Password Pair";
    include_once $_SERVER['DOCUMENT_ROOT'].'/api/user/login.html.php';
    exit;
}

$uid = $_SESSION["userid"];
?>
<div class="banner-1">
    <h2 class="text-center">Upload Gallery Files</h2>
</div>
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h4 class="text-center">Upload Gallery Files</h4>
            <div>
                <form action="/api/gallery/" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="articlefile1caption">Caption For File</label>
                        <input id="articlefile1caption" type="text"  name="articlefile1caption" placeholder="File Caption" class="form-control"/>
                        <input id="articlefile1" type="file"  name="articlefile1"  onchange="displayPic(event)" class="btn btn-primary btn-lg btn-block" />
                    </div>

                    <div class="form-group">
                        <label for="articlefile2caption">Caption For File</label>
                        <input id="articlefile2caption" type="text"  name="articlefile2caption" placeholder="File Caption" class="form-control"/>
                        <input id="articlefile2" type="file"  name="articlefile2"  onchange="displayPic(event)" class="btn btn-primary btn-lg btn-block"/>
                    </div>

                    <div class="form-group">
                        <label for="articlefile3caption">Caption For File</label>
                        <input id="articlefile3caption" type="text"  name="articlefile3caption" placeholder="File Caption" class="form-control"/>
                        <input id="articlefile3" type="file"  name="articlefile3"  onchange="displayPic(event)" class="btn btn-primary btn-lg btn-block" />
                    </div>

                    <div class="form-group">
                        <label for="articlefile4caption">Caption For File</label>
                        <input id="articlefile4caption" type="text"  name="articlefile4caption" placeholder="File Caption" class="form-control"/>
                        <input id="articlefile4" type="file"  name="articlefile4" onchange="displayPic(event)" class="btn btn-primary btn-lg btn-block"/>
                    </div>

                    <div class="form-group">
                        <label for="articlefile5caption">Caption For File</label>
                        <input id="articlefile5caption" type="text"  name="articlefile5caption" placeholder="File Caption" class="form-control"/>
                        <input id="articlefile5" type="file"  name="articlefile5" onchange="displayPic(event)" class="btn btn-primary btn-lg btn-block"/>
                    </div>


                    <div class="form-group">
                        <button type="submit" name="addgalleryfiles" class="btn btn-lg btn-primary btn-block">
                            Upload Files
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-12" id="img-pack-div">

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let g_imgs = ['fileimg1','fileimg2','fileimg3','fileimg4','fileimg5'];
    let g_imgs_files = ['articlefile1','articlefile2','articlefile3','articlefile4','articlefile5'];
    let g_imgs_divs = ['fileimg1','fileimg2','fileimg3','fileimg4','fileimg5'];

    var gallery_img_display_div = document.getElementById("img-pack-div");
    function displayPic(event){

        var img_elem = event.target;
        let filereader = new FileReader();
        filereader.onload = function(){
            let result = filereader.result;
            let img = document.createElement("img");
            img.src = result;
            img.style.height = "100px";
            img.style.width = "100px";
            gallery_img_display_div.appendChild(img);
        };
        filereader.readAsDataURL(img_elem.files[0]);
    }
</script>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/api/includes/htmlpages/footer.html.php';?>