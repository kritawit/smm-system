<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class='no-js' lang='en'>
	<!--<![endif]-->
	<head>
		<meta charset='utf-8' />
		<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
		<title>Slide</title>
		<meta content='Aaron Vanderzwan' name='author' />
		<meta name="distribution" content="global" />
		<meta name="language" content="en" />
		<meta content='width=device-width, initial-scale=1.0' name='viewport' />
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>table_slide.css"> -->
		<link rel="stylesheet" type="text/css" href="<?php echo LB?>bootstrap/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
	 <style type="text/css" media="screen">
    .slide-text{
      display: inline;
      padding-top: 15px;
      margin-right: 40px;
      font-size: 40px;
      text-align: center;
      /*color:#13B804;*/
    }
    .footer {
      position:fixed;
      left:0px;
      bottom:0px;
      padding-top: 2px;
      height:70px;
      width:100%;
      background:#999;
      color:#ffffff;
    }
    li {
      display: inline;
    }
    td{
      text-align: center;
    }
    th{
      text-align: center;
    }
    #slideshow {
      margin-left: 30px;
      margin-right: auto;
      position: relative;
/*      width: 100%;
      height: 100%;*/
      /*padding: 10px;*/
      /*box-shadow: 0 0 20px rgba(0,0,0,0.4);*/
    }

    #slideshow > div {
      position: absolute;
      top: 1px;
      /*left: 10px;*/
      /*right: 10px;*/
      bottom: 10px;
    }
    #slidemain > div{
      position: absolute;
      top: 5px;
      /*left: 10px;*/
      /*right: 10px;*/
      bottom: 10px;
    }
    #slidemain {
      margin: 0px auto;
      position: relative;
      width: 100%;
      height: 100%;
      /*padding: 10px;*/
      /*box-shadow: 0 0 20px rgba(0,0,0,0.4);*/
    }
    .loader-img
    {
      max-width: 100%;
      max-height: 100%;
      display: block;
      margin: auto auto;
      opacity: 0.4;
    }
    #slidedata
    {
      display:table-cell;
      height: 500px;
      width: 550px;
      vertical-align: middle;
    }
    .loader{
      display: none;
    }
    .loader_main{
      display: none;
    }
    .loader_footer{
      display: none;
    }
    body {
      background-image: url("../assets/images/slide/background_slide.jpg");
    }
    .img-sl{
      border:5px;
      border-style: solid;
      width: 650px;
      height: 490px;
    }
    table{
      -moz-border-radius:10px;
      -webkit-border-radius:10px;
      border-radius:10px
    }
    </style>
  </head>
	<body>
		<div class="container">
    <div class="row">
    <div>
      <div style="margin: 15px 0px 0px; display: inline-block; text-align: center; width: 400px;"><noscript><div style="display: inline-block; padding: 2px 4px; margin: 0px 0px 5px; border: 1px solid rgb(204, 204, 204); text-align: center; background-color: rgb(255, 255, 254);"><a href="http://localtimes.info/Asia/Thailand/Bangkok/" style="text-decoration: none; font-size: 13px; color: rgb(0, 0, 0);"><img src="http://localtimes.info/images/countries/th.png"="" border=0="" style="border:0;margin:0;padding:0"=""> Bangkok</a></div></noscript><script type="text/javascript" src="http://localtimes.info/clock.php?continent=Asia&country=Thailand&city=Bangkok&cp1_Hex=000000&cp2_Hex=fffffe&cp3_Hex=000000&fwdt=400&ham=1&hbg=0&hfg=0&sid=0&mon=0&wek=0&wkf=0&sep=0&widget_number=1014"></script></div>
    </div>
    <div class="col-md-7">
      <div id="slidemain">
        <div class="loader_main">
        <div id="slidedata">
          <img class="loader-img" alt="" src="<?php echo IMG; ?>loader/loading.gif" width="40" height="40" align="center" />
        </div>
        </div>
      </div>
    </div>
    <div class="col-md-5" id="datacontent">
      <div class="loader">
        <div id="slidedata">
          <img class="loader-img" alt="" src="<?php echo IMG; ?>loader/loading.gif" width="40" height="40" align="center" />
        </div>
      </div>
    </div>
  <div class="col-md-12">
    <div class="footer" id="slide_news">
       <div class="loader_footer">
        <div id="slidedata">
          <img class="loader-img" alt="" src="<?php echo IMG; ?>loader/loading.gif" width="40" height="40" align="center" />
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo JS; ?>jquery-1.11.2.min.js" ></script>
<script type="text/javascript" src="<?php echo LB?>bootstrap/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(function() {
    var interval = 1000;
    var interval_footer = 2500;
    var refresh = function() {
        $('.loader').show();
        $.ajax({
            url: "<?php echo base_url(); ?>slide/slidedata",
            type: "GET",
            cache: false,
            success: function(data) {
                $('.loader').hide();
                $("#datacontent").html(data);
                setTimeout(function() {
                    $('.loader').show();
                    refresh();
                }, interval);
            }
        });
    };
    refresh();

    var imgslide = function() {
        $('.loader_main').show();
        $.ajax({
            url: "<?php echo base_url(); ?>slide/slideimg",
            type: "GET",
            cache: false,
            success: function(data) {
                $('.loader_main').hide();
                $("#slidemain").html(data);
            }
        });
    };
    imgslide();
    var newsslide = function() {
        $('.loader_main').show();
        $.ajax({
            url: "<?php echo base_url(); ?>slide/slidenews",
            type: "GET",
            cache: false,
            success: function(data) {
                $('.loader_main').hide();
                $("#slide_news").html(data);
            }
        });
    };
    newsslide();

  });

  function slidemain(){
    $("#slidemain > div:gt(0)").hide();
    setInterval(function() {
    $('#slidemain > div:first')
        .fadeOut(1000)
        .next()
        .fadeIn(1000)
        .end()
        .appendTo('#slidemain');
    },  8000);
  }
</script>
  </body>
</html>
