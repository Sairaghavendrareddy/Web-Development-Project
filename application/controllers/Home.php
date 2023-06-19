<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
        $data['pop_list'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`,`prod_slug`,`combo_products` FROM `products` WHERE `is_popular`=1 AND `prod_status`=1")->result_array();
        $data['bestprod_list'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, SUM(`orders_count`), `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`,`prod_slug`,`combo_products` FROM `products` WHERE orders_count > 0 GROUP BY `prod_id` ORDER BY `orders_count` DESC LIMIT 20")->result_array();
        $data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
        $data['popular_banners']=$this->db->query("SELECT `id`, `page`, `module`, `title`, `image`, `description`, `prods`, `is_active`, `created_at`, `updated_at` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='products' AND `is_active`=1")->result_array();
        $data['best_seller_banners']=$this->db->query("SELECT `id`, `page`, `module`, `title`, `image`, `description`, `prods`, `is_active`, `created_at`, `updated_at` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='best' AND `is_active`=1")->result_array();
        $user_id=$this->session->userdata('user_id');
        if($user_id==''){
			$user_id = 0;
		}
        $data['deals_of_the_day']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,a.`prod_slug`,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 ORDER BY a.orders_count DESC")->result_array();
        $data['deal_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='deal'")->result_array();
        $data['subscriptions']=$this->db->query("SELECT a.`prod_id`, a.`prod_title`, a.`prod_mesurements`,a.`prod_status`, a.`prod_available_locations`,a.prod_category,a.`prod_slug`,b.title AS cat_title,a.available_subscraibe,(SELECT COUNT(`favourate_id`) FROM `favourate_products` WHERE `product_id`=prod_id AND `user_id`=$user_id) as favourate_or_not,br.brand_title,(SELECT COUNT(`subscribe_id`) FROM `prod_subscriptions` WHERE `prod_id`=a.prod_id AND `user_id`=$user_id AND is_active<3) AS subscraibed_or_not,a.combo_products FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id LEFT JOIN  category_brands br ON br.brand_id=a.prod_brand WHERE a.prod_status=1 AND a.available_subscraibe=1 ORDER BY a.orders_count DESC")->result_array();
		$data['subscription_banners']=$this->db->query("SELECT `id`, `title`, `image`, `description` FROM `prod_offer_banners` WHERE `page`='home' AND `module`='offer'")->result_array();
        // echo "<pre>";print_r( $data['subscriptions']);exit;	
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/home');
		$this->load->view('frontend/footer');
	}
	public function get_measurement_id_by_products()
	{
        $prod_mes_id1 =$this->input->post('prod_mes_id');
		$data =$this->db->query("SELECT `t1`.`id`, `t1`.`prod_id`, `t1`.`mes_id`, `t1`.`prod_image`,`t1`.`prod_image_name`, `t1`.`prod_org_price`, `t1`.`prod_offered_price`, `t1`.`prod_available_qty`,`t2`.`mes_id`,`t2`.`title` FROM `product_mesurments` as `t1` LEFT JOIN `mesurements` as `t2` ON `t1`.`mes_id` = `t2`.`mes_id` WHERE `t1`.`id`=$prod_mes_id1")->row_array();
		 // echo "<pre>";print_r( $data);exit;

		$json =$data['prod_image'];
		// print_r($json);exit;
		$img1 = json_decode($json, true);
		// print_r($img1);exit;
		$url =base_url()."assets/products/";
		$img =$url . $img1[0];
		// print_r($img);exit;
		$prod_id =$data['prod_id'];
		$prod_mes_id =$data['id'];
		$prod_mes_title =$data['title'];
		$prod_org_price =$data['prod_org_price'];
		$prod_offered_price =$data['prod_offered_price'];
		$cart = $this->cart->contents();
		// echo '<pre>';print_r($cart);exit;
		$cart_prod_mes_id=array();
		$cart_qty=array();
		$rowid=array();
		if(!empty($cart)){
			foreach ($cart as $cart_data) {
				if($prod_mes_id==$cart_data['name']){
				 $cart_prod_mes_id[] =$cart_data['name'];
				 $rowid =$cart_data['rowid'];
				// echo "<pre>";print_r($rowid);exit;
				 $cart_qty[$cart_data['name']] =$cart_data['qty'];
				}
			}
			 $chk_prod_exits = in_array($prod_mes_id,$cart_prod_mes_id);
			 $prod_mes_id_qty = @$cart_qty[$prod_mes_id];
			}else{
				$chk_prod_exits='';
				$prod_mes_id_qty='';
			}
			// echo "<pre>";print_r($rowid);exit;
		$returnArr= array(
			'rowid'=>$rowid,
		 	'img'=>$img,
		 	'prod_org_price'=>$prod_org_price,
		 	'prod_offered_price'=>$prod_offered_price,
		 	'prod_id'=>$prod_id,
		 	'prod_mes_id'=>$prod_mes_id,
		 	'prod_mes_title'=>$prod_mes_title,
		 	'chk_prod_exits'=>$chk_prod_exits,
		 	'prod_mes_id_qty'=>$prod_mes_id_qty,
		 	'cart_count'=>count($this->cart->contents())
	    );
// print_r($returnArr);exit;
		// $returnArr = [$img,$prod_org_price,$prod_offered_price,$prod_id,$prod_mes_id,$chk_prod_exits,$prod_mes_id_qty];    
		echo json_encode($returnArr);
	}
	public function addtocart()
	{
		$post =$this->input->post();
		// echo "<pre>";print_r($post);exit;
		$this->session->unset_userdata('coupon_code');
		$this->session->unset_userdata('coupon_amount');
		$this->session->unset_userdata('final_order_amt');
		$prod_id =$this->input->post('prod_id');
		$prod_title =$this->input->post('prod_title');
		$prod_mes_title =$this->input->post('prod_mes_title');
		$prod_mes_id =$this->input->post('prod_mes_id');
		$prod_available_qty =@$this->input->post('prod_available_qty');
		$prod_org_price =$this->input->post('prod_org_price');
		$prod_offered_price =$this->input->post('prod_offered_price');
		$qty =1;
		$prod_image =$this->input->post('prod_img');
		$data = array(
	        'id'      => 'sku_'.$prod_mes_id.'',
	        'qty'     => $qty,
	        'price'   => $prod_offered_price,
	        'name' => $prod_mes_id,
	        'options' => array('prod_id' => $prod_id,'prod_title' => $prod_title,'prod_mes_title' => $prod_mes_title, 'prod_mes_id' => $prod_mes_id,'prod_org_price' => $prod_org_price,'prod_image' => $prod_image)
		);
		// echo "<pre>";print_r($data);exit;
		// $cart = $this->cart->contents();
		// print_r($cart);exit;
		 // foreach ($cart as $contents) {
		 // 	$rowid = $contents['rowid'];
		 // 	$product_id = $contents['name'];
		 // 	if($product_id==$prod_id){
		 // 		$update_cart = array(
		 //            'rowid'         => $rowid,
		 //            'name'         => $product_id,
		 //            'qty'           => 0
   //      	 	 );
   //    			$this->cart->update($update_cart);
		 // 	}
		 // } 
		 
		 // print_r($data);exit;
		$rowid =$this->cart->insert($data);
		if($rowid!=''){
			$cart_count = count($this->cart->contents());
			$arr =['rowid' =>$rowid,'cart_count' =>$cart_count];
			echo json_encode($arr);
		}else{
			echo 0;
		}
		
		
	}
	public function cart(){
        $catrData =$this->cart->contents();
        // print_r($catrData);exit;
        if(!empty($catrData)){
            $this->load->view('frontend/cart');
         }else{
          
            $this->load->view('frontend/noitems_in_cart');
            
          }
    }
    
    public function plus_prod_qty()
    {
    	$rowid=$this->input->post('rowid');
    	$prod_id=$this->input->post('prod_id');
    	$prod_mes_id=$this->input->post('prod_mes_id');
    	$get_qty =$this->db->query("SELECT `id`, `prod_id`, `mes_id`, `prod_available_qty` FROM `product_mesurments` WHERE `prod_id`=$prod_id AND `id`=$prod_mes_id")->row_array();
    	$chkqty =$get_qty['prod_available_qty'];
    	$qty=$this->input->post('qty')+1;
    	if($qty <= $chkqty){
	 		$update_cart = array('rowid'=> $rowid,'qty'=> $qty);
  			$this->cart->update($update_cart);
  			echo $this->cart->total();
    	}else{
    		echo "no_qty";
    	}
	}
	public function ajax_plus_prod_qty()
    {
    	$prod_id=$this->input->post('prod_id');
    	$prod_mes_id=$this->input->post('prod_mes_id');
    	$rowid=$this->input->post('rowid');
    	$get_qty =$this->db->query("SELECT `id`, `prod_id`, `mes_id`, `prod_available_qty` FROM `product_mesurments` WHERE `prod_id`=$prod_id AND `id`=$prod_mes_id")->row_array();
    	$chkqty =$get_qty['prod_available_qty'];
    	$qty=$this->input->post('qty')+1;
    	if($qty <= $chkqty){
	 		$update_cart = array(
	            'rowid'         => $rowid,
	            'qty'           => $qty
		 	 );
				$this->cart->update($update_cart);
				echo $this->cart->total();
    	}else{
    		echo 0;
    	}
		 
    }
    public function minus_prod_qty()
    {
    	$rowid=$this->input->post('rowid');
    	$prod_mes_id=$this->input->post('prod_mes_id');
    	$qty=$this->input->post('qty') - 1;
		$update_cart = array('rowid' => $rowid,'qty' => $qty);
		$this->cart->update($update_cart);
		$this->session->unset_userdata('coupon_code');
		$this->session->unset_userdata('coupon_amount');
		$this->session->unset_userdata('final_order_amt');
		$cart_tatl = $this->cart->total();
		$cart_count = count($this->cart->contents());
		// echo $cart_count;exit;
		$arr =array('qty'=>$qty,'cart_tatl'=>$cart_tatl,'cart_count'=>$cart_count);
		// echo "<pre>";print_r($arr);exit;
		echo json_encode($arr);
	}
    public function ajax_minus_prod_qty()
    {
    	$prod_id=$this->input->post('prod_id');
    	$prod_mes_id=$this->input->post('prod_mes_id');
    	$qty=$this->input->post('qty')-1;
    	$rowid=$this->input->post('rowid');
	    $update_cart = array('rowid' => $rowid,'qty' => $qty);
		$res =$this->cart->update($update_cart);
		$this->session->unset_userdata('coupon_code');
		$this->session->unset_userdata('coupon_amount');
		$this->session->unset_userdata('final_order_amt');
		if($res==1){
			$cart_tatl = $this->cart->total();
			$cart_count = count($this->cart->contents());
	  			// echo $cart_count;exit;
	  			$arr =array('qty'=>$qty,'cart_tatl'=>$cart_tatl,'cart_count'=>$cart_count);
	  			// echo "<pre>";print_r($arr);exit;
	  			echo json_encode($arr);
	 	}else{
	 		echo 0;
	 	}
		   
    }
    public function signup_using_otp()
    {
    	$mobile_no =$this->input->post('mobile_no');
    	// $rand_no =mt_rand(2000,9000);
    	$rand_no =1111;
    	$chk_query =$this->db->query("SELECT `phone` FROM `users` WHERE `phone` = $mobile_no")->num_rows();
    	if(($chk_query) > 0){
    		$update=array('otp'=>$rand_no);
    	    $this->db->where('phone',$mobile_no);
    	    $res =$this->db->update('users',$update);
    	 }else{
    	    $arr =array('name'=>'The Soilson','fname'=>'The','lname'=>'Soilson','phone' =>$mobile_no,'otp' =>$rand_no,'status' =>0,'created_date' =>date("Y-m-d h:i:s")
    		);
	    	$res =$this->db->insert('users',$arr); 	
    	 }
    	echo $res;
    }
    public function chk_signup_otp()
    {
    	$mobile_no =$this->input->post('mobile_no');
    	$digit1 =$this->input->post('digit1');
    	$digit2 =$this->input->post('digit2');
    	$digit3 =$this->input->post('digit3');
    	$digit4 =$this->input->post('digit4');
    	$chk_otp = $digit1 . $digit2 . $digit3 . $digit4;
    	$chk_query =$this->db->query("SELECT `otp`, `phone` FROM `users` WHERE `otp` = $chk_otp AND `phone` = $mobile_no")->num_rows();
    	if(($chk_query) > 0){
    		$update_status=array('status'=>1);
    	    $this->db->where('phone',$mobile_no);
    	    $this->db->update('users',$update_status);
    	    $get_userdata =$this->db->query("SELECT `user_id`, `name`, `fname`, `lname` FROM `users` WHERE `phone`=$mobile_no And `status`=1")->row_array();
    	 	$this->session->set_userdata(array(
				'user_id' => $get_userdata['user_id'],
				'user_name' => $get_userdata['name']
		 	));
    		echo 1;
    	}else{
    		echo 0;
    	}
    }
    public function resend_otp()
    {
    	$mobile_no =$this->input->post('mobile_no');
    	$chk_ph_no =$this->db->query("SELECT `otp`, `phone` FROM `users` WHERE `phone` = $mobile_no AND `status`=1")->num_rows();
    	if(($chk_ph_no) > 0){
    		$rand_no =mt_rand(2000,9000);
    		$update_status=array('otp'=>$rand_no);
    	    $this->db->where('phone',$mobile_no);
    	    $this->db->update('users',$update_status);
    	    echo 1;
    	}else{
    		echo 0;
    	}
    }
    public function logout()
    {
    	$this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('coupon_code');
		$this->session->unset_userdata('coupon_amount');
		$this->session->unset_userdata('final_order_amt');
        redirect(site_url());
    }
    public function get_cartdata()
    {
    	$data['cart'] = $this->cart->contents();
    	// echo "<pre>";print_r($data);exit;
    	echo $this->load->view('frontend/ajaxcart',$data,TRUE);
    }
    public function subscribe_cron(){
        $this->load->model('common_model');
        $msg=$this->common_model->subscribe_cron();
    }
	
}