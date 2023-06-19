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