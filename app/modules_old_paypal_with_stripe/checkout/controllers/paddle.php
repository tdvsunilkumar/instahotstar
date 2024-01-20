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
		$this->payment_type		   = "cardinity";
		$this->mode = get_option("payment_environment", "");
		$this->currency_code = (get_option("currency_code", "USD") == "")? 'USD' : get_option("currency_code", "USD");

		$CI = &get_instance();
		if(empty($CI->model)){
			$CI->load->model('model', 'model');
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
				"redirectUrls" => cn("checkout/paddle/complete"),
				"cancelUrl"    => cn("checkout/unsuccess"),
			);
				$amount = number_format((float)$finalPaidAmount, 2, '.', '');
				//$amount = 0.00;
				$cancel_url = $data->cancelUrl;
				$country = "LT";
				$currency = "USD";
				$description = $description;
				$order_id = 'LIKE'.strtotime(date("Y-m-d H:i:s"));
				$return_url = $data->redirectUrls.'?checkout={checkout_hash}';
				$title      = $itemQuantity.' '.$item->name;
        $attribures['vendor_id'] = PADDLE_VENDOR_ID;
        $attribures['vendor_auth_code'] = PADDLE_AUTH_CODE;
        $attribures['return_url'] = $return_url;
        $attribures['product_id'] = 567242;
        $attribures['customer_email'] = $email;
        //$attribures['customer_postcode'] = 10003;
        $attribures['prices'][0] = "USD:".$amount;
        $attribures['webhook+url'] = $return_url;
        $attribures['title'] = $title;
        $url = 'https://vendors.paddle.com/api/2.0/product/generate_pay_link';
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://vendors.paddle.com/api/2.0/product/generate_pay_link",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($attribures),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
        $response = array(
               'status'=>2,
               'data'=>$err
            );
        } else {
            $data = json_decode($response);
            if($data->success) {
            $response = array(
               'status'=>1,
               'data'=>$data
            );
        } else {
            $response = array(
               'status'=>2,
               'data'=>array()
            );
        }
        
        }
			set_session("order_details", $order_details);
			ms($response);
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