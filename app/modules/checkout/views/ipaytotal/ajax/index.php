
<div class="title text-center">
                <h1 class="title-name"><strong>Checkout<strong></strong></h1> 
              </div>
<hr class="show-sm">
<div id="card_error_place"></div>
<form method="post" id="card_details_form" action="<?php echo cn('checkout/ipaytotal/process_payment'); ?>">
<input type="hidden" name="card_type" id="card_type" value="">
<div class="row">
    <div class="col-sm-12 cardZipGroup">
<div class="form-group">
    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                        <input type="text" name="card_no" value="" placeholder="Card No." class="form-control inputCreditCard" id="card" style="border-top-right-radius:4px;border-bottom-right-radius:4px;">
                                    </div>
                                    <span class="validation_error" id="error_card_no"></span>
                                    <div id="creditCardType" class="d-flex tx-28 tx-gray-500 mg-t-10">
                                        
                                        <div class="visa lh-1 mg-l-5"><i class="fab fa-cc-visa"></i></div>
                                        <div class="mastercard lh-1 mg-l-5"><i class="fab fa-cc-mastercard"></i></div>
                                        
                                        
                                        
                                    </div>
                                    <span class="validation_error" id="error_card_type"></span>

</div>
</div>
   <div class="col-sm-6 cardZipGroup">
<div class="form-group">
<select class="form-control" style="border-radius:4px;" name="ccExpiryMonth" id="ccExpiryMonth" data-select2-id="ccExpiryMonth" tabindex="-1">
                                                <option selected="" disabled="" data-select2-id="2"> -- Select Exp. Month -- </option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <span class="validation_error" id="error_ccExpiryMonth"></span>
</div>
</div>
<div class="col-sm-6 cardZipGroup">
<div class="form-group">
    <select class="form-control single-select" style="border-radius:4px;" name="ccExpiryYear" id="ccExpiryYear"  data-select2-id="ccExpiryYear" tabindex="-1" aria-hidden="true">
                                                <option selected="" disabled="" data-select2-id="4"> -- Select Exp. Year -- </option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                                <option value="2036">2036</option>
                                                <option value="2037">2037</option>
                                                <option value="2038">2038</option>
                                                <option value="2039">2039</option>
                                                <option value="2040">2040</option>
                                            </select>
                                            <span class="validation_error" id="error_ccExpiryYear"></span>

</div>
</div>
<div class="col-sm-12 cardZipGroup">
<div class="form-group">
    <div class="input-group">
<div class="input-group-prepend">
    <span class="input-group-text"><i class="fa fa-lock"></i></span>
    </div>
    <input class="form-control spinner" name="cvvNumber" type="text" id="cvvNumber" placeholder="CVV No." value="">
    </div>
    <span class="validation_error" id="error_cvvNumber"></span>
    
    <input class="form-control spinner" name="amount" type="hidden" id="amount" placeholder="Phone" value="<?php echo (isset($payableAmount))?number_format((float)$payableAmount, 2, '.', ''):''; ?>">
    <input class="form-control spinner" name="currency" type="hidden" id="currency" placeholder="Phone" value="USD">
    <input class="form-control spinner" name="response_url" type="hidden" id="response_url" placeholder="Phone" value="https://instahotstar.com/checkout/ipaytotal/complete">
    <input id="ip_address" name="ip_address" class="form-control no-icon secure" type="hidden" placeholder="Postal code" maxlength="16" value="<?php echo (isset($location['ipAddress']))?$location['ipAddress']:''; ?>" data-hj-suppress="">
    <input id="ip_address" name="user" class="form-control no-icon secure" type="hidden" placeholder="Postal code" maxlength="16" value="<?php echo (isset($user_id))?$user_id:''; ?>" data-hj-suppress="">
</div>
</div>
<div class="col-sm-12 cardZipGroup">
<div id="paypal-button-container">
        <p><a href="javascript:void(0);" id="pay_final_payment" class="btn-pink"><i class="fa fa-lock" style="font-size: 18px;margin-right: 5px;"></i> Pay $<?php echo (isset($payableAmount))?number_format((float)$payableAmount, 2, '.', ''):''; ?> USD</a></p>
    </div>
    </div>
    </form>
    <script>
        var cleave = new Cleave('.inputCreditCard', {
              creditCard: true,
              onCreditCardTypeChanged: function (type) {
                console.log(type)
                var card = $('#creditCardType').find('.'+type);
                 $("#card_type").val(type);
                if(card.length) {
                  card.addClass('tx-primary');
                  card.siblings().removeClass('tx-primary');
                } else {
                  $('#creditCardType span').removeClass('tx-primary');
                }
              }
            });
    </script>
    <script>
        $('#pay_final_payment').click(function(){
            var form = $('#card_details_form');
        $('#card_error_place').html('');
        loader(true, '#content-needs-to-change');
        event.preventDefault();
        $.ajax({ 
            url: form.attr("action"),
            method: 'post',
            dataType: 'json',  //3
            data: form.serialize() //4
        }).done( function (response) {  
            loader(false, '#content-needs-to-change');
            $('.validation_error').html('');
            $('#card_error_place').html('');
            if(response.status == 'error' && (typeof response.type === 'undefined')){
                $.each( response.errors, function( key, error) { 
                                $("#error_"+key+"").show().html('<strong>'+error+'</strong>');
                            });
            }
            if(response.status == 'error' && (typeof response.type !== 'undefined')){
                var msg = '<div class="alert alert-danger text-center">'+response.errors+'</div>';
              $('#card_error_place').html('');
              $('#card_error_place').html(msg);
            }
            if(response.status == '3d_redirect' && (typeof response.type === 'undefined')){
                window.location.href = response.url;
            }
            if(response.status == 'success'){
                console.log(response);
                var url = '<?php echo cn('checkout/ipaytotal/complete'); ?>?status='+response.data.status+'&message='+response.data.message+'&order_id='+response.data.order_id+'&sulte_apt_no='+response.data.sulte_apt_no;
                window.location.href = url;
            }
        }).fail(function() {
            loader(false, '#content-needs-to-change'); 
            alert('i am failure');
         });
    });
    </script>