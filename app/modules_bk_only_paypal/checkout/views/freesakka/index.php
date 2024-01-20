<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#pay_button').click();
	});
</script>
<form method = 'get' action = 'https://www.free-kassa.ru/merchant/cash.php'>
                        <input type = 'hidden' name = 'm' value = '<?php echo $merchant_id; ?>'>
    <input type = 'hidden' name = 'oa' value = '<?php echo $amount; ?>'>
    <input type = 'hidden' name = 'o'  value = '<?php echo $order_id; ?>'>
    <input type = 'hidden' name = 's'  value = '<?php echo $sig; ?>'>
    <!--<input type = 'hidden' name = 'i' value = '160'>-->
    <input type = 'hidden' name = 'lang' value = 'en'>
    <input type = 'submit' id="pay_button" name = 'pay' value = 'Pay'>
                        </form>