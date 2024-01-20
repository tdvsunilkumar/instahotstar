    <?php if($display_html){?>
    <div class="footer footer_top dark">
      <div class="container m-t-60 m-b-50">
        <div class="row">
          <div class="col-lg-3">
            <div class="site-logo m-b-30" style="margin-bottom:10px;">
              <a href="<?php echo cn(); ?>" class="m-r-20">
                <img src="<?php echo get_option('website_logo_white', BASE."assets/images/logo-white.png"); ?>" alt="Website logo">
              </a>
              
            </div>
            <p><?php echo strip_tags(get_option('website_desc', "SmartStore is the best option to get all social media services in website. Easy build Social Media Marketing Store with a unique design and business process automation")); ?></p>
          </div>
          <div class="col-lg-9 m-t-30  mt-lg-0">
            <div class="row">
              <div class="col-lg-4  mt-lg-0">
                <h4 class="title"><?php echo lang("Quick_links"); ?></h4>
                <ul class="list-unstyled quick-link mb-0">
                  <li><a href="<?php echo cn(); ?>"><?php echo lang("Home"); ?></a></li>
                  <li><a href="<?php echo cn('faq'); ?>"><?php echo lang("FAQs"); ?></a></li>
                  <li><a href="<?php echo cn('blog'); ?>"><?php echo lang('Blog'); ?></a></li>
                  <li><a href="<?php echo cn('terms'); ?>"><?php echo lang("terms__conditions"); ?></a></li>
                  
                </ul>
              </div>
              <div class="col-lg-4  mt-lg-0">
                <h4 class="title">Best Offers</h4>
                <ul class="list-unstyled quick-link mb-0">
                  <?php 
                        foreach ($firstThreeItems as $key => $category) {
                      ?>
                      <li><a href="<?php echo cn($category->url_slug); ?>"><?php echo strip_tags($category->name); ?></a>
                        </li>
                      <?php } ?>
                </ul>
              </div>
              <div class="col-4 col-md-4  mt-lg-0">
            <h4 class="title"><?php echo lang("contact_informations"); ?></h4>
            <ul class="list-unstyled">
              
              <li><?php echo lang("Email"); ?>: <?php echo get_option('contact_email',"do-not-reply@smartpanel.com"); ?> </li>
              <li><?php echo lang("working_hour"); ?>: <?php echo get_option('contact_work_hour',"Mon - Sat 09 am - 10 pm"); ?> </li>
              <!--<li><a href="//showstreams.tv/"><img src="//www.free-kassa.ru/img/fk_btn/15.png" title="Бесплатный видеохостинг"></a></li>-->
              <li><a href="//www.dmca.com/Protection/Status.aspx?ID=6af2a1dc-60ee-4045-9fc9-42709a62c8a1" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca_protected_sml_120n.png?ID=6af2a1dc-60ee-4045-9fc9-42709a62c8a1"  alt="DMCA.com Protection Status" /></a>  <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script></li>
            </ul>
          </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer footer_bottom dark">
      <div class="container">
        <div class="row align-items-center flex-row-reverse">
          <div class="col-auto ml-lg-auto">
            <div class="row align-items-center">
              <div class="col-auto">
                <ul class="list-inline mb-0">
                  <?php 
                    if (get_option('social_facebook_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?php echo get_option('social_facebook_link',''); ?>" target="_blank" class="btn btn-icon btn-facebook"><i class="fa fa-facebook"></i></a></li>
                  <?php }?>
                  <?php 
                    if (get_option('social_twitter_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?php echo get_option('social_twitter_link',''); ?>" target="_blank" class="btn btn-icon btn-twitter"><i class="fa fa-twitter"></i></a></li>
                  <?php }?>
                  <?php 
                    if (get_option('social_instagram_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?php echo get_option('social_instagram_link',''); ?>" target="_blank" class="btn btn-icon btn-instagram"><i class="fa fa-instagram"></i></a></li>
                  <?php }?>

                  <?php 
                    if (get_option('social_pinterest_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?php echo get_option('social_pinterest_link',''); ?>" target="_blank" class="btn btn-icon btn-pinterest"><i class="fa fa-pinterest"></i></a></li>
                  <?php }?>

                  <?php 
                    if (get_option('social_tumblr_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?php echo get_option('social_tumblr_link',''); ?>" target="_blank" class="btn btn-icon btn-vk"><i class="fa fa-tumblr"></i></a></li>
                  <?php }?>

                  <?php 
                    if (get_option('social_youtube_link','') != '') {
                  ?>
                  <li class="list-inline-item"><a href="<?php echo get_option('social_youtube_link',''); ?>" target="_blank" class="btn btn-icon btn-youtube"><i class="fa fa-youtube"></i></a></li>
                  <?php }?>

                </ul>
              </div>
            </div>
          </div>
          
          <?php
            $version = get_field(PURCHASE, ['pid' => 23595718], 'version');
            $version = 'Ver'.$version;
          ?>
          <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
            <?php echo lang("Copyright"); ?> <?php echo (get_role("admin")) ? $version : "" ?>
          </div>
        </div>
      </div>
      
    </footer>
    <?php }?>
    <div id="message-purchased" class="wn-background-template-type-0 wn-product-with-image fade-in" style="display: none;"><div id="notify-close"></div></div>

    <script src="<?php echo BASE; ?>assets/plugins/vendors/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/vendors/jquery.sparkline.min.js"></script>
    <script src="<?php echo BASE; ?>assets/js/core.js"></script>
    <!-- toast -->
    <script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/jquery-toast/js/jquery.toast.js"></script>
    <!-- AOS -->
    <script src="<?php echo BASE; ?>themes/pergo/assets/plugins/aos/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <?php  if(segment(1) != 'auth'){?>
    <!-- theme Js -->
    <script src="<?php echo BASE; ?>themes/pergo/assets/js/theme.js"></script>
    <?php } ?>
    <!-- Script js -->
    <script src="<?php echo BASE; ?>assets/js/process.js"></script>
    <script src="<?php echo BASE; ?>assets/js/general.js"></script>
    <?php echo htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES); ?>
    <script>
      $(document).ready(function(){
        "use strict";
        var is_notification_popup = "<?php echo get_option('enable_notification_popup', 0); ?>"
        setTimeout(function(){
            if (is_notification_popup == 1) {
              $("#notification").modal('show');
            }else{
              $("#notification").modal('hide');
            }
        },500);
     });
    </script>
    <script type='text/javascript'>
/* <![CDATA[ */
var _woocommerce_notification_params = {"str_about":"About","str_ago":"ago","str_day":"day","str_days":"days","str_hour":"hour","str_hours":"hours","str_min":"minute","str_mins":"minutes","str_secs":"secs","str_few_sec":"a few seconds","time_close":"24","show_close":"1","display_effect":"fade-in","hidden_effect":"fade-out","redirect_target":"0","image":"0","messages":["Someone in {city} purchased {product_with_link} {time_ago}"],"message_custom":"{number} people seeing this product right now","message_number_min":"100","message_number_max":"200","detect":"1","time":"0","names":["T2xpdmVyDQ==","SmFjaw0=","SGFycnkN","SmFjb2IN","Q2hhcmxpZQ=="],"cities":["SW5kb25lc2lhDQ==","R2VybWFueQ0=","RGVubWFyaw0=","R3JlYXQgQnJpdGFpbg0=","U2F1ZGlhIEFyYWJpYQ0=","U3BhaW4N","VW5pdGVkIFN0YXRlcw0=","R3JlYXQgQnJpdGFpbg0=","TW9yb2Njbw0=","TmV0aGVybGFuZHMN","RG9taW5pY2FuIFJlcHVibGljDQ==","VW5pdGVkIEFyYWIgRW1pcmF0ZXMN","U2luZ2Fwb3JlDQ==","VW5pdGVkIEtpbmdkb20N","VW5pdGVkIEFyYWIgRW1pcmF0ZXMN","RWd5cHQN","SmFwYW4N","VHVya2V5DQ==","QmVsZ2l1bQ0=","RmlubGFuZA0=","VW5pdGVkIFN0YXRlcw0=","R3JlYXQgQnJpdGFpbg0=","U2F1ZGlhIEFyYWJpYQ0=","Sm9yZGFu","SHVuZ2FyeQ0=","R2VybWFueQ0=","VW5pdGVkIFN0YXRlcw0=","VWtyYWluZQ0=","TWFsYXlzaWEN","U2F1ZGlhIEFyYWJpYQ0=","U3dlZGVuDQ==","VW5pdGVkIFN0YXRlcw0=","VW5pdGVkIFN0YXRlcw0=","VW5pdGVkIFN0YXRlcw0=","RnJhbmNlDQ==","TmV0aGVybGFuZHMN","VW5pdGVkIEFyYWIgRW1pcmF0ZXMN","U2F1ZGkgQXJhYmlhDQ==","Tm9yd2F5DQ==","U291dGggQWZyaWNhDQ==","VW5pdGVkIFN0YXRlcw0=","VW5pdGVkIFN0YXRlcw0=","SXRhbHkN","VW5pdGVkIEFyYWIgRW1pcmF0ZXMN","VW5pdGVkIFN0YXRlcw0=","UG9ydHVnYWwN","Q2hpbmEN","SXJlbGFuZA0=","SW5kaWEN","UnVzc2lhDQ=="],"country":"United States","billing":"0","products":[{"title":"300 Followers","url":"https:\/\/instahotstar.com\/checkout\/selectproduct?service=af83daca2ca56d8117e3ee2d07898161","thumb":"https:\/\/instahotstar.com\/assets\/uploads\/blogs\/followers_image-1-150x150.png"},{"title":"500 Followers","url":"https:\/\/instahotstar.com\/checkout\/selectproduct?service=36b7993e0be5fc8580a098963cd22d7c","thumb":"https:\/\/instahotstar.com\/assets\/uploads\/blogs\/followers_image-1-150x150.png"},{"title":"1000 Followers","url":"https:\/\/instahotstar.com\/checkout\/selectproduct?service=44baac2036aecb8a6451942b896b4d67","thumb":"https:\/\/instahotstar.com\/assets\/uploads\/blogs\/followers_image-1-150x150.png"}]};
/* ]]> */
</script>
<script type='text/javascript' src='<?php echo BASE; ?>assets/js/woo-notification.min.js'></script>
  </body>
</html>