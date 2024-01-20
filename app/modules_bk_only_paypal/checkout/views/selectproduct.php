    <script src="<?php echo BASE; ?>assets/js/myjs.js"></script>
    <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
<script type="text/javascript">
    var vendor = '<?php echo PADDLE_VENDOR_ID; ?>';
    Paddle.Setup({ vendor: parseInt(vendor) });
</script>
    <style type="text/css">
.section {
    padding: 100px 0 80px;
}.container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
.default-part {
    max-width: 680px;
    margin: 0 auto;
    border: 1px solid #d0e3eb;
    border-radius: 10px;
    background: #fff;
    box-shadow: 5px 9px 60px rgba(50,117,208,.1);
    padding: 40px 45px;
    width: 100%;
    position: relative;
}
.default-part .title {
    font-size: 24px;
    margin: 0 0 10px;
    padding: 0;
}.template-content p {
    margin: 15px 0 15px;
    text-align: center;
}.default-part .subtitle {
    font-size: 18px;
    margin: 0 0 35px;
}form input[type=text], form input[type=email], form input[type=phone], form textarea {
    border: 1px solid #babdfb;
    width: 100%;
    padding: 10px 15px;
    margin: 0 0 10px;
    border-radius: 4px;
    color: #19224c;
    font-size: 14px;
}.btn-pink {
    border-radius: 26px;
    border-color: #f16334 !important;
    background-color: #f16334 !important;
    padding: 10px 25px;
    min-width: 230px;
    display: inline-block;
    color: #fff;
    border: 2px solid transparent;
    text-align: center;
    position: relative;
    top: 0;
}.mt15 {
    margin-top: 15px !important;
}.package {
    padding: 25px 0;
    border-top: 1px solid #babdfb;
    margin: 40px 0 0;
}.package p {
    width: calc(100% - 240px);
}.package p, .package a {
    display: inline-block;
    vertical-align: middle;
    -ms-text-overflow: ellipsis;
    text-overflow: ellipsis;
    overflow: hidden;
}.package-select {
    padding: 25px 0;
    border-top: 1px solid #babdfb;
    margin: 40px 0 0;
    display: none;
}.package-select .select-inner {
    width: 100%;
    position: relative;
}.package-select .select-inner:before {
    content: '\f107';
    font-family: 'Font Awesome 5 Free';
    font-size: 18px;
    color: #598eee;
    font-weight: 800;
    display: inline-block;
    vertical-align: baseline;
    margin: 0 0 0 5px;
    position: absolute;
    top: 20px;
    left: 100%;
    margin-left: -20px;
}.package-select select {
    border: 1px solid #babdfb;
    width: 100%;
    padding: 10px 15px;
    margin: 10px 0 10px;
    border-radius: 4px;
    color: #babdfb;
    font-size: 18px;
    position: relative;
    background: 0 0;
}.default-part {
    max-width: 680px;
    margin: 0 auto;
    border: 1px solid #d0e3eb;
    border-radius: 10px;
    background: #fff;
    box-shadow: 5px 9px 60px rgba(50,117,208,.1);
    padding: 40px 45px;
    width: 100%;
    position: relative;
}.default-part .title {
    font-size: 24px;
    margin: 0 0 10px;
    padding: 0;
}.payment-div .price {
    font-size: 76px;
}#paypal-button-container {
    margin: 30px auto;
    text-align: center;
}.note {
    font-size: 16px;
}.account-view .account-change {
    border-bottom: 0;
}

.account-change {
    border-bottom: 1px solid #babdfb;
    padding: 0 0 45px;
    margin: 0 0 45px;
}.account-change img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: inline-block;
    vertical-align: middle;
}.account-change a {
    display: inline-block;
    vertical-align: middle;
}.account-change p {
    display: inline-block;
    overflow: hidden;
    -ms-text-overflow: ellipsis;
    text-overflow: ellipsis;
    width: calc(100% - 311px);
    vertical-align: middle;
    padding: 0 20px;
}.account-change {
    border-bottom: 1px solid #babdfb;
    padding: 0 0 45px;
    margin: 0 0 45px;
}.account-change.account-photo p {
    width: 100%;
    padding: 0;
}.account-change.account-photo p {
    width: 100%;
    padding: 0;
}.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}.account-change .media-cor {
    margin-bottom: 10px;
}.col-12 {
    position: relative;
    padding-right: 15px;
    padding-left: 15px;
}.account-change a {
    display: inline-block;
    vertical-align: middle;
}

