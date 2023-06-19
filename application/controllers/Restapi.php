<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'libraries/REST_Controller.php';
if(isset($_SERVER['HTTP_ORIGIN'])){
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
}
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		exit(0);
}
class Restapi extends REST_Controller{
	public function __construct(){
		parent :: __construct();
		$this->load->model('app_login');  
		$this->load->model('common_model');
	}
	public function user_register_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$mobile_number = @$data['mobile_number'];
		$otp = @$data['otp'];
		$response['status']=0;
		$response['message']='Mobile number required';
		if($mobile_number!=''){
			$check = $this->db->select('user_id')->get_where('users',array('phone'=>$mobile_number))->num_rows();
			if($check>0){
				$response['status']=0;
				$response['message']='Mobile number already registered';
			}else{
				if($otp==''){
					$otp = Generate_Otp();
					$data['otp'] = $otp; 
					$data['created_date']=date('Y-m-d');
					$check=$this->common_model->commonGet('temp_registrations','id',array('mobile_number'=>$mobile_number),'');
					if(empty($check)){
						$id=$this->common_model->commonInsert('temp_registrations',$data);
					}else{
						$id = $check['id'];
						$this->common_model->commonUpdate('temp_registrations',array('otp'=>$otp),array('id'=>$id));
					}
					$response['status']=1;
					$response['otp']=$otp;
					$response['restype'] = 'getotp';
					$response['message']='OTP sent to your mobile number';
					$MsgARR = array(
						'OTP'   =>  $otp
					);
					$msg=$this->common_model->Get_Temp_Content(1,$MsgARR);
					if($msg!=''){
						$this->common_model->sendSMS($mobile_number,$msg);
					}
				}else{
					$wh=array('otp'=>$otp,'mobile_number'=>$mobile_number);
					$Otp_Check = $this->db->select('id')->get_where('temp_registrations',$wh)->num_rows();
					if($Otp_Check>0){
						$regs = array(
							'phone'=>$mobile_number,
							'password'=>PassWord_Default()
						);
						$user_id = $this->common_model->commonInsert('users',$regs);
						$this->db->delete('temp_registrations',$wh);
						$wh = array('phone'=>$mobile_number);
						$Check_with_otp = $this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`,`status`,`apartment_id`, `block_id`, `flat_id`')->get_where('users',$wh)->row_array();
						$response['status']=1;
						$response['restype'] = 'validateotp';
						$response['user_data']=$Check_with_otp;
						$response['message']='Logined successfully';
					}else{
						$response['status']=0;
						$response['mobile_number']=$mobile_number;
						$response['message']='Invalid otp';
					}
				}
			}
		}
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function login_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$mobile_number = @$data['mobile_number'];
		$otp = @$data['otp'];
		$response['status']=0;
		$response['message']='Mobile number required';
		if($mobile_number!=''){
			$wh = array('phone'=>$mobile_number);
			$Check_Mobile = $this->db->select('user_id')->get_where('users',$wh)->num_rows();
			if($Check_Mobile>0){
				if($otp!=''){
					$wh = array_merge($wh,array('otp'=>$otp));
				}
				$Check_with_otp = $this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`,`status`,`apartment_id`, `block_id`, `flat_id`')->get_where('users',$wh)->row_array();
				if(!empty($Check_with_otp)){
					if($Check_with_otp['status']==1){
						if($otp!=''){
							$response['status']=1;
							$response['user_data']=$Check_with_otp;
							$response['message']='Logined successfully';
						}else{
							$otp = Generate_Otp();
							$Up['otp']=$otp;
							$this->common_model->commonUpdate('users',$Up,$wh);
							$MsgARR = array(
								'OTP'   =>  $otp
							);
							$Wh['phone']=$mobile_number;
							$Status = $this->common_model->commonCheck('users','user_id',$Wh);
							$msg=$this->common_model->Get_Temp_Content(2,$MsgARR);
							if($msg!=''){
								$this->common_model->sendSMS($mobile_number,$msg);
							}
							$response['status']=1;
							$response['otp']=$otp;
							$response['mobile_number']=$mobile_number;
							$response['message']='Enter otp';
						}
					}else{
						$response['status']=0;
						$response['message']='Your account was inactive status! Please contact admin';
					}
				}else{
					$response['status']=0;
					$response['message']='Invalid otp';
				}
			}else {
				$response['status']=0;
				$response['message']='Invalid mobilenumber';
			}
		}
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function resend_otp_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$mobile_number = @$data['mobile_number'];
		$type = @$data['type'];
		$response['status']=0;
		$response['message']='Mobile number and type were required';
		$Status=0;
		$msg='';
		if($mobile_number!='' && $type!=''){
			$otp = Generate_Otp();
			$Up['otp']=$otp;
			$MsgARR = array(
				'OTP'   =>  $otp
			);
			if($type=='reg'){
				$Wh['mobile_number']=$mobile_number;
				$Status = $this->common_model->commonCheck('temp_registrations','id',$Wh);
				$this->db->update('temp_registrations',$Up,$Wh);
				$msg=$this->common_model->Get_Temp_Content(4,$MsgARR);
			}else{
				if($type=='login'){
					$Wh['phone']=$mobile_number;
					$Status = $this->common_model->commonCheck('users','user_id',$Wh);
					$msg=$this->common_model->Get_Temp_Content(5,$MsgARR);
				}else{
					$Wh['phone_2']=$mobile_number;
					$Status = $this->common_model->commonCheck('users','user_id',$Wh);
					$msg=$this->common_model->Get_Temp_Content(6,$MsgARR);
				}
				if($msg!=''){
					$this->common_model->sendSMS($mobile_number,$msg);
				}
				$this->db->update('users',$Up,$Wh);
			}
			if($msg!=''){
				$this->common_model->sendSMS($mobile_number,$msg);
			}
			if($Status>0){
				$response['status']=1;
				$response['otp']=$otp;
				$response['mobile_number']=$mobile_number;
				$response['message']='Otp generated successfully';
			}else{
				$response['status']=0;
				$response['message']='Mobile number not existed';
			}
		}
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function add_user_address_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$user_id = @$data['user_id'];
		$type = @$data['appartment_id'];
		$block = @$data['block'];
		$floor = @$data['floor'];

		if($res>0){
			$response['status']=1;
			$response['message']='Address added successfully';
		}else{
			$response['status']=0;
			$response['message']='Adding failed try again';
		}
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function user_all_addresses_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$user_id = $data['user_id'];
		$response['status']=1;
		$response['address'] = $this->db->query("SELECT `user_address_id`, `user_id`, `mobile_no`, `floor_no`, `block_no`, `appartment`, `street_name`, `area_name`, `pincode`, `landmark`, `status`, `created_date`, `updated_date` FROM `user_address` WHERE `user_id`=$user_id")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_address_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$user_address_id = $data['user_address_id'];
		$response['status']=1;
		$response['address'] = $this->db->query("SELECT `user_address_id`, `user_id`, `mobile_no`, `floor_no`, `block_no`, `appartment`, `street_name`, `area_name`, `pincode`, `landmark`, `status`, `created_date`, `updated_date` FROM `user_address` WHERE `user_address_id`=$user_address_id")->row_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_locations_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$response['status']=1;
		$response['locations'] = $this->db->query("SELECT `loc_id`, `title`, `icon`, `created_date`, `updated_date` FROM `locations`")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_location_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$loc_id = $data['loc_id'];
		$response['status']=1;
		$response['location'] = $this->db->query("SELECT `loc_id`, `title`, `icon`, `created_date`, `updated_date` FROM `locations` WHERE loc_id=$loc_id")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function home_banner_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$response['status']=1;
		$response['banners'] = $this->db->query("SELECT `banner_id`, `title`, `icon`, `status`, `created_date`, `updated_date` FROM `banners` WHERE status=1")->row_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_banner_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$banner_id = $data['banner_id'];
		$response['status']=1;
		$response['banners'] = $this->db->query("SELECT `banner_id`, `title`, `icon`, `status`, `created_date`, `updated_date` FROM `banners` WHERE banner_id=$banner_id")->row_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_sliders_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$response['status']=1;
		$response['sliders'] = $this->db->query("SELECT `slider_id`, `title`, `icon`, `status`, `created_date`, `updated_date` FROM `sliders` WHERE `status`=1")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_slider_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;	
		$slider_id = $data['slider_id'];
		$response['status']=1;
		$response['slider'] = $this->db->query("SELECT `slider_id`, `title`, `icon`, `status`, `created_date`, `updated_date` FROM `sliders` WHERE `slider_id`=$slider_id")->row_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_categories_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$keyword = @$data['keyword'];
		$and='';
		if($keyword!=''){
		    $and .= " AND  (title LIKE '%$keyword%' OR brands LIKE '%$keyword%') ";
		}
		$response['status']=1;	
		$response['categories']=$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`,categories,(SELECT COUNT(`prod_id`) FROM `products` WHERE `prod_category`=`cat_id`) as products_count,is_brands_available,brands FROM `categories` WHERE status=1 $and")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_sub_categories_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$keyword = @$data['keyword'];
		$cat_id = @$data['cat_id'];
		$user_id = @$data['user_id'];
		$and=' WHERE a.status=1 ';
		if($keyword!=''){
		    $and .= " AND  (a.title LIKE '%$keyword%' OR b.title LIKE '%$keyword%') ";
		}
		if($cat_id!=''){
			$and .= " AND a.cat_id=$cat_id ";
		}
		$response['status']=1;	
		$categories=$this->db->query("SELECT a.`sub_cat_id`, a.`cat_id`, a.`title`, a.`icon`, a.`status`, a.`created_date`, a.`updated_date`, a.`is_brands_available`, a.`brands`,b.title as cat_title,(SELECT COUNT(`prod_id`) FROM `products` WHERE `sub_cat_id`=a.`sub_cat_id`) as products_count FROM `sub_categories` a LEFT JOIN categories b ON a.`cat_id`=b.cat_id $and")->result_array();
		$Cats=array();
		if(count($categories)>0){
		    foreach($categories as $k=>$ct){
		        $prod_category =  $ct['cat_id'];
		        $prod_sub_category = $ct['sub_cat_id'];
		        $ct['products'] = $this->db->query("SELECT a.`prod_id`,a.prod_brand,a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,a.available_subscraibe,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_category=$prod_category AND a.prod_sub_category=$prod_sub_category")->result_array();
		        $ct['banners'] = $this->db->query("SELECT `id`, `page`, `module`, `title`, `image`, `description`, `prods`, `is_active`, `created_at`, `updated_at` FROM `prod_offer_banners` WHERE `module`=$prod_sub_category")->result_array();
				$Cats[] = $ct;
		    }
		}
		$response['categories']=$Cats;
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_category_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$cat_id = $data['cat_id'];
		$response['status']=1;	
		$response['categories']=$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`,(SELECT COUNT(`prod_id`) FROM `products` WHERE `prod_category`=`cat_id`) as products_count, is_brands_available,brands FROM `categories` WHERE cat_id=$cat_id")->row_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_products_with_and_without_cats_brands_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$cat_id = @$data['cat_id'];
		$sub_cat_id = @$data['sub_cat_id'];
		$keyword = @$data['keyword'];
		$user_id = @$data['user_id'];
		$loc_id  = @$data['loc_id'];
		$brand_id  = @$data['brand_id'];
		if($user_id==''){
			$user_id = 0;
		}
		$response['status']=1;	
		$and = "a.`prod_status`=1";
		if($cat_id!=''){
			$and .= " AND a.prod_category = $cat_id ";
		}
		if($brand_id!=''){
			$and .= " AND a.prod_brand = $brand_id ";
		}
		if($keyword!=''){
			$and .= " AND a.prod_title LIKE '%$keyword%' ";
		}
		if($sub_cat_id!=''){
			$and .= " AND a.prod_sub_category LIKE '%$sub_cat_id%' ";
		}
		if($loc_id!=''){
			$and .= " AND FIND_IN_SET('prod_available_locations',$loc_id) ";
		}
        if($cat_id!=''){
            $Sub = $this->db->query("SELECT `sub_cat_id`, `cat_id`, `title`, `icon` FROM `sub_categories` WHERE `status`=1 AND `cat_id`=$cat_id")->result_array();
            $cat_title=$this->db->query("SELECT `title` FROM `categories` WHERE `cat_id`=$cat_id")->row_array();
            $response['cat_title']=$cat_title['title'];
        }else{
            $Sub = [];
            $response['cat_title']='';
        }
        //$response['subcats'] = $Sub;
		$response['products']=$this->db->query("SELECT a.`prod_id`,a.prod_brand,a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,a.available_subscraibe,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE $and")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function popular_products_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$user_id = @$data['user_id'];
		if($user_id==''){
			$user_id = 0;
		}
		$response['status']=1;
		$response['products']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 AND a.is_popular=1 ORDER BY a.orders_count DESC")->result_array();
		$response['product_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='products'")->result_array();
		$response['deals_of_the_day']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 ORDER BY a.orders_count DESC")->result_array();
		$response['deal_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='deal'")->result_array();
		$response['best_selling']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 ORDER BY a.orders_count DESC")->result_array();
		$response['best_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='best'")->result_array();
		$response['offers_for_you']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 ORDER BY a.orders_count DESC")->result_array();
		//$response['offers_for_you']=$this->db->query("SELECT `id`, `name`, `code`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `status`, `use_for`, `created_at`, `updated_at`, `deleted_at` FROM `coupon` WHERE (CURDATE() BETWEEN `start_date` AND `end_date`) AND `use_for` IN (0,$user_id)")->result_array();
		$response['offer_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='subc'")->result_array();
		$response['subscriptions']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 AND a.available_subscraibe=1 ORDER BY a.orders_count DESC")->result_array();
		$response['subscription_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='offer'")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function offer_banner_products_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$user_id = @$data['user_id'];
		$banner_id = @$data['banner_id'];
		if($user_id==''){
			$user_id = 0;
		}
		$response['page_title']=$this->db->query("SELECT `title` FROM `prod_offer_banners` WHERE `id`=$banner_id")->row()->title;
		$response['products']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 AND a.is_popular=1 ORDER BY a.orders_count DESC")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_product_post(){
		$data 	= 	json_decode(file_get_contents("php://input"),true);
		$data	=	(isset($data))? $data : $_POST;
		$prod_id = $data['prod_id'];
		$user_id = @$data['user_id'];
		if($user_id==''){
			$user_id = 0;
		}
		$response['status']	=	1;	
		$response['products']	=	$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`,a.`prod_description`, a.`prod_available_locations`,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_id=$prod_id")->row_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function add_or_remove_from_product_favourate_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$prod_id 	= 	$data['prod_id'];
		$user_id 	= 	@$data['user_id'];
		$check		=	$this->db->select("favourate_id")->get_where('favourate_products',array('product_id'=>$prod_id,'user_id'=>$user_id))->num_rows();
		if($check>0){
			$response['status']	=	1;	
			$response['message']	=	'Remove from the favourate successfully';
			$Ins = array('product_id'=>$prod_id,'user_id'=>$user_id);
			$this->common_model->commonDelete('favourate_products',$Ins);	
		}else{
			$response['status']	=	1;	
			$response['message']	=	'Added to favourated successfully';
			$Ins = array('product_id'=>$prod_id,'user_id'=>$user_id,'created_date'=>date('Y-m-d H:i:s'));
			$this->common_model->commonInsert('favourate_products',$Ins);	
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function get_product_favourate_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$user_id 	= 	@$data['user_id'];
		$user_id = ($user_id=='')?0:$user_id;
		$keyword 	= 	@$data['keyword'];
		$response['status']=1;	
		$and = "a.`prod_status`=1";
		if($keyword!=''){
			$and .= " AND a.prod_title LIKE '%$keyword%' ";
		}
		$prods = $this->db->query("SELECT GROUP_CONCAT(`product_id`) AS prods  FROM `favourate_products` WHERE `user_id`=$user_id")->row_array();
		$def[]=0;
		$all_pro = (!empty($prods))?$prods['prods']:$def;
		if(!empty($all_pro))
		{
		    $and .= " AND a.`prod_id` IN ($all_pro) ";
		}
		$response['products']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,b.title AS cat_title,br.brand_title,a.available_subscraibe,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not ,'1' as favourate_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN category_brands br ON br.brand_id=a.prod_brand LEFT join `favourate_products` f on f.product_id = a.prod_id  WHERE $and AND f.`user_id`=$user_id")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function get_scanned_products_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$scanner_id 	= 	@$data['barcode_id'];
		if($scanner_id!=''){
			$user_id 	= 	@$data['user_id'];
			$keyword 	= 	@$data['keyword'];
			$response['status']=1;	
			$prods = $this->db->query("SELECT `prod_ids` FROM `scan_prods` WHERE `scanner_id`=$scanner_id")->row_array();
			$def=0;
			$all_pro = (!empty($prods))?str_replace('##',',',$prods['prod_ids']):$def;
			$and = " a.`prod_id` IN ($all_pro) ";
			$response['products']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`,a.prod_category, a.`prod_available_locations`,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN category_brands br ON br.brand_id=a.prod_brand WHERE $and")->result_array();
		}else{
			$response['status']=0;	
			$response['message']='Barcode not working contact admin';
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function add_amount_to_wallet_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$amount 	= $data['amount'];
		$type 		= $data['type'];
		$user_id 	= $data['user_id'];
		$description = @$data['description'];
		$Amount = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
		$balance=$amount;
		if(!empty($Amount)){
		    $balance = $Amount['final_wallet_amount']+$amount;
		}
		$Insert = array(
			'amount'=>$amount,
			'type'=>$type,
			'balance'=>$balance,
			'user_id'=>$user_id,
			'transaction_id' => Transaction_Id(),
			'created_date'=>date('Y-m-d H:i:s')
		);
		$description = 'Recharge';
		if($description!=''){
		    $sec=array('description'=>$description);
		    $Insert=array_merge($Insert,$sec);
		}
		$this->db->insert('user_wallet',$Insert);
		$this->db->query("UPDATE `users` SET `final_wallet_amount`=`final_wallet_amount`+$amount WHERE `user_id`=$user_id");
		$response['status']=1;	
		$response['message']='Added successfully';	
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function check_prod_qty_available_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$prod_id    =   $data['prod_id'];
		$mes_id 		=   $data['mes_id'];
		$qty 		=   $data['qty'];
		$avilable = $this->db->query("SELECT `prod_id` FROM `product_mesurments` WHERE `prod_id`=$prod_id AND `prod_available_qty`>=$qty")->num_rows();
		if($avilable==0){
			$response['status']=0;
			$response['message']='Quantity not available';
		}else{
			$response['status']=1;
			$response['message']='Quantity available';
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function update_user_details_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$user_id    =   $data['user_id'];
		$fname      =   @$data['fname'];
		$lname      =   @$data['lname'];
		$name		= trim($fname." ".$lname);
		$email      =   trim($data['email']);
		$phone      =   @$data['phone'];
		$profile_pic = @$data['profile_pic'];
		$file='';
	    if($profile_pic!=''){
			unset($data['profile_pic']);
			$file='profile'.time().'.jpg';
			$ree=file_put_contents('assets/images/'.$file, base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$profile_pic)));
		}
		$profile_pic = $file;
		if($user_id!='' && $phone!=''){
    		$apartment_id = @$data['apartment_id'];
            $block_id   = @$data['block_id'];
            $flat_id = @$data['flat_id'];
    		$otp	=	@$data['otp'];
            $existed    = $this->db->select('user_id')->get_where('users',array('email'=>$email,'user_id!='=>$user_id))->num_rows();
    		$Final_status=0;
    		if($existed==0){
    		    $CheckPhone = $this->common_model->commonCheck('users','user_id',array('phone'=>$phone));
    			if($CheckPhone>0){
    					$insert = array('name'=>$name,'fname'=>$fname,'lname'=>$lname,'phone'=>$phone,'email'=>$email,'phone_2'=>'');
    					if($file!=''){
    					    $insert = array_merge(array('profile_pic'=>$profile_pic),$insert);
    					}
    					$check=$this->db->update('users',$insert,array('user_id'=>$user_id));
    					$response['status'] = 1;
    					$wh = array('user_id'=>$user_id);
    					$response['user_data'] = $this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`,`status`,`apartment_id`, `block_id`, `flat_id`')->get_where('users',$wh)->row_array();
    					$response['message']='Updated successfully';
    				
    			}else{
    			    if($otp==''){
        				$otp = Generate_Otp();
        				$UpUser['otp']=$otp;
        				$UpUser['phone_2']=$phone;
        				$MsgARR = array(
        					'OTP'   =>  $otp
        				);
        				$WhereUs = array('user_id'=>$user_id);
        				$this->common_model->commonUpdate('users',$UpUser,$WhereUs);
        				$Status = $this->common_model->commonCheck('users','user_id',$WhereUs);
        				$msg=$this->common_model->Get_Temp_Content(3,$MsgARR);
        				$response['status']     =   1;
        				$response['otp']        =   $otp;
        				$response['user_id']    =   $data['user_id'];
        				$response['fname']      =   @$data['fname'];
        				$response['lname']      =   @$data['lname'];
        				$response['email']      =   trim($data['email']);
        				$response['phone']      =   $data['phone'];
        				$response['message']    =   'Enter otp';
    			    }else{
                        $CheckPhone_2 = $this->common_model->commonCheck('users','user_id',array('otp'=>$otp,'phone_2'=>$phone));
                        if($CheckPhone_2>0){
                            $insert = array('name'=>$name,'fname'=>$fname,'lname'=>$lname,'phone'=>$phone,'email'=>$email,'phone_2'=>'');
                            if($file!=''){
                            $insert = array_merge(array('profile_pic'=>$profile_pic),$insert);
                            }
                            $check=$this->db->update('users',$insert,array('user_id'=>$user_id));
                            $response['status'] = 1;
                            $wh = array('user_id'=>$user_id);
                            $response['user_data'] = $this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`,`status`,`apartment_id`, `block_id`, `flat_id`')->get_where('users',$wh)->row_array();
                            $response['message']='Updated successfully';
                        }else{
                            $response['status']=0;
    				 		$response['user_id']=$user_id;
    				 		$response['message']='Invalid otp';
                        }
    			    }
    			}
    		}else{
    		    $response['status']=0;
        		$response['message']='Email already existed enter another one';
    		}
		}else{
		    if($user_id!=''){
		        $WhereUs = array('user_id'=>$user_id);
                $insert = array('name'=>$name,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone_2'=>'');
                if($file!=''){
				    $insert = array_merge(array('profile_pic'=>$profile_pic),$insert);
				}
                $check=$this->db->update('users',$insert,array('user_id'=>$user_id));
                $response['status'] = 1;
                $response['user_data'] = $this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`,`status`,`apartment_id`, `block_id`, `flat_id`')->get_where('users',$WhereUs)->row_array();
                $response['message']='Updated successfully';
		    }else{
		        $response['status']=0;
        		$response['message']='User id required';
		    }
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function changepassword_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$user_id    =   $data['user_id'];
		$old        =   $data['old_password'];
		$new        =   $data['new_password'];
		$pass       =   $data['confirm_new_password'];
		$Check = $this->db->select('user_id')->get_where('users',array('password'=>md5($old)))->num_rows();
		if($Check>0){
    		if($new==$pass){
    		    $response['status']=0;
    			$response['message']='Quantity not available';
    		}else{
    			$response['status']=0;
    			$response['message']='Mismatched confirm password';
    		}
		}else{
		    	$response['status']=0;
    			$response['message']='Invalid old password';
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function forgotpassword_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$email      =   $data['email'];
	    $Check = $this->db->select('user_id')->get_where('users',array('email'=>$email))->num_rows();
		if($Check==0){
			$response['status']=0;
			$response['message']='Invalid emailid';
		}else{
		    $pass = rand ( 10000 , 99999 );
		    $html_content = 'Your updated password : '.$pass;
		    $subject='The Soilson - Forgotpassword';
		    $this->common_model->send_email($html_content, $email, $subject);
			$response['status']=1;
			$response['message']='New password generated and send to you mail check once with spam';
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function user_wallet_history_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$user_id      =   $data['user_id'];
		$response['status']=1;
	    $response['history']=$this->db->query("SELECT `wallet_id`,`balance`,`amount`, `type`, `user_id`, `status`, `description`, `created_date`, `updated_date`,CASE WHEN (`action_type`=0) THEN 'Recharge' WHEN (`action_type` = 1) THEN 'Subscription' WHEN (`action_type` = 2) THEN 'ServiceCharge' ELSE 'Order' END AS particulars FROM `user_wallet` WHERE `user_id`=$user_id ORDER BY wallet_id DESC LIMIT 10")->result_array();
		$amt = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
		$response['amount']=($amt['final_wallet_amount']=='')?0:$amt['final_wallet_amount'];
		$wall = $this->db->query("SELECT `id`, `description` FROM `wallet_content` LIMIT 1")->row_array();
        $response['message'] = $wall['description'];
        $this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function my_total_orders_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$user_id      =   $data['user_id'];
		$response['status']=1;
	   $ords=$this->db->query("SELECT a.delivery_type,.a.`order_id`, a.`payment_id` as invoice_id, a.`user_id`, a.`reference_id`, a.`order_amount`, a.`user_address_id`, a.`payment_mode`, a.order_status,a.`payment_status`, a.`order_date`, a.`order_succ_date`, a.`order_failed_date`, a.`order_cancelled_date`,b.name,b.email,b.phone,c.user_address_id,c.appartment,c.floor_no,c.block_no,c.pincode,c.address,(SELECT COUNT(`order_prod_id`) FROM `order_products` WHERE `order_id`=a.`order_id`) AS tot_items,a.delivery_date,a.delivery_slot,a.delivery_slot_id FROM `orders` a LEFT JOIN users b ON a.user_id=b.user_id LEFT JOIN order_user_address c ON a.order_id=c.order_id WHERE a.`user_id`=$user_id ORDER BY a.`order_id` DESC")->result_array();
        $userords=array();
        $curent=date('Y-m-d H:i:s');
        if(count($ords)>0){
            foreach($ords as $ord){
                $is_cancel=0;
                if(trim($ord['order_status'])!='Cancelled'){
                    $from = $ord['order_date'];
                    if(trim($ord['delivery_type'])=='express'){
                       $convertedTime = date('Y-m-d H:i:s', strtotime('+180 minutes', strtotime($from)));
                    }else{
                        $convertedTime = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($from)));
                    }
                    $is_cancel=($curent<$convertedTime)?1:0;
                }
               $ord['is_cancel']= $is_cancel;
               $ord['delivery_timings']= ($ord['delivery_slot_id']>0)?$ord['delivery_slot']:'Before 8 AM';
               $userords[]=$ord;  
            }
        }
        $response['orders']=$userords;
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function single_order_view_post(){
		$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$order_id      =   $data['order_id'];
		$response['status']=1;
	    $response['order']=$this->db->query("SELECT a.`order_id`, a.`payment_id`, a.`user_id`, a.`reference_id`, a.`order_amount`, a.`user_address_id`, a.`payment_mode`, a.`payment_status`, a.`order_date`, a.`order_succ_date`, a.`order_failed_date`, a.`order_cancelled_date`,b.name,b.email,b.phone,c.user_address_id,c.appartment,c.floor_no,c.block_no,c.pincode,c.address FROM `orders` a LEFT JOIN users b ON a.user_id=b.user_id LEFT JOIN order_user_address c ON a.order_id=c.order_id WHERE a.`order_id`=$order_id")->row_array();
	    //$response['products']=$this->db->query("SELECT `order_prod_id`, `order_id`, `user_id`, `qty`, `tot_amount`, `offer_amount`, `prod_id`, `prod_title`, `prod_mesurement`, `prod_category`, `prod_image`, `prod_image_name`, `prod_org_price`, `prod_offered_price`, `prod_available_locations` FROM `order_products` WHERE `order_id`=$order_id")->result_array();
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function place_order_post(){
    	$data 			= 	json_decode(file_get_contents("php://input"),true);
		$data			=	(isset($data))? $data : $_POST;
		$user_id      	=   $data['user_id'];
		$delivery_type  =   $data['delivery_type'];
		$delivery_slot  =   @$data['slot'];
		$coupon_id  	=   @$data['coupon_id'];
		$coupon_code  	=   @$data['coupon_code'];
		$coupon_amount  =   @$data['coupon_amount'];
		$online_amount	=	@$data['online_amount'];
		$wallet_amount	=	@$data['wallet_amount'];
		$order_amount   =   @$data['order_amount'];
		$payment_mode   =   @$data['payment_mode'];
		$check_wallet   =  1;
		if($payment_mode=='wallet' || $payment_mode=='wallet_online'){
		    $check_wallet = ($wallet_amount<=$order_amount)?1:0;
		}
		if($check_wallet==1){
		$slot_day = @$data['slot_day'];
		$slot_available = 1;
		if($delivery_type=='normal'){
			$check_slot = 1;
			$slot_available = 1;
		}else{
			if($slot_day==1){
				$check_slot = $delivery_slot;
				$Slots_Dt = $this->db->query("SELECT `id`, `slot_from`, `slot_to`, `time_in_seconds` FROM `delivery_slots` WHERE `id`=$delivery_slot")->row_array();
				$today = date('H:i:s');
				$current_time = date("H:i:s", strtotime($today));
				$secs = time2sec($current_time);
				if($Slots_Dt['time_in_seconds']>$secs){
					$slot_available = 1;
				}else{
					$slot_available = 0;
				}
			}else{
				$check_slot = 1;
				$slot_available = 1;
			}
		}
		$slot = $delivery_slot;
		if($check_slot!='' && $check_slot>0){
			if($slot_available>0){
                //$cartdata[]=array('product_id'=>1,"product_qty"=>2,"prod_mesurment_id"=>"1");
                $cartdata = $data['cartdata'];
				$payment_mode = $data['payment_mode'];
				$adress_id = @$data['user_apartment_det_id'];
				$order_amount=$data['order_amount'];
                if($payment_mode=='wallet' || $payment_mode=='wallet_online'){
                    $Amount = $this->db->query("SELECT `final_wallet_amount`,`reserved_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
                    $checking_wallet_amount = ($Amount['final_wallet_amount']!='')?$Amount['final_wallet_amount']:0;
                    $checking_wallet_amount = $checking_wallet_amount-$Amount['reserved_amount'];
                    $Check_Payment_Status = ($wallet_amount<=$checking_wallet_amount)?1:0;
                }else{
                    $Check_Payment_Status = 1;
                }
				if($Check_Payment_Status){
					if($adress_id!='' && $adress_id>0){
						$Failed = array();
						if(count($cartdata)>0){
							foreach($cartdata as $k => $json_data) {
								//$json_data = json_decode($cart,true);
								$prod_id = $json_data['product_id'];
								$qty     = $json_data['product_qty'];
								$prod_mes_id     = $json_data['prod_mesurment_id'];
								$Check = $this->db->query("SELECT b.prod_title,a.prod_available_qty FROM `product_mesurments` a JOIN products b on a.`prod_id`=b.prod_id AND a.id=$prod_mes_id")->row_array();
								if(!empty($Check)){
									if($Check['prod_available_qty']<$qty){
										$qty_tit = $Check['prod_available_qty'];
										$Failed[]= '('.$Check['prod_title'] .') product available only '.$qty_tit.' qunatity';
									}
								}
							}
							if(empty($Failed)){
								$reference_id = $this->common_model->GetRefId();
								$ord_data['payment_id'] 			= 	$reference_id;
								$ord_data['reference_id'] 			= 	$reference_id;
								$ord_data['order_amount'] 			= 	$order_amount;
								$ord_data['user_id'] 				= 	$user_id;
								$ord_data['payment_mode'] 			= 	$payment_mode;
								$ord_data['user_apartment_det_id'] 	= 	$adress_id;
								$ord_data['delivery_type'] 			= 	$delivery_type;
								$ord_data['slot'] 					= 	$slot;
								$ord_data['coupon_id']				=	$coupon_id;
								$ord_data['coupon_code']			=	$coupon_code;
								$ord_data['coupon_amount']			=	$coupon_amount;
								$ord_data['online_amount']			=	$online_amount;
								$ord_data['wallet_amount']			=	$wallet_amount;
								$ord_data['slot_day'] = $slot_day;
								$order_id = $this->app_login->Save_Order_Details($ord_data);
								$this->app_login->Save_Order_Address_Details($adress_id,$order_id,$user_id);
								foreach($cartdata as $k => $json_data) {
									// $json_data = json_decode($cart,true);
									$prod_id = $json_data['product_id'];
									$qty     = $json_data['product_qty'];
									$prod_mes_id     = $json_data['prod_mesurment_id'];
									$Check = $this->db->query("SELECT b.prod_title,a.prod_available_qty,a.prod_org_price,a.prod_offered_price,c.title as mes_title ,b.prod_mesurements, d.title as cat_title , e.brand_title as prod_brand,sb.title as sub_title FROM `product_mesurments` a JOIN products b on a.`prod_id`=b.prod_id LEFT JOIN mesurements c ON c.mes_id=a.mes_id LEFT JOIN categories d ON d.cat_id=b.prod_category LEFT JOIN category_brands e ON e.brand_id=b.prod_brand LEFT JOIN sub_categories sb ON sb.sub_cat_id=b.prod_sub_category WHERE a.id=$prod_mes_id")->row_array();
									$pqty = $Check['prod_available_qty']-$qty;
									$Ord['order_id'] = $order_id;
									$Ord['qty'] = $qty;
									$Ord['user_id'] = $user_id;
									$Ord['tot_amount'] = $Check['prod_org_price'];
									$Ord['offer_amount'] = $Check['prod_offered_price'];
									$Ord['prod_id'] = $prod_id;
									$Ord['prod_mes_id'] = $prod_mes_id;
									$Ord['mesurment'] = $Check['mes_title'];
									$Ord['prod_title'] = $Check['prod_title'];
									$Ord['prod_mesurements'] = $Check['prod_mesurements'];
									$Ord['prod_category'] = $Check['cat_title'];
									$Ord['prod_sub_category'] = $Check['sub_title'];
									$Ord['prod_brand'] =  $Check['prod_brand'];
									$Ord['tot_amount']=($qty*$Check['prod_org_price']);
									$Ord['offer_amount']=($qty*$Check['prod_offered_price']);
									$this->app_login->Save_Order_Product_Details($Ord,$payment_mode,$pqty);
								}
								if($payment_mode=='online' || $payment_mode=='wallet_online'){
									$this->app_login->Update_Qty($order_id);
								}
								$this->common_model->send_invoice($order_id);
								$delivery_date = $this->db->query("SELECT delivery_date FROM `orders` WHERE `order_id`=$order_id")->row_array();
								$response['status']=1;
								$response['message']='Order placed successfully';
								$response['order_id']=$reference_id;
								$response['sno_id']=$order_id;
								$response['delivery_date']=date_month_name($delivery_date['delivery_date']).' '.($delivery_type=='normal')?'Before 8AM':'Between 8AM to 8PM ';
							}else{
								$response['status']=0;
								$response['message']='Below list of products qty not available';
								$response['products']=$Failed;
							}
						}else{
							$response['status']=0;
							$response['message']='Cart data were mondatory';
						}
					}else{
						$response['status']=0;
						$response['message']='Please select apartment address';
					}
				}else{
					$response['status']=0;
					$response['message']='Insufficient wallet amount...';
				}
			}else{
				$response['status']=0;
				$response['message']='Selected slot not available...';
			}
		}else{
			$response['status']=0;
			$response['message']='Invalid delivery time slot';
		}
		}else{
		    $response['status']=0;
			$response['message']='Wallet amount not greater of tot amount';
		}
		$this->set_response($response, REST_Controller::HTTP_CREATED);		
	}
	public function all_products_in_cart_post(){
		$data = json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$productIds = @$data['productIds'];
		$response['status']=1;	
		$and = "a.`prod_status`=1 ";
		$productIdsArr = array();
		if($productIds != '')
		{
		    $productIdsArr = explode(',',$productIds);
		}
		if(!empty($productIdsArr))
		{
		    if(count($productIdsArr) == 1)
		    {
		        $and .= "and a.`prod_id`= ".$productIdsArr[0]; 
		    }
		    else
		    {
		        $and .= "and a.`prod_id` in (".$productIds.")";
		    }
		}
			
		$response['products']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`,  a.`prod_status`, a.`prod_available_locations`,a.prod_category,a.`prod_mesurements`,b.title cat_title FROM `products` a JOIN categories b ON a.`prod_category`=b.cat_id WHERE $and")->result_array();
	
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_appart_ments_post(){
       	$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST; 
		$response['apartments'] = $this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date` FROM `apartments` WHERE `status`=1")->result_array(); 
		$response['status']=1;
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_appart_ment_post(){
    	$data 		= 	json_decode(file_get_contents("php://input"),true);
		$data		=	(isset($data))? $data : $_POST;
		$apartment_id = @$data['apartment_id'];
        $response['apartment'] = $this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date` FROM `apartments` WHERE `status`=1 AND apartment_id=".$apartment_id)->row_array(); 
		$response['status']=1;
		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_blocks_with_and_without_apartments_post(){
        $data 		= 	json_decode(file_get_contents("php://input"),true);
        $data		=	(isset($data))? $data : $_POST;
        $apartment_id = @$data['apartment_id'];
         $and='';
         if($apartment_id!=''){
            $and .= " AND a.apartment_id=$apartment_id";
        }
        $response['blocks']=$this->db->query("SELECT a.`block_id`, a.`block_name` FROM `blocks` a LEFT JOIN apartments b ON a.apartment_id = b.apartment_id WHERE a.`status`=1 $and")->result_array();
        $response['status']=1;
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_block_post(){
        $data 		= 	json_decode(file_get_contents("php://input"),true);
        $data		=	(isset($data))? $data : $_POST;
        $apartment_id = @$data['apartment_id'];
        $block_id   = @$data['block_id'];
        $and='';
        if($apartment_id!=''){
            $and .= " AND a.apartment_id=$apartment_id";
        }
        $and .= " AND a.block_id=$block_id";
        $response['block']=$this->db->query("SELECT a.`block_id`, a.`block_name` FROM `blocks` a LEFT JOIN apartments b ON a.apartment_id = b.apartment_id WHERE a.`status`=1 $and")->row_array();
        $response['status']=1;
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function all_flats_with_and_without_block_and_apartment_post(){
        $data 		= 	json_decode(file_get_contents("php://input"),true);
        $data		=	(isset($data))? $data : $_POST;
        $apartment_id = @$data['apartment_id'];
        $block_id   = @$data['block_id'];
        $and='';
        if($block_id!=''){
            $and .= " AND b.block_id=$block_id";
        }
        $response['flats']=$this->db->query("SELECT a.flat_id,a.`flat_name`,b.block_name FROM `flats` a LEFT JOIN blocks b ON a.`block_id`=b.block_id WHERE a.status=1 $and")->result_array();
        $response['status']=1;
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function single_flat_post(){
        $data 		= 	json_decode(file_get_contents("php://input"),true);
        $data		=	(isset($data))? $data : $_POST;
        $apartment_id = @$data['apartment_id'];
        $block_id   = @$data['block_id'];
        $flat_id = @$data['flat_id'];
        $and='';
        if($block_id!=''){
            $and .= " AND b.block_id=$block_id";
        }
        if($flat_id!=''){
            $and .= " AND a.flat_id=$flat_id";
        }
        $response['flat'] = $this->db->query("SELECT a.`flat_name`,b.block_name,c.apartment_name FROM `flats` a LEFT JOIN blocks b ON a.`block_id`=b.block_id LEFT JOIN apartments c ON a.apartment_id = c.apartment_id WHERE a.status=1 $and")->row_array();
        $response['status']=1;
        $this->set_response($response, REST_Controller::HTTP_CREATED);
	}
	public function add_user_apartment_details_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $apartment_id   =   @$data['apartment_id'];
        $block_id       =   @$data['block_id'];
        $flat_id        =   @$data['flat_id'];
        $user_id        =   @$data['user_id'];
		$title 			=   @trim($data['title']);
		// $Arr = array(
        //     'apartment_id'=>$apartment_id,
        //     'block_id'=>trim($block_id),
        //     'flat_id'=>trim($flat_id),
        //     'user_id'=>$user_id,
		// 		'title'=>ucfirst($title)
        // );    
        // $this->db->update("user_apartment_details",array('is_latest'=>0),array('user_id'=>$user_id));
        // $Check=$this->db->select('user_apartment_det_id')->get_where("user_apartment_details",$Arr)->num_rows();
        // if($Check==0){
        //     $Insert=array_merge($Arr,array('is_latest'=>1));
        //     $this->db->insert("user_apartment_details",$Insert);
        // }else{
        //      $this->db->update("user_apartment_details",array('is_latest'=>1),$Arr);
        // }
        // $response['status']=1;
        // $response['message']='Details added successfully';
        $Arr = array(
            'apartment_id'=>$apartment_id,
            'block_id'=>trim($block_id),
            'flat_id'=>trim($flat_id),
            'user_id'=>$user_id,
        );
		$response['status']=1;
        $this->db->update("user_apartment_details",array('is_latest'=>0),array('user_id'=>$user_id));
        $Check=$this->db->select('title')->get_where("user_apartment_details",$Arr)->row_array();
        if(empty($Check)){
            $Insert=array_merge($Arr,array('is_latest'=>1,'title'=>ucfirst($title)));
            $this->db->insert("user_apartment_details",$Insert);
			$response['message']='Address added successfully';
        }else{
			 if($Check['title']==$title){
				$response['status']		=	0;
				$response['message']	= 	'Address already added';
			 }else{
				$response['status']		=	0;
				$response['message']	=	'This address already added like '.$Check['title'];
			 }
             $this->db->update("user_apartment_details",array('is_latest'=>1),$Arr);
        }
         $response['address']=$this->db->get_where("user_apartment_details",$Arr)->row_array();
        $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function update_user_apartment_details_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $apartment_id   =   @$data['apartment_id'];
        $user_apartment_det_id   =   @$data['user_apartment_det_id'];
        $block_id       =   @$data['block_id'];
        $flat_id        =   @$data['flat_id'];
        $user_id        =   @$data['user_id'];
		$title 			=   @trim($data['title']);
		// $Arr = array(
        //     'apartment_id'=>$apartment_id,
        //     'block_id'=>trim($block_id),
        //     'flat_id'=>trim($flat_id),
        //     'user_id'=>trim($user_id),
		// 	'title'=>ucfirst($title),
        // );
        // $Check=$this->db->select('user_apartment_det_id')->get_where("user_apartment_details",array('user_apartment_det_id'=>$user_apartment_det_id,'user_id'=>$user_id))->num_rows();
        // if($Check==0){
		// 	$response['status']=0;
		// 	$response['message']='Address id not found';
        // }else{
        //      $this->db->update("user_apartment_details",$Arr,array('user_apartment_det_id'=>$user_apartment_det_id));
        //      $response['status']=1;
        // 	$response['message']='Address updated successfully';
        // }
        $Arr = array(
            'apartment_id'=>$apartment_id,
            'block_id'=>trim($block_id),
            'flat_id'=>trim($flat_id),
            'user_id'=>trim($user_id)
        );
        $Check=$this->db->select('user_apartment_det_id')->get_where("user_apartment_details",array('user_apartment_det_id'=>$user_apartment_det_id,'user_id'=>$user_id))->num_rows();
        if($Check==0){
			$response['status']=0;
			$response['message']='Address id not found';
        }else{
			$Check_Tit = $Check=$this->db->select('user_apartment_det_id')->get_where("user_apartment_details",array('title'=>$title,'user_id'=>$user_id,'user_apartment_det_id != '=>$user_apartment_det_id))->num_rows();
			if($Check_Tit==0){
				$Arr = array_merge($Arr,array('title'=>$title));
				$this->db->update("user_apartment_details",$Arr,array('user_apartment_det_id'=>$user_apartment_det_id));
				$response['status']=1;
				$response['message']='Address updated successfully';
			}else{
			    $Arr = array_merge($Arr,array('title'=>$title));
				$this->db->update("user_apartment_details",$Arr,array('user_apartment_det_id'=>$user_apartment_det_id));
				$response['status']=1;
				$response['message']='Address updated successfully';
				// $response['status']=0;
				// $response['message']='Address already existed for '.$title;
			}
        }
        $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function add_default_user_apartment_details_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $user_apartment_det_id   =   @$data['user_apartment_det_id'];
        $user_id        =   @$data['user_id'];
        $this->db->update("user_apartment_details",array('is_default'=>0),array('user_id'=>$user_id));
        $this->db->update("user_apartment_details",array('is_default'=>1),array('user_apartment_det_id'=>$user_apartment_det_id));
        $response['status']=1;
        $response['message']='Added default address successfully';
        $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function remove_user_apartment_details_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $user_id        =   @$data['user_id'];
        $user_apartment_det_id   =   @$data['user_apartment_det_id'];
         $this->db->delete("user_apartment_details",array('user_apartment_det_id'=>$user_apartment_det_id));
        $response['status']=1;
        $response['message']='Address removed successfully';
        $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function user_apartment_details_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $user_id        =   @$data['user_id'];
        $response['status']=1;
        $user_address = $this->db->query("SELECT d.title,d.`user_apartment_det_id`, d.`apartment_id`, d.`block_id`, d.`flat_id`,d.`is_latest`,d.`user_id`,c.apartment_name,c.apartment_address,c.apartment_pincode,d.is_default as default_address FROM `user_apartment_details` d  LEFT JOIN apartments c ON d.apartment_id = c.apartment_id WHERE d.status=1 AND d.user_id=$user_id")->result_array();
        $response['addresses']=$user_address;
       $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function user_default_address_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $user_id        =   @$data['user_id'];
        $response['status']=1;
        $user_address = $this->db->query("SELECT d.title,d.`user_apartment_det_id`, d.`apartment_id`, d.`block_id`, d.`flat_id`,d.`user_id`,d.is_default as default_address,c.apartment_name,c.apartment_address,c.apartment_pincode FROM `user_apartment_details` d  LEFT JOIN apartments c ON d.apartment_id = c.apartment_id WHERE d.status=1 AND d.user_id=$user_id AND is_latest=1")->row_array();
        $response['message']=$user_address;
        $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function user_address_post(){
	    $data 		    			  =   json_decode(file_get_contents("php://input"),true);
        $data		    			  =	  (isset($data))? $data : $_POST;
        $user_apartment_det_id        =   @$data['user_apartment_det_id'];
        $response['status']=1;
        $user_address = $this->db->query("SELECT d.title,d.`user_apartment_det_id`, d.`apartment_id`, d.`block_id`, d.`flat_id`,d.`user_id`,d.is_default as default_address,c.apartment_name,c.apartment_address,c.apartment_pincode FROM `user_apartment_details` d  LEFT JOIN apartments c ON d.apartment_id = c.apartment_id WHERE d.status=1 AND d.user_apartment_det_id=$user_apartment_det_id")->row_array();
        if(empty($user_address)){
            $response['message'] =  'Address not found';
        }else{
            $response['message'] = '';
            $response['user_address']=$user_address;
        }
       $this->set_response($response, REST_Controller::HTTP_CREATED); 
	}
	public function user_details_post(){
	    $data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
        $user_id        =   @$data['user_id'];
        $response['status']=1;
        $response['user_details'] = $this->db->query("SELECT `user_id`, `name`, `fname`, `lname`, `email`, `phone`,`final_wallet_amount`,`profile_pic` from `users` where `user_id`=$user_id")->row_array();
		$User_address = $this->db->query("SELECT d.title,d.`apartment_id`, d.`block_id`, d.`flat_id`,c.apartment_name,c.apartment_address,c.apartment_pincode FROM `user_apartment_details` d  LEFT JOIN apartments c ON d.apartment_id = c.apartment_id WHERE d.status=1 AND d.user_id=$user_id AND is_latest=1")->row_array();
		if(!empty($User_address)){
			$response['user_details'] = array_merge($response['user_details'],$User_address);
		}
        $response['message']="success";
        $this->set_response($response,REST_Controller::HTTP_CREATED); 
	}
	public function all_category_brand_post(){
		$data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
		$cat_id 		= 	@$data['cat_id'];
		$cat_id 		= 	($cat_id=='')?0:$cat_id;
		$response['status']=1;
		$response['brands']=$this->db->query("SELECT a.`brand_id`, a.`cat_id`, a.`brand_title`,b.title as category_title,(SELECT COUNT(`prod_id`) FROM `products` WHERE brand_id=a.brand_id) AS products_count FROM `category_brands` a JOIN categories b ON a.`cat_id`=b.cat_id WHERE a.`cat_id`=$cat_id")->result_array();
		$this->set_response($response,REST_Controller::HTTP_CREATED); 
	}
	public function single_category_brand_post(){
		$data 		    = 	json_decode(file_get_contents("php://input"),true);
        $data		    =	(isset($data))? $data : $_POST;
		$brand_id 		= 	@$data['brand_id'];
		$brand_id 		= 	($brand_id=='')?0:$brand_id;
		$response['status']=1;
		$response['brand']=$this->db->query("SELECT a.`brand_id`, a.`cat_id`, a.`brand_title`,b.title as category_title,(SELECT COUNT(`prod_id`) FROM `products` WHERE brand_id=a.brand_id) AS products_count FROM `category_brands` a JOIN categories b ON a.`cat_id`=b.cat_id WHERE a.`brand_id`=$brand_id")->row_array();
		$this->set_response($response,REST_Controller::HTTP_CREATED); 
	}
	public function add_subscribe_product_post(){
        $data               	= json_decode(file_get_contents("php://input"),true);
        $data               	= (isset($data))? $data : $_POST;
        $user_id            	= @$data['user_id'];
        $prod_id            	= @$data['prod_id'];
        $prod_mesids        	= @$data['prod_mes_id'];
		$qty_id        			= @$data['qty'];
		$from_date  			= @$data['from_date'];
		$pick_schedule  		= ($data['pick_schedule']);
		$user_apartment_det_id  = @trim($data['user_apartment_det_id']);
		$days_list 				= @($data['days_list']);
		$from       = yy_mm_dd($from_date);
		$today = date('Y-m-d');
		$next_day = date("Y-m-d",strtotime($today.' +1 day'));
		$next_after_day = date("Y-m-d",strtotime($next_day.' +1 day'));
		if($from > $today){
			$existed_count = $this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `qty`, `from_date`, `schedule_type`, `subscription_address_id`, `days_list`, `to_date`, `type`, `is_active`, `created_date` FROM `prod_subscriptions` WHERE `user_id`=$user_id AND `prod_id`=$prod_id AND is_active<3")->result_array();
			$tot_count = $this->db->query("SELECT `id` FROM `product_mesurments` WHERE `prod_id`=$prod_id")->num_rows();
			if(count($existed_count)==$tot_count){
				$this->db->insert_batch('temp_prod_subscriptions',$existed_count);
				$this->db->delete('prod_subscriptions',array('prod_id'=>$prod_id,'user_id'=>$user_id));
			}
			$response['status'] =   0;
			$current_time = date('H');
			if($from==$next_day && $current_time > 20){
				$calculated_date = '';
			}else{
			    $calculated_date = $from;
			}
			if($calculated_date!=''){
				if(count($prod_mesids)>0){
					$fail = array();
					$Arr_Dat = array();
					$check=array();
					$Address = $this->db->query("SELECT `user_apartment_det_id`, `title`, `apartment_id`, `block_id`, `flat_id`, `user_id`, `status`, `is_latest`, `is_default`, `created_date`, `updated_date` FROM `user_apartment_details` WHERE `user_apartment_det_id`=$user_apartment_det_id")->row_array();
					$subscription_address_id = $this->common_model->commonInsert('subscription_addresses',$Address);
					foreach($prod_mesids as $k=>$prod){
						$prod_mes_id = $prod;
						$qty = $qty_id[$k];
						if($qty>0){
							$Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'prod_id'=>$prod_id,'prod_mes_id'=>$prod_mes_id,'is_active<'=>3),'');
							if($Check_Subscribe>0){
								$dt=$this->db->query("SELECT b.title FROM `product_mesurments` a JOIN mesurements b ON a.`mes_id`=b.mes_id WHERE a.id=$prod_mes_id")->row_array();
								$check[] = $dt['title'];
							}else{
							    $days_list = @implode(',',$days_list);
								$final = array(
									'user_id'=>$user_id,
									'prod_id'=>$prod_id,
									'prod_mes_id'=>$prod_mes_id,
									'qty'=>$qty,
									'from_date'=>$from_date,
									'schedule_type'=>trim($pick_schedule),
									'subscription_address_id'=>$subscription_address_id,
									'days_list'=>$days_list,
									'created_date'=>date('Y-m-d H:i:s')
								);
								$Arr_Dat[] = $final;
								$this->common_model->commonInsert('prod_subscriptions',$final);
							}
						}
					}
					if(count($check)>0){
						if(count($check)==count($prod_mesids)){
							$name = (count($check)>1)?'measurements':'measurement';
							$response['faild']=implode(',',$check).' '.$name.' Already subscribed';
						}else{
							$name = (count($check)>1)?'measurements':'measurement';
							$response['faild']=implode(',',$check).' '.$name.' Already subscribed';
						}
					}
					$response['message'] = 'Your subscription successfull';
					$response['subscription_start_date'] = $from;
					$response['showing_price_msg']=1;
					$response['status'] = 1;
				}else{
					$response['message'] = 'Please check product measurements ';
				}
			}else{
				$response['message'] = 'Please select subscription start date from '.$next_after_day;;
			}
		}else{
			$response['message'] = 'Please select subscription start date from '.$next_day;
		}
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function changing_subscribe_product_post(){
        $data               = json_decode(file_get_contents("php://input"),true);
        $data               = (isset($data))? $data : $_POST;
        $user_id            = @$data['user_id'];
        $subscribe_id       = @$data['subscribe_id'];
        $type               = 'pause_subscription';
        $from_date          = @$data['from_date'];
        $to_date            = @$data['to_date'];
        $from               = yy_mm_dd($from_date);
        $to                 = yy_mm_dd($to_date);
        $Qty                = array('from_date'=>$from,'to_date'=>$to);
        $response['status'] =   0;
        $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','`subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `qty`, `from_date`, `schedule_type`, `subscription_address_id`, `days_list`, `to_date`, `type`, `is_active`, `created_date`',array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id),'');
        if(!empty($Check_Subscribe)){
            $Check_Arr  =   array(
                'user_id'      =>$user_id,
                'subscribe_id' =>$subscribe_id
            );
			$reason = 'Your subscription has been paused from '.$from_date .' to '.$to_date.' To continue services tap on resume';
            $this->common_model->commonUpdate('prod_subscriptions',array('type'=>trim($type),'reason'=>$reason),$Check_Arr);
            $CheckPause = array_merge($Check_Arr,array('user_id'=>$user_id,'subscribe_id' =>$subscribe_id,'is_expaired'=>1));
            $Check = $this->common_model->commonGet('pause_subscriptions','subscribe_id',$CheckPause,'');
            //$final = array_merge($Check_Subscribe,array('type'=>'pause','is_expaired'=>1));
			if($Check>0){
				$this->common_model->commonUpdate('pause_subscriptions',array('type'=>'pause','is_expaired'=>1,'from_date' =>$from,'to_date'=>$to),$Check_Arr);
			}else{
				$this->common_model->commonInsert('pause_subscriptions',array('user_id'=>$user_id,'subscribe_id' =>$subscribe_id,'type'=>'pause','is_expaired'=>1,'from_date' =>$from,'to_date'=>$to));
			}
			$this->common_model->commonUpdate('prod_subscriptions',array('is_active'=>2),$Check_Arr);
			$response['status']=1;
			$response['message'] =  'Your subscription has been pauses as request. You can tap on resume to the services.';
        }else{
            $response['message'] = 'Invalid subscriber id';
        }
        $this->set_response($response,REST_Controller::HTTP_CREATED);
    }
    public function temporarly_modify_subscribe_product_post(){
        $data               = json_decode(file_get_contents("php://input"),true);
        $data               = (isset($data))? $data : $_POST;
        $user_id            = @$data['user_id'];
        $prod_id            = @$data['prod_id'];
        $prod_mes_id_ss     = @$data['prod_mes_id'];
        $qty_ss             = @$data['qty'];
        $from_date          = @$data['from_date'];
        $to_date            = @$data['to_date'];
        $from               = yy_mm_dd($from_date);
        $to                 = yy_mm_dd($to_date);
        $type = 'temporarily_change';
        $response['status'] =   0;
        if(count($prod_mes_id_ss)>0){
            foreach($prod_mes_id_ss as $pk=>$prod_mes_id){
                $qty    =    $qty_ss[$pk];
                $Qty                = array('user_id'=>$user_id,'qty'=>$qty,'from_date' =>$from,'to_date'   =>$to);
                $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'prod_id'=>$prod_id,'prod_mes_id'=>$prod_mes_id,'is_active<'=>3),'');
                if(!empty($Check_Subscribe)){
                    $Check_Arr  =   array(
                        'user_id'=>$user_id,
                        'prod_id'=>$prod_id,
                        'prod_mes_id'=>$prod_mes_id
                    );
					$reason = 'Your subscription has been modified from '.$from_date.' to '.$to_date;
                    $this->common_model->commonUpdate('prod_subscriptions',array('type'=>trim($type),'reason'=>$reason),$Check_Arr);
                    $Check_Arr = $Check_Subscribe;
                    $Check_Arr['is_expaired']=1;
                    $Check = $this->common_model->commonGet('pause_subscriptions','subscribe_id',$Check_Arr,'');
                    $Up_Arr = array_merge($Check_Subscribe,$Qty);
                    $Up_Arr['type']='temp';
                    if(!empty($Check)){
                        $this->common_model->commonUpdate('pause_subscriptions',$Up_Arr,$Check_Arr);
                    }else{
                        $this->common_model->commonInsert('pause_subscriptions',$Up_Arr);
                    }
                }
            }
            $response['status']  =   1;
            $response['message'] =  'Your subscription has been modified as requested.';
        }else{
            $response['status']  =   0;
            $response['message'] =  'Product details required';
        }
        $this->set_response($response,REST_Controller::HTTP_CREATED);
    }
    public function permenently_modify_subscribe_product_post(){
        $data               = json_decode(file_get_contents("php://input"),true);
        $data               = (isset($data))? $data : $_POST;
        $user_id            = @$data['user_id'];
        $prod_id            = @$data['prod_id'];
        $prod_mes_id_ss     = @$data['prod_mes_id'];
        $qty_ss             = @$data['qty'];
        $type = 'perminently_change';
        $response['status'] =   0;
        if(count($prod_mes_id_ss)>0){
            foreach($prod_mes_id_ss as $pk=>$prod_mes_id){
                $qty    =    $qty_ss[$pk];
                $Qty                = array('user_id'=>$user_id,'qty'=>$qty);
                $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','`subscribe_id`, `user_id`,`qty`, `from_date`, `to_date`',array('user_id'=>$user_id,'prod_id'=>$prod_id,'prod_mes_id'=>$prod_mes_id,'is_active<'=>3),'');
                if(!empty($Check_Subscribe)){
                    $subscribe_id = $Check_Subscribe['subscribe_id'];
                    $Check_Arr  =   array(
                        'user_id'=>$user_id,
                        'prod_id'=>$prod_id,
                        'prod_mes_id'=>$prod_mes_id
                    );
                    $existed_count = $this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `qty`, `from_date`, `schedule_type`, `subscription_address_id`, `days_list`, `to_date`, `type`, `is_active`, `created_date` FROM `prod_subscriptions` WHERE `user_id`=$user_id AND `prod_mes_id`=$prod_mes_id AND `prod_id`=$prod_id AND is_active<3")->row_array();
                    if(!empty($existed_count)){
                        $existed_count['created_date']=date('Y-m-d H:i:s');
						$existed_count['action_type']=1;
                        $this->db->insert('temp_prod_subscriptions',$existed_count);
                    }
                    $this->common_model->commonUpdate('prod_subscriptions',array('type'=>trim($type),'qty'=>$qty,'reason'=>''),$Check_Arr);
                    $Check = $this->common_model->commonGet('pause_subscriptions','subscribe_id',array('subscribe_id'=>$subscribe_id,'type'=>'perm'),'');
                    $Check_Subscribe['type']='perm';
                    $Check_Subscribe['is_expaired']=0;
                    if(!empty($Check)){
                        unset($Check_Subscribe['subscribe_id']);
                        $this->common_model->commonUpdate('pause_subscriptions',$Check_Subscribe,array('subscribe_id'=>$subscribe_id));
                    }else{
                        $this->common_model->commonInsert('pause_subscriptions',$Check_Subscribe);
                    }
                }
            }
            $response['status']  =   1;
            $response['message'] =  'Your subscription has been modified as requested.';
        }else{
            $response['status']  =   0;
            $response['message'] =  'Product details required';
        }
        $this->set_response($response,REST_Controller::HTTP_CREATED);
    }
	public function delete_product_subscraibe_post(){
        $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $subscribe_id   = @$data['subscribe_id'];
		$reason			= @$data['reason'];
        $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id),'');
        if(!empty($Check_Subscribe)){
            $this->common_model->commonUpdate('prod_subscriptions',array('reason'=>$reason,'is_active'=>'3'),array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id));
            $response['status'] = 1;
            $response['message'] = 'Your Subscription deleted successfully';
        }else{
            $response['status'] = 0;
            $response['message'] = 'Invalid subscriber id';
        }
	    $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function unpause_the_subscraibe_product_post(){
        $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $subscribe_id   = @$data['subscribe_id'];
        $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id,'is_active'=>2),'');
        if(!empty($Check_Subscribe)){
            $this->common_model->commonUpdate('prod_subscriptions',array('type'=>'resume','is_active'=>1,'reason'=>''),array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id));
            $response['status'] = 1;
            $response['message'] = 'UnPaused successfully';
        }else{
            $response['status'] = 0;
            $response['message'] = 'Invalid subscriber id';
        }
	    $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function member_subscribed_products_post(){
	    $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $Sub_Data = $this->db->query("SELECT a.schedule_type,a.reason,a.type,a.`subscribe_id`,a.`user_id`,a.`prod_id`,a.`prod_mes_id`,a.`qty`,a.`from_date`,a.`to_date`,a.`is_active`,b.prod_title,d.title as mes_title, c.`prod_image`, c.`prod_org_price`, c.`prod_offered_price`, c.`prod_available_qty`,e.title as cat_title,b.combo_products FROM `prod_subscriptions` a LEFT JOIN products b ON a.`prod_id`=b.prod_id LEFT JOIN product_mesurments c ON a.`prod_mes_id`=c.id LEFT JOIN mesurements d ON c.mes_id=d.mes_id LEFT JOIN categories e ON e.cat_id=b.prod_category WHERE a.user_id=$user_id AND a.`is_active`<3")->result_array();
        $Final_Dt=array();
        if(count($Sub_Data)>0){
            foreach($Sub_Data as $k=>$va){
                $subscribe_id = $va['subscribe_id'];
                $type = $va['type'];
                if($va['prod_image']!=''){
                $prod_image = json_decode($va['prod_image'],true);
                $va['prod_image'] = $prod_image[0];
                }else{
                   $va['prod_image'] = ''; 
                }
                if($type=='temporarily_change' || $type=='pause_subscription'){
                   $Check_Temp = $this->db->query("SELECT `qty`, `from_date`, `to_date`, `type`, `is_expaired` FROM `pause_subscriptions` WHERE `subscribe_id`=$subscribe_id AND is_expaired=1 ORDER BY id DESC LIMIT 1")->row_array();
                   if(!empty($Check_Temp)){
                       if($type=='temporarily_change'){
                        $va['qty']=$Check_Temp['qty'];
                       }
                       $va['from_date']=$Check_Temp['from_date'];
                       $va['to_date']=$Check_Temp['to_date'];
                   }
                }
                $Final_Dt[]=$va;
            }
        }
        $response['status'] = 1;
        $response['products'] = $Final_Dt;
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function subscription_dalete_reason_post(){
		$data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
		$response['status'] = 1;
		$response['reasons']=$this->db->query("SELECT `id`, `reason`, `is_active`, `created_date`, `updated_date` FROM `subscription_cancell_reason` WHERE `is_active`=1")->result_array();
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function add_to_cart_post(){
	    $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $mes_id        = @$data['mes_id'];
        $prod_id       = @$data['prod_id'];
        $qty        = @$data['qty'];
        $check_mes = $this->db->query("SELECT `id` FROM `product_mesurments` WHERE `id`=$mes_id AND `prod_available_qty`>=$qty")->num_rows();
        if($check_mes>0){
            $check = $this->db->query("SELECT `cart_id` FROM `user_cart` WHERE `user_id`=$user_id AND `prod_id`=$prod_id AND `mes_id`=$mes_id")->row_array();
            if(!empty($check)){
                $cart_id = $check['cart_id'];
                $this->db->update('user_cart',array('qty'=>$qty),array('cart_id'=>$cart_id));
            }else{
                $ins=array(
                    'user_id'=>$user_id,
                    'mes_id'=>$mes_id,
                    'prod_id'=>$prod_id,
                    'qty'=>$qty
                );
                $this->db->insert('user_cart',$ins);
            }
            $response['status'] = 1;
            $response['message'] = 'Added to cart successfully';
        }else{
            $response['status'] = 0;
            $response['message'] = 'Quantity not available';
        }
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function my_cart_list_post(){
	    $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $result = $this->db->query("SELECT `cart_id`, `user_id`, `prod_id`, `mes_id`, `qty` FROM `user_cart` WHERE `user_id`=$user_id")->result_array();
        $response['status'] = 1;
        $response['result'] = $result;
        $this->set_response($response,REST_Contunroller::HTTP_CREATED);
	}
	public function single_subscribed_products_post(){
	    $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $prod_id        = @$data['product_id'];
        $Sub_Data = $this->db->query("SELECT a.type,a.`subscribe_id`,a.`user_id`,a.`prod_id`,a.`prod_mes_id`,a.`qty`,a.`from_date`,a.`to_date`,a.`is_active`,b.prod_title,d.title as mes_title, c.`prod_image`, c.`prod_org_price`, c.`prod_offered_price`, c.`prod_available_qty`,e.title as cat_title,b.combo_products FROM `prod_subscriptions` a LEFT JOIN products b ON a.`prod_id`=b.prod_id LEFT JOIN product_mesurments c ON a.`prod_mes_id`=c.id LEFT JOIN mesurements d ON c.mes_id=d.mes_id LEFT JOIN categories e ON e.cat_id=b.prod_category WHERE a.prod_id=$prod_id AND a.user_id=$user_id AND a.is_active<3")->result_array();
        $Final_Dt=array();
        if(count($Sub_Data)>0){
            foreach($Sub_Data as $k=>$va){
                $subscribe_id = $va['subscribe_id'];
                $type = $va['type'];
                if($va['prod_image']!=''){
                $prod_image = json_decode($va['prod_image'],true);
                $va['prod_image'] = $prod_image[0];
                }else{
                   $va['prod_image'] = ''; 
                }
                if($type=='temporarily_change' || $type=='pause_subscription'){
                    $Check_Temp = $this->db->query("SELECT `qty`, `from_date`, `to_date`, `type`, `is_expaired` FROM `pause_subscriptions` WHERE `subscribe_id`=$subscribe_id AND is_expaired=1")->row_array();
                   if(!empty($Check_Temp)){
                       $va['qty']=$Check_Temp['qty'];
                       $va['from_date']=$Check_Temp['from_date'];
                       $va['to_date']=$Check_Temp['to_date'];
                   }
                }
                $Final_Dt[]=$va;
            }
        }
        $response['status'] = 1;
        $response['products'] = $Final_Dt;
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function user_final_wallet_amount_post(){
	    $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $Amount = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
        $response['status'] = 1;
        $response['wallet_amount'] = $Amount['final_wallet_amount'];
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function user_order_cancellation_post(){
        $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
        $order_id       = @$data['order_id'];
        $check_already_cancelled_or_not = $this->db->query("SELECT delivery_type,order_date,`order_id` FROM `orders` WHERE `order_id`=$order_id AND `user_id`=$user_id AND `order_status`='Cancelled'")->num_rows();
        if($check_already_cancelled_or_not>0){
            $response['status'] = 0;
            $response['message'] = 'This order already cancelled'; 
        }else{
             $ord = $this->db->query("SELECT delivery_type,order_date,`order_id` FROM `orders` WHERE `order_id`=$order_id AND `user_id`=$user_id ")->row_array();
            $is_cancel=1;
            $curent=date('Y-m-d H:i:s');
            $from = $ord['order_date'];
            if(trim($ord['delivery_type'])=='express'){
            $convertedTime = date('Y-m-d H:i:s', strtotime('+180 minutes', strtotime($from)));
            }else{
            $convertedTime = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($from)));
            }
            $is_cancel= ($curent<$convertedTime)?1:0;
            if($is_cancel==1){
                $updated_date =date("Y-m-d H:i:s");
                $arr2 = array('order_status'=>'Cancelled','order_cancelled_date'=>$updated_date);
                $this->db->where('order_id',$order_id);
                $status=$this->db->update('orders',$arr2);
                $Amount = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
                $wallet_amount = $Amount['final_wallet_amount'];
                $Order = $this->db->query("SELECT `payment_id`,`user_id`,order_amount,payment_mode FROM `orders` WHERE `order_id`=$order_id")->row_array();
                if($Order['payment_mode']=='wallet'){
                    $order_amount = $Order['order_amount'];
                    $final_wallet_amount = $wallet_amount+$order_amount;
                    $this->db->query("UPDATE `users` SET `final_wallet_amount`=$final_wallet_amount WHERE `user_id`=$user_id");
                    $history = array(
                    'amount'=>$order_amount,
                    'type'=>0,
                    'user_id'=>$user_id,
                    'status'=>1,
                    'description'=>'Cancelled order #'.$Order['payment_id'],
                    'invoice_id'=>$order_id,
                    'created_date'=>date('Y-m-d H:i:s')
                    );
                    $this->db->insert('user_wallet',$history);
                }
                $response['status'] = 1;
                $response['message'] = 'Order cancelled successfully'; 
            }else{
                $response['status'] = 0;
                $response['message'] = 'Order cancellation not allowed'; 
            }
        }
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function get_wallet_content_post(){
	    $data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $wall = $this->db->query("SELECT `id`, `description` FROM `wallet_content` LIMIT 1")->row_array();
        $response['status'] = 1;
        $response['message'] = $wall['description'];
        $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function recharge_history_post(){
		$data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
		$response['data']=array();
		$yrs=$this->db->query("SELECT MONTHNAME(created_date) as mnth,YEAR(created_date) as yr,MONTH(created_date) as mn FROM `user_wallet` where user_id=$user_id AND action_type=0 GROUP BY YEAR(`created_date`), MONTH(`created_date`) ORDER BY `created_date` DESC")->result_array();
		if(count($yrs)>0){
			foreach($yrs as $k=>$dt){
				$mn 				= $dt['mn'];
				$yr 				= $dt['yr'];
				unset($dt['mn']);
				$dt['history']= $this->db->query("SELECT `action_type`,`wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE YEAR(`created_date`)='$yr' AND MONTH(`created_date`)='$mn' AND `user_id`=$user_id AND action_type=0 ")->result_array();
				$response['data'][]=$dt;
			}
		}
		$response['status'] = 1;
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function statement_history_post(){
		$data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
		$start_date     = @$data['start_date'];
		$end_date       = @$data['end_date'];
		$valid_date = 1;
		if($start_date!='' && $end_date!=''){
			if($start_date>$end_date){
				$valid_date = 0;
			}
		}
		if($valid_date==1){
			$wh = ' ';
			if($start_date!='' && $end_date!=''){
				$wh.=" AND created_date >= '$start_date' AND created_date <= '$end_date' ";
			}else if($start_date!=''){
				$wh.=" AND created_date >= '$start_date'";
			}else if($end_date!=''){
				$wh.=" AND created_date <= '$end_date' ";
			}else{
				$wh.='';
			}
			$wh.=' ORDER BY created_date DESC ';
			$response['data']=$this->db->query("SELECT `action_type`,`wallet_id`, `amount`, balance,`type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE `user_id`=$user_id $wh")->result_array();
		}else{
			$response['status']  = 1;
			$response['message'] = 'End date must be grater or equal to start date';
		}
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function refund_history_post(){
		$data           = json_decode(file_get_contents("php://input"),true);
        $data           = (isset($data))? $data : $_POST;
        $user_id        = @$data['user_id'];
		$response=array();
		$yrs=$this->db->query("SELECT MONTHNAME(created_date) as mnth,YEAR(created_date) as yr,MONTH(created_date) as mn FROM `user_wallet` where user_id=$user_id AND action_type=4 GROUP BY YEAR(`created_date`), MONTH(`created_date`) ORDER BY `created_date` DESC")->result_array();
		if(count($yrs)>0){
			foreach($yrs as $k=>$dt){
				$mn 				= $dt['mn'];
				$yr 				= $dt['yr'];
				unset($dt['mn']);
				$dt['history']= $this->db->query("SELECT `action_type`,`wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE YEAR(`created_date`)='$yr' AND MONTH(`created_date`)='$mn' AND `user_id`=$user_id AND action_type=4 ")->result_array();
				$response['data'][]=$dt;
			}
		}
		$response['status'] = 1;
		$response['data']=array();
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function check_coupon_existed_or_not_post(){
		$data             = json_decode(file_get_contents("php://input"),true);
        $data             = (isset($data))? $data : $_POST;
        $user_id          = @$data['user_id'];
		$order_tot_amount = @$data['order_tot_amount'];
		$delivery_type    = @$data['delivery_type'];
		$code			  = @$data['coupon_code'];
		$response['status'] = 1;
		$offers_for_you=$this->db->query("SELECT `id`, `name`, `code`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `status`, `use_for`, `created_at`, `updated_at`, `deleted_at` FROM `coupon` WHERE  `use_for` IN (0,$user_id) AND code='$code'")->row_array();
		if(!empty($offers_for_you)){
			$curdate = date('Y-m-d');
			if($curdate>=$offers_for_you['start_date']){
				if($offers_for_you['end_date']>=$curdate){
				    if($offers_for_you['use_count']<$offers_for_you['max_use']){
    					if($offers_for_you['type']==0){
    						//$amt = $order_tot_amount-$offers_for_you['discount'];
    						$amt = $offers_for_you['discount'];
    					}else{
    						$perc = ($order_tot_amount*$offers_for_you['discount'])/100;
    						//$amt = $order_tot_amount-$perc;
    						$amt = $perc;
    					}
    					if($order_tot_amount<$amt){
    						$final = round($order_tot_amount);
    					}else{
    						$final = round($amt);
    					}
    					$response['coupon_id']=$offers_for_you['id'];
    					$response['coupon_code']=$code;
    					$response['coupon_amount']=number_format($final, 2, '.', '');
    					$final_ord = $order_tot_amount-$final;
    					$response['final_order_amt']=number_format($final_ord, 2, '.', '');
    					$response['message'] = 'Coupon applied successfully';
				    }else{
						$response['status'] = 0;
						$response['message'] = 'Total limits for coupon completed';
					}
				}else{
					$response['status'] = 0;
					$response['message'] = 'Coupon expaired';
				}
			}else{
				$response['status'] = 0;
				if($curdate<$offers_for_you['start_date']){
				    $response['message'] = 'This coupon started from '.date_month_name($offers_for_you['start_date']);
				}else{
				     $response['message'] = 'Invalid coupon';
				}
			}
		}else{
			$response['status'] = 0;
			$response['message'] = 'Invalid coupon';
		}
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function check_wallet_before_order_post(){
		$data             = json_decode(file_get_contents("php://input"),true);
        $data             = (isset($data))? $data : $_POST;
        $user_id          = @$data['user_id'];
		$order_amount     = @$data['order_amount'];
		$from = date('Y-m-d');
		$next_day = date("Y-m-d",strtotime($from.' +1 day'));
		$Wallet = $this->db->query("SELECT `final_wallet_amount`,reserved_amount FROM `users` WHERE `user_id`=$user_id")->row_array();
		$user_wallet 	= $Wallet['final_wallet_amount'];
		$reserved_amount = $Wallet['reserved_amount'];
		$Subc_Payment = $this->db->query("SELECT a.`qty`*b.prod_offered_price as amount FROM `prod_subscriptions` a INNER JOIN product_mesurments b ON a.`prod_mes_id`=b.id WHERE a.user_id=$user_id AND a.`is_active`=1 AND a.next_payment='$next_day'")->result_array();
		$Calc_Amt[]=0;
		if(count($Subc_Payment)>0){
			foreach($Subc_Payment as $sb){
				$Calc_Amt[]	=	$sb['amount'];
			}
		}
		$subscription_amt 		= array_sum($Calc_Amt);
		$response['reserved_for_subscription_amount']=0;
		$response['remaining_amt']=0;
		$response['user_wallet']=0;
		$response['status'] = 1;
		if($subscription_amt>0){
			$user_wallet = $user_wallet-$reserved_amount;
			$user_wallet = $user_wallet-$subscription_amt;
			$response['user_wallet']=$user_wallet;
			$response['reserved_for_subscription_amount']=$reserved_amount;
			if($user_wallet<$order_amount){
				$response['remaining_amt']=$order_amount-$user_wallet;
			}
		}else{
			if($user_wallet<$order_amount){
				$response['remaining_amt']=$order_amount-$user_wallet;
				$response['message'] = $user_wallet.' available only pay remaining through payment gateway';
			}else{
				$response['remaining_amt']=0;
			}
			$response['user_wallet']=$user_wallet;
			$response['status'] = 1;
			$this->set_response($response,REST_Controller::HTTP_CREATED);
		}
	}
	public function billing_history_details_post(){
		$data             = json_decode(file_get_contents("php://input"),true);
        $data             = (isset($data))? $data : $_POST;
        $user_id          = @$data['user_id'];
        $wallet_id          = @$data['wallet_id'];
		$details = $this->db->query("SELECT `refund_type`,`amount`,`description`,`transaction_id`,`invoice_id`,`type`,`action_type`,`created_date` FROM `user_wallet` WHERE `wallet_id`=$wallet_id")->row_array();
		$invoice_id = $details['invoice_id'];
		if($details['action_type']==0){
			$det=array('invoice_id'=>$details['invoice_id']);
		}else if($details['action_type']==1 || $details['action_type']==2){
			$sub=$this->db->query("SELECT a.`schedule_type`,b.prod_image,d.prod_title,c.title as mesurment FROM `prod_subscriptions` a LEFT JOIN product_mesurments b ON a.`prod_mes_id`=b.id LEFT JOIN mesurements c ON b.mes_id=c.mes_id LEFT JOIN products d ON a.`prod_id`=d.prod_id WHERE a.subscribe_id='$invoice_id'")->row_array();
			$det=$sub;
		}else if($details['action_type']==3){
			$ord = $this->db->query("SELECT a.`order_id`,a.`payment_id` as invoice_id,a.`payment_mode` FROM `orders` a WHERE a.`order_id`='$invoice_id'")->row_array();
			$det=$ord;
		}else{
			if($details['refund_type']==0){
				$det=array('invoice_id'=>$details['invoice_id']);
			}else if($details['refund_type']==1 || $details['refund_type']==2){
				$sub=$this->db->query("SELECT a.`schedule_type`,b.prod_image,d.prod_title,c.title as mesurment FROM `prod_subscriptions` a LEFT JOIN product_mesurments b ON a.`prod_mes_id`=b.id LEFT JOIN mesurements c ON b.mes_id=c.mes_id LEFT JOIN products d ON a.`prod_id`=d.prod_id WHERE a.subscribe_id='$invoice_id'")->row_array();
				$det=$sub;
			}else if($details['refund_type']==3){
				$ord = $this->db->query("SELECT a.`order_id`,a.`payment_id` as invoice_id,a.`payment_mode` FROM `orders` a WHERE a.`order_id`='$invoice_id'")->row_array();
				$det=$ord;
			}
		}
		$det=array_merge(array('description'=>$details['description'],'amount'=>$details['amount'],'transaction_date'=>$details['created_date'],'type'=>$details['action_type'],'transaction_id'=>$details['transaction_id']),$det);
		$response['status']  = 1;
		$response['history'] = $det;
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function delivery_slots_post(){
		$data             = json_decode(file_get_contents("php://input"),true);
        $data             = (isset($data))? $data : $_POST;
        $type = @$data['type'];
        $final=array();
		$slots = $this->db->query("SELECT `id`, `slot_from`, `slot_to`, `time_in_seconds` FROM `delivery_slots` WHERE is_active=1")->result_array();
		$delivery_date = date("Y-m-d");
		if($type==2){
		    $delivery_date = date("Y-m-d",strtotime($delivery_date.' +1 day'));
		}
		$tm=time2sec(date('H:i:s'));
		if(count($slots)>0){
		    foreach($slots as $s){
		        $s['available']=0;
		        if($type==1){
		            if($s['time_in_seconds']>$tm){
		                $s['available']=1;
		            }
		        }
		        $final[] = $s;
		    }
		}
		$response['status']  = 1;
		$response['current_time'] = $tm;
		$response['delivery_date']  = $delivery_date;
		$response['slots'] = $final;
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function all_my_coupons_post(){
		$data             = json_decode(file_get_contents("php://input"),true);
        $data             = (isset($data))? $data : $_POST;
        $user_id = @$data['user_id'];
		$offers = $this->db->query("SELECT `id`, `name`, `code`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `status`, `use_for`, `created_at`, `updated_at`, `deleted_at` FROM `coupon` WHERE `use_for`=$user_id OR use_for=0")->result_array();
		$response['status']  = 1;
		$response['offers'] = $offers;
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function service_and_delivery_charge_post(){
	    $response['service']  = Service_Charge();
		$response['delivery'] = Delivery_Charge();
		$this->set_response($response,REST_Controller::HTTP_CREATED);
	}
}
