<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class payop extends MX_Controller {
	public $tb_users;
	public $tb_transaction_logs;
	public $paypal;
	public $payment_type;
	public $currency_code;
	public $tb_services;
	public $tb_order;
	public $mode;
	public $tb_addresses;
	public $payopcontext;

	public function __construct(){
		parent::__construct();
		$this->tb_users            = USERS;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->tb_services         = SERVICES;
		$this->tb_services         = SERVICES;
		$this->tb_order            = ORDER;
		$this->tb_addresses        = ADDRESSES;
		$this->payment_type		   = "payop";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");
		$this->load->library("payopapi");
        $this->payopcontext = new payopapi();
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


	public function createSignature($order = []){
			$order = $order;
			ksort($order, SORT_STRING);
			$dataSet = array_values($order);
			$dataSet[] = PAYOP_SECRET_KEY;
			return hash('sha256', implode(':', $dataSet));
	}
	
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
		$order_details['id'] = $item->id;
		$order_details['itemQuantity'] = $item->quantity;
		
		//pr($this->payopcontext);exit;
		$invoice_identifier = $this->payopcontext->create_invoice($order_details);
		if(!empty($invoice_identifier) && $invoice_identifier->status == 1){
		    $order_details['invoice_identifier'] = $invoice_identifier->data;
		}else{
		    redirect(cn("checkout"));
		}
		
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
	    //pr($order_details);exit;
		    set_session("order_details", $order_details);
		    $redirectUrl = "https://payop.com/en/payment/invoice-preprocessing/".$order_details['invoice_identifier'];
		    $order_details['paymentpage'] = $redirectUrl;
		    redirect($redirectUrl);
			$this->template->set_layout('user');
		    $this->template->build($this->payment_type.'/payop', $order_details);
			//$this->load->view($this->payment_type.'/ipaytotal', $order_details);
		}else{
			redirect(cn());
		}
	}
	
	
	public function process_payment(){
	    
	    $config = array(
        array(
                'field' => 'holderName',
                'label' => 'Cardholder Name',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'Cardholder Name is required field',
                )
        ),
        array(
                'field' => 'pan',
                'label' => 'Bank card number',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'expirationDate',
                'label' => 'Card Expiry Date',
                'rules' => 'required',
                'errors' => array(
                        'required' => '%s is required field.',
                )
        ),
        array(
                'field' => 'cvv',
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
            'type'=>'validation_error',
            'errors'=>$this->form_validation->error_array()
            ]);
                }else{
                    
        $rows = 1;
	    if($rows > 0){
	        $cardTokenData = [
	            "invoiceIdentifier"=>post("invoiceIdentifier"),
	            "pan"=>str_replace(" ","",post("pan")),
	            "expirationDate"=>post("expirationDate"),
	            "cvv"=>post("cvv"),
	            "holderName"=>post("holderName")
	            ];
	        $cardToken = $this->payopcontext->create_card_token($cardTokenData);
	        
	        if(isset($cardToken->status) && $cardToken>status == 1){
	            $orderDetails = session('order_details');
	            //pr($orderDetails);exit;
	            $createCheckout = [
	                'invoiceIdentifier'=>$orderDetails['invoice_identifier'],
	                'customer'=>['email'=>$orderDetails['email'],'ip'=>$_SERVER['REMOTE_ADDR']],
	                'checkStatusUrl'=>"https://instahotstar.com/checkout/payop/complete/{{txid}}",
	                'payCurrency'=>"USD",
	                'paymentMethod'=>381,
	                'cardToken'=>$cardToken->data->token
	                ];
	                pr($createCheckout);exit;
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
	            if(isset($cardToken->message) && !empty($cardToken->message)){
	                $messages = (array)$cardToken->message;
	                ms([
            'status'=>'error',
            'type'  =>'payop_error',
            'errors'=>$messages
            ]);
	            }else{
	                ms(
	            [
	                'status' => 'error',
	                'type'   => 'card_error',
	                'errors'=>'Server error, Please try again after some time.'
	                ]
	            );
	            }
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

	/*public function create_payment($order_details = ""){
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
				"redirectUrls" => cn("checkout/paypal/complete"),
				"cancelUrl"    => cn("checkout/unsuccess"),
			);
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
		}
	}*/

	/**
	 *
	 * Call Execute payment after creating payment
	 *
	 */
	public function complete(){
	    //pr($_REQUEST);exit;
		if (isset($_REQUEST["txid"]) && $_REQUEST["txid"] != "" && isset($_REQUEST["invoiceId"]) && $_REQUEST["invoiceId"] != "") {
			$txnId = $_REQUEST["txid"];
			$invoiceId = $_REQUEST["invoiceId"];
			$txnResult = $this->payopcontext->getTransactionDetails($txnId);
			$invoiceInfo = $this->payopcontext->getInvoiceDetails($invoiceId);
			if(isset($invoiceInfo->status) && $invoiceInfo->status == 1){
			    $orderDetails = (array)$invoiceInfo->data->payer->extraFields;
			}else{
			    $orderDetails = [];
			}
			
			//pr($orderDetails);exit;
			$amount = $orderDetails['payableAmount'];
			$sale_id = $_REQUEST["txid"];
			if(isset($txnResult->status) && $txnResult->status == "1"){
				require_once 'orders.php';
				$data_order = (object)array(
					'payment_type'          => $this->payment_type,
					'amount'                => $amount,
					'txt_id'                => $sale_id,
					'transaction_fee'       => 0.00,
					'order_details'         => $orderDetails,
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
		    exit;
			redirect(cn("checkout/unsuccess"));
		}
	}
}