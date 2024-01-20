<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class package_faq_model extends MY_Model {
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
		$this->tb_package_faq    = PACKAGE_FAQ;
		parent::__construct();
	}


	function get_package_faq_list($service_data = false){
		$data  = array();
		// get categories
		if (!get_role("admin") || !get_role("supporter")) {
			$this->db->where("status", "1");
		}
		$this->db->select("id, ids, name");
		$this->db->from($this->tb_categories);
		$this->db->order_by("sncate_id", 'ASC');

		$query = $this->db->get();
		$categories = $query->result();
		if(!empty($categories)){
			$i = 0;
			foreach ($categories as $key => $row) {
				$i++;
				// get services
				if ($i > 0) {
					
					if ($service_data) {
						$require_data = "*";
					}else{
						$require_data = "id";
					}

					if (get_role("admin") || get_role("supporter")) {
						$services = $this->model->fetch($require_data, $this->tb_package_faq, ['cat_id' => $row->id],'id', 'ASC');
					}else{
						$services = $this->model->fetch($require_data, $this->tb_package_faq, ["status" => 1, 'cat_id' => $row->id], 'id', 'ASC');
					}

					if(!empty($services)){
						$categories[$key]->is_exists_services = 1;
						if ($service_data) {
							$categories[$key]->services = $services;
						}
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
			$this->db->select('package_faqs.*,categories.id as categoryId,categories.name as catName');
			$this->db->from($this->tb_package_faq);
			$this->db->join($this->tb_categories, 'categories.id = package_faqs.cat_id');
			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`package_faqs`.`answer` LIKE '%".$k."%' ESCAPE '!' OR `package_faqs`.`question` LIKE '%".$k."%' ESCAPE '!' OR `categories`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}

			$this->db->where("package_faqs.status", 1);
			$this->db->order_by("package_faqs.id", 'DESC');
			$query = $this->db->get();
			$result = $query->result();

		}else{
			$this->db->select('package_faqs.*,categories.id as categoryId,categories.name as catName');
			$this->db->from($this->tb_package_faq);
			$this->db->join($this->tb_categories, 'categories.id = package_faqs.cat_id');
			if ($k != "" && strlen($k) >= 2) {
				$this->db->where("(`package_faqs`.`answer` LIKE '%".$k."%' ESCAPE '!' OR `package_faqs`.`question` LIKE '%".$k."%' ESCAPE '!' OR `categories`.`name` LIKE '%".$k."%' ESCAPE '!')");
			}
			
			$this->db->order_by("package_faqs.id", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

	function get_categories_list_by_social_network(){
		$data  = array();
		$this->db->select("id, ids, name");
		$this->db->from($this->tb_social_network);
		$this->db->order_by("sort", 'cate_id');
		$query = $this->db->get();
		$social_networks = $query->result();
		if(!empty($social_networks)){
			$i = 0;
			foreach ($social_networks as $key => $row) {
				$i++;
				if ($i > 0) {
					$categories = $this->model->fetch("id, ids, sncate_id, name", $this->tb_categories, ['sncate_id' => $row->id], 'id', 'ASC');
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
			$this->db->select('package_faqs.*,categories.id as categoryId,categories.name as catName');
			$this->db->from($this->tb_package_faq);
			$this->db->join($this->tb_categories, 'categories.id = package_faqs.cat_id');
			$this->db->where("package_faqs.cat_id", $id);
			$this->db->where("package_faqs.status", 1);
			$this->db->order_by("package_faqs.id", 'ASC');
			$query = $this->db->get();
			$result = $query->result();

		}else{
			$this->db->select('package_faqs.*,categories.id as categoryId,categories.name as catName');
			$this->db->from($this->tb_package_faq);
			$this->db->join($this->tb_categories, 'categories.id = package_faqs.cat_id');
			$this->db->where("package_faqs.cat_id", $id);
			$this->db->order_by("package_faqs.id", 'ASC');
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

}
