<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	function checklogin_admin(){
		$CI= & get_instance();		
		$CI->load->library('session');
		$CI->load->helper('url');
		$admin_id=$CI->session->userdata('admin_id');		
		if($admin_id=='' || !isset($admin_id)){
			redirect('master/');
		}
}