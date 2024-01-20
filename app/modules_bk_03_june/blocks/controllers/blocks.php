<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class blocks extends MX_Controller {
	

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		// call all services: 
		$this->load->model('services/services_model','services_md');
		// call all category: 
		$this->load->model('category/category_model','category_model');

		//Config Module
		$this->tb_tickets    		= TICKETS;
		$this->tb_users    		    = USERS;
		$this->tb_ticket_message    = TICKET_MESSAGES;

	}

	public function set_language(){
		set_language(post("id"));

		ms(array("status" => "success"));
	}

	public function header(){
		$data = array();
		$this->load->view('header', $data);
	}

	public function sidebar(){
		$data = array();
		$this->load->view('sidebar', $data);
	}	
	
	public function header_vertical(){
		$data = array(
        	'lang_current' => get_lang_code_defaut(),
        	'languages'    => $this->model->fetch('*', LANGUAGE_LIST,'status = 1'),
        );
		$this->load->view('header_vertical', $data);
	}	

	public function footer(){
		$data = array(
        	'lang_current' => get_lang_code_defaut(),
        	'languages'    => $this->model->fetch('*', LANGUAGE_LIST,'status = 1'),
        );
		$this->load->view('footer', $data);
	}	

	public function back_to_admin(){
		$user = $this->model->get("id, ids", $this->tb_users, ['id' => session('uid')]);
		if (empty($user)) {
			ms(array(
				'status'  => 'error',
				'message' => lang("There_was_an_error_processing_your_request_Please_try_again_later"),
			));
		}
		unset_session("uid_tmp");
		unset_session("user_current_info");
		if (!session('uid_tmp')) {
			ms(array(
				'status'  => 'success',
				'message' => lang("processing_"),
			));
		}
	}

	public function user_header(){
		$categories = $this->category_model->get_category_lists(true);
		$instagramCategories = $this->category_model->get_categories_by_social_network_id(1);
		$firstThree = [];
		$exceptFirstThree = [];
		$i = 0;
		foreach ($instagramCategories as $cat) {
			if($i < 3){
				$firstThree[] = $cat;
			}else{
				$exceptFirstThree[] = $cat;
			}
			$i++;
		}
		$data = array(
			'all_items'        => $categories,
			'firstThreeItems'  => $firstThree,
			'rest_items'       => $exceptFirstThree
		);
		$this->load->view("user/header", $data);
	}

	public function user_header_top($link = ''){

		$first_link = (object)array(
			'link'  => cn(),
			'name'  => 'Home'
		);
		
		$data = array(
			'first_link'  => $first_link,
			'second_link' => $link,
		);
		$this->load->view("user/header_top", $data);
	}

	public function empty_data(){
		$data = array();
		$this->load->view('empty_data', $data);
	}
}