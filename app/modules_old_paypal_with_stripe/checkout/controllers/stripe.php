<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class stripe extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $stripeapi;
	public $payment_type;
	public $currency_code;
	public $mode;

	public function __construct(){
		parent::__construct();

		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->tb_services         = SERVICES;
		$this->tb_services         = SERVICES;
		$this->tb_order            = ORDER;
		$this->payment_type		   = "stripe";
		$this->mode 			   = get_option("stripe_payment_environment", "");
		$this->currency_code       = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "");
		$this->load->library("stripeapi");
		$this->stripeapi = new stripeapi(get_option('stripe_secret_key',""), get_option('stripe_publishable_key',""), $this->mode);

		$this->load->model('model', 'model');
	}

	public function index(){
		redirect(cn("checkout"));
	}

	public function create_payment($order_details = ""){
		if ($order_details) {
			$order_details['call_from'] = 'instahotstar';
			//pr($order_details);exit;
			$this->load->view($this->payment_type.'/stripe', $order_details);
		}else{
			redirect(cn());
		}
	}

	/**
	 *
	 * Create payment
	 *
	 */

	public function collect_payment(){
		if(isset($_GET['data']) && $_GET['data'] != ''){
          $newData = json_decode($_GET['data']);
         $this->create_payment_step2($newData);
		}else{
			redirect(cn());
		}
        
	}


	public function create_payment_step2($dataFromOutsource = []){
		unset_session("order_details");
		$order_details = (array)$dataFromOutsource->order_details;
		//pr($order_details);
		if ($order_details['item_ids'] == "" || $order_details['email'] == "" || $order_details['link'] == ""|| $order_details['price'] == "") {
			redirect(cn());
		}

		$item_ids      = $order_details['item_ids'];
		$email         = $order_details['email'];
		$item 		   = $this->model->get('id, price, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		if (empty($item)) {
			redirect(cn());
		}
		if(isset($order_details['offer_applied']) && $order_details['offer_applied'] == 1){
        	$itemQuantity     = $item->quantity.' + '.$order_details['extraActivities'];
        }else{
        	$itemQuantity     = $item->quantity;
        }
		$finalPaidAmount = number_format((float)$order_details['payableAmount'], 2, '.', '');
		$description = '';
		$amount = $item->price;
		if(isset($dataFromOutsource->txt_id) && !empty($dataFromOutsource->txt_id)){
			

			//add customer to stripe
			//$customer = $this->stripeapi->customer_create($data_buyer_info);
			// Item info
			$itemNumber = $item->name;
			$orderID    = 'ODRS'.strtotime(NOW);//charge a credit or a debit card.

			

			$data_charge = array(
				'customer'     => $customer->id,
		        'amount'       => $finalPaidAmount,
		        'currency'     => strtolower($this->currency_code),
		        'description'  => $description,
		        'metadata'     => array(
		            'order_id' => $orderID
		        )
			);
			//charge a credit or a debit card
			set_session("order_details", $order_details);
		    $result = true;
			if ($result) {
				/*----------  Insert to Transaction table  ----------*/
				
				
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $finalPaidAmount,
					'txt_id'                => $dataFromOutsource->txt_id,
					'order_details'         => session('order_details'),
					'transaction_fee'       => "",
				);

				$order = new orders();
				if(!$order->save_order($data_order)){
					unset_session("order_details");
					redirect(cn("checkout/unsuccess"));
				};
				/*----------  Add funds to user balance  ----------*/
				unset_session("order_details");
				redirect(cn("checkout/success"));
			}else{
				redirect(cn("checkout/unsuccess"));
			}
	
		}else{
			redirect(cn("checkout"));
		}
	}
}