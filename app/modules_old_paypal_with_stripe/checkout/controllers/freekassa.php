<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class freekassa extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $paypal;
	public $payment_type;
	public $currency_code;
	public $tb_services;
	public $tb_order;
	public $mode;

	public function __construct(){
		parent::__construct();
		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->tb_services         = SERVICES;
		$this->tb_services         = SERVICES;
		$this->tb_order            = ORDER;
		$this->payment_type		   = "free-kassa";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");
		$this->load->library("paypalapi");
		$this->paypal = new paypalapi(get_option('paypal_client_id',""), get_option('paypal_client_secret',""));

		$CI = &get_instance();
		if(empty($CI->model)){
			$CI->load->model('model', 'model');
		}


	}

	public function index(){
		redirect(cn("checkout"));
	}

	/**
	 *
	 * Create payment
	 *
	 */

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
		$description = '';
		$amount = $item->price;
		$orderId = "IH".strtotime(date("Y-m-d H:i:s"));
		$merchant_id = 210816;
		$secret_word = 'eqpqvnmi';
		//$finalPaidAmount = 0.74;
		$sign = md5 ($merchant_id. ':'. $finalPaidAmount. ':'. $secret_word . ':'. $orderId);
		if (!empty($amount) && $amount > 0) {
			$data = (object)array(
				"amount"       => $finalPaidAmount,
				"currency"     => $this->currency_code,
				"description"  => $description,
				"redirectUrls" => cn("checkout/paypal/complete"),
				"cancelUrl"    => cn("checkout/unsuccess"),
				"merchant_id"  => $merchant_id,
				"secret_word"  => $secret_word,
				"order_id"     => $orderId,
				"sig"          => $sign
			);
			set_session("order_details", $order_details);
			$this->load->view('freesakka/index', $data);
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
         //pr($_GET);exit;
		if (isset($_GET["MERCHANT_ORDER_ID"]) && isset($_GET["intid"])) {
		    $orderId = $_GET["MERCHANT_ORDER_ID"];
		    $initId  = $_GET["intid"];
		    $sig     = md5('210816'. 'eqpqvnmi');
            $uri = 'https://www.free-kassa.ru/api.php?merchant_id=210816&s='.$sig.'&action=check_order_status&order_id='.$orderId.'&type=json'; 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri); // uri
            curl_setopt($ch, CURLOPT_POST, false); // POST
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // POST DATA
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN RESULT true
            curl_setopt($ch, CURLOPT_HEADER, 0); // RETURN HEADER false
            curl_setopt($ch, CURLOPT_NOBODY, 0); // NO RETURN BODY false / we need the body to return
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // VERIFY SSL HOST false
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // VERIFY SSL PEER false
            $result = json_decode(curl_exec($ch));
            
            //pr($result);          
			// get amount
			$amount = (isset($result->data->amount))?$result->data->amount:0;

			// get Transaction Id
			$transactions = (isset($result->data->id))?$result->data->id:'';
			$sale_id      = $transactions;
			if($transactions != '' && $amount != 0 && !empty($result) && $result->data->status == 'completed'){
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $sale_id,
					'transaction_fee'       => 0.00,
					'order_details'         => session('order_details'),
				);
				unset_session('order_details');
				unset_session('paypal_payment_id');
				//pr($data_order);
				$order = new orders();
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