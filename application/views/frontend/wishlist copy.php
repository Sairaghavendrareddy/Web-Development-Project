<section class="ss-inner-brd">
   <div class="container">
      <div class="ss-inner-brd-cnt">
         <h1>The Soil Son <span><i class="fas fa-shopping-cart"></i> Your Wishlist</span></h1>
         <ul>
            <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="brek-lst">/</li>
            <li class="brd-active">Wishlist</li>
         </ul>
      </div>
   </div>
</section>
<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Wishlist</h1>
      <div class="item" id="wishlist_empty">
         <?php if(!empty($wish_list)){ foreach ($wish_list as $wishlist){ ?>
         <div class="prodct-bx" id="remove_wish_product_<?php echo $wishlist['prod_id']; ?>">
            <a href="<?php echo base_url(); ?>product/product_details/<?php echo $wishlist['prod_slug']; ?>" target="_blank">
               <div class="prodct-bx-pic">
                  <div class="prd-bx-info">
                     <div class="prodt-frnd vegan">
                        <i class="fas fa-circle"></i>
                     </div>
                  </div>
                  <div class="prd-recomnd">
                     <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                  </div>
                  <div class="prdt-main-imag" />
                     <?php $wishlist['prod_image']; 
                        $prod_image =$wishlist['prod_image'];
                        $decode_prod_image = json_decode($prod_image, true);
                        $product_img =$decode_prod_image[0];
                        ?>
                     <img class="1_change-image" src="<?php echo base_url();?>assets/products/<?php echo $product_img; ?>" />
                  </div>
                  <div class="prodt-offer">
                     <h4>
                        <img src="<?php echo base_url(); ?>assets/frontend/images/discount.svg" /> GET 60%
                        OFF
                     </h4>
                  </div>
            </a>
            </div>
            <div class="prodct-bx-cnt">
               <div class="prodct-bx-det">
                  <a href="<?php echo base_url(); ?>product/product_details/<?php echo $wishlist['prod_slug']; ?>">
                     <h1 class="prod_title"><?php echo $wishlist['prod_title']; ?></h1>
                  </a>
                  <div class="prodct-bx-prc">
                     <ul>
                        <li class="cmpny-prc">Rs. <span
                           class="prod_offered_price"><?php echo $wishlist['prod_offered_price']; ?></span>
                        </li>
                     </ul>
                  </div>
                  <div class="prodct-bx-delvry">
                     <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     <button onclick="remove_wishlist('<?php echo $wishlist['prod_id']; ?>');">Remove</button>
                  </div>
               </div>
            </div>
             <?php  } }else{ echo "No data found";}?>
         </div>
        
      </div>
   </div>
</section>
<script>
   function remove_wishlist(prod_id){
        bootbox.confirm({
        message: "Are you sure you want to remove this?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result){
                 $.ajax({
                    url: '<?php echo site_url('profile/remove_wishlist'); ?>',
                    type: 'POST',
                    data: {prod_id: prod_id},
                    success: function(data) {
                       if(data==2){
                           $.toast({heading:'Error',text:'Wishlist Item deleted Failed Please try Again...',position:'top-right',stack: false,icon:'error'});
                       }else if(data==0){
                            $('#remove_wish_product_'+prod_id).remove();
                             $('#wishlist_empty').html('<h4>No Data Found</h4>');
                            $.toast({heading:'Success',text:'Wishlist Item deleted Successfully...',position:'top-right',stack: false,icon:'success'});
                       }else{
                            $('#remove_wish_product_'+prod_id).remove();
                            $.toast({heading:'Success',text:'Wishlist Item deleted Successfully...',position:'top-right',stack: false,icon:'success'});
                       }
                    }
                });
            }
        }
    });
   }
</script>