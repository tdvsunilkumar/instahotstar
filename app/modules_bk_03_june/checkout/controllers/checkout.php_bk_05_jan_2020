<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class checkout extends MX_Controller {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_social_network;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_categories       = CATEGORIES;
		$this->tb_services         = SERVICES;
		$this->tb_api_providers    = API_PROVIDERS;
		$this->tb_social_network   = SOCIAL_NETWORK_CATEGORIES;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->module_name         = 'Services';
		$this->module_icon         = "fa ft-users";

        if (get_role("admin") || get_role("supporter")) {
			$this->columns = array(
				"name"             => lang("Name"),
				"price"            => 'Price',
				"quantity"         => 'Quantity',
				"add_type"         => lang("Type"),
				"provider"         => lang("api_provider"),
				"api_service_id"   => lang("api_service_id"),
				"original_price"   => lang("rate_per_1000")."(".get_option("currency_symbol","").")",
				"min_max"          => lang("min__max_order"),
				"status"           => lang("Status"),
			);
		}				
	}

	public function index(){
		$id = post('item_id');
		$item = $this->model->get_service_detail_by($id);
		if (empty($item)) {
			redirect(cn());
		}
		$data = array(
			"module"     => get_class($this),
			"item"		 => $item,
		);
		
		$this->template->set_layout('user');
		$this->template->build("index", $data);
	}

	public function process(){
		$link   = post("link");
		$email  = post("email");
		$agree  = post("agree");
		$ids    = post('item_ids');

		$payment_method = post('payment_method');
		if ($link  == "" || $email == "") {
			ms(array(
				"status"  => "error", 
				"message" => lang('please_fill_in_the_required_fields')
			)); 
		}
		$link = strip_tags($link);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	      	ms(array(
				'status'  => 'error',
				'message' => lang("invalid_email_format"),
			));
	    }

		if (!$agree) {
			ms(array(
				"status"  => "error",
				"message" => lang('please_agree_to_our_terms_of_services_before_placing_an_order')
			));
		}

		$item = $this->model->get('id, ids, price', $this->tb_services, ['ids' => $ids, 'status' => 1]);
		if (empty($item)) {
			ms(array(
				"status"  => "error",
				"message" => lang('services_does_not_exists')
			));
		}

		/*----------  Check payment method exists or non  ----------*/
		if ($payment_method == "" || $payment_method == "empty") {
			ms(array(
				"status"  => "error",
				"message" => lang('payments_method_do_not_exists_now_please_contact_us_for_more_details')
			));
		}
		
		$exists_payment_methods = get_payments_method();
		if (!in_array($payment_method, $exists_payment_methods)) {
			ms(array(
				"status"  => "error",
				"message" => lang('this_payment_does_not_exists_please_choose_another_payment')
			));
		}

		$is_active_payment = get_option('is_active_'.$payment_method, 0);
		if (!$is_active_payment) {
			ms(array(
				"status"  => "error",
				"message" => lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail')
			));
		}
		
		$data = array(
			"module"             => get_class($this),
			'link'               => $link,
			'email'              => $email,
			'item_ids'           => $item->ids,
			'price'              => $item->price,
			'payment_method'     => $payment_method,
		);
		require $payment_method.'.php';
		$payment_module = new $payment_method();
		$payment_module->create_payment($data);
	}

	public function success(){
		$id = session("transaction_log_id");
		$transaction = $this->model->get("id, ids, uid,amount, order_id, transaction_id, transaction_fee", $this->tb_transaction_logs, ['id' => $id]);
		if (!empty($transaction)) {
			$order_detail = $this->model->get_order_by_id($transaction->order_id);
			if (!empty($order_detail)) {
				$order_detail = $order_detail->id.' - '.$order_detail->quantity.' '.$order_detail->service_name;
			}else{
				$order_detail = 'Empty';
			}
			$data = array(
				"module"        => get_class($this),
				"transaction"   => $transaction,
				"order_detail"  => $order_detail,
			);
			unset_session("transaction_log_id");
			$this->template->set_layout('user');
			$this->template->build("payment_successfully", $data);
		}else{
			redirect(cn());
		}
	}

	public function unsuccess(){
		$data = array(
			"module"        => get_class($this),
		);
		$this->template->set_layout('user');
		$this->template->build("payment_unsuccessfully", $data);
	}
}