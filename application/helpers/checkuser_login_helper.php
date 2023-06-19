<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	function checkuser_login(){
		$CI= & get_instance();
        $CI->load->library('session');
        $CI->load->helper('url');
        $user_id =$CI->session->userdata('user_id');
        $user_name =$CI->session->userdata('user_name');
        if(($user_id =='' || !isset($user_id)) && ($user_name =='' || !isset($user_name))){
            redirect(base_url());
		}
}