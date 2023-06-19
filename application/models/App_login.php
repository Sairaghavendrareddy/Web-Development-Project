<?php
class App_login extends CI_Model {
	public function __construct(){
		parent :: __construct();
		$this->load->model('common_model');    
	}
	public function insertKey($uid,$randomString,$device_id,$is_device){
	    $dd=$this->db->get_where('cas_tmp',array('device_id'=>$device_id))->result_array();
		if(!empty($dd)){
			 $devdata=array('user_id'=>$uid);
			 $this->db->where('device_id',$device_id);
		     $this->db->update("cas_tmp",$devdata); 
		}
		else{
			$data2=array("user_id"=>$uid,"device_id"=>$device_id,"device_type"=>$is_device,'login_type'=>'1','pn_enabled'=>'1');
			$this->db->insert("cas_tmp",$data2);
		}
		
		$data=array("user_id"=>$uid,"key"=>$randomString,"device_id"=>$device_id,"device_type"=>$is_device,'user_type'=>'1');
		return $rec=$this->db->insert("user_devices",$data);
	}
	public function check_device($device_id,$uid){
		$this->db->select("user_id,device_id");
		$this->db->from("user_devices");
		$this->db->where("device_id",$device_id);
		$this->db->where("user_type",'1');
		$query=$this->db->get();
		return $rec=$query->num_rows();		 		
	}
	public function updateKey($uid,$randomString,$did,$is_device){
	    $dd=$this->db->get_where('cas_tmp',array('device_id'=>$did))->result_array();
		if(!empty($dd)){
			$devdata=array('user_id'=>$uid);
			$this->db->where('device_id',$did);
		    $this->db->update("cas_tmp",$devdata); 
		}else{
			$data2=array("user_id"=>$uid,"device_id"=>$did,"device_type"=>$is_device,'login_type'=>'1','pn_enabled'=>'1');
			$this->db->insert("cas_tmp",$data2);
		}
		$data=array('key'=>$randomString,"user_id"=>$uid,"device_type"=>$is_device);
		$this->db->where('device_id',$did);
		$this->db->where('user_type','1');
		return $res=$this->db->update("user_devices",$data);  
	}
	public function login_user($post){
		$pass 	= PassWord_Encode($post['password']);
		$email	= $post['email'];
		return $this->db->select('`user_id`, `name`, `fname`, `lname`, `email`, `phone`,`status`,`apartment_id`, `block_id`, `flat_id`')->get_where('users',array('email'=>$email,'password'=>$pass))->row_array();
	}
	public function add_user($post){
        $pwd = @$post['password'];
        $cpwd = @$post['confirm_password'];
		$fname = $post['name'];
		$lname = '';
		$email = $post['email'];
		$name = $fname.' '.$lname;
		$fb_id = @$post['facebook_id'];
		$gmail_id = @$post['gmail_id'];
        $apartment_id = @$post['apartment_id'];
        $block_id = @$post['block_id'];
        $flat_id = @$post['flat_id'];
		if($pwd==$cpwd){
    		$existed    = $this->db->select('user_id')->get_where('users',array('email'=>$email))->num_rows();
    		if($existed==0){
        		$insert = array(
        			'name'=>$name,
        			'fname'=>$fname,
        			'lname'=>$lname,
        			'email'=>$email,
        			'fb_id'=>$fb_id,
        			'gmail_id'=>$gmail_id,
        			'password'=>md5($pwd),
        			'created_date'=>date('Y-m-d H:i:s')
        		);
        		if($apartment_id!=''){
        		    $ins = array('apartment_id'=>$apartment_id);
        		    $insert = array_merge($insert,$ins);
        		}
        		if($block_id!=''){
        		    $ins = array('block_id'=>$block_id);
        		    $insert = array_merge($insert,$ins);
        		}
        		if($flat_id!=''){
        		    $ins = array('flat_id'=>$flat_id);
        		    $insert = array_merge($insert,$ins);
        		}
        		$res=$this->common_model->commonInsert('users',$insert);
        		if($res>0){
        			$html_content ='Email:'.$email;
        			$html_content .='<br>Password:'.$pwd;
        			$subject='Your login crdentials';
        			$this->common_model->send_email($html_content, $email, $subject);
        			$status=1;
        		}else{
        			$status=0;
        		}
    		}else{
    		   $status=2;
    		}
		}else{
		   $status=3;
		}
		return $status;
	}
	public function add_user_address($post){
		$insert = array(
			'user_id'	 =>	@$post['user_id'],
			'mobile_no'	 =>	@$post['mobile_no'],
			'floor_no'	 =>	@$post['floor_no'],
			'block_no'	 =>	@$post['block_no'],
			'appartment'	 =>	@$post['appartment'],
			'street_name' =>	@$post['street_name'],
			'area_name'   => @$post['area_name'],
			'pincode'	 =>	@$post['pincode'],
			'landmark'	 =>	@$post['landmark'],
		);
		$rs = $this->common_model->commonInsert('user_address',$insert);
		return $rs;
	}
	public function Save_Order_Details($data){
		$slot = 0;
		$delivery_charge = 0;
		$delivery_date = date('Y-m-d');
		$Slots_Dt=array();
		if(isset($data['delivery_type']) && trim($data['delivery_type'])=='express'){
		    $delivery_charge = Delivery_Charge();
    		if(isset($data['slot']) && $data['slot']!=''){
    			$slot = $data['slot'];
    			$Slots_Dt = $this->db->query("SELECT `id`, `slot_from`, `slot_to`, `time_in_seconds` FROM `delivery_slots` WHERE `id`=$slot")->row_array();
    			if($data['slot_day']==2){
    			   	$delivery_date = date("Y-m-d",strtotime($delivery_date.' +1 day'));
    			}
    		}else{
    			$current_time = date('H');
    			if($current_time < 20){
    				$delivery_date = $delivery_date;
    			}else{
    				$delivery_date = date("Y-m-d",strtotime($delivery_date.' +1 day'));
    			}
    			$delivery_date = date("Y-m-d",strtotime($delivery_date.' +1 day'));
    		}
		}else{
		    $delivery_date = date("Y-m-d",strtotime($delivery_date.'+1 day'));
		}
		if(is_null($data['coupon_amount'])){
		    $data['coupon_amount']=0;
		}
		if(is_null($data['wallet_amount'])){
		    $data['wallet_amount']=0;
		}
		$Order = array(
	        'payment_id'				=>$data['payment_id'],
	        'user_id'					=>$data['user_id'],
	        'reference_id'				=>$data['reference_id'],
	        'order_amount'				=>$data['order_amount'],
	        'payment_mode'				=>$data['payment_mode'],
	        'user_apartment_det_id'		=>$data['user_apartment_det_id'],
			'delivery_type'				=>$data['delivery_type'],
			'delivery_date'				=>$delivery_date,
	        'order_date'				=>date('Y-m-d H:i:s'),
			'coupon_id'					=>$data['coupon_id'],
			'coupon_code'				=>$data['coupon_code'],
			'coupon_amount'				=>$data['coupon_amount'],
			'wallet_amount'				=>$data['wallet_amount'],
			'online_amount'				=>$data['online_amount'],
			'delivery_charge'           =>$delivery_charge,
	    );
		if($slot>0 && !empty($Slots_Dt)){
		    $slot_from = $Slots_Dt['slot_from'];
		    $slot_to = $Slots_Dt['slot_to'];
		    $ord_Slot = array('delivery_slot_id'=>$slot,'delivery_slot'=>$slot_from.' TO '.$slot_to);
			$Order = array_merge($Order,$ord_Slot);
		}
        $this->db->insert('orders',$Order);	
        $insert_id = $this->db->insert_id();
        if($data['payment_mode']=='wallet' || $data['payment_mode']=='cod'){
        	$this->Update_Qty($insert_id);
		}
        return $insert_id;
	}
	public function Update_Qty($order_id){
		$Prods=$this->db->query("SELECT `qty`,`prod_id`,`prod_mes_id` FROM `order_products` WHERE `order_id`=$order_id")->result_array();
		if(count($Prods)>0){
			foreach($Prods as $prd){
				$qty=$prd['qty'];
				$prod_id = $prd['prod_id'];
				$prod_mes_id  = $prd['prod_mes_id'];
				$check_prod=$this->db->query("SELECT `prod_available_qty` FROM `product_mesurments` WHERE `id`=$prod_mes_id")->row_array();
				if($check_prod['prod_available_qty']>0){
					$finalqty = $check_prod['prod_available_qty']-$qty;
					$finalqty = ($finalqty>=0)?$finalqty:0;
					$this->db->update('product_mesurments',array('prod_available_qty'=>$finalqty),array('id'=>$prod_mes_id));
				}
				$ms = $this->common_model->GetProdMes($prod_id);
				if(count($ms)>0){
					$prod_mesurements = json_encode($ms);
					$up = array('prod_mesurements'=>$prod_mesurements);
					$this->common_model->commonUpdate('products',$up,array('prod_id'=>$prod_id));
				}
			}
		}
        $data = $this->db->query("SELECT `order_id`,`coupon_id`,`coupon_code`,`payment_mode`,`payment_id`,`wallet_amount`,`user_id`,`order_id` FROM `orders` WHERE `order_id`=$order_id")->row_array();
        $Order = array_merge(array('paid_status'=>1,'order_status'=>'Success','payment_status'=>'Success','order_succ_date'=>date('Y-m-d H:i:s')));
        $this->db->update('orders',$Order,array('order_id'=>$order_id));
        if($data['payment_mode']=='wallet_online' || $data['payment_mode']=='wallet'){
            $this->Update_Wallet_Amount($data['payment_id'],$data['wallet_amount'],$data['user_id']);
        }
        if($data['coupon_id']>0){
            $coupon_id = $data['coupon_id'];
            $coupon_code = $data['coupon_code'];
            $this->db->query("UPDATE `coupon` SET `use_count`=`use_count`+1 WHERE `id`='$coupon_id' AND `code`='$coupon_code'");
        }
	}
	public function Save_Order_Product_Details($prods,$payment_mode,$pqty){
	    if($payment_mode=='cod'){
	       // $dt=date('Y-m-d H:i:s');
	       // $prods=array_merge($prods,array('payment_status'=>'Success','order_date'=>$dt,'rder_succ_date'=>$dt));
	    }
	    $this->db->insert('order_products',$prods);	
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}
	public function Save_Order_Address_Details($adress_id,$order_id,$user_id){
	    $Address = $this->db->query("SELECT `a`.title,`a`.`user_apartment_det_id` as `user_address_id`, `a`.`apartment_id` as `appartment`, `a`.`block_id` as `block_no`, `flat_id` as `floor_no`,b.apartment_name as appartment,b.apartment_address as address,b.apartment_pincode as pincode FROM `user_apartment_details` a JOIN apartments b ON a.`apartment_id`=b.apartment_id WHERE a.user_apartment_det_id=".$adress_id)->row_array();
	    $Address['order_id']=$order_id;
	    $Address['user_id']=$user_id;
	    $this->db->insert('order_user_address',$Address);	
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}
	public function Update_Wallet_Amount($order_id,$order_amount,$user_id){
	    $Amount = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
        $wallet_amount = $Amount['final_wallet_amount'];
        $final_wallet_amount = $wallet_amount-$order_amount;
        $this->db->query("UPDATE `users` SET `final_wallet_amount`=$final_wallet_amount WHERE `user_id`=$user_id");
        $history = array(
            'amount'=>$order_amount,
            'balance'=>$final_wallet_amount,
            'type'=>1,
            'user_id'=>$user_id,
            'status'=>1,
            'description'=>'For order '.$order_id,
            'invoice_id'=>$order_id,
			'action_type'=>3,
            'created_date'=>date('Y-m-d H:i:s')
        );
        $this->db->insert('user_wallet',$history);
	}
	public function send_invoice($order_id){
	    $this->common_model->send_invoice($order_id);
	}
}