<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
		$data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/cart');
		$this->load->view('frontend/footer');
	}
	public function check_coupon_existed_or_not(){
		$user_id   = $this->session->userdata('user_id');
        $code      = $this->input->post('coupon_code');
        $order_tot_amount = $this->input->post('order_tot_amount');
		$delivery_type    = @$data['delivery_type'];
		$offers_for_you=$this->db->query("SELECT `id`, `name`, `code`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `status`, `use_for`, `created_at`, `updated_at`, `deleted_at` FROM `coupon` WHERE  `use_for` IN (0,$user_id) AND code='$code'")->row_array();
		// echo $this->db->last_query();exit;
		if(!empty($offers_for_you)){
			$curdate = date('Y-m-d');
			// echo $curdate;
			// print_r($offers_for_you['start_date']);exit;
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
    						$final = $order_tot_amount;
    					}else{
    						$final = $amt;
    					}
    					$data['coupon_id']=$offers_for_you['id'];
    					$data['coupon_code']=$code;
    					$data['coupon_amount']=number_format($final, 2, '.', '');
    					$final_ord = $order_tot_amount-$final;
    					$data['final_order_amt']=number_format($final_ord, 2, '.', '');
    					$data['status']=1;
    					$data['msg']='Coupon applied successfully';
    					// $data['message'] = 'Coupon applied successfully';
    					// echo "<pre>";print_r($data);exit;
    					$coupon_session_data = array(
    						   'coupon_id'  => $offers_for_you['id'],
			                   'coupon_code'  => $code,
			                   'coupon_amount'     => number_format($final, 2, '.', ''),
			                   'final_order_amt' => number_format($final_ord, 2, '.', '')
               			);
    					$this->session->set_userdata($coupon_session_data);
    					// echo "<pre>";print_r($data);exit;
    					echo json_encode($data);
				    }else{
						 $data = ['status' =>0,'msg' =>'Total limits for coupon completed'];
						 echo json_encode($data);
					}
				}else{
					$data = ['status' =>0,'msg' =>'Coupon expaired'];
				    echo json_encode($data);
				}
			}else{
				if($curdate<$offers_for_you['start_date']){
					$date_get ='This coupon started from '.date_month_name($offers_for_you['start_date']);
				    $data = ['status' =>0,'msg' =>$date_get];
				    echo json_encode($data);
				}else{
				     $data = ['status' =>0,'msg' =>'Invalid coupon'];
				     echo json_encode($data);
				}
			}
		}else{
			$data = ['status' =>0,'msg' =>'Invalid coupon'];
		    echo json_encode($data);
		}
	}
	public function remove_coupon()
	{
		// $this->session->sess_destroy();
		$this->session->unset_userdata('coupon_code');
		$this->session->unset_userdata('coupon_amount');
		$this->session->unset_userdata('final_order_amt');
		echo 1;

	}
	public function removecart()
    {
    	$rowid=$this->input->post('rowid');
        $removed_cart = array(
            'rowid'         => $rowid,
            'qty'           => 0
         );
         $res =$this->cart->update($removed_cart);
         $this->session->unset_userdata('coupon_code');
		 $this->session->unset_userdata('coupon_amount');
		 $this->session->unset_userdata('final_order_amt');
         $cart_tatl = $this->cart->total();
	     $cart_count = count($this->cart->contents());
	     $arr =array('cart_tatl'=>$cart_tatl,'cart_count'=>$cart_count);
	     // echo "<pre>";print_r($arr);exit;
	      if($res=1){
	      	  	echo json_encode($arr);
			  }else{
			  	echo "error";
			  }
    }
    public function move_to_wishlist()
	{
		$user_id =$this->session->userdata('user_id');
		$prod_id =$this->input->post('prod_id');
		$chk =$this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$prod_id AND `user_id`=$user_id")->num_rows();
    	// print_r($chk);exit;
    	if($chk== 1){
    		$this->db->where('user_id',$user_id);
    		$this->db->where('product_id',$prod_id);
	    	$this->db->delete('favourate_products');
	    	$status =0;
	    	$cart_tatl = $this->cart->total();
	     	$cart_count = count($this->cart->contents());
	    	$arr =array('status'=>$status,'cart_tatl'=>$cart_tatl,'cart_count'=>$cart_count);
	      	echo json_encode($arr);
    	}else{
    	$favourate_products = array(
		    'user_id' => $user_id,
		    'product_id' => $this->input->post('prod_id'),
		    'created_date' => date("Y-m-d h:i:s")
    	);
    	$this->db->insert('favourate_products',$favourate_products);
    	 $this->session->unset_userdata('coupon_code');
		 $this->session->unset_userdata('coupon_amount');
		 $this->session->unset_userdata('final_order_amt');
    	$status =1;
    	$rowid =$this->input->post('rowid');
		$removed_cart = array(
            'rowid'         => $rowid,
            'qty'           => 0
         );
         $res =$this->cart->update($removed_cart);
         $cart_tatl = $this->cart->total();
	     $cart_count = count($this->cart->contents());
	     $arr =array('status'=>$status,'cart_tatl'=>$cart_tatl,'cart_count'=>$cart_count);
	      echo json_encode($arr);
      }

		
	}

}