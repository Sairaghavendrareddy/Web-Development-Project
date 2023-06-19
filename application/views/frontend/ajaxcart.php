<div class="rit-cart-cnt nicescroll">
   <?php if(!empty($cart)){ foreach ($cart as $cartData) { ?>
   <div id="remove_ajaxcart_<?php echo $cartData['name']; ?>" class="del_cart_item_<?php echo $cartData['rowid']; ?>">
      <div class="rit-cart">
         <div class="rit-cart-box">
            <div class="cart-box-img">
               <img src="<?php echo $cartData['options']['prod_image']; ?>" />
            </div>
            <div class="cart-box-des">
               <div class="cart-box-tit">
                  <h6><?php echo $cartData['options']['prod_title']; ?> <span><?php echo $cartData['options']['prod_mes_title']; ?></span></h6>
               </div>
               <input type="hidden" name="product_price" id="product_price_<?php echo $cartData['name']; ?>" value="<?php echo $cartData['price']; ?>">
               <div class="cart-box-prc">
                  <p>MRP <span>Rs 
                     <?php echo $cartData['options']['prod_org_price']; ?> 
                     </span> Rs
                     <?php echo $price=$cartData[ 'price']; ?>
                  </p>
               </div>
            </div>
            <div class="cart-box-qnty">
               <div class="cart-dd-qty">
                  <input class="plsmin-vlue chck_qty_<?php echo $cartData['name']; ?>" type="text" size="25"
                     value='<?php echo $cartData['qty']; ?>' readonly />
                  <div class="cart-dd-btns">
                     <div class="cart-dd-btn-cnt">
                        <button type="button" onclick="ajax_plus(1,'<?php echo $cartData['options']['prod_id']; ?>','<?php echo $cartData['name']; ?>','<?php echo $cartData['rowid']; ?>')"><i class="fas fa-plus"></i>
                        </button>
                     </div>
                     <div class="cart-dd-btn-cnt2">
                        <button type="button" onclick="ajax_minus(1,'<?php echo $cartData['options']['prod_id']; ?>','<?php echo $cartData['name']; ?>','<?php echo $cartData['rowid']; ?>')"><i class="fas fa-minus"></i>
                        </button>
                     </div>
                  </div>
               </div>
            </div>
            <div class="cart-box-sb-ttl">
               <p>Sub Total</p>
               <h6>Rs <span class="remove_tol_amt" id="sub_total_amount_<?php echo $cartData['name']; ?>"> <?php $chk_qty =$cartData['qty']; $price =$cartData['price']; $totoal_price =$chk_qty * $price; echo $totoal_price; ?> </span></h6>
            </div>
            <div class="cart-box-remove">
               <button onclick="removecart(1,'<?php echo $cartData['options']['prod_id']; ?>','<?php echo $cartData['name']; ?>','<?php echo $cartData['rowid']; ?>');">
               <i class="far fa-times-circle"></i>
               </button>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>
</div>
<div class="crt-total-set">
   <p>Total Amount : Rs <span id="subtotal"><?php echo $this->cart->total();?></span></p>
</div>
<div class="crt-checkout">
   <a href="javascript:void(0);" onclick="gotocheckout();">Checkout</a>
</div>
<?php }else{ ?>
<div class="ss-empty-cart">
   <div class="ss-empty-cart-img">
      <img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png">
   </div>
   <div class="ss-empty-cart-cnt">
      <p>Your Cart is empty. Start Shopping now!</p>
   </div>
</div>
<?php } ?>
<script>
function ajax_plus(id_type,prod_id,prod_mes_id,rowid){
    var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var total_amount = $('#product_price_' + prod_mes_id).val();
      $.ajax({
            url: '<?php echo site_url('home/ajax_plus_prod_qty'); ?>',
            type: 'POST',
            data: {prod_id: prod_id,prod_mes_id: prod_mes_id,qty: qty,rowid: rowid},
            dataType: "json",
            success: function(data) {
                if(data==0){
                    $.toast({heading:'Error',text:'Sorry! We don"t much have stock',position:'top-right',stack: false,icon:'error'});
                }else{
                     $('.chck_qty_' + prod_mes_id).val(qty + 1);
                      var multi_qty = $('.chck_qty_' + prod_mes_id).val();
                      var plus_price = multi_qty * total_amount;
                      var price1 = parseInt($('#sub_total_amount_' + prod_mes_id).html(plus_price));
                      $('#price_'+prod_mes_id).html(plus_price);
                      $('#final_order_amt').html(data);
                      $('#cart_totl_amnt').html(data);
                      var cart_totl_amt = $('#subtotal').html(data);
                      // $('#cart_count').html(cart_count);
                }
            }
      });
}
      
function ajax_minus(idtype,prod_id, prod_mes_id,rowid) 
{
    var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var total_amount = $('#product_price_' + prod_mes_id).val();
       $.ajax({
            url: '<?php echo site_url('home/ajax_minus_prod_qty'); ?>',
            type: 'POST',
            data: {prod_id: prod_id,prod_mes_id: prod_mes_id,qty: qty,rowid: rowid},
            dataType: "json",
            success: function(data) {
              var cart_tatl = data.cart_tatl;
              var cart_count = data.cart_count;
                 if(data!=0)
                 {
                    $('.chck_qty_' + prod_mes_id).val(qty - 1);
                    var minus_qty = (qty - 1);
                    var final_amount = (minus_qty) * (total_amount)
                    $('#sub_total_amount_' + prod_mes_id).text(final_amount);
                    var cart_totl_amt = $('#subtotal').html(cart_tatl);
                    $('#price_'+prod_mes_id).html(final_amount);
                    $('#final_order_amt').html(cart_tatl);
                    $('#cart_totl_amnt').html(cart_tatl);
                      if(cart_count==0){
                           $("#order_summary").remove();
                           $("#remove_rowid_"+rowid).remove();
                           $("#ajaxcart").html('<div class="ss-empty-cart"><div class="ss-empty-cart-img"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png"></div><div class="ss-empty-cart-cnt"><p>Your Cart is empty. Start Shopping now!</p></div></div>');
                           $("#empty_cart").html('<div class="cart_page_empty_cart_section"><div class="cart_page_empty_cart_image"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png" /></div><h3>Your Cart is Currently Empty</h3><div class="cart_page_empty_continue_btn"><a href="<?php echo base_url(); ?>">Continue Shopping</a></div></div>');
                        }
                         if(qty == 1)
                          {
                              var cart_totl_amt = $('#subtotal').html(cart_tatl);
                              $("#remove_ajaxcart_" + prod_mes_id).remove();
                              $("#remove_rowid_"+rowid).remove();
                              $('#cart_count').html(cart_count);
                              $(".cart_totl_amnt").html(cart_tatl);
                              // $("#ajaxcart").html('<p style="text-align: center;">Your Soilson is empty. Start shopping now!</p>');
                             $(".1_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +idtype + "," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                             $(".2_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(2," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                             $(".3_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(2," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                             $(".4_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(3," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                             $(".5_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +idtype + "," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                             $(".pdetails_addtocart_" + prod_id).html('<ul><li><button class="addcrt" onclick="addtocart(' + idtype + ',' + prod_id + ',' +prod_mes_id +');"><i class="fas fa-cart-plus"></i> Add to Cart</button></li></ul>');
                          }
                         remove_coupon();
                     }else
                      {
                          $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
                      }
                }
        });
}

function removecart(idtype,prod_id, prod_mes_id, rowid) {
     $.ajax({
         url: '<?php echo site_url("cart/removecart"); ?>',
         type: 'POST',
         data: {rowid: rowid},
         success: function(data) {
           if(data!='error')
           {
                    $(".del_cart_item_" + rowid).remove();
                    var obj =$.parseJSON(data);
                       if(obj['cart_count']==0){
                          $(".crt-total-set").remove();
                          $(".crt-checkout").remove();
                          $("#ajaxcart").html('<div class="ss-empty-cart"><div class="ss-empty-cart-img"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png"></div><div class="ss-empty-cart-cnt"><p>Your Cart is empty. Start Shopping now!</p></div></div>');
                          $('#cart_count').html(obj['cart_count']);
                          $("#order_summary").remove();
                          $("#empty_cart").html('<div class="cart_page_empty_cart_section"><div class="cart_page_empty_cart_image"><img src="<?php echo base_url(); ?>assets/frontend/images/cart_page_empty.png" /></div><h3>Your Cart is Currently Empty</h3><div class="cart_page_empty_continue_btn"><a href="<?php echo base_url(); ?>">Continue Shopping</a></div></div>');
                       }else{
                           $("#cart_count").html(obj['cart_count']);
                       }
                        // $("#cart_totl_amnt").html(obj['cart_tatl']);
                        remove_coupon();
                        $("#subtotal").html(obj['cart_tatl']);
                        $(".cart_totl_amnt").html(obj['cart_tatl']);
                        $("#remove_rowid_"+rowid).remove();
                        $(".1_addtocart_" + prod_id).html(
                        "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" + idtype + "," + prod_id + "," + prod_mes_id +")'>Add</button></div>");
                        $(".2_addtocart_" + prod_id).html(
                        "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(2," + prod_id + "," + prod_mes_id +")'>Add</button></div>");
                        $(".3_addtocart_" + prod_id).html(
                        "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(2," + prod_id + "," + prod_mes_id +")'>Add</button></div>");
                        $(".4_addtocart_" + prod_id).html(
                        "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(3," + prod_id + "," + prod_mes_id +")'>Add</button></div>");
                        $(".5_addtocart_" + prod_id).html(
                        "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +idtype + "," + prod_id + "," + prod_mes_id +")'>Add</button></div>");
                        $(".pdetails_addtocart_" + prod_id).html('<ul><li><button class="addcrt" onclick="addtocart(' + idtype + ',' + prod_id + ',' +prod_mes_id +');"><i class="fas fa-cart-plus"></i> Add to Cart</button></li></ul>');
                        // location.reload();
          }else{
                $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
             }
      },error: function (data) {
             $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
          }
    });
}

function gotocheckout(){
   window.location="<?php echo base_url();?>cart/";
}
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/nicescroll.js"></script>
<script>
   $(function() {  
     $(".nicescroll").niceScroll({cursorcolor:"rgb(115 1 174 / 25%)"});
   });
</script>