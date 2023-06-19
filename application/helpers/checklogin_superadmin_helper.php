<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	function checklogin_sadmin(){
		$CI= & get_instance();		
		$CI->load->library('session');
		$CI->load->helper('url');
		$superadmin_id=$CI->session->userdata('superadmin_id');		
		if($superadmin_id=='' || !isset($superadmin_id)){
			redirect('login/');
		}
}