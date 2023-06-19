<?php
$base_url=base_url();
if(is_array($output) && count($output)>0){
    foreach($output  as $k=>$res){
        $NewArr=array(); 
        $NewArr[]=$k+1;
        $NewArr[]=$res['prod_title'];
        $NewArr[]='<a class="btn btn-outline-success waves-effect waves-light" href="javascript:void(0);" Onclick="Get_mess('.$res['prod_id'].');">View</a>';
       
       
        $NewArr[] = '<a href="'.$base_url.'admin/edit_combo/'.$res['prod_id'].'"><button class="btn btn-info waves-effect waves-light"> Edit </button></a>';
        $returndata['data'][]=$NewArr;
    }   
}else{
    $returndata['data']=array();
}
echo json_encode($returndata);exit;