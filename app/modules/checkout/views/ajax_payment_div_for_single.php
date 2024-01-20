<style type="text/css">
    #summary-upgrade {
    padding: 25px 30px;
    background: #ff7b7b;
    border-radius: 8px;
    color: #fff;
    margin-bottom: 20px;
    margin-top: 5px;
    position: relative;
}#upgrade-hide {
    width: 25px;
    height: 25px;
    top: 20px;
    right: 20px;
    position: absolute;
    cursor: pointer;
    opacity: .4;
    -webkit-transition: all .3s linear;
    transition: all .3s linear;
}#upgrade-header {
    font-weight: 900;
    display: block;
    width: 85%;
    font-size: 20px;
    padding-bottom: 5px;
    font-family: Lato,Helvetica,Sans-serif;
    line-height: 130%;
}#upgrade-button {
    border-radius: 26px;
    background: #fff;
    padding: 10px 25px;
    min-width: 230px;
    display: inline-block;
    color: #000 !important;
    font-family: 'GraphikBold';
    border: 2px solid transparent;
    text-align: center;
    position: relative;
    top: 0;
}#checkout-payment-applied-upgrade {
    padding: 25px 30px;
    background: #fff;
    border-radius: 8px;
    color: #19224c;
    margin-bottom: 20px;
    margin-top: 5px;
    position: relative;
    padding-bottom: 5px;
    border: 2px solid #c5c5c5;
}#checkout-payment-applied-upgrade p {
    width: calc(100% - 150px);
    padding-right: 10px;
    font-size: 18px;
    font-family: Lato,Helvetica,Sans-serif;
    font-weight: 400;
    /* line-height: 160%; */
    display: inline-block;
    vertical-align: middle;
    /* padding-top: 5px; */
}#checkout-payment-downgrade-button {
    height: 34px;
    min-width: 140px;
    text-align: center;
    font-size: 16px;
    line-height: 32px;
    color: #000 !important;
    padding: 0 10px;
    display: inline-block;
    background: #fff;
    vertical-align: middle;
    border-radius: 26px;
    position: relative;
    top: -10px;
    font-weight: 600;
    border: 2px solid #c5c5c5;
}
#apply-coupan-board {
    background: #fff;
    border-radius: 8px;
    color: #19224c;
    position: relative;
}#apply-coupan-board p {
    width: calc(100% - 150px);
    padding-right: 10px;
    font-size: 18px;
    font-family: Lato,Helvetica,Sans-serif;
    font-weight: 400;
    /* line-height: 160%; */
    display: inline-block;
    vertical-align: middle;
    /* padding-top: 5px; */
}
</style>
<?php

  $actualPrice = (isset($package->price))?number_format((float)$package->price, 2, '.', ''):0.00;
  $discount =   0;
  $discountedPrice = $actualPrice-$discount;
  $discountedPrice = number_format((float)$discountedPrice, 2, '.', '');
  $coupanDiscount = 0;
  $offerExtra     = 0;
  
  $previousPackagePrice     = (isset($previous_package->price))?$previous_package->price:0;
  $discountValue            = (int)(isset($category->offer_discount))?$category->offer_discount:0;
  //echo $discountValue;exit;
  $offerExtraPriceToDisplay =   $previousPackagePrice-($previousPackagePrice*$discountValue/100);
  $offerExtraPriceToDisplay =   number_format((float)$offerExtraPriceToDisplay, 2, '.', '');

if(isset($cupan_apllied) && $cupan_apllied == 1){
  $coupanDiscount =   $discountedPrice*$package->coupan_disc/100;
  $coupanDiscount =   number_format((float)$coupanDiscount, 2, '.', '');
}
if(isset($offer_apllied) && $offer_apllied == 1){

  $offerExtra =   $previousPackagePrice-($previousPackagePrice*$discountValue/100);
  $offerExtra =   number_format((float)$offerExtra, 2, '.', '');
}

$discountedPrice = $discountedPrice+$offerExtra-$coupanDiscount;
$discountedPrice = number_format((float)$discountedPrice, 2, '.', '');
 ?>
