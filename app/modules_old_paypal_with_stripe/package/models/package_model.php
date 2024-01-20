<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class package_model extends MY_Model {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_social_network;
	public $tb_package_faq;

	public function __construct(){
		$this->tb_categories     = CATEGORIES;
		$this->tb_services       = SERVICES;
		$this->tb_api_providers  = API_PROVIDERS;
		$this->tb_social_network = SOCIAL_NETWORK_CATEGORIES;
		$this->tb_reviews        = REVIEWS;
		$this->tb_package_faq    = PACKAGE_FAQ;
		parent::__construct();
	}


	function get_reviews_by_cat($catId = null){
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		$this->db->select('*');
		$this->db->from($this->tb_reviews);
		$this->db->where('category_id',$catId);
		$this->db->where("status", "1");
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();

		if($query->result()){
			return $data = $query->result();
		}else{
			false;
		}
	}

	public function get_reviews_by_product($value=''){
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		//echo $value;exit;
		$this->db->select('*');
		$this->db->from($this->tb_reviews);
		$this->db->where('service_id',$value);
		$this->db->where("status", "1");
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
        
		if($query->num_rows() > 0){
			//pr($query->result());
			return $query->result();
		}else{
			return [];
		}
	}

	function get_faqs_by_cat($catId = null){
		if (!get_role("admin")) {
			$this->db->where("status", "1");
		}
		$this->db->select('*');
		$this->db->from($this->tb_package_faq);
		$this->db->where('cat_id',$catId);
		$this->db->where("status", "1");
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();

		if($query->result()){
			return $data = $query->result();
		}else{
			false;
		}
	}


	function get_services_list(){
		$data  = array();
		// get categories
		if (get_role("user")) {
			$this->db->where("status", "1");
		}
		$this->db->select("id, ids, name");
		$this->db->from($this->tb_categories);
		$this->db->order_by("sort", 'ASC');

		$query = $this->db->get();
		$categories = $query->result();
		if(!empty($categories)){
			$i = 0;
			foreach ($categories as $key => $row) {
				$i++;
				// get services
				if ($i > 0) {
					if (get_role("user")) {
						$services = $this->model->fetch("id", $this->tb_services, ["status" => 1, 'cate_id' => $row->id], 'price', 'ASC');
					}else{
						$services = $this->model->fetch("id", $this->tb_services, ['cate_id' => $row->id],'price', 'ASC');
					}
					if(!empty($services)){
						$categories[$key]->is_exists_services = 1;
					}else{
						unset($categories[$key]);
					}
				}else{
					break;
				}
				
			}
		}
		return $categories;
	}

	function get_services_by_search($k){
		$k = trim(htmlspecialchars($k));

		if (get_role("user")) {
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`s`.`id` LIKE '%".$k."%' ESCAPE '!' OR `s`.`api_service_id` LIKE '%".$k."%' ESCAPE '!' OR  `s`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}

			$this->db->where("s.status", 1);
			$this->db->order_by("s.id", 'DESC');
			$query = $this->db->get();
			$result = $query->result();

		}else{
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`s`.`id` LIKE '%".$k."%' ESCAPE '!' OR `s`.`api_service_id` LIKE '%".$k."%' ESCAPE '!' OR  `s`.`name` LIKE '%".$k."%' ESCAPE '!' OR  `api`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}
			
			$this->db->order_by("s.id", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

	function get_categories_list_by_social_network(){
		$data  = array();
		$this->db->select("id, ids, name");
		$this->db->from($this->tb_social_network);
		$this->db->order_by("sort", 'ASC');
		$query = $this->db->get();
		$social_networks = $query->result();
		if(!empty($social_networks)){
			$i = 0;
			foreach ($social_networks as $key => $row) {
				$i++;
				if ($i > 0) {
					$categories = $this->model->fetch("id, ids,sncate_id, name, desc", $this->tb_categories, ['sncate_id' => $row->id], 'id', 'ASC');
					if(!empty($categories)){
						$social_networks[$key]->categories = $categories;
					}else{
						unset($social_networks[$key]);	
					}
				}else{
					break;
				}
			}
		}
		return array_values($social_networks);
	}

	function get_services_by_cate_id($id){
		if (get_role("user")) {
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');

			$this->db->where("s.cate_id", $id);
			$this->db->where("s.status", 1);
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();

		}else{
			$this->db->select('s.*, api.name as api_name');
			$this->db->from($this->tb_services." s");
			$this->db->join($this->tb_api_providers." api", "s.api_provider_id = api.id", 'left');
			
			$this->db->where("s.cate_id", $id);
			$this->db->order_by("s.price", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

}
