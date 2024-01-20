
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" >
    <meta name="description" content="If you are looking to buy Authentic, Powerful Instagram followers, likes and views there is no better place than instaHotStar.com. We offer exclusive Instagram Power likes, followers, views for a price as low as $0.09                                                                ">
    <meta name="keywords" content="instaHotStar, buy instagram followers, instagram followers, instagram likes, buy instagram likes, buy followers, buying instagram followers, instagram followers buy, likes on instagram, buy real instagram followers, buy real instagram likes, buy instagram power likes, buy ig followers, buy likes instagram, buy likes on instagram, cheap instagram followers, buy followers on instagram,  get instagram likes, buy instagram followers cheap, real instagram followers, buy ig views, buying instagram video views                                                                                                                         ">
    <title>Buy Instagram Followers and Likes starting at $0.50 - instaHotStar.com</title>

    <link rel="shortcut icon" type="image/x-icon" href="http://instahotstar.com/assets/uploads/usereb4ac3033e8ab3591e0fcefa8c26ce3fd36d5a0f/4aa6ba769d9478fcf298214de5d45b6e.png">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    
    <!--bootstrap v4.0.0-->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/new/css/bootstrap.min.css">
    <!--animate-->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/new/css/aos.css">
    <!--reset css-->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/new/css/normalize.css">
    <!--main style-->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/new/css/style.css?v=1">
    <!--owl-carousel-->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/new/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/new/css/owl.theme.default.min.css">
    <!--sweet alert cdn-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--fontawesome cdn-->
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
    
    <script>
        window.Laravel = {"csrfToken":"FGY5jULtxQOHRiripB79D8gwrKc2TG50WXZfbEED"};
        window.baseUrl = "https://www.instahotstar.com";
        var spinner = "<span class='loader'></span>";
    </script>
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="https://code.iconify.design/1/1.0.0-rc7/iconify.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="<?php echo BASE; ?>assets/new/js/jquery.form-validator.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.validate({
                modules: 'date',
                validateOnBlur: false,
                lang: 'en'
            });

            $(document).on('click','.dropdown-lang a',function (e) {
                e.preventDefault();
                var locale = $(this).data('locale');
                $('#locale').val(locale);
                document.getElementById('lang-form').submit();
            });
        });
    </script>
    <!--modernizr-->
    <script src="assets/js/modernizr.js"></script>
    
    
    
    <!--Adding SnowFlake Effect-->
    
    <style>
  #snowflakeContainer {
    position: absolute;
    left: 0px;
    top: 0px;
    display: none;
  }

  .snowflake {
    position: fixed;
    background-color: #CCC;
    user-select: none;
    z-index: 1000;
    pointer-events: none;
    border-radius: 50%;
    width: 10px;
    height: 10px;
  }
</style>

