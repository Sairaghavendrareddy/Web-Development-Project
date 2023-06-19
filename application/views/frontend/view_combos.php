<?php 
if(!empty($res)){
$products_json =$res['combo_products'];
$products = json_decode($products_json, true);
?>
<div class="del-logn-titl">
    <h1 id="combo_title"><?php echo $res['title']; ?></h1>
</div>

 <?php $sno = 1; foreach ($products as  $product) { ?>
	
	<div class="combo_prdt">
		<img src="<?php echo base_url();?>assets/products/<?php echo $product['prod_image'];?>" alt="<?php echo $product['prod_title']; ?>">
		<div class="combo_prdt_info">
		<h4><?php echo $product['prod_title']; ?></h4>
		<p><?php echo $product['mesurment']; ?></p>
		<h6>Rs <span><?php echo $product['prod_offered_price']; ?></span> </h6> 
		</div>
	</div>
	
	
	<!-- <h4><?php echo $product['prod_id']; ?></h4> -->
	<!-- <h4><?php echo $product['mes_id']; ?></h4> -->

	<!-- <h4><?php echo $product['prod_image']; ?></h4> -->
	<!-- <h4><?php echo $product['prod_org_price']; ?></h4> -->

	<!-- <h4><?php echo $product['prod_available_qty']; ?></h4> -->
<?php $sno++; } } else{ } ?>
