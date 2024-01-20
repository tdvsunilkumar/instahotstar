    
    <style type="text/css">
    .d-none {
     display: block !important; 
}
      .flex-middle {
    -webkit-align-items: center;
    -ms-flex-align: center;
    -webkit-box-align: center;
    align-items: center;
    align-self: center;
}.section-title {
    font-size: 34px;
    color: #19224c;
    margin: 0 0 20px;
}.price-product {
    color: #ff7b7b;
    font-weight: 600;
    font-size: 24px;
}.btn-pink {
    border-radius: 26px;
    border-color: #f16334 !important;
    background-color: #f16334 !important;
    padding: 10px 25px;
    min-width: 230px;
    display: inline-block;
    color: #fff;
    font-family: 'GraphikBold';
    border: 2px solid transparent;
    text-align: center;
    position: relative;
    top: 0;
}
.description{
    padding:0px 0px 0px 0px;
}
@media (max-width: 767px){
.section {
    text-align: center;
    padding: 60px 0;
}
.description{
    padding:0px 0px 0px 0px;
}
/*.section ul{
    text-align: left;
    padding: 60px 0;
}*/

}
section.how-it-works .header-top .title {
    line-height: 45px;
    font-size: 40px;
    font-weight: 600;
    font-family: 'Source Sans Pro', sans-serif;
}
    </style>
    <!-- get Header top menu -->
    <?php
      $data_link = (object)array(
        'link'  => cn(strip_tags($service->package_slug)),
        'name'  => strip_tags($service->name)
      );
    ?>
    <?php echo Modules::run("blocks/user_header_top", $data_link); ?>    
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-xVVam1KS4+Qt2OrFa+VdRUoXygyKIuNWUUUBZYv+n27STsJ7oDOHJgfF0bNKLMJF" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/css/my_css.css" id="theme-stylesheet">
    <section class="package-content" style="padding: 0px 0 100px;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            
             <!-- Copied Content -->
             <div class="section section-gradient section-product margin-top-25" style="padding-top: 50px;">
   <div class="container">
      <div class="row">
         <div class="col-5 col-12 col-xl-6 col-lg-5 col-md-5 text-center flex-middle">

          <img width="350" height="292" src="<?php echo (isset($service->image))?$service->image:''; ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" srcset="<?php echo (isset($service->image))?$service->image:''; ?> 469w" sizes="(max-width: 469px) 100vw, 469px">

        </div>
         <div class="col-12 col-xl-6 col-lg-7 col-md-7 flex-middle">
            <div>
               <h1 class="section-title"> <span > <?php echo (isset($service->quantity))?$service->quantity:''; ?> <?php echo (isset($service->name))?ucwords($service->name):''; ?></span></h1>
               <div class="stars" style="color:#f3632e;font-size: 20px;">
                        <?php 
                        $starRating = '';
                        if($product_rating != 0){
                          for($i = 0; $i<$product_rating; $i++){
                        $starRating .= '★';
                        }
                        $starRatingText = $starRating.' (<a class="scroll-down-ro-review-area" href="javascript:void(0);">'.$product_review_count.' Reviews</a>)';
                      }else{
                        $starRatingText ='(<a class="scroll-down-ro-review-area" href="javascript:void(0);">No Reviews</a>)';
                      }
                        
                        echo $starRatingText;
                        ?>
                        </div>
               <img style="display: none" src="<?php echo (isset($service->image))?$service->image:''; ?>">
               <p class="old-price medium" style="font-size: 24px;color: #bfc2fe;text-decoration: line-through;"></p>
               <div class="price-product" style="font-size: 32px">
                  <span>$</span><span> <?php echo (isset($service->price))?number_format((float)$service->price, 2, '.', ''):''; ?> </span>
                  <link>
               </div>
               <div class="description" style="margin-top: 20px;">
                <ul class="features list-unstyled leading-loose">
                  <li><i class="fa fa-usd text-icon" aria-hidden="true"></i> One Time Payment</li>
                  <li><i class="fa fa-money text-icon" aria-hidden="true"></i> Refund Policy</li>
                      <li><i class="fe fe-star text-icon" aria-hidden="true"></i> <?php echo lang('high_quality');?></li>
                      <li><i class="fe fe-unlock text-icon" aria-hidden="true"></i> <?php echo lang('no_password_needed');?></li>
                      <li><i class="fe fe-thumbs-up text-icon" aria-hidden="true"></i> <?php echo lang('drop_protection');?></li>
                      <li><i class="fe fe-shield text-icon" aria-hidden="true"></i> <?php echo lang('safe_and_easy');?></li>
                      <li><i class="fe fe-pie-chart text-icon" aria-hidden="true"></i> 1-7 Days Delivery Guaranteed</li>
                      <li><i class="fe fe-message-circle text-icon" aria-hidden="true"></i> <?php echo lang('2_47_support');?></li>
                      <li class="text-success"><i class="fe fe-check " aria-hidden="true"></i> <?php echo lang('secure_payments');?></li>
                    </ul>
                 
               </div>
            </div>
            <a style="margin-top: 10px;" href="<?php echo cn('checkout/selectproduct').'?service='.$service->ids; ?>" rel="nofollow" class="btn-pink mt30"> BUY NOW </a>
         </div>
      </div>
      <div class="row" style="margin-top: 45px;">
          
         <div class="col-md-12 detail-page-card-items" style="padding: 40px 0 40px;text-align: center;"> 
         <!--<p class="text-center" style="color:red;"><b>If you have any query regarding make a purchase please talk to us. To connect with our live agent, please click on chat icon at right bottom.</b></p>-->
          <img data-src="<?php echo BASE; ?>/assets/images/30_days.png" src="<?php echo BASE; ?>/assets/images/30_days.png"> 

          <img data-src="https://instahotstar.com/assets/images/paypal_new.png" style="margin: 0 35px;width:160px;height:47px" src="https://instahotstar.com/assets/images/paypal_new.png">

           <img data-src="<?php echo BASE; ?>/assets/images/credit-debit-card-payment.png" style="max-width: 150px;position: relative;" src="<?php echo BASE; ?>/assets/images/credit-debit-card-payment.png">

         </div>
         <div class="col-12">
            <div class="service-description">
               <p class="description"></p>
               <?php echo html_entity_decode((isset($service->description))?$service->description:'', ENT_QUOTES); ?>
                <?php //echo (isset($service->description))?$service->description:''; ?>
               <p></p>
            </div>
         </div>
      </div>
   </div>
