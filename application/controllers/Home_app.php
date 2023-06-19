<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
	if (isset($_SERVER['HTTP_ORIGIN'])) {
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');
	}
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
	}
class Home_app extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('app_login');       
	}
	public function login_with_otp(){
		$data=json_decode(file_get_contents("php://input"),true);
		$data=(isset($data))? $data : $_POST;
		$mobile=$data['mobile'];
		$otp=trim($data['otp']);
		$relation=trim($data['relation']);
		$member_id=$data['member_id'];
		if(isset($data['device_id'])){
			$device_id=$data['device_id'];
		}else{
			$device_id=0;
		}
		$is_device=isset($data['is_device'])?$data['is_device']:false;
		$result=$this->db->query("SELECT `user_id`,`password`,`appartment_id`,`member_name` FROM `ams_members` WHERE `otp`=$otp AND `user_id`=$member_id")->row_array();
		if(!empty($result)){
			if($relation==0){
				$username=$result['username'];
				$mobile_number=$result['mobile_number'];
			}else{
				$res=$this->db->query("SELECT `phonenumber`,`name` FROM `ams_family_members` WHERE `member_id`=$member_id AND `relation`=$relation")->row_array();
				$username=$res['name'];
				$mobile_number=$res['phonenumber'];
			}
			$uid=$result['user_id'];
			$apikey=$device_id.$member_id.$result['password'].time();
			$key=md5($apikey);
			$characters =$key;
			$randomString = '';
			for ($i=0;$i<10;$i++){
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}		
			$check_device=$this->app_login->check_device($device_id,$uid);
			if($check_device>=1){
				$res=$this->app_login->updateKey($uid,$randomString,$device_id,$is_device);
				if($res==1){					 
					$response=array(
						'status'=>'1', 
						'message'=>'Login successfully',
						'userid'=>$uid,
						'userkey'=>$randomString,
						'username'=>$username,
						'appartment_id'=>$result['appartment_id'],
						"device_id"=>$device_id,
						"relation"=>$relation,
						"mobile_number"=>$mobile_number
					); 
					echo json_encode($response);exit;
				}
			}else if($check_device==0){
				$res=$this->app_login->insertKey($uid,$randomString,$device_id,$is_device);
				if($res==1){
					$response=array(
						'status'=>'1', 
						'message'=>'Login successfully',
						'userid'=>$uid,
						'userkey'=>$randomString,
						'username'=>$username,
						'appartment_id'=>$result['appartment_id'],
						"device_id"=>$device_id,
						"relation"=>$relation,
						"mobile_number"=>$mobile_number
					); 
					echo json_encode($response);exit;
				}
			}else{
				$response=array('status'=>'0', 'message'=>'Invalid username or password');
			}			
		}else{
			$response=array('status'=>'0', 'message'=>'Invalid otp');
		} 
		echo json_encode($response);
	}
}
