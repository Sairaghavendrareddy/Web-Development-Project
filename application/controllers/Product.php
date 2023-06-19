<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function product_details($prod_slug='')
	{
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
		$data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		if($this->input->get('prod_search')!=''){
			$prod_title =$this->input->get('prod_search');
			$data['p_details'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`,`prod_slug`,`combo_products` FROM `products` WHERE `prod_title`='$prod_title' AND `prod_status`=1")->row_array();
		}else{
			$data['p_details'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`,`prod_slug`,`combo_products` FROM `products` WHERE `prod_slug`='$prod_slug' AND `prod_status`=1")->row_array();
		}
        
        $p_decode=$data['p_details']['prod_mesurements'];
        $data['p_decode'] = json_decode($p_decode, true);
        $cat_id = $data['p_details']['prod_category'];
		$subcat_id = $data['p_details']['prod_sub_category'];
		$prod_id = $data['p_details']['prod_id'];
        $data['similar_products'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `available_subscraibe`,`prod_slug`,`combo_products` FROM `products` WHERE `prod_category`=1 AND `prod_sub_category`=1 AND `prod_status`=1 AND `prod_id`!=$prod_id")->result_array();
        $this->recent_products($prod_id);
         // echo $this->db->last_query();exit;
        if($this->session->userdata('user_id')!='')
		 {
		 	$user_id =$this->session->userdata('user_id');
		 }else{
		 	$user_id = $this->input->ip_address();
		 }
         $data['recent_products'] =$this->db->query("SELECT `t1`.`recent_products_id`, `t1`.`prod_id`, `t1`.`user_id`,`t2`.`prod_id`, `t2`.`prod_title`, `t2`.`prod_category`, `t2`.`prod_sub_category`, `t2`.`prod_brand`, `t2`.`prod_mesurements`, `t2`.`prod_status`, `t2`.`prod_available_locations`, `t2`.`orders_count`, `t2`.`prod_description`, `t2`.`sub_cat_id`, `t2`.`available_subscraibe`, `t2`.`prod_slug`,t2.`combo_products` FROM `recent_products` as `t1` LEFT JOIN `products` as `t2` ON `t1`.`prod_id` = `t2`.`prod_id` WHERE `t1`.`user_id`='$user_id'")->result_array();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/product_details');
		$this->load->view('frontend/footer');
	}
	public function recent_products($prod_id)
	{
		// echo $prod_id;exit;
		 if($this->session->userdata('user_id')!='')
		 {
		 	$user_id =$this->session->userdata('user_id');
		 }else{
		 	$user_id = $this->input->ip_address();
		 }
		 $check =$this->db->query("SELECT `recent_products_id`, `prod_id`, `user_id`, `created_date` FROM `recent_products` WHERE `user_id`='$user_id' AND `prod_id`=$prod_id")->row_array();
		 if(($check) >0){

		 }else{
		 	 $ip_address = $this->input->ip_address();
	         $created_date =date('Y-m-d');
	         $data =array('prod_id' =>$prod_id,'user_id' =>$user_id,'created_date' =>$created_date);
	         $this->db->insert('recent_products',$data);
		 }
			 
	}
	public function product_list($cat_id='',$subcat_id='')
	{
		$data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		$data['cat_id']=  $cat_id;
        $data['subcat_id']=  $subcat_id;
        $data['search']=  $this->input->get('search');
        
	        $wh='prod_status=1';
	        if($cat_id!=''){
	        	$wh.=" AND `t1.prod_category`=$cat_id";
	        }
	        if($subcat_id!=''){
	        	$wh.=" AND t1.`prod_sub_category`=$subcat_id";
	        }
	      if($this->input->get('search')!=''){
            $title=$this->input->get('search');
        	$wh.=" AND t1.`prod_title` LIKE '%$title%'";
         }
        //  if(isset($data['measurement']) && $data['measurement']!=''){
        //     $measurement="'". implode("','",$data['measurement'])."'";
        //     $wh.=" AND  prod_title IN ($measurement)";
        // }
	     // echo"<pre>";print_r($wh);exit;
         	$data['menu_list']=$this->web_model->getmenuListByid($wh);
	    	$data['brands']=$this->web_model->getBrands($wh);
	    	// echo"<pre>";print_r($data['menu_list']);exit;
		
               
	    $data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
	   if(!empty($data['menu_list'])){
			$data['ppage']= $this->load->view('frontend/all_prods',$data,TRUE);
			$data['titles']=$this->web_model->getmenuidByidTitles($wh);
			$data['prices']=$this->web_model->getmenuidByidPrices($wh);
			// echo"<pre>";print_r($data['ppage']);exit;
			// $data['vehicle_maker']=$this->web_model->getmenuidByidVehicleMaker($wh);
			// $data['get_filters']=$this->web_model->getmenuListByid1($wh);

			// echo"<pre>";print_r($data['get_filters']);exit;
			// echo"<pre>";print_r($data['menu_list']);exit;
			$this->load->view('frontend/header',$data);
			$this->load->view('frontend/menu');
			$this->load->view('frontend/product_list');
			$this->load->view('frontend/footer');
    	}else{
    	   $this->load->view('frontend/header',$data);
			$this->load->view('frontend/menu');
			$this->load->view('frontend/no_data_found');
			$this->load->view('frontend/footer');
    	}
	}
	public function onscroll_data()
    {
      	 $limit =$this->input->post('limit'); 
      	 $start =$this->input->post('start');
      	 $cat_id=  $this->input->post('cat_id');
         $subcat_id=  $this->input->post('subcat_id');
         $search=  $this->input->post('search');
         $brand=  $this->input->post('brand');
         $title=  $this->input->post('title');
         $price=  $this->input->post('price');
      	 $data['cat_id']=  $this->input->post('cat_id');
         $data['subcat_id']=  $this->input->post('subcat_id');
         $data['search']=  $this->input->post('search');
         $data['brand']=  $this->input->post('brand');
         $data['title']=  $this->input->post('title');
         $data['price']=  $this->input->post('price');
	        $wh='t1.prod_status=1';
	        if($cat_id!=''){
	        	$wh.=" AND t1.prod_category=$cat_id";
	        }
	        if($subcat_id!=''){
	        	$wh.=" AND t1.prod_sub_category=$subcat_id";
	        }
	         if(isset($data['brand']) && $data['brand']!=''){
            	$brand="'". implode("','",$data['brand'])."'";
            	$wh.=" AND  t1.prod_brand IN ($brand)";
        	}
        	if(isset($data['price']) && $data['price']!=''){
            	$price="'". implode("','",$data['price'])."'";
            	$wh.=" AND  t3.prod_offered_price IN ($price)";
        	}
        	if(isset($data['title']) && $data['title']!=''){
            	$ms_title="'". implode("','",$data['title'])."'";
            	$wh.=" AND  t3.mes_id IN ($ms_title)";
        	}
	       if($search!=''){
	       		$wh.=" AND t1.`prod_title` LIKE '%$search%'";
	        }
	        $data['res']=$this->web_model->fetch_data($limit,$start,$wh);
	        // $res=$this->web_model->fetch_data($limit,$start,$wh);
	       // echo"<pre>";print_r($data['res']);exit;
      	 	$data =$this->load->view('frontend/load_more_data',$data);
     }
	public function getfilter_data()
	{
          $wh='t1.prod_status=1';
         $data=$this->input->post();
         // echo "<pre>";print_r($data);exit;
        
        if(isset($data['cat_id']) && $data['cat_id']!=''){
            $cat_id=$data['cat_id'];
            $wh.=" AND t1.prod_category=$cat_id";
        }
        if(isset($data['subcat_id']) && $data['subcat_id']!=''){
            $subcat_id=$data['subcat_id'];
            $wh.=" AND  t1.prod_sub_category=$subcat_id";
        }
        if($this->input->post('search')!=''){
            $title=$this->input->post('search');
        $wh.=" AND `t1`.`prod_title` LIKE '%$title%'";
        }
        if(isset($data['brand']) && $data['brand']!=''){
            $brand="'". implode("','",$data['brand'])."'";
            $wh.=" AND  t1.prod_brand IN ($brand)";
        }
        if(isset($data['price']) && $data['price']!=''){
            $price="'". implode("','",$data['price'])."'";
            $wh.=" AND  t3.prod_offered_price IN ($price)";
        }
        if(isset($data['title']) && $data['title']!=''){
            $ms_title="'". implode("','",$data['title'])."'";
            $wh.=" AND  t3.mes_id IN ($ms_title)";
        }
        $data['menu_list']=$this->web_model->getmenuListByid($wh);
         // echo"<pre>";print_r($data['menu_list']);exit;
         // $data['brands']=$this->web_model->getBrands($wh);
        // echo $this->db->last_query();exit;
        $data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1 LIMIT 1")->result_array();
	   // $data['ppage']= $this->load->view('frontend/all_prods',$data,TRUE);
	    // echo"<pre>";print_r($data['menu_list']);exit;
        // $this->load->view('frontend/header',$data);
        // $this->load->view('frontend/menu');
        if(!empty($data['menu_list'])){
        	echo $this->load->view('frontend/all_prods',$data,true);
        }else{
        	echo $this->load->view('frontend/no_data_found','',true);
        }
        
        // $this->load->view('frontend/footer');

    }
    public function subscribe($prod_id='')
	{
		 checkuser_login();
		$user_id =$this->session->userdata('user_id');
		$data['subscribe'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`, `prod_slug` FROM `products` WHERE `prod_id`=$prod_id AND `available_subscraibe`=1")->row_array();
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
		$data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		$data['default_address'] =$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`,t3.`user_id`,t3.`name`,t3.`phone`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` INNER JOIN users as t3 ON t1.`user_id`=t3.`user_id` WHERE t1.`user_id`=$user_id AND t1.`is_latest`=1")->row_array();
		 // echo"<pre>";print_r($data['subscribe']);exit;
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/subscribe');
		$this->load->view('frontend/footer');
	}	
	public function ajaxcall_get_user_address()
	{
		$user_id =$this->session->userdata('user_id');
		$data['default_address'] =$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`,t3.`user_id`,t3.`name`,t3.`phone`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` INNER JOIN users as t3 ON t1.`user_id`=t3.`user_id` WHERE t1.`user_id`=$user_id AND t1.`is_latest`=1")->row_array();
		echo $this->load->view('frontend/ajax_user_address',$data,TRUE);
	}
	public function save_subscription(){
        $post =$this->input->post();
        // echo "<pre>";print_r($post);exit;
        $user_id       = 1;
        $prod_id       = $this->input->post('prod_id');
        $prod_mesids   = $this->input->post('prod_mes_id');
		$qty_id        =$this->input->post('qty');
		$from_date     = @$data['sub_from_date'];
		$to_date       = @$data['sub_to_date'];
		$from          = yy_mm_dd($from_date);
		$to            = yy_mm_dd($to_date);
		$existed_count = $this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `qty`, `from_date`, `to_date`, `type`, `is_active`, `created_date` FROM `prod_subscriptions` WHERE `user_id`=$user_id AND `prod_id`=$prod_id AND is_active<3")->result_array();
		$tot_count = $this->db->query("SELECT `id` FROM `product_mesurments` WHERE `prod_id`=$prod_id")->num_rows();
		// print_r(count($existed_count));
		// print_r($tot_count);exit;
		// echo $tot_count;exit;
		if(count($existed_count)==$tot_count){
		    $this->db->insert_batch('temp_prod_subscriptions',$existed_count);
		    $this->db->delete('prod_subscriptions',array('prod_id'=>$prod_id,'user_id'=>$user_id));
		}
        // $response['status'] =   0;
		if($to >= $from){
			if(count($prod_mesids)>0){
				// print_r(count($prod_mesids));exit;
				$fail = array();
				$Arr_Dat = array();
				$check=array();
				foreach($prod_mesids as $k=>$prod){
					$prod_mes_id = $prod;
					$qty = $qty_id[$k];
					if($qty>0){
						$Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'prod_id'=>$prod_id,'prod_mes_id'=>$prod_mes_id,'is_active<'=>3),'');
						//echo $this->db->last_query();exit;
						if($Check_Subscribe>0){
							$dt=$this->db->query("SELECT b.title FROM `product_mesurments` a JOIN mesurements b ON a.`mes_id`=b.mes_id WHERE a.id=$prod_mes_id")->row_array();
							$check[] = $dt['title'];
						}else{
							$final = array(
								'user_id'=>$user_id,
								'prod_id'=>$prod_id,
								'prod_mes_id'=>$prod_mes_id,
								'qty'=>$qty,
								'from_date'=>$from_date,
								'to_date'=>$to_date,
								'created_date'=>date('Y-m-d H:i:s')
							);
							$Arr_Dat[] = $final;
							$this->common_model->commonInsert('prod_subscriptions',$final);
						}
					}
				}
				// print_r($check);exit;
				if(count($check)==0){
					redirect('product/subscription_list/successfully');
					// $response['message'] = 'Subscribed successfully';
				}else{
					if(count($check)==count($prod_mesids)){
						$name = (count($check)>1)?'measurements':'measurement';
						// $response['message'] = 'Subscribed successfully';
						$faild=implode(',',$check).' '.$name.' Already subscribed';
						redirect('product/subscription_list/Alreadysubscribed');
					}else{
						$name = (count($check)>1)?'measurements':'measurement';
						// $response['message'] = 'Subscribed successfully';
						$faild=implode(',',$check).' '.$name.' Already subscribed';
						redirect('product/subscription_list/Alreadysubscribed2');
					}
					
				}
			}else{
				$message = 'Please check product measurements ';
				redirect('product/subscription_list/Pleasecheckproductmeasurements');
			}
		}else{
			$message= 'Please check once from and to dates';
			redirect('product/subscription_list/Pleasecheckoncefromandtodates');
		}
        // $this->set_response($response,REST_Controller::HTTP_CREATED);
	}
	public function save_subscription1()
	{
		$user_id =1;
		$post =$this->input->post();
		unset($post['add_subscription']);
		foreach($post['prod_id'] as $key => $res) {
		      $dataToSave = array(
		      	'user_id' => $user_id,
		        'prod_id' => $res,
		        'prod_mes_id' => $post['prod_mes_id'][$key],
		        'qty' => $post['chck_qty'][$key],
		        'from_date' => date("Y-m-d", strtotime($post['sub_from_date'])),
		        'to_date' => date("Y-m-d", strtotime($post['sub_to_date'])),
		        'type' => "no_change",
		        'is_active' => 1,
		        'created_date'=>date("Y-m-d h:i:s")
		      );
      		$this->db->insert('prod_subscriptions', $dataToSave);
  		  }
  		 redirect('product/subscription_list');
	}
	public function subscription_list()
	{
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1 LIMIT 1")->result_array();
		 // echo"<pre>";print_r($data['subscribe']);exit;
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/subscription_list');
		$this->load->view('frontend/footer');	
	}
	public function get_combo_details()
	{
		$prod_id =$this->input->post('prod_id');
		$data['res'] =$this->db->query("SELECT t1.`prod_id`, t1.`combo_products`, t1.`prod_slug`,t2.`prod_id` as proid,t2.`prod_title` as title FROM `products` as t1 LEFT JOIN `products` as `t2` ON `t1`.`prod_id` = `t2`.`prod_id` WHERE t1.`prod_id`=$prod_id")->row_array();
		// echo $this->db->last_query();exit;
		// echo"<pre>";print_r($data);exit;
		echo $this->load->view('frontend/view_combos',$data,TRUE);
	}
	public function offers($banner_id='')
	{
		$data['banner_id']=$banner_id;
		$user_id =$this->session->userdata('user_id');
		if($user_id==''){
			$user_id = 0;
		}
		if($banner_id==''){
			$banner_id = 0;
		}
		$data['page_title']=$this->db->query("SELECT `title` FROM `prod_offer_banners` WHERE `id`=$banner_id")->row_array();
		// echo"<pre>";print_r($data['page_title']);exit;
		$products_list=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.`prod_slug`,a.`prod_category`,b.`title` AS `cat_title`,a.`available_subscraibe`,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.`brand_title`,br.`brand_id`,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.`prod_id` AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.`combo_products` FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.`cat_id` LEFT JOIN  category_brands br ON br.`brand_id`=a.`prod_brand` WHERE a.`prod_status`=1 AND a.`is_popular`=1 ORDER BY a.`orders_count` DESC")->result_array();
		$data['res']=$products_list;
			foreach ($products_list as $brands_list) {
				$brand_ids= $brands_list['brand_id'];
				if($brand_ids!=''){
					$getbrands[] =$this->db->query("SELECT `brand_id`,  `brand_title` FROM `category_brands` WHERE `brand_id`=$brand_ids")->row_array();
				}
			}
			if(!empty($getbrands)){
			   $data['brands'] =array_unique($getbrands, SORT_REGULAR); 
			}
		
// 		echo"<pre>";print_r($brands);exit;

		foreach ($products_list as $prod_id_list) {
				$prod_ids= $prod_id_list['prod_id'];
				if($prod_ids!=''){
					$getprods[] =$this->db->query("SELECT t1.`prod_id`, t2.`prod_id`,t2.`prod_offered_price` FROM `products` t1 LEFT JOIN product_mesurments t2 ON t1.`prod_id`=t2.`prod_id` WHERE t1.`prod_id`=$prod_ids")->row_array();
					// echo"<pre>";print_r($getprods);exit;
				}
			}
		$data['prices'] =array_column($getprods, null, 'prod_offered_price');
		// echo"<pre>";print_r($data['prices']);exit;

		foreach ($products_list as $prod_id_list) {
				$prod_ids_mes= $prod_id_list['prod_id'];
				if($prod_ids_mes!=''){
					$getprod_mesids[] =$this->db->query("SELECT t1.`prod_id`, t2.`prod_id`,t2.`mes_id`,t3.`mes_id`,t3.`title` FROM `products` t1 LEFT JOIN product_mesurments t2 ON t1.`prod_id`=t2.`prod_id` LEFT JOIN mesurements t3 ON t2.`mes_id`=t3.`mes_id` WHERE t1.`prod_id`=$prod_ids_mes ORDER BY t2.`prod_id` ASC")->row_array();
					// $usedVals[] = $getprod_mesids['mes_id'];
					// $usedVals[] = $getprod_mesids['title'];
					// echo"<pre>";print_r($getprod_mesids);exit;
				}
			}
		$data['titles'] =array_column($getprod_mesids, null, 'mes_id');
		// echo"<pre>";print_r($data['titles']);exit;


		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
		$data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		// $data['brands']
		// echo"<pre>";print_r($data['res']);exit;
		$data['ppage']= $this->load->view('frontend/all_offer_prods',$data,TRUE);
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/offers');
		$this->load->view('frontend/footer');	
	}
	public function offer_getfilter_data(){
          $wh='t1.prod_status=1';
         $data=$this->input->post();
         $banner_id =$data['banner_id'];
         // echo "<pre>";print_r($data);exit;
        if(isset($data['brand']) && $data['brand']!=''){
            $brand="'". implode("','",$data['brand'])."'";
            $wh.=" AND  t1.prod_brand IN ($brand)";
        }
        if(isset($data['price']) && $data['price']!=''){
            $price="'". implode("','",$data['price'])."'";
            $wh.=" AND  t3.prod_offered_price IN ($price)";
        }
        if(isset($data['title']) && $data['title']!=''){
            $ms_title="'". implode("','",$data['title'])."'";
            $wh.=" AND  t3.mes_id IN ($ms_title)";
        }
        $data['page_title']=$this->db->query("SELECT `title` FROM `prod_offer_banners` WHERE `id`=$banner_id")->row_array();
        if($data['id']==2){
        	$user_id =$this->session->userdata('user_id');
		if($user_id==''){
			$user_id = 0;
		}
		
		$data['res']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.`prod_slug`,a.prod_category,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,br.brand_id,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 AND a.is_popular=1 ORDER BY a.orders_count DESC")->result_array();
		// echo"<pre>";print_r($data['page_title']);exit;
        }else{
        	$data['res']=$this->web_model->getOfferMenuListByid($wh);
        }
        	 
        // echo"<pre>";print_r($data['page_title']);exit;
       
         // echo"<pre>";print_r($data['res']);exit;
         // $data['brands']=$this->web_model->getBrands($wh);
        // echo $this->db->last_query();exit;
        $data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1 LIMIT 1")->result_array();
	   // $data['ppage']= $this->load->view('frontend/all_prods',$data,TRUE);
	    // echo"<pre>";print_r($data['menu_list']);exit;
        // $this->load->view('frontend/header',$data);
        // $this->load->view('frontend/menu');
        if(!empty($data['res'])){
        	echo $this->load->view('frontend/all_offer_prods',$data,true);
        }else{
        	echo $this->load->view('frontend/no_data_found','',true);
        }
        
        // $this->load->view('frontend/footer');

    }	

}