<?php 
if(count($mes)>0){ 
$a=1;
foreach($mes as $res){
$image = json_decode($res['prod_image'],true);
?>
<tr>
    <td><?php echo $a; ?></td>
    <td><?php echo $res['title']; ?></td>
    <td><?php echo $res['prod_org_price']; ?></td>
    <td><?php echo $res['prod_offered_price']; ?></td>
    <td><?php echo $res['prod_available_qty']; ?></td>
    <td><img src="<?php echo base_url();?>assets/products/<?php echo $image[0];?>" height="100px" width="100px"/></td>
</tr>
<?php   
$a++; 
} 
} 
?>


<?php 
// 	echo "<pre>";print_r($combos);exit;
if(count($combos)>0){  ?>
Combos
    <?php $combo =json_decode($combos['combo_products'],true);
    // 	echo "<pre>";print_r($combo);exit;
$a=1;
foreach($combo as $cmb){
?>
<tr>
    <td><?php echo $a; ?></td>
    <td><?php echo $cmb['prod_title']; ?></td>
   <!-- <td><?php echo $cmb['mesurment']; ?></td>  -->
    <td><?php echo $cmb['prod_org_price']; ?></td>
    <td><?php echo $cmb['prod_offered_price']; ?></td>
    <td><?php echo $cmb['prod_available_qty']; ?></td>
    <td><img src="<?php echo base_url();?>assets/products/<?php echo $cmb['prod_image'];?>" height="100px" width="100px"/></td>
</tr>
<?php   
$a++; 
} 
} 
?>