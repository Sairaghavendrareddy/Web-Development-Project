<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Signup extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
        $data['p_details'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`,`prod_slug` FROM `products` WHERE `prod_id`=$prod_id AND `prod_status`=1")->row_array();
        $p_decode=$data['p_details']['prod_mesurements'];
        $data['p_decode'] = json_decode($p_decode, true);
        // echo "<pre>";print_r( $data);exit;	
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/product_details');
		$this->load->view('frontend/footer');
	}
	
	
}