</div>
             <!-- Copied Content -->
            <!-- Category Content -->
            
            <!-- Category Content -->
          </div>
        </div>
      </div>
    </section>

    <section class="how-it-works text-center">
      <div class="container">
        <div class="row " data-aos="fade-down" data-aos-easing="ease-in" data-aos-delay="200">
          <div class="col-md-12 mx-auto">
            <div class="header-top">
              <div class="title">
                <?php echo lang("how_to_buy_a_package"); ?>
              </div>
              <span class="">Buying social media packages from instaHotStar.com is simple and fast. Just follow these steps </span>
            </div>
            <div class="col-md-12">
              <div class="row step-lists">

                <div class="col-sm-6 col-lg-4 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("choose_package"); ?></h3>
                    <p class="desc">Very easily you can start. Choose from our wide range of Instagram marketing packages that suit your requirements</p>
                  </div>
                  <div class="bg-number">1</div>
                </div>

                <div class="col-sm-6 col-lg-4 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("enter_details"); ?></h3>
                    <p class="desc">In the checkout form just enter your Instagram username. Our system will automatically get your public info. We DON’T require your instagram account password</p>
                  </div>
                  <div class="bg-number">2</div>
                </div>

                <div class="col-sm-6 col-lg-4 step text-left">
                  <div class="header-name">
                    <h3><?php echo lang("wait_for_results"); ?></h3>
                    <p class="desc">You can pay via any bank card and paypal. We will proceed with the order and inform you once its done via email. And you can also track your order status from the client area</p>
                  </div>
                  <div class="bg-number">3</div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php if(isset($faqs) && !empty($faqs)): ?>
    <section class="section section--faq">
<div class="section__head">
<div class="shell">
<h2>Instahotstar - Your #1 Instagram Provider</h2>
<p>1,000,000 happy customer's can't be wrong!</p>
</div>
</div>
<div class="section__body">
<div class="shell shell--normal">
<?php foreach ($faqs as $faq): ?>
<div class="section__body-col">
<div class="accordion-main">
<?php foreach ($faq as $item): ?>
<div class="accordion__group">
<div class="accordion__head">
<h4><?php echo (isset($item->question))?$item->question:''; ?></h4>
</div>
<div class="accordion__body">
<p>
<?php echo (isset($item->answer))?$item->answer:''; ?>
</p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<script type="text/javascript">
  var acc = document.getElementsByClassName("accordion__head");
  $('.accordion__head').click(function(){
    var panel = $(this).parent();
    console.log(panel);
    $('.accordion__group active').toggleClass('accordion__group');
    panel.toggleClass("active");
  });
// var i;

// for (i = 0; i < acc.length; i++) {
//   acc[i].addEventListener("click", function() {
//     /* Toggle between hiding and showing the active panel */
//     var panel = $(this).parent();
//     console.log(panel);
//     $('.accordion__group active').toggleClass('accordion__group');
//     panel.toggleClass("active");
//   });
// }
</script>
</section>
<?php endif; ?>

<section class="section section--gray section--reviews" id="review-section-area" style="text-align: left;">
<div class="section__head">
<div class="shell">
<h2>Customer Feedback &amp; Reviews <i class="em em-slightly_smiling_face"></i></h2>
<p>Here at Instahotstar we pride ourselves in exceptional service and affordable prices. Don’t just take our word for it – check out our customer reviews below</p>
</div>
</div>
<div class="section__body">
<div class="shell shell--medium">
  <div class="col-md-12">
                    <div id="alert-message" class="save-review-alert">
                      
                    </div>
                  </div>
