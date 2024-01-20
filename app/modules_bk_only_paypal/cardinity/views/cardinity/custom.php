<html>
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title>Redirecting to Secure Payment Page</title>
      <script type="text/javascript">
        $('#my-payment-button').click();
      </script>
   </head>
   <body onload="document.forms['checkout'].submit()">
    <h4 class="text-center">Please wait while we are redirecting you to cardinity website for secure payment.</h4>
      <form name="checkout" method="POST" action="https://checkout.cardinity.com">
          <button id="my-payment-button" style="display:none;" type=submit>Click Here</button>
          <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
          <input type="hidden" name="cancel_url" value="<?php echo $cancel_url; ?>" />
          <input type="hidden" name="country" value="<?php echo $country; ?>"  />
          <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
          <input type="hidden" name="description" value="<?php echo $description; ?>" />
          <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
          <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
          <input type="hidden" name="return_url" value="<?php echo $return_url; ?>" />
          <input type="hidden" name="signature" value="<?php echo $signature; ?>"  />
      </form>
   </body>
</html>