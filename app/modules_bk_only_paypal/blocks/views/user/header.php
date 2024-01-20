    <link href="<?php echo BASE; ?>assets/css/woo-notification.min.css" rel="stylesheet">
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
    <header class="header fixed-top" id="headerNav">
      <div class="container">
        <nav class="navbar navbar-expand-lg ">
          <a class="navbar-brand" href="<?php echo cn(); ?>">
            <img class="site-logo" src="<?php echo get_option('website_logo', BASE."assets/images/logo.png"); ?>" alt="Webstie logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fe fe-menu"></i></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item <?php echo (segment(1) == '') ? "active" : ""?>">
                <a class="nav-link js-scroll-trigger" href="<?php echo cn(); ?>"><?php echo lang("Home"); ?></a>
              </li>

              <?php 
                        foreach ($firstThreeItems as $key => $category) {
                      ?>
                      <li class="nav-item <?php echo (segment(1) == '') ? "active" : ""?>"><a class="nav-link js-scroll-trigger" href="<?php echo cn($category->url_slug); ?>"><?php echo strip_tags($category->name); ?></a>
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