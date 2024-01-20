<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class package extends MX_Controller {
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
		$this->tb_categories      = CATEGORIES;
		$this->tb_services        = SERVICES;
		$this->tb_api_providers   = API_PROVIDERS;
		$this->tb_social_network  = SOCIAL_NETWORK_CATEGORIES;
	}

	public function index($cate_url_slug = ""){
		$cate_url_slug = addslashes(trim($cate_url_slug));
		if (get_role('admin')) {
			# code...
			$exists_cate = $this->model->get('id, ids, name,category_content, url_slug, page_title, meta_keywords, meta_description', $this->tb_categories, ['url_slug' => $cate_url_slug]);
		}else{
			$exists_cate = $this->model->get('id, ids, name,category_content, url_slug, page_title, meta_keywords, meta_description, created, changed', $this->tb_categories, ['url_slug' => $cate_url_slug , 'status' => 1]);

			$exists_service = $this->model->get('id, ids, cate_id,page_title, meta_keywords, meta_description, package_slug, image,description,name,quantity,price,original_price,min,max, created, changed', $this->tb_services, ['package_slug' => $cate_url_slug , 'status' => 1]);

		}
 
		if(empty($exists_cate) && empty($exists_service)){
			redirect(cn());
		}
        //pr($exists_cate);
		$services_by_cate_id = $this->model->fetch("*", $this->tb_services, ['cate_id' => (isset($exists_cate->id))?$exists_cate->id:0, 'status' => 1], 'price', 'ASC');
		//pr($services_by_cate_id);
		if(isset($exists_service) && !empty($exists_service)){
			$data = array(
			"module"                  => get_class($this),
			"service"                 => $exists_service,
			"page_title"              => $exists_service->page_title,
			"page_meta_keywords"      => $exists_service->meta_keywords,
			"page_meta_description"   => $exists_service->meta_description,
			"pageUrl"                 => cn($cate_url_slug),
			"poublishedAt"            => $exists_service->created,
			"modifiedAt"              => $exists_service->changed,
			"pageType"                => 'product'
		);
			$catId = $exists_service->cate_id;
		}else{
			$newServices = [];
			foreach ($services_by_cate_id as $service) {
				$productRating = $this->db->select('SUM(rating) as total,service_id,status')->where('status',1)->where('service_id',$service->id)->get('reviews')->row();
				$productCount  = $this->db->select('count(id) as count,service_id,status')->where('status',1)->where('service_id',$service->id)->get('reviews')->row();
				if($productRating->total != '' && $productCount->count != ''){
					$service->rating = ($productRating->total)/($productCount->count);
					$service->review_count = $productCount->count;
				}else{
					$service->rating = 0;
					$service->review_count = 0;
				}
				$newServices[] = $service;
			}
			$categoryReviewRating = $this->db->select('SUM(rating) as total,category_id,service_id,status')->where('status',1)->where('category_id',$exists_cate->id)->get('reviews')->row();
			$categoryReviewCount  = $this->db->select('count(id) as count,category_id,service_id,status')->where('status',1)->where('category_id',$exists_cate->id)->get('reviews')->row();

			if($categoryReviewRating->total != '' && $categoryReviewCount->count != ''){
					$categoryRating = $categoryReviewRating->total/$categoryReviewCount->count;
					$categoryCount  = $categoryReviewCount->count;
				}else{
					$categoryRating = 0;
					$categoryCount = 0;
				}
			$data = array(
			"module"                  => get_class($this),
			"category"                => $exists_cate,
			"services"                => $newServices,
			"page_title"              => $exists_cate->page_title,
			"page_meta_keywords"      => $exists_cate->meta_keywords,
			"page_meta_description"   => $exists_cate->meta_description,
			"category_rating"         => $categoryRating,
			"category_review_count"   => $categoryCount,
			"pageUrl"                 => cn($cate_url_slug),
			"poublishedAt"            => (isset($exists_cate->created))?$exists_cate->created:'',
			"modifiedAt"              => (isset($exists_cate->changed))?$exists_cate->changed:'',
			"pageType"                => 'main',
			//"productImage"            =>      
		);
		
			$catId = $exists_cate->id; 
		}
		
		$faqs            = $this->model->get_faqs_by_cat($catId);
		if(!empty($faqs)){
		    $data['faqs']     = array_chunk( $faqs,ceil(count($faqs)/2));
		}else{
		    $data['faqs']     = array();
		}
		if(isset($exists_service) && !empty($exists_service)){
		    //pr($exists_service);
			$productReviewRating = $this->db->select('SUM(rating) as total,category_id,service_id,status')->where('status',1)->where('service_id',$exists_service->id)->get('reviews')->row();
			$productReviewCount  = $this->db->select('count(id) as count,category_id,service_id,status')->where('status',1)->where('service_id',$exists_service->id)->get('reviews')->row();

			if($productReviewRating->total != '' && $productReviewCount->count != ''){
					$productRating = $productReviewRating->total/$productReviewCount->count;
					$productCount  = $productReviewCount->count;
				}else{
					$productRating = 0;
					$productCount  = 0;
				}
			$data['reviews'] = $this->model->get_reviews_by_product($exists_service->id);
			$data["product_rating"]        = $productRating;
			$data["product_review_count"]   = $productCount;
			$data["sku"] = $exists_service->id;
			$data["productImage"] = $exists_service->image;
			$data["offerPrice"] = $exists_service->price;
			$category = $this->db->where('id',$catId)->get('categories');
            if($category->num_rows() > 0){
            	$data['category'] = $category->row();
            }else{
            	$data['category'] = [];
            }
            //pr($data);exit;
			$this->template->set_layout('user');
		    $this->template->build("package_detail_page", $data);
		}else{
			$data['reviews'] = $this->model->get_reviews_by_cat($catId);
			//pr($data);
			$this->template->set_layout('user');
		    $this->template->build("index", $data);
		}
	}

	
}