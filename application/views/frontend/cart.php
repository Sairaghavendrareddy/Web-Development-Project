<section class="ss-inner-brd">
   <div class="container">
      <div class="ss-inner-brd-cnt">
         <h1>The Soil Son <span><i class="fas fa-shopping-cart"></i> Your Cart</span></h1>
         <ul>
            <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="brek-lst">/</li>
            <li class="brd-active">Cart</li>
         </ul>
      </div>
   </div>
</section>
<section class="cart_page_total_section">
   <div class="container">
      <div id="empty_cart_items">
         <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
               <div class="cart_page_left_inner">
                  <?php 
                     $cart = $this->cart->contents();
                     if(!empty($cart)){ ?>
                  <div id="empty_cart">
                     <?php
                        foreach ($cart as $contents) { ?>
                     <div class="cart_page_item_total" id="remove_rowid_<?php echo $contents['rowid']; ?>">
                        <div class="cart_page_product_image"> 
                           <a href="<?php echo base_url(); ?>products/product_details/<?php echo $contents['options']['prod_id']; ?>">
                           <img src="<?php echo $contents['options']['prod_image']; ?>" alt="product img">
                           </a>
                        </div>
                        <div class="cart_page_product_names_right">
                           <div class="cart_page_porduct_name_item_left">
                              <h3 class="cart_page_product_item_heading"><?php echo $contents['options']['prod_title']; ?></h3>
                              <span class="cart_page_product_item_quntity"><?php echo $contents['options']['prod_mes_title']; ?></span>
                              <div class="cart_page_product_plus_minus prodct-add-plsmin addtocart_<?php echo $contents['options']['prod_mes_id']; ?>">
                                 <div class="prodct-plsmin" id="input_div">
                                    <button type="button" value="-" onclick="minus(1,'<?php echo $contents['options']['prod_id']; ?>','<?php echo $contents['name']; ?>','<?php echo $contents['rowid']; ?>')"><i class="fas fa-minus"></i> </button>
                                    <input class="plsmin-vlue chck_qty_<?php echo $contents['name']; ?>" type="text" size="25" value="<?php echo@$contents['qty'];?>" readonly />
                                    <button type="button" value="+" onclick="plus(1,'<?php echo $contents['options']['prod_id']; ?>','<?php echo $contents['name']; ?>','<?php echo $contents['rowid']; ?>')"><i class="fas fa-plus"></i></button>
                                 </div>
                              </div>
                           </div>
                           <div class="cart_page_porduct_name_item_right">
                              <div class="cart_page_product_final_amout">
                                 <?php 
                                    $chk_qty =$contents['qty'];
                                    $price =$contents['price'];
                                    $totoal_price =$chk_qty * $price;
                                    ?>
                                 <input type="hidden" name="price" class="price_<?php echo $contents['name']; ?>" value="<?php echo $totoal_price; ?>">
                                 <input type="hidden" name="prod_price" class="prod_price_<?php echo $contents['name']; ?>" value="<?php echo $contents['price']; ?>">
                                 <span class="cart_page_product_amout_strike">Rs <strike><?php echo $contents['options']['prod_org_price']; ?></strike></span>
                                 <div class="cart_page_product_amount_heading">Rs <span id="price_<?php echo $contents['name']; ?>"><?php echo $totoal_price; ?></span></div>
                              </div>
                              <div class="cart_page_product_remove_btn">
                                 <ul class="cart_page_remove_wishlist">
                                    <?php
                                       $prodid=$contents['options']['prod_id'];
                                       $prodtitle =$contents['options']['prod_title'];
                                       $combo_products = $this->db->query("SELECT `prod_id`, `prod_title`,`combo_products`, `prod_slug` FROM `products` WHERE `prod_id`=$prodid")->row_array();
                                       
                                       $combo_products =$combo_products['combo_products'];
                                       if(!empty($combo_products)){ ?>
                                    <li>
                                       <button type="button" class="cart_page_remove_btn_inner cart_cmbo_clr" onclick="view_combos('<?php echo $prodid; ?>');"><i class="fas fa-list-ul"></i> View</button>
                                    </li>
                                    <li>|</li>
                                    <?php } else{ } ?>
                                    <?php if($this->session->userdata('user_id')!=''){
                                       $user_id =$this->session->userdata('user_id');
                                       $prod_id =$contents['options']['prod_id'];
                                       $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$prod_id AND `user_id`=$user_id")->num_rows(); 
                                       if(($wlist)>0){
                                       ?>
                                    <li>
                                       <button class="cart_page_remove_btn_inner" onclick="move_to_wishlist('<?php echo $contents['options']['prod_id']; ?>','<?php echo $contents['rowid']; ?>');"><i class="far fa-heart"></i> 
                                       <span id="Remove_to_Wishlist_<?php echo $contents['rowid']; ?>">Remove to Wishlist</span></button>
                                    </li>
                                    <?php }else{ ?>
                                    <li>
                                       <button class="cart_page_remove_btn_inner" onclick="move_to_wishlist('<?php echo $contents['options']['prod_id']; ?>','<?php echo $contents['rowid']; ?>');"><i class="far fa-heart"></i> Move to Wishlist</button>
                                    </li>
                                    <?php } }else{ ?>
                                    <button class="cart_page_remove_btn_inner" onclick="move_to_wishlist('<?php echo $contents['options']['prod_id']; ?>','<?php echo $contents['rowid']; ?>');"><i class="far fa-heart"></i> Move to Wishlist</button>
                                    <?php } ?>
                                    <li>|</li>
                                    <li>
                                       <button class="cart_page_remove_btn_inner" onclick="removecart('<?php echo $contents['rowid']; ?>');"><i class="fas fa-times"></i> Remove</button>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
                  <?php }else{ ?>
                  <div class="cart_page_empty_cart_section">
                     <div class="cart_page_empty_cart_image">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png" />
                     </div>
                     <h3>Your Cart is Currently Empty</h3>
                     <div class="cart_page_empty_continue_btn">
                        <a href="<?php echo base_url(); ?>">Continue Shopping</a>
                     </div>
                  </div>
                  <?php } ?> 
               </div>
            </div>
            <?php $cart = $this->cart->contents();
               if(!empty($cart)){ 
               ?>
            <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3" id="order_summary">
               <?php if($this->session->userdata('user_id')!=''){ ?>
               <div class="cart_page_right_inner cart_page_mb-8">
                  <h3 class="cart_pge_coupon_code">Coupon Code</h3>
                  <div class="cart_page_promo_check">
                     <?php if($this->session->userdata('coupon_code')!=''){ ?>
                     <input type="text" class="cart_page_coupon_enter" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code" value="<?php echo $this->session->userdata('coupon_code'); ?>" readonly/>
                     <div id="coupon_remove">
                        <input type="button" class="cart_page_coupon_apply" onclick="remove_coupon();" name="coupon" id="coupon" value="Remove" name="Remove" />
                     </div>
                     <?php }else{ ?>
                     <input type="text" class="cart_page_coupon_enter" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code" />
                     <div id="coupon_remove">
                        <input type="button" class="cart_page_coupon_apply" onclick="apply_coupon();" name="coupon" id="coupon" value="Apply" name="Apply" />
                     </div>
                     <?php }  ?>
                  </div>
               </div>
               <?php } else { ?>
               <a href="#login-modal" data-toggle="modal" data-target="#login-modal">
                  <div class="cart_page_right_inner cart_page_mb-8">
                     <h3 class="cart_pge_coupon_code">Coupon Code</h3>
                     <div class="cart_page_promo_check">
                        <input type="text" class="cart_page_coupon_enter" placeholder="Enter Coupon Code" />
                        <input type="submit" class="cart_page_coupon_apply" value="Apply" name="Apply" />
                     </div>
                  </div>
               </a>
               <?php } ?>
               <div class="cart_page_right_inner">
                  <h3 class="cart_pge_coupon_code">Order Summary</h3>
                  <div class="cart_page_total_amount_cart">
                     <span class="cart_page_total_left_all_heading">Sub Total:</span>
                     <span class="cart_page_total_right_all_heading cart_totl_amnt" id="cart_totl_amnt"><?php echo $this->cart->total(); ?></span>
                  </div>
                  <div class="cart_page_total_amount_cart">
                     <span class="cart_page_total_left_all_heading">Discount:</span>
                     <?php if($this->session->userdata('coupon_amount')!=''){ ?>
                     <span class="cart_page_total_right_all_heading" id=discount><?php echo $this->session->userdata('coupon_amount'); ?></span>
                     <?php }else{ ?>
                     <span class="cart_page_total_right_all_heading" id=discount></span>
                     <?php } ?>
                  </div>
                  <div class="cart_page_total_amount_cart">
                     <span class="cart_page_total_left_all_heading" >Delivery Charges:</span>
                     <span class="cart_page_total_right_all_heading">0</span>
                  </div>
                  <div class="cart_page_total_amount_cart cart_page_total_amount_bold">
                     <span class="cart_page_total_left_all_heading" id="remove_tol_amt">Total Amount:</span>
                     <?php if($this->session->userdata('coupon_code')!=''){ ?>
                     <span class="cart_page_total_right_all_heading cart_totl_amnt" id="final_order_amt"><?php echo $this->session->userdata('final_order_amt'); ?></span>
                     <?php }else{ ?>
                     <span class="cart_page_total_right_all_heading cart_totl_amnt" id="final_order_amt"><?php echo $this->cart->total(); ?></span>
                     <?php } ?>
                  </div>
                  <div class="cart_page_goto_checkout_btn">
                     <?php if($this->session->userdata('user_id')!=''){ ?>
                     <a href="<?php echo base_url(); ?>checkout">Checkout</a>
                     <?php }else{ ?>
                     <a href="#login-modal" data-toggle="modal" data-target="#login-modal">Checkout</a>
                     <?php } ?>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</section>
<script>
   function removecart(rowid) {
       $.ajax({
           url: '<?php echo site_url("cart/removecart"); ?>',
           type: 'POST',
           data: {rowid: rowid},
           success: function(data) {
               if (data!= '') 
               {
                   $("#remove_rowid_" + rowid).remove();
                    var obj =$.parseJSON(data);
                           if(obj['cart_count']==0)
                           {
                               $("#remove_tol_amt").remove();
                               $("#order_summary").remove();
                               $("#empty_cart").html('<div class="cart_page_empty_cart_section"><div class="cart_page_empty_cart_image"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png" /></div><h3>Your Cart is Currently Empty</h3><div class="cart_page_empty_continue_btn"><a href="<?php echo base_url(); ?>">Continue Shopping</a></div></div>');
                               $('#cart_count').html(cart_count);
                           }else{
                                $("#cart_count").html(obj['cart_count']);
                              }
                           remove_coupon();
               }else {
                    $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
               }
            },error: function (data) {
              $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
            }
       });
   }
   
   function minus(id_type,prod_id, prod_mes_id, rowid) {
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       var price = parseInt($('.prod_price_' + prod_mes_id).val());
       $.ajax({
           url: '<?php echo site_url('home/ajax_minus_prod_qty'); ?>',
           type: 'POST',
           data: {prod_id: prod_id,prod_mes_id: prod_mes_id,qty: qty,rowid: rowid},
           dataType: "json",
           success: function(data) {
               var chk_qty = data.qty;
               var cart_count = data.cart_count;
               var cart_tatl = data.cart_tatl;
               if(chk_qty==0){
                      $("#remove_rowid_" + rowid).remove();
                       var cart_totl_amt = $('.cart_totl_amnt').html(cart_tatl);
                       $('#cart_count').html(cart_count);
                       if(cart_count==0){
                         $("#remove_tol_amt").remove();
                         $("#order_summary").remove();
                         $("#empty_cart").html('<div class="cart_page_empty_cart_section"><div class="cart_page_empty_cart_image"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png" /></div><h3>Your Cart is Currently Empty</h3><div class="cart_page_empty_continue_btn"><a href="<?php echo base_url(); ?>">Continue Shopping</a></div></div>');
                         $('#cart_count').html(cart_count);
                       }
               }else if (chk_qty!='') {
                   $('.chck_qty_' + prod_mes_id).val(qty - 1);
                   var minus_qty = $('.chck_qty_' + prod_mes_id).val();
                   var minus_price = minus_qty * price;
                   var finl_prc = parseInt($('#price_' + prod_mes_id).html(minus_price));
                   var cart_totl_amt = $('.cart_totl_amnt').html(cart_tatl);
                   $('#cart_count').html(cart_count);
               } else {
                    $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
               }
           }
       });
   }
   function apply_coupon(){
        var coupon_code =$('#coupon_code').val();
        var order_tot_amount =$('#cart_totl_amnt').text();
        if(coupon_code==''){
            return false;
        }
            $.ajax({
                url: '<?php echo site_url('cart/check_coupon_existed_or_not'); ?>',
                type: 'POST',
                 dataType: 'json',
                data: {coupon_code: coupon_code,order_tot_amount: order_tot_amount},
                success: function(data) {
                  var coupon_id = data.coupon_id;
                  var coupon_code = data.coupon_code;
                  var coupon_amount = data.coupon_amount;
                  var final_order_amt = data.final_order_amt;
                  var status =data.status;
                  var msg =data.msg;
                    if(status==1){
                        $("#discount").html(coupon_amount);
                        // var net_payble_amt =parseFloat(order_tot_amount)-parseFloat(coupon_discount_amt);
                         $("#final_order_amt").html(final_order_amt);
                         // $("#remove_netpay_amt").show();
                         $("#coupon_code").prop('disabled', true);
                         $("#coupon_remove").html('<input type="button" class="cart_page_coupon_apply" name="coupon_remove" id="coupon_remove" value="Remove" onclick="remove_coupon();" />');
                         $.toast({heading:'Success',text:'Coupon applied successfully',position:'top-right',stack: false,icon:'success'});
                    }else{
                         $.toast({heading:'Error',text:msg,position:'top-right',stack: false,icon:'error'});
                    }
                }
            });
   }
   
   function move_to_wishlist(prod_id,rowid){
     var user_id = '<?php echo $this->session->userdata("user_id");?>'; 
     if(user_id!='')
     {     
         $.ajax({
            url: '<?php echo site_url('cart/move_to_wishlist'); ?>',
            type: 'POST',
            data: {prod_id: prod_id,rowid: rowid},
            success: function(data) {
                 var obj =$.parseJSON(data);
                 $("#cart_count").html(obj['cart_count']);
               if(obj['status']==1)
               {
                     $('#remove_rowid_'+rowid).remove();
                     $('#cart_totl_amnt').html(obj['cart_tatl']);
                     $('#final_order_amt').html(obj['cart_tatl']);
                     remove_coupon();
       
                    if(obj['cart_count']==0)
                    {
                       $('.justify-content-center').remove(); 
                       $("#empty_cart_items").html('<div class="cart_page_empty_cart_section"><div class="cart_page_empty_cart_image"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png" /></div><h3>Your Cart is Currently Empty</h3><div class="cart_page_empty_continue_btn"><a href="<?php echo base_url(); ?>">Continue Shopping</a></div></div>');
                    }
                     
                    $.toast({heading:'Success',text:'Added to Your Wishlist Successfully...',position:'top-right',stack: false,icon:'success'});
               }else{
                    $('#Remove_to_Wishlist_'+rowid).text('Move to Wishlist');
                    $.toast({heading:'Success',text:'Removed from your wishlist successfully...',position:'top-right',stack: false,icon:'success'});
                    // setTimeout(function () {
                    //     location.reload(true);
                    //   }, 3000);
               }
            }
        });
     }else{
        $('#login-modal').modal('show');
      } 
   }
   
</script>