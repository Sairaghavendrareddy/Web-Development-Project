<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('app_login');
		$this->load->helper('checklogin_helper');
	}
	public function index(){
		checkuser_login();
		$user_id        =   $this->session->userdata('user_id');
		$delivery_type  =   @$this->input->post('get_delivery_mode');
		$delivery_slot  =   @$this->input->post('get_delivery_slot_time');
		$slot_day       =   @$this->input->post('get_delivery_slots_day');
		$coupon_id  	=   @$this->session->userdata('coupon_id');
		$coupon_code  	=   @$this->session->userdata('coupon_code');
		$coupon_amount  =   @$this->session->userdata('coupon_amount');
		if($coupon_amount!=''){
			$coupon_amount  =   @$this->session->userdata('coupon_amount');
		}else{
			$coupon_amount=0;
		}
		// $online_amount	=	@$data['online_amount'];
		// $wallet_amount	=	@$data['wallet_amount'];
		if($this->session->userdata('final_order_amt')!=''){
			$order_amount   =   @$this->session->userdata('final_order_amt');
		}else{
			$order_amount   =   $this->cart->total();
		}
		// echo $order_amount;exit;
		$payment_mode   =   @$this->input->post('wallet_amount');
		$get_wallet_amount  =$this->db->query("SELECT `final_wallet_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
		$wallet_amount =$get_wallet_amount['final_wallet_amount'];
		// echo $wallet_amount;exit;
		$user_apartment_det_id      = $this->input->post('user_apartment_det_id');
		$adress_id      = $this->input->post('apartment_id');
		
		$check_wallet   =  1;
		if($payment_mode=='wallet' || $payment_mode=='wallet_online'){
		    $check_wallet = ($wallet_amount>=$order_amount)?1:0;
		} 
		// echo $check_wallet;exit;
		if($check_wallet==1){
		// $slot_day = @$slot_day;
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
                $cartdata = $this->cart->contents();
				// $payment_mode = $this->input->post('wallet_amount');
				$adress_id = $this->input->post('apartment_id');
				// $order_amount=$this->session->userdata('final_order_amt');
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
								$prod_id = $json_data['options']['prod_id'];
								$qty     = $json_data['qty'];
								$prod_mes_id     = $json_data['name'];
								$Check = $this->db->query("SELECT b.`prod_title`,a.`prod_available_qty` FROM `product_mesurments` a JOIN products b on a.`prod_id`=b.`prod_id` AND a.`id`=$prod_mes_id")->row_array();
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
								$ord_data['user_address_id'] 	    = 	$adress_id;
								$ord_data['user_apartment_det_id'] 	= 	$user_apartment_det_id;
								$ord_data['delivery_type'] 			= 	$delivery_type;
								$ord_data['slot'] 					= 	$slot;
								$ord_data['coupon_id']				=	@$coupon_id;
								$ord_data['coupon_code']			=	@$coupon_code;
								$ord_data['coupon_amount']			=	@$coupon_amount;
								$ord_data['online_amount']			=	@$online_amount;
								$ord_data['wallet_amount']			=	@$wallet_amount;
								$ord_data['slot_day'] = $slot_day;
								$order_id = $this->app_login->Save_Order_Details($ord_data);
								$this->app_login->Save_Order_Address_Details($user_apartment_det_id,$order_id,$user_id);
								foreach($cartdata as $k => $json_data) {
									// $json_data = json_decode($cart,true);
									$prod_id = $json_data['options']['prod_id'];
									$qty     = $json_data['qty'];
									$prod_mes_id     = $json_data['name'];
									$Check = $this->db->query("SELECT b.`prod_title`,a.`prod_available_qty`,a.`prod_org_price`,a.`prod_offered_price`,c.`title` as mes_title ,b.`prod_mesurements`, d.`title` as cat_title , e.`brand_title` as prod_brand,sb.`title` as sub_title FROM `product_mesurments` a JOIN products b on a.`prod_id`=b.`prod_id` LEFT JOIN mesurements c ON c.`mes_id`=a.`mes_id` LEFT JOIN categories d ON d.`cat_id`=b.`prod_category` LEFT JOIN category_brands e ON e.`brand_id`=b.`prod_brand` LEFT JOIN sub_categories sb ON sb.`sub_cat_id`=b.`prod_sub_category` WHERE a.`id`=$prod_mes_id")->row_array();
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
								$this->session->set_flashdata('success','Order placed successfully');
								$this->cart->destroy();
        						// $this->session->sess_destroy();
								redirect('profile#orders');
								// $response['message']='Order placed successfully';
								// echo "Order placed successfully";exit;
								// $response['order_id']=$reference_id;
								// $response['delivery_date']=date_month_name($delivery_date['delivery_date']).' '.($delivery_type=='normal')?'Before 8AM':'Between 8AM to 8PM ';
							}else{
								// $response['message']='Below list of products qty not available';
								// $response['products']=$Failed;
								// echo "Below list of products qty not available";exit;
								$this->session->set_flashdata('danger','Below list of products qty not available'.$Failed);
								redirect(base_url('checkout'));
							}
						}else{
							$this->session->set_flashdata('danger','Cart data were mondatory');
							redirect(base_url('checkout'));
						}
					}else{
						$this->session->set_flashdata('danger','Please select apartment address');
						redirect(base_url('checkout'));
					}
				}else{
					$this->session->set_flashdata('danger','Insufficient wallet amount...');
					redirect(base_url('checkout'));
				}
			}else{
				$this->session->set_flashdata('danger','Selected slot not available...');
				redirect(base_url('checkout'));
			}
		}else{
			$this->session->set_flashdata('danger','Invalid delivery time slot');
			redirect(base_url('checkout'));
		  }
		}else{
			$this->session->set_flashdata('danger','Wallet amount not greater of tot amount');
			redirect(base_url('checkout'));
		}
			
	}
	
	public function user_order_cancellation(){
        checkuser_login();
		$user_id        = $this->session->userdata('user_id');
        $order_id       = $this->input->post('order_id');
        $check_already_cancelled_or_not = $this->db->query("SELECT delivery_type,order_date,`order_id` FROM `orders` WHERE `order_id`=$order_id AND `user_id`=$user_id AND `order_status`='Cancelled'")->num_rows();
        if($check_already_cancelled_or_not>0){
            echo 0;
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
                echo 1;
            }else{
                echo 2;
            }
        }
	}
}