<div class="item">
   <div class="prodct-bx">
      <a href="<?php echo base_url(); ?>product/product_details/<?php echo $change_product['prod_id']; ?>">
         <div class="prodct-bx-pic">
            <div class="prd-bx-info">
               <div class="prodt-frnd vegan">
                  <i class="fas fa-circle"></i>
               </div>
            </div>
            <div class="prd-recomnd">
               <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
            </div>
            <div class="prdt-main-imag 1_img_id_<?php echo $change_product['mes_id']; ?>">
               <img class="change-image_<?php echo $change_product['prod_id']; ?>"
                  src="<?php echo base_url();?>assets/products/<?php echo $change_product['prod_id']; ?>" />
            </div>
            <div class="fav-prd">
               <?php
                  $prod_id=$products['prod_id'];
                   $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$prod_id AND `user_id`=1")->num_rows(); ?>
                  <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $products['prod_id']; ?>','pop_product');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_pop_product_<?php echo $products['prod_id'];?>"><i class="fas fa-heart"></i></a>
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
            <a
               href="<?php echo base_url(); ?>product/product_details/<?php echo $products['prod_id']; ?>">
               <h1 class="1_prod_title_<?php echo $prod_id; ?>"><?php echo $products['prod_title']; ?></h1>
            </a>
            <div class="prodct-bx-wtprc">
               <?php if(count($pop_result)>1){ ?>
               <div class="prodct-bx-wt">
                  <select class="selectpicker" name="prod_mes_id"
                     id="prod_mes_id_<?php echo $pop_result[0]['mes_id']; ?>"
                     onchange="change_prod_mesid(1,this,'<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo $products['prod_id']; ?>');">
                     <?php foreach ($pop_result as $prod_mesid) { ?>
                     <option value="<?php echo $prod_mesid['prod_mes_id']; ?>">
                        <?php echo $prod_mesid['title']; ?>
                     </option>
                     <?php } ?>
                  </select>
                  <input type="text" id="1_<?php echo $pop_result[0]['prod_mes_id']; ?>" value="<?php echo $pop_result[0]['title']; ?>"/>
               </div>
               <?php  } else{ ?>
               <input type="text" id="1_<?php echo $pop_result[0]['prod_mes_id']; ?>" value="<?php echo $pop_result[0]['title']; ?>"/>
               <?php echo $pop_result[0]['title']; ?>
               <?php } ?>
               <div class="prodct-bx-prc">
                  <ul>
                     <li class="actl-prc">RS. <span bclass="1_prod_org_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_org_price']; ?></span>
                     </li>
                     <li class="cmpny-prc" id="prod_offered_price">RS. <span
                        class="1_prod_offered_price_<?php echo $prod_id; ?>"><?php echo $pop_result[0]['prod_offered_price']; ?></span>
                     </li>
                  </ul>
               </div>
            </div>
            <div class="prodct-bx-delvry">
               <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
            </div>
            <div class="prodct-suboradd">
               <?php if($products['available_subscraibe']==1){ ?>
               <div class="prodct-sub">
                  <a href="<?php echo base_url(); ?>product/subscribe/<?php echo $products['prod_id'];?>">
                  <button type="button">
                     <i class="far fa-calendar-alt"></i>  Subscribe</button>
                  </a>
               </div>
               <?php } else{ }?>
               <?php  
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
               <div class="prodct-add-plsmin addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                  <div class="prodct-plsmin" id="input_div">
                     <button type="button" value="-" id="moins" onclick="minus(1,'<?php echo $pop_result[0]['prod_id']; ?>','<?php echo $pop_result[0]['prod_mes_id']; ?>')"><i class="fas fa-minus"></i> </button>
                     <input class="plsmin-vlue chck_qty_<?php echo $pop_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$pop_cart_qty[$pop_result[0]['prod_mes_id']];?>" readonly />
                     <button type="button" value="+" id="plus" onclick="plus('<?php echo $pop_result[0]['prod_mes_id']; ?>')"><i class="fas fa-plus"></i></button>
                  </div>
               </div>
               <?php }else { ?>
               <div class="prodct-add addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                  <button class="addcrtbn" onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
               </div>
               <?php } }else{ ?>
               <div class="prodct-add addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                  <button class="addcrtbn" onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
               </div>
               <?php } } else{?>Out of Stock
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>