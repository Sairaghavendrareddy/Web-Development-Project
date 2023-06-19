<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$search =$this->input->get('search');
		$data['menu'] =$this->db->query("SELECT `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands`, `categories` FROM `categories` WHERE `status`=1 LIMIT 1")->result_array();
        $data['address_list'] =$this->db->query("SELECT `apartment_id`, `apartment_name`, `apartment_address`, `apartment_pincode`, `status`, `created_date`, `updated_date` FROM `apartments` WHERE `status`=1")->result_array();
		$data['menu_list'] =$this->db->query("SELECT `prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`, `prod_slug` FROM `products` WHERE `prod_title` LIKE '%$search%' AND `prod_status`=1")->result_array();
		// echo"<pre>";print_r($data['ppage']);exit;
		 $data['ppage']= $this->load->view('frontend/all_prods',$data,TRUE);
		$this->load->view('frontend/header',$data);
		$this->load->view('frontend/menu');
		$this->load->view('frontend/product_list');
		$this->load->view('frontend/footer');
	}
	public function get_autocomplete()
    {
        if (isset($_GET['term'])) {
            $result = $this->web_model->search_blog($_GET['term']);
            // echo "<pre>";print_r($result);exit;
            if (count($result) > 0) {
            foreach ($result as $row)
            // 	$img_decode =$row->prod_mesurements;
            //     $img = json_decode($img_decode, true);
            //     // echo "<pre>";print_r($img);exit;
            //     $image_decode =$img[0]['prod_image'];
            //     // echo "<pre>";print_r($image_decode);exit;
            //     $prod_image = json_decode($image_decode, true);
            // // echo "<pre>";print_r($prod_image);exit;
            	// $image =json_decode($row->prod_image);
            	// $url =base_url()."assets/products/";
           		// $arr_result[] =$url.json_decode($row->prod_image)[0] . ' ' . $row->prod_title;
                  $arr_result[] =$row->prod_title;
                echo json_encode($arr_result);
            }
        }
    }
}