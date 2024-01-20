<?php
//pr($freeKasa);exit;
if($call_from == 'instahotstar' && isset($offer_applied) && $offer_applied == 1 && isset($offer_price) && $offer_price != ''){
    $finalPaidAmount = $price;
}else{
    $finalPaidAmount  = $price;
}
$orderInfo = array(
    'module' => (isset($module))?$module:'',
    'link'   =>(isset($link))?$link:'',
    'email'  =>(isset($email))?$email:'',
    'item_ids'=>(isset($item_ids))?$item_ids:'',
    'price'=>(isset($price))?$price:'',
    'payment_method'=>(isset($payment_method))?$payment_method:'',
    'call_from'=>(isset($call_from))?$call_from:'',
    'cart_id'=>(isset($cart_id))?$cart_id:'',
    'product'=>(isset($product))?$product:'',
    'coupan'=>(isset($coupan))?$coupan:'',
    'iscoupanApplied'=>(isset($iscoupanApplied))?$iscoupanApplied:'',
    'offer_price'=>(isset($offer_price))?$offer_price:'',
    'offer_applied'=>(isset($offer_applied))?$offer_applied:'',
    'payableAmount'=>$finalPaidAmount,
    'extraActivities'=>(isset($extraActivities))?$extraActivities:'',
    'orderNo'     => 'ODRS'.strtotime(NOW)
      );
      //pr($orderInfo);exit;
      $jsonData = json_encode($orderInfo);
     $token    = encrypt_encode($jsonData);
     $token = urlencode($token);
     //echo $call_from;exit;
     if($call_from == 'instahotstar'){
        $url = $freeKasa->redirectUrls;
     }else{
     	$url = $freeKasa->redirectUrls;
     }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#pay_button').click();
	});
</script>
<form method = 'get' action = 'https://www.free-kassa.ru/merchant/cash.php'>
                        <input type = 'hidden' name = 'm' value = '<?php echo $freeKasa->merchant_id; ?>'>
    <input type = 'hidden' name = 'oa' value = '<?php echo $freeKasa->amount; ?>'>
    <input type = 'hidden' name = 'o'  value = '<?php echo $freeKasa->order_id; ?>'>
    <input type = 'hidden' name = 's'  value = '<?php echo $freeKasa->sig; ?>'>
    <!--<input type = 'hidden' name = 'i' value = '160'>-->
    <input type = 'hidden' name = 'lang' value = 'en'>
    <input type = 'hidden' name = 'us_paymentinfo' value = '<?php echo $token; ?>'>
    <input type = 'submit' id="pay_button" name = 'pay' value = 'Pay'>
                        </form>

<center><h4>Please wait while we are redirecting you to checkout page.</h4></center>