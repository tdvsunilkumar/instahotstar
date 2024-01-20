
<form id="payment-form"  method="post" action="<?=cn($module."/process")?>">
              <div class='form-row'>
              <div class='form-group col-sm-12'>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="hidden" name="price" value="<?php echo (isset($price))?$price:00; ?>">
                <input type="text" name="owner_name" placeholder="Name on Card" class="form-control" id="owner">
                        <input type="hidden" name="module" value="<?php echo (isset($module))?$module:''; ?>">
                        <input type="hidden" name="link" value="<?php echo (isset($link))?$link:''; ?>">
                        <input type="hidden" name="email" value="<?php echo (isset($email))?$email:''; ?>">
                        <input type="hidden" name="item_ids" value="<?php echo (isset($item_ids))?$item_ids:''; ?>">
                        <input type="hidden" name="payment_method" value="<?php echo (isset($payment_method))?$payment_method:''; ?>">
                        <span class="error" id="owner_name_error"></span>
              </div>
           </div>
            <div class='form-row'>
              <div class='form-group col-sm-12'>
                <input type="text" name="card_number" placeholder="Card Number" class="form-control" id="cardNumber">
                <span class="error" id="card_number_error"></span>
              </div>
            </div>
            <div class='form-row'>
              <div class='form-group col-sm-4'>
                <input type="text" name="cvv" placeholder="CVC" class="form-control" id="cvv">
                <span class="error" id="cvv_error"></span>
              </div>
              <div class='form-group col-sm-4'>
                <select name="expiry_month" id="expiry_month" class="form-control">
                            <option value="">Select Month</option>
                            <option value="01">January</option>
                            <option value="02">February </option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <span class="error" id="expiry_month_error"></span>
              </div>
              <div class='form-group col-sm-4'>
                <select name="expiry_year" id="expiry_year" class="form-control">
                    <option value="">Select Year</option>
                            <option value="2021"> 2021</option>
                            <option value="2022"> 2022</option>
                            <option value="2023"> 2023</option>
                            <option value="2024"> 2024</option>
                            <option value="2025"> 2025</option>
                            <option value="2026"> 2026</option>
                        </select>
                        <span class="error" id="expiry_year_error"></span>
              </div>
            </div>
            
            <div class='form-row'>
              <div class='col-md-12 form-group'>
                <button class='form-control btn btn-primary submit-button my-payment-button' id="confirm-purchase" type='submit' style="color:#fff">Pay <span class='amount'>$<?php echo number_format((float)$price, 2, '.', ''); ?></span></button>
              </div>
            </div>
            
          </form>
<script type="text/javascript">
  $(function() {

    var owner = $('#owner');
    var cardNumber = $('#cardNumber');
    var cardNumberField = $('#card-number-field');
    var CVV = $("#cvv");
    var mastercard = $("#mastercard");
    var confirmButton = $('#confirm-purchase');
    var visa = $("#visa");
    var amex = $("#amex");
    var expiryMonth = $('#expiry_month');
    var expiryYear = $('#expiry_year');

    // Use the payform library to format and validate
    // the payment fields.

    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');


    cardNumber.keyup(function() {

        amex.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            $('#card_number_error').empty();
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            $('input[name=card_type]').val('');
            $('input[name=card_type]').val('visa');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
            $('input[name=card_type]').val('');
            $('input[name=card_type]').val('amex');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            $('input[name=card_type]').val('');
            $('input[name=card_type]').val('mastercard');
        }
    });

    confirmButton.click(function(e) {
        e.preventDefault();

        var isCardValid = $.payform.validateCardNumber(cardNumber.val());
        var isCvvValid = $.payform.validateCardCVC(CVV.val());

        if(owner.val().length < 5){
            $('#owner_name_error').empty().html('invalid Name on Card');
        } else if (!isCardValid) {
            $('#card_number_error').empty().html('invalid card number');
        } else if (!isCvvValid) {
            $('#cvv_error').empty().html('invalid CVV');
        } else if(expiryMonth.val() == ''){
            $('#expiry_month_error').empty().html('invalid Expiry Month');
        }else if(expiryYear.val() == ''){
            $('#expiry_year_error').empty().html('invalid Expiry Year');
        }else {
            $('.error').empty();
            $('#payment-form').submit();
             
        }
    });
});
</script>          