<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		checkuser_login();
		$user_id   = $this->session->userdata('user_id');
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
		$data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		$data['default_address'] =$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`,t3.`user_id`,t3.`name`,t3.`phone`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` INNER JOIN users as t3 ON t1.`user_id`=t3.`user_id` WHERE t1.`user_id`=$user_id AND t1.`is_latest`=1")->row_array();
		$data['wallet_amount'] = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
		// $data['address_list'] =$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`,t3.`user_id`,t3.`name`,t3.`phone`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` INNER JOIN users as t3 ON t1.`user_id`=t3.`user_id` WHERE t1.`user_id`=$user_id AND t1.`is_latest`=0")->result_array();
		// echo "<pre>";print_r($data);exit;
		$this->load->view('frontend/header',$data);
		// $this->load->view('frontend/menu');
		$this->load->view('frontend/checkout');
		$this->load->view('frontend/footer');
	}
	public function update_user_address()
	{
		checkuser_login();
		$user_id   = $this->session->userdata('user_id');
		$user_apartment_det_id=$this->input->post('d_address_id');
		$d_app_block_no=$this->input->post('d_app_block_no');
		$d_app_flat_no=$this->input->post('d_app_flat_no');
		$data =array('block_id' =>$d_app_block_no,'flat_id'=>$d_app_flat_no);
		$this->db->where('user_id',$user_id);
		$this->db->where('user_apartment_det_id',$user_apartment_det_id);
		$res =$this->db->update('user_apartment_details',$data);
		$arr =['d_app_block_no' =>$d_app_block_no,'d_app_flat_no'=>$d_app_flat_no];
		if($res==1){
            echo json_encode($arr);
         }else{
            echo 0;
          }
	}
	public function save_user_delivery_address()
    {
        checkuser_login();
        $user_id =$this->session->userdata('user_id');
        $apartment_id =$this->input->post('apartment_id');
        $block_no =$this->input->post('app_block_no');
        $flat_no =$this->input->post('app_flat_no');
        $chk =$this->db->query("SELECT `user_apartment_det_id`, `title`, `apartment_id`, `block_id`, `flat_id`, `user_id`, `status`, `is_latest`, `is_default`, `created_date`, `updated_date` FROM `user_apartment_details` WHERE `user_id`=$user_id AND `apartment_id`=$apartment_id AND `block_id`='$block_no' AND `flat_id`='$flat_no'")->num_rows();
        if(($chk) >0){
            echo 2;
        }else
        {
            $this->db->query("UPDATE user_apartment_details SET is_latest =0 WHERE `user_id` = $user_id");
            $data =array(
                'user_id' =>$user_id,
                'apartment_id' =>$apartment_id,
                'block_id' =>$block_no,
                'flat_id' =>$flat_no,
                'status' =>1,
                'is_latest' =>1,
                'updated_date' =>date("Y-m-d H:i:s")
            );  
            $res =$this->db->insert('user_apartment_details',$data); 
             if($res==1){
               $delivery_address=$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`,t3.`user_id`,t3.`name`,t3.`phone`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` INNER JOIN users as t3 ON t1.`user_id`=t3.`user_id` WHERE t1.`user_id`=$user_id AND t1.`is_latest`=1")->row_array();
                // $session_address_id =array('apartment_id' =>$apartment_id);
                // $this->session->set_userdata($session_address_id);
               // echo "<pre>";print_r($delivery_address);exit;
               $arr =['user_apartment_det_id'=>$delivery_address['user_apartment_det_id'],'apartment_id'=>$delivery_address['apartment_id'],'apartment_name'=>$delivery_address['apartment_name'],'apartment_address' =>$delivery_address['apartment_address'],'apartment_pincode' =>$delivery_address['apartment_pincode'],'name' =>$delivery_address['name'],'phone'=>$delivery_address['phone'],'block_id'=>$delivery_address['block_id'],'flat_id'=>$delivery_address['flat_id']];
               // echo "<pre>";print_r($arr);exit;
                echo json_encode($arr);
             }else{
                echo 0;
             }
        }
    }
	public function delivery_slots(){
        $type = $this->input->post('delivery_slots');
        $final=array();
		$slots = $this->db->query("SELECT `id`, `slot_from`, `slot_to`, `time_in_seconds` FROM `delivery_slots` WHERE is_active=1")->result_array();
		$delivery_date = date("Y-m-d");
		if($type==2){
		    $delivery_date = date("Y-m-d",strtotime($delivery_date.' +1 day'));
		}
		$tm=time2sec(date('H:i:s'));
		if(count($slots)>0){
		    foreach($slots as $s){
		        $s['available']=1;
		        if($type==1){
		            if($tm>$s['time_in_seconds']){
		                $s['available']=0;
		            }
		        }
		        $final[] = $s;
		    }
		}
		$data['current_time'] = $tm;
		$data['delivery_date']  = $delivery_date;
		$data['slots'] = $final;
		// echo "<pre>";print_r($data);exit;
		echo $this->load->view('frontend/delivery_slots',$data,TRUE);
	}
	public function check_coupon_existed_or_not(){
		checkuser_login();
		$user_id   = $this->session->userdata('user_id');
        $code      = $this->input->post('coupon_code');
        $order_tot_amount = $this->input->post('order_tot_amount');
		$delivery_type    = @$data['delivery_type'];
		$offers_for_you=$this->db->query("SELECT `id`, `name`, `code`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `status`, `use_for`, `created_at`, `updated_at`, `deleted_at` FROM `coupon` WHERE  `use_for` IN (0,$user_id) AND code='$code'")->row_array();
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
    					// $data['message'] = 'Coupon applied successfully';
    					// echo "<pre>";print_r($data);exit;
    					echo json_encode($data);
				    }else{
						$data['status'] = 0;
						$data['message'] = 'Total limits for coupon completed';
						echo 2;
					}
				}else{
					$data['status'] = 0;
					$data['message'] = 'Coupon expaired';
					echo 3;
				}
			}else{
				$data['status'] = 0;
				if($curdate<$offers_for_you['start_date']){
				    // $data['message'] = 'This coupon started from '.date_month_name($offers_for_you['start_date']);
				    echo 4;
				}else{
				     $data['message'] = 'Invalid coupon';
				     echo 5;
				}
			}
		}else{
			$data['status'] = 0;
			$data['message'] = 'Invalid coupon';
			echo 6;
		}
	}


}