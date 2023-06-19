<style>
   .wishlist_active {
   color: red;
   }
</style>
<section class="ss-banner">
   <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active">
            <div class="ss-banner-cnt ssbanner1">
               <img class="banner-img" src="<?php echo base_url(); ?>assets/frontend/images/banner.png" />
               <div class="container">
                  <div class="row">
                     <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="ssbanner-left">
                           <h4>Shop Groceries Online</h4>
                           <h1>Farm Fresh Vegetables</h1>
                           <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                              Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                              unknown printer took a galley of type and scrambled 
                           </p>
                           <div class="ssbanner-btns">
                              <ul>
                                 <li><a class="knwmore" href="#">Know More</a></li>
                                 <li><a class="buymore" href="#">Buy Now</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
         </a>
      </div>
   </div>
</section>
<!-- <section class="ss-bnrbtm-boxes">
   <div class="container">
      <div class="row">
         <?php if(!empty($popular_banners)){ foreach ($popular_banners as $popularbanners) { ?>
         <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <div class="ss-bnrbtm-box box-clr-orng">
               <img style="width:100%" src="<?php echo base_url(); ?>assets/banners/<?php echo $popularbanners['image']; ?>">
               <h5>Get Every Vegetables<br>you need </h5>
               <a href="<?php echo base_url(); ?>product/offers/<?php echo $popularbanners['id']; ?>">Shop Now <i class="fas fa-caret-right"></i></a>
            </div>
         </div>
          <?php } } ?>
        
      </div>
   </div>
</section> -->
<section class="ss-semi-banners">
   <div class="container">
   <div class="owl-ss-semibaner owl-carousel owl-theme">
   <?php if(!empty($popular_banners)){ foreach ($popular_banners as $popularbanners) { ?>
      <div class="item">
         <a href="<?php echo base_url(); ?>product/offers/<?php echo $popularbanners['id']; ?>">
            <div class="ss-semi-ban-cnt">
                <img src="<?php echo base_url(); ?>assets/banners/<?php echo $popularbanners['image']; ?>"> 
               <!--<img class="banner-img" src="<?php echo base_url(); ?>assets/frontend/images/banner.png" />-->
            </div>
         </a>
      </div>
      <?php } } ?>
   </div>   
   </div>