<script>
  // Array to store our Snowflake objects
  var snowflakes = [];

  // Global variables to store our browser's window size
  var browserWidth;
  var browserHeight;

  // Specify the number of snowflakes you want visible
  var numberOfSnowflakes = 50;

  // Flag to reset the position of the snowflakes
  var resetPosition = false;

  // Handle accessibility
  var enableAnimations = false;
  var reduceMotionQuery = matchMedia("(prefers-reduced-motion)");

  // Handle animation accessibility preferences 
  function setAccessibilityState() {
    if (reduceMotionQuery.matches) {
      enableAnimations = false;
    } else { 
      enableAnimations = true;
    }
  }
  setAccessibilityState();

  reduceMotionQuery.addListener(setAccessibilityState);

  //
  // It all starts here...
  //
  function setup() {
    if (enableAnimations) {
      window.addEventListener("DOMContentLoaded", generateSnowflakes, false);
      window.addEventListener("resize", setResetFlag, false);
    }
  }
  setup();

  //
  // Constructor for our Snowflake object
  //
  function Snowflake(element, speed, xPos, yPos) {
    // set initial snowflake properties
    this.element = element;
    this.speed = speed;
    this.xPos = xPos;
    this.yPos = yPos;
    this.scale = 1;

    // declare variables used for snowflake's motion
    this.counter = 0;
    this.sign = Math.random() < 0.5 ? 1 : -1;

    // setting an initial opacity and size for our snowflake
    this.element.style.opacity = (.1 + Math.random()) / 3;
  }

  //
  // The function responsible for actually moving our snowflake
  //
  Snowflake.prototype.update = function () {
    // using some trigonometry to determine our x and y position
    this.counter += this.speed / 5000;
    this.xPos += this.sign * this.speed * Math.cos(this.counter) / 40;
    this.yPos += Math.sin(this.counter) / 40 + this.speed / 30;
    this.scale = .5 + Math.abs(10 * Math.cos(this.counter) / 20);

    // setting our snowflake's position
    setTransform(Math.round(this.xPos), Math.round(this.yPos), this.scale, this.element);

    // if snowflake goes below the browser window, move it back to the top
    if (this.yPos > browserHeight) {
      this.yPos = -50;
    }
  }

  //
  // A performant way to set your snowflake's position and size
  //
  function setTransform(xPos, yPos, scale, el) {
    el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0) scale(${scale}, ${scale})`;
  }

  //
  // The function responsible for creating the snowflake
  //
  function generateSnowflakes() {

    // get our snowflake element from the DOM and store it
    var originalSnowflake = document.querySelector(".snowflake");

    // access our snowflake element's parent container
    var snowflakeContainer = originalSnowflake.parentNode;
    snowflakeContainer.style.display = "block";

    // get our browser's size
    browserWidth = document.documentElement.clientWidth;
    browserHeight = document.documentElement.clientHeight;

    // create each individual snowflake
    for (var i = 0; i < numberOfSnowflakes; i++) {

      // clone our original snowflake and add it to snowflakeContainer
      var snowflakeClone = originalSnowflake.cloneNode(true);
      snowflakeContainer.appendChild(snowflakeClone);

      // set our snowflake's initial position and related properties
      var initialXPos = getPosition(50, browserWidth);
      var initialYPos = getPosition(50, browserHeight);
      var speed = 5 + Math.random() * 40;

      // create our Snowflake object
      var snowflakeObject = new Snowflake(snowflakeClone,
        speed,
        initialXPos,
        initialYPos);
      snowflakes.push(snowflakeObject);
    }

    // remove the original snowflake because we no longer need it visible
    snowflakeContainer.removeChild(originalSnowflake);

    moveSnowflakes();
  }

  //
  // Responsible for moving each snowflake by calling its update function
  //
  function moveSnowflakes() {

    if (enableAnimations) {
      for (var i = 0; i < snowflakes.length; i++) {
        var snowflake = snowflakes[i];
        snowflake.update();
      }      
    }

    // Reset the position of all the snowflakes to a new value
    if (resetPosition) {
      browserWidth = document.documentElement.clientWidth;
      browserHeight = document.documentElement.clientHeight;

      for (var i = 0; i < snowflakes.length; i++) {
        var snowflake = snowflakes[i];

        snowflake.xPos = getPosition(50, browserWidth);
        snowflake.yPos = getPosition(50, browserHeight);
      }

      resetPosition = false;
    }

    requestAnimationFrame(moveSnowflakes);
  }

  //
  // This function returns a number between (maximum - offset) and (maximum + offset)
  //
  function getPosition(offset, size) {
    return Math.round(-1 * offset + Math.random() * (size + 2 * offset));
  }

  //
  // Trigger a reset of all the snowflakes' positions
  //
  function setResetFlag(e) {
    resetPosition = true;
  }
</script>

<!--Adding SnowFlake Effect-->


<script charset="UTF-8" src="//web.webpushs.com/js/push/2da612b00ab67774c3be4ffa8235e7c1_1.js" async></script>

</head>
<body data-spy="scroll" data-target=".navbar" data-offset="60" onload="getBCs()">
    
    <!--Adding SnowFlake Effect-->
    <div id="snowflakeContainer">
  <span class="snowflake"></span>
</div>
<!--Adding SnowFlake Effect-->


  <form id="logout-form" action="#" method="POST" style="display: none;">
     <input type="hidden" name="_token" value="FGY5jULtxQOHRiripB79D8gwrKc2TG50WXZfbEED">  </form>
    <div class="se-pre-con"></div>
    <!-- main nav start -->
    <nav class="navbar navbar-expand-lg fixed-top center-brand static-nav">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="http://instahotstar.com/assets/uploads/usereb4ac3033e8ab3591e0fcefa8c26ce3fd36d5a0f/50e796f82f481552d1ecdeda1ec99892.png" alt="logo" class="logo-default" style="max-width: 200px;max-height: 100px">
            </a>
            <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#xenav">
                <i class="fas fa-bars fa-2x"></i>
            </button>
            <div class="collapse navbar-collapse" id="xenav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feature">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#depoimentos">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact Us</a>
                    </li>
                </ul>

            </div>
        </div>
        <!--/.CONTAINER-->
    </nav>
    <!-- /.navbar -->
       <div class="container">
                   
        
    
        
    
    
    
    <style>
    .login-form {
        padding: 20px;
    }

    /* already defined in bootstrap4 */
    .text-xs-center {
        text-align: center;
    }

    .g-recaptcha {
        display: inline-block;
    }
</style>
  <!--hero section-->

    <header class="hero-section" id="home">
        <!--line shape background animation-->
        <div class="container-line">
            <div class="container-line-center">
               <div class="line-item one"></div>
               <div class="line-item two"></div>
               <div class="line-item three"></div>
               <div class="line-item four"></div>
            </div>
         </div>
         <!--line shape background animation-->

            <div class="row">
                <div class="col-md-12">
                    <div class="row h-100">
                        <div class="col-md-12 align-self-center">
                            <div class="hero-content">
                                <h1><b>Get Real Instagram followers, likes, likes, views and comments in Minutes.</b> </h1>
                                <p> Instagram is one of the best social media platforms to reach millions of followers. Buying active and real Instagram followers will allow you to increase your network of followers naturally. Not only this but you will also save your precious time and get the job done in an effortless manner.</p>
                                <div class="btn-group">
                                    <a href="#" class="btn">Compare</a>
                                </div>
                            </div><!--/.hero-content-->
                        </div>
                    </div>
                </div>

            </div>

    </header>
    <!--/.hero section-->

    <!--app feature-->
    <section class="app-feature-sec" id="feature">
        <!--line shape background animation-->
        <div class="container-line">
            <div class="container-line-center">
               <div class="line-item one"></div>
               <div class="line-item two"></div>
               <div class="line-item three"></div>
               <div class="line-item four"></div>
            </div>
         </div>
         <!--line shape background animation-->
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="title">
                        <h3>Our Services</h3>
                        <p>We offer a huge range of services and features and you just have to pay very little payment!</p>
                    </div><!--/.title-->
                </div>
                <div class="w-100"></div>
                <div  class="col-md-6">
                    <div class="app-mock-up-img">
                        <div class="row justify-content-md-center justify-content-sm-center">
                            <div class="col-md-auto col-sm-auto">
                                <div class="banner-app-mock">
                                    <!--mobile inside image-->
                                    <img src="<?php echo BASE; ?>assets/new/img/smm1.png" class="main-img" alt=""/>
                                    <!--mobile mockup-->
                                    <img src="<?php echo BASE; ?>assets/new/img/mobile-mock.png" class="mockup" alt=""/>

                                </div><!--/.banner-app-mock-->
                            </div>
                        </div>
                        <div class="mobile-graphic">
                            <!--mobile graphic-->

                        </div>
                    </div>
                </div>
                <div  class="col-md-5 offset-md-1">
                    <div class="feature-inside">
                        <ul>
                            <li>
                                <img src="<?php echo BASE; ?>assets/new/img/feature2.png" alt=""/>
                                <h4>Fast Delivery</h4>
                                <p>We’re lightning fast! As soon as your sign up and make your first payment, we begin boosting your Instagram account and finding new followers, likes, views for your account in a matter of minutes. New followers come in at a fast pace as we continue boosting your posts until your purchased amount is reached.</p>
                            </li>
                            <li>
                                <img src="<?php echo BASE; ?>assets/new/img/feature2.png" alt=""/>
                                <h4>24/7 Support</h4>
                                <p>Technical support for all our services 24/7 to help you. If you have some query, drop an email to our support team. We are delighted to assist you</p>
                            </li>
                            <li>
                                <img src="<?php echo BASE; ?>assets/new/img/feature3.png" alt=""/>
                                <h4>High Quality Services</h4>
                                <p>We only give you the highest quality Instagram followers, likes, views. Quality is one of our most important goals at instaHotStar.com. We always make sure that your Instagram followers are long-lasting, reliable, and that the packages are affordable.</p>
                            </li>
                            <li>
                                <img src="<?php echo BASE; ?>assets/new/img/feature3.png" alt=""/>
                                <h4>Privacy & Safety</h4>
                                <p>We don’t require your password. When people follow an account on Instagram, they don’t ask your account’s password. So, naturally, we don’t need yours either.</p>
                            </li>
                        </ul>
                        <div class="btn-group">
                            <a href="#" class="btn">Get Started</a>
                        </div>
                    </div><!--/.feature-inside-->
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--/.app feature-->
<!--fun fact-->
    <br><br><section class="fun-fact">
        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="single-fact">
                        <h2><span class="counter">12757</span></h2>
                        <h5>Tickets Solved</h5>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="single-fact">
                        <h2><span class="counter">455</span></h2>
                        <h5>Services</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="single-fact">
                        <h2><span class="counter">13579</span></h2>
                        <h5>Clients</h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="single-fact">
                        <h2><span class="counter">1221328</span></h2>
                        <h5>Orders</h5>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--/.fun fact-->
    <!--about app-->
    <section class="about-app-sec" id="services">
        <!--line shape background animation-->
        <div class="container-line">
            <div class="container-line-center">
               <div class="line-item one"></div>
               <div class="line-item two"></div>
               <div class="line-item three"></div>
               <div class="line-item four"></div>
            </div>
         </div>
         <!--line shape background animation-->
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="title">
                        <h3>What make us best?</h3>
                        <p>We provide 24/7 ticket support and are online every day at WhatsApp. We also have dedicated support team, that can answer all your questions about the platform quickly with an incredibly humming experience.</p>
                        <p>We accept most payments known in the market. PayTM, PayPal, Bank Transfer.When you buy Instagram followers, buy Instagram views Or , buy Instagram likes you can make a significant amount of money off the Instagram account – especially from ads. Digital marketers always look for new ways to reach their target audience. When you have – let’s say a million followers – advertisers will reach out to you and ask you to promote their products and services. There are many Instagrammers who have bought millions of authentic followers from instaHotStar.com. You will be surprised to know that these Instagrammers are now earning in 5 figures simply by promoting third-party products. Having a large number of followers means you are powerful enough to bring about change. Today, hashtags started by politicians, sportspersons, and celebrities who have a method of going viral on this social media platform to reach a much wider audience.</p>
                        <a href="#" class="btn">Be part of it!</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="special-graphic">
                        <img src="<?php echo BASE; ?>assets/new/img/img-3.png" data-aos="fade-up" alt=""/>
                        <!--overlay image-->
                        <img src="<?php echo BASE; ?>assets/new/img/svg-mock.png" alt="" class="mock">
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--/.about app-->
    <!--testimonials-->
    <section class="testimonials-sec" id="depoimentos">
        <!--line shape background animation-->
        <div class="container-line">
            <div class="container-line-center">
               <div class="line-item one"></div>
               <div class="line-item two"></div>
               <div class="line-item three"></div>
               <div class="line-item four"></div>
            </div>
         </div>
         <!--line shape background animation-->
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="title">
                        <h3>Reviews</h3>
                        <p>What customers from across the world have to say about our best interaction website</p>
                    </div><!--title-->
                </div>

                <div class="col-md-8">
                    <div class="owl-carousel" id="testimonial-owl">
                        <div>
                            <div class="single-testi">
                                <p>I am owner and marketer of my company. With The SMM Store I was able to increase my level in Social Networks!</p>
                                <div class="media">
                                    <img src="<?php echo BASE; ?>assets/new/img/dep_emp.png" alt=""/>
                                    <div class="media-body">
                                        <h4>Lucio Martins</h4>
                                        <h5>CEO eMarketeiro</h5>
                                    </div>
                                </div>
                            </div><!--/.single-testi-->
                        </div>
                        <div>
                            <div class="single-testi">
                                <p>I'm a TV presenter and I use the platform to bomb my publications and influence people!</p>
                                <div class="media">
                                    <img src="<?php echo BASE; ?>assets/new/img/dep_ap.png" alt=""/>
                                    <div class="media-body">
                                        <h4>Pamela Larroque</h4>
                                        <h5>TV Presenter</h5>
                                    </div>
                                </div>
                            </div><!--/.single-testi-->
                        </div>
                        <div>
                            <div class="single-testi">
                                <p>We have been using The SMM Store since 2017. They are always online and doing their best to improve services.</p>
                                <div class="media">
                                    <img src="<?php echo BASE; ?>assets/new/img/dep_agen.png" alt=""/>
                                    <div class="media-body">
                                        <h4>Pablo Soares</h4>
                                        <h5>Marketing Executive</h5>
                                    </div>
                                </div>
                            </div><!--/.single-testi-->
                        </div>

                        <div>
                            <div class="single-testi">
                                <p>I have used several services on other sites and you are simply the best. Thank you!</p>
                                <div class="media">
                                    <img src="<?php echo BASE; ?>assets/new/img/dep_ytb.png" alt=""/>
                                    <div class="media-body">
                                        <h4>Vanessa Silva</h4>
                                        <h5>Youtuber</h5>
                                    </div>
                                </div>
                            </div><!--/.single-testi-->
                        </div>
                    </div>
                </div>

            </div>
        </div><!--/.container-->
    </section>
    <!--/.testimonials-->

    <!--faq ask-->
    <section class="faq-sec" id="faq">
        <!--line shape background animation-->
        <div class="container-line">
            <div class="container-line-center">
               <div class="line-item one"></div>
               <div class="line-item two"></div>
               <div class="line-item three"></div>
               <div class="line-item four"></div>
            </div>
         </div>
         <!--line shape background animation-->
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="title text-center">
                        <h3>Common questions</h3>
                        <p>Questions that new customers make most </p>
                    </div><!--/.title-->
                </div>
                <div class="w-100"></div>
                <div class="col-md-6">
                    <div class="app-mock-up-img">
                        <div class="row justify-content-md-center justify-content-sm-center">
                            <div class="col-md-auto col-sm-auto">
                                <div class="banner-app-mock">
                                    <!--mobile inside image-->
                                    <img src="<?php echo BASE; ?>assets/new/img/dashboard2.jpeg" class="main-img" alt=""/>
                                    <!--mobile mockup-->
                                    <img src="<?php echo BASE; ?>assets/new/img/mobile-mock.png" class="mockup" alt=""/>

                                </div><!--/.banner-app-mock-->
                            </div>
                        </div>
                        <div class="mobile-graphic">
                            <!--mobile graphic-->

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="accordion">

                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                  <button class="btnc" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> 1.How do I buy it? <i class="fa" aria-hidden="true"></i>
                                  </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                  Our platform works prepaid, the customer must add balance and every order that is made is automatically charged to your account.
                                </div>
                            </div>
                        </div><!--/.card-->

                        <div class="card">
                            <div class="card-header" id="headingtwo">
                                <h5 class="mb-0">
                                  <button class="btnc collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">2.How do I add balance?<i class="fa" aria-hidden="true"></i>
                                  </button>
                                </h5>
                            </div>

                            <div id="collapseTwo" class="collapse" aria-labelledby="headingtwo" data-parent="#accordion">
                                <div class="card-body">
                                  To add balance just go to the "Add Funds" page, select the best option for you and make the payment.
                                </div>
                            </div>
                        </div><!--/.card-->

                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                  <button class="btnc collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">3.The services are real? <i class="fa" aria-hidden="true"></i>
                                  </button>
                                </h5>
                            </div>

                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                <div class="card-body">All our services are real and count in fact for the statistics of your posts and your profile.
                                </div>
                            </div>
                        </div><!--/.card-->

                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h5 class="mb-0">
                                  <button class="btnc collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">4.The services are guaranteed? <i class="fa" aria-hidden="true"></i>
                                  </button>
                                </h5>
                            </div>

                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                <div class="card-body">
                                  We work with services with warranty and without guarantee, the user chooses by which to choose. Either way, guaranteed services have full support throughout your time.
                                </div>
                            </div>
                        </div><!--/.card-->

                    </div><!--/#accordion-->
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <!--/.faq ask-->

    <!--contact us-->
    <section class="contactus-sec" id="contact">
        <!--line shape background animation-->
        <div class="container-line">
            <div class="container-line-center">
               <div class="line-item one"></div>
               <div class="line-item two"></div>
               <div class="line-item three"></div>
               <div class="line-item four"></div>
            </div>
         </div>
         <!--line shape background animation-->
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="title text-center">
                        <h3>Contact</h3>
                        <p>Doubts? please contact directly with someone on our team</p>
                    </div><!--/.title-->
                </div>
                <div id="map"></div>
                <div class="w-100"></div>
                <div class="col-md-8 offset-md-2">
                    <div class="inside-contact">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="contact-form">
                                    <form id="contact-form" method="post" action="" role="form">
                                    <input type="hidden" name="_token" value="FGY5jULtxQOHRiripB79D8gwrKc2TG50WXZfbEED">
                                                                        <div class="form-group">
                                        <input id="form_name" type="text" name="name" placeholder="Full Name" required="required" data-error="Your name is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <input id="form_email" type="email" name="email"  placeholder="Email" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="form_message" name="message" placeholder="Write your message" rows="4" cols="10" required="required" data-error="Please, leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                <div class="form-group">
                                                                
                                
                            </div>

                                    <button type="submit" class="btn" >Send Message</button>
                                </form>
                                </div>
                            </div>
                                                        <div class="col-md-4">
                                <div class="contact-details">
                                    <div class="single-details">
                                        <i class="fab fa-skype fa-3x" style="color: white"></i>
                                        <p>officialsameel</p>
                                    </div><!--/.single-details-->
                                    <div class="single-details">
                                        <img src="<?php echo BASE; ?>assets/new/img/contact3.png" alt=""/>
                                        <p>officialsameel@gmail.com</p>
                                    </div><!--/.single-details-->
                                </div><!--/.contact-details-->
                            </div>
                        </div>
                    </div><!--/.inside-contact-->
                </div>
                <div class="w-100"></div>
            </div>
        </div><!--/.container-->
    </section>
    <!--/.contact us-->
        </div>

   <footer class="copyright-text">
       <p>instaHotStar.com - Cheapest Instagram Store with Best Services in 2020 2020. All rights reserved</p>
   </footer>
   <!--jquery-->
   <script src="<?php echo BASE; ?>assets/new/js/jquery-1.12.4.min.js"></script>
   <!--bootstrap v4 js-->
   <script src="<?php echo BASE; ?>assets/new/js/bootstrap.min.js"></script>
   <!--popper js-->
   <script src="<?php echo BASE; ?>assets/new/js/popper.min.js"></script>
   <!--aos js-->
   <script src="<?php echo BASE; ?>assets/new/js/aos.js"></script>
   <!--owl carousel -->
   <script src="<?php echo BASE; ?>assets/new/js/owl-carousel.js"></script>
   <!--counter js-->
   <script src="<?php echo BASE; ?>assets/new/js/counter.js"></script>
   <!--easing js-->
   <script src="<?php echo BASE; ?>assets/new/js/easing.js"></script>
   <!--ajax contact-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8=" crossorigin="anonymous"></script>
   <!--main script-->
   <script src="<?php echo BASE; ?>assets/new/js/main.js"></script>
   <script src="<?php echo BASE; ?>assets/new/js/datatables.min.js"></script>
   <script src="<?php echo BASE; ?>assets/new/js/flat-ui.min.js"></script>
   <script src="<?php echo BASE; ?>assets/new/js/application.js"></script>
   <script>
       $(function () {

           if (!$(".alert").hasClass('no-auto-close')) {
               $(".alert").delay(3000).slideUp(300);
           }

       });
   </script>
   
   


<script src="//fbstore.sendpulse.com/loader.js" data-sp-widget-id="51a1d4fc-1ac7-4e4a-8389-49c80bb1fb48" async></script>
 </body>
        <script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>
     </html>