<div class="default-part payment-div"  style="margin-top: 20px;" data-coupancode="<?php echo (isset($package->coupan) && isset($cupan_apllied) && $cupan_apllied == 1)?$package->coupan:'no'; ?>" data-discount="<?php echo (isset($package->coupan_disc) && isset($cupan_apllied) && $cupan_apllied == 1)?$package->coupan_disc:'0.00'; ?>" data-applied="<?php echo (isset($cupan_apllied) && $cupan_apllied == 1)?1:0; ?>" data-offerapplied="<?php echo (isset($offer_apllied) && $offer_apllied == 1)?1:0; ?>">
    <p class="title bold mb0">Payment</p>
    <?php if(isset($previous_package) && !empty($previous_package)): ?>
    <?php if(isset($offer_apllied) && $offer_apllied == 1): ?>
        <div id="checkout-payment-applied-upgrade" style="">
            <p>Applying <?php echo (isset($previous_package->quantity))?$previous_package->quantity:0; ?> extra <?php echo (isset($previous_package->order_for))?$orderFor[$previous_package->order_for]['for']:''; ?> for a total of $<?php echo (isset($offerExtra))?$offerExtra:0.00; ?>!</p>
            <div id="checkout-payment-downgrade-button" class="button white remove-offer-code"><a href="javascript:void(0);">Remove</a></div>
        </div>
    
    <?php else: ?>
    <div id="summary-upgrade" style="" data-summ="1.8" data-count="1.25" data-t="0">
        <img id="upgrade-hide" src="https://instagrowing.net/wp-content/themes/instagrowing/inc-checkout/assets/icon-cross.svg">
        <div id="upgrade-header" >Limited offer:</div>
        <p id="upgrade-body">Add <?php echo (isset($previous_package->quantity))?$previous_package->quantity:0; ?> additional <?php echo (isset($previous_package->order_for))?$orderFor[$previous_package->order_for]['for']:''; ?> to your cart for only $<?php echo (isset($offerExtraPriceToDisplay))?$offerExtraPriceToDisplay:0.00; ?> extra and save <?php echo $discountValue; ?>%!</p>
        <div id="upgrade-button" class="button white"><a href="javascript:void(0);">Add to cart</a></div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    
            <!--<p class="subtitle medium">Payments will be processed securily through PayPal.</p>-->
            <p class="price mauto bold">$<?php echo $discountedPrice; ?></p>

        <div id="alert-message-for-coupan">
              
            </div>
        <?php if(isset($cupan_apllied) && $cupan_apllied == 1): ?>
          <div id="checkout-payment-applied-upgrade" style="">
            <p>Coupon <?php echo (isset($package->coupan))?$package->coupan:''; ?> with <?php echo (isset($package->coupan_disc))?$package->coupan_disc:'0.00'; ?>% discount has been applied successfully!</p>
            <div id="checkout-payment-downgrade-button"  class="button white remove-coupan-code"><a href="javascript:void(0);">Remove</a></div>


        </div>
            <?php else: ?>
          <div id="apply-coupan-board" style="">
            <p><input type="text" name="coupan" placeholder="Apply Coupon Here" class="form-control"></p>
            <div id="checkout-payment-downgrade-button" style="top:0px;" class="button white apply-coupan-form"><a href="javascript:void(0);">Apply</a></div>
        </div>
        
