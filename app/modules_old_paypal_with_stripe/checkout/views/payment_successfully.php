<?php 
$mergedOrderId = session('final_order_id');
$finalPaidAmount = session('total_paid_amount');
unset_session('final_order_id');
unset_session('total_paid_amount');
$trsId = (isset($transaction->transaction_id))?$transaction->transaction_id:'';
$affiliation = 'instaHotStar.com';
$revenue = (isset($transaction->amount))?$transaction->amount:0.00;
$transactionFee = (isset($transaction->transaction_fee))?$transaction->transaction_fee:0.00;
$orderFor = ORDER_FOR;
$productOrderFor = (isset($product->order_for))?$product->order_for:0;
$category = $orderFor[$productOrderFor]['for'];
$productName = (isset($product->name) && isset($product->quantity))?$product->quantity.' '.$product->name:'';
$productId = (isset($product->id))?$product->id:0;
$productIds = (isset($product->ids))?$product->ids:0;
//echo $trsId;exit;
?>
<script>
ga('require', 'ecommerce');
ga('ecommerce:addTransaction', {
  'id': '<?php echo $trsId; ?>',
  'affiliation': '<?php echo $affiliation; ?>',
  'revenue': '<?php echo $revenue; ?>',
  'shipping': '0.00',
  'tax': '0.00'
});

ga('ecommerce:addItem', {
  'id': '<?php echo $productId; ?>',
  'name': '<?php echo $productName; ?>',
  'sku': '<?php echo $productIds; ?>',
  'category': '<?php echo $category; ?>',
  'price': '<?php echo $revenue; ?>',
  'quantity': '1'
});
ga('ecommerce:send');
</script>
<section class="checkout-result">   
  <div class="container-fluid">
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="checkout-header text-center">
              <div class="title">
                <strong><i class="fa fa-check-circle"></i> <?php echo lang("thank_you"); ?></strong>
              </div>
              <span class="text-muted"><?php echo lang("your_order_has_been_placed_successfully"); ?></span>
            </div>
          	<div class="detail">
	            <p><?php echo lang("your_order_has_been_processed_here_are_the_details_of_this_transaction_for_your_reference"); ?></p>
	            <ul class="text-left fs-12 p-l-40">
                <li><?php echo lang("order__is"); ?> <strong><?php echo (!empty($mergedOrderId)) ? strip_tags($mergedOrderId) : ''?></strong></li>
	            	<li><?php echo lang("Transaction_ID"); ?>: <strong><?php echo (!empty($transaction) && $transaction->transaction_id == 'empty') ? lang($transaction->transaction_id)." ".lang("transaction_id_was_sent_to_your_email") : strip_tags($transaction->transaction_id); ?></strong></li>
	            	<li>Per Order Amount: <strong><?php echo (!empty($transaction)) ? strip_tags($transaction->amount) : ''?> <?php echo get_option("currency_code", "USD"); ?></strong> </li>
                <li>Total Paid Amount (includes fee): <strong><?php echo (!empty($finalPaidAmount)) ? strip_tags($finalPaidAmount) : ''?> <?php echo get_option("currency_code", "USD"); ?></strong> </li>
                
                <li>Item: <strong><?php echo (!empty($order_detail)) ? strip_tags($order_detail) : ''?></strong> </li>
                
	            </ul>
              <p><?php echo lang("we_appreciate_you_most_recent_purchase_and_hope_you_enjoyed_your_purchase_an_email_receipt_including_the_details_about_your_order_has_been_sent_to_your_email_address"); ?></p> 
              <div class="text-center">
                <a href="<?php echo cn(); ?>" class="btn btn-pill btn-submit btn-gradient btn-min-width mr-1 mb-1">
                  <?php echo lang("continute"); ?>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

