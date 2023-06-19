<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
         checkuser_login();
		$user_id=$this->session->userdata('user_id');
        $data['profile'] =$this->db->query("SELECT `user_id`, `name`, `fname`, `lname`, `email`, `phone`, `status`, `profile_pic`, `apartment_id`, `block_id`, `flat_id`, `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id AND `status`=1")->row_array();
        $data['address'] =$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` WHERE t1.`user_id`=$user_id")->result_array();
        $data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
        $data['orders']=$this->db->query("SELECT a.`order_id`, a.`payment_id` as invoice_id, a.`user_id`, a.`reference_id`, a.`order_amount`, a.`user_address_id`, a.`payment_mode`, a.`order_status`,a.`payment_status`, a.`order_date`, a.`order_succ_date`, a.`order_failed_date`, a.`order_cancelled_date`,b.`name`,b.`email`,b.`phone`,c.`user_address_id`,c.`appartment`,c.`floor_no`,c.`block_no`,c.`pincode`,c.`address`,(SELECT COUNT(`order_prod_id`) FROM `order_products` WHERE `order_id`=a.`order_id`) AS tot_items FROM `orders` a LEFT JOIN users b ON a.`user_id`=b.`user_id` LEFT JOIN order_user_address c ON a.`order_id`=c.`order_id` WHERE a.`user_id`=$user_id GROUP BY a.`order_id` ORDER BY a.`order_id` DESC")->result_array();
        $data['description'] = $this->db->query("SELECT `id`, `description` FROM `wallet_content` LIMIT 1")->row_array();
        $data['wallet_amount'] = $this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
        $recharge_data=array();
        $yrs=$this->db->query("SELECT MONTHNAME(created_date) as mnth,YEAR(created_date) as yr,MONTH(created_date) as mn FROM `user_wallet` where user_id=$user_id AND action_type=0 GROUP BY YEAR(`created_date`), MONTH(`created_date`) ORDER BY `created_date` DESC")->result_array();
        if(count($yrs)>0){
            foreach($yrs as $k=>$dt){
                $mn                 = $dt['mn'];
                $yr                 = $dt['yr'];
                unset($dt['mn']);
                $dt['history']= $this->db->query("SELECT `action_type`,`wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE YEAR(`created_date`)='$yr' AND MONTH(`created_date`)='$mn' AND `user_id`=$user_id AND action_type=0 ")->result_array();
                $recharge_data[]=$dt;
            }
        }
        $data['recharge_history'] =$recharge_data;
        $refund_data =array();       
        $refund_yrs=$this->db->query("SELECT MONTHNAME(created_date) as mnth,YEAR(created_date) as yr,MONTH(created_date) as mn FROM `user_wallet` where user_id=$user_id AND action_type=4 GROUP BY YEAR(`created_date`), MONTH(`created_date`) ORDER BY `created_date` DESC")->result_array();
        if(count($refund_yrs)>0){
            foreach($refund_yrs as $rk=>$rdt){
                $rmn                 = $rdt['mn'];
                $ryr                 = $rdt['yr'];
                unset($rdt['mn']);
                $rdt['history']= $this->db->query("SELECT `action_type`,`wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE YEAR(`created_date`)='$ryr' AND MONTH(`created_date`)='$rmn' AND `user_id`=$user_id AND action_type=4 ")->result_array();
                 $refund_data[]=$rdt;
            }
        }
       $data['refund_history'] =$refund_data;
        $data['mini_statement'] = $this->db->query("SELECT `wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE `user_id`=$user_id ORDER BY `wallet_id` DESC LIMIT 10")->result_array();
        // echo $this->db->last_query();exit;
        // echo "<pre>";print_r($data['orders']);exit;	
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/profile');
		$this->load->view('frontend/footer');
	}
	public function edit_profile()
	{
        checkuser_login();
		$user_id=$this->session->userdata('user_id');
        $data['profile'] =$this->db->query("SELECT `user_id`, `name`, `fname`, `lname`, `email`, `phone`, `status`, `profile_pic`, `apartment_id`, `block_id`, `flat_id`, `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id AND `status`=1")->row_array();
        // echo $this->db->last_query();exit;
        // echo "<pre>";print_r($data);exit;	
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/profile');
		$this->load->view('frontend/footer');
	}
	public function update_profile()
    {
        checkuser_login();
        $user_id=$this->session->userdata('user_id');
        $fname=$this->input->post('fname');
        $lname=$this->input->post('lname');
        $name =$fname." ".$lname;
        // $phone=$this->input->post('phone');
        $email=$this->input->post('email');
        $oldpic=$this->input->post('oldpic');
        $updated_date =date("Y-m-d H:i:s");
        $file='';
        $imagename='';
        
        if($_FILES['simage']['name'] !='')
            {
                $file=str_replace(" ","_",$_FILES['simage']['name']);
                $imagename=time().$file;
                $this->load->library('upload');
                $config['upload_path'] = 'assets/user_images';
                $config['file_name'] = $imagename;
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite']=true;
                $this->upload->initialize($config);

                 if(!$this->upload->do_upload('simage'))
                    {
                        $this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
                         redirect('profile');
                    }
                    else
                    {
                        
                            $imagename=$imagename;
                    }
            }
            else{
                $imagename=$oldpic;
            }
            $res =$this->db->update('users',array('profile_pic'=>$imagename,'name'=>$name,'fname'=>trim($this->input->post('fname')),'lname'=>trim($this->input->post('lname')),'email'=>trim($this->input->post('email')),'updated_date'=>$updated_date),array('user_id'=>$user_id));
        if($res==1){
            $this->session->set_flashdata('success','Profile Updated successfully..');
         }else{
            $this->session->set_flashdata('danger','Profile Updating failed...');
          }
        redirect($_SERVER['HTTP_REFERER']);
        
    }
    public function addtowishlist()
    {
        checkuser_login();
        $user_id =$this->input->post('user_id');
        $prod_id =$this->input->post('prod_id');
        $chk =$this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$prod_id AND `user_id`=$user_id")->num_rows();
        // print_r($chk);exit;
        if($chk== 1){
            $this->db->where('user_id',$user_id);
            $this->db->where('product_id',$prod_id);
            $this->db->delete('favourate_products');
            echo 0;
        }else{
        $favourate_products = array(
            'user_id' => $this->input->post('user_id'),
            'product_id' => $this->input->post('prod_id'),
            'created_date' => date("Y-m-d h:i:s")
        );
        $this->db->insert('favourate_products',$favourate_products);
        echo 1;
      }
    }
    public function save_user_address()
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
                
                // $session_address_id =array('apartment_id' =>$apartment_id);
                // $this->session->set_userdata($session_address_id);
                echo 1;
             }else{
                echo 0;
             }
        }
    }
    public function add_amount_to_wallet()
    {
        checkuser_login();
        $user_id   = $this->session->userdata('user_id');
        $amount     = $this->input->post('wallet_amount');
        $type       = 0;
        $description = "Added by User";
        $Insert = array(
            'amount'=>$amount,
            'type'=>$type,
            'user_id'=>$user_id,
            'created_date'=>date('Y-m-d H:i:s')
        );
        if($description!=''){
            $sec=array('description'=>$description);
            $Insert=array_merge($Insert,$sec);
        }
        $this->db->insert('user_wallet',$Insert);
        $res =$this->db->query("UPDATE `users` SET `final_wallet_amount`=`final_wallet_amount`+$amount WHERE `user_id`=$user_id");
        if($res==1){
            $this->session->set_flashdata('success','Amount Added successfully..');
        }else{
            $this->session->set_flashdata('danger','Amount Added failed...');
        } 
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function recharge_history()
    {
        checkuser_login();
        $user_id   = $this->session->userdata('user_id');
        $data=array();
        $yrs=$this->db->query("SELECT MONTHNAME(created_date) as mnth,YEAR(created_date) as yr,MONTH(created_date) as mn FROM `user_wallet` where user_id=$user_id AND action_type=0 GROUP BY YEAR(`created_date`), MONTH(`created_date`) ORDER BY `created_date` DESC")->result_array();
        if(count($yrs)>0){
            foreach($yrs as $k=>$dt){
                $mn                 = $dt['mn'];
                $yr                 = $dt['yr'];
                unset($dt['mn']);
                $dt['history']= $this->db->query("SELECT `action_type`,`wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE YEAR(`created_date`)='$yr' AND MONTH(`created_date`)='$mn' AND `user_id`=$user_id AND action_type=0 ")->result_array();
                $data[]=$dt;
            }
        }
        $data['recharge_history'] =$data;
        echo $this->load->view('frontend/recharge_history', $data, true);
        // $response['status'] = 1;
    }
	public function statement_history()
	{
        checkuser_login();
        $user_id   = $this->session->userdata('user_id');
        $start_date1 =$this->input->post('start_date');
        $start_date = date("Y-m-d", strtotime($start_date1));
        $end_date1 =$this->input->post('end_date');
        $end_date = date("Y-m-d", strtotime($end_date1));
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
            $data['result']=$this->db->query("SELECT `action_type`,`wallet_id`, `amount`, `type`, `user_id`, `status`, `description`, `transaction_id`, `invoice_id`, `action_type`, `created_date`, `updated_date` FROM `user_wallet` WHERE `user_id`=$user_id $wh")->result_array();
            echo $this->load->view('frontend/statement_history', $data, true); 
        }else{
            echo 0;
        }
       
    }
    public function delete_user_address()
    {
        checkuser_login();
        $user_id=$this->session->userdata('user_id');
        $user_apartment_det_id =$this->input->post('user_apartment_det_id');
        $this->db->where('user_apartment_det_id',$user_apartment_det_id);
        $this->db->where('user_id',$user_id);
        $res=$this->db->delete('user_apartment_details');
        if ($res==1)
        {
           echo 1;
        }
        else
        {
           echo 0;
        }
           
    }
    public function wishlist()
    {
        checkuser_login();
        $user_id=$this->session->userdata('user_id');
        $data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
        $data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
        $data['wish_list'] =$this->db->query("SELECT `t1`.`favourate_id`, `t1`.`product_id`, `t1`.`user_id`, `t2`.`prod_id`, `t2`.`prod_title`, `t2`.`prod_status`, `t2`.`prod_slug`, `t3`.`id`, `t3`.`prod_id`, `t3`.`mes_id`, `t3`.`prod_image`,`t3`.`prod_offered_price` FROM `favourate_products` as `t1` LEFT JOIN `products` as `t2` ON `t1`.`product_id` = `t2`.`prod_id` LEFT JOIN `product_mesurments` as `t3` ON `t1`.`product_id` = `t3`.`prod_id` WHERE `t1`.`user_id` =$user_id AND `t2`.`prod_status` = 1")->result_array();
            // echo $this->db->last_query();exit;
        $this->load->view('frontend/header',$data);
        $this->load->view('frontend/wishlist');
        $this->load->view('frontend/footer');
    }
    public function remove_wishlist()
    {
        checkuser_login();
        $user_id=$this->session->userdata('user_id');
        $prod_id=$this->input->post('prod_id');
        $this->db->where('product_id',$prod_id);
        $this->db->where('user_id',$user_id);
        $res=$this->db->delete('favourate_products');
        $chk_count =$this->db->query("SELECT `favourate_id`, `product_id`, `user_id` FROM `favourate_products` WHERE `user_id`=$user_id")->result_array();
        // echo count($chk_count);exit;
        if ($res==1)
        {
           echo count($chk_count);
        }
        else
        {
           echo 2;
        }
    }
    public function change_delivery_address()
    {
        checkuser_login();
        $user_id =$this->session->userdata('user_id');
        $user_apartment_det_id =$this->input->post('user_apartment_det_id');
        $this->db->query("UPDATE user_apartment_details SET is_latest =0 WHERE `user_id` = $user_id");
        $res =$this->db->query("UPDATE user_apartment_details SET is_latest =1 WHERE `user_id` = $user_id AND `user_apartment_det_id`=$user_apartment_det_id");
         if($res==1){
           $this->session->set_flashdata('success',"Delivery Address Changed Successfully...");
           redirect($_SERVER['HTTP_REFERER']);
         }else{
           $this->session->set_flashdata('danger',"Opps! Delivery Address Changed Failed...");
            redirect($_SERVER['HTTP_REFERER']); 
         }
    }	
	
}