</section>
<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Popular Products</h1>
      <div class="owl-ss owl-carousel owl-theme">
         <?php
            $cart = $this->cart->contents();
            $cart_prod_mes_id=array();
            $pop_cart_qty=array();
            $pop_car_rowid=array();
            if(!empty($cart)){
               foreach ($cart as $cart_data) {
                  $cart_prod_mes_id[] =$cart_data['name'];
                  $pop_cart_qty[$cart_data['name']] =$cart_data['qty'];
                  $pop_car_rowid[$cart_data['name']] =$cart_data['rowid'];
               }
            }
           
              foreach ($pop_list as $products){ 
               $pop_prod_mesurements_json =$products['prod_mesurements'];
               $pop_result = json_decode($pop_prod_mesurements_json, true);
               $pop_prod_image =$pop_result[0]['prod_image'];
               $pop_decode_prod_image = json_decode($pop_prod_image, true);
               $pop_product_img =$pop_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
               <a href="<?php echo base_url(); ?>product/product_details/<?php echo $products['prod_slug']; ?>">
                  <div class="prodct-bx-pic">
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
                  <?php } 
                      $combo_products =$products['combo_products'];
                      if(!empty($combo_products)){ ?>
                          <button class="comboinfo" type="button" onclick="view_combos('<?php echo $pop_result[0]['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
                      <?php } else{ } ?>
               </div>
               <div class="prodt-offer">
                  <h4>
                        <img src="<?php echo base_url(); ?>assets/frontend/images/discount.svg" /> GET 60% OFF
                  </h4>
               </div>
               </a>
               </div>
               <div class="prodct-bx-cnt">
                  <div class="prodct-bx-det">
                     <a href="<?php echo base_url(); ?>product/product_details/<?php echo $products['prod_slug']; ?>">
                        <h1 class="1_prod_title_<?php echo $p_prod_id; ?>"><?php echo $products['prod_title']; ?></h1>
                     </a>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($pop_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker selectpicker_<?php echo $p_prod_id; ?>" name="prod_mes_id" onchange="change_prod_mesid(1,this,'<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo $products['prod_id']; ?>');">
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
                              <li class="actl-prc">RS. <span class="1_prod_org_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc">RS. <span class="1_prod_offered_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_offered_price']; ?></span>
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
                              $prodid =$products['prod_id'];
                              $chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                              $chk_count =$chk_subscribe['prod_id'];
                              if(($chk_count)>0){ ?>
                        <div class="prodct-sub">
                           <button>
                           <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <div class="prodct-sub">
                           <a href="<?php echo base_url(); ?>product/subscribe/<?php echo $products['prod_id'];?>">
                              <button>
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
                        <?php } ?>
                        <?php } else{ }
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
                        <div class="prodct-add-plsmin 1_addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                           <div class="prodct-plsmin" id="input_div">
                              <button type="button" value="-" onclick="minus(1,'<?php echo $pop_result[0]['prod_id']; ?>','<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo@$pop_car_rowid[$pop_result[0]['prod_mes_id']];?>')"><i class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $pop_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$pop_cart_qty[$pop_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+" onclick="plus(1,'<?php echo $pop_result[0]['prod_id']; ?>','<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo@$pop_car_rowid[$pop_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        <?php }else { ?>
                        <div class="prodct-add 1_addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add 1_addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
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
         <?php  } ?>
      </div>
   </div>
</section>
<div class="w-100 float-left">
   <div class="brdr-btwn-set"></div>
</div>
<section class="ss-semi-banners">
   <div class="container">
   <div class="owl-ss-semibaner owl-carousel owl-theme">
   <?php if(!empty($best_seller_banners)){ foreach ($best_seller_banners as $bestbanners) { ?>
      <div class="item">
         <a href="<?php echo base_url(); ?>product/offers/<?php echo $bestbanners['id']; ?>">
            <div class="ss-semi-ban-cnt">
               <img src="<?php echo base_url(); ?>assets/banners/<?php echo $bestbanners['image']; ?>">
            </div>
         </a>
      </div>
      <?php } } ?>
   </div>   
   </div>
</section>
<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Best Seller</h1>
      <div class="owl-ss owl-carousel owl-theme">
         <?php 
            $b_cart = $this->cart->contents();
              $b_cart_prod_mes_id=array();
              $best_cart_qty=array();
              $best_cart_rowid=array();
              if(!empty($b_cart)){
                 foreach ($b_cart as $b_cart_data) {
                    $b_cart_prod_mes_id[] =$b_cart_data['name'];
                    $best_cart_qty[$b_cart_data['name']] =$b_cart_data['qty'];
                    $best_cart_rowid[$b_cart_data['name']] =$b_cart_data['rowid'];
                 }
              }
            if(!empty($bestprod_list)){
              foreach ($bestprod_list as $best_list) { 
               $best_prod_mesurements_json =$best_list['prod_mesurements'];
               $best_result = json_decode($best_prod_mesurements_json, true);
               $best_prod_image =$best_result[0]['prod_image'];
               $best_decode_prod_image = json_decode($best_prod_image, true);
               $best_product_img =$best_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
               <div class="prodct-bx-pic">
                  <a href="<?php echo base_url(); ?>product/product_details/<?php echo $best_list['prod_slug']; ?>">
                     <div class="prd-bx-info">
                        <div class="prodt-frnd vegan">
                           <i class="fas fa-circle"></i>
                        </div>
                     </div>
                     <div class="prd-recomnd">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                     </div>
                     <div class="prdt-main-imag 2_img_id_<?php echo $best_result[0]['prod_id']; ?>">
                        <img class="2_change-image_<?php echo $best_list['prod_id']; ?>"
                           src="<?php echo base_url();?>assets/products/<?php echo $best_product_img; ?>" />
                     </div>
                     <div class="fav-prd">
                        <?php
                           $b_prod_id=$best_list['prod_id'];
                             if($this->session->userdata('user_id')!=''){ 
                                 $user_id =$this->session->userdata('user_id');
                                 $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$b_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                              <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $best_list['prod_id']; ?>','pop_product');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_pop_product_<?php echo $best_list['prod_id'];?>"><i class="fas fa-heart"></i></a>
                        <?php } else{ ?>
                           <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $best_list['prod_id']; ?>','pop_product');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_pop_product_<?php echo $best_list['prod_id'];?>"><i class="fas fa-heart"></i></a>
                  <?php } 
                     $best_combo_products =$best_list['combo_products'];
                      if(!empty($best_combo_products)){ ?>
                          <button class="comboinfo" type="button" onclick="view_combos('<?php echo $best_list[0]['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
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
                     <h1 class="prod_title_<?php echo $b_prod_id; ?>"><?php echo $best_list['prod_title']; ?></h1>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($best_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker selectpicker_<?php echo $b_prod_id; ?>" name="prod_mes_id" onchange="change_prod_mesid(2,this,'<?php echo $best_result[0]['prod_mes_id']; ?>','<?php echo $best_list['prod_id']; ?>');">
                              <?php foreach ($best_result as $best_prod_mesid) { ?>
                              <option value="<?php echo $best_prod_mesid['prod_mes_id']; ?>">
                                 <?php echo $best_prod_mesid['title']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="2_<?php echo $best_result[0]['prod_id']; ?>" value="<?php echo $best_result[0]['title']; ?>"/>
                        </div>
                        <?php } else{ ?>
                        <div class="prodct-bx-wt">
                           <input type="hidden" id="2_<?php echo $best_result[0]['prod_id']; ?>" value="<?php echo $best_result[0]['title']; ?>"/>
                           <p><span><?php echo $best_result[0]['title']; ?></span></p>
                        </div>
                        <?php } ?>
                        <div class="prodct-bx-prc">
                           <ul>
                              <li class="actl-prc">RS. <span class="2_prod_org_price_<?php echo $best_result[0]['prod_id']; ?>"><?php echo $best_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc">RS. <span class="2_prod_offered_price_<?php echo $best_result[0]['prod_id']; ?>"><?php echo $best_result[0]['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="prodct-bx-delvry">
                        <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     </div>
                     <div class="prodct-suboradd">
                        <?php if($best_list['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                              $user_id =$this->session->userdata('user_id');
                              $b_prodid =$best_result[0]['prod_id'];
                              $b_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$b_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                              $b_chk_count =$b_chk_subscribe['prod_id'];
                              if(($b_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub">
                           <button>
                           <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <div class="prodct-sub">
                           <a href="<?php echo base_url(); ?>product/subscribe/<?php echo $best_list['prod_id'];?>">
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
                        <?php } } else{ } ?>
                        <?php
                           if($best_result[0]['prod_available_qty']!=0){
                              $b_catrData =$this->cart->contents();
                              $b_product_id =$best_result[0]['prod_mes_id'];
                           if(!empty($b_catrData)){
                              $b_cart_options = array_column($b_catrData,'options');
                              if(!is_array($b_cart_options))
                                 {
                                    $b_cart_options = array();
                                 }
                              $b_cart_product_ids = array_column($b_cart_options,'prod_mes_id');
                              $b_cart_qty_options = array_column($b_catrData,'qty');
                              if(!is_array($b_cart_product_ids))
                              {
                                  $b_cart_product_ids =array();
                                  $b_cart_qty_options =array();
                              }
                           if(in_array($b_product_id,$b_cart_product_ids)){
                           ?>
                        <div class="prodct-add-plsmin 2_addtocart_<?php echo $best_result[0]['prod_id']; ?>">
                           <div class="prodct-plsmin" id="input_div">
                              <button type="button" value="-" onclick="minus(2,'<?php echo $best_result[0]['prod_id']; ?>','<?php echo $best_result[0]['prod_mes_id']; ?>','<?php echo@$best_cart_rowid[$best_result[0]['prod_mes_id']];?>')"><i class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $best_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$best_cart_qty[$best_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+" onclick="plus(2,'<?php echo $best_result[0]['prod_id']; ?>','<?php echo $best_result[0]['prod_mes_id']; ?>','<?php echo@$best_cart_rowid[$best_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        <?php } else { ?>
                        <div class="prodct-add 2_addtocart_<?php echo $best_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(2,"<?php echo $best_result[0]['prod_id']; ?>","<?php echo $best_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add 2_addtocart_<?php echo $best_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(2,"<?php echo $best_result[0]['prod_id']; ?>","<?php echo $best_result[0]['prod_mes_id']; ?>")'>Add</button>
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
         <?php } } ?>
      </div>
   </div>
</section>
<div class="w-100 float-left">
   <div class="brdr-btwn-set"></div>
</div>
<section class="ss-semi-banners">
   <div class="container">
   <div class="owl-ss-semibaner owl-carousel owl-theme">
   <?php if(!empty($deal_banners)){ foreach ($deal_banners as $dealbanners) { ?>
      <div class="item">
      <a href="<?php echo base_url(); ?>product/offers/<?php echo $dealbanners['id']; ?>">
            <div class="ss-semi-ban-cnt">
            <img src="<?php echo base_url(); ?>assets/banners/<?php echo $dealbanners['image']; ?>">
            </div>
         </a>
      </div>
      <?php } } ?>
   </div>   
   </div>
</section>

<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Deals of The Day</h1>
      <div class="owl-ss owl-carousel owl-theme">
         <?php 
            $b_cart = $this->cart->contents();
              $d_cart_prod_mes_id=array();
              $deal_cart_qty=array();
              $deal_cart_rowid=array();
              if(!empty($b_cart)){
                 foreach ($b_cart as $d_cart_data) {
                    $d_cart_prod_mes_id[] =$d_cart_data['name'];
                    $deals_cart_qty[$d_cart_data['name']] =$d_cart_data['qty'];
                    $deal_cart_rowid[$d_cart_data['name']] =$d_cart_data['rowid'];
                 }
              }
            if(!empty($deals_of_the_day)){
              foreach ($deals_of_the_day as $deals_of_theday) { 
               $deals_prod_mesurements_json =$deals_of_theday['prod_mesurements'];
               $deals_result = json_decode($deals_prod_mesurements_json, true);
               $deals_prod_image =$deals_result[0]['prod_image'];
               $deals_decode_prod_image = json_decode($deals_prod_image, true);
               $deals_product_img =$deals_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
               <div class="prodct-bx-pic">
                  <a href="<?php echo base_url(); ?>product/product_details/<?php echo $deals_of_theday['prod_slug']; ?>">
                     <div class="prd-bx-info">
                        <div class="prodt-frnd vegan">
                           <i class="fas fa-circle"></i>
                        </div>
                     </div>
                     <div class="prd-recomnd">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                     </div>
                     <div class="prdt-main-imag 3_img_id_<?php echo $deals_result[0]['prod_id']; ?>">
                        <img class="3_change-image_<?php echo $deals_of_theday['prod_id']; ?>"
                           src="<?php echo base_url();?>assets/products/<?php echo $deals_product_img; ?>" />
                     </div>
                     <div class="fav-prd">
                        <?php
                           $d_prod_id=$deals_of_theday['prod_id'];
                             if($this->session->userdata('user_id')!=''){ 
                                 $user_id =$this->session->userdata('user_id');
                                 $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$d_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                              <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $deals_of_theday['prod_id']; ?>','deal');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_pop_product_<?php echo $deals_of_theday['prod_id'];?>"><i class="fas fa-heart"></i></a>
                        <?php } else{ ?>
                           <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $deals_of_theday['prod_id']; ?>','deal');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_pop_product_<?php echo $deals_of_theday['prod_id'];?>"><i class="fas fa-heart"></i></a>
                  <?php } 
                     $deals_combo_products =$deals_of_theday['combo_products'];
                      if(!empty($deals_combo_products)){ ?>
                          <button class="comboinfo" type="button" onclick="view_combos('<?php echo $deals_of_theday['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
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
                     <h1 class="prod_title_<?php echo $d_prod_id; ?>"><?php echo $deals_of_theday['prod_title']; ?></h1>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($deals_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker selectpicker_<?php echo $d_prod_id; ?>" name="prod_mes_id" onchange="change_prod_mesid(3,this,'<?php echo $best_result[0]['prod_mes_id']; ?>','<?php echo $deals_of_theday['prod_id']; ?>');">
                              <?php foreach ($deals_result as $deal_prod_mesid) { ?>
                              <option value="<?php echo $deal_prod_mesid['prod_mes_id']; ?>">
                                 <?php echo $deal_prod_mesid['title']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="3_<?php echo $deals_result[0]['prod_id']; ?>" value="<?php echo $deals_result[0]['title']; ?>"/>
                        </div>
                        <?php } else{ ?>
                        <div class="prodct-bx-wt">
                           <input type="hidden" id="3_<?php echo $deals_result[0]['prod_id']; ?>" value="<?php echo $deals_result[0]['title']; ?>"/>
                           <p><span><?php echo $deals_result[0]['title']; ?></span></p>
                        </div>
                        <?php } ?>
                        <div class="prodct-bx-prc">
                           <ul>
                              <li class="actl-prc">RS. <span class="3_prod_org_price_<?php echo $deals_result[0]['prod_id']; ?>"><?php echo $deals_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc">RS. <span class="3_prod_offered_price_<?php echo $deals_result[0]['prod_id']; ?>"><?php echo $deals_result[0]['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="prodct-bx-delvry">
                        <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     </div>
                     <div class="prodct-suboradd">
                        <?php if($deals_of_theday['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                              $user_id =$this->session->userdata('user_id');
                              $d_prodid =$deals_result[0]['prod_id'];
                              $d_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$d_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                              $d_chk_count =$d_chk_subscribe['prod_id'];
                              if(($d_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub">
                           <button>
                           <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <div class="prodct-sub">
                           <a href="<?php echo base_url(); ?>product/subscribe/<?php echo $deals_of_theday['prod_id'];?>">
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
                        <?php } } else{ } ?>
                        <?php
                           if($deals_result[0]['prod_available_qty']!=0){
                              $d_catrData =$this->cart->contents();
                              $d_product_id =$deals_result[0]['prod_mes_id'];
                           if(!empty($d_catrData)){
                            $d_cart_options = array_column($d_catrData,'options');
                              if(!is_array($d_cart_options))
                                 {
                                    $d_cart_options = array();
                                 }
                              $d_cart_product_ids = array_column($d_cart_options,'prod_mes_id');
                              $d_cart_qty_options = array_column($d_catrData,'qty');
                              if(!is_array($d_cart_product_ids))
                              {
                                  $d_cart_product_ids =array();
                                  $d_cart_qty_options =array();
                              }
                           if(in_array($d_product_id,$d_cart_product_ids)){
                           ?>
                        <div class="prodct-add-plsmin 4_addtocart_<?php echo $deals_result[0]['prod_id']; ?>">
                           <div class="prodct-plsmin" id="input_div">
                              <button type="button" value="-" onclick="minus(3,'<?php echo $deals_result[0]['prod_id']; ?>','<?php echo $deals_result[0]['prod_mes_id']; ?>','<?php echo@$deal_cart_rowid[$deals_result[0]['prod_mes_id']];?>')"><i class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $deals_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$deals_cart_qty[$deals_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+"  onclick="plus(3,'<?php echo $deals_result[0]['prod_id']; ?>','<?php echo $deals_result[0]['prod_mes_id']; ?>','<?php echo@$deal_cart_rowid[$deals_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        <?php } else { ?>
                        <div class="prodct-add 4_addtocart_<?php echo $deals_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(3,"<?php echo $deals_result[0]['prod_id']; ?>","<?php echo $deals_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add 4_addtocart_<?php echo $deals_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(3,"<?php echo $deals_result[0]['prod_id']; ?>","<?php echo $deals_result[0]['prod_mes_id']; ?>")'>Add</button>
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
         <?php } } ?>
      </div>
   </div>
</section>
<div class="w-100 float-left">
   <div class="brdr-btwn-set"></div>
</div>
<div class="w-100 float-left">
   <div class="brdr-btwn-set"></div>
</div>
<section class="ss-semi-banners">
   <div class="container">
   <div class="owl-ss-semibaner owl-carousel owl-theme">
   <?php if(!empty($subscription_banners)){ foreach ($subscription_banners as $subscriptionbanners) { ?>
      <div class="item">
      <a href="<?php echo base_url(); ?>product/offers/<?php echo $subscriptionbanners['id']; ?>">
            <div class="ss-semi-ban-cnt">
            <img src="<?php echo base_url(); ?>assets/banners/<?php echo $subscriptionbanners['image']; ?>">
            </div>
         </a>
      </div>
      <?php } } ?>
   </div>   
   </div>
</section>

<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Subscriptions</h1>
      <div class="owl-ss owl-carousel owl-theme">
         <?php 
            $s_cart = $this->cart->contents();
              $s_cart_prod_mes_id=array();
              $s_cart_qty=array();
              $s_cart_rowid=array();
              if(!empty($s_cart)){
                 foreach ($b_cart as $s_cart_data) {
                    $s_cart_prod_mes_id[] =$s_cart_data['name'];
                    $s_cart_qty[$s_cart_data['name']] =$s_cart_data['qty'];
                    $s_cart_rowid[$s_cart_data['name']] =$s_cart_data['rowid'];
                 }
              }
            if(!empty($subscriptions)){
              foreach ($subscriptions as $subscriptions) { 
               $sub_prod_mesurements_json =$subscriptions['prod_mesurements'];
               $sub_result = json_decode($sub_prod_mesurements_json, true);
               $sub_prod_image =$sub_result[0]['prod_image'];
               $sub_decode_prod_image = json_decode($sub_prod_image, true);
               $sub_product_img =$sub_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
               <div class="prodct-bx-pic">
                  <a href="<?php echo base_url(); ?>product/product_details/<?php echo $subscriptions['prod_slug']; ?>">
                     <div class="prd-bx-info">
                        <div class="prodt-frnd vegan">
                           <i class="fas fa-circle"></i>
                        </div>
                     </div>
                     <div class="prd-recomnd">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                     </div>
                     <div class="prdt-main-imag 4_img_id_<?php echo $sub_result[0]['prod_id']; ?>">
                        <img class="4_change-image_<?php echo $subscriptions['prod_id']; ?>"
                           src="<?php echo base_url();?>assets/products/<?php echo $sub_product_img; ?>" />
                     </div>
                     <div class="fav-prd">
                        <?php
                           $s_prod_id=$subscriptions['prod_id'];
                             if($this->session->userdata('user_id')!=''){ 
                                 $user_id =$this->session->userdata('user_id');
                                 $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$s_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                              <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $subscriptions['prod_id']; ?>','sub');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_pop_product_<?php echo $subscriptions['prod_id'];?>"><i class="fas fa-heart"></i></a>
                        <?php } else{ ?>
                           <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $subscriptions['prod_id']; ?>','sub');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_pop_product_<?php echo $subscriptions['prod_id'];?>"><i class="fas fa-heart"></i></a>
                  <?php } 
                     $s_combo_products =$subscriptions['combo_products'];
                      if(!empty($s_combo_products)){ ?>
                          <button class="comboinfo" type="button" onclick="view_combos('<?php echo $subscriptions['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
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
                     <h1 class="prod_title_<?php echo $s_prod_id; ?>"><?php echo $subscriptions['prod_title']; ?></h1>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($sub_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker selectpicker_<?php echo $s_prod_id; ?>" name="prod_mes_id" onchange="change_prod_mesid(4,this,'<?php echo $best_result[0]['prod_mes_id']; ?>','<?php echo $subscriptions['prod_id']; ?>');">
                              <?php foreach ($sub_result as $sub_prod_mesid) { ?>
                              <option value="<?php echo $sub_prod_mesid['prod_mes_id']; ?>">
                                 <?php echo $sub_prod_mesid['title']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="4_<?php echo $sub_result[0]['prod_id']; ?>" value="<?php echo $sub_result[0]['title']; ?>"/>
                        </div>
                        <?php } else{ ?>
                        <div class="prodct-bx-wt">
                           <input type="hidden" id="4_<?php echo $sub_result[0]['prod_id']; ?>" value="<?php echo $sub_result[0]['title']; ?>"/>
                           <p><span><?php echo $sub_result[0]['title']; ?></span></p>
                        </div>
                        <?php } ?>
                        <div class="prodct-bx-prc">
                           <ul>
                              <li class="actl-prc">RS. <span class="4_prod_org_price_<?php echo $sub_result[0]['prod_id']; ?>"><?php echo $sub_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc">RS. <span class="4_prod_offered_price_<?php echo $sub_result[0]['prod_id']; ?>"><?php echo $sub_result[0]['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="prodct-bx-delvry">
                        <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     </div>
                     <div class="prodct-suboradd">
                        <?php if($subscriptions['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                              $user_id =$this->session->userdata('user_id');
                              $b_prodid =$sub_result[0]['prod_id'];
                              $s_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$b_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                              $s_chk_count =$s_chk_subscribe['prod_id'];
                              if(($s_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub">
                           <button>
                           <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <div class="prodct-sub">
                           <a href="<?php echo base_url(); ?>product/subscribe/<?php echo $subscriptions['prod_id'];?>">
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
                        <?php } } else{ } ?>
                        <?php
                           if($sub_result[0]['prod_available_qty']!=0){
                              $sub_catrData =$this->cart->contents();
                              $sub_product_id =$sub_result[0]['prod_mes_id'];
                             
                           if(!empty($sub_catrData)){
                            $sub_cart_options = array_column($sub_catrData,'options');
                              if(!is_array($sub_cart_options))
                                 {
                                    $sub_cart_options = array();
                                 }
                              $sub_cart_product_ids = array_column($sub_cart_options,'prod_mes_id');
                              $sub_cart_qty_options = array_column($b_catrData,'qty');
                              if(!is_array($sub_cart_product_ids))
                              {
                                  $sub_cart_product_ids =array();
                                  $sub_cart_qty_options =array();
                              }
                           if(in_array($sub_product_id,$sub_cart_product_ids)){
                           ?>
                        <div class="prodct-add-plsmin 4_addtocart_<?php echo $sub_result[0]['prod_id']; ?>">
                           <div class="prodct-plsmin" id="input_div">
                              <button type="button" value="-" onclick="minus(4,'<?php echo $sub_result[0]['prod_id']; ?>','<?php echo $sub_result[0]['prod_mes_id']; ?>','<?php echo@$s_cart_rowid[$sub_result[0]['prod_mes_id']];?>')"><i class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $sub_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$s_cart_qty[$sub_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+" onclick="plus(4,'<?php echo $sub_result[0]['prod_id']; ?>','<?php echo $sub_result[0]['prod_mes_id']; ?>','<?php echo@$s_cart_rowid[$sub_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        <?php } else { ?>
                        <div class="prodct-add 4_addtocart_<?php echo $sub_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(4,"<?php echo $sub_result[0]['prod_id']; ?>","<?php echo $sub_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add 4_addtocart_<?php echo $sub_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(4,"<?php echo $sub_result[0]['prod_id']; ?>","<?php echo $sub_result[0]['prod_mes_id']; ?>")'>Add</button>
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
         <?php } } ?>
      </div>
   </div>
</section>
<section class="ss-mid-patch">
   <div id="carouselExampleControls1" class="carousel carousel-fade slide" data-ride="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active">
            <div class="ss-mid-patch-cnt">
               <div class="container">
                  <div class="row">
                     <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-6">
                        <div class="ss-mid-patch-left">
                           <h4>Starting from <span style="color: #2b2b2b;">Rs.</span> <span
                              style="color: #1dc15c">99/-</span></h4>
                           <h1>Farm Fresh Vegetables</h1>
                           <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                              Ipsum has been the industry's standard dummy
                           </p>
                        </div>
                     </div>
                     <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-6">
                        <div class="ss-mid-patch-right">
                           <img src="<?php echo base_url(); ?>assets/frontend/images/patch-img.png" />
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
         </a>
      </div>
   </div>
</section>
<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Your Daily Staples</h1>
      <div class="ss-dailystpl">
         <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
               <div class="ss-bnrbtm-box box-clr-orng">
                  <img style="width:100%" src="<?php echo base_url(); ?>assets/frontend/images/veggies.png">
                  <h5>Get Every Vegetables<br>you need </h5>
                  <a href="#">Shop Now <i class="fas fa-caret-right"></i></a>
               </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
               <div class="ss-bnrbtm-box box-clr-grn">
                  <img src="<?php echo base_url(); ?>assets/frontend/images/veggies-floating.png" />
                  <h5>Get Every Vegetables<br>you need </h5>
                  <a href="#">Shop Now <i class="fas fa-caret-right"></i></a>
               </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
               <div class="ss-bnrbtm-box box-clr-red">
                  <img src="<?php echo base_url(); ?>assets/frontend/images/veggies-close.png" />
                  <h5>Get Every Vegetables<br>you need </h5>
                  <a href="#">Shop Now <i class="fas fa-caret-right"></i></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="ss-downapp">
   <div class="container">
      <div class="row">
         <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="ss-downapp-left">
               <h4>Download Our App</h4>
               <h1>Farm Fresh Vegetables</h1>
               <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                  the industry's standard dummy 
               </p>
               <div class="ss-downapp-btns">
                  <ul>
                     <li><a href="#"><img
                        src="<?php echo base_url(); ?>assets/frontend/images/google-play-badge.png" /></a>
                     </li>
                     <li><a href="#"><img
                        src="<?php echo base_url(); ?>assets/frontend/images/app-store-badge.png" /></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <img class="dwn-app-mk" src="<?php echo base_url(); ?>assets/frontend/images/down-app.png" />
   </div>
</section>
<script>
   function minus(idtype,prod_id, prod_mes_id,rowid)
   {
      // var prod_mes_title = $('#'+idtype+'_'+prod_id).val();
      var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
      $.ajax({
              url: '<?php echo site_url('home/minus_prod_qty'); ?>',
              type: 'POST',
              data: {prod_mes_id: prod_mes_id,qty: qty,rowid: rowid},
              success: function(data)
              {
                  if (data!= '') 
                  {
                     $('.chck_qty_' + prod_mes_id).val(qty - 1);
                        if(qty == 1)
                        {
                           var obj =$.parseJSON(data);
                                 // alert(obj['cart_count']);
                           $("#cart_count").html(obj['cart_count']);
                           $(".1_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +idtype + "," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                           $(".2_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(2," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                           $(".3_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(3," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                           $(".4_addtocart_" + prod_id).html("<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(4," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                        }
                  }else{
                          $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
                     }
           }  
      });
  }
   
</script>