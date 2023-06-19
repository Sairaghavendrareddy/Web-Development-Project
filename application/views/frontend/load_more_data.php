<?php $output = '';
   if(!empty($res))
   {
       $cart = $this->cart->contents();
        $cart_prod_mes_id=array();
        $pop_cart_qty=array();
        $pop_cart_rowid=array();
        if(!empty($cart)){
           foreach ($cart as $cart_data) {
              $cart_prod_mes_id[] =$cart_data['name'];
              $pop_cart_qty[$cart_data['name']] =$cart_data['qty'];
              $pop_cart_rowid[$cart_data['name']] =$cart_data['rowid'];
           }
        }
       
          foreach ($res as $products){ 
           $pop_prod_mesurements_json =$products['prod_mesurements'];
           $pop_result = json_decode($pop_prod_mesurements_json, true);
           $pop_prod_image =$pop_result[0]['prod_image'];
           $pop_decode_prod_image = json_decode($pop_prod_image, true);
           $pop_product_img =$pop_decode_prod_image[0];
       ?>
<div class="col-12 col-sm-12 col-md-6 col-xl-6 col-lg-6 marginsettb-15">
   <div class="prodct-bx">
      <div class="prodct-bx-pic">
         <a href="<?php echo base_url(); ?>product/product_details/<?php echo $products['prod_slug']; ?>" target="_blank">
            <div class="prd-bx-info">
               <div class="prodt-frnd vegan">
                  <i class="fas fa-circle"></i>
               </div>
            </div>
            <div class="prd-recomnd">
               <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
            </div>
            <div class="prdt-main-imag 1_img_id_<?php echo $pop_result[0]['prod_id']; ?>">
               <img class="1_change-image_<?php echo $pop_result[0]['prod_id']; ?>"
                  src="<?php echo base_url();?>assets/products/<?php echo $pop_product_img; ?>" />
            </div>
            <div class="fav-prd">
               <?php
                  $p_prod_id=$products['prod_id'];
                   if($this->session->userdata('user_id')!=''){ 
                     $user_id =$this->session->userdata('user_id');
                     $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$p_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                    <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $products['prod_id']; ?>','pop_product');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_pop_product_<?php echo $products['prod_id'];?>"><i class="fas fa-heart"></i></a>
                 <?php }else{ ?>
                  <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $products['prod_id']; ?>','pop_product');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_pop_product_<?php echo $products['prod_id'];?>"><i class="fas fa-heart"></i></a>
            <?php } ?>  
            <?php
                $combo_products =$products['combo_products'];
                if(!empty($combo_products)){ ?>
                    <button class="comboinfo" type="button" onclick="view_combos('<?php echo $pop_result[0]['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
                <?php } else{ } ?>
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
            <a href="<?php echo base_url(); ?>product/product_details/<?php echo $products['prod_slug']; ?>">
               <h1 class="1_prod_title_<?php echo $p_prod_id; ?>"><?php echo $products['prod_title']; ?> 
              </h1>
            </a>
            <div class="prodct-bx-wtprc">
               <?php if(count($pop_result)>1){ ?>
               <div class="prodct-bx-wt">
                  <select class="selectpicker selectpicker_<?php echo $p_prod_id; ?>" name="prod_mes_id"
                     onchange="change_prod_mesid(1,this,'<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo $products['prod_id']; ?>');">
                     <?php foreach ($pop_result as $prod_mesid) { ?>
                     <option value="<?php echo $prod_mesid['prod_mes_id']; ?>">
                        <?php echo $prod_mesid['title']; ?>
                     </option>
                     <?php } ?>
                  </select>
                  <input type="hidden" id="1_<?php echo $pop_result[0]['prod_id']; ?>" value="<?php echo $pop_result[0]['title']; ?>"/>
               </div>
               <?php  } else{ ?>
               <div class="prodct-bx-wt">
                  <input type="hidden" id="1_<?php echo $pop_result[0]['prod_id']; ?>" value="<?php echo $pop_result[0]['title']; ?>"/>
                  <p><span><?php echo $pop_result[0]['title']; ?></span></p>
               </div>
               <?php } ?>
               <div class="prodct-bx-prc">
                  <ul>
                     <li class="actl-prc">RS. <span
                        class="1_prod_org_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_org_price']; ?></span>
                     </li>
                     <li class="cmpny-prc">RS. <span
                        class="1_prod_offered_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_offered_price']; ?></span>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="prodct-bx-delvry">
               <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
            </div>
            <div class="prodct-suboradd">
               <?php if($products['available_subscraibe']==1){ 
                  if($this->session->userdata('user_id')!=''){
                    $user_id =$this->session->userdata('user_id');
                    $po_prodid =$pop_result[0]['prod_id'];
                    $po_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$po_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                    $po_chk_count =$po_chk_subscribe['prod_id'];
                    if(($po_chk_count)>0){ 
                  ?>
               <div class="prodct-sub">
                  <button>
                      <i class="far fa-calendar-alt"></i> Subscribed
                  </button>
               </div>
               <?php }else{ ?>
               <div class="prodct-sub">
                  <a href="<?php echo base_url(); ?>product/subscribe/<?php echo $pop_result[0]['prod_id'];?>">
                    <button type="button">
                      <i class="far fa-calendar-alt"></i> Subscribe
                    </button>
                  </a>
               </div>
               <?php } }else{ ?>
               <div class="prodct-sub">
                  <a href="#login-modal" data-toggle="modal" data-target="#login-modal">
                  <button type="button">
                    <i class="far fa-calendar-alt"></i> Subscribe
                 </button>
                </a>
               </div>
               <?php } } else{ }
               
                  if($pop_result[0]['prod_available_qty']!=0){
                  $catrData =$this->cart->contents();
                         $product_id =$pop_result[0]['prod_mes_id'];
                          if(!empty($catrData)){
                            $cart_options = array_column($catrData,'options');
                              if(!is_array($cart_options))
                                 {
                                    $cart_options = array();
                                 }
                              $cart_product_ids = array_column($cart_options,'prod_mes_id');
                              $cart_options_qty = array_column($catrData,'qty');
                           if(!is_array($cart_product_ids))
                           {
                               $cart_product_ids =array();
                               $cart_options_qty =array();
                           }
                        if(in_array($product_id,$cart_product_ids)){ 
                     ?>
               <div class="prodct-add-plsmin 5_addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                  <div class="prodct-plsmin" id="input_div">
                     <button type="button" value="-" onclick="minus(1,'<?php echo $pop_result[0]['prod_id']; ?>','<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo@$pop_cart_rowid[$pop_result[0]['prod_mes_id']];?>')"><i
                        class="fas fa-minus"></i> </button>
                     <input class="plsmin-vlue chck_qty_<?php echo $pop_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$pop_cart_qty[$pop_result[0]['prod_mes_id']];?>" readonly />
                     <button type="button" value="+" onclick="plus(1,'<?php echo $pop_result[0]['prod_id']; ?>','<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo@$pop_cart_rowid[$pop_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                  </div>
               </div>
               <?php }else { ?>
               <div class="prodct-add addtocart 5_addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                  <button class="addcrtbn" type="button" onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
               </div>
               <?php } }else{ ?>
               <div class="prodct-add addtocart 5_addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                  <button class="addcrtbn" type="button" onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
               </div>
               <?php } } else{?><div class="otf_stk">
               
               Out of Stock
               </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php } ?>
</a>
<?php } echo $output; ?>

<script>
$(document).ready(function(){
  $( '.selectpicker' ).selectpicker( 'refresh' );
});
    
function minus(idtype,prod_id, prod_mes_id,rowid)
{
// var prod_mes_title = $('#'+idtype+'_'+prod_id).val();
var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
$.ajax({
      url: '<?php echo site_url('home/minus_prod_qty'); ?>',
      type: 'POST',
      data: {prod_mes_id: prod_mes_id,qty: qty,rowid: rowid},
      success: function(data){
        if(data!=='')
        {
          $('.chck_qty_' + prod_mes_id).val(qty - 1);
          if (qty == 1)
          {
            var obj =$.parseJSON(data);
          // alert(obj['cart_count']);
            $("#cart_count").html(obj['cart_count']);
            $(".5_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +idtype + "," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
          }
        }else {
          alert('fail');
        }
      }
  });
}
    
</script>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/bootstrap-select.min.js"></script> -->