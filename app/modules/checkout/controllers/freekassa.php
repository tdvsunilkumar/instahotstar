<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class freekassa extends MX_Controller {
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
		$this->payment_type		   = "freekassa";
		$this->mode 			   = get_option("stripe_payment_environment", "");
		$this->currency_code       = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "");

		$this->load->model('model', 'model');
	}

	public function index(){
		redirect(cn("checkout"));
	}
	
	public function fail(){
	    $token = (isset($_REQUEST['order_info']))?$_REQUEST['order_info']:'';
           $dataFromToken = encrypt_decode($token);
           $orderInfo = json_decode($dataFromToken);
           if(isset($orderInfo->call_from) && $orderInfo->call_from == 'instahotstar'){
               redirect(INSTAHOTSTAR);
           }else{
               redirect(cn());
           }
	}
	
	
	public function test(){
	    $merchant_id = FREEKASSA_MERCHENT_ID;
    $merchant_secret = FREEKASSA_SECRET_WORD;

    function getIP () {
    if (isset ($_SERVER ['HTTP_X_REAL_IP'])) return $_SERVER ['HTTP_X_REAL_IP'];
    return $_SERVER['REMOTE_ADDR'];
    }
    if (! in_array (getIP (), array ('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '136.243.38.108'))) {
    die ("hacking attempt!");
    }

    $sign = md5 ($merchant_id. ':'. $_REQUEST['AMOUNT']. ':'. $merchant_secret. ':'. $_REQUEST['MERCHANT_ORDER_ID']);

    if ($sign != $_REQUEST['SIGN']) {
    die ('wrong sign');
    }

    // Also, it is recommended to add a check for the amount of the payment and whether this application has already been paid or canceled
    // Payment was successful, you can carry out the operation.

    die ('YES');
	}
	
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
			$this->load->view($this->payment_type.'/freekassa', $order_details);
		}else{
			redirect(cn());
		}
	}

	


	public function paymentIntent(){
        
		try {
			$json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);
				$result = $this->stripeapi->create_intent($json_obj);
  echo json_encode($result);
			} catch (\Exception $e) {
				echo json_encode(['error' => $e->getMessage()]);exit;
			}
	}

	public function publicKey(){
        $result = $this->stripeapi->getPublicKey();
        echo json_encode(array('publicKey' => $result));exit;
	}

	public function process_payment(){
		if(isset($_REQUEST['payment_token']) && $_REQUEST['payment_token'] != ''){
           $token = $_REQUEST['payment_token'];
           //echo $token;exit;
           $dataFromToken = encrypt_decode($token);
           $orderInfo = json_decode($dataFromToken);
           //pr($orderInfo);exit;
           if(isset($orderInfo->offer_applied) && $orderInfo->offer_applied ==1 && $orderInfo->call_from == 'instahotstar'){
               $orderInfo->payableAmount += $orderInfo->offer_price;
           }
           //pr($orderInfo);exit;
           $order_details = (array)$orderInfo;
           unset_session("order_details");
		$item_ids      = $order_details['item_ids'];
		$email         = $order_details['email'];
		$item = $this->model->get('id, price,coupan_disc,coupan,cate_id, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		if (empty($item)) {
			$this->create_new_item($item_ids);
			$item 		   = $this->model->get('id, price, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		}
        if(isset($order_details['offer_applied']) && $order_details['offer_applied'] == 1){
        	$itemQuantity     = $item->quantity.' + '.$order_details['extraActivities'];
        }else{
        	$itemQuantity     = $item->quantity;
        }
        if($order_details['call_from'] == "instahotstar"){
            $redirectURL = cn("checkout/freekassa/create_payment_step3");
        }else{
            $redirectURL = cn("checkout/freekassa/create_payment_step2");
        }
		$finalPaidAmount = number_format((float)$order_details['payableAmount'], 2, '.', '');
		$description = '';
		$amount = $finalPaidAmount;
		$orderId = "FKS".strtotime(date("Y-m-d H:i:s"));
		$merchant_id = FREEKASSA_MERCHENT_ID;
		$secret_word = FREEKASSA_SECRET_WORD;
		//$finalPaidAmount = 0.74;
		$sign = md5 ($merchant_id. ':'. $finalPaidAmount. ':'. $secret_word . ':'. $orderId);
		if (!empty($amount) && $amount > 0) {
			$data = (object)array(
				"amount"       => $finalPaidAmount,
				"currency"     => $this->currency_code,
				"description"  => $description,
				"redirectUrls" => $redirectURL,
				"cancelUrl"    => cn("checkout/freekassa/fail").'?token='.$token,
				"merchant_id"  => $merchant_id,
				"secret_word"  => $secret_word,
				"order_id"     => $orderId,
				"sig"          => $sign,
			);
			$order_details['freeKasa'] = $data;
			set_session("order_details", $order_details);
			$this->load->view($this->payment_type.'/index', $order_details);
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail')
			));
		}
           
           $this->load->view($this->payment_type.'/index', $orderInfo);
		}
	}

	/**
	 *
	 * Create payment
	 *
	 */

     public function getInstaHotSTarItem($ids=''){
			// From URL to get webpage contents. 
			$url = "https://instahotstar.com/checkout/getInstaHotSTarProduct/".$ids; 
            //echo $url;exit;
			// Initialize a CURL session. 
			$ch = curl_init();  

			// Return Page contents. 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

			//grab URL and pass it to the variable. 
			curl_setopt($ch, CURLOPT_URL, $url); 

			$result = curl_exec($ch); 

			return $result; 
	 }

	 public function createStripeCustomer($value=''){
	 	//pr(post());exit;
	 	$data_buyer_info = array(
				"email"=> post('email'),
				'name' => post('name'),
                'address' => [
                    'line1' => post('CustomerAddress'),
                    'postal_code' => post('zip'),
                    'city' => '',
                    'state' => '',
                    'country' => post('customerCountry'),
                ]  
			);

			//add customer to stripe
			try {
				$customer = $this->stripeapi->customer_create($data_buyer_info);

				try {
					$this->stripeapi->update_intent(['customer'=>$customer->id],post('paymentIntent'));
					echo json_encode(array("status"=>200,"customer"=>$customer->id));exit;
				} catch (Exception $e) {
					echo json_encode(array("status"=>500,));exit;
				}
				echo json_encode(array("status"=>200,"customer"=>$customer->id));exit;
			} catch (\Exception $e) {
				echo json_encode(array("status"=>500,));exit;
			}
	 }


	public function create_new_item($ids){
         $data = $this->getInstaHotSTarItem($ids);
         $dataArray = json_decode($data);
         $dataForNewProduct = array(
             'ids'=>$dataArray->ids,
             'uid'=>$dataArray->uid,
             'cate_id'=>$dataArray->cate_id,
             'order_for'=>$dataArray->order_for,
             'name'=>'Quality Backlinks',
             'quantity'=>$dataArray->quantity,
             'price'=>$dataArray->price,
             'status'=>$dataArray->status
         );
         $this->db->insert($this->tb_services,$dataForNewProduct);
	}

	public function create_payment_step3(){
	    
		   $token = (isset($_REQUEST['order_info']))?$_REQUEST['order_info']:'';
           $dataFromToken = encrypt_decode($token);
           $orderInfo = json_decode($dataFromToken);
         unset_session("order_details");
		$order_details = (array)$orderInfo;
		//pr($order_details);exit;
		if ($order_details['item_ids'] == "" || $order_details['email'] == "" || $order_details['link'] == ""|| $order_details['price'] == "") {
			redirect(cn());
		}

		$item_ids      = $order_details['item_ids'];
		$email         = $order_details['email'];
		$item 		   = $this->model->get('id, price, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		if (empty($item)) {
			$this->create_new_item($item_ids);
			$item 		   = $this->model->get('id, price, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		}
		if(isset($order_details['offer_applied']) && $order_details['offer_applied'] == 1){
        	$itemQuantity     = $item->quantity.' + '.$order_details['extraActivities'];
        }else{
        	$itemQuantity     = $item->quantity;
        }
		$finalPaidAmount = number_format((float)$order_details['payableAmount'], 2, '.', '');
		$description = '';
		$amount = $finalPaidAmount;
		$itemName = 'Order '.$item->name.' ('.$item->quantity.') - ServiceID #'.$item->id.' - '.$email;
		$amount = $finalPaidAmount;
			//charge a credit or a debit card
			set_session("order_details", $order_details);
			//pr(post());exit;
		    if (post('ik_inv_st') == 'success') {
				/*----------  Insert to Transaction table  ----------*/
				//$response = $result->response;
				
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => post('ik_inv_id'),
					'order_details'         => session('order_details'),
					'transaction_fee'       => "",
				);
                //pr($data_order);exit;
				$order = new orders();
				if(!$order->save_order($data_order)){
					unset_session("order_details");
					redirect(cn("checkout/unsuccess"));
				};
				/*----------  Add funds to user balance  ----------*/
				//unset_session("order_details");
				if(isset($data_order->order_details['call_from']) && $data_order->order_details['call_from'] == 'instahotstar'){
					unset_session("order_details");
					$url = INSTAHOTSTAR.'/checkout/interkassa/collect_payment?data='.json_encode($data_order);
					redirect($url);
				}
				redirect(cn("checkout/success"));
			}else{
			    if(isset($order_details['call_from']) && $order_details['call_from'] == 'instahotstar'){
			        $url = INSTAHOTSTAR.'/checkout/unsuccess';
			        redirect($url);
			    }
				//redirect(cn("checkout/unsuccess"));
			}
	
		
	}
	
	public function collect_payment(){
	    //pr($_REQUEST);exit;
		if(isset($_REQUEST['data']) && $_REQUEST['data'] != ''){
          $newData = json_decode($_REQUEST['data']);
          //pr($newData);exit;
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
				//'customer'     => $customer->id,
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
                //pr($data_order);exit;
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