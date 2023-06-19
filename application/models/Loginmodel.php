<?php
ob_start();
class Loginmodel extends CI_Model{
	public function check_login($uname, $password){
			$this->db->select('*');
			$this->db->from('admin_login');
			$this->db->where('username',$uname);
			$this->db->where('password',$password);
			$this->db->where('status','1');
			$q=$this->db->get();
			if($q->num_rows()==1){
						$this->session->set_userdata('admin_id',$q->row()->admin_id);
						$this->session->set_userdata('login_name',$q->row()->username);
				return $q->result_array();
			}else{
				return 0;
			}

	}
	function getCityDepartment($postData){
		$response = array();
		$this->db->select('block_id,block_name');
		$this->db->where('apartment_id', $postData['apartment_id']);
		$q = $this->db->get('blocks');
		$response = $q->result_array();
		return $response;
  	}
	public function search_user_Details($type,$start,$length,$search,$column,$order){
		if($type==2){
			$this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`, `password`, `otp`, `phone_2`, `status`, `profile_pic`, `apartment_id`, `block_id`, `flat_id`, `final_wallet_amount`, `created_date`',FALSE);
		}else{
			$this->db->select('user_id',FALSE);
		}
		$this->db->from('users');
		if($search!=''){ 
			$this->db->where("name like '%$search%' OR phone like '%$search%' OR email like '%$search%' OR created_date like '%$search%'");
		} 
		switch($column){
			case 0:
			$this->db->order_by("user_id", $order);
			break;
			case 1: 
			$this->db->order_by("name", $order);
			break;
			case 2:
			$this->db->order_by("email", $order);
			break;
			case 3:
			$this->db->order_by("phone", $order);
			break;
			default:
			$this->db->order_by("created_date", $order);
		}
		if($type==2){
			if($length!=0){ $this->db->limit($length,$start);}
			$resp = $this->db->get()->result_array();
		}else{
			$resp=$this->db->get()->num_rows();
		}		
		return $resp;
	} 
	public function search_product_Details($ispopsubtype,$type,$start,$length,$search,$column,$order){
		if($type==2){
			$this->db->select('`t1`.*, `t2`.`cat_id`, `t2`.`title` as cat_title,br.brand_title',FALSE);
		}else{
			$this->db->select('`t2`.`cat_id`',FALSE);
		}
		$this->db->from('products t1'); 
		$this->db->join('categories t2','`t1`.`prod_category` = `t2`.`cat_id`','left');
		$this->db->join('category_brands br','br.brand_id=t1.prod_brand','left');
		if($ispopsubtype>0){
		    if($ispopsubtype==1){
		        $this->db->where(array('available_subscraibe'=>1));
		    }else{
		        $this->db->where(array('is_popular'=>1));
		    }
		}
		if($search!=''){ 
			$this->db->where("t1.prod_title like '%$search%' OR `t2`.`title` like '%$search%' OR br.brand_title like '%$search%'");
		} 
		switch($column){
			case 0:
			$this->db->order_by("t1.prod_id", $order);
			break;
			case 1: 
			$this->db->order_by("t1.prod_title", $order);
			break;
			case 2: 
			$this->db->order_by("t1.prod_title", $order);
			break;
			case 3:
			$this->db->order_by("`t2`.`title`", $order);
			break;
			case 4:
			$this->db->order_by("br.brand_title", $order);
			break;
			case 5:
				$this->db->order_by("t1.prod_status", $order);
			break;
			case 6:
				$this->db->order_by("t1.prod_title", $order);
			break;
			default:
			$this->db->order_by("t1.prod_created_date", $order);
		}
		if($type==2){
			if($length!=0){ $this->db->limit($length,$start);}
			$resp = $this->db->get()->result_array();
		}else{
			$resp=$this->db->get()->num_rows();
		}		
		return $resp;
	}
	public function search_ord_Details($type,$start,$length,$search,$column,$order,$user_id){
		if($type==2){
			$this->db->select('order_delivered_date,`order_id`,paid_status, `payment_id`, `user_id`, `reference_id`, `order_amount`, `user_address_id`, `payment_mode`, `payment_status`, `user_apartment_det_id`, `order_date`, `order_succ_date`, `order_failed_date`, `order_cancelled_date`',FALSE);
		}else{
			$this->db->select('order_id',FALSE);
		}
		$this->db->from('orders');
		if($user_id>0){
		    $this->db->where('user_id',$user_id);
		}
		if($search!=''){ 
			$this->db->where("order_id like '%$search%' OR paid_status like '%$search%' OR reference_id like '%$search%'");
		} 
		switch($column){
			case 0:
				$this->db->order_by("order_id", $order);
			break;
			case 1: 
				$this->db->order_by("paid_status", $order);
			break;
			case 2: 
				$this->db->order_by("order_id", $order);
			break;
			case 3:
				$this->db->order_by("order_id", $order);
			break;
			case 4:
				$this->db->order_by("order_id", $order);
			break;
			case 5:
				$this->db->order_by("order_id", $order);
			break;
			case 6:
				$this->db->order_by("order_id", $order);
			break;
			default:
				$this->db->order_by("order_date", $order);
		}
		if($type==2){
			if($length!=0){ $this->db->limit($length,$start);}
			$resp = $this->db->get()->result_array();
		}else{
			$resp=$this->db->get()->num_rows();
		}		
		return $resp;
	}
}
