<?php
$base_url=base_url();
if(is_array($userdetails) && count($userdetails)>0){
foreach($userdetails  as $k=>$res){
    $act='';
    $user_id = $res['user_id'];
    $img = ($res['profile_pic']!='')?$res['profile_pic']:'no_img.png';
	$userdet=array(); 
	$userdet[]=$k+1;
	$userdet[]=$res['name'];
	$userdet[]=$res['email'];
	$userdet[]=$res['phone'];
	$userdet[]='<img src="'.$base_url.'assets/images/'.$img.'" width="50px" height="50px"/>';
	$userdet[]=$res['created_date'];
	//$act .= '<a href="'.$base_url.'/admin/edit_user/'.$res['user_id'].'"><button class="save"> Edit </button></a></td>';
	$act .= '<a target="_blank" href="'.$base_url.'admin/orders/'.$user_id.'"><button class="btn btn-primary waves-effect waves-light"> Orders </button></a> | <a target="_blank" href=""><button class="btn btn-info waves-effect waves-light"> Subscribes </button></a>';
	$userdet[]=$act;
	$returndata['data'][]=$userdet;
}	
}else{
	$returndata['data']=array();
}
echo json_encode($returndata);exit;