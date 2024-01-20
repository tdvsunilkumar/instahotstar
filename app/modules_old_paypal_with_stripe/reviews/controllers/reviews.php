<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class reviews extends MX_Controller {
	public $tb_reviews;
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_orders;
	public $tb_faqs;
	public $api_key;
	public $uid;

	public function __construct(){
		$this->load->model(get_class($this).'_model', 'model');
		//Config Module
		$this->tb_reviews    = REVIEWS;
		$this->tb_users      = USERS;
		$this->tb_categories = CATEGORIES;
		$this->tb_services   = SERVICES;
		$this->tb_orders     = ORDER;
		$this->tb_faqs       = FAQS;
		$this->columns = array(
			"category_id"   => 'Category',
			"name"     => 'Name',
			"email"    => 'Email',
			"rating"       => 'Rating',
			"review"     => 'Review',
			"status"=>'Status'
		);
	}

	public function index(){
		//echo "i am calling here";exit;
		$reviews = $this->model->get_reviews_with_join();
		$data = array(
			"module"     => get_class($this),
			"reviews"       => $reviews,
			"columns"    => $this->columns,
		);
		//pr($data);
		$this->template->build("index", $data);
	}

	public function store(){
		//pr($this->input->post());
		$config = array(
        array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'Required',
                ),
        ),
        array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => array(
                        'required' => 'Required',
                        'valid_email' => 'Invalid',
                ),
        ),
        array(
                'field' => 'rating',
                'label' => 'Rating',
                'rules' => 'required',
                'errors' => array(
                        'required' =>'Required',
                ),
        ),
        array(
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'required',
                'errors' => array(
                        'required' => 'Required'
                )
        )
);
      $errors = $this->form_validation->set_rules($config);
		 if ($this->form_validation->run() == FALSE){
		 	$result = array(
            'status' =>2,
            'errors'=> $errors->error_array()
		 	);
		 	echo json_encode($result);exit;
            }

      $reviewData = array(
      	    'ids'=>ids(),
     	  	'category_id'  => $this->input->post('category_id'),
     	  	'service_id'   => $this->input->post('service_id'),
     	  	'name'         => $this->input->post('name'),
     	  	'email'        => $this->input->post('email'),
     	  	'rating'       => $this->input->post('rating'),
            'review'       => $this->input->post('comment'),
     	  );  

      $result = $this->model->save($reviewData); 
      if($result){
         $response = array(
                        'status'=>1,
                        'message'=>'Review has been saved successfully.',
                        'class'=>'success'
                        );
      } else{
      	$response = array(
                        'status'=>3,
                        'message'=>'Review could not be saved.',
                        'class'=>'error'
                        );

      }

      echo json_encode($response);exit;
	}
	
	public function update($ids = ""){
		$faq = $this->model->get_review_by_ids($ids);
		$data = array(
			"module"   => get_class($this),
			"faq" => $faq,
			'ratings'=>array('1'=>'1 Star','2'=>'2 Star','3'=>'3 Star','4'=>'4 Star','5'=>'5 Star'),
			'categories'=>$this->model->get_categories_for_dropdown()
		);
		//pr($data);
		$this->template->build('update', $data);
	}

	public function ajax_update($ids = ""){
		$category 		= post("category_id");
		$name 		    = post("name");
		$email 	        = post("email");
		$rating 		= post("rating");
		$status 		= post("status");
		$review 		= post("review");

		if($category == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Category is required'
			));
		}

		if($name == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Name is required'
			));
		}

		if($email == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Email is required'
			));
		}
		if($rating == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Rating is required'
			));
		}
		if($status == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Status is required'
			));
		}
		if($review == ""){
			ms(array(
				"status"  => "error",
				"message" => 'Review is required'
			));
		}


		//
		$data = array(
			"category_id"   => $category,
			"name"          => $name,
			"email"         => $email,
			"rating"        => $rating,
			"review"        => $review,
			"status"        => $status
		);

		//pr($data);

		$check_item = $this->model->get("ids", $this->tb_reviews, "ids = '{$ids}'");
		
		if(empty($check_item)){
			$data["ids"]     = ids();
			$data["updated_at"] = NOW;
			$data["created_at"] = NOW;
			$this->db->insert($this->tb_reviews, $data);
		}else{
			$data["updated_at"] = NOW;
			$this->db->update($this->tb_reviews, $data, array("ids" => $check_item->ids));
		}
		
		if ($this->db->affected_rows() > 0) {
			ms(array(
				"status"  => "success",
				"message" => lang("Update_successfully")
			));
		}else{
			ms(array(
				"status"  => "error",
				"message" => lang("There_was_an_error_processing_your_request_Please_try_again_later")
			));
		}
		
	}
	
	public function ajax_search(){
		//echo "calli";exit;
		$k = post("k");
		$reviews = $this->model->get_search_faqs($k);
		$data = array(
			"module"     => get_class($this),
			"reviews"    => $reviews,
			"columns"    => $this->columns,
		);
		$this->load->view("ajax/search", $data);
	}

	public function ajax_delete_item($ids = ""){
		$this->model->delete($this->tb_reviews, $ids, false);
	}
}

