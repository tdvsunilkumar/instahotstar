<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class provider extends MX_Controller {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_social_network;
	public $tb_api_providers;
	public $tb_orders;
	public $columns;
	public $module_name;
	public $module_icon;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_users       		= USERS;
		$this->tb_categories 		= CATEGORIES;
		$this->tb_services   		= SERVICES;
		$this->tb_api_providers   	= API_PROVIDERS;
		$this->tb_social_network    = SOCIAL_NETWORK_CATEGORIES;
		$this->tb_orders     		= ORDER;
		$this->refillDateDiff       = "+24 hours";
		$this->columns = array(
			"name"             => lang("Name"),
			"balance"          => lang("Balance"),
			"desc"             => lang("Description"),
			"status"           => lang("Status"),
		);
	}

	public function index(){

		if (!get_role('admin') || !session('uid')) {
			redirect(cn('statistics'));
		}

		$api_lists = $this->model->get_api_lists();
		$data = array(
			"module"       => get_class($this),
			"columns"      => $this->columns,
			"api_lists"    => $api_lists,
		);

		$this->template->build('index', $data);
	}

	/**
	 *
	 * Update API
	 *
	 */
	 
	 public function update_refill_status($value=''){
	   	$refillOrders = $this->model->get_refill_order_logs_list("completed",500);
	   	//pr($refillOrders);exit;
	   	$currentDateTime = date("Y-m-d H:i:s");
	   	if(!empty($refillOrders)){
	   		foreach ($refillOrders as $key => $row) {
	   		$add24Hours = date("Y-m-d H:i:s", strtotime($this->refillDateDiff, strtotime($row->refill_last_date)));
	   		//pr($row);
	   		//echo $add24Hours;
	   		if(strtotime($currentDateTime) > strtotime($add24Hours)){
	   		    //pr($row);
	   			$data = array(
		                         "refill_status"         => 0,
		                       );
				$this->db->update($this->tb_orders, $data, array("ids" => $row->ids));
	   		}
	   		
	   	}
	   }else{
	   	echo "No refill order found";exit;
	   }
	   	
	   }

		public function add_to_refill($value=''){
		    
		$order_status = "completed";
		$limit_per_page = 500;
		$order_logs = $this->model->get_order_logs_list($order_status, $limit_per_page);
		//pr($order_logs);exit;
		if(!empty($order_logs)){
			foreach ($order_logs as $key => $row) {
				$api = $this->model->get("url, key", $this->tb_api_providers, ["id" => $row->api_provider_id] );
				if (!empty($api)) {
							$data_post = array(
								'key' 	   => $api->key,
					            'action'   => 'refill',
					            'order'  => $row->api_order_id,
							);
							$response = $this->connect_api($api->url, $data_post);
							$response = json_decode($response);
							//pr($response);
							if(isset($response->refill) && $response->refill != ""){
							$data = array(
		                         "refill_status"         => 1,
		                         "refill_last_date"      => date("Y-m-d H:i:s"),
		                       );
				            $this->db->update($this->tb_orders, $data, array("ids" => $row->ids));
							}
				}
			}

		}else{
			echo "No Record found to refill";exit;
		}
	}
	
	public function update($ids = ""){
		$api    = $this->model->get("*", $this->tb_api_providers, "ids = '{$ids}' ");
		$data = array(
			"module"   		=> get_class($this),
			"api" 			=> $api,
		);
		$this->load->view('update', $data);
	}

	public function ajax_update($ids = ""){
		$name 			= post("name");
		$api_url  		= trim(post("api_url"));
		$api_key 		= trim(post("api_key"));
		$status 		= (int)post("status");
		$description    = $this->input->post('description');
		$description    = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

		if($name == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("name_is_required")
			));
		}

		if($api_url == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("api_url_is_required")
			));
		}

		if($api_key == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("api_key_is_required")
			));
		}

		//
		$data = array(
			"uid"             => session('uid'),
			"name"            => $name,
			"key"         	  => $api_key,
			"url"         	  => $api_url,
			"description"     => $description,
			"status"          => $status,
		);

		/*----------  Check API status   ----------*/
		if (!empty($api_key) && !empty($api_url)) {
			$data_post = array(
				'key' => $api_key,
	            'action' => 'balance',
			);

			$data_connect = $this->connect_api($api_url, $data_post);
			$data_connect = json_decode($data_connect);

			if (empty($data_connect) || !isset($data_connect->balance)) {
				ms(array(
					"status"  => "error",
					"message" => lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again")
				));
			}else{
				$data["balance"]  = $data_connect->balance;
			}
		}

		$check_item = $this->model->get("ids, id", $this->tb_api_providers, "ids = '{$ids}'");
		if(empty($check_item)){
			$data["ids"]     = ids();
			$data["changed"] = NOW;
			$data["created"] = NOW;
			$this->db->insert($this->tb_api_providers, $data);
		}else{
			$data["changed"] = NOW;
			$this->db->update($this->tb_api_providers, $data, array("ids" => $check_item->ids));
			$this->db->update($this->tb_services, ["status" => $status], array("api_provider_id" => $check_item->id));
		}
		
		ms(array(
			"status"  => "success",
			"message" => lang("Update_successfully")
		));
	}

	public function ajax_update_api_provider($ids){
		if ($ids != "" ) {
			$api = $this->model->get("*", $this->tb_api_providers, ["ids" => $ids]);
			if (!empty($api)) {
				$data_post = array(
					'key' => $api->key,
		            'action' => 'balance',
				);

				$data_connect = $this->connect_api($api->url, $data_post);
				$data_connect = json_decode($data_connect);

				if (empty($data_connect) || !isset($data_connect->balance)) {
					ms(array(
						"status"  => "error",
						"message" => lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again")
					));
				}else{
					$data = array(
						"balance" 	        => $data_connect->balance,
						"currency_code" 	=> $data_connect->currency,
					);

					$this->db->update($this->tb_api_providers, $data, ["ids" => $api->ids]);

					ms(array(
						"status"  => "success",
						"message" => lang("Update_successfully")
					));
				}

			}else{
				ms(array(
					"status"  => "error",
					"message" => lang("api_provider_does_not_exists")
				));
			}
		}
	}

	public function ajax_delete_item($ids = ""){
		$this->model->delete($this->tb_api_providers, $ids, true);
	}

	/**
	 *
	 * Get Services List from API
	 *
	 */
	public function services(){
		$api_lists = $this->model->get_api_lists(true);
		$data = array(
			"module"       => get_class($this),
			"api_lists"    => $api_lists,
			
		);

		$this->template->build('get_services', $data);
	}

	public function ajax_get_services_list_by_api($ids = ""){
		if (!empty($ids)) {
			$api = $this->model->get("id, name, ids, url, key",  $this->tb_api_providers, "ids = '{$ids}'");
			if (!empty($api)) {
				$data_post = array(
					'key' => $api->key,
		            'action' => 'services',
				);
				$data_services = $this->connect_api($api->url, $data_post);
				$data_services = json_decode($data_services);
				
				if (empty($data_services) || !is_array($data_services)) {
					$message = '<div class="alert alert-icon alert-danger" role="alert"> <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> '.lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again").'</div>';
					echo $message;
				}

				$data_columns = array(
					"service_id"       => lang("service_id"),
					"name"             => lang("Name"),
					"category"         => lang("Category"),
					"price"            => lang("rate_per_1000"),
					"min_max"          => lang("min__max_order"),
					"type"             => lang("Type"),
				);
				
				$categories_by_social_network = $this->model->get_categories_list_by_social_network();
				$data = array(
					"api_id"	                        => $api->id,
					"api_ids"	                        => $api->ids,
					"module"                            => get_class($this),
					"columns"                           => $data_columns,
					"services"                          => $data_services,
					"categories_by_social_network"      => $categories_by_social_network,
				);
				$this->load->view("ajax/get_services_list", $data);
			}else{
				$message = '<div class="alert alert-icon alert-danger" role="alert"> <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> '.lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again").'</div>';
				echo $message;
			}
		}else{
			$message = '<div class="alert alert-icon alert-danger" role="alert"> <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> '.lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again").'</div>';
			echo $message;
		}
	}

	public function ajax_add_api_provider_service(){
		$api_provider_id    = post("api_provider_id");
		$api_service_id 	= post("service_id");
		$type 	            = post("type");
		$type               = strtolower(str_replace(" ", "_", $type));
		$name 				= post("name");
		$category			= post("category");
		$min	    		= post("min");
		$quantity	        = post("quantity");
		$max	    		= post("max");
		$price	    		= (double)post("price");
		$original_price	    = (double)post("original_price");
		$desc 				= post("desc");

		if($name == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("name_is_required")
			));
		}

		if($category == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("category_is_required")
			));
		}

		if($quantity == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Quantity is required'
			));
		}

		if($quantity < $min){
			ms(array(
				"status"  => "error",
				"message" => "Quantity must to be greater than min order"
			));
		}

		if($quantity > $max){
			ms(array(
				"status"  => "error",
				"message" => "Quantity must to be less than max order"
			));
		}

		if($price == ""){
			ms(array(
				"status"  => "error",
				"message" => lang("price_invalid")
			));
		}

		$data = array(
			"ids"              => ids(),
			"name"             => $name,
			"uid"              => session('uid'),
			"cate_id"          => $category,
			"desc"             => $desc,
			"min"              => $min,
			"max"              => $max,
			"quantity"         => $quantity,
			"price"            => $price,
			"original_price"   => $original_price,
			"add_type"         => 'api',
			"type"             => $type,
			"api_provider_id"  => $api_provider_id,
			"api_service_id"   => $api_service_id,
			"status"           => 1,
			"changed"          => NOW,
			"created"          => NOW,
		);
		$this->db->insert($this->tb_services, $data);

		ms(array(
			"status"  => "success",
			"message" => lang("Update_successfully")
		));
		
	}


	/**
	 *
	 * Sync services
	 *
	 */
	public function sync_services($ids = ""){
		if (!empty($ids)) {
			$api = $this->model->get("id, name, ids, url, key",  $this->tb_api_providers, "ids = '{$ids}'");
			if (!empty($api)) {
				$data = array(
					"module"       => get_class($this),
					"api"          => $api,
				);
				$this->load->view('sync_services', $data);
			}
		}
	}

	public function ajax_sync_services($ids){
		$price_percentage_increase = 0;
		$request = 0;
		$decimal_places = get_option("auto_rounding_x_decimal_places", 2);

		// Check convert Currency or not
		$is_convert_to_new_currency = post("is_convert_to_new_currency");
		$is_enable_sync_price       = post("is_enable_sync_price");

		$new_currency_rate         = 1;
		$is_enable_sync_price      = 0;
		$price_percentage_increase = 0;

		if ($ids != "") {

			$api = $this->model->get("id, name, ids, url, key",  $this->tb_api_providers, ["ids" => $ids, "status" => 1]);

			if (!empty($api)) {
				$data_post = array(
					'key' => $api->key,
		            'action' => 'services',
				);

				$data_services = $this->connect_api($api->url, $data_post);
				$api_services  = json_decode($data_services);
				if (empty($api_services) || !is_array($api_services)) {
					ms(array(
						"status"  => "error",
						"message" => lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again")
					));
				}

				$services = $this->model->fetch("`id`, `ids`, `uid`, `cate_id`, `name`, `desc`, `price`, original_price, `min`, `max`, `add_type`, `type`, `api_service_id` as service, `api_provider_id`, `status`, `changed`, `created`", $this->tb_services, ["api_provider_id" => $api->id, 'status' => 1]);

				if (empty($services) && !$request) {
					ms(array(
						"status"  => "error",
						"message" => lang("service_lists_are_empty_unable_to_sync_services")
					));
				}

				$data_item = (object)array(
					'api' 			             => $api,
					'api_services'               => $api_services,
					'services'                   => $services,
					'price_percentage_increase'  => $price_percentage_increase,
					'request'                    => $request,
					'decimal_places'             => $decimal_places,
					'new_currency_rate'          => $new_currency_rate,
					'is_enable_sync_price'       => $is_enable_sync_price,

				);

				$response = $this->sync_services_by_api($data_item);

				$data = array(
					"api_id"           	=> $api->id,
					"api_name"         	=> $api->name,
					"services_new"     	=> ($request)? $response->new_services : "",
					"services_disabled" => $response->disabled_services,
				);
				$this->load->view("ajax/results_sync", $data);

			}else{
				ms(array(
					"status"  => "error",
					"message" => lang("there_seems_to_be_an_issue_connecting_to_api_provider_please_check_api_key_and_token_again")
				));
			}

		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("api_provider_does_not_exists")
			));
		}
	}


	/**
	 *
	 * Auto sync Service setting
	 *
	 */
	public function auto_sync_services_setting(){
		$data = array(
			"module"       => get_class($this),
		);

		$this->load->view('api/auto_sync_update', $data);
	}

	public function ajax_auto_sync_services_setting(){
		$price_percentage_increase 	= (int)post("price_percentage_increase");
		$sync_request 				= (int)post("request");

		if (post('is_enable_sync_price')) {
			$is_enable_sync_price = 1;
		}else{
			$is_enable_sync_price = 0;
		}

		if (post('is_convert_to_new_currency')) {
			$is_convert_to_new_currency = 1;
			$new_currency_rate = get_option('new_currecry_rate', 1);
		}else{
			$is_convert_to_new_currency = 0;
			$new_currency_rate = 1;
		}

		/*----------  update configure  ----------*/
		$data = array(
			'price_percentage_increase' 	=> $price_percentage_increase,
			'sync_request' 					=> $sync_request,
			'new_currency_rate'          	=> $new_currency_rate,
			'is_enable_sync_price'       	=> $is_enable_sync_price,
			'is_convert_to_new_currency' 	=> $is_convert_to_new_currency,
		);

		update_option('defaut_auto_sync_service_setting', json_encode($data));

		ms(array(
        	"status"  => "success",
        	"message" => lang('Update_successfully')
        ));

	}

	private function sync_services_by_api($data_item){
		
		$api 					   = $data_item->api;
		$api_services 			   = $data_item->api_services;
		$services 				   = $data_item->services;
		$price_percentage_increase = $data_item->price_percentage_increase;
		$request                   = $data_item->request;
		$decimal_places            = $data_item->decimal_places;
		$new_currency_rate         = $data_item->new_currency_rate;
		$is_enable_sync_price      = $data_item->is_enable_sync_price;

		/*----------  Compare All services  ----------*/
		$disabled_services = array_udiff($services, $api_services,
		  	function ($obj_a, $obj_b) {
			    return $obj_a->service - $obj_b->service;
		  	}
		);

		$new_services = array_udiff($api_services, $services,
		  	function ($obj_a, $obj_b) {
			    return $obj_a->service - $obj_b->service;
		  	}
		);

		$exists_services = array_udiff($api_services, $new_services,
		  	function ($obj_a, $obj_b) {
			    return $obj_a->service - $obj_b->service;
		  	}
		);

		/*----------  Update disabled services  ----------*/
		if (!empty($disabled_services)) {
			foreach ($disabled_services as $key => $disabled_service) {
				$this->db->update($this->tb_services, ["status" => 0, "changed" => NOW], ["api_provider_id" => $api->id, "api_service_id" => $disabled_service->service, 'id' => $disabled_service->id]);
			}
		}
		
		/*----------  update exists services  ----------*/
		if (!empty($exists_services) && $is_enable_sync_price) {
			foreach ($exists_services as $key => $exists_service) {
				$service_type = strtolower(str_replace(" ", "_", $exists_service->type));
				$data_service = array(
					"min"             	=> $exists_service->min,
					"max"             	=> $exists_service->max,
					"dripfeed"  	    => $exists_service->dripfeed,
					"original_price"    => $exists_service->rate,
					"type"        	    => $service_type,
					"changed"  	        => NOW,
				);

				/*----------  Calculate new price  ----------*/
				$rate = $exists_service->rate;
				$new_rate = round($rate + (($rate*$price_percentage_increase)/100), $decimal_places);
				if ($new_rate <= 0.004) {
					$new_rate = 0.01;
				}

				$data_service['price'] = $new_rate * $new_currency_rate;
				$this->db->update($this->tb_services, $data_service, ["api_service_id" => $exists_service->service, "api_provider_id" => $api->id]);
			}
		}

		/*----------  add new services  ----------*/
		if (!empty($new_services) && $request) {
			$i = 1;
			foreach ($new_services as $key => $new_service) {
				$category_name = trim($new_service->category);
				$check_category = $this->model->get("ids, id, name", $this->tb_categories, "name = '{$category_name}'");
				$service_type = strtolower(str_replace(" ", "_", $new_service->type));

				/*----------  Auto round up ----------*/
				$rate = $new_service->rate;
				$new_rate = round($rate + (($rate*$price_percentage_increase)/100), $decimal_places);
				if ($new_rate <= 0.004) {
					$new_rate = 0.01;
				}
				$data_service = array(
					"uid"             	=> session('uid'),
					"name"            	=> $new_service->name,
					"min"             	=> $new_service->min,
					"max"             	=> $new_service->max,
					"price"           	=> $new_rate * $new_currency_rate,
					"original_price"    => $rate,
					"add_type"        	=> 'api',
					"type"        	    => $service_type,
					"api_provider_id"  	=> $api->id,
					"api_service_id"  	=> $new_service->service,
					"dripfeed"  	    => $new_service->dripfeed,
					"ids"  				=> ids(),
					"status"  			=> 1,
					"changed"  			=> NOW,
					"created"  			=> NOW,
				);	

				if (!empty($check_category)) {
					$cate_id = $check_category->id;
					$data_service["cate_id"] = $cate_id;
				}else{
					/*----------  insert category  ----------*/
					$data_category = array(
						"ids"  			  => ids(),
						"uid"             => session('uid'),
						"name"            => $category_name,
						"sort"            => $i,
						"changed"         => NOW,
						"created"         => NOW,
					);
					$this->db->insert($this->tb_categories, $data_category);

					if ($this->db->affected_rows() > 0) {
						$cate_id = $this->db->insert_id();
						$data_service["cate_id"] = $cate_id;
					}
				}

				$data_service_batch[] 	= $data_service;
				++$i;
			}

			if (!empty($data_service_batch)) {
				$this->db->insert_batch($this->tb_services, $data_service_batch); 
			}
		}

		/*----------  update time for next update  ----------*/
		$rand_time = get_random_time("api");
		$this->db->update($this->tb_api_providers, ['changed' => date('Y-m-d H:i:s', strtotime(NOW) + $rand_time)], ['id' => $api->id]);

		$result = (object)array(
			'new_services' 		=> $new_services,
			'disabled_services' => $disabled_services,

		);
		return $result;
	}
	
	public function refill(){
	    echo "Yes i called";exit;
	}

	public function cron($type = ""){
		switch ($type) {
			case 'order':
				/*----------  Get all order through API  ----------*/
				$orders = $this->model->get_all_orders();
			//	pr($orders);exit;
				if (!empty($orders)) {
				    $i = 1;
					foreach ($orders as $key => $row) {
					    
						$api = $this->model->get("url, key", $this->tb_api_providers, ["id" => $row->api_provider_id] );
						if (!empty($api)) {
							$data_post = array(
								'key' 	   => $api->key,
					            'action'   => 'add',
					            'service'  => $row->api_service_id,
							);
                             //pr($data_post);exit;
							switch ($row->service_type) {
								case 'subscriptions':
									$data_post["username"] = $row->username;
									$data_post["min"]      = $row->sub_min;
									$data_post["max"]      = $row->sub_max;
									$data_post["posts"]    = ($row->sub_posts == -1) ? 0 : $row->sub_posts ;
									$data_post["delay"]    = $row->sub_delay;
									$data_post["expiry"]   = (!empty($row->sub_expiry))? date("d/m/Y",  strtotime($row->sub_expiry)) : "";//change date format dd/mm/YYYY
									break;

								case 'custom_comments':
									$data_post["link"]     = $row->link;
									$data_post["comments"] = json_decode($row->comments);
									break;

								case 'mentions_with_hashtags':
									$data_post["link"]         = $row->link;
									$data_post["quantity"]     = $row->quantity;
									$data_post["usernames"]    = $row->usernames;
									$data_post["hashtags"]     = $row->hashtags;
									break;

								case 'mentions_custom_list':
									$data_post["link"]         = $row->link;
									$data_post["usernames"]    = json_decode($row->usernames);
									break;

								case 'mentions_hashtag':
									$data_post["link"]         = $row->link;
									$data_post["quantity"]     = $row->quantity;
									$data_post["hashtag"]      = $row->hashtag;
									break;
									
								case 'mentions_user_followers':
									$data_post["link"]         = $row->link;
									$data_post["quantity"]     = $row->quantity;
									$data_post["username"]     = $row->username;
									break;

								case 'mentions_media_likers':
									$data_post["link"]         = $row->link;
									$data_post["quantity"]     = $row->quantity;
									$data_post["media"]        = $row->media;
									break;

								case 'package':
									$data_post["link"]         = $row->link;
									break;	

								case 'custom_comments_package':
									$data_post["link"]         = $row->link;
									$data_post["comments"]     = json_decode($row->comments);
									break;

								case 'comment_likes':
									$data_post["link"]         = $row->link;
									$data_post["quantity"]     = $row->quantity;
									$data_post["username"]     = $row->username;
									break;
								
								default:
                                    
									$data_post["link"] = $row->link;
									$data_post["quantity"] = $row->quantity;
									if (isset($row->is_drip_feed) && $row->is_drip_feed == 1) {
										$data_post["runs"]     = $row->runs;
										$data_post["interval"] = $row->interval;
										$data_post["quantity"] = $row->dripfeed_quantity;
									}else{
										$data_post["quantity"] = $row->quantity;
									}
									
									break;
							}
							/* check either order link already exists or not */
							if(isset($row->link) && $row->link != ''){
								$existLinkOrNot = $this->db->where('link',$row->link)
								->where('cate_id',$row->cate_id)
								->where('api_order_id >',0)
								->where_in('status',array('pending','processing','inprogress','awaiting'))
								->get($this->tb_orders);
								$numOfRecords = $existLinkOrNot->num_rows();
								//$numOfRecords = ()
							}else{
								$numOfRecords = 0;
							}    
						
							/* check either order link already exists or not */
							
							if($numOfRecords == 0){
							    
								$response = $this->connect_api($api->url, $data_post);
							if($i == 2){
							    //pr( $data_post);exit;
							}
							}else{
							    $response = '';
							}
							
							$response = json_decode($response);
							
							$i++;

							if (isset($response->error) && $response->error != "") {
								echo $response->error."<br>";
								$data = array(
									"note"        => $response->error,
									"changed"     => NOW,
								);
								$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
							}

							if (!empty($response->order) && $response->order != "") {
								$this->db->update($this->tb_orders, ["api_order_id" => $response->order, "changed" => NOW, "partial_orders" => $response->order], ["id" => $row->id]);
							}
						}else{
							echo "API Provider does not exists.<br>";
						}
					}

				}else{
					echo "There is no order at the present.<br>";
				}
				echo "Successfully";
				break;

			case 'status_subscriptions':
				$orders = $this->model->get_all_subscriptions_status();

				// Convert to new currency or not
				$new_currency_rate = get_option('new_currecry_rate', 1);
				if ($new_currency_rate == 0) {
					$new_currency_rate = 1;
				}

				if (!empty($orders)) {
					foreach ($orders as $key => $row) {
						$api = $this->model->get("id, url, key", $this->tb_api_providers, ["id" => $row->api_provider_id] );
						if (!empty($api)) {
							$data_post = array(
								'key' 	   => $api->key,
					            'action'   => 'status',
					            'order'    => $row->api_order_id,
							);
							$response = $this->connect_api($api->url, $data_post);
							$response = json_decode($response);
							if (isset($response->error) && $response->error != "") {
								echo $response->error."<br>";
								$data = array(
									"note"        => $response->error,
									"changed"     => NOW,
								);
								$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
							}
							if (!empty($response->status) && $response->status != "") {
								$rand_time = get_random_time();
								$data = array(
									"sub_status"        		=> $response->status,
								    "sub_response_orders" 	    => json_encode($response->orders),
								    "sub_response_posts" 	    => $response->posts,
								    "note" 	                    => "",
								    "changed"           		=> date('Y-m-d H:i:s', strtotime(NOW) + $rand_time),
								);

								if ($response->status == "Completed" || $response->status == "Canceled") {
									if ($response->status == "Completed") {
										$data["status"] = strtolower($response->status);
									}
									if ($response->status == "Canceled") {
										$data["status"] = 'canceled';
									}
									
								}

								if (!empty($response->orders)) {
									foreach ($response->orders as $key => $order_id) {
										$check_order = $this->model->get("api_order_id", $this->tb_orders, ["api_order_id" => $order_id, "api_provider_id" => $api->id]);

										$data_post_order = array(
											'key' 	   => $api->key,
								            'action'   => 'status',
								            'order'    => $order_id,
										);
										$response_order = $this->connect_api($api->url, $data_post_order);
										$response_order = json_decode($response_order);
										if (isset($response_order->status) && empty($check_order)) {
											$data_order = array(
												"ids" 	        	            => ids(),
												"uid" 	        	            => $row->uid,
												"cate_id" 	    	            => $row->cate_id,
												"service_id" 		            => $row->service_id,
												"service_type" 		            => "default",
												"link" 	        	            => "https://www.instagram.com/".$row->username,
												"quantity" 	    	            => ($response_order->remains > 0) ? $response_order->remains : 0,
												"remains" 	    	            => $response_order->remains,
												"start_counter" 	            => $response_order->start_count,
												"charge" 	    	            => $new_currency_rate * $response_order->charge,
												"api_provider_id"  	            => $row->api_provider_id,
												"api_service_id"  	            => $row->api_service_id,
												"api_order_id"  	            => $order_id,
												"status"			            => ($response_order->status == "In progress")? "inprogress" :  strtolower($response_order->status),
												"sub_response_posts"			=> 1,
												"changed" 	    	            => NOW,
												"created" 	    	            => NOW,
											);
											$this->db->insert($this->tb_orders, $data_order);
										}

									}

								}

								$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
							}

						}else{
							echo "API Provider does not exists.<br>";
						}
					}

				}else{
					echo "There is no order at the present.<br>";
				}
				echo "Successfully";
				break;

			case 'status':
				/*----------  Get all order through API  ----------*/
				$orders = $this->model->get_all_orders_status();
				//pr($orders);
				$default_price_percentage_increase = get_option("default_price_percentage_increase", 30);
				/*echo "<pre>";
                print_r($orders);*/
				// Convert to new currency or not
				$new_currency_rate = get_option('new_currecry_rate', 1);
				if ($new_currency_rate == 0) {
					$new_currency_rate = 1;
				}
				//pr($orders);exit;
				if (!empty($orders)) {
					foreach ($orders as $key => $row) {
					    $api = $this->model->get("url, key", $this->tb_api_providers, ["id" => $row->api_provider_id] );
					    //pr($api);exit;
						if (!empty($api)) {
							$data_post = array(
								'key' 	   => $api->key,
					            'action'   => 'status',
					            'order'    => $row->api_order_id,
							);
							$response = $this->connect_api($api->url, $data_post);
							
							//echo $response;
							$response = json_decode($response);
							if (isset($response->error) && $response->error != "") {
								echo $response->error."<br>";
								$data = array(
									"note"        => $response->error,
									"changed"     => NOW,
								);
								$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
							}

							if (isset($response->status) && $response->status != "") {
								if (!in_array($response->status, array('Completed', 'Processing', 'In progress', 'Partial', 'Canceled', 'Refunded', 'Completed'))) {
									$response->status = 'Pending';
								}
								$data = array();
								$rand_time = get_random_time();
								$remains = $response->remains;
								
								if ($remains < 0) {
									$remains = abs($remains);
									$remains = "+".$remains;
								}

								$data = array(
								    "start_counter" => $response->start_count,
								    "remains"       => $remains,
								    "note" 	        => "",
								    "changed"       => date('Y-m-d H:i:s', strtotime(NOW) + $rand_time),
								    "status"        => ($response->status == "In progress") ? "inprogress" :  strtolower($response->status),
								);
								if(isset($response->status) && $response->status == "Partial"){
									unset($data['start_counter']);
								}

								/*if (!empty($data)) {
									if ($row->sub_response_posts != 1 && ($response->status == "Refunded" ||$response->status == "Canceled" || $response->status == "Partial" )) {
										$charge = $row->charge;
										if ($response->status == "Partial") {
											$real_charge = $response->charge + (($response->charge*$default_price_percentage_increase)/100);
											$real_charge = $real_charge * $new_currency_rate;
											$charge =  $charge - $real_charge;
											$this->db->update($this->tb_orders, ['charge' => $real_charge], ["id" => $row->id]);
										}
									}
									$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
								}*/
								/* reset order in case order moves to partial */
								
								if (!empty($data)) {
								    //pr($row);
									if (($response->status == "Refunded" ||$response->status == "Canceled" || $response->status == "Partial" )) {
										$charge = $row->charge;
										if ($response->status == "Partial") {
											/* Create new order here*/
											$data_post_for_partial = array(
								'key' 	   => $api->key,
					            'action'   => 'add',
					            'service'  => $row->api_service_id,
							     );
							     $data_post_for_partial["link"] = $row->link;
								 $data_post_for_partial["quantity"] = $remains;
								 $adPartialOrderresponse = $this->connect_api($api->url, $data_post_for_partial);
							     $adPartialOrderresponse = json_decode($adPartialOrderresponse);

							if (isset($adPartialOrderresponse->error) && $adPartialOrderresponse->error != "") {
								$data = array(
									"note"        => $adPartialOrderresponse->error,
									"changed"     => NOW,
								);
								$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
							}

							if (!empty($adPartialOrderresponse->order) && $adPartialOrderresponse->order != "") {
							    $partialOrderDetails = $row->partial_orders.','.$adPartialOrderresponse->order;
							    
								$this->db->update($this->tb_orders, ["api_order_id" => $adPartialOrderresponse->order, "changed" => NOW, "partial_orders" => $partialOrderDetails], ["id" => $row->id]);
							}
											/* Create new order here*/	
										}
									}
									$this->db->update($this->tb_orders, $data, ["id" => $row->id]);
								}
								/* reset order in case order moves to partial */
							}

						}else{
							echo "API Provider does not exists.<br>";
						}
					}

				}else{
					echo "There is no order at the present.<br>";
				}
				echo "Successfully";
				break;
			case 'sync_services':
				ini_set('max_execution_time', 300000);

				/*----------  Get Default Auto sync services setting  ----------*/
				$defaut_auto_sync = get_option("defaut_auto_sync_service_setting", '{"price_percentage_increase":50,"sync_request":0,"new_currency_rate":"1","is_enable_sync_price":0,"is_convert_to_new_currency":0}');
				$defaut_auto_sync = json_decode($defaut_auto_sync);

				$price_percentage_increase = (isset($defaut_auto_sync->price_percentage_increase)) ? $defaut_auto_sync->price_percentage_increase : "";
    			$request = (isset($defaut_auto_sync->sync_request)) ? $defaut_auto_sync->sync_request : 0;
    			$new_currency_rate  = (isset($defaut_auto_sync->is_convert_to_new_currency) && $defaut_auto_sync->is_convert_to_new_currency) ? get_option('new_currecry_rate', 1) : 1;
    			$is_enable_sync_price = (isset($defaut_auto_sync->is_enable_sync_price)) ? $defaut_auto_sync->is_enable_sync_price : 0;
				$decimal_places            = get_option("auto_rounding_x_decimal_places", 2);

				$apis = $this->model->fetch("id, name, ids, url, key", $this->tb_api_providers, "`status` = 1 AND `changed` < '".NOW."' ", "changed", "ASC", 0, 2);
				if (!empty($apis)) {
					foreach ($apis as $key => $api) {
						$data_post = array(
							'key' => $api->key,
				            'action' => 'services',
						);
						$data_services = $this->connect_api($api->url, $data_post);
						$api_services = json_decode($data_services);
						if (empty($api_services) || !is_array($api_services)) {
							echo "<br> Error! There seems to be an issue connecting to SMM provider ".$api->name;
							continue;
						}

						$services = $this->model->fetch("`id`, `ids`, `uid`, `cate_id`, `name`, `desc`, `price`, `min`, `max`, `add_type`, `type`, `api_service_id` as service, `api_provider_id`, `dripfeed`, `status`, `changed`, `created`", $this->tb_services, ["api_provider_id" => $api->id, 'status' => 1]);

						if (empty($services) && !$request) {
							echo "<br> Error! Service lists are empty unable to sync services to".$api->name;
							continue;
						}

						$data_item = (object)array(
							'api' 			             => $api,
							'api_services'               => $api_services,
							'services'                   => $services,
							'price_percentage_increase'  => $price_percentage_increase,
							'request'                    => $request,
							'decimal_places'             => $decimal_places,
							'new_currency_rate'          => $new_currency_rate,
							'is_enable_sync_price'       => $is_enable_sync_price,

						);
						$this->sync_services_by_api($data_item);
						
					}

					echo "Successfully";
				}else{
					echo "There is no API providers at the present";
				}

			break;
		}
	}

	private function connect_api($url, $post = array("")) {
	    //echo $url;exit;
        $_post = Array();

        if (is_array($post)) {
          foreach ($post as $name => $value) {
            $_post[] = $name.'='.urlencode($value);
          }
        }

        if (is_array($post)) {
          $url_complete = join('&', $_post);
        }
        $url = $url."?".$url_complete;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'API (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
          $result = false;
        }
        curl_close($ch);
        //echo $result;exit;
        return $result;
    }

}