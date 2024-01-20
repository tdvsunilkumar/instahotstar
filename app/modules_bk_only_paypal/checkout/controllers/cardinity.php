<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'libraries/cardinity/autoload.php');
use Cardinity\Client;
use Cardinity\Method\Payment;
class cardinity extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $cardinity;
	public $payment_type;
	public $currency_code;
	public $tb_services;
	public $tb_order;
	public $mode;
	private $credentails;
	private $authentication;

	public function __construct(){
		$this->credentails = $this->config->config;
		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->tb_services         = SERVICES;
		$this->tb_services         = SERVICES;
		$this->tb_order            = ORDER;
		$this->payment_type		   = "cardinity";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");
			$this->authentication = Client::create([
			'consumerKey' => $this->credentails['consumerKey'],
			'consumerSecret' => $this->credentails['consumerSecret'],
			]);

		$CI = &get_instance();
		if(empty($CI->model)){
			$CI->load->model('model', 'model');
		}


	}

	public function index($data = array()){
		redirect(cn("checkout"));
		//$this->load->view('cardinity/index', $data);
	}

	/**
	 *
	 * Create payment
	 *
	 */

	/*public function create_payment($order_details = ""){
		    $orderData = array();
		    $cardNumber = str_replace(" ","",$order_details['card_number']);
            $amount = (int)$order_details['price'];
            //echo $cardNumber;exit;
            $method = new Payment\Create([
            'amount' => floatval($amount),
            'currency' => 'USD',
            'settle' => false,
            'description' => 'some description',
            'order_id' => 'LIKE'.strtotime(date("Y-m-d H:i:s")),
            'country' => 'LT',
            'payment_method' => Payment\Create::CARD,
            'payment_instrument' => [
            'pan' => (string)$cardNumber,
            'exp_year' => (int)$order_details['expiry_year'],
            'exp_month' => (int)$order_details['expiry_month'],
            'cvc' => (string)$order_details['cvv'],
            'holder' => $order_details['owner_name']
            ],
            ]);
            try {
	$payment = $this->authentication->call($method);
	$paymentId = $payment->getId();
	$amount = $payment->getAmount();
	$currency = $payment->getCurrency();
	$status = $payment->getStatus();
    if($status == 'approved'){
    	$orderData['status'] = $status;
    	$orderData['payment_id'] = $paymentId;
    	$orderData['amount'] = $amount;
    	$orderData['currency'] = $currency;
    	$orderData['msg'] = 'Payment of $'.$amount.' has been completed successfully.';
    	$status = 200;
    }
    } catch (Exception $e) {
    	$status = 400;
    	$errors = $e->getErrorsAsString();
    	$orderData['status'] = $status;
    	$orderData['msg'] = $errors;
    }
        if($status == 200){
            unset_session("order_details");
		$orderData['item_ids']     = $order_details['item_ids'];
		$orderData['email']        = $order_details['email'];
		$item = $this->model->get('id, price, name, quantity', $this->tb_services, ['ids' => $order_details['item_ids'], 'status' => 1]);
		if (empty($item)) {
			redirect(cn("checkout"));
		}
		$description = 'Order '.$item->name.' ('.$item->quantity.') - ServiceID #'.$item->id.' - '.$email;
		$orderData['description'] = $description;
		set_session("order_details", $orderData);
		redirect(cn("checkout/cardinity/complete").'?paymentId='.$paymentId);
        }else{
        	set_session("order_details", $orderData);
		    redirect(cn("checkout/unsuccess"));

        }
		
	}*/

	public function create_payment($order_details = ""){
		unset_session("order_details");
		$item_ids      = $order_details['item_ids'];
		$email         = $order_details['email'];
		$item = $this->model->get('id, price,coupan_disc,coupan,cate_id, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		if (empty($item)) {
			redirect(cn("checkout"));
		}
        if(isset($order_details['offer_applied']) && $order_details['offer_applied'] == 1){
        	$itemQuantity     = $item->quantity.' + '.$order_details['extraActivities'];
        }else{
        	$itemQuantity     = $item->quantity;
        }
        $finalPaidAmount = number_format((float)$order_details['payableAmount'], 2, '.', '');
		$description = 'Order '.$item->name.' ('.$itemQuantity.') - ServiceID #'.$item->id.' - '.$email;
		$amount = $item->price;
		if (!empty($amount) && $amount > 0) {
			$data = (object)array(
				"amount"       => $finalPaidAmount,
				"currency"     => $this->currency_code,
				"description"  => $description,
				"redirectUrls" => cn("checkout/cardinity/complete"),
				"cancelUrl"    => cn("checkout/unsuccess"),
			);
				$amount = number_format((float)$finalPaidAmount, 2, '.', '');
				$cancel_url = $data->cancelUrl;
				$country = "LT";
				$currency = "USD";
				$description = $description;
				$order_id = 'LIKE'.strtotime(date("Y-m-d H:i:s"));
				$return_url = $data->redirectUrls;
				$project_id = $this->credentails['project_id'];
				$project_secret = $this->credentails['project_secret'];
				$attributes = [
				"amount" => $finalPaidAmount,
				"currency" => $currency,
				"country" => $country,
				"order_id" => $order_id,
				"description" => $description,
				"project_id" => $project_id,
				"cancel_url" => $cancel_url,
				"return_url" => $return_url,
				];
				//pr($attributes);
				ksort($attributes);
				$message = '';
				foreach($attributes as $key => $value) {
				$message .= $key.$value;
				}
				$signature = hash_hmac('sha256', $message, $project_secret);
				//echo $signature;exit;
				$attributes['signature'] = $signature;
			    set_session("order_details", $order_details);
			//$response = $this->paypal->create_payment($data, $this->mode);
			if (true) {
				$this->load->view('cardinity/custom', $attributes);
			}else{
				ms(array(
					"status"  => "error",
					"message" => $response->message
				));
			}
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail')
			));
		}
	}

	/**
	 *
	 * Call Execute payment after creating payment
	 *
	 */
	public function complete(){
            $orderDetails = session('order_details');
		if (isset($_REQUEST["id"]) && $_REQUEST["id"] != '') {
			$orderDetails = session('order_details');
			// get amount
			$amount = $_REQUEST["amount"];
			// get Transaction Id
			$get_transaction_fee = 0.00;
			$sale_id = $_REQUEST["id"];
			if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'approved'){
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $sale_id,
					'transaction_fee'       => 0.00,
					'order_details'         => session('order_details'),
					'order_status'          => $_REQUEST["status"]
				);
				//pr($data_order);
				unset_session('order_details');
				unset_session('paypal_payment_id');	
				//pr($data_order);
				$order = new orders();
				//pr($order->save_order($data_order));
				if(!$order->save_order($data_order)){
					redirect(cn("checkout/unsuccess"));
				};
				/*----------  Add funds to user balance  ----------*/
				redirect(cn("checkout/success"));
			}else{
				redirect(cn("checkout/unsuccess"));
			}

		}else{
			redirect(cn("checkout/unsuccess"));
		}
	}
}