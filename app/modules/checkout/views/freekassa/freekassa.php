
<?php 
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
    'payableAmount'=>(isset($payableAmount))?$payableAmount:'',
    'extraActivities'=>(isset($extraActivities))?$extraActivities:'',
    'orderNo'     => 'ODRS'.strtotime(NOW),
    'visitorId'   =>  (isset($visitorId))?$visitorId:'',
    'location'    => $location
      );
      //pr($orderInfo);exit;
      $jsonData = json_encode($orderInfo);
     $token    = encrypt_encode($jsonData);
     //echo $token;exit;
     if($payment_method == 'stripe'){
        $urlToCall = cn('checkout/API/PaymentPage').'?payment_token='.urlencode($token);
     }else{
        $urlToCall = 'https://offlineseostore.com/checkout/'.$payment_method.'/process_payment?payment_token='.urlencode($token);
     }
     
     /*$jsonData = json_encode($orderInfo);
     $urlToCall = 'http://offlineseostore.com/checkout/stripe/process_payment?module='.$orderInfo['module'].'&link='.$orderInfo['link'].'&email='.$orderInfo['email'].'&item_ids='.$orderInfo['item_ids'].'&price='.$orderInfo['price'].'&payment_method='.$orderInfo['payment_method'].'&payment_method='.$orderInfo['payment_method'].'&call_from='.$orderInfo['call_from'].'&cart_id='.$orderInfo['cart_id'].'&product='.$orderInfo['product'].'&coupan='.$orderInfo['coupan'].'&iscoupanApplied='.$orderInfo['iscoupanApplied'].'&offer_price='.$orderInfo['offer_price'].'&offer_applied='.$orderInfo['offer_applied'].'&payableAmount='.$orderInfo['payableAmount'].'&extraActivities='.$orderInfo['extraActivities'];*/
 ?>
 <center><h4>If you are not redirect to payment page click on below button.</h4>
<button onclick="redirect();" id="payment-page-redirection">Redirect to payment page</button></center>
<script type="text/javascript">
  var URL = "https://href.li/<?php echo $urlToCall; ?>";
  open(URL, '_self').close();
      document.getElementById('payment-page-redirection').click(function(){
          open(URL, '_self').close();
      });
    window.close();
    
</script>
