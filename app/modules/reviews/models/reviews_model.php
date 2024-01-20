<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reviews_model extends MY_Model {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_orders;
	public $tb_faqs;
	public $tb_reviews;

	public function __construct(){
		parent::__construct();
		//Config Module
		$this->tb_users      = USERS;
		$this->tb_categories = CATEGORIES;
		$this->tb_services   = SERVICES;
		$this->tb_orders     = ORDER;
		$this->tb_faqs       = FAQS;
		$this->tb_reviews    = REVIEWS;

	}

	function get_reviews(){
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		$this->db->select('*');
		$this->db->from($this->tb_reviews);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();

		if($query->result()){
			return $data = $query->result();
		}else{
			false;
		}
	}

	function get_reviews_with_join(){
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		$this->db->select('reviews.*,categories.id as category_id, categories.name as cat_name');
		$this->db->from($this->tb_reviews);
		$this->db->join($this->tb_categories, 'categories.id = reviews.category_id');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();

		if($query->result()){
			return $data = $query->result();
		}else{
			false;
		}
	}


	function save($dataTosave = array()){
		if(!empty($dataTosave)){
            $result = $this->db->insert($this->tb_reviews,$dataTosave);
            if($result){
            	return true;
            }else{
            	return false;
            }
		}else{
			return false;
		}
	}

	

	function get_review_by_ids($ids = ""){
		$this->db->select('*');
		$this->db->from($this->tb_reviews);
		$this->db->where("ids", $ids);
		$query = $this->db->get();
		$result = $query->row();
		if (!empty($result)) {
			return $result;
		}
		return false;
	}

	function get_categories_for_dropdown($ids = ""){
		$this->db->select('*');
		$this->db->from($this->tb_categories);
		$query = $this->db->get();
		$result = $query->result();
		$cats = array();
		if (!empty($result)) {
			foreach ($result as $cat) {
				$cats[$cat->id] = $cat->name;
			}
		}
		return $cats;
	}

	function get_search_faqs($k = ""){
		$k = trim(htmlspecialchars($k));
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		$this->db->select('reviews.*,categories.id as category_id, categories.name as cat_name');
		$this->db->from($this->tb_reviews);  
		$this->db->join($this->tb_categories, 'categories.id = reviews.category_id');
		if ($k != "" && strlen($k) >= 2) {
			$this->db->like("reviews.name", $k, 'both');
			$this->db->or_like("email", $k, 'both');
			$this->db->or_like("review", $k, 'both');
		}
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

}