<?php endif; ?>
<span><!--<select class="form-control" id="selectedPaymentMethod" >
    
    <option value="stripe">Debit/Credit Card</option>
    <option value="interkassa">Interkassa (Mastercard, Bitoin and Wallet)</option>
    <!--<option value="freekassa">Freekassa</option>-->
            
            </select>
            </span>
            <style>
                .paymentMethodsList {
    display: table;
    margin: auto;
    list-style: none;
}
                .paymentMethodsList li{
                    padding:10px;
                }
            </style>
            
            <div id="checkout-payment-applied-upgrade">
                <ul class="paymentMethodsList">
                    <?php if($discountedPrice > 2): ?>
                    <!--<li><span><input type="radio" checked="checked" value="paddle" name="selectedPaymentMethod">&nbsp;&nbsp;<strong>Debit/Credit card and PayPal</strong></span></li>-->
                    <?php endif; ?>
                    
		<!--<li><div class="column twelvecol" style="margin-top: 5px;margin-bottom: 5px;">
 <input type="radio" id="paypal_btn"  checked="checked" name="selectedPaymentMethod" value="paypal"  style="display: inline !important;width: initial !important;"> 
                                  <label for="paypal_btn" style="font-weight: bold;display: inline-block; margin-bottom: 5px;color: #000;">&nbsp;&nbsp;PayPal (USD)
                                      <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" style="
                                            max-width: 130px;
                                            margin-bottom: 3px;
                                            display: inline-block;">
                                         
                                    </label>
                                  </div></li>-->
                                  <li><div class="column twelvecol" style="margin-top: 5px;margin-bottom: 5px;">
 <input type="radio" id="paypal_btn" checked="checked" name="selectedPaymentMethod" value="paddle"  style="display: inline !important;width: initial !important;"> 
                                  <label for="paypal_btn" style="font-weight: bold;display: inline-block; margin-bottom: 5px;color: #000;">&nbsp;&nbsp;PayPal and Debit/Credit Card
                                      <img src="https://instahotstar.com/assets/images/test_01.png" style="
                                            max-width: 130px;
                                            margin-bottom: 3px;
                                            display: inline-block;">
                                         
                                    </label>
                                  </div></li>
                                  
                                  
                    <!--<li><span><input type="radio" value="unitpay" name="selectedPaymentMethod">&nbsp;&nbsp;<strong>UnitPay (RUB)</strong></span></li>-->
                    <?php if($discountedPrice <= 20.00): ?>
                    <!--<li><div class="column twelvecol" style="margin-top: 5px;margin-bottom: 5px;">
 <input type="radio" id="paypal_btn"  name="selectedPaymentMethod" value="freekassa"  style="display: inline !important;width: initial !important;"> 
                                  <label for="paypal_btn" style="font-weight: bold;display: inline-block; margin-bottom: 5px;color: #000;">&nbsp;&nbsp;PayPal(RUB)
                                      <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" style="
                                            max-width: 130px;
                                            margin-bottom: 3px;
                                            display: inline-block;">
                                         
                                    </label>
                                  </div></li>-->
                                  <?php endif; ?>
                                  <li><div class="column twelvecol" style="margin-top: 5px;margin-bottom: 5px;">
 <input type="radio" id="paypal_btn" name="selectedPaymentMethod" value="payop"  style="display: inline !important;width: initial !important;"> 
                                  <label for="paypal_btn" style="font-weight: bold;display: inline-block; margin-bottom: 5px;color: #000;">&nbsp;&nbsp;Cards, e-Wallet, Net Banking, Bank Transfer
                                      <!--<img src="https://instahotstar.com/assets/images/test_01.png" style="
                                            max-width: 130px;
                                            margin-bottom: 3px;
                                            display: inline-block;">-->
                                         
                                    </label>
                                  </div></li>
                    <?php if($discountedPrice > 5.50): ?>
                    <li><span><input type="radio" value="coinbase" name="selectedPaymentMethod">&nbsp;&nbsp;<strong>Coinbase (Bitcoin)</strong></span></li>
                    <?php endif; ?>
                    
                    <!--<li><span><input type="radio" value="interkassa" name="selectedPaymentMethod">&nbsp;&nbsp;<strong>Interkassa (Mastercard, Bitoin and Wallet)</strong></span></li>-->
                    
                    <!--<li><span><input type="radio" value="freekassa" name="selectedPaymentMethod">&nbsp;&nbsp;<strong>Freekassa (Mastercard, Visa and PayPal)</strong></span></li>-->
                    
                    </ul>
            </div>
        <p class="note">
            <!--<span><i><b>PayPal accept RUB currency</b></i></span><br/>-->
            <!--<span style="color:green;"><b>Use code GET10OFF coupan for 10% instant discount</b></span><br />-->
        <span class="bold">Note:</span>
        During payment with PayPal you will get a security check, please complete this security check to redirect on PayPal page.
    </p>
        <img style="margin:auto;display:block;" src="https://instahotstar.com/assets/images/test_01.png" />
        <p class="note">
        <img style="margin:auto;display:block;" src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" />
    </p>
    <div id="alert-message"></div>
        <div id="paypal-button-container">
        <p><a href="javascript:void(0);" id="pay" class="btn-pink"><i class="fas fa-lock" style="font-size: 18px;margin-right: 5px;"></i> Pay</a></p>
    </div>

    <p class="note">
        <span class="bold">Note:</span>
        <!--You don't have to create a PayPal account to pay and PayPal accepts credit and debit cards. <br /><br />-->
    By clicking to Pay button, you're agreeing to our T&amp;C and <a href="<?php echo cn('terms'); ?>" target="_blank">Privacy Policy</a>.
    </p>
