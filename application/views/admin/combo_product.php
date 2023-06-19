<?php 
if(count($mes)>0){ 
$a=1;
$mes1 =json_decode($mes['combo_products'],true);
if(!empty($mes1)){
foreach($mes1 as $res){
	// echo "<pre>";print_r($res['combo_products']);exit;
// $image = json_decode($res['combo_products'],true);
?>
<tr>
    <td><?php echo $a; ?></td>
    <td><?php echo $res['prod_title']; ?></td>
    <td><?php echo $res['prod_org_price']; ?></td>
    <td><?php echo $res['prod_offered_price']; ?></td>
    <td><?php echo $res['prod_available_qty']; ?></td>
    <td><img src="<?php echo base_url();?>assets/products/<?php echo $res['prod_image'];?>" height="100px" width="100px"/></td>
</tr>
<?php   
$a++; 
} }else{ echo "no data found";}
} 
?>