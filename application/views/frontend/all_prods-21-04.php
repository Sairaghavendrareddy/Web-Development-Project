<style>
    .wishlist_active {
        color: red;
    }
</style>
<section class="ss-bstsellers">
   <div class="container">
     
      <div class="owl-ss owl-carousel owl-theme">
         <?php
            $cart = $this->cart->contents();
            $cart_prod_mes_id=array();
            $pop_cart_qty=array();
            if(!empty($cart)){
               foreach ($cart as $cart_data) {
                  $cart_prod_mes_id[] =$cart_data['name'];
                  $pop_cart_qty[$cart_data['name']] =$cart_data['qty'];
               }
            }
           
              foreach ($menu_list as $menulist){ 
               $pop_prod_mesurements_json =$menulist['prod_mesurements'];
               $pop_result = json_decode($pop_prod_mesurements_json, true);
               $pop_prod_image =$pop_result[0]['prod_image'];
               $pop_decode_prod_image = json_decode($pop_prod_image, true);
               $pop_product_img =$pop_decode_prod_image[0];
               ?>
         <div class="item">
            <div class="prodct-bx">
                  <a href="<?php echo base_url(); ?>product/product_details/<?php echo $menulist['prod_slug']; ?>" >
               <div class="prodct-bx-pic">
                     <div class="prd-bx-info">
                        <div class="prodt-frnd vegan">
                           <i class="fas fa-circle"></i>
                        </div>
                     </div>
                     <div class="prd-recomnd">
                        <img src="<?php echo base_url(); ?>assets/frontend/images/recomended-tag.png" />
                     </div>
                     <div class="prdt-main-imag img_id_<?php echo $pop_result[0]['prod_mes_id']; ?>" />
                        <img class="change-image_<?php echo $pop_result[0]['prod_id']; ?>"
                           src="<?php echo base_url();?>assets/products/<?php echo $pop_product_img; ?>" />
                     </div>
                     <div class="fav-prd">
                        <?php $p_prod_id=$menulist['prod_id']; $wlist = $this->db->query("SELECT `favourate_id`, `product_id`, `user_id`FROM `favourate_products` WHERE `product_id`=$p_prod_id AND `user_id`=1")->num_rows(); ?>
                  <a href='javascript:void(0)'
                     onclick="addtowishlist('<?php echo $menulist['prod_id']; ?>','pop_product');"
                     class="wsh-shw-cn whishstate wish_icon <?php if (($wlist) > 0) {?>wishlist_active<?php } ?>"
                     data-id="wish_pop_product_<?php echo $menulist['prod_id'];?>"><i
                     class="fas fa-heart"></i></a>
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
                        href="<?php echo base_url(); ?>product/product_details/<?php echo $menulist['prod_slug']; ?>">
                        <h1 class="prod_title_<?php echo $p_prod_id; ?>"><?php echo $menulist['prod_title']; ?></h1>
                     </a>
                     <div class="prodct-bx-wtprc">
                        <?php if(count($pop_result)>1){ ?>
                        <div class="prodct-bx-wt">
                           <select class="selectpicker_<?php echo $p_prod_id; ?>" name="prod_mes_id"
                              onchange="change_prod_mesid(1,this,'<?php echo $pop_result[0]['prod_mes_id']; ?>','<?php echo $menulist['prod_id']; ?>');">
                              <?php foreach ($pop_result as $prod_mesid) { ?>
                              <option value="<?php echo $prod_mesid['prod_mes_id']; ?>">
                                 <?php echo $prod_mesid['title']; ?>
                              </option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="1_<?php echo $pop_result[0]['prod_id']; ?>" value="<?php echo $pop_result[0]['title']; ?>"/>
                        </div>
                        <?php  } else{ ?>
                        <input type="hidden" id="1_<?php echo $pop_result[0]['prod_id']; ?>" value="<?php echo $pop_result[0]['title']; ?>"/>
                        <?php echo $pop_result[0]['title']; ?>
                        <?php } ?>
                        <div class="prodct-bx-prc">
                           <ul>
                              <li class="actl-prc">RS. <span
                                 class="prod_org_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_org_price']; ?></span>
                              </li>
                              <li class="cmpny-prc" id="prod_offered_price">RS. <span
                                 class="prod_offered_price_<?php echo $pop_result[0]['prod_id']; ?>"><?php echo $pop_result[0]['prod_offered_price']; ?></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="prodct-bx-delvry">
                        <h4>Standard Delivery: <span>Today 7:30PM - 10:30PM</span></h4>
                     </div>
                     <div class="prodct-suboradd">
                        <?php if($menulist['available_subscraibe']==1){ ?>
                        <div class="prodct-sub">
                           <a
                              href="<?php echo base_url(); ?>product/subscribe/<?php echo $menulist['prod_id'];?>">
                           <button class="button"><i class="far fa-calendar-alt"></i> Subscribe</button>
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
                              <button type="button" value="-" id="moins"
                                 onclick="minus(1,'<?php echo $pop_result[0]['prod_id']; ?>','<?php echo $pop_result[0]['prod_mes_id']; ?>')"><i
                                 class="fas fa-minus"></i> </button>
                              <input class="plsmin-vlue chck_qty_<?php echo $pop_result[0]['prod_mes_id']; ?>" type="text"
                                 size="25" value="<?php echo@$pop_cart_qty[$pop_result[0]['prod_mes_id']];?>" readonly />
                              <button type="button" value="+" id="plus"
                                 onclick="plus('<?php echo $pop_result[0]['prod_mes_id']; ?>')"><i
                                 class="fas fa-plus"></i></button>
                           </div>
                        </div>
                        <?php }else { ?>
                        <div class="prodct-add addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                           <button class="addcrtbn"
                              onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
                        </div>
                        <?php } }else{ ?>
                        <div class="prodct-add addtocart_<?php echo $pop_result[0]['prod_id']; ?>">
                           <button class="addcrtbn"
                              onclick='addtocart(1,"<?php echo $pop_result[0]['prod_id']; ?>","<?php echo $pop_result[0]['prod_mes_id']; ?>")'>Add</button>
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
   function change_prod_mesid(idtype,sel, id, pid) {
       var prod_mes_id = sel.value;
       $.ajax({
           url: '<?php echo site_url('home/get_measurement_id_by_products'); ?>',
           type: 'POST',
           dataType: 'json',
           data: {id:id,prod_mes_id: prod_mes_id},
           success: function(response) {
               var img = response.img;
               var prod_org_price = response.prod_org_price;
               var prod_offered_price = response.prod_offered_price;
               var prod_id1 = response.prod_id;
               var prod_mes_id1 = response.prod_mes_id;
               var prod_mes_title1 = response.prod_mes_title;
               // alert(prod_mes_title1);
               var prod_mes_title = response.prod_mes_title;
               var chk_prod_exits = response.chk_prod_exits;
               var prod_mes_id_qty = response.prod_mes_id_qty;
               $('#'+idtype+'_'+pid).val(prod_mes_title1);

              $(".selectpicker_"+prod_id1).selectpicker('refresh');
              // $(".selectpicker_"+prod_id1).val(prod_mes_title1);
              $('.selectpicker_'+prod_id1).val(prod_mes_title1);
               // alert($("#"+idtype+"_"+pid).val(prod_mes_title1));
               $('.img_id_' + prod_id1).html("<img class=change-image_" + pid + " src=" + img +
                   " alt='product img' style='width:100%' >");
               $('.prod_org_price_' + prod_id1).text(prod_org_price);
               $('.prod_offered_price_' + prod_id1).text(prod_offered_price);
               if (chk_prod_exits != '') {
                   $(".addtocart_" + prod_id1).html(
                       '<div class="prodct-add-plsmin"><div class="prodct-plsmin " id="input_div"><button type="button" value="-" id="moins" onclick="minus(1,' +
                       prod_id1 + ',' + prod_mes_id1 +
                       ')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' +
                       prod_mes_id + '" type="text" size="25" value=' + prod_mes_id_qty +
                       ' readonly /><button type="button" value="+" id="plus" onclick="plus(' +
                       prod_mes_id + ')"><i class="fas fa-plus"></i></button></div></div>');
               } else {
                    // $(".addtocart_" + prod_id1).html(
                    //        "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +prod_id1 + "," + prod_mes_id + "," +prod_mes_title + ")'>ChAddd</button></div>");
                    $(".addtocart_" + prod_id1).html('<div class="prodct-add"><button class="addcrtbn" onclick="addtocart('+idtype+','+prod_id1+','+prod_mes_id+')">Add</button></div>');
               }
   
           }
       });
   }
   
   function addtocart(idtype,prod_id,prod_mes_id) {
       var prod_title = $(".prod_title_" + prod_id).text();
       var prod_mes_title = $('#'+idtype+'_'+prod_id).val();
       var prod_available_qty = $("#prod_available_qty_" + prod_id).val();
       var prod_org_price = $(".prod_org_price_" + prod_id).html();
       var prod_offered_price = $(".prod_offered_price_" + prod_id).html();
       var prod_img = $(".change-image_" + prod_id).attr('src');
       var qty = $("#qty").val();
       var url = '<?php echo base_url();?>';
       $.ajax({
           url: '<?php echo site_url('home/addtocart'); ?>',
           type: 'POST',
           data: {
               prod_id: prod_id,
               prod_mes_title: prod_mes_title,
               prod_title: prod_title,
               prod_mes_id: prod_mes_id,
               prod_available_qty: prod_available_qty,
               prod_org_price: prod_org_price,
               prod_offered_price: prod_offered_price,
               prod_img: prod_img
           },
           success: function(data) {
               $("#cart_count").html(data);
               $(".addtocart_" + prod_id).html(
                   '<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" value="-" id="moins" onclick="minus(1,' +
                   prod_id + ',' + prod_mes_id +
                   ')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +
                   '" type="text" size="25" value="1" readonly/><button type="button" value="+" id="plus" onclick="plus(' +
                   prod_mes_id + ')"><i class="fas fa-plus"></i></button></div></div>');
           }
       });
   }
   
   function plus(prod_mes_id) {
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       $.ajax({
           url: '<?php echo site_url('home/plus_prod_qty'); ?>',
           type: 'POST',
           data: {
               prod_mes_id: prod_mes_id,
               qty: qty
           },
           success: function(data) {
               if (data !== '') {
                   $('.chck_qty_' + prod_mes_id).val(qty + 1);
               } else {
                   alert('fail');
               }
           }
       });
   }
   
   function minus(idtype,prod_id, prod_mes_id) {
       // var prod_mes_title = $('#'+idtype+'_'+prod_id).val();
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       $.ajax({
           url: '<?php echo site_url('home/minus_prod_qty'); ?>',
           type: 'POST',
           data: {
               prod_mes_id: prod_mes_id,
               qty: qty
           },
           success: function(data) {
               if (data !== '') {
                   $('.chck_qty_' + prod_mes_id).val(qty - 1);
                   if (qty == 1) {
                     var obj =$.parseJSON(data);
                     // alert(obj['cart_count']);
               $("#cart_count").html(obj['cart_count']);
               $(".addtocart_" + prod_id).html(
            "<div class='prodct-add'><button class='addcrtbn' onclick='addtocart(" +idtype + "," +prod_id + "," + prod_mes_id + ")'>Add</button></div>");
                   }
               } else {
                   alert('fail');
               }
           }
       });
   }
   
   function addtowishlist(prod_id, type) {
       var user_id = 1;
       $.ajax({
           url: '<?php echo site_url('home/addtowishlist'); ?>',
           type: 'POST',
           data: {
               user_id: user_id,
               prod_id: prod_id
           },
           success: function(result) {
               if ($.trim(result) == 1) {
                   $('a[data-id=wish_' + type + '_' + prod_id + ']').addClass('wishlist_active');
                   alert('success');
               } else {
                   $('a[data-id=wish_' + type + '_' + prod_id + ']').removeClass('wishlist_active');
                   alert('fail');
               }
           }
       });
   }
</script>