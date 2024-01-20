<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class paddle extends MX_Controller {
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
		$this->payment_type		   = "paddle";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");

		$CI = &get_instance();
		if(empty($CI->model)){
			$CI->load->model('model', 'model');
		}


	}
	
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

	public function index($data = array()){
		redirect(cn("checkout"));
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
	    $countryCode = (isset($res['geoplugin_countryCode']))?$res['geoplugin_countryCode']:'';
	    $location = array(
	        'ipAddress' =>$ipAddress,
	        'city'      =>$city,
	        'state'     =>$state,
	        'country'   =>$country,
	        'lat'       =>$lat,
	        'long'      =>$long,
	        'countryCode' => $countryCode
	        );
	        $order_details['location'] = $location;  
	        //pr($order_details);exit;
			$this->load->view($this->payment_type.'/paddle', $order_details);
		}else{
			redirect(cn());
		}
	}

	/**
	 *
	 * Call Execute payment after creating payment
	 *
	 */
	public function complete(){
            $orderDetails = session('order_details');
		if (isset($_REQUEST["checkout"]) && $_REQUEST["checkout"] != '') {
			$curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://checkout.paddle.com/api/1.0/order?checkout_id=".$_REQUEST['checkout'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $paddleObj = json_decode($response);
			$orderDetails = session('order_details');
			$status       = (isset($paddleObj->state))?$paddleObj->state:'canceled';
			//echo $status;exit;
			if($status == 'processed' || $status == 'processing'){
				// get amount
			$amount = $orderDetails['payableAmount'];
			// get Transaction Id
			$sale_id = (isset($orderDetails->order->order_id))?$orderDetails->order->order_id:'IHO'.strtotime(date("y-m-d H:i:s")).rand(00000,99999);
			$get_transaction_fee = 0.00;
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $sale_id,
					'transaction_fee'       => 0.00,
					'order_details'         => session('order_details'),
					'order_status'          => $status
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