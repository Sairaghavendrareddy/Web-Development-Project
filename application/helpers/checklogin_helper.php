<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
      
	#--------------------------------------------------------------------
	# function for Check Super Admin Login
	#---------------------------------------------------------------------
	function checklogin(){
		$CI= & get_instance();
		$CI->load->library('session');
		$CI->load->helper('url');
		$user_id =$CI->session->userdata('user_id');
		$user_type =$CI->session->userdata('user_type');
		$type =$CI->session->userdata('type');
		$stype = $CI->uri->segment(1);
		if(($user_id =='' || !isset($$user_id)) && ($user_type =='' || !isset($user_type)) || $type!=$stype){
			redirect(base_url());
		}
	}
	function get_module_type($type=0){
		if($type==2){
			$nm='Admin';
		}else if($type==1){
			$nm='Superadmin';
		}else if($type==4){
			$nm='Member';
		}else{
			$nm='Agent';
		}
	}
	function PassWord_Default($type=''){
		return md5('root');
	}
	function PassWord_Encode($pass){
		return md5($pass);
	}
	function str_preg_replace($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return (trim($string, '-'));
    }
	function Generate_Otp(){
		//$otp =  mt_rand(1000,9999);
		$otp = 1111;
		return $otp;
	}
	function yy_mm_dd($date){
		return date('Y-m-d', strtotime($date));
	}
	function Delivery_Charge(){
		return 45;
	}
	function Service_Charge(){
		return 25;
	}
	function date_month_name($original_date){
		return date("M-d-Y", strtotime($original_date));
	}
	function delivery_date_with_time($original_date){
		return date("M-d-Y H:i:s", strtotime($original_date));
	}
	function time2sec($time) {
        $time= explode(':', $t);
	    $h = $time[0]*(3600);
	    $m = $time[1]*60;
	    $s = $time[2];
	    return $h+$m+$s;
        // $sec = 0;
        // foreach (array_reverse(explode(':', $time)) as $k => $v) $sec += pow(60, $k) * $v;
        // return $sec;
    }
    function combo(){
		$arr['ct'] 	= 	'combos';
		$arr['ms']	=	'combo';
		return $arr;
	}
	function Transaction_Id(){
	   return $randomNum= strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 11));
	}
