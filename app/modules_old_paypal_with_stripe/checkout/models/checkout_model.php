<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class checkout_model extends MY_Model {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_order;
	public $tb_social_network;
	public $tb_abonded_checkouts;

	public function __construct(){
		$this->tb_categories     = CATEGORIES;
		$this->tb_services       = SERVICES;
		$this->tb_api_providers  = API_PROVIDERS;
		$this->tb_order          = ORDER;
		$this->tb_social_network = SOCIAL_NETWORK_CATEGORIES;
		$this->tb_abonded_checkouts = ABONDED_CHECKOUT;
		parent::__construct();
	}
	
	
	public function getAbondedCheckRecords($date = ''){
		$this->db->where('cron_job_date_time',$date);
		$this->db->where('status',0);
        $result = $this->db->get($this->tb_abonded_checkouts)->result();
        return $result;
	}

	public function checkAbondedEmailEligibilty($emailAddress = '',$date = ''){
		$getLastEmailDuration  = strtotime("-".ABONDED_EMAIL_DURATION." hours", strtotime($date));
	    $getLastEmailDuration  = date('Y-m-d H:i', $getLastEmailDuration);
	    $this->db->where('cron_job_date_time >', $getLastEmailDuration);
        $this->db->where('cron_job_date_time <', $date);
        $this->db->where('email',$emailAddress);
        $this->db->where('status',0);
        $result = $this->db->get($this->tb_abonded_checkouts)->num_rows();
	    return $result;
	}

	public function saveAbondedData($data = array()){
		$result = $this->db->insert($this->tb_abonded_checkouts,$data);
	}
	
	public function updateAbondedData($data = array(),$email = ''){
		$this->db->where('email',$email);
		$this->db->update($this->tb_abonded_checkouts,$data);
	}

	function get_order_by_id($id){
		$this->db->select("o.id, o.quantity, o.service_id,o.link, s.name as service_name");
		$this->db->from($this->tb_order." o");
		$this->db->join($this->tb_services." s", "o.service_id = s.id", 'left');
		$this->db->where('o.id', $id);
		$query  = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function get_service_detail_by_ids($ids){
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where('ids', $ids);
		$query  = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function get_service_detail_by($id){
		$this->db->select('s.*, cate.required_field');
		$this->db->from($this->tb_services." s");
		$this->db->join($this->tb_categories." cate", "s.cate_id = cate.id", 'left');
		$this->db->where("s.id", $id);
		$this->db->where("s.status", 1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function get_previous_service_detail_by_id($id,$categoryId){
		//echo $id;exit;
		$this->db->select("*");
		$this->db->from($this->tb_services);
		$this->db->where('sort <', $id);
		$this->db->where('cate_id', $categoryId);
		$this->db->where('status', 1);
		//$this->db->where('id !=', 83);
		$this->db->order_by('sort','desc');
		$query  = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function get_category_detail_by($id = ''){
		$this->db->select('*');
		$this->db->from($this->tb_categories);
		$this->db->where("id", $id);
		$this->db->where("status", 1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function getCartItems($cartId = ''){
        $cartitems = $this->db->select(
        	'cart_products.*,carts.id as cartId,carts.product as cartProduct'
        )
        ->join("cart_products","cart_products.cart_id = carts.id")
        ->where('cart_products.cart_id',$cartId)
        ->get('carts');
     	$cartitems      = $cartitems->result();
     	return $cartitems;
	}
}
