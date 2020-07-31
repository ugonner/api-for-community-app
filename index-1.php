

<!DOCTYPE HTML>
<html>
<head>
    <title>Kpakpando Media Group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="this is all about the kpakpando Media Group, the foremost media group promoting the light, culture and politics of the african rural communities" />
    <link href="/api/web/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom Theme files -->
    <link href='//fonts.googleapis.com/css?family=Raleway:400,600,700' rel='stylesheet' type='text/css'>
    <link href="/api/web/css/style.css" rel='stylesheet' type='text/css' />
    <script src="/api/web/js/jquery-1.11.1.min.js"></script>
    <script src="/api/web/js/bootstrap.min.js"></script>

    <style>
        #welcome-text-div{
            position: absolute;
            top: 50%;
            left: 30%;
            background: transparent;
            z-index: 10;
            text-align: center;
            font-size: 4em;

        }


        #dangling-divs-container{
            position: absolute;
            top: 0%;
            right: 0%;
            background: transparent;
            z-index: 10;
            text-align: center;
            /*animation: bouncer 5s linear infinite;*/
        }
        .dangling-divs .btn, .dangling-divs a{
            border: 1px double red;
            color: lightcyan;
            background: red;
            opacity: 0.5;
        }
        .dangling-divs .btn:hover{
            background: firebrick;
            opacity: 0.9;
        }


        #rotater-div, #rotater-div-2{
            animation: rotate 5s linear infinite;
        }

        #shaker-div{
            animation: shake 5s linear infinite;
        }

        @media screen and (max-width: 768px){

            #welcome-text-div{
                font-size: 1em;
                font-weight: bolder;
                top: 20%;
                right: 10%;
            }
        }
