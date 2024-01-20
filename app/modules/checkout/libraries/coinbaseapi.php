<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'coinbase/autoload.php';

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;
use CoinbaseCommerce\Webhook;
use CoinbaseCommerce\Resources\Charge;
/**
 * Paypal PHP SDK
 */
class coinbaseapi {
	private $apiContext;
	
	public function __construct($apiKey = null, $apiSecret = null, $mode = "") {
		
			
		
	}

	/**
	 *
	 * Define Payment && Create payment.
	 *
	 */
	 
	function coinbaseWebhook($headers = []){
	    //pr($_GET);exit;
            $secret = 'c8cee4c0-cf6b-4ede-8121-dcdbb45228ae';
            $headerName = 'X-Cc-Webhook-Signature';
            $signraturHeader = isset($headers[$headerName]) ? $headers[$headerName] : null;
            $payload = trim(file_get_contents('php://input'));
            try {
            $event = Webhook::buildEvent($payload, $signraturHeader, $secret);
            http_response_code(200);
            return ['status'=>200,'event'=>$event];
            } catch (\Exception $exception) {
            http_response_code(400);
             return ['status'=>400,'event'=>[]];
            }
	} 
	
	
	function  create_payment($data = "", $desc="tets", $name="test"){
	    //pr($data);exit;
            ApiClient::init("33461a5a-c53d-4823-8b2b-16d50cac4292");
            $tokenJson = json_encode($data);
           $infoToken = encrypt_encode($tokenJson);
            $chargeData = [
    'name' => $name,
    'description' => $desc,
    'local_price' => [
        'amount' => $data['payableAmount'],
        'currency' => 'USD'
    ],
    'pricing_type' => 'fixed_price',
    'metadata' => ['email'=>$data['email'],'orderInfoToken'=>$infoToken],
    'redirect_url' =>cn('checkout/coinbase/complete'),
    'cancel_url' => cn()
];
try{
    $charge = Charge::create($chargeData);
    $res = $charge->getAttributes();
    $hostedUrl = $res['hosted_url'];
    return $hostedUrl;
}catch(\Exception $e){
    echo $e->getMessage();exit;
}

//pr($charge);exit;
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