.media-item {
    border-radius: 6px;
    -webkit-transition: -webkit-box-shadow .2s linear;
    transition: -webkit-box-shadow .2s linear;
    transition: box-shadow .2s linear;
    transition: box-shadow .2s linear,-webkit-box-shadow .2s linear;
    -webkit-box-shadow: 0 2px 8px 1px rgba(0,0,0,.2);
    box-shadow: 0 2px 8px 1px rgba(0,0,0,.2);
    display: table;
    width: 100%;
    height: 100%;
    overflow: hidden;
    min-height: 140px;
    position: relative;
}.media-item img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
    border-radius: 0 !important;
}

.account-change img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: inline-block;
    vertical-align: middle;
}.media-item .hover {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    background: rgba(0,0,0,.4);
    height: 100%;
    width: 100%;
    text-align: center;
    line-height: 140px;
    color: #fff;
    opacity: 0;
    visibility: hidden;
    transition: all .3s ease;
}.media-item .hover i {
    font-size: 16px;
    margin: 0 10px 0 0;
}.summary {
    display: none;
}.summary-item {
    width: calc(50% - 25px);
    display: inline-block;
    vertical-align: middle;
    margin: 5px 10px 5px 0;
    border-radius: 6px;
    padding: 10px;
    -webkit-box-shadow: 0 3px 10px 1px rgba(0,0,0,.15);
    box-shadow: 0 3px 10px 1px rgba(0,0,0,.15);
}.summary-item img {
    width: 50px;
    height: 50px;
    border-radius: 6px;
    display: inline-block;
    vertical-align: middle;
}.summary-item a {
    display: inline-block;
    vertical-align: middle;
}.account-change .media-item.active .hover {
    opacity: 1;
    visibility: visible;
}.custom-loader {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
    font-size: 64px;
    padding-top: 20%;
    background: rgba(255, 255, 255, .9)
}

.custom-loader .fas {
    opacity: .5
}#upgrade-body{
    margin: 0 0 15px;
    text-align: left;
}#checkout-payment-applied-upgrade p{
    margin: 0 0 15px;
    text-align: left;
}
.d-none{
    display: block !important;
}
section.header-top .mini-menu {
    padding-left: 0px;
}
@media (min-width: 1200px){

  .container {
    max-width: 1140px;
    margin: 0 auto;
    padding-right: 15px;
    padding-left: 15px;
}
}

