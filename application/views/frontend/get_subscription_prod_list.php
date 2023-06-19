<?php foreach ($pause_list as $res) {
      $image =$res['prod_image'];
      $image_decode = json_decode($image, true);
      $img =$image_decode[0];
   ?>
<div class="subscrip-item">
   <img src="<?php echo base_url(); ?>assets/products/<?php echo $img; ?>"/>
     <div class="subscrip-item-info">
         <h2><?php echo $res['prod_title']; ?></h2>
         <p><?php echo $res['title']; ?></p>
         <?php
            $mes_id =$res['id'];
            $chk =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `qty` FROM `prod_subscriptions` WHERE `prod_mes_id`=$mes_id")->row_array(); 
            $get_qty =$chk['qty']; ?>
         <p>Qty : <span><?php echo $get_qty; ?></span></p>
         <p>MRP : &#8377<span><?php echo $res['prod_offered_price']; ?></span></p>
     </div>
</div>
<?php } ?>