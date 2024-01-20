<!doctype html>
<html lang="en" dir="ltr" id="instahotstar-entire-page">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" >
    <meta name="offset-time" content="">
    <meta name="description" content="<?php echo strip_tags(get_option('website_desc', "SmartStore is the best option to get all social media services in website. Easy build Social Media Marketing Store with a unique design and business process automation")); ?>">
    <meta name="keywords" content="<?php echo strip_tags(get_option('website_keywords', "SmartStore, smm reseller panel, smmpanel, panelsmm, create smm store, business smm, socialmedia, instagram reseller panel, create smm store, resell smm services, smm store, start smm business, cheap smm business, buy instagram followers, instagram likes, facebook followers, facebook likes, twitter likes, youtube views, soundclound")); ?>">
    <title><?php echo strip_tags(get_option('website_title', "SmartStore - Social Media Marketing Store Script")); ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_option('website_favicon', BASE."assets/images/favicon.png"); ?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
    
    <script src="<?php echo BASE; ?>assets/plugins/vendors/jquery-3.2.1.min.js"></script>

    <!-- Core -->
    <link href="<?php echo BASE; ?>assets/css/core.min.css" rel="stylesheet">

    <!-- AOS -->
    <link rel="stylesheet" href="<?php echo BASE; ?>themes/pergo/assets/plugins/aos/dist/aos.css" />
      
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>assets/plugins/jquery-toast/css/jquery.toast.css">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/plugins/boostrap/colors.css" id="theme-stylesheet">

    <link href="<?php echo BASE; ?>assets/css/util.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/keyframes.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>themes/pergo/assets/css/theme_style.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>themes/pergo/assets/css/theme_footer.css" rel="stylesheet">
    <link href="<?php echo BASE; ?>assets/css/woo-notification.min.css" rel="stylesheet">
    <style type="text/css">
      html{
        /*visibility: hidden;*/
      }
    </style>
    <script type="text/javascript">
      $(document).ready(function(){
var timezone_offset_minutes = new Date().getTimezoneOffset();
timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
var domain = window.location.hostname;
  $.ajax({
                   type: 'get',
                   url: '<?php echo cn('custom_page/check_access'); ?>?offset='+timezone_offset_minutes,
                   success: function( resp ){
                       var json = JSON.parse(resp);
                       if(json.status == 1){
                        $("html").css("visibility","visible");
                       }else{
                        //document.body.innerHTML = '';
                        //$(document).write(json.view);
                       }
                   }
              });
});
    </script>
    <script type="text/javascript">
      var token = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>',
          PATH  = '<?php echo PATH; ?>',
          BASE  = '<?php echo BASE; ?>';
      var    deleteItem = '<?php echo lang("Are_you_sure_you_want_to_delete_this_item"); ?>';
      var    deleteItems = '<?php echo lang("Are_you_sure_you_want_to_delete_all_items"); ?>';
    </script>
    <?=htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES)?>
    <style id='woo-notification-inline-css' type='text/css'>
#message-purchased #notify-close:before{color:#000000;}#message-purchased .message-purchase-main{overflow:hidden}#message-purchased .wn-notification-image-wrapper{padding:0;}#message-purchased .wn-notification-message-container{padding-left:20px;}
                #message-purchased .message-purchase-main{
                        background-color: #ffffff;                       
                        color:#454949 !important;
                        border-radius:5px ;
                }
                 #message-purchased a, #message-purchased p span{
                        color:#f3632e !important;
                }
</style>

  </head>
  <?php //exit; ?>
  <body class="">
    
    <div id="page-overlay" class="visible incoming">
      <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
          <div class="lds-double-ring">
            <div></div>
            <div></div>
            <div>
              <div></div>
            </div>
            <div>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if($display_html){?>
    <header class="header fixed-top" id="headerNav">
      <div class="container">
        <nav class="navbar navbar-expand-lg ">
          <a class="navbar-brand" href="<?php echo cn(); ?>">
            <img class="site-logo-white" src="<?php echo get_option('website_logo_white', BASE."assets/images/logo-white.png"); ?>" alt="Webstie logo">
            <img class="site-logo d-none" src="<?php echo get_option('website_logo', BASE."assets/images/logo.png"); ?>" alt="Webstie logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fe fe-menu"></i></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link js-scroll-trigger" href="<?php echo cn(); ?>"><?php echo lang("Home"); ?></a>
              </li>

              <?php 
                        foreach ($firstThreeItems as $key => $category) {
                      ?>
                      <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?php echo cn($category->url_slug); ?>"><?php echo strip_tags($category->name); ?></a>
                        </li>
                      <?php } ?>

               <?php if(!empty($rest_items)): ?>   
               <li class="nav-item dropdown <?php echo (strpos(segment(1), 'buy') !== false ) ? "active" : ""?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Other Services
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <?php 
                        foreach ($rest_items as $key => $category) {
                      ?>
                      <li class="dropdown-submenu"><a class="dropdown-item" href="<?php echo cn($category->url_slug); ?>"><?php echo lang('Buy'); ?> <?php echo strip_tags($category->name); ?></a>

                      <?php } ?>
                </ul>
              </li>
            <?php endif; ?>

              <li class="nav-item <?php echo (segment(1) == 'blog') ? "active" : ""?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo cn('blog'); ?>"><?php echo lang('Blog'); ?></a>
              </li>              

              <li class="nav-item <?php echo (segment(1) == 'faq') ? "active": ""?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo cn('faq'); ?>"><?php echo lang('FAQ'); ?></a>
              </li>

              <li class="nav-item <?php echo (segment(1) == 'contact') ? "active" : ""?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo cn('contact'); ?>"><?php echo lang('Contact'); ?></a>
              </li>

            </ul>
          </div>
        </nav>
      </div>
    </header>
    <?php }?>
