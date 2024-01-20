<style>
    .d-none {
     display: block !important; 
}
.label.green {
    background: rgb(255, 138, 13);
}

.label {
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    color: #fff;
    font-family: 'GraphikBold';
    text-align: center;
    top: -16px;
    left: -25px;
    padding: 8px;
}
.green .label-content {
    background: #37c64f;
}
.label-content {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
}
</style>    
    <!-- get Header top menu -->
    <?php
      $data_link = (object)array(
        'link'  => cn(strip_tags($category->url_slug)),
        'name'  => strip_tags($category->name)
      );
    ?>
    <?php echo Modules::run("blocks/user_header_top", $data_link);
    //pr($data_link);
    ?>    
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-xVVam1KS4+Qt2OrFa+VdRUoXygyKIuNWUUUBZYv+n27STsJ7oDOHJgfF0bNKLMJF" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE; ?>assets/css/my_css.css" id="theme-stylesheet">
    <section class="package-content text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
              <!--<p class="text-center" style="color:red;"><b>If you have any query regarding make a purchase please talk to us. To connect with our live agent, please click on chat icon at right bottom.</b></p>-->
            <div class="pk-header">
              <?php
                if($category->name == "Buy Instagram Followers"){
                    $replace_text = '<strong>Buy Instagram Followers Cheap</strong>';
                }else{
                    $replace_text = '<strong>'.strip_tags($category->name).'</strong>';
                }
                
              ?>
              <div class="title">
                <h1 class="title-name"><?php echo $replace_text;?></h1> 
              </div>
              <span class="text-muted"><h2 style="font-size: 1.25rem;">With the instahotstar.com you can <?php echo $replace_text;?> with Instant Delivery.</h2></span>
              <span class="text-muted"><?php echo lang('select_a_package_that_you_like_and_submit_order_now_button'); ?></span>
                        <div class="stars" style="color:#f3632e;font-size: 20px;">
                        <?php 
                        $starRating = '';
                        if($category_rating != 0){
                          for($i = 0; $i<$category_rating; $i++){
                        $starRating .= 'â˜…';
                        }
                        $starRatingText = $starRating.' (<a class="scroll-down-ro-review-area" href="javascript:void(0);">'.$category_review_count.' Reviews</a>)';
                      }else{
                        $starRatingText ='(No Reviews)';
                      }
                        
                        echo $starRatingText;
                        ?>
                        </div>

            </div>
<script type="text/javascript">
  $(".scroll-down-ro-review-area").on('click',function() {
    $('html, body').animate({
        'scrollTop' : $("#review-section-area").position().top
    });
});
</script>
            <div class="owl-carousel pk-lists">
              <?php
                $setting_number  = get_setting_number_format();
                $currency_symbol = get_option('currency_symbol', '$');
                if (!empty($services)) {
                  foreach ($services as $key => $row) {
                    //pr($row);
              ?>
              <form action="<?php echo cn('checkout'); ?>" method="POST">
              <div class="item">
				<div class="card">
				<?php if($row->quantity == '250' && $row->cat_id = 13): ?>
			  <div class="label green" style="background: rgba(,,,.5);"><div class="label-content" style="background:#f16334;"> Most Popular</div></div>
                <?php endif; ?>
                  <div class="text-center">
                    <div class="name">
                      <div class="number"><?php echo strip_tags($row->quantity); ?></div>
                      <span><?php echo strip_tags($row->name); ?></span>
                      <div class="stars" style="color:#f3632e;font-size: 10px;">
                        <?php 
                        $starRatingProduct = '';
                        if($row->review_count != 0){
                          for($i = 0; $i<$row->rating; $i++){
                        $starRatingProduct .= 'â˜…';
                        }
                        $starRatingProductText = $starRatingProduct.' (<a href="#review-section-area">'.$row->review_count.' Reviews</a>)';
                      }else{
                        $starRatingProductText ='(No Reviews)';
                      }
                        
                        echo $starRatingProductText;
                        ?>
                        </div>
                    </div>
                    <div class="price">
                      <sub class="symbol"><?php echo strip_tags($currency_symbol); ?></sub>
                      <span class="big"><?php echo currency_format($row->price, $setting_number->decimal_places, $setting_number->decimal_separator, $setting_number->thousand_separator); ?></span>
                    </div>
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
					  <li class="text-icon"><i class="" aria-hidden="true"></i> <a style="text-decoration:underline;" href="<?php echo cn((isset($row->package_slug))?$row->package_slug:''); ?>">Read More</a></li>
                    </ul>
                    <div class="text-center order_button">
                      <div class="">
                        <input type="hidden" name="<?php echo strip_tags($this->security->get_csrf_token_name());?>" value="<?php echo strip_tags($this->security->get_csrf_hash());?>">
                        <input type="hidden" name="item_id" value="<?php echo strip_tags($row->id); ?>">
                        <span class="btn btn-dark"><i class="fe fe-shopping-cart"></i></span>
                        <?php 
                          if ($row->status) {
                        ?> 
                        <button onclick="window.location='<?php echo cn('checkout/selectproduct').'?service='.$row->ids; ?>'" class="btn btn-color" type="button">
                          <?php echo lang('order_now'); ?>
                        </button>
                        <?php }else{ ?>
                         <span class="btn btn-disabled">
                          <?php echo lang('Disabled'); ?>
                        </span> 
                        <?php }?>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
              </form>
              <?php }}?>

            </div>
            <!-- Category Content -->
            <?php echo html_entity_decode((isset($category->category_content))?$category->category_content:'', ENT_QUOTES); ?>
            <?php //echo (isset($category->category_content))?$category->category_content:''; ?>
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
                    <p class="desc">In the checkout form just enter your Instagram username. Our system will automatically get your public info. We DO NOT require your instagram account password</p>
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
<h2>Instahotstar - Your #1 Instagram Maketing Service Provider</h2>
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

<section class="section section--gray section--reviews" id="review-section-area">
<div class="section__head">
<div class="shell">
<h2>Customer Feedback &amp; Reviews <i class="em em-slightly_smiling_face"></i></h2>
<p>Here at Instahotstar we pride ourselves in exceptional service and affordable prices. Don't just take our word for it - check out our customer reviews below</p>
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
<input type="hidden" name="service_id" value="0">
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

<div class="rr_review_post_id" itemprop="name" style="display:none;">
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
          $starRating .= 'â˜…';
      }
      echo $starRating;
    ?>
</div>
<div style="display:none;" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating">
<span itemprop="ratingValue">5</span>
<span itemprop="bestRating">5</span>
<span itemprop="worstRating">1</span>
</div>
<div class="clear"></div>
<div class="rr_review_text"><span class="drop_cap">â€œ</span><span itemprop="reviewBody"><?php echo $review->review; ?></span>”</div>
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
