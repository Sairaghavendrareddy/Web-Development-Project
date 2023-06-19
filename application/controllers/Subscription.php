<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subscription extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('common_model');
	}
	public function index()
	{
		 checkuser_login();
		 $user_id  = $this->session->userdata('user_id');
		 $data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1")->result_array();
		 $data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
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
	        $data['products'] = $Final_Dt;

			 // echo"<pre>";print_r($data['products']);exit;
			$this->load->view('frontend/header',$data);
			$this->load->view('frontend/menu');
			$this->load->view('frontend/subscription_list');
			$this->load->view('frontend/footer');
	}
	public function add_subscribe_product(){
		checkuser_login();
        $user_id                = $this->session->userdata('user_id');
        $prod_id                = $this->input->post('prod_id');
        $prod_mesids            = $this->input->post('prod_mes_id');
		$qty_id                 = $this->input->post('qty');
		$from_date1  			= @$this->input->post('sub_date');
		$from_date              =  date("Y-m-d", strtotime($from_date1));
		$pick_schedule  		= @$this->input->post('pick_schedule');
		$user_apartment_det_id  = @trim($this->input->post('user_apartment_det_id'));
		$days_list 				= @implode(',',$this->input->post('days_list'));
		// echo $days_list;exit;
		$from       =  date("Y-m-d", strtotime($from_date));
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
			$data['status'] =   0;
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
							// echo $this->db->last_query();exit;
							// echo $Check_Subscribe;exit;
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
								// print_r($final);exit;
								$Arr_Dat[] = $final;
								$this->common_model->commonInsert('prod_subscriptions',$final);
								// echo $this->db->last_query();exit;
							}
						}
					}
					if(count($check)>0){
						if(count($check)==count($prod_mesids)){
							$name = (count($check)>1)?'measurements':'measurement';
							$faild=implode(',',$check).' '.$name.' Already subscribed';
							$this->session->set_flashdata('danger',$faild.'Already subscribed');
						}else{
							$name = (count($check)>1)?'measurements':'measurement';
							$faild=implode(',',$check).' '.$name.' Already subscribed';
							$this->session->set_flashdata('danger',$faild.'Already subscribed');
						} 
						redirect($_SERVER['HTTP_REFERER']);
					}
					
					$this->session->set_flashdata('success','Your subscription successfull');
					redirect('subscription');
				
					// $response['subscription_start_date'] = $from;
				}else{
					$this->session->set_flashdata('danger','Please check product measurements');
					redirect($_SERVER['HTTP_REFERER']);
				} 
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('danger','Please select subscription start date from '.$next_after_day);
			}
			 redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('danger','Please select subscription start date from '.$next_day);	
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function get_pause_subscription_list(){
        checkuser_login();
        $user_id            = $this->session->userdata('user_id');
        $subscribe_id       = $this->input->post('subscription_id');
        $prod_id            = $this->input->post('prod_id');
        $prod_mes_id        = $this->input->post('prod_mes_id');
        $data['pause_list']=$this->db->query("SELECT t2.`prod_id`, t2.`prod_title`,t3.`id`,t3.`prod_id`,t3.`mes_id`,t3.`prod_image`,t3.`prod_org_price`,t3.`prod_offered_price`,t4.`mes_id`,t4.`title` FROM `products` as t2 INNER JOIN product_mesurments as t3 ON t2.`prod_id`=t3.`prod_id` INNER JOIN mesurements as t4 ON t3.`mes_id`=t4.`mes_id` WHERE t3.`id`=$prod_mes_id")->result_array();
        echo $this->load->view('frontend/get_subscription_prod_list',$data,TRUE);
        	// echo "<pre>";print_r($data);exit;
	}
	public function get_modify_temporarily_list(){
        checkuser_login();
        $user_id            = $this->session->userdata('user_id');
        $subscribe_id       = $this->input->post('subscription_id');
        $prod_id            = $this->input->post('prod_id');
        $prod_mes_id        = $this->input->post('prod_mes_id');
        $data['pause_list']=$this->db->query("SELECT t2.`prod_id`, t2.`prod_title`,t3.`id`,t3.`prod_id`,t3.`mes_id`,t3.`prod_image`,t3.`prod_org_price`,t3.`prod_offered_price`,t4.`mes_id`,t4.`title` FROM `products` as t2 INNER JOIN product_mesurments as t3 ON t2.`prod_id`=t3.`prod_id` INNER JOIN mesurements as t4 ON t3.`mes_id`=t4.`mes_id` WHERE t2.`prod_id`=$prod_id")->result_array();
        	echo $this->load->view('frontend/modify_temporarily_modal',$data,TRUE);
        	// echo "<pre>";print_r($data);exit;
	}
	public function get_modify_permently_list(){
        checkuser_login();
        $user_id            = $this->session->userdata('user_id');
        $subscribe_id       = $this->input->post('subscription_id');
        $prod_id            = $this->input->post('prod_id');
        $prod_mes_id        = $this->input->post('prod_mes_id');
        $data['pause_list']=$this->db->query("SELECT t2.`prod_id`, t2.`prod_title`,t3.`id`,t3.`prod_id`,t3.`mes_id`,t3.`prod_image`,t3.`prod_org_price`,t3.`prod_offered_price`,t4.`mes_id`,t4.`title` FROM `products` as t2 INNER JOIN product_mesurments as t3 ON t2.`prod_id`=t3.`prod_id` INNER JOIN mesurements as t4 ON t3.`mes_id`=t4.`mes_id` WHERE t2.`prod_id`=$prod_id")->result_array();
        	echo $this->load->view('frontend/modify_permanent_modal',$data,TRUE);
        	// echo "<pre>";print_r($data);exit;
	}
	public function changing_subscribe_product(){
        checkuser_login();
        $user_id            = $this->session->userdata('user_id');
        $subscribe_id       = $this->input->post('pause_subscription_id');
        $type               = 'pause_subscription';
        $from_date          = $this->input->post('pause_start_date');
        $to_date            = $this->input->post('pause_end_date');
        $from               = date("Y-m-d", strtotime($from_date));
        $to                 = date("Y-m-d", strtotime($to_date));
        $Qty                = array('from_date'=>$from,'to_date'=>$to);
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
			$this->session->set_flashdata('success','Your subscription has been pauses as request. You can tap on resume to the services.');
			redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('danger','Invalid subscriber id');
        }
         redirect($_SERVER['HTTP_REFERER']);
    }
    public function temporarly_modify_subscribe_product(){
        checkuser_login();
        $user_id        = $this->session->userdata('user_id');
        $prod_id            = $this->input->post('temporarily_prod_id');
        $prod_mes_id_ss     = $this->input->post('modify_subscription_prod_mes_id1');
        $qty_ss             = $this->input->post('qty');
        $from_date          = $this->input->post('modified_from_date');
        $to_date            =$this->input->post('modified_to_date');
        $from               = date("Y-m-d", strtotime($from_date));
        $to                 = date("Y-m-d", strtotime($to_date));
        $type = 'temporarily_change';
        // print_r($prod_mes_id_ss);exit;
        if(count($prod_mes_id_ss)>0){
            foreach($prod_mes_id_ss as $pk=>$prod_mes_id){
                $qty    =    $qty_ss[$pk];
                $Qty    = array('user_id'=>$user_id,'qty'=>$qty,'from_date' =>$from,'to_date'   =>$to);
                $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'prod_id'=>$prod_id,'prod_mes_id'=>$prod_mes_id,'is_active<'=>3),'');
                // echo $this->db->last_query();exit;
                // print_r($Check_Subscribe);exit;
                // echo "string";exit;
                if(!empty($Check_Subscribe)){
                    $Check_Arr  =   array(
                        'user_id'=>$user_id,
                        'prod_id'=>$prod_id,
                        'prod_mes_id'=>$prod_mes_id
                    );
                    // echo "string";exit;
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
            $this->session->set_flashdata('success','Your subscription has been modified as requested.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('danger','Product details required');
            redirect($_SERVER['HTTP_REFERER']);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function permenently_modify_subscribe_product(){
        checkuser_login();
        $user_id         = $this->session->userdata('user_id');
        $prod_id         = $this->input->post('permenently_prod_id');
        $prod_mes_id_ss  = $this->input->post('modify_permently_prod_mes_id1');
        $qty_ss          = $this->input->post('permently_qty');
        $type = 'perminently_change';
        if(count($prod_mes_id_ss)>0){
            foreach($prod_mes_id_ss as $pk=>$prod_mes_id){
                $qty    =    $qty_ss[$pk];
                $Qty    = array('user_id'=>$user_id,'qty'=>$qty);
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
            $this->session->set_flashdata('success','Your subscription has been modified as requested.');
              redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('danger','Product details required');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function single_subscribed_products(){
	    checkuser_login();
        $user_id    = $this->session->userdata('user_id');
        $prod_id    = @$data['product_id'];
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
        echo json_encode($Final_Dt);
	}
	public function delete_product_subscraibe(){
	    checkuser_login();
        $user_id        = $this->session->userdata('user_id');
        $subscribe_id   = $this->input->post('subscription_id');
		$reason			= "ntg";
        $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id),'');
        if(!empty($Check_Subscribe)){
            $this->common_model->commonUpdate('prod_subscriptions',array('reason'=>$reason,'is_active'=>'3'),array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id));
            $response['message'] = 'Your Subscription deleted successfully';
            // echo "Your Subscription deleted successfully";exit;
            $get_sub_count =$this->db->query("SELECT `subscribe_id`, `user_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `user_id`=$user_id AND `is_active`=1")->result_array();
            // print_r(count($get_sub_count));exit;
            $arr =['subscription_count' =>count($get_sub_count)];
            echo json_encode($arr);
        }else{
            $response['message'] = 'Invalid subscriber id';
            // echo "Invalid subscriber id";exit;
            echo 0;
        }
	}
	public function unpause_the_subscraibe_product(){
       checkuser_login();
        $user_id        = $this->session->userdata('user_id');
        $subscribe_id   = $this->input->post('subscription_id');
        $Check_Subscribe=$this->common_model->commonGet('prod_subscriptions','subscribe_id',array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id,'is_active'=>2),'');
        if(!empty($Check_Subscribe)){
            $this->common_model->commonUpdate('prod_subscriptions',array('type'=>'resume','is_active'=>1,'reason'=>''),array('user_id'=>$user_id,'subscribe_id'=>$subscribe_id));
             echo 1;
        }else{
        	echo 0;
        }
	}
	public function get_month_dates()
	{
		$sub_date =$this->input->post('sub_date');
		if($sub_date!=''){
			$date = explode('-', $sub_date);
			$day   = $date[0];
			$month = $date[1];
			$year  = $date[2];
			$data['days_count'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
			echo $this->load->view('frontend/get_month_days',$data,TRUE);
		}
		
		
	}
}