</div>
<form id="finalpayment" action="<?php echo cn("checkout/process"); ?>" method="post">
    <input type="hidden" id="csrf_token"  name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
    <input type="hidden" name="link">
    <input type="hidden" name="email">
    <input type="hidden" name="payment_method" value="paypal">
    <input type="hidden" name="item_ids">
    <input type="hidden" name="agree" value="1">
    <input type="hidden" name="cart_id" value="<?php echo (isset($cart_id))?$cart_id:0; ?>">
    <input type="hidden" name="product" value="">
    <input type="hidden" name="coupan" value="">
    <input type="hidden" name="coupan_applied" value="">
    <input type="hidden" name="offer_price" value="">
    <input type="hidden" name="offer_applied" value="">
    <input type="hidden" name="payableAmount" value="">
    <input type="hidden" name="extraActivities" value="">
    <input type="hidden" name="visitorId" >
</form>
<script type="text/javascript">
    $('#pay').click(function(){
        loader(true, '#single-order-payment-div');
        var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
        var link = $('.main-account').data('account');
        var email = $('.main-account').data('email');
        var item_ids = $('#change-package-content-goes-here .package').data('package');
        var product = $('.checkout-section').data('product');
        var coupan  = $('.payment-div').data('coupancode');
        var isCoupanApplied  = $('.payment-div').data('applied');
        var isOfferApplied  = $('.payment-div').data('offerapplied');
        var offerPrice  = '<?php echo $offerExtraPriceToDisplay; ?>';
        var paidAmount  = '<?php echo $discountedPrice; ?>';
        var extraActivities  = $('#change-package-content-goes-here .package').data('offeritems');
        //var paymentMethod = $('#selectedPaymentMethod').val();
        var paymentMethod = $('input[name=selectedPaymentMethod]:checked').val();
        //alert(paymentMethod);
        $('input[name=visitorId]').val(newVisitorId);
        $('input[name=link]').val(link);
        $('input[name=email]').val(email);
        $('input[name=item_ids]').val(item_ids);
        $('input[name=product]').val(product);
        $('input[name=coupan]').val(coupan);
        $('input[name=coupan_applied]').val(isCoupanApplied);
        $('input[name=offer_price]').val(offerPrice);
        $('input[name=offer_applied]').val(isOfferApplied);
        $('input[name=payableAmount]').val(paidAmount);
        $('input[name=extraActivities]').val(extraActivities);
        $('input[name=payment_method]').val(paymentMethod);
        
        /* check validation.*/
        event.preventDefault();
            var _that       = $('#finalpayment'),
                _action     = PATH + '/checkout/process_validation',
                _data       = _that.serialize();
                _data       = _data + '&' + $.param({token:token});
            $.post(_action, _data, function(_result){
                if (is_json(_result)) {
                    _result = JSON.parse(_result);
                    
                        if (_result.status == 'error') {
                            loader(false, '#single-order-payment-div');
                            alert(_result.message);
                        }  
                        if (_result.status == 'success') {
                                   loader(false, '#single-order-payment-div');
                            
                                   swal("Dear customer, please don't raise any dispute. If you have any query or problem regarding your order then please contact us by leaving a message on our chat system or by email at support@instahotstar.com. Definitely, we will help you. Have a great day.")
.then((value) => {
        if( link != '' && email != '' && item_ids != ''){
            var $this = $('#finalpayment'); 
            
            if(product == 'Views' || product == 'Likes'){
                $this.submit();
                //alert('Website is under maintainance');
            }else{
                $this.submit();
            }
        }
});


                        }
                    
                }else{
                    /* Display modal and show checkout form*/
                    /*$(".actionCheckoutForm .btn-submit").removeClass('btn-loading');
                      $('#cardinity-payment-modal').modal('show');
                      $("#cardinity-payment-modal-content").html(_result);*/
                    /* Display modal and show checkout form*/
                    $(".checkout-left .form-content").html(_result);
                }
            })
            return false;
        /* check validation.*/
 
        
        
    });

    $('#upgrade-button').click(function(){
        //e.preventDefault();
        costOfAdd_summ = $('#summary-upgrade').data('summ');
        costOfAdd_count = $('#summary-upgrade').data('count');
        reloadCart();
        if ($('#summary-upgrade').data('t') == "1") {
            if ($('.default-part.payment').length > 0) {
                $('.default-part.payment').remove();
            }
            doneAllCart();
        } else {
            if ($('.default-part.payment').length > 0) {
                $('.default-part.payment').remove();
                doneAllCart();
            }
        }
         loader(true, '#instagram-posts-goes-here');
         var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
         var package = $('.package').data('package');
         var cart    = '<?php echo (isset($cart_id))?$cart_id:0; ?>';
         var isCoupanApplied  = $('.payment-div').data('applied');
         var isOfferApplied  = 1;
         var coupan  = $('.payment-div').data('coupancode');
         $.ajax({ 
            url: '<?php echo cn('checkout/applyCoupan') ?>',
            method: 'post',
            dataType: 'json',  //3
            data: {
            token:csrfvalue,
            'package':package,
            'cart':cart,
            'coupan':coupan,
            'isCoupanApplied':isCoupanApplied,
            'isOfferApplied':isOfferApplied
            } //4
        }).done( function (response) {  
            loader(false, '#instagram-posts-goes-here');
            if(response.status == 'error'){
                var msg = '<div class="alert alert-icon content alert-warning" role="alert"><i class="fe icon-symbol fe-alert-triangle" aria-hidden="true"></i><span class="message">'+response.message+'</span></div>';
               $('#alert-message-for-coupan').empty().html(msg);
            }
            if(response.status == 'success'){
               $('#single-order-payment-div').empty().html(response.view);
            }
        }).fail(function() {
          loader(false, '#instagram-posts-goes-here'); 
            alert('i am failure');
         });

    });

    $('.apply-coupan-form').click(function(){
        loader(true, '#instagram-posts-goes-here');
    var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
    var package = $('.package').data('package');
    var cart    = '<?php echo (isset($cart_id))?$cart_id:0; ?>';
    var coupan  = $('input[name=coupan]').val();
    var isCoupanApplied  = 1;
    var isOfferApplied  = $('.payment-div').data('offerapplied');;
        var $this = $(this); 
        $.ajax({ 
            url: '<?php echo cn('checkout/applyCoupan') ?>',
            method: 'post',
            dataType: 'json',  //3
            data: {
            token:csrfvalue,
            'package':package,
            'cart':cart,
            'coupan':coupan,
            'isCoupanApplied':isCoupanApplied,
            'isOfferApplied':isOfferApplied
            } //4
        }).done( function (response) {  
            loader(false, '#instagram-posts-goes-here');
            if(response.status == 'error'){
                var msg = '<div class="alert alert-icon content alert-warning" role="alert"><i class="fe icon-symbol fe-alert-triangle" aria-hidden="true"></i><span class="message">'+response.message+'</span></div>';
               $('#alert-message-for-coupan').empty().html(msg);
            }
            if(response.status == 'success'){
               $('#single-order-payment-div').empty().html(response.view);
            }
        }).fail(function() {
          loader(false, '#instagram-posts-goes-here'); 
            alert('i am failure');
         });
    });


    $('.remove-coupan-code').click(function(){
        loader(true, '#instagram-posts-goes-here');
    var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
    var package = $('.package').data('package');
    var cart    = '<?php echo (isset($cart_id))?$cart_id:0; ?>';
    var isOfferApplied   = $('.payment-div').data('offerapplied');
    var isCoupanApplied  = 0;
        var $this = $(this); 
        $.ajax({ 
            url: '<?php echo cn('checkout/removeCoupan') ?>',
            method: 'post',
            dataType: 'json',  //3
            data: {
            token:csrfvalue,
            'package':package,
            'cart':cart,
            'isCoupanApplied':isCoupanApplied,
            'isOfferApplied':isOfferApplied
            } //4
        }).done( function (response) {  
            loader(false, '#instagram-posts-goes-here');
            $('#single-order-payment-div').empty().html(response.view);
        }).fail(function() {
          loader(false, '#instagram-posts-goes-here'); 
            alert('i am failure');
         });
    });


    $('.remove-offer-code').click(function(){
        costOfAdd_summ = 0;
        costOfAdd_count = 1;
        reloadCart();
        loader(true, '#instagram-posts-goes-here');
    var csrfvalue = '<?php echo $this->security->get_csrf_hash(); ?>';
    var package = $('.package').data('package');
    var cart    = '<?php echo (isset($cart_id))?$cart_id:0; ?>';
    var isOfferApplied   = 0;
    var isCoupanApplied  = $('.payment-div').data('applied');;
        var $this = $(this); 
        $.ajax({ 
            url: '<?php echo cn('checkout/removeCoupan') ?>',
            method: 'post',
            dataType: 'json',  //3
            data: {
            token:csrfvalue,
            'package':package,
            'cart':cart,
            'isCoupanApplied':isCoupanApplied,
            'isOfferApplied':isOfferApplied
            } //4
        }).done( function (response) {  
            loader(false, '#instagram-posts-goes-here');
            $('#single-order-payment-div').empty().html(response.view);
        }).fail(function() {
          loader(false, '#instagram-posts-goes-here'); 
            alert('i am failure');
         });
    });
</script>