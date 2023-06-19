<section class="ss-inner-brd">
   <div class="container">
      <div class="ss-inner-brd-cnt">
         <h1>The Soil Son <span><i class="far fa-heart"></i> Your Wishlist</span></h1>
         <ul>
            <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="brek-lst">/</li>
            <li class="brd-active">Wishlist</li>
         </ul>
      </div>
   </div>
</section>
<section class="wish_list_products">
   <div class="container">
   <div id="wishlist_empty"></div>
      <div class="row">
         <!--------Loop start------>
          <?php if(!empty($wish_list)){ foreach ($wish_list as $wishlist){ ?>
          
         <div class="col-sm-12 col-md-6 col-xl-4" id="remove_wish_product_<?php echo $wishlist['prod_id']; ?>">
            <div class="wsh_lst_main">
               <div class="prodct-bx">
                  <a href="<?php echo base_url(); ?>product/product_details/<?php echo $wishlist['prod_slug']; ?>" target="_blank">
                  </a>
                  <div class="prodct-bx-pic">
                      <a href="<?php echo base_url(); ?>product/product_details/<?php echo $wishlist['prod_slug']; ?>" target="_blank">
                        <div class="prd-bx-info">
                           <div class="prodt-frnd vegan">
                              <i class="fas fa-circle"></i>
                           </div>
                        </div>
                        <div class="prd-recomnd">
                           <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png">
                        </div>
                        <div class="prdt-main-imag">
                            <?php $wishlist['prod_image']; 
                              $prod_image =$wishlist['prod_image'];
                              $decode_prod_image = json_decode($prod_image, true);
                              $product_img =$decode_prod_image[0];
                           ?>
                          <img class="1_change-image" src="<?php echo base_url();?>assets/products/<?php echo $product_img; ?>" />
                        </div>
                        <div class="prodt-offer">
                           <h4>
                              <img src="<?php echo base_url(); ?>assets/frontend/images/discount.svg"> GET 60%
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
                           <ul class="wishlish_prc_ul">
                              <li class="cmpny-prc">Rs. <span class="prod_offered_price"><?php echo $wishlist['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                        <div class="wish_list_remove">
                           <button onclick="remove_wishlist('<?php echo $wishlist['prod_id']; ?>');">Remove</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php  } }else{ ?>
            <section class="cart_page_total_section searchntfnd p-0">
   <div class="container">
      <div id="empty_cart_items">
         <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
               <div class="cart_page_left_inner">
                                    <div class="cart_page_empty_cart_section">
                     <div class="cart_page_empty_cart_image">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png">
                     </div>
                     <h3>No Data Found</h3>
                     <div class="cart_page_empty_continue_btn">
                        <a href="<?php echo base_url(); ?>">Continue Shopping</a>
                     </div>
                  </div>
                   
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
            <?php }?>
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
                             $('#wishlist_empty').html('<div class="nodatafound m-0"><div class="nodatafound-cnt"><div class="nodatafound-pic"><img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"/></div><p>No Data Found</p></div></div>');
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