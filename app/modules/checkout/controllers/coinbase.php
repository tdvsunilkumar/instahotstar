<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class coinbase extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $coinbase;
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
		$this->payment_type		   = "coinbase";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");
		$this->load->library("coinbaseapi");
		$this->coinbase = new coinbaseapi();

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
			if(isset($orderInfo->offer_applied) && $orderInfo->offer_applied ==1 && $orderInfo->call_from == 'instahotstar'){
               $orderInfo->payableAmount += $orderInfo->offer_price;
           }
           //pr($orderInfo);exit;
           $order_details = (array)$order_details;
           
           unset_session("order_details");
		$item_ids      = $order_details['item_ids'];
		$email         = $order_details['email'];
		$item = $this->model->get('id, price,coupan_disc,coupan,cate_id, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		
		if (empty($item)) {
			redirect(cn());
		}
        if(isset($order_details['offer_applied']) && $order_details['offer_applied'] == 1){
        	$itemQuantity     = $item->quantity.' + '.$order_details['extraActivities'];
        }else{
        	$itemQuantity     = $item->quantity;
        }
        
		$finalPaidAmount = number_format((float)$order_details['payableAmount'], 2, '.', '');
		$description = 'Purchase of '.$itemQuantity;
		$amount = $finalPaidAmount;
		$orderId = "FKS".strtotime(date("Y-m-d H:i:s"));
		//$order_details['']
		$result = $this->coinbase->create_payment($order_details,$description,$item->name);
		//pr($result);exit;
		if($result != ""){
		    $coinbaseurl = $result;
		}else{
		    redirect(cn('checkout/unsuccess'));
		}
		if (!empty($amount) && $amount > 0) {
			$data = (object)array(
				"amount"       => $finalPaidAmount,
				"currency"     => $this->currency_code,
				"description"  => $description,
				"coinbaseurl"  => $coinbaseurl
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
           
           //$this->load->view($this->payment_type.'/index', $orderInfo);
		}else{
			redirect(cn());
		}
	}

	/**
	 *
	 * Call Execute payment after creating payment
	 *
	 */
	 
	public function getLocation(){
	     $loc = json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$_SERVER['REMOTE_ADDR']));
         return (array)$loc;
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
		$description = 'Purchase of '.$itemQuantity;
		$amount = $finalPaidAmount;
		$orderId = "FKS".strtotime(date("Y-m-d H:i:s"));
		//$order_details['']
		$result = $this->coinbase->create_payment($order_details,$description,$item->name);
		if($result != ""){
		    $coinbaseurl = "https://commerce.coinbase.com/checkout/".$result;
		}else{
		    if($order_details['call_from'] == "instahotstar"){
		        redirect(INSTAHOTSTAR."/checkout/unsuccess");
		    }else{
		        redirect(cn('checkout/unsuccess'));
		    }
		}
		if (!empty($amount) && $amount > 0) {
			$data = (object)array(
				"amount"       => $finalPaidAmount,
				"currency"     => $this->currency_code,
				"description"  => $description,
				"coinbaseurl"  => $coinbaseurl
			);
			$order_details['freeKasa'] = $data;
			//pr($order_details);exit;
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
       // pr($orderInfo);
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
	 
	 public function checkTxnExistsorNot($txn = ''){
	    $this->db->where('transaction_id',$txn);
        $result = $this->db->get($this->tb_transaction_logs)->num_rows();
	    if($result > 0){
	        return 0;
	    }else{
	        return 1;
	    }
	}
	 
	 
	
	public function complete(){
	    //pr($_REQUEST);exit;
	        $tempOrderDetails = session('order_details');
            $headers = getallheaders();
            $res = $this->coinbase->coinbaseWebhook($headers);
            //$res = '';
            if($res['status'] == 200 && !empty($res['event'])){
                $txn = $res['event'];
                $eventType = (isset($txn->type))?$txn->type:'';
                $txtId = (isset($txn->data->code))?$txn->data->code:'';
                /* check either this transaction is is already exists or not*/
                $txnidExistance = $this->checkTxnExistsorNot($txtId);
                /* check either this transaction is is already exists or not*/
                $status = (isset($txn->data->payments[0]['status']))?$txn->data->payments[0]['status']:'';
                
                if($eventType == 'charge:confirmed' && $txnidExistance == 1){
                //if($eventType == 'charge:created' && $txnidExistance == 1){
                    $parameter = $txn->data->metadata['orderInfoToken'];
                    $orderInfo = (array)json_decode(encrypt_decode($parameter));
                    require_once 'orders.php';
                    $amount = $orderInfo['payableAmount'];
                    /*$dataToSave = [
                    'data'=>$amount
                    ];
                    $this->db->insert('test_data', $dataToSave);exit;*/
				    $data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $txtId,
					'transaction_fee'       => 0,
					'order_details'         => $orderInfo,
				);
				
				$item 		   = $this->model->get('id, price, name, quantity', $this->tb_services, ['ids' => $data_order->order_details['item_ids'], 'status' => 1]);
            		if (empty($item)) {
            			redirect(cn("checkout/unsuccess"));
            		}
            	    unset_session('order_details');
				    $order = new orders();
    				if(!$order->save_order($data_order)){
    					redirect(cn("checkout/unsuccess"));
    				};
				    /*----------  Add funds to user balance  ----------*/
				    redirect(cn("checkout/success"));
                }else{
                    redirect(cn("checkout/unsuccess"));
                }
                //pr ($txn->data->checkout->id);exit;
            }else{
                redirect(cn("checkout/unsuccess"));
            }
            
		/*if (isset($_GET["paymentId"]) && $_GET["paymentId"] == session('paypal_payment_id')) {
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

				
				unset_session('order_details');
				unset_session('paypal_payment_id');	
				$order = new orders();
				if(!$order->save_order($data_order)){
					redirect(cn("checkout/unsuccess"));
				};
				/*----------  Add funds to user balance  ----------
				
				if(isset($data_order->order_details['call_from']) && $data_order->order_details['call_from'] == 'instahotstar'){
					unset_session("order_details");
					$url = INSTAHOTSTAR.'/checkout/paypal/collect_payment?data='.json_encode($data_order);
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

		}else{
			redirect(cn("checkout/unsuccess"));
		}*/
	}
}