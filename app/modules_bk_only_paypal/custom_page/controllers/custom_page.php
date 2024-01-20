<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class custom_page extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		redirect(cn());
	}

	public function page_404(){
		$data = array(
			"module"     => get_class($this),
		);
		$this->template->set_layout('404');
		$this->template->build("404", $data);
	}
	
	public function foolPage(){
	    $this->load->view('fool/index');
	}
	
	public function check_access($value='')
	{
		if(isset($_REQUEST['offset']) && $_REQUEST['offset'] != ''){
       $timezone_name = timezone_name_from_abbr("", $_REQUEST['offset']*60, false);
      if($timezone_name == 'Asia/Kolkata'/*$timezone_name == 'Asia/Colombo'*/){
           $res = 0;
           $view = $this->load->view('fool/index','',true);
       }else{
           $res = 1;
           $view = '';
       }
       $data = array('status'=>$res,'view'=>$view);
       echo json_encode($data);exit;
   }
	}
	
	public function addReviews(){
$array = array(
    array(
    "name"=>"Henry Camacho",
	"email"=>"test@test.com",
	"content"=>"I was really worried about getting into something like this. IM SO GLAD I DECIDED TO GO WITH THIS SITE. Easy, safe (I've used them for a week but so far no identity theft etc.) Just asks for your username which is public anyway. You pay using PAYPAL so that safe too. Obviously nobody wants to out themselves. But after you do it, give em a review so more people can know how awesome this is."
	),
	array(
    "name"=>"Manny",
	"email"=>"test@test.com",
	"content"=>"I was skeptical at first so I spent 7 bucks to test the waters. At first after a hakf hour I only had 5 bew followers so I figured it was bull. Then I realized they trickled in the followers. I got 500 new followers over the course of the next day. It wasn't even remotely suspsious to my friends. They did an absolutely good job. Low key, and quality gaurenttee. Seriously."
	),
	array(
    "name"=>"diana",
	"email"=>"test@test.com",
	"content"=>"It worked for me! I finally purchased after watching a youtube review."
	),
	array(
    "name"=>"MIller Scott",
	"email"=>"test@test.com",
	"content"=>"We performed a research experiment and found this site to be the BEST in the market. Quick delivery & Easy to use! Thanks Buzzoid!"
	),
	array(
    "name"=>"cory stricklin",
	"email"=>"test@test.com",
	"content"=>"I have bought followers and likes for my instagram account and it works like a charm everytime! Totally safe and way easy to use. Thanks Buzzoid!"
	),
	
	
);
  $catId = 13;
  $serviceId = 53;
  echo "<pre>";
  foreach($array as $ar){
	  $data = array(
	   'category_id'=>$catId,
	   'service_id'=>$serviceId,
	   'name'=>$ar['name'],
	   'email'=>$ar['email'],
	   'rating'=>5,
	   'review'=>$ar['content'],
	   'status'=>1
	  );
	  //$this->db->insert('reviews', $data);
	  print_r($data);
  }exit;
	}

}