@media (max-width: 767px){
#upgrade-button {
    min-width: auto !important;
    width: 100%;
}
#checkout-payment-applied-upgrade p {
    display: block !important;
    width: 100% !important;
    margin-bottom: 15px;
}
.section>:first-child {
    padding-top: 100px !important;
}
.account-change p, .account-change.package p, .package p {
    width: 100%;
    margin: 0 0 20px;
}.package-select .select-inner {
    width: 100%;
}.account-change img {
    display: table;
    margin: 0 auto 30px;
}.summary-item {
    width: 100%;
}

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
             <div class="section template-content">
   <div class="container">
      <div class="default-part mb30 checkout-section">
        <form id="submitinstaaccount" method="post" action="<?php echo cn('checkout/ajaxsubmitinstaaccount') ?>"> 
        <input type="hidden" name="timezone_offset">
         <div class="account-view">
            <div id="instaaccount-form-view">
              <p class="title bold">Instagram account</p>
            <p class="subtitle medium">Select your Instagram account.</p>
            <div id="alert-message">
              
            </div>
               <input type="hidden" id="csrf_token"  name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="text" placeholder="Your Instagram name" name="account" required> 
              <input type="text" placeholder="Your Email" name="email" required> 
              <button id="select-account" type="submit" class="btn-pink mt15 select-account"> Select Account </button>
            </div>
            
         </div>
         <input type="hidden" value="<?php echo (isset($service->ids))?$service->ids:''; ?>" name="package"> 
              <input type="hidden" value="0" name="instagramaccountselection"> 
         </form>
         <div id="change-package-content-goes-here">
           <div class="package" data-product-id="222" data-min="<?php echo (isset($service->min))?$service->min:''; ?>" data-count="<?php echo (isset($service->quantity))?$service->quantity:''; ?>" data-package="<?php echo (isset($service->ids))?$service->ids:''; ?>" data-offeritems="<?php echo (isset($previous_package->quantity))?$previous_package->quantity:''; ?>">
            <p class="bold" style="font-weight: 1000;font-size: 25px;"> <span><?php echo (isset($service->quantity))?$service->quantity:''; ?> <?php echo (isset($service->order_for))?$orderFor[$service->order_for]['for']:''; ?></span> | <span><?php echo (isset($service->price))?number_format((float)$service->price, 2, '.', ''):''; ?> $</span></p>
            <a href="javascript:void(0);" class="btn-pink select-new-package">Change Package</a> <script></script> 
         </div>
         </div>
         <div class="package-select">
            <p>Select a suitable package.</p>
            <div class="select-inner">
               <select id="change-package-selectlist">
                  <?php foreach($selectList as $key=>$value): ?>
                  <option value="<?php echo $key; ?>"><?php echo str_replace("per month","$",$value); ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <p><a href="#" id="select-new-package" class="btn-pink change-new-package" data-product="autolikes">Select</a></p>

         </div>
         <div class="package-loader"></div>
         <div id="instagram-posts-goes-here">

        
      </div>
      
      </div>
      <div id="single-order-payment-div">

        
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
<script type="text/javascript">
  $('body').on('click','.select-new-package',function(){
    removePay();
    costOfAdd_summ = 0;
        costOfAdd_count = 1;
        reloadCart();
    $('.package-select').show();
    /*$('#single-order-payment-div').empty();
    $('#instagram-posts-goes-here').empty();
    $('.package').hide();
    $('.package-select').show();
    $('.summary').empty();*/
  });

  $('body').on('submit','#submitinstaaccount',function(e){
      var timezone_offset_minutes = new Date().getTimezoneOffset();
        timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
        $('input[name=timezone_offset]').val(timezone_offset_minutes);
        loader(true, '.package-loader');
        e.preventDefault(); 
        var $this = $(this); 
        $.ajax({ 
            url: $this.prop('action'),
            method: $this.prop('method'),
            dataType: 'json',  //3
            data: $this.serialize(), //4
        }).done( function (response) {    
            loader(false, '.package-loader');
            $('#alert-message').empty(); 
            if(response.status == 'error'){
               var msg = '<div class="alert alert-icon content alert-warning" role="alert"><i class="fe icon-symbol fe-alert-triangle" aria-hidden="true"></i><span class="message">'+response.message+'</span></div>';
               $('#alert-message').empty().html(msg);
            }
            if(response.status == 'success'){
               $('input[name=instagramaccountselection]').val(1);
               $('.account-view').empty().html(response.view);
               changePackage(response.package,1);
            }
        }).fail(function() {
          loader(false, '.package-loader');
            alert('i am failure');
         });
  });

  $('body').on('click','#select-new-package',function(){
         var package = $('#change-package-selectlist').val();
         $('#instagram-posts-goes-here').empty();
         var accountSelection = $('input[name=instagramaccountselection]').val();
         changePackage(package,accountSelection);
  });

  function changePackage(package,accountSelection) {
    loader(true, '#instagram-posts-goes-here');
    var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
    var socialuserid = '';
    if(accountSelection == 1){
        socialuserid = $('.main-account').data('id');
    }
        var $this = $(this); 
        $.ajax({ 
            url: '<?php echo cn('checkout/changepackage') ?>',
            method: 'post',
            dataType: 'json',  //3
            data: {token:csrfvalue,'package':package,'selectaccount':accountSelection,'socialuserid':socialuserid} //4
        }).done( function (response) {  
            loader(false, '#instagram-posts-goes-here');
            $('#alert-message').empty(); 
            if(response.status == 'error'){
               var msg = '<div class="alert alert-icon content alert-warning" role="alert"><i class="fe icon-symbol fe-alert-triangle" aria-hidden="true"></i><span class="message">'+response.message+'</span></div>';
               $('#alert-message').empty().html(msg);
            }
            if(response.status == 'success'){
               $('.checkout-section').data('product',response.packageFor);
               $('input[name=package]').val(response.package);
               $('.package-select').hide();
               $('#change-package-content-goes-here').empty().html(response.view1);
               if (typeof response.view2 !== 'undefined') {
                   $('#single-order-payment-div').empty().html(response.view2);
                }
               if (typeof response.view3 !== 'undefined') {
                   $('#instagram-posts-goes-here').empty().html(response.view3);
                } 
            }
        }).fail(function() {
          loader(false, '#instagram-posts-goes-here'); 
            alert('i am failure');
         });
  }
