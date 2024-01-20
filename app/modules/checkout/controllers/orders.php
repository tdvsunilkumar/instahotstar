<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class orders extends MX_Controller {
	public $tb_users;
	public $tb_order;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_social_network;
	public $cart;
	public $cartproduct;
	public $tb_abonded_checkouts;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		$this->load->model('checkout_model', 'checkoutmodel');
		//Config Module
		$this->tb_categories       = CATEGORIES;
		$this->tb_users            = USERS;
		$this->tb_order            = ORDER;
		$this->tb_services         = SERVICES;
		$this->tb_api_providers    = API_PROVIDERS;
		$this->tb_social_network   = SOCIAL_NETWORK_CATEGORIES;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->cart                = CART;
		$this->cartproduct         = CART_PRODUCT;
		$this->tb_abonded_checkouts = ABONDED_CHECKOUT;
				
	}
	
	
	public function getLocation(){
	     $loc = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
         return $loc;
	}

	public function getOrderStatus($status=''){
		//pr($status);
		if($status == 'processed'){
			return 'inprogress';
		}else if($status == 0){
			return 'awaiting';
		}else{
			return 'pending';
		}
	}

	public function save_order($data_order = "") {
	    //pr($data_order);exit;
		if (!is_object($data_order) && $data_order->amount < 0) {
			return false;
		}
 		$order_detail       = $data_order->order_details;
		$amount             = $data_order->amount;
		$txt_id             = $data_order->txt_id;
		$transaction_fee    = $data_order->transaction_fee;
		$payment_type       = $data_order->payment_type;
		$orderStatus        = (isset($data_order->order_status))?$data_order->order_status:0;
		$order_status       =  $this->getOrderStatus($orderStatus);
		$order_note         = (isset($data_order->order_note)) ? $data_order->order_note : '';
		$transaction_status = (isset($data_order->transaction_status) && $data_order->transaction_status == 0) ? 0 : 1;
        /* Update abonded checkout data. */
			$abondedData = array('status'=>1);
			$this->db->where('email',$order_detail['email'])->update($this->tb_abonded_checkouts,$abondedData);
			/* Update abonded checkout data. */
		//update customer informations
		$user = $this->model->get('id, total_orders, total_spent', $this->tb_users, ['email' => $order_detail['email']]);
		if (empty($user)) {
			$data_user = array(
				"ids" 	        	  => ids(),
				'email'               => $order_detail['email'],
				'total_orders'        => 1,
				'total_spent'         => $amount,
				'history_ip'          => get_client_ip(),
				'changed'             => NOW,
				'created'             => NOW,
			);
			$this->db->insert($this->tb_users, $data_user);
			$user_id = $this->db->insert_id();
		}else{
			$data_user = array(
				'total_orders'   => $user->total_orders + 1,
				'total_spent'    => $user->total_spent + $amount,
				'history_ip'     => get_client_ip(),
				'changed'        => NOW,
			);
			$this->db->update($this->tb_users, $data_user,  ['id' => $user->id]);
			$user_id = $user->id;
		}
		$service = $this->model->get('*', $this->tb_services, ['ids' => $order_detail['item_ids'], 'status' => 1]);
		/* Insert data in cart in case cart id is 0*/
		$cartId = $order_detail['cart_id'];
		if(isset($order_detail['cart_id']) && $order_detail['cart_id'] == 0){
			if(isset($order_detail['offer_applied']) && $order_detail['offer_applied'] == 1){
        	$itemQuantity     = $service->quantity+$order_detail['extraActivities'];
        }else{
        	$itemQuantity     = $service->quantity;
        }

			$cartData = [
				'service_id'        => (isset($service->id))?$service->id:0,
				'instagram_account' => $order_detail['link'],
				'email'             => $order_detail['email'],
				'product'           => $order_detail['product']

			];
			$this->db->insert($this->cart, $cartData);
		    $cartId = $this->db->insert_id();
		    if($cartId > 0){
		    	$cartproductData = [
                 'cart_id'           => $cartId,
                 'media'             => $order_detail['link'],
                 'email'             => $order_detail['email'],
                 'instagram_account' => $order_detail['link'],
                 'service_id'        => (isset($service->id))?$service->id:0,
                 'activities_count'  => $itemQuantity
				];
				$this->db->insert($this->cartproduct, $cartproductData);
		    }

		}
		
		/* Insert data in cart in case cart id is 0*/

		/* Insert different orders based on different cart items. */
		$cartProducts = $this->checkoutmodel->getCartItems($cartId);
		$perItemCharge = $data_order->amount/count($cartProducts);
		$perItemCharge = number_format((float)$perItemCharge, 2, '.', '');
        $countLoopIteration = 1;
        $mergedOrder = '';
        
        $location = (isset($data_order->order_details['location']))?$data_order->order_details['location']:[];
        
        //pr($location);exit;
		foreach ($cartProducts as $cart) {
		
		$data_order_for = array(
			"ids" 	        	=> ids(),
			"uid" 	        	=> $user_id,
			"cate_id" 	    	=> $service->cate_id,
			"service_id" 		=> $service->id,
			"service_type" 		=> $service->type,
			"cart_id"           => $cartId,
			"link" 	        	=> $cart->media,
			"quantity" 	    	=> $cart->activities_count,
			"charge" 	    	=> $perItemCharge,
			"is_coupan_applied" => (isset($data_order->order_details['iscoupanApplied']))?$data_order->order_details['iscoupanApplied']:0,
			"is_offer_applied"  => (isset($data_order->order_details['offer_applied']))?$data_order->order_details['offer_applied']:0,
			"api_provider_id"  	=> $service->api_provider_id,
			"api_service_id"  	=> $service->api_service_id,
			"api_order_id"  	=> -1,
			"note"  	        => $order_note,
			"visitor_id"        => (isset($data_order->order_details['visitorId']))?$data_order->order_details['visitorId']:0,
			"ipadress"          => (isset($location->ipAddress))?$location->ipAddress:'',
			"city"              => (isset($location->city))?$location->city:'',
			"state"             => (isset($location->state))?$location->state:'',
			"country"           => (isset($location->country))?$location->country:'',
			"lat"               => (isset($location->lat))?$location->lat:'',
			"longitude"         => (isset($location->long))?$location->long:'',
			"status"			=> $order_status,
			"changed" 	    	=> NOW,
			"created" 	    	=> NOW,
		);
		//pr($data_order_for);
		$this->db->insert($this->tb_order, $data_order_for);
		$order_id = $this->db->insert_id();
        $mergedOrder .= $order_id.',';
		/*----------  Insert to Transaction table  ----------*/
		$data_transaction = array(
			"ids" 				=> ids(),
			"uid" 				=> $user_id,
			"order_id" 		    => $order_id,
			"type" 				=> $payment_type,
			"transaction_id" 	=> $txt_id,
			"transaction_fee" 	=> $transaction_fee,
			"amount" 	        => $perItemCharge,
			"original_price"    => $service->price,
			"status" 	        => $transaction_status,
			"created" 			=> NOW,
		);
		//pr($data_order);
		if(isset($data_order->order_details['iscoupanApplied']) && $data_order->order_details['iscoupanApplied'] == '1'){
			//echo "calling";exit;
			$data_transaction['coupan'] = $service->coupan;
			$data_transaction['discount'] = $service->coupan_disc;
		}if(isset($data_order->order_details['offer_applied']) && $data_order->order_details['offer_applied'] == '1'){
			$perItemExtraCharge = $data_order->order_details['offer_price']/count($cartProducts);
		    $perItemExtraCharge = number_format((float)$perItemExtraCharge, 2, '.', '');
			$data_transaction['offer_extra_price'] = $perItemExtraCharge;
		}
		$this->db->insert($this->tb_transaction_logs, $data_transaction);
		$transaction_log_id = $this->db->insert_id();
		set_session("transaction_log_id", $transaction_log_id);
        
		// send email to user and admin enable_new_order_notification_send_to_customer
		if($countLoopIteration == count($cartProducts)){
		if (get_option("enable_new_order_notification_send_to_customer")) {
			$subject = get_option('new_order_notification_send_to_customer_subject');
			$message = get_option('new_order_notification_send_to_customer_content');
			set_session('final_order_id',rtrim($mergedOrder, ','));
			set_session('total_paid_amount',$amount);
			$merge_fields = array(
				"{{customer_email}}"      => $order_detail['email'],
	            "{{order_id}}"            => rtrim($mergedOrder, ','),
	            "{{each_order_amount}}"   => $perItemCharge,
	            "{{amount}}"              => $amount,
	            "{{package_name}}"        => $cart->activities_count.' '.$service->name.' per order',
	            "{{manage_orders_link}}"  => cn('client'),
			);
			$template = [ 'subject' => $subject, 'message' => $message, 'merge_fields' => $merge_fields];
			$check_send_email_issue = $this->model->send_mail_template($template, $user_id);
		}		

		if (get_option("enable_new_order_notification_send_to_admin")) {
			$subject = get_option('new_order_notification_send_to_admin_subject');
			$message = get_option('new_order_notification_send_to_admin_content');
			$template = [ 'subject' => $subject, 'message' => $message, 'merge_fields' => $merge_fields];
			$admin_id = $this->model->get("id", $this->tb_users, "role = 'admin'", "id","ASC")->id;
			if ($admin_id) {
				$check_send_email_issue = $this->model->send_mail_template($template, $admin_id);
			}
		}
	}
		// send email to user and admin enable_new_order_notification_send_to_customer
	      $countLoopIteration++;
		}

		/* Insert different orders based on different cart items. */

		return true;
	}
}