/*
        @keyframes bouncer{
            100%{
                opacity: 1;
                transform: translateY(40px);

            }
        }*/

        /*@keyframes rotate{
            100%{
                opacity: 1;
                transform: rotate(360deg);
            }
        }*/

        /*@keyframes shake{

            0%{
                opacity: 1;
                transform: translateX(0px);
            }
            25%{
                opacity: 1;
                transform: translateX(-40px);
            }
            50%{
                opacity: 1;
                transform: translateX(40px);
            }
            100%{
                opacity: 1;
                transform: translateX(0px);
            }
        }*/
    </style>

    <!--from dyna-->
    <!--for text up and down-->
    <style type="text/css">

        /*Example CSS for the two demo scrollers*/

        #pscroller1{
            width: 400px;
            height: 100px;
            /*border: 1px solid black;*/
            padding: 5px;
            background-color: transparent;
            color: whitesmoke;
            margin: 5px;
        }

        #pscroller2{
            width: 350px;
            height: 100px;
            border: 1px solid black;
            padding: 3px;
            background: red;
        }

        #pscroller2 a{
            text-decoration: none;
        }

        .someclass{ //class to apply to your scroller(s) if desired
        }

    </style>

    <script type="text/javascript">

        /*Example message arrays for the two demo scrollers*/

        var pausecontent=new Array()
        pausecontent[0]=
            '<div class="container-fluid">' +
                ' <div class="col-xs-3">' +
                    '<img src="/api/img/site-imgs/logo.jpg" class="img-responsive">' +
                '</div>' +
                '<div class="col-xs-9">' +
                    ' <a href="/api/index-2.php"> Coming sonn !</a><br> Kpakpando Is here to bring you up to speed with current news and updates' +
                '</div>' +
            '</div>' +
            '<br>&nbsp;'
        pausecontent[1]=
            '<div class="container-fluid">' +
                ' <div class="col-xs-3">' +
                '<img src="/api/img/site-imgs/logo.jpg" class="img-responsive">' +
                '</div>' +
                '<div class="col-xs-9">' +
                ' <a href="/api/index-2.php"> Yes, Great !</a><br> it is going to be a blast, real soon' +
                '</div>' +
                '</div>' +
                '<br>&nbsp; '
        pausecontent[2]=
            '<div class="container-fluid">' +
                ' <div class="col-xs-3">' +
                '<img src="/api/img/site-imgs/logo.jpg" class="img-responsive">' +
                '</div>' +
                '<div class="col-xs-9">' +
                ' <a href="/api/index-2.php"> Wake To This !</a><br> Expect it, the big bang from kpakpando media' +
                '</div>' +
                '</div>' +
                '<br>&nbsp; '
        pausecontent[3]=
            '<div class="container-fluid">' +
                ' <div class="col-xs-3">' +
                '<img src="/api/img/site-imgs/logo.jpg" class="img-responsive">' +
                '</div>'+
                '<div class="col-xs-9">' +
                ' <a href="/api/index-2.php"> Coming sonn !</a><br> it is gonna be a jump off' +
                '</div>' +
                '</div>' +
                '<br>&nbsp; '

        var pausecontent2=new Array()
        pausecontent2[0]='<a href="http://www.news.com/">News.com: Technology and business reports</a>'
        pausecontent2[1]='<a href="http://www.cnn.com/">CNN: Headline and breaking news 24/7</a>'
        pausecontent2[2]='<a href="http://news.bbc.co.uk/">BBC News: UK and international news</a>'

    </script>

    <script type="text/javascript">

        /***********************************************
         * Pausing up-down scroller- (c) Dynamic Drive (www.dynamicdrive.com)
         * Please keep this notice intact
         * Visit http://www.dynamicdrive.com/ for this script and 100s more.
         ***********************************************/

        function pausescroller(content, divId, divClass, delay){
            this.content=content //message array content
            this.tickerid=divId //ID of ticker div to display information
            this.delay=delay //Delay between msg change, in miliseconds.
            this.mouseoverBol=0 //Boolean to indicate whether mouse is currently over scroller (and pause it if it is)
            this.hiddendivpointer=1 //index of message array for hidden div
            document.write('<div id="'+divId+'" class="'+divClass+'" style="position: relative; overflow: hidden"><div class="innerDiv" style="position: absolute; width: 100%" id="'+divId+'1">'+content[0]+'</div><div class="innerDiv" style="position: absolute; width: 100%; visibility: hidden" id="'+divId+'2">'+content[1]+'</div></div>')
            var scrollerinstance=this
            if (window.addEventListener) //run onload in DOM2 browsers
                window.addEventListener("load", function(){scrollerinstance.initialize()}, false)
            else if (window.attachEvent) //run onload in IE5.5+
                window.attachEvent("onload", function(){scrollerinstance.initialize()})
            else if (document.getElementById) //if legacy DOM browsers, just start scroller after 0.5 sec
                setTimeout(function(){scrollerinstance.initialize()}, 500)
        }

        // -------------------------------------------------------------------
        // initialize()- Initialize scroller method.
        // -Get div objects, set initial positions, start up down animation
        // -------------------------------------------------------------------

        pausescroller.prototype.initialize=function(){
            this.tickerdiv=document.getElementById(this.tickerid)
            this.visiblediv=document.getElementById(this.tickerid+"1")
            this.hiddendiv=document.getElementById(this.tickerid+"2")
            this.visibledivtop=parseInt(pausescroller.getCSSpadding(this.tickerdiv))
//set width of inner DIVs to outer DIV's width minus padding (padding assumed to be top padding x 2)
            this.visiblediv.style.width=this.hiddendiv.style.width=this.tickerdiv.offsetWidth-(this.visibledivtop*2)+"px"
            this.getinline(this.visiblediv, this.hiddendiv)
            this.hiddendiv.style.visibility="visible"
            var scrollerinstance=this
            document.getElementById(this.tickerid).onmouseover=function(){scrollerinstance.mouseoverBol=1}
            document.getElementById(this.tickerid).onmouseout=function(){scrollerinstance.mouseoverBol=0}
            if (window.attachEvent) //Clean up loose references in IE
                window.attachEvent("onunload", function(){scrollerinstance.tickerdiv.onmouseover=scrollerinstance.tickerdiv.onmouseout=null})
            setTimeout(function(){scrollerinstance.animateup()}, this.delay)
        }


        // -------------------------------------------------------------------
        // animateup()- Move the two inner divs of the scroller up and in sync
        // -------------------------------------------------------------------

        pausescroller.prototype.animateup=function(){
            var scrollerinstance=this
            if (parseInt(this.hiddendiv.style.top)>(this.visibledivtop+5)){
                this.visiblediv.style.top=parseInt(this.visiblediv.style.top)-5+"px"
                this.hiddendiv.style.top=parseInt(this.hiddendiv.style.top)-5+"px"
                setTimeout(function(){scrollerinstance.animateup()}, 50)
            }
            else{
                this.getinline(this.hiddendiv, this.visiblediv)
                this.swapdivs()
                setTimeout(function(){scrollerinstance.setmessage()}, this.delay)
            }
        }

        // -------------------------------------------------------------------
        // swapdivs()- Swap between which is the visible and which is the hidden div
        // -------------------------------------------------------------------

        pausescroller.prototype.swapdivs=function(){
            var tempcontainer=this.visiblediv
            this.visiblediv=this.hiddendiv
            this.hiddendiv=tempcontainer
        }

        pausescroller.prototype.getinline=function(div1, div2){
            div1.style.top=this.visibledivtop+"px"
            div2.style.top=Math.max(div1.parentNode.offsetHeight, div1.offsetHeight)+"px"
        }

        // -------------------------------------------------------------------
        // setmessage()- Populate the hidden div with the next message before it's visible
        // -------------------------------------------------------------------

        pausescroller.prototype.setmessage=function(){
            var scrollerinstance=this
            if (this.mouseoverBol==1) //if mouse is currently over scoller, do nothing (pause it)
                setTimeout(function(){scrollerinstance.setmessage()}, 100)
            else{
                var i=this.hiddendivpointer
                var ceiling=this.content.length
                this.hiddendivpointer=(i+1>ceiling-1)? 0 : i+1
                this.hiddendiv.innerHTML=this.content[this.hiddendivpointer]
                this.animateup()
            }
        }

        pausescroller.getCSSpadding=function(tickerobj){ //get CSS padding value, if any
            if (tickerobj.currentStyle)
                return tickerobj.currentStyle["paddingTop"]
            else if (window.getComputedStyle) //if DOM2
                return window.getComputedStyle(tickerobj, "").getPropertyValue("padding-top")
            else
                return 0
        }

    </script>
    <!--end up-down scroll-->

