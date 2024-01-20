<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'libraries/cardinity/autoload.php');
use Cardinity\Client;
use Cardinity\Method\Payment;

class cardinity extends MX_Controller {
	public $tb_users;
	public $tb_categories;
	public $tb_social_network;
	public $tb_services;
	public $columns;
	public $module_name;
	public $module_icon;
	private $credentails;

	public function __construct(){
		//parent::__construct();
		//$this->load->model(get_class($this).'_model', 'model');

		//Config Module
		$this->credentails = $this->config->config;
		$this->tb_categories     = CATEGORIES;
		$this->tb_services       = SERVICES;
		$this->tb_social_network = SOCIAL_NETWORK_CATEGORIES;
		$this->module_name   = 'Cardinity';
		$this->module_icon   = "fa ft-users";
		$this->columns = array(
			"name"             => lang("Name"),
			"url_slug"         => 'Url Slug',
			"sort"             => lang("Sorting"),
			"status"           => lang("Status"),
		);
	}
	
	public function sevenpay(){
	    $this->load->view('sevenpay', []);
	}

	public function index(){
        if(isset($_REQUEST['call_from']) && isset($_REQUEST['product']) && isset($_REQUEST['price']) && isset($_REQUEST['user_id'])){

        $call_from = $_REQUEST['call_from'];
        $product = $_REQUEST['product'];
        $price = $_REQUEST['price'];
        $user_id = $_REQUEST['user_id'];
        $amount = (int)trim(str_replace("$","",$price));
        $outSideData = array(
          'call_from'=>$call_from,
          'product'=>$product,
          'price'=>number_format((float)$amount, 2, '.', ''),
          'user_id'=>$user_id,
        );
        set_session("massgress_order_details", $outSideData);
        /* Generate signature */
        $data = (object)array(
                "amount"       => number_format((float)$amount, 2, '.', ''),
                "currency"     => 'USD',
                "redirectUrls" => cn("cardinity-returl-url"),
                "cancelUrl"    => cn("cardinity-cancel-url"),
            );
                $amount = $data->amount;
                $cancel_url = $data->cancelUrl;
                $country = "LT";
                $currency = "USD";
                $order_id = 'MASS'.strtotime(date("Y-m-d H:i:s"));
                $description = 'Purchase of Instagram followers with order ID '.$order_id;
                $return_url = $data->redirectUrls;
                $project_id = $this->credentails['project_id'];
                $project_secret = $this->credentails['project_secret'];
                $attributes = [
                "amount" => $amount,
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
                $attributes['signature'] = $signature;
                $this->load->view('cardinity/cardinity/custom', $attributes);
        /* Generate signature */ 
        }
			}

	public function complete(){
        if (isset($_REQUEST["id"]) && $_REQUEST["id"] != '') {
            $orderDetails = session('massgress_order_details');
            unset_session("massgress_order_details");
            // get amount
            $amount = $_REQUEST["amount"];
            $paymentId = $_REQUEST["id"];
            $get_transaction_fee = 0.00;
            $currency = $_REQUEST["currency"];
            if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'approved'){
                    $cardinityPaymentData = array(
                    'orderId'=>$paymentId,
                    'amount'=>$amount,
                    'currency'=>$currency,
                    'status'=>$_REQUEST["status"]
                    );
                    $response = array(
                    'status'=>200,
                    'data'=>$cardinityPaymentData,
                    'message'=>'Payment done successfully.',
                    'user_id'=>$orderDetails['user_id'],
                    'call_from'=>$orderDetails['call_from']
                    );  
            }else if(isset($_REQUEST["status"]) && $_REQUEST["status"] == 'declined'){
                    $response = array(
                    'status'=>400,
                    'data'=>json_encode(array()),
                    'message'=>$_REQUEST['error'],
                    'user_id'=>$orderDetails['user_id'],
                    'call_from'=>$orderDetails['call_from']
                    );   
            }else{
                    $response = array(
                    'status'=>400,
                    'data'=>json_encode(array()),
                    'message'=>'Payment canceled due to internal server error, Please try again.',
                    'user_id'=>$orderDetails['user_id'],
                    'call_from'=>$orderDetails['call_from']
                    );
                
            }

            $finalResponse = json_encode($response);
    redirect('https://massgress.com/payment/add-funds?cardinityresponse='.$finalResponse, 'refresh');

        }
    }


    public function cancel($value=''){
        $orderDetails = session('massgress_order_details');
        unset_session("massgress_order_details");
        $response = array(
        'status'=>400,
        'data'=>json_encode(array()),
        'message'=>'Payment canceled due to internal server error, Please try again.',
        'user_id'=>$orderDetails['user_id'],
        'call_from'=>$orderDetails['call_from']
        );
        $finalResponse = json_encode($response);
    redirect('https://massgress.com/payment/add-funds?cardinityresponse='.$finalResponse, 'refresh');
    }


}