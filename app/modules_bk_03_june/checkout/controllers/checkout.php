<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class checkout extends MX_Controller {
	public $tb_users;
	public $tb_categories;
	public $tb_services;
	public $tb_api_providers;
	public $tb_social_network;
	public $columns;
	public $module_name;
	public $module_icon;
	public $cart;
	public $cartproduct;

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
	    $this->lang->load('cardinity');
		//Config Module
		$this->tb_categories       = CATEGORIES;
		$this->tb_services         = SERVICES;
		$this->tb_api_providers    = API_PROVIDERS;
		$this->tb_social_network   = SOCIAL_NETWORK_CATEGORIES;
		$this->tb_transaction_logs = TRANSACTION_LOGS;
		$this->cart                = CART;
		$this->cartproduct         = CART_PRODUCT;
		$this->module_name         = 'Services';
		$this->module_icon         = "fa ft-users";

        if (get_role("admin") || get_role("supporter")) {
			$this->columns = array(
				"name"             => lang("Name"),
				"price"            => 'Price',
				"quantity"         => 'Quantity',
				"add_type"         => lang("Type"),
				"provider"         => lang("api_provider"),
				"api_service_id"   => lang("api_service_id"),
				"original_price"   => lang("rate_per_1000")."(".get_option("currency_symbol","").")",
				"min_max"          => lang("min__max_order"),
				"status"           => lang("Status"),
			);
		}
	}

	public function index(){
		$id = post('item_id');
		$item = $this->model->get_service_detail_by($id);
		if (empty($item)) {
			redirect(cn());
		}
		$data = array(
			"module"     => get_class($this),
			"item"		 => $item,
		);
		$this->template->set_layout('user');
		$this->template->build("index", $data);
	}

	public function selectproduct(){
		$orderFor = ORDER_FOR;
		$id = get('service');
		$item = $this->model->get_service_detail_by_ids($id);
		if (empty($item)) {
			redirect(cn());
		}
		//pr($item);
		$categoryId = (isset($item->cate_id))?$item->cate_id:0;
		$category   = $this->model->get_category_detail_by($categoryId);
		$previousProduct = $this->model->get_previous_service_detail_by_id((isset($item->sort))?$item->sort:0,$categoryId);
		//pr($previousProduct);
		$services_by_cate_id = $this->model->fetch("*", $this->tb_services, ['cate_id' => $categoryId], 'price', 'ASC');
		$selectList = [];
		foreach ($services_by_cate_id as $value) {
			$selectList[$value->ids] = $value->quantity.' '.$orderFor[$value->order_for]['for'].' | '.number_format((float)$value->price, 2, '.', '').' per month';
		}
		//$data['selectList'] = $selectList;
		$data = array(
			"module"           => get_class($this),
			"item"		       => $item,
			"service"          => $item,
			"selectList"       => $selectList,
			"orderFor"         => ORDER_FOR,
			"category"         => $category,
			"previous_package" => $previousProduct
		);
		$this->template->set_layout('user');
		$this->template->build("selectproduct", $data);
	}

	public function findTimeZoneThroughOffset($offset=''){
		$timezone_name = timezone_name_from_abbr("", $offset*60, false);
		return $timezone_name;
	}

	public function convertTimeZoneToAnother($newTimeZone = '', $dateTime = ''){
		$date = new DateTime($dateTime);
		$date->setTimezone(new DateTimeZone($newTimeZone));
		$newDateTime = $date->format('Y-m-d H:i');
        return  $newDateTime;
	}

	public function ajaxsubmitinstaaccount(){
        $account   = post("account");
		$email     = post("email");
		$package   = post("package");
        $tZoneOffset = post("timezone_offset");
        $tZname      = '';
        if($tZoneOffset != '' && $tZoneOffset != 0){
        	$tZname = $this->findTimeZoneThroughOffset($tZoneOffset);
        	//$tZname = 'America/Anchorage';
        }
		if ($account  == "" || $email == "") {
			ms(array(
				"status"  => "error", 
				"message" => lang('please_fill_in_the_required_fields')
			)); 
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	      	ms(array(
				'status'  => 'error',
				'message' => lang("invalid_email_format"),
			));
	    }

	    $result = (object) $this->getInstagramUserDetails($account);
	    if(isset($result->data->is_private) && $result->data->is_private == 1){
	    	ms(array(
				'status'  => 'error',
				'message' => 'Private accounts are not allowed.',
			));
	    }

	    $packageDetails = $this->model->get_service_detail_by_ids($package);
	    /* Save abonded checkout details*/

	    if($tZname != ''){
	    	$cLink = cn('checkout/selectproduct').'?service='.$package.'&email='.$email.'&username='.$account;
	    	$convTimeDate = $this->convertTimeZoneToAnother($tZname,date("Y-m-d H:i"));
	    	$afterTwenty  = strtotime(ABONDED_EMAIL_AFTER, strtotime($convTimeDate));
	    	$afterTwenty  = date('Y-m-d H:i', $afterTwenty);
	    	$afterTwentyInArizona = new DateTime($afterTwenty, new DateTimeZone($tZname));
	    	$afterTwentyInArizona->setTimezone(new DateTimeZone('America/Los_Angeles'));
	    	$afterTwentyInArizona = $afterTwentyInArizona->format('Y-m-d H:i');
	    	$resultACE = $this->model->checkAbondedEmailEligibilty($email,$afterTwentyInArizona);
            $abondedCheckOutDetails = array(
               'email'                 =>$email,
               'username'              =>$account,
               'checkout_link'         =>$cLink,
               'cron_job_date_time'    =>$afterTwentyInArizona,
               'customer_timezone'     =>$tZname,
               'service'               =>$package
            );
            //pr($abondedCheckOutDetails);
            if($resultACE == 0){
            	//echo 'call';exit;
                $this->model->saveAbondedData($abondedCheckOutDetails);
            }
	    }
	    /* Save abonded checkout details*/
	    if(isset($result->status) && $result->status == 200){
	    	$metaData = [
              'instaAccount' => $result->data,
              'email'=>$email
	    	];
            $instaAccountView = $this->template->loadSectionView("ajax_instagram_account_view", $metaData);
	    	ms(array(
              'status'=>'success',
              'view'=>$instaAccountView,
              'package'=>$package
	    	));
	    }else{
	    	ms(array(
				'status'  => 'error',
				'message' => 'Server error, Please try again',
			));
	    }


		
	}
	
	
	public function sendcheckoutabondedemail(){
		$datetimeInArizona = $this->convertTimeZoneToAnother('America/Los_Angeles',date("Y-m-d H:i"));
		$result = $this->model->getAbondedCheckRecords($datetimeInArizona);
		//pr($result);
		if(!empty($result)){
			foreach ($result as $checkout) {
				/* Send email to customer about abonded checkout. */
                $subject = get_option('missed_checkout_notification_send_to_customer_subject');
			    $message = get_option('missed_checkout_notification_send_to_customer_content');
			    $service = $this->model->get('*', $this->tb_services, ['ids' => $checkout->service, 'status' => 1]);
			    $merge_fields = array(
			    	    "{{account_link}}"        => 'https://www.instagram.com/'.$checkout->username,
				        "{{customer_email}}"      => $checkout->email,
	                    "{{account}}"             => $checkout->username,
	                    "{{amount}}"              => number_format((float)$service->price, 2, '.', ''),
	                    "{{package_name}}"        => $service->name,
	                    "{{manage_orders_link}}"  => $checkout->checkout_link,
			);
			    //pr($merge_fields);
			$template = [ 'subject' => $subject, 'message' => $message, 'merge_fields' => $merge_fields];
			if($checkout->customer_timezone != 'Asia/Kolkata' && $checkout->customer_timezone != '' && $checkout->customer_timezone != 'Asia/Colombo'){
			$check_send_email_issue = $this->model->send_mail_template($template, $checkout->email);
			}
				/* Send email to customer about abonded checkout. */
			}
		}
	}

	public function getInstagramUserDetailsFromCurl($value=''){
		$uri = 'https://www.iinstazood.com/api/getUserInfo/'.$value; 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri); // uri
	curl_setopt($ch, CURLOPT_POST, false); // POST
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // POST DATA
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN RESULT true
	curl_setopt($ch, CURLOPT_HEADER, 0); // RETURN HEADER false
	curl_setopt($ch, CURLOPT_NOBODY, 0); // NO RETURN BODY false / we need the body to return
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // VERIFY SSL HOST false
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // VERIFY SSL PEER false
	$result = json_decode(curl_exec($ch));

	return $result;

	}


	public function getInstagramPostsDetails($userNamePara='',$maxId = '',$mediaTypePara = 1){
        if($userNamePara != ''){
            $username = 'mathews_dacklin';
            $password = 'ankeee0130';
            $proxy = '';
            $security_code     = '';
            $verification_code = '';
            $login = true;
            try{
                $newObj = new Instagramapi($username,$password,$proxy,$login,$security_code,$verification_code);
                //pr($newObj);
                $res = $newObj->login();
                if(isset($res['status']) && $res['status'] == 'success'){
                $posts = $newObj->get_feed($userNamePara,$maxId);  
		$limit = 10;
	$i=0;
    $postsData = [];
    $videos    = [];
	foreach ($posts as $post) {
		if($i <= $limit){
		   $preview = (isset($post->code))?$post->code:'';	
		   $mediaType = (isset($post->media_type))?$post->media_type:'';	
           $mediaId = (isset($post->pk))?$post->pk:'';
           if($mediaTypePara == 1){
              if($mediaType == 8){
           	$craousal  = $post->carousel_media[0];
            $postPic = (isset($craousal->image_versions2->candidates[0]->url))?$craousal->image_versions2->candidates[0]->url:'';
           }else{
            $postPic = (isset($post->image_versions2->candidates[0]->url))?$post->image_versions2->candidates[0]->url:'';
           }
			}
		   if(isset($postPic) && $postPic != ''){
		     if(!in_array($postPic,$videos)){
		         $postsData[] = [
             'id'=>$mediaId,
             'image'=>$postPic,
             'preview'=>'https://www.instagram.com/p/'.$preview
           ];
		     }
		   	
		   }
		}
		$i++;
		# code...
	}//pr($postsData);exit;
	$response = [
        'status'=>200,
        'posts'=>$postsData
	];
                }else{
                    $response = array('status'=>400,'msg'=>'Not able to login');
                }
            }catch(Exception $e){
                $response = array('status'=>400,'msg'=>$e->getMessage);
            }
        }else{
            $response = array('status'=>400,'msg'=>'Username is required field');
        }
        
        return $response;
	}
	
	
	public function getInstagramVideosDetails($userNamePara='',$maxId = '',$mediaTypePara = 1){
        if($userNamePara != ''){
            $username = 'mathews_dacklin';
            $password = 'ankeee0130';
            $proxy = '';
            $security_code     = '';
            $verification_code = '';
            $login = true;
            try{
                $newObj = new Instagramapi($username,$password,$proxy,$login,$security_code,$verification_code);
                //pr($newObj);
                $res = $newObj->login();
                if(isset($res['status']) && $res['status'] == 'success'){
                $posts = $newObj->get_feed($userNamePara,$maxId);  
		$limit = 50;
	$i=0;
    $postsData = [];
	foreach ($posts as $post) {
		if($i <= $limit){
		   $preview = (isset($post->code))?$post->code:'';	
		   $mediaType = (isset($post->media_type))?$post->media_type:'';	
           $mediaId = (isset($post->pk))?$post->pk:'';
           if($mediaTypePara == 1){
              if($mediaType == 2){
           	$postPic = (isset($post->image_versions2->candidates[0]->url))?$post->image_versions2->candidates[0]->url:'';
           	 if(isset($postPic) && $postPic != ''){
		         $postsData[] = [
             'id'=>$mediaId,
             'image'=>$postPic,
             'preview'=>'https://www.instagram.com/p/'.$preview
           ];
		     
		   	
		   }
           }
			}
		  
		}
		$i++;
		# code...
	}//pr($postsData);exit;
	$response = [
        'status'=>200,
        'posts'=>$postsData
	];
                }else{
                    $response = array('status'=>400,'msg'=>'Not able to login');
                }
            }catch(Exception $e){
                $response = array('status'=>400,'msg'=>$e->getMessage);
            }
        }else{
            $response = array('status'=>400,'msg'=>'Username is required field');
        }
        
        return $response;
	}


	public function getInstagramPostsDetailsFromCurl($value='',$maxId = null,$mediaTypePara = 1){
		$uri = 'https://www.iinstazood.com/api/getPostsInfo?username='.$value.'&maxid='.$maxId; 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri); // uri
	curl_setopt($ch, CURLOPT_POST, false); // POST
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // POST DATA
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN RESULT true
	curl_setopt($ch, CURLOPT_HEADER, 0); // RETURN HEADER false
	curl_setopt($ch, CURLOPT_NOBODY, 0); // NO RETURN BODY false / we need the body to return
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // VERIFY SSL HOST false
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // VERIFY SSL PEER false
	$result = json_decode(curl_exec($ch));
	$postsData = [];
	if($result->status == 200){
		$limit = 10;
	$i=0;
	//pr($result->data);
	foreach ($result->data as $post) {
		//pr($post);
		if($i <= $limit){
			$mediaType = (isset($post->media_type))?$post->media_type:'';
           $mediaId = (isset($post->pk))?$post->pk:'';
           $preview = (isset($post->code))?$post->code:'';
			if($mediaTypePara == 1){
              if($mediaType == 8){
           	$craousal  = $post->carousel_media[0];
            $postPic = (isset($craousal->image_versions2->candidates[0]->url))?$craousal->image_versions2->candidates[0]->url:'';
           }else{
            $postPic = (isset($post->image_versions2->candidates[0]->url))?$post->image_versions2->candidates[0]->url:'';
           }
			}else{
              if($mediaType == 2){
           	$postPic = (isset($post->image_versions2->candidates[0]->url))?$post->image_versions2->candidates[0]->url:'';
           }
			}
		   if(isset($postPic) && $postPic != ''){
		   	$postsData[] = [
             'id'=>$mediaId,
             'image'=>$postPic,
             'preview'=>'https://www.instagram.com/p/'.$preview
           ];
		   }	
           
		}
		$i++;
		# code...
	}
	$response = [
        'status'=>200,
        'posts'=>$postsData
	];
	}else{
    $response = [
        'status'=>400,
        'posts'=>$postsData
	];
	}
	
	return $response;
	}

	public function postspagination($value=''){
		$maxId          = post("maxId");
		$account        = post("account");
		$type           = post("type");
		if($type == 'video'){
          $posts = $this->getInstagramVideosDetails($account,$maxId,1);
		}else{
           $posts = $this->getInstagramPostsDetails($account,$maxId,1);
		}
		
		if(isset($posts['status']) && $posts['status'] == 200){
			$data['posts'] = $posts['posts'];

		}else{
			$data['posts'] = [];

		}
		$paymentView = $this->template->loadSectionView("ajax_load_posts_pagination", $data);
			echo $paymentView;exit;
		
	}


	public function changepackage($value=''){
		$package          = post("package");
		$accountSelection = post("selectaccount");
		$socialuserid     = post("socialuserid");
        $packageDetails = $this->model->get_service_detail_by_ids($package);
        $category   = $this->model->get_category_detail_by((isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
        $orderFor = ORDER_FOR;
        $previousProduct = $this->model->get_previous_service_detail_by_id((isset($packageDetails->sort))?$packageDetails->sort:0,(isset($packageDetails->cate_id))?$packageDetails->cate_id:0);

		if(!empty($packageDetails)){
			$data = [
              'package'          => $packageDetails,
              'orderFor'         => $orderFor,
              'category'         => $category,
              'previous_package' => $previousProduct
	    	];
	    	$defaultView = $this->template->loadSectionView("ajax_selected_package", $data);
	    	if(isset($orderFor[$packageDetails->order_for]['orderType']) && $orderFor[$packageDetails->order_for]['orderType'] == 'multiple'){
	    	   if($accountSelection == 1){
	    	   	  if($packageDetails->order_for == 2){
	    	   	  	$posts = $this->getInstagramPostsDetails($socialuserid,null,1);
	    	   	  }elseif($packageDetails->order_for == 6){
                    $posts = $this->getInstagramVideosDetails($socialuserid,null,1);
	    	   	  }
	    	   	  
	    	   	  //pr($posts);	
	    	   	  if($posts['status'] == 200){
	    	   	  	$data['posts'] = $posts['posts'];
	    	   	  }else{
	    	   	  	$data['posts'] = [];	
	    	   	  }
	    	   	  
	    	   }else{
                  $data['posts'] = [];	
	    	   }	
	    	   //pr($posts);
               $paymentView = $this->template->loadSectionView("ajax_load_posts", $data);
	    	}else{
               $paymentView = $this->template->loadSectionView("ajax_payment_div_for_single", $data);
	    	}
	    	$response    = array(
				'status'  => 'success',
				'view1'    => $defaultView,
				'package' => $packageDetails->ids,
				'packageFor' => $orderFor[$packageDetails->order_for]['for']
			);
			if($accountSelection == 1){
				if(isset($orderFor[$packageDetails->order_for]['orderType']) && $orderFor[$packageDetails->order_for]['orderType'] == 'multiple'){
               $response['view3'] = $paymentView;
	    	}else{
               $response['view2'] = $paymentView;
	    	}
			}
	    	ms($response);
		}else{
			ms(array(
				'status'  => 'error',
				'data'    => 'Server error, Please try again',
			));
		}

	}

	public function applyCoupan($value=''){
		$package          = post('package');
		$cartId           = post('cart');
		$coupan           = post('coupan');
		$isCoupanApplied  = post('isCoupanApplied');
		$isOfferApplied   = post('isOfferApplied');
        $packageDetails   = $this->model->get_service_detail_by_ids($package);
        $data['category'] = $this->model->get_category_detail_by((isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
        $data['orderFor']      = ORDER_FOR;
        $previousProduct = $this->model->get_previous_service_detail_by_id((isset($packageDetails->sort))?$packageDetails->sort:0,(isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
        $data['previous_package'] = $previousProduct;
		if($isCoupanApplied == 0 && $isOfferApplied == 1){
		/* Update Cart Items */	
		//pr($data['previous_package']);
		if($cartId != 0){
           $this->updateCartItems($cartId,(isset($data['previous_package']->quantity))?$data['previous_package']->quantity:0,(isset($packageDetails->quantity))?$packageDetails->quantity:0,1);
		}	
		/* Update Cart Items */	
		$data['package'] = $packageDetails;
        $data['cart_id'] = $cartId;
        $data['cupan_apllied'] = 0;
        $data['offer_apllied'] = $isOfferApplied;
        $orderFor = ORDER_FOR;
		$paymentView = $this->template->loadSectionView("ajax_payment_div_for_single", $data);
		$response    = array(
				'status'  => 'success',
				'view'    => $paymentView,
				'package' => $packageDetails->ids,
				'packageFor' => $orderFor[$packageDetails->order_for]['for']
			);
		ms($response);
		}
		if($isCoupanApplied == 1 && $isOfferApplied == 0){
           if(isset($coupan) && $coupan == ''){
			ms(array(
				'status'  => 'error',
				'message'    => 'Invalid coupan',
			));
		}
		$packageDetails = $this->model->get_service_detail_by_ids($package);
		if(strtoupper($coupan) != strtoupper($packageDetails->coupan)){
			ms(array(
				'status'  => 'error',
				'message'    => 'Invalid coupan',
			));
		}
		$data['package'] = $packageDetails;
        $data['cart_id'] = $cartId;
        $data['cupan_apllied'] = 1;
        $orderFor = ORDER_FOR;
		$paymentView = $this->template->loadSectionView("ajax_payment_div_for_single", $data);
		$response    = array(
				'status'  => 'success',
				'view'    => $paymentView,
				'package' => $packageDetails->ids,
				'packageFor' => $orderFor[$packageDetails->order_for]['for']
			);
		ms($response);
		}
		if($isCoupanApplied == 1 && $isOfferApplied == 1){
         if(isset($coupan) && $coupan == ''){
			ms(array(
				'status'  => 'error',
				'message'    => 'Invalid coupan',
			));
		}
		$packageDetails = $this->model->get_service_detail_by_ids($package);
		if(strtoupper($coupan) != strtoupper($packageDetails->coupan)){
			ms(array(
				'status'  => 'error',
				'message'    => 'Invalid coupan',
			));
		}
		$data['package'] = $packageDetails;
        $data['cart_id'] = $cartId;
        $data['cupan_apllied'] = 1;
        $data['offer_apllied'] = $isOfferApplied;
        $orderFor = ORDER_FOR;
		$paymentView = $this->template->loadSectionView("ajax_payment_div_for_single", $data);
		$response    = array(
				'status'  => 'success',
				'view'    => $paymentView,
				'package' => $packageDetails->ids,
				'packageFor' => $orderFor[$packageDetails->order_for]['for']
			);
		ms($response);
		}
		
	}

     public function updateCartItems($cartId = '',$extra = '',$qty = '',$action = ''){
        //echo $extra;exit;
     	$cartitems      = $this->db->from('cart_products')->where('cart_id',$cartId)->get();
     	$cartitems      = $cartitems->result();
     	$cartItemCount  = count($cartitems);
     	$extraItems     = ceil($extra/$cartItemCount);
     	$qty            = ceil($qty/$cartItemCount);
     	//pr($cartitems);
		foreach ($cartitems as $item) {
			if($action == 1){
             $this->db->set('activities_count', ($extraItems+$qty));
			}else{
             $this->db->set('activities_count', $qty);
			}
			$this->db->where('id',$item->id);
			$this->db->update('cart_products');
		}
	}

	public function removeCoupan($value=''){
		$package          = post('package');
		$cartId           = post('cart');
		$coupan           = post('coupan');
		$isCoupanApplied  = post('isCoupanApplied');
		$isOfferApplied   = post('isOfferApplied'); 
		$orderFor = ORDER_FOR;
		$packageDetails   = $this->model->get_service_detail_by_ids($package);
		$data['category'] = $this->model->get_category_detail_by((isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
		$data['package']  = $packageDetails;
		$previousProduct = $this->model->get_previous_service_detail_by_id((isset($packageDetails->sort))?$packageDetails->sort:0,(isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
        $data['previous_package'] = $previousProduct;
        $data['cart_id']  = $cartId;
        $data['cupan_apllied'] = $isCoupanApplied;
        $data['offer_apllied'] = $isOfferApplied;
        $data['orderFor']      = $orderFor;
        if($isOfferApplied == 0){
		/* Update Cart Items */	
		if($cartId != 0){
           $this->updateCartItems($cartId,(isset($data['category']->offer_followers))?$data['category']->offer_followers:0,(isset($packageDetails->quantity))?$packageDetails->quantity:0,0);	
		}
		/* Update Cart Items */	
	    }
        
		$paymentView = $this->template->loadSectionView("ajax_payment_div_for_single", $data);
		$response    = array(
				'status'  => 'success',
				'view'    => $paymentView,
				'package' => $packageDetails->ids,
				'packageFor' => $orderFor[$packageDetails->order_for]['for']
			);
		ms($response);
	}

	public function get_payment_action($value=''){
		$package = post('package');
		$product = post('product');
		$account = post('account');
		$email   = post('email');
		$mediais = post('media');
		$totalAct= post('totalActivities');
		$packageDetails = $this->model->get_service_detail_by_ids($package);
        $media   = explode(";",$mediais);
		$cartdata = [
          'service_id'=>(isset($packageDetails->id))?$packageDetails->id:0,
          'instagram_account'=>$account,
          'email'=>$email,
          'product'=>$product
		];

		$this->db->insert($this->cart, $cartdata);
		$cartId = $this->db->insert_id();
		foreach ($media as $key => $value) {
			if($value != ''){
				$cartproductData = [
                 'cart_id'=>$cartId,
                 'media'=>$value,
                 'email'=>$email,
                 'instagram_account'=>$account,
                 'service_id'=>(isset($packageDetails->id))?$packageDetails->id:0,
                 'activities_count'=>$totalAct
				];
				$this->db->insert($this->cartproduct, $cartproductData);
			}
		}
		$data['orderFor'] = ORDER_FOR;
		$data['category'] = $this->model->get_category_detail_by((isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
		$data['package'] = $packageDetails;
        $data['cart_id'] = $cartId;
        $previousProduct = $this->model->get_previous_service_detail_by_id((isset($packageDetails->sort))?$packageDetails->sort:0,(isset($packageDetails->cate_id))?$packageDetails->cate_id:0);
        $data['previous_package'] = $previousProduct;
		$paymentView = $this->template->loadSectionView("ajax_payment_div_for_single", $data);

		echo $paymentView;exit;

	}

	public function getInstagramUserDetails($userNamePara = ''){
		//echo $userNamePara;exit;
		if($userNamePara != ''){
            $username = 'mathews_dacklin';
            $password = 'ankeee0130';
            $proxy = '';
            $security_code     = '';
            $verification_code = '';
            $login = true;
            try{
                $newObj = new Instagramapi($username,$password,$proxy,$login,$security_code,$verification_code);
                $res = $newObj->login();
               // pr($res);
                if(isset($res['status']) && $res['status'] == 'success'){
                $data = $newObj->search_username($userNamePara);
                if(isset($data[0])){
                    $data = $newObj->get_userinfo($data[0]->pk);
                    $response = array('status'=>200,'data'=>$data,'msg'=>'success');
                    //pr($data);
                }else{
                    $response = array('status'=>400,'msg'=>'invalid request');
                }
                }else{
                    $response = array('status'=>400,'msg'=>'Not able to login');
                }
            }catch(Exception $e){
                $response = array('status'=>400,'msg'=>$e->getMessage);
            }
        }else{
            $response = array('status'=>400,'msg'=>'Username is required field');
        }
        
        return $response;
	}

	public function getInstagramUserDetailsAPI($userNamePara = ''){
		//echo $userNamePara;exit;
		if($userNamePara != ''){
            $username = 'mathews_dacklin';
            $password = 'ankeee0130';
            $proxy = '';
            $security_code     = '';
            $verification_code = '';
            $login = true;
            try{
                $newObj = new Instagramapi($username,$password,$proxy,$login,$security_code,$verification_code);
                $res = $newObj->login();
               // pr($res);
                if(isset($res['status']) && $res['status'] == 'success'){
                $data = $newObj->search_username($userNamePara);
                if(isset($data[0])){
                    $data = $newObj->get_userinfo($data[0]->pk);
                    $response = array('status'=>200,'data'=>$data,'msg'=>'success');
                    //pr($data);
                }else{
                    $response = array('status'=>400,'msg'=>'invalid request');
                }
                }else{
                    $response = array('status'=>400,'msg'=>'Not able to login');
                }
            }catch(Exception $e){
                $response = array('status'=>400,'msg'=>$e->getMessage);
            }
        }else{
            $response = array('status'=>400,'msg'=>'Username is required field');
        }
        
        ms($response);
	}


	public function process(){
		//pr($this->input->post());
		$link            = post("link");
		$email           = post("email");
		$agree           = post("agree");
		$ids             = post('item_ids');
		$cart            = post('cart_id');
		$product         = post('product');
		$coupan          = post('coupan');
		$iscoupanApplied = post('coupan_applied');
		$offer_price     = post('offer_price');
		$offer_applied   = post('offer_applied');
		$payableAmount   = post('payableAmount');
		$extraActivities = post('extraActivities');


		$payment_method = post('payment_method');
		if ($link  == "" || $email == "") {
			ms(array(
				"status"  => "error", 
				"message" => lang('please_fill_in_the_required_fields')
			)); 
		}
		$link = strip_tags($link);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	      	ms(array(
				'status'  => 'error',
				'message' => lang("invalid_email_format"),
			));
	    }

		if (!$agree && post('card_number') == '') {
			ms(array(
				"status"  => "error",
				"message" => lang('please_agree_to_our_terms_of_services_before_placing_an_order')
			));
		}

		$item = $this->model->get('id, ids, price', $this->tb_services, ['ids' => $ids, 'status' => 1]);
		if (empty($item)) {
			ms(array(
				"status"  => "error",
				"message" => lang('services_does_not_exists')
			));
		}

		/*----------  Check payment method exists or non  ----------*/
		if ($payment_method == "" || $payment_method == "empty") {
			ms(array(
				"status"  => "error",
				"message" => lang('payments_method_do_not_exists_now_please_contact_us_for_more_details')
			));
		}
		
		$exists_payment_methods = get_payments_method();
		if (!in_array($payment_method, $exists_payment_methods)) {
			ms(array(
				"status"  => "error",
				"message" => lang('this_payment_does_not_exists_please_choose_another_payment')
			));
		}

		$is_active_payment = get_option('is_active_'.$payment_method, 0);
		if (!$is_active_payment) {
			ms(array(
				"status"  => "error",
				"message" => lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail')
			));
		}

		$cardData = array(
          'owner_name'=>post('owner_name'),
          'card_number'=>post('card_number'),
          'cvv'=>post('cvv'),
          'expiry_month'=>post('expiry_month'),
          'expiry_year'=>post('expiry_year')
		);
		

		$data = array(
			"module"             => get_class($this),
			'link'               => $link,
			'email'              => $email,
			'item_ids'           => $item->ids,
			'price'              => $item->price,
			'payment_method'     => $payment_method,
			'cart_id'            => $cart,
			'product'            => $product ,
			'coupan'             => $coupan,
			'iscoupanApplied'    => $iscoupanApplied,
			'offer_price'        => $offer_price,
			'offer_applied'      => $offer_applied,
			'payableAmount'      => $payableAmount,
			'extraActivities'    => $extraActivities
		);

		$mergedData = array_merge($data, $cardData/*, $arrayN, $arrayN*/);

		//pr($mergedData);
		require $payment_method.'.php';
		$payment_module = new $payment_method();
		$payment_module->create_payment($mergedData);
		/*if($payment_method == 'cardinity' && post('card_number') == ''){
             $payment_module->index($mergedData);
		}else{
			$payment_module->create_payment($mergedData);
		}*/
		
	}

	public function success(){
		$id = session("transaction_log_id");
		$transaction = $this->model->get("id, ids, uid,amount, order_id, transaction_id, transaction_fee", $this->tb_transaction_logs, ['id' => $id]);
		if (!empty($transaction)) {
			$order = $this->model->get_order_by_id($transaction->order_id);
			if (!empty($order)) {
				$order_detail = $order->quantity.' '.$order->service_name.' per order';
			}else{
				$order_detail = 'Empty';
			}

			$product = $this->model->get_service_detail_by((isset($order->service_id))?$order->service_id:0);
			//pr($product);
			$data = array(
				"module"        => get_class($this),
				"transaction"   => $transaction,
				"order_detail"  => $order_detail,
				"product"       => $product
			);
			//pr($data);
			unset_session("transaction_log_id");
			$this->template->set_layout('user');
			$this->template->build("payment_successfully", $data);
		}else{
			redirect(cn());
		}
	}

	public function unsuccess(){
		$data = array(
			"module"        => get_class($this),
		);
		$this->template->set_layout('user');
		$this->template->build("payment_unsuccessfully", $data);
	}
}