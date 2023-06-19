<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'libraries/REST_Controller.php';
if(isset($_SERVER['HTTP_ORIGIN'])){
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
}
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		exit(0);
}
class Home_api extends REST_Controller{
	public function __construct(){
        parent :: __construct();
        $this->load->model();
	}
	public function user_register_post(){
		$data = json_decode(file_get_contents("php://input"),true);
        $data=(isset($data))? $data : $_POST;	
        $pass= md5(PassWord_Default('user'));

		$this->set_response($response, REST_Controller::HTTP_CREATED);
	}
}
