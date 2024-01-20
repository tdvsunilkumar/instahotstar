<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class ipaytotal extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $paypal;
	public $payment_type;
	public $currency_code;
	public $tb_services;
	public $tb_order;
	public $mode;
	public $apiKey;
	public $tb_addresses;

	public function __construct(){
		parent::__construct();
		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->tb_services         = SERVICES;
		$this->tb_services         = SERVICES;
		$this->tb_order            = ORDER;
		$this->tb_addresses        = ADDRESSES;
		$this->payment_type		   = "ipaytotal";
		$this->apiKey              = "13127KUcNb0wdhsoXt6FAwzHzvD8UYMjaGrKJwkD6Eq2gl1HAtHbWsb1gl5dRVQ3KcgJn";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");
		

		$CI = &get_instance();
		if(empty($CI->model)){
			$CI->load->model('model', 'model');
		}


	}
	
	
	public function process_payment(){
	    $config = array(
        array(
                'field' => 'card_type',
                'label' => 'Card Type',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'Only Visa and Mastercard accpted.',
                )
        ),
        array(
                'field' => 'card_no',
                'label' => 'Card No.',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'ccExpiryMonth',
                'label' => 'Expiry Month',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'ccExpiryYear',
                'label' => 'Expiry Year',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'cvvNumber',
                'label' => 'CVV',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.'
                )
        )
);
$this->form_validation->set_rules($config);
if ($this->form_validation->run() == FALSE){
    
        ms([
            'status'=>'error',
            'errors'=>$this->form_validation->error_array()
            ]);
                }else{
                     $this->db->where('id',post('user'));
        $result = $this->db->get($this->tb_addresses);
        $rows = $result->num_rows();
	    if($rows > 0){
	        $fResult = $result->result();
	        $user = (array)$fResult[0];
	        $payMentData = array_merge($user, post());
	        unset($payMentData['id']);
	        unset($payMentData['created_at']);
	        unset($payMentData['updated_at']);
	        unset($payMentData['user']);
	        $payMentData['api_key'] = $this->apiKey;
	        $payMentData['card_no'] = str_replace(" ","",$payMentData['card_no']);
	        if($payMentData['card_type'] == 'mastercard'){
	            $payMentData['card_type'] = 3;
	        }else{
	            $payMentData['card_type'] = 2;
	        }
	        //pr($payMentData);exit;
	        $url = "https://ipaytotal.solutions/api/transaction";
	        //$url = "https://ipaytotal.solutions/api/test/transaction";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payMentData));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER,[
            'Content-Type: application/json'
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response);
            //pr($responseData);exit;
            if(isset($responseData->status) && $responseData->status == 'success'){
                ms(
	            [
	                'status' => 'success',
	                'data'=>$responseData
	                ]
	            );
            }
            else if(isset($responseData->status) && $responseData->status == 'failed'){
                ms(
	            [
	                'status' => 'error',
	                'type'   => 'card_error',
	                'errors'=>$responseData->message
	                ]
	            );
            }else if(isset($responseData->status) && $responseData->status == '3d_redirect'){
                ms(
	            [
	                'status' => '3d_redirect',
	                'url'=>$responseData->redirect_3ds_url
	                ]
	            );
            }
            else if(isset($responseData->status) && $responseData->status == 'fail'){
                ms(
	            [
	                'status' => 'error',
	                'type'   => 'card_error',
	                'errors'=>$responseData->message
	                ]
	            );
            }else{
                ms(
	            [
	                'status' => 'error',
	                'type'   => 'card_error',
	                'errors'=>'Server error, Please try again after some time.'
	                ]
	            );
            }
	        
	    }else{
	        ms(
	            [
	                'status' => 'error',
	                'type'   => 'card_error',
	                'errors'=>'Invalid Billing Address'
	                ]
	            );
	    }
                }
	}
	
	
	public function save_billing_details(){
	    $config = array(
        array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'state',
                'label' => 'State',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'country',
                'label' => 'Country',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'zip',
                'label' => 'Zip',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => array(
                        'required' => '%s is required field.',
                        'valid_email'=>'Invalid Email'
                )
        ),
        array(
                'field' => 'phone_no',
                'label' => 'Phone No.',
                'rules' => 'required|regex_match[/^[0-9]{6,12}$/]',
                'errors' => array(
                        'required' => '%s is required field.',
                        'regex_match'=>'Invalid Phone'
                )
        )
);
$this->form_validation->set_rules($config);
if ($this->form_validation->run() == FALSE){
    
        ms([
            'status'=>'error',
            'errors'=>$this->form_validation->error_array()
            ]);
                }else{
                    /* Check record already exists or not */
                    $this->db->where('email',post('email'));
        $result = $this->db->get($this->tb_addresses);
        $rows = $result->num_rows();
	    if($rows > 0){
	        $this->db->where('email',post('email'));
	        $this->db->update($this->tb_addresses, post());
	        $fResult = $result->result();
	        $user_id = $fResult[0]->id;
	    }else{
	        $this->db->insert($this->tb_addresses, post());
			$user_id = $this->db->insert_id();
	    }
	    $order_details = session('order_details');
	    $order_details['user_id'] = $user_id;
	    //pr($order_details);exit;
	    $instaAccountView = $this->template->loadSectionView("ipaytotal/ajax/index", $order_details);
	    ms(
	        [
	            'status'=>'success',
	            'view'  =>$instaAccountView
	            ]
	        );
                    /* Check record already exists or not */
                    
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
		//	pr($res);exit;
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
	    $item_ids      = $order_details['item_ids'];
		$email         = $order_details['email'];
		$item = $this->model->get('id, price,coupan_disc,coupan,cate_id, name, quantity', $this->tb_services, ['ids' => $item_ids, 'status' => 1]);
		if (empty($item)) {
			redirect(cn("checkout"));
		}   
		$order_details['itemQuantity'] = $item->quantity;
	    $order_details['location'] = $location;  
	    $this->db->where('email',$order_details['email']);
        $result = $this->db->get($this->tb_addresses);
        $rows = $result->num_rows();
        $rows = $result->num_rows();
	    if($rows > 0){
	        $fResult = $result->result();
	        $user = $fResult[0];
	    }else{
	        $user = [];
	    }
	    $order_details['user'] = (array)$user;
	    if(isset($order_details['iscoupanApplied']) && $order_details['iscoupanApplied'] == 1){
	        $order_details['coupon_disc'] = $item->coupan_disc;
	    }
		    set_session("order_details", $order_details);
			$this->template->set_layout('user');
		    $this->template->build($this->payment_type.'/ipaytotal', $order_details);
			//$this->load->view($this->payment_type.'/ipaytotal', $order_details);
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
        if (isset($_GET["status"]) && $_GET["status"] == 'success') {
		$url = "https://ipaytotal.solutions/api/get/transaction";
        $key = $this->apiKey;
        $order_id = (isset($_REQUEST['order_id']))?$_REQUEST['order_id']:'';
        $sulte_apt_no = (isset($_REQUEST['sulte_apt_no']))?$_REQUEST['sulte_apt_no']:'';
        $data = [
        'api_key' => $key,
        'order_id' => $order_id,
        ];
        //pr($data);exit;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,[
        'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response);
			if(!empty($responseData) && $responseData->status == 'success' && isset($responseData->transaction->transaction_status) && $responseData->transaction->transaction_status == 'success'){
                $amount = $responseData->transaction->amount;
			    $sale_id = $responseData->transaction->order_id;
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $sale_id,
					'transaction_fee'       => 0.00,
					'order_details'         => session('order_details'),
				);
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

		}else{
			redirect(cn("checkout/unsuccess"));
		}
	}
}