<?php
$base_url=base_url();
if(is_array($output) && count($output)>0){
    foreach($output  as $k=>$res){
            $user_apartment_det_id = $res['user_apartment_det_id'];
            $user_id=$res['user_id'];
            $address=$this->db->query("SELECT d.`user_apartment_det_id`, d.`apartment_id`, d.`block_id`, d.`flat_id`,d.`user_id`,a.flat_name,b.block_name,c.apartment_name,c.apartment_address,c.apartment_pincode FROM `user_apartment_details` d LEFT JOIN `flats` a ON a.`flat_id`=d.`flat_id` LEFT JOIN blocks b ON d.`block_id`=b.block_id LEFT JOIN apartments c ON d.apartment_id = c.apartment_id WHERE d.status=1 AND d.user_apartment_det_id=$user_apartment_det_id")->row_array();
            $userData=$this->db->query("SELECT `t1`.`user_id`, `t2`.* FROM `orders` as `t1` LEFT JOIN `users` as `t2` ON `t1`.`user_id` = `t2`.`user_id` WHERE t1.user_id=$user_id")->row_array();
            $order_id = $res['order_id'];
        $NewArr=array(); 
        $NewArr[]=$k+1;
            $paid=$res['paid_status'];
            if($paid==1){
                $paid_status = 'Tot Amount:  '.$res['order_amount'];
            }else{
                $paid_status = 'Cod Amount :  '.$res['order_amount'];
            }
        $NewArr[]='Order ID:    '.$res['payment_id'].'<br>Order Date:     '.$res['order_date'].'<br>Payment Mode: '.$res['payment_mode'].' <br>'.$paid_status.'';

               
            $sel='<select class="select2 form-control" name="cars" id="cars"  onchange="getval(this,'.$order_id.');">';
                $op=($res['payment_status']=='Processing')?'selected':'';
            $sel.='<option value="Processing" '.$op.'>Processing</option>';
                $op=($res['payment_status']=='Success')?'selected':'';
            $sel.='<option value="Success" '.$op.'>Success</option>';
                $op=($res['payment_status']=='Failed')?'selected':'';
            $sel.='<option value="Failed" '.$op.'>Failed</option>';
                $op=($res['payment_status']=='Cancelled')?'selected':'';
            $sel.='<option value="Cancelled" '.$op.'>Cancelled</option>';
                $op=($res['payment_status']=='Delivered')?'selected':'';
            $sel.='<option value="Delivered" '.$op.'>Delivered</option>';
            $sel.='</select>';


            if($res['payment_status'] == 'Processing') {
                $final= $res['order_date'];
            }else if($res['payment_status'] == 'Success'){
                $final= $res['order_succ_date'];
            }else if($res['payment_status'] == 'Failed'){
                $final= $res['order_failed_date'];
            }else if($res['payment_status'] == 'order_delivered_date'){
                $final= $res['order_delivered_date'];
            }else{
                $final= $res['order_cancelled_date'];
            }
        $NewArr[] = $sel.'<br>'.$final;
        $NewArr[]='Name:    '.$userData['name'].'<br>Email Id:     '.$userData['email'].'<br>Phone No: '.$userData['phone'].'';
            $add=($address['apartment_name']!='')?$address['apartment_name']:'';
            $add .= ($address['block_name']!='')?','.$address['block_name']:'';
            $add .= ($address['flat_name']!='')?','.$address['flat_name']:'';
            $add .= ($address['apartment_address']!='')?','.$address['apartment_address']:'';
            $add .= ($address['apartment_pincode']!='')?','.$address['apartment_pincode']:'';
        $NewArr[] = $add;
        $NewArr[] = '<a class="btn btn-primary dropdown-toggle waves-effect waves-light" target="_blank" href="'.$base_url.'admin/order_view/'.$res['order_id'].'">View Order</a>';
        $NewArr[] = '<a href="'.$base_url.'admin/invoice/'.$res['order_id'].'">Invoice</a>';
        $returndata['data'][]=$NewArr;
    }	
}else{
	$returndata['data']=array();
}
echo json_encode($returndata);exit;