</script>
<script type="text/javascript">
  $('.checkout-section').on('click', '.load-more-media', function(e) {
        loader(true, '.load-upp-load');
        e.preventDefault();
        var maxId = $('.account-photo .media-cor').last().data('maxid');
        if (maxId) {
            var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
            var account_id = $('.account-change.main-account').data('id');
            var product = $('.checkout-section').data('product');
            //alert(product);
            var type = 'image';
            saveLogForm('get_account_photo_next_action');
            if (product == 'Views') type = 'video';
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo cn('checkout/postspagination'); ?>',
                data: {
                    'action': 'get_account_photo_next_action',
                    'maxId': maxId,
                    'account': account_id,
                    'type': type,
                    'token':csrfvalue
                },
                success: function(data) {
                    if (data) {
                        $('.account-change.account-photo .row').append(data);
                    }
                    loader(false, '.load-upp-load');
                },
            });
        } else {
            loader(false, '.load-upp-load');
        }
    });
</script>
<script type="text/javascript">
  function showPayBlock(account, product_id) {
    var type = $('.package').data('type');
    var product = $('.checkout-section').data('product');
    var id_product = $('.package').data('product-id');
    var package = $('.package').data('package');
    var email = $('.account-change.main-account').data('email');
    if (type === 'demo') {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'get_demo_action',
                'id_product': product_id,
                'email': email,
                'account': account,
            },
            success: function(data) {
                if (data) {
                    $('.checkout-section').append(data);
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $(".default-part.payment").offset().top
                    }, 1000);
                }
            }
        });
    } else {
        var media = '';
        var c_m = $('.media-item.active').length;
        var c = 0;
        if (c_m > 0) {
            $('.media-item.active').each(function() {
                media += $(this).data('url') + ';';
                c++;
                if (c >= c_m) {
                    sendPayDataNew(id_product, account, product, package, email, media);
                }
            });
        } else {
            sendPayDataNew(id_product, account, product, package, email, media);
        }
    }
}

function sendPayDataNew(id_product, account, product, package, email, media) {
    loader(true, '.section.template-content');
    var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
    var totalActivities = $('.count-likes-set-d')[0].innerText;
    //console.log(totalActivities);
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '<?php echo cn("checkout/get_payment_action"); ?>',
        data: {
            'id_product': id_product,
            'account': account,
            'product': product,
            'package': package,
            'email': email,
            'media': media,
            'costOfAdd_summ': costOfAdd_summ,
            'costOfAdd_count': costOfAdd_count,
            'token':csrfvalue,
            'totalActivities':totalActivities
        },
        success: function(data) {
            loader(false, '.section.template-content');
            if (data) {
                $('#single-order-payment-div').append(data);
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(".default-part.payment").offset().top
                }, 1000);
            }
        }
    });
}
</script>
