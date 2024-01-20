<?php //pr($orderDetails);exit; ?>
<form action = "https://unitpay.money/pay/370691-2b6e3">
  <input type = "text" name = "account" value = "demo">
  <input type = "text" name = "sum" value = "<?php echo $amount; ?>">
  <input type = "hidden" name = "desc" value = "Payment description">
  <input type = "hidden" name = "currency" value = "RUB">
  <input type = "hidden" name = "signature" value = "<?php echo $sig; ?>">
  
  <input class = "btn" type = "submit"value = "Pay">
</form>