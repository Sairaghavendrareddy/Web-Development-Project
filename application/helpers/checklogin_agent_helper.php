<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	function checklogin_agent(){
		$CI= & get_instance();		
		$CI->load->library('session');
		$CI->load->helper('url');
		$admin_id=$CI->session->userdata('agent_id');		
		$agent_table_id=$CI->session->userdata('agent_table_id');		
		if($admin_id=='' || !isset($admin_id) || $agent_table_id=='' || !isset($agent_table_id)){
			redirect('login/');
		}
}