</head>
<body style="background: #000000; color: #f5f5f5;">

<div class="container-fluid" style="height: 100%;">
    <nav class="nav navbar-inverse">
        <div class="navbar navbar-header">
            <div class="navbar-brand">
                <img src="/api/img/site-imgs/logo.jpg" alt="Kpakpando Media Logo" style="width: 1em; height: 1em;">
            </div>
        </div>
    </nav>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <!--<ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>-->

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <div class="item active">
                        <a href="/api/index-2.php">
                            <img src="/api/img/kpakpandomediapictures/mrs-okechukwu.jpg" alt="">
                            <div class="carousel-caption">
                                <p>We report African crafts!</p>
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a href="/api/index-2.php">
                            <img src="/api/img/kpakpandomediapictures/banner-in-studio.jpg" alt="African rural community">
                            <div class="carousel-caption">
                                <p>we bring out the light</p>
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a href="/api/index-2.php">
                            <img src="/api/img/kpakpandomediapictures/meeting-of-four.jpg" alt="">
                            <div class="carousel-caption">
                                <p>we report the politics!</p>
                            </div>
                        </a>
                    </div>

                    <div class="item">
                        <a href="/api/index-2.php">
                            <img src="/api/img/kpakpandomediapictures/banner-meeting.jpg" alt="">
                            <div class="carousel-caption">
                                <p>We report African crafts!</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-sm-5">

            <div class="row">
                <div class="col-sm-6 text-justify">
                    <h3 style="color: greenyellow; font-weight: bolder;">Kpakpando <span style="color: blueviolet">Media</span> </h3>
                    <h5>Kpakpando Media is here to promote life and light out of our rural communities</p>
                    <p>There is a story yet untold, Life and Light in the rurals remain largely under-showcased or reported
                        All the beauties, the traditions, the politics, the creativities and the people remain beneath the cameras
                        of urban media. This is what <b>KPAKPANDO MEDIA</b> stands for
                    </h5>
                    <h6 class="page-header text-right"><span class="glyphicon glyphicon-time"></span> <?php echo(date("Y M d, l h:i:s a"));?>.</h6>
                </div>
                <div class="col-sm-6 text-justify">
                    <h3 style="color: sandybrown; font-weight: bolder;">Mission Statement</h3>
                    <h5>
                        The mission of Kpakpando Media, comprising Kpakpando Community Radio and
                        Kpakpando Community Newspaper, can be summed up in a quest to pioneer a new
                        perspective in Nigerian journalism by shifting focus from the conventional
                        urban-based journalism to the rural communities.
                    </h5>
                </div>
            </div>
        </div>
    </div>
    </div>

        <!--dyna text up-dwon-->
        <script type="text/javascript">

            //new pausescroller(name_of_message_array, CSS_ID, CSS_classname, pause_in_miliseconds)

            new pausescroller(pausecontent, "pscroller1", "someclass", 3000)
            document.write("<br />")

        </script>
        <!--end up-down dyna-->

<div class="copyright">
    <div class="container text-center">
        <p>
            <b><sup>&copy;</sup>kpakpando Media</b>
        </p>
        <h6>Powered by <a href="https://smallate.com.ng">SmallateIT<sup>&trade;</sup></a> </h6>
    </div>
</div>

<div id="dangling-divs-container">
    <div class="row">
        <div class="col-xs-4 dangling-divs" id="rotater-div-2">
            <a href="/api/mission.html.php" class="btn btn-lg">
                About
            </a>
        </div>
        <div class="col-xs-4 dangling-divs" id="shaker-div">
            <a href="/api/board.html.php" class="btn btn-lg">
                Board
            </a>
        </div>
        <div class="col-xs-4 dangling-divs" id="rotater-div">
            <a href="/api/index-2.php" class="btn btn-lg">
                Home
            </a>
        </div>
    </div>
</div>

<!--
<div id="welcome-text-div">
</div>
-->
<div>
    <audio id="sound-div" src="/api/assets/village_tone.mp3" loop="loop" ></audio>
</div>
<script type="text/javascript">
    $("document").ready(function(){
        $("#sound-div").get(0).play();
    });

</script>

<!--
<script type="text/javascript">
    var text = ['K','p','a','k','p','a','n','d','o', '  M','e','d','i','a  ', 'W','e','l','c','o','m','e','s', '  Y','o','u'];
    var i = 0;
    var init_text = ' ';
    var div = document.getElementById("welcome-text-div");
    function showText(){

        if(i == text.length){
            clearInterval(showTextInt);
        }else{
            init_text += text[i];
            div.innerHTML = init_text;
            i++;
        }
    }

    var showTextInt = setInterval(showText,250);


</script>-->
</body>