<div class="section__body-form">
<div class="form-review">
<form id="submitReview" action="<?php echo cn('reviews/store'); ?>" method="POST">
  <input type="hidden" id="csrf_token"  name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

<input type="hidden" name="action" value="review">
<input type="hidden" name="category_id" value="<?php echo $category->id; ?>">
<input type="hidden" name="service_id" value="<?php echo (isset($service->id))?$service->id:''; ?>">
<div class="form__head">
<img src="<?php echo BASE; ?>assets/images/form-review.svg" alt="">
<h4>Submit Your Review</h4>
</div>
<div class="form__body">
<ul>
<li>
<div class="form__field">
<label>Name</label>
<input name="name" type="text" placeholder="Your name"   maxlength="32">
<span class="error" id="name"></span>
</div>
</li>
<li>
<div class="form__field">
<label>Email</label>
<input name="email" type="email" placeholder="your@email.com"  maxlength="100">
<span class="error" id="email"></span>
</div>
</li>
 <li>
<div class="form__field form__field--rating">
<label>Rating</label>

<fieldset class="rating">
    <input type="radio" id="star5" name="rating" value="5" />
    <label class = "full" for="star5" ></label>

    <input type="radio" id="star4" name="rating" value="4" />
    <label class = "full" for="star4" title="Pretty good - 4 stars"></label>

    <input type="radio" id="star3" name="rating" value="3" />
    <label class = "full" for="star3" title="Meh - 3 stars"></label>

    <input type="radio" id="star2" name="rating" value="2" />
    <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>

    <input type="radio" id="star1" name="rating" value="1" checked/>
    <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
</fieldset>
<span class="error" id="rating"></span>
</div>
</li>
<li>
<div class="form__field form__field--textarea">
<label>Review</label>
<textarea name="comment" cols="" rows="" placeholder="Your Review" maxlength="500"></textarea>
<span class="error" id="comment"></span>
</div>
</li>
</ul>
</div>
<div class="form__actions">
<input type="submit" value="Submit review" class="form__btn">
</div>
</form>
</div>
</div>
<div class="section__body-review">
<div class="list-reviews" data-post="18">
<div class="page_reviews" style="overflow-y: scroll;">
  <script type="text/javascript">
  $(".scroll-down-ro-review-area").on('click',function() {
    $('html, body').animate({
        'scrollTop' : $("#review-section-area").position().top
    });
});
</script>
<script type="text/javascript">
  $('#submitReview').on('submit', function(e){
        e.preventDefault(); 
        var $this = $(this);
        $.ajax({ 
            url: '<?php echo cn('reviews/store'); ?>',
            method: $this.prop('method'),
            dataType: 'json',  //3
            data: $this.serialize(), //4
        }).done( function (response) {
            if(response.status==1){
              $('#submitReview')[0].reset();
              $(".error").show().html(''); 
              $(".save-review-alert").empty().append('<div class="alert alert-icon content alert-success" role="alert"><span class="message">'+response.message+'</span></div>'); 
            }
            if(response.status==2){
            $(".error").show().html(''); 

            $.each( response.errors, function( key, error) { 
            $("#"+key).show().html(error);
            });
            }      
        }).fail(function() {
            $(".save-review-alert").empty().append('<div class="alert alert-icon content alert-danger" role="alert"><span class="message">Server error, Please try again.</span></div>'); 
         });
            });
</script>
<div class="testimonial_group">
<?php if(isset($reviews) && !empty($reviews)): ?>
<?php foreach($reviews as $review): ?>
<div class="testimonial" itemscope="" >
<h3 class="rr_title" style="display:none" itemprop="name">Haha No Way!</h3>
<div class="clear"></div>
<span>
<div class="rr_review_post_id" itemprop="name" style="display:none;">
<a href="javascript:void(0);">Instahotstar Followers</a>
</div>
<div class="clear"></div>
</span>
<span class="rr_date" style="display:none;"><meta itemprop="datePublished" content="2018-03-23 21:44:30">
<time datetime="March 23, 2018">March 23, 2018</time>
</span>
<div class="stars">
    <?php 
      $starRating = '';
      for($i = 0; $i<$review->rating; $i++){
          $starRating .= '★';
      }
      echo $starRating;
    ?>
</div>

<div class="clear"></div>
<div class="rr_review_text"><span class="drop_cap">“</span><span itemprop="reviewBody"><?php echo $review->review; ?></span>”</div>
<div class="rr_review_name" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
<span itemprop="name">- <?php echo $review->name; ?></span></div>
<div class="clear"></div>
</div>
<?php endforeach; ?>
<?php else: ?>
  <div class="testimonial" itemscope="" ><div class="rr_review_text"><span class="drop_cap">“</span><span itemprop="reviewBody">No review found</span>”</div></div>
<?php endif; ?>


</div>
<!-- <div class="all_reviews">
<a href="#">Show All Reviews</a>
</div>
<div class="more_reviews">
<a href="#">Read More Reviews</a>
</div> -->
</div>
</div>
</div>
</div>
</div>
</section>

    <script type="text/javascript">
      $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:1,
                    nav:false
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:false
                }
            }
        })
      });
    </script>
