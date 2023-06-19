<style>
   .hide_qty {
   display: none;
   }
   .add_to_cart {
   display: none;
   }
   .wishlist_active {
   color: red;
   }
</style>
<section class="ss-breadcrumb">
   <div class="container">
      <div class="ss-breadcrumb-cnt">
         <ul>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="nxt-arw"><i class="fas fa-caret-right"></i></li>
            <li class="active"><?php echo $p_details['prod_title']; ?></li>
         </ul>
      </div>
   </div>
</section>
<section class="ss-product-view">
   <div class="container">
      <div class="row">
         <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
            <div class="ss-product-view-slide">
               <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                     <li data-target="#carouselExampleIndicators3" data-slide-to="0" class="active"></li>
                  </ol>
                  <div class="carousel-inner">
                     <div class="fav-prd baskinnner-fav">
                        <?php
                           $d_prod_id=$p_details['prod_id']; 
                           if($this->session->userdata('user_id')!=''){ 
                               $user_id =$this->session->userdata('user_id');
                               $d_wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$d_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                                 <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $p_details['prod_id']; ?>','product_details');" class="wsh-shw-cn whishstate wish_icon <?php if (($d_wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_product_details_<?php echo $p_details['prod_id'];?>"><i class="fas fa-heart"></i></a>
                        <?php } else{ ?>
                           <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $p_details['prod_id']; ?>','product_details');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_product_details_<?php echo $p_details['prod_id'];?>"><i class="fas fa-heart"></i></a>
                        <?php } 
                           $pdetails_combo_products =$p_details['combo_products'];
                         if(!empty($pdetails_combo_products)){ ?>
                             <button class="comboinfo" type="button" onclick="view_combos('<?php echo $p_decode[0]['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
                         <?php } else{ } ?>
                     </div>
                     <div class="carousel-item active">
                        <div class="product-view-main">
                           <?php 
                              $img =$p_decode[0]['prod_image'];
                              $prod_image = json_decode($img, true);
                              ?>
                           <div class="1_img_id_<?php echo $p_decode[0]['prod_id']; ?>">
                              <img class="1_change-image_<?php echo $p_decode[0]['prod_id']; ?>" src="<?php echo base_url(); ?>assets/products/<?php echo $prod_image[0]; ?>" />
                           </div>
                        </div>
                     </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button"
                     data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button"
                     data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                  </a>
               </div>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
            <div class="product-info-view">
               <div class="product-info-top">
                  <h1 class="1_prod_title_<?php echo $p_decode[0]['prod_id']; ?>">
                     <?php echo $p_details['prod_title']; ?>
                  </h1>
                  <div class="product-view-prc">
                     <ul>
                        <li>
                           <div class="viw-act-prc">MRP: Rs <span class="1_prod_org_price_<?php echo $p_decode[0]['prod_id']; ?>"><?php echo $p_decode[0]['prod_org_price']; ?></span>
                           </div>
                           <div class="viw-dis-prc">Our Price: Rs <span class="1_prod_offered_price_<?php echo $p_decode[0]['prod_id']; ?>">
                              <?php echo $p_decode[0]['prod_offered_price']; ?></span>
                           </div>
                        </li>
                        <li class="viw-dis-app">You Save: 10%</li>
                        <li class="viw-tax-info">(Inclusive of all taxes)</li>
                     </ul>
                  </div>
                  <div class="product-addcrt">
                     <div class="product-addcrt-lb">
                        <h5>Pack Sizes <span class="float-right">:</span></h5>
                     </div>
                     <?php if(count($p_decode) > 1){ ?>
                     <div class="prodct-packs-set">
                        <ul>
                           <?php 
                              $count = 1;
                              foreach ($p_decode as $mes) { ?>
                           <li>
                              <label class="radio">
                              <?php if($count==1){ ?>
                              <input type="radio" name="prod_mes_id" onclick="change_prod_measuremts(1,'<?php echo $mes['prod_id']; ?>','<?php echo $mes['prod_mes_id']; ?>');" checked>
                              <span><?php echo $mes['title']; ?></span>
                              <input type="hidden" id="1_<?php echo $mes['prod_id']; ?>" value="<?php echo $mes['title']; ?>" />
                              </label>
                              <?php }else{ ?>
                              <input type="radio" name="prod_mes_id" onclick="change_prod_measuremts(1,'<?php echo $mes['prod_id']; ?>','<?php echo $mes['prod_mes_id']; ?>');" />
                              <span><?php echo $mes['title']; ?></span>
                              <input type="hidden" id="1_<?php echo $mes['prod_id']; ?>" value="<?php echo $mes['title']; ?>" />
                              <?php } ?>
                              <?php $count++; } ?>
                           </li>
                        </ul>
                     </div>
                     <?php }else{ ?>
                     <div class="prodct-packs-set">
                        <ul>
                           <li>
                              <label class="radio">
                              <input type="radio" name="mes_title" checked />
                              <span><?php echo $p_decode[0]['title']; ?></span>
                              <input type="hidden" id="1_<?php echo $p_decode[0]['prod_id']; ?>" value="<?php echo $p_decode[0]['title']; ?>" />
                              </label>
                           </li>
                        </ul>
                     </div>
                     <?php } ?>
                  </div>
                  <?php 
                     if($p_decode[0]['prod_available_qty']!=0){
                        $prod_mes_id = $p_decode[0]['prod_mes_id'];
                        $cart = $this->cart->contents();
                           $cart_prod_mes_id=array();
                           $cart_qty=array();
                           $cart_rowid=array();
                           if(!empty($cart)){
                              foreach ($cart as $cart_data) {
                                  $cart_prod_mes_id[] =$cart_data['name'];
                                  $cart_qty[$cart_data['name']] =$cart_data['qty'];
                                  $cart_rowid[$cart_data['name']] =$cart_data['rowid'];
                              }
                           }
                           $chk_prod_exits = in_array($prod_mes_id,$cart_prod_mes_id);
                           $prod_mes_id_qty = @$cart_qty[$prod_mes_id]; 
                                
                                 $product_id =$prod_mes_id;
                                 if(!empty($cart)){
                                 $cart_options = array_column($cart,'options');
                                 if(!is_array($cart_options))
                                 {
                                  $cart_options = array();
                                 }
                                 $cart_product_ids = array_column($cart_options,'prod_mes_id');
                                 $cart_options_qty = array_column($cart,'qty');
                                 if(!is_array($cart_product_ids))
                                 {
                                  $cart_product_ids =array();
                                  $cart_options_qty =array();
                                 }
                                 if(in_array($product_id,$cart_product_ids)){ 
                                
                                 ?>
                           
                  <div class="prodct-add-plsmin addcrt-bnts pdetails_addtocart_<?php echo $p_decode[0]['prod_id']; ?>">
                  <div class="prodct-add-plsmin">
                     <div class="prodct-plsmin" id="input_div">
                        <button type="button" onclick="minus(1,'<?php echo $p_decode[0]['prod_id']; ?>','<?php echo $prod_mes_id; ?>','<?php echo@$cart_rowid[$prod_mes_id];?>')"><i class="fas fa-minus"></i> </button>
                        <input class="plsmin-vlue chck_qty_<?php echo $prod_mes_id; ?>" type="text" size="25"
                           value="<?php echo@$cart_qty[$prod_mes_id];?>" readonly />
                        <button type="button" onclick="plus(1,'<?php echo $p_decode[0]['prod_id']; ?>','<?php echo $prod_mes_id; ?>','<?php echo@$cart_rowid[$prod_mes_id];?>')"><i class="fas fa-plus"></i></button>
                     </div>
                  </div>
                  </div>
                  <?php if($p_details['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                              $user_id =$this->session->userdata('user_id');
                              $p_prodid =$p_decode[0]['prod_id'];
                              $p_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$p_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                              $p_chk_count =$p_chk_subscribe['prod_id'];
                              if(($p_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub innr-sub">
                           <button>
                              <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <div class="prodct-sub innr-sub">
                        <a class="subscribe-inn-btn" href="<?php echo base_url(); ?>product/subscribe/<?php echo $p_details['prod_id'];?>" type="button"><i class="far fa-calendar-alt"></i> Subscribe</a>
                        </div>
                        <?php } } else{ ?>
                        <div class="prodct-sub innr-sub">
                           <button type="button" class="subscribe-inn-btn" href="#login-modal" data-toggle="modal" data-target="#login-modal"><i class="far fa-calendar-alt"></i> Subscribe</button>
                        </div>
                        <?php } } else{ } ?>
                  <?php }else { ?>
                  <div class="addcrt-bnts addcrt-bnts pdetails_addtocart_<?php echo $p_decode[0]['prod_id']; ?>">
                     <ul>
                        <li><button class="addcrt" onclick="addtocart(1,'<?php echo $p_decode[0]['prod_id']; ?>','<?php echo $p_decode[0]['prod_mes_id']; ?>');"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        </li>
                        <?php if($p_details['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                           $user_id =$this->session->userdata('user_id');
                           $p_prodid =$p_decode[0]['prod_id'];
                           $p_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$p_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                           $p_chk_count =$p_chk_subscribe['prod_id'];
                           if(($p_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub innr-sub">
                           <button>
                              <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <li>
                        <a class="subscribe-inn-btn" href="<?php echo base_url(); ?>product/subscribe/<?php echo $p_details['prod_id'];?>" type="button"><i class="far fa-calendar-alt"></i>  Subscribe
                        </li></a>
                        <?php } }else{ ?>
                        <li>
                        <button type="button" class="subscribe-inn-btn" href="#login-modal" data-toggle="modal" data-target="#login-modal">
                           <i class="far fa-calendar-alt"></i>  Subscribe</button>
                        </li>
                        <?php } }else{ } ?>
                     </ul>
                  </div></div>
                  <?php } }else{ ?>
                  <div class="addcrt-bnts addtocart pdetails_addtocart_<?php echo $p_decode[0]['prod_id']; ?>">
                     <ul>
                        <li><button class="addcrt" onclick="addtocart(1,'<?php echo $p_decode[0]['prod_id']; ?>','<?php echo $p_decode[0]['prod_mes_id']; ?>');"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        </li>
                        
                     </ul>
                  </div>
                  <?php if($p_details['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                              $user_id =$this->session->userdata('user_id');
                              $p_prodid =$p_decode[0]['prod_id'];
                              $p_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$p_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                              $p_chk_count =$p_chk_subscribe['prod_id'];
                              if(($p_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub innr-sub">
                           <button>
                              <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                           <div class="prodct-sub innr-sub">
                        <a class="subscribe-inn-btn" href="<?php echo base_url(); ?>product/subscribe/<?php echo $p_details['prod_id'];?>" type="button"><i class="far fa-calendar-alt"></i> Subscribe</a>
                        </div>
                        <?php } } else{ ?>
                           <div class="prodct-sub innr-sub">
                        <button type="button" class="subscribe-inn-btn" href="#login-modal" data-toggle="modal" data-target="#login-modal"><i class="far fa-calendar-alt"></i> Subscribe</button>
                           </div>
                        <?php } } else{ } ?>
                  <?php } } else{?><div class="prd_otfstk">
               
               Out of Stock
               </div>
                  <?php } ?>
               </div>
               <div class="product-view-shpmsg">
                  <h4><i class="fas fa-truck"></i> Standard: Today 7:30PM - 10:30PM</h4>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</section>
<section class="prd-view-full">
   <div class="container">
      <div class="prd-view-full-cnt">
         <div class="prd-view-des">
            <h4>Description</h4>
            <div class="prd-view-des-inner">
               <p><?php echo $p_details['prod_description']; ?></p>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Similar Products</h1>
      <div class="owl-ss owl-carousel owl-theme">
         <?php
            $sim_cart = $this->cart->contents();
            $sim_cart_prod_mes_id=array();
            $sim_cart_qty=array();
            $sim_cart_rowid=array();
            if(!empty($sim_cart)){
               foreach ($sim_cart as $sm_cart_data) {
                  $sim_cart_prod_mes_id[] =$sm_cart_data['name'];
                  $sim_cart_qty[$sm_cart_data['name']] =$sm_cart_data['qty'];
                  $sim_cart_rowid[$sm_cart_data['name']] =$sm_cart_data['rowid'];
               }
            }
            
              foreach ($similar_products as $similarproducts){ 
               $similarproducts_json =$similarproducts['prod_mesurements'];
               $sim_result = json_decode($similarproducts_json, true);
               $sim_prod_image =$sim_result[0]['prod_image'];
               $sim_decode_prod_image = json_decode($sim_prod_image, true);
               $sim_product_img =$sim_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
               <a href="<?php echo base_url(); ?>product/product_details/<?php echo $similarproducts['prod_slug']; ?>">
                  <div class="prodct-bx-pic">
                     <div class="prd-bx-info">
                        <div class="prodt-frnd vegan">
                           <i class="fas fa-circle"></i>
                        </div>
                     </div>
                     <div class="prd-recomnd">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                     </div>
                     <div class="prdt-main-imag 2_img_id_<?php echo $sim_result[0]['prod_id']; ?>" />
                        <img class="2_change-image_<?php echo $sim_result[0]['prod_id']; ?>"
                           src="<?php echo base_url();?>assets/products/<?php echo $sim_product_img; ?>" />
                     </div>
                     <div class="fav-prd">
                        <?php
                           $s_prod_id=$similarproducts['prod_id'];
                           if($this->session->userdata('user_id')!=''){ 
                            $user_id =$this->session->userdata('user_id');
                            $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$s_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                           <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $similarproducts['prod_id']; ?>','sim_product');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_sim_product_<?php echo $similarproducts['prod_id'];?>"><i class="fas fa-heart"></i></a>
                  <?php }else{ ?>
                     <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $similarproducts['prod_id']; ?>','sim_product');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_sim_product_<?php echo $similarproducts['prod_id'];?>"><i class="fas fa-heart"></i></a>
               <?php } 
                     $sim_combo_products =$similarproducts['combo_products'];
                        if(!empty($sim_combo_products)){ ?>
                             <button class="comboinfo" type="button" onclick="view_combos('<?php echo $sim_result[0]['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
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
                     <a href="<?php echo base_url(); ?>product/product_details/<?php echo $similarproducts['prod_slug']; ?>">
                        <h1 class="2_prod_title_<?php echo $s_prod_id; ?>"><?php echo $similarproducts['prod_title']; ?></h1>
                     </a>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($sim_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker selectpicker_<?php echo $s_prod_id; ?>" name="prod_mes_id" onchange="change_prod_mesid(2,this,'<?php echo $sim_result[0]['prod_mes_id']; ?>','<?php echo $similarproducts['prod_id']; ?>');">
                              <?php foreach ($sim_result as $sim_prod_mesid) { ?>
                              <option value="<?php echo $sim_prod_mesid['prod_mes_id']; ?>">
                                 <?php echo $sim_prod_mesid['title']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="2_<?php echo $sim_result[0]['prod_id']; ?>" value="<?php echo $sim_result[0]['title']; ?>"/>
                        </div>
                        <?php  } else{ ?>
                        <div class="prodct-bx-wt">
                           <input type="hidden" id="2_<?php echo $sim_result[0]['prod_id']; ?>" value="<?php echo $sim_result[0]['title']; ?>"/>
                           <p><span><?php echo $sim_result[0]['title']; ?></span></p>
                        </div>
                        <?php } ?>
                        <div class="prodct-bx-prc">
                           <ul>
                              <li class="actl-prc">RS. <span class="2_prod_org_price_<?php echo $sim_result[0]['prod_id']; ?>"><?php echo $sim_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc">RS. <span class="2_prod_offered_price_<?php echo $sim_result[0]['prod_id']; ?>"><?php echo $sim_result[0]['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="prodct-bx-delvry">
                        <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     </div>
                     <div class="prodct-suboradd">
                        <?php if($similarproducts['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                                $user_id =$this->session->userdata('user_id');
                                 $s_prodid =$sim_result[0]['prod_id'];
                                 $s_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$s_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
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
                           <button type="button" href="<?php echo base_url(); ?>product/subscribe/<?php echo $similarproducts['prod_id'];?>">
                              <i class="far fa-calendar-alt"></i> Subscribe</button>
                           </button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-sub">
                        <button type="button" href="#login-modal" data-toggle="modal" data-target="#login-modal">
                             
                                 <i class="far fa-calendar-alt"></i> Subscribe
                              </button>
                           
                        </div>
                        <?php } } else{ }?>
                        <?php  
                           if($sim_result[0]['prod_available_qty']!=0){
                           $catrData =$this->cart->contents();
                                  $product_id =$sim_result[0]['prod_mes_id'];
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
                        <div class="prodct-add-plsmin 3_addtocart_<?php echo $sim_result[0]['prod_id']; ?>">
                           <div class="prodct-plsmin" id="input_div">
                              <button type="button" value="-" onclick="minus(2,'<?php echo $sim_result[0]['prod_id']; ?>','<?php echo $sim_result[0]['prod_mes_id']; ?>','<?php echo@$sim_cart_rowid[$sim_result[0]['prod_mes_id']];?>')"><i class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $sim_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$sim_cart_qty[$sim_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+" onclick="plus(2,'<?php echo $sim_result[0]['prod_id']; ?>','<?php echo $sim_result[0]['prod_mes_id']; ?>','<?php echo@$sim_cart_rowid[$sim_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        <?php }else { ?>
                        <div class="prodct-add 3_addtocart_<?php echo $sim_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(2,"<?php echo $sim_result[0]['prod_id']; ?>","<?php echo $sim_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add 3_addtocart_<?php echo $sim_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(2,"<?php echo $sim_result[0]['prod_id']; ?>","<?php echo $sim_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } } else{?>Out of Stock
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
<section class="ss-bstsellers">
   <div class="container">
      <h1 class="ss-subhead">Recent Products</h1>
      <div class="owl-ss owl-carousel owl-theme">
         <?php
            $rece_cart = $this->cart->contents();
            $rec_cart_prod_mes_id=array();
            $rec_cart_qty=array();
            $rec_cart_rowid=array();
            if(!empty($rece_cart)){
               foreach ($rece_cart as $r_cart_data) {
                  $rec_cart_prod_mes_id[] =$r_cart_data['name'];
                  $rec_cart_qty[$r_cart_data['name']] =$r_cart_data['qty'];
                  $rec_cart_rowid[$r_cart_data['name']] =$r_cart_data['rowid'];
               }
            }
            
              foreach ($recent_products as $recentproducts){ 
               $recentproducts_json =$recentproducts['prod_mesurements'];
               $recent_result = json_decode($recentproducts_json, true);
               $recent_prod_image =$recent_result[0]['prod_image'];
               $rece_decode_prod_image = json_decode($recent_prod_image, true);
               $rec_product_img =$rece_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
               <a href="<?php echo base_url(); ?>product/product_details/<?php echo $recentproducts['prod_slug']; ?>">
                  <div class="prodct-bx-pic">
                     <div class="prd-bx-info">
                        <div class="prodt-frnd vegan">
                           <i class="fas fa-circle"></i>
                        </div>
                     </div>
                     <div class="prd-recomnd">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                     </div>
                     <div class="prdt-main-imag 3_img_id_<?php echo $recent_result[0]['prod_id']; ?>" />
                        <img class="3_change-image_<?php echo $recent_result[0]['prod_id']; ?>"
                           src="<?php echo base_url();?>assets/products/<?php echo $rec_product_img; ?>" />
                     </div>
                     <div class="fav-prd">
                        <?php
                           $p_prod_id=$recentproducts['prod_id'];
                           if($this->session->userdata('user_id')!=''){ 
                            $user_id =$this->session->userdata('user_id');
                            $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$p_prod_id AND `user_id`=$user_id")->num_rows(); ?>
                           <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $recentproducts['prod_id']; ?>','rec_product');" class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>" data-id="wish_rec_product_<?php echo $recentproducts['prod_id'];?>"><i class="fas fa-heart"></i></a>
                     <?php }else{ ?>
                        <a href='javascript:void(0)' onclick="addtowishlist('<?php echo $recentproducts['prod_id']; ?>','rec_product');" class="wsh-shw-cn whishstate wish_icon" data-id="wish_rec_product_<?php echo $recentproducts['prod_id'];?>"><i class="fas fa-heart"></i></a>
               <?php } 
                     $rec_combo_products =$recentproducts['combo_products'];
                        if(!empty($rec_combo_products)){ ?>
                             <button class="comboinfo" type="button" onclick="view_combos('<?php echo $recentproducts['prod_id']; ?>');"><i class="fas fa-info-circle"></i></button>
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
                     <a href="<?php echo base_url(); ?>product/product_details/<?php echo $recentproducts['prod_slug']; ?>">
                        <h1 class="3_prod_title_<?php echo $p_prod_id; ?>"><?php echo $recentproducts['prod_title']; ?></h1>
                     </a>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($recent_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker selectpicker_<?php echo $p_prod_id; ?>" name="prod_mes_id" onchange="change_prod_mesid(3,this,'<?php echo $recent_result[0]['prod_mes_id']; ?>','<?php echo $recentproducts['prod_id']; ?>');">
                              <?php foreach ($recent_result as $rec_prod_mesid) { ?>
                              <option value="<?php echo $rec_prod_mesid['prod_mes_id']; ?>">
                                 <?php echo $rec_prod_mesid['title']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="3_<?php echo $recent_result[0]['prod_id']; ?>" value="<?php echo $recent_result[0]['title']; ?>"/>
                        </div>
                        <?php  } else{ ?>
                        <div class="prodct-bx-wt">
                           <input type="hidden" id="3_<?php echo $recent_result[0]['prod_id']; ?>" value="<?php echo $recent_result[0]['title']; ?>"/>
                           <p><span><?php echo $recent_result[0]['title']; ?></span></p>
                        </div>
                        <?php } ?>
                        <div class="prodct-bx-prc">
                           <ul>
                              <li class="actl-prc">RS. <span class="3_prod_org_price_<?php echo $recent_result[0]['prod_id']; ?>"><?php echo $recent_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc">RS. <span class="3_prod_offered_price_<?php echo $recent_result[0]['prod_id']; ?>"><?php echo $recent_result[0]['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="prodct-bx-delvry">
                        <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     </div>
                     <div class="prodct-suboradd">
                        <?php if($recentproducts['available_subscraibe']==1){ 
                           if($this->session->userdata('user_id')!=''){
                                $user_id =$this->session->userdata('user_id');
                                 $r_prodid =$recent_result[0]['prod_id'];
                                 $r_chk_subscribe =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `is_active`, `created_date`, `next_payment` FROM `prod_subscriptions` WHERE `prod_id`=$r_prodid AND `user_id`=$user_id AND `is_active`!=3")->row_array();
                                 $r_chk_count =$r_chk_subscribe['prod_id'];
                                 if(($r_chk_count)>0){ 
                           ?>
                        <div class="prodct-sub">
                           <button>
                              <i class="far fa-calendar-alt"></i> Subscribed
                           </button>
                        </div>
                        <?php }else{ ?>
                        <div class="prodct-sub">
                        <button type="button" href="<?php echo base_url(); ?>product/subscribe/<?php echo $recentproducts['prod_id'];?>">
                           
                              <i class="far fa-calendar-alt"></i> Subscribe
                              </button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-sub">
                        <button type="button" href="#login-modal" data-toggle="modal" data-target="#login-modal">
                             
                                 <i class="far fa-calendar-alt"></i> Subscribe
                              </button>
                           
                        </div>
                        <?php } }else{ }?>
                        <?php  
                           if($recent_result[0]['prod_available_qty']!=0){
                           $catrData =$this->cart->contents();
                                  $product_id =$recent_result[0]['prod_mes_id'];
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
                        <div class="prodct-add-plsmin 4_addtocart_<?php echo $recent_result[0]['prod_id']; ?>">
                        <div class="prodct-add-plsmin">
                           <div class="prodct-plsmin" id="input_div">
                              <button type="button" value="-" onclick="minus(3,'<?php echo $recent_result[0]['prod_id']; ?>','<?php echo $recent_result[0]['prod_mes_id']; ?>','<?php echo@$rec_cart_rowid[$recent_result[0]['prod_mes_id']];?>')"><i class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $recent_result[0]['prod_mes_id']; ?>" type="text" size="25" value="<?php echo@$pop_cart_qty[$recent_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+" onclick="plus('<?php echo $recent_result[0]['prod_mes_id']; ?>','<?php echo@$rec_cart_rowid[$recent_result[0]['prod_mes_id']];?>')"><i class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        </div>
                        <?php }else { ?>
                        <div class="prodct-add 4_addtocart_<?php echo $recent_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(3,"<?php echo $recent_result[0]['prod_id']; ?>","<?php echo $recent_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add 4_addtocart_<?php echo $recent_result[0]['prod_id']; ?>">
                           <button class="addcrtbn" onclick='addtocart(3,"<?php echo $recent_result[0]['prod_id']; ?>","<?php echo $recent_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } } else{?>Out of Stock
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
<script>
   function change_prod_measuremts(idtype,prod_id,prod_mes_id) {
       $.ajax({
           url: '<?php echo site_url('home/get_measurement_id_by_products'); ?>',
           type: 'POST',
           data: {prod_id: prod_id,prod_mes_id: prod_mes_id},
           dataType: 'json',
           success: function(response) {
                  var rowid = response.rowid;
                  var img = response.img;
                  var prod_org_price = response.prod_org_price;
                  var prod_offered_price = response.prod_offered_price;
                  var prod_id1 = response.prod_id;
                  var prod_mes_id1 = response.prod_mes_id;
                  var prod_mes_title1 = response.prod_mes_title;
                  // alert(prod_mes_title1);
                  var chk_prod_exits = response.chk_prod_exits;
                  var prod_mes_id_qty = response.prod_mes_id_qty;
                   $('#'+idtype+'_'+prod_id1).val(prod_mes_title1);
                  var cart_count = response.cart_count;
                  $('.'+idtype+'_'+'img_id_' + prod_id).html("<img class="+idtype+"_"+"change-image_" + prod_id + " src=" + img +
                      " alt='product img' style='width:100%' >");
                  $('.'+idtype+'_'+'prod_org_price_' + prod_id).text(prod_org_price);
                  $('.'+idtype+'_'+'prod_offered_price_' + prod_id).text(prod_offered_price);
                  if(chk_prod_exits!= '')
                  {
                     $("#cart_count").html(cart_count);
                     $(".pdetails_addtocart_" + prod_id1).html(
                     '<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +prod_id + ',' + prod_mes_id +
                     ',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value=' + prod_mes_id_qty +' readonly /><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                  }else{
                      // $("#addcrt-bnts_"+prod_id).remove();
                      $("#cart_count").html(cart_count);
                      // $('#suresh').html('<div class="addcrt-bnts addtocart pdetails_addtocart_<?php echo $p_decode[0]['prod_id']; ?>"><ul><li><button class="addcrt" onclick="addtocart('+idtype+','+prod_id + ',' + prod_mes_id +',\''+rowid+'\');"><i class="fas fa-cart-plus"></i> Add to Cart</button></li></ul></div>');

                      $(".pdetails_addtocart_" + prod_id).html('<ul><li><button class="addcrt" onclick="addtocart('+idtype+','+prod_id + ',' + prod_mes_id +');"><i class="fas fa-cart-plus"></i> Add to Cart</button></li></ul>');
                  }
      
              }
          });
      }
      
   function minus(idtype,prod_id, prod_mes_id)
   {
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       $.ajax({
              url: '<?php echo site_url('home/minus_prod_qty'); ?>',
              type: 'POST',
              data: {prod_mes_id: prod_mes_id,qty: qty},
              success: function(data) 
              {
                  if(data!=0)
                  {
                      $('.chck_qty_' + prod_mes_id).val(qty - 1);
                      if(qty == 1)
                      {
                           var obj =$.parseJSON(data);
                           $("#cart_count").html(obj['cart_count']);
                           $(".pdetails_addtocart_"+prod_mes_id).html('<ul><li><button class="addcrt" onclick="addtocart(' + idtype + ',' + prod_id + ',' +prod_mes_id +');"><i class="fas fa-cart-plus"></i> Add to Cart</button></li></ul>');
                           $(".3_addtocart_" + prod_id).html(
                           "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(2," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                           $(".4_addtocart_" + prod_id).html(
                           "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(3," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                          $("#addcrt-bnts_"+prod_mes_id).html("<div class='prodct-add' id=addtocart_<?php echo $p_decode[0]['prod_mes_id']; ?>'><button class='button' onclick='addtocart("+prod_mes_id+")'>Add</button></div>");
                      }
                  }else{
                       $.toast({heading:'Error',text:'Opps! Something went to wrong Please try again...',position:'top-right',stack: false,icon:'error'});
                  }
            }
      });
   }
      
</script>