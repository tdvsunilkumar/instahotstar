<html>
   <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title>Request Example | Hosted Payment Page</title>
      <script type="text/javascript">
        $('#my-payment-button').click();
      </script>
   </head>
   <body onload="document.forms['checkout'].submit()">
       <p>Please wait while we are redirecting you to Cardinity Secure form.</p>
      <form name="checkout" method="POST" action="https://checkout.cardinity.com">
          <button style="display:none;" id="my-payment-button" type=submit>Click Here</button>
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