<?php defined('BASEPATH') OR exit('No direct script access allowed');


class payopapi {
	
	public $public_key;
	
	public $secret_key;
	
	public $project_id;
	
	public function __construct() {
	    //echo PAYOP_PUBLIC_KEY;exit;
			
			$this->public_key = PAYOP_PUBLIC_KEY;
			$this->secret_key = PAYOP_SECRET_KEY;
			$this->project_id = PAYOP_PROJECT_ID;
	}

	/**
	 *
	 * Define Payment && Create payment.
	 *
	 */
	 public function createSignature($order = []){
			$order = $order;
			ksort($order, SORT_STRING);
			$dataSet = array_values($order);
			$dataSet[] = $this->secret_key;
			return hash('sha256', implode(':', $dataSet));
	}
	 
	function create_invoice($order_details = []){
	    $od = json_encode($order_details);
	    if(isset($order_details['offer_applied']) && $order_details['offer_applied'] == 1){
	        $extraAct = (isset($order_details['extraActivities']) && $order_details['extraActivities'] != "")?$order_details['extraActivities']:0;
	        $finalQuty = $order_details['itemQuantity']+$extraAct;
	    }else{
	        $finalQuty = $order_details['itemQuantity'];
	    }
	    if(!empty($order_details)){
	        $orderId = "PAYOP".strtotime(date("Y-m-d H:i:s"));
	        $invoiceParam = [
	            "publicKey"=>$this->public_key,
	            "order"    => [
	                "id"=>$orderId,
	                "amount"=>$order_details['payableAmount'],
	                "currency" => "USD",
	                "items"=>[
	                    [
	                        "id"=>$order_details['id'],
	                    "name"=>$finalQuty." ".$order_details['product'],
	                    "price"=>$order_details['payableAmount']
	                        ]
	                    
	                    ],
	               "description"=>"Purchase of ".$finalQuty." ".$order_details['product'],
	               
	                ],
	           "signature"=>$this->createSignature(["id"=>$orderId,"amount"=>$order_details['payableAmount'],"currency"=>"USD"])  ,
	           "payer"=>[
	               "email"=>$order_details['email'],
	               "phone"=>"",
	               "name"=>"",
	               "extraFields"=>$order_details
	               ],
	           //"paymentMethod"=>667,
	           "language"=>"en",
	           "resultUrl"=>cn("checkout/payop/complete?invoiceId={{invoiceId}}&txid={{txid}}"),
	           "failPath"=>cn("checkout/unsuccess"),
	           "metadata"=>$od
	            ];
	            //pr($invoiceParam);exit;
	            $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://payop.com/v1/invoices/create",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($invoiceParam),
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 1b95bd54-b1d7-d144-175a-63ae0cafa8e2"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  return [];
} else {
  return json_decode($response);
}
	            
	    }else{
	        return [];
	    }
	}
	
	function getTransactionDetails($txnId = ""){
	    if($txnId != ""){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://payop.com/v1/transactions/".$txnId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MzQzNDUsImFjY2Vzc1Rva2VuIjoiOGE0NjlkZjY1YTE4NWU2OGY3YmJjOWMyIiwidG9rZW5JZCI6MjExOSwid2FsbGV0SWQiOjI2NDk4LCJ0aW1lIjoxNjIzODIzOTMxLCJleHBpcmVkQXQiOjE3NzE5NTc4MDAsInJvbGVzIjpbMV0sInR3b0ZhY3RvciI6eyJwYXNzZWQiOmZhbHNlfX0.K6pFdm56Dyv7UKtRPF-srGS21DG4erHEsWBr2KTCyt4",
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: d847433e-fb4e-ec2b-4360-5447e2a77394"
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return json_decode($response);
}
	    }else{
	        return [];
	    }
	}
	
	
	function getInvoiceDetails($invoiceId = ""){
	    if($invoiceId != ""){
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://payop.com/v1/invoices/".$invoiceId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: d847433e-fb4e-ec2b-4360-5447e2a77394"
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return json_decode($response);
}
	    }else{
	        return [];
	    }
	}
	
	
	
	function  create_payment($data = "", $mode){
		/*----------  Set Sanbox mode or Live  ----------*/
		$this->apiContext->setConfig(
	        array(
	            'mode' => $mode,
	        )
	    );
		
		// Create new payer and method
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");

		// Set redirect URLs
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl($data->redirectUrls)
		  ->setCancelUrl($data->cancelUrl);

		// Set payment amount
		$amount = new Amount();
		$amount->setCurrency($data->currency)
		  ->setTotal($data->amount);

		// Set transaction object
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		  ->setDescription($data->description);

		// Create the full payment object
		$payment = new Payment();
		$payment->setIntent('sale')
		  ->setPayer($payer)
		  ->setRedirectUrls($redirectUrls)
		  ->setTransactions(array($transaction));
		// Create payment with valid API context
		try {
		  	$payment->create($this->apiContext);
		  	// Get PayPal redirect URL and redirect the customer
		  	$approvalUrl = $payment->getApprovalLink();
		  	set_session('paypal_payment_id', $payment->id);
		  	// Redirect the customer to $approvalUrl
		  	$result = array(
	        	'status'          => true,
	        	'message'         => 'success',
	        	'approvalUrl'     => $approvalUrl ,
	        );
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		  	$result = array(
	        	'status'      => false,
	        	'message'     => $ex->getMessage(),
    		);
		} 
		return (object)$result;
	}

	/**
	 *
	 * Execute payment 
	 * If the customer accepts the payment, you can execute the payment.
	 * To execute the payment, set the payment ID and payer ID parameters in the request:
	 *
	 */
	public function execute_payment($paymentId, $payerId, $mode){

		$this->apiContext->setConfig(
	        array(
	            'mode' => $mode,
	        )
	    );
		// Get payment object by passing paymentId
		$payment = Payment::get($paymentId, $this->apiContext);
		// Execute payment with payer ID
		$execution = new PaymentExecution();
		$execution->setPayerId($payerId);

		try {
		  // Execute payment
		  $result = $payment->execute($execution, $this->apiContext);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		  pr($ex->getMessage(), 1);
		  die($ex);
		}

		return $result;
	}
}