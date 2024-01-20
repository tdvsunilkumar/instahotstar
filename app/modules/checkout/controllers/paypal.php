<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class paypal extends MX_Controller {
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
		$this->payment_type		   = "paypal";
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
	
	public function test(){
	     $txtId = 'ba9a8d8697739e32452048e8cffe870e6e34093e95eb7f777a0ecf76e003d0ec3e89a51445eb98b58e77f9cf9f26dca8e21a4e5fc1f688a802cba270b112bb9dd/deCFZF5sc+3wnyQtBnjRRp/YTcETSMZ+YPENFq0dfcSDUN8aoIwLE4qLeUVu5bC4qlP+Fc6IO0bZ9v82L03nckk3qeJZ/NftSKKgbxeHFjeEwRCqOlYwGx1klImr/tlYkYiHNiXFJ6MW/MqmlNip8fvTUD5SyKqeJXM+mlKPOpLMksVFNhaxKAWqtmeuaMl6LmmOI6ioqgVev4gmXQ1M1fr7ov5oMMGZeJCvJt5GrzEFXHKjS5nrXuO0GCaAlnfglT0SkcSpluiy8OWoZi7tVx0AEi1FwF0lW2DuD/7HNxckfe3FraoXUdCiYrXy+wUgCJhFZp+0iAyDCarv6XtcN8qlulildJjlROgAZUstBYEpUTeD9e4Eu9HYCbAYdP1E6BRfvbD8Fc72fXe2b0HJnAIL6M1EExvzfNGcPxZpGRJQW1EMRCmj0ALsNydspBzxfx04oPrFgk8MESSL9Efux2oTs/57SrEY97weSxAsP5OzQcCg98H5meCE1aHxGo6h6TP+FeNZ5r4YXVMwc8UFvzyeof9TCGBd2GUFwMuWiyYyWshYa4A2zLKr2HrNiu5OJxEklbet1zWvF8REzSqQ9XoEV4A+irgMhlSf6bh3bDdMJQEkcsf+wjcRyWQufJ5eBaEQpA3/yjNFbm9GmKL0HjfzINxBTJ3hYAnPSAj/I9INa6w9ggzZSInjXOaSNHe0LJHfRYcT/RpffLvzDeGTOx1+CcjF5a+sgZPl8ph0z9qMVYlZyx4dZh9jBem/E9ALURDQ4c8dYq6HhL1H/HFyxJwInWfwAMkoqEb6m0LBIwHdOPdUHIy88wD6vy8FbZCFn9et+sL7K8qwqAb9dOWTp/reOzQFDQdGNMtuxnCuKO5dpAgY4syAJkKvZsAerYmvFzFMxl1Crq0Mtx30/qLA==';
	     $txnidExistance = json_decode(encrypt_decode($txtId));
	     pr ($txnidExistance);exit;
	 }

	/**
	 *
	 * Create payment
	 *
	 */
	 
	 public function getLocation(){
	     $loc = json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$_SERVER['REMOTE_ADDR']));
         return (array)$loc;
	}

	public function create_payment($order_details = ""){
		if ($order_details) {
			$order_details['call_from'] = 'instahotstar';
			$res = $this->getLocation();
	    $ipAddress = (isset($res['geoplugin_request']))?$res['geoplugin_request']:'';
	    $city      = (isset($res['geoplugin_city']))?$res['geoplugin_city']:'';
	    $state     = (isset($res['geoplugin_regionName']))?$res['geoplugin_regionName']:'';
	    $country   = (isset($res['geoplugin_countryName']))?$res['geoplugin_countryName']:'';
	    $lat       = (isset($res['geoplugin_latitude']))?$res['geoplugin_latitude']:'';
	    $long      = (isset($res['geoplugin_longitude']))?$res['geoplugin_longitude']:'';
	    $location = array(
	        'ipAddress' =>$ipAddress,
	        'city'      =>$city,
	        'state'     =>$state,
	        'country'   =>$country,
	        'lat'       =>$lat,
	        'long'      =>$long,
	        );
	    $order_details['location'] = $location;  
			//pr($order_details);exit;
			$this->load->view($this->payment_type.'/index', $order_details);
		}else{
			redirect(cn());
		}
		/*unset_session("order_details");
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
		if (!empty($amount) && $amount > 0) {
			$data = (object)array(
				"amount"       => $finalPaidAmount,
				"currency"     => $this->currency_code,
				"description"  => $description,
				"redirectUrls" => cn("checkout/paypal/complete"),
				"cancelUrl"    => cn("checkout/unsuccess"),
			);
			//pr($data);
			set_session("order_details", $order_details);
			$response = $this->paypal->create_payment($data, $this->mode);
			if ($response->status) {
				$this->load->view('paypal/index', ['redirect_url' => $response->approvalUrl]);
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
		}*/
	}

	/**
	 *
	 * Call Execute payment after creating payment
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
	
	public function complete(){

		if (isset($_GET["paymentId"]) && $_GET["paymentId"] == session('paypal_payment_id')) {
			$result = $this->paypal->execute_payment($_GET["paymentId"], $_GET["PayerID"], $this->mode);
                      
			// get amount
			$amount = $result->transactions[0]->amount;
			$amount = $amount->total;

			// get Transaction Id
			$transactions = $result->getTransactions();
			$related_resources = $transactions[0]->getRelatedResources();
			$sale = $related_resources[0]->getSale();
			$get_transaction_fee = $sale->getTransactionFee();
			$sale_id = $sale->getId();


			if(!empty($result) && $result->state == 'approved'){

				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $sale_id,
					'transaction_fee'       => $get_transaction_fee->getValue(),
					'order_details'         => session('order_details'),
				);
				unset_session('order_details');
				unset_session('paypal_payment_id');	
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