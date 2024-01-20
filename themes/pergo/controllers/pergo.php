<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class pergo extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');

		$this->template->set_layout('blank_page');
	}

	public function index(){

		$categories = $this->model->get_category_lists(true);
		if (!empty($categories)) {
			$first_category     = $categories[0]->categories;
			$first_category_url = $first_category[0]->url_slug;
		}

		if (get_option("enable_disable_homepage", 0)) {
			redirect(cn($first_category_url));
		}

		$data = array();
		if (isset($first_category_url)) {
			$data['first_category_url'] = $first_category_url;
		}
		$this->template->build('index', $data);
	}

	public function header($display_html = true){
		$data = array(
			'display_html' => $display_html,
		);

		if ($display_html) {
			$categories = $this->model->get_category_lists(true);
		$instagramCategories = $this->model->get_categories_by_social_network_id(1);
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
		$data['all_items'] = $categories;
		$data['firstThreeItems'] = $firstThree;
		$data['rest_items'] = $exceptFirstThree;
		}
		
		$this->load->view('blocks/header', $data);
	}

	public function footer($display_html = true){
		$data = array(
			'display_html' => $display_html,
			'lang_current' => get_lang_code_defaut(),
			'languages'    => $this->model->fetch("*", LANGUAGE_LIST, "status = 1")
		);
		$this->load->view('blocks/footer', $data);
	}

}