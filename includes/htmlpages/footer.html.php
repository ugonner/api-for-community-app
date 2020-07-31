<div class="footer" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="col-md-4 footer-left">
            <h4 class="secondary-color">About Us</h4>
            <p> The Joint National Association Of Persons With Disability (JONAPWD) is an umbrella body
                enveloping the various associations or clusters of persons with disability. Thus, Providing a
                common front for protection and development of the interests of all persons with disability

                JONAPWD is therefore a that one point to serve the common interests of persons with disability
                at a common ground.
            </p>
            <div class="bht1">
                <a href="/api/about.html.php">Read More</a>
            </div>
        </div>

        <div class="col-md-4 footer-middle" id="contactdiv">
            <h4 class="secondary-color">JONAPWD CLUSTERS</h4>
            <div class="mid-btm">
                <p style="background: url('/api/img/banner-1.jpg') no-repeat 100% 100%">
                    <?php foreach($head_clusters as $cluster):?>
                        <a href="/api/cluster/?getcluster&clusterid=<?php echo($cluster['id']);?>" class="btn btn-primary btn-lg btn-block">
                            <?php echo($cluster['name']);?>
                        </a>
                    <?php endforeach; ?>
                </p>
            </div>
            <p></p>
        </div>


        <div class="col-md-4 footer-right">
            <h4 class="secondary-color">Contact </h4>
            <p>
                You can contact JONAPWD via the following points
                <p>

                          <span class="giyphicon glyphicon-map-marker"></span>	Address:
                                JONAPWD Secretariat, Prof. Dora Akunyili Women Development Centre, Awka.
                <br>&nbsp;<span class="giyphicon glyphicon-phone"></span>	Phone numbers: 08060025948.
                <br>&nbsp;<span class="giyphicon glyphicon-inbox"></span>	E-mails: jonapwdanambra@gmail.com,
                                                                                     jonapwdsupport@jonapwdanambra.org.ng
                <br>&nbsp;<br>&nbsp;
                                        <span class="giyphicon glyphicon-user"></span>
                                        Contact Person: Comr.  Okeke, Ugochukwu
                <br>&nbsp;&nbsp;&nbsp;<small><span class="giyphicon glyphicon-inbox"></span></small> desimpleman4real@gmail.com
                <br>&nbsp;&nbsp;&nbsp;&nbsp;<small<sup><span class="giyphicon glyphicon-phone"></span></sup>08060025948.</small>


            </p>
            </p>

            <div class="name">
                <form action="#" method="post">
                    <input type="text" name="firstname" placeholder="Your Name" required="true">
                    <input type="text" name="email" placeholder="Your Email" required="true">
                    <input type="submit" value="Subscribed Now">
                </form>

            </div>

            <div class="clearfix"> </div>

        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="copyright">
    <div class="container text-center">
        <p>
            <b><sup>&copy;</sup>JONAPWD</b>
        </p>
        <h6>Powered by <a href="https://smallate.com.ng">SmallateIT<sup>&trade;</sup></a> </h6>
    </div>
</div>

<script type="text/javascript">
    $("document").load(
        $(".banner-fadein").slideDown(1000)
    );

    var donmodalbtn = document.getElementById("donatamodalclosebtn");
    var donmodaltoggler = document.getElementById("donationModal");
    donmodalbtn.addEventListener("click", function(){
        donmodaltoggler.css("display","none");
    });

</script>