<section class="ss-inner-brd">
   <div class="container">
      <div class="ss-inner-brd-cnt">
         <h1>The Soil Son <span><i class="far fa-calendar-alt"></i> My Subscriptions</span></h1>
         <ul>
            <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="brek-lst">/</li>
            <li class="brd-active">My Subscriptions</li>
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
                  <div id="empty_cart">
                     <?php if(!empty($products)){ foreach ($products as$product) { ?>
                     <div class="cart_page_item_total" id="remove_subscription_<?php echo $product['prod_mes_id']; ?>">
                        <div class="cart_page_product_image"> 
                           <a href="<?php echo base_url(); ?>/products/product_details/1">
                           <img src="<?php echo base_url();?>assets/products/<?php echo $product['prod_image']; ?>" alt="product img">
                           </a>
                        </div>
                        <div class="cart_page_product_names_right">
                           <div class="cart_page_porduct_name_item_left">
                              <h3 class="cart_page_product_item_heading"><?php echo $product['prod_title']; ?></h3>
                              <span class="cart_page_product_item_quntity"><?php echo $product['mes_title']; ?></span>
                              <p class="subcri-para-shw">Subscription: <span><?php echo $product['schedule_type']; ?></span></p>
                              <p class="subcri-para-warning"><?php echo $product['reason']; ?></p>
                           </div>
                           <div class="cart_page_porduct_name_item_right">
                              <div class="cart_page_product_final_amout">
                                 <input type="hidden" name="price" class="price_1" value="30">
                                 <span class="cart_page_product_amout_strike">Rs <?php echo $product['prod_org_price']; ?></span>
                                 <div class="cart_page_product_amount_heading">Rs <span id="price_1"><?php echo $product['prod_offered_price']; ?></span></div>
                              </div>
                              <div class="cart_page_product_remove_btn">
                                 <ul class="cart_page_remove_wishlist">
                                    <?php if($product['is_active']==2){ ?>
                                    <li><button type="button" class="cart_page_remove_btn_inner sub-mdfy" onclick="resume_subscription('<?php echo $product['subscribe_id']; ?>','<?php echo $product['prod_id']; ?>','<?php echo $product['prod_mes_id']; ?>');"><i class="fas fa-redo"></i> Resume</button></li>
                                    
                                    <?php }else{ ?>
                                    <li><button type="button" class="cart_page_remove_btn_inner sub-mdfy" onclick="pause_subscription('<?php echo $product['subscribe_id']; ?>','<?php echo $product['prod_id']; ?>','<?php echo $product['prod_mes_id']; ?>');"><i class="far fa-pause-circle"></i> Pause</button></li>
                                    <?php } ?>
                                    <li>|</li>
                                    <li><button onclick="modify('<?php echo $product['subscribe_id']; ?>','<?php echo $product['prod_id']; ?>','<?php echo $product['prod_mes_id']; ?>','<?php echo $product['prod_image']; ?>');" class="cart_page_remove_btn_inner sub-mdfy"><i class="far fa-calendar-alt"></i> Modify</button></li>
                                    <li>|</li>
                                    <li>
                                       <button class="cart_page_remove_btn_inner" onclick="delete_subscription('<?php echo $product['subscribe_id']; ?>','<?php echo $product['prod_id']; ?>','<?php echo $product['prod_mes_id']; ?>','<?php echo $product['is_active']; ?>');"><i class="fas fa-times"></i> Remove</button>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                        <?php }  } else{ ?>
                        <div class="my-sub-empty-crt">
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
                        <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade login-modl" id="subscription-delete-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="subscrip-mdl-cnt">
               <div class="subscrip-mdl-img">
                  <img src="<?php echo base_url(); ?>assets/frontend/images/soil-son-bag.svg"/>
               </div>
               <input type="hidden" name="delete_subscription_id" id="delete_subscription_id" />
               <input type="hidden" name="delete_subscription_prod_id" id="delete_subscription_prod_id" />
               <input type="hidden" name="delete_subscription_prod_mes_id" id="delete_subscription_prod_mes_id" />
                <input type="hidden" name="is_active" id="is_active" />
               <div class="subscrip-mdl-sntc">
                  <h2>Holiday Mode</h2>
                  <p>You can pause your subscription for a duration and it will resume once you are back automatically</p>
               </div>
               <div class="subscrip-mdl-buttons">
                  <ul>
                     <li><button type="button" onclick="delete_subscription_prod();"><i class="far fa-trash-alt"></i> Delete</button></li>
                     <li id="dlete_pause_button"><button class="alter-set-btn"  type="button" onclick="delete_pause_subscription();"><i class="far fa-pause-circle"></i> Pause</button></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade login-modl" id="subscription-modify-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="subscrip-mdl-cnt">
               <div class="subscrip-mdl-img" >
                  <img id="subscrip_mdl_img" />
               </div>
               <div class="subscrip-mdl-sntc">
                  <h2>Modify Subscription</h2>
                  <p>You can modify your subscription for a time being or permanently</p>
               </div>
               <div class="subscrip-mdl-buttons subscrip-mdl-full-buttons">
                  <ul>
                     <input type="hidden" name="modify_subscription_id" id="modify_subscription_id" />
                     <input type="hidden" name="modify_subscription_prod_id" id="modify_subscription_prod_id" />
                     <input type="hidden" name="modify_subscription_prod_mes_id" id="modify_subscription_prod_mes_id" />
                     <li><button type="button" onclick="modify_temporarily1();">Modify Temporarily</button></li>
                     <li><button class="alter-set-btn" type="button" onclick="update_permanently1();">Update Permanently</button></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Pause Subsciption -->
<div class="modal fade login-modl" id="subscription-item-pause-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="subscrip-indi-mdl-cnt">
               <div id="get_pause_subscription_prod_list"></div>
               <form method="post" action="<?php echo base_url(); ?>subscription/changing_subscribe_product" id="pause_subscribe_product" name="pause_subscribe_product" >
                  <input type="hidden" name="pause_subscription_id" id="pause_subscription_id" />
                  <div class="subscrip-item-dates">
                     <h1>Select Dates</h1>
                     <div class="subscrip-item-date-cnt">
                        <div class="subscrip-item-date-inn">
                           <label>From Date</label>
                           <input type="text" name="pause_start_date" id="pause_start_date" placeholder="Select From">
                        </div>
                        <div class="subscrip-item-date-inn">
                           <label>To Date</label>
                           <input type="text" name="pause_end_date" id="pause_end_date" placeholder="Select To">
                        </div>
                     </div>
                  </div>
                  <div class="subscrip-item-sub">
                     <button type="submit">Pause Subscription</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Pause Subscrption -->
<div class="modal fade login-modl" id="subscription-item-modify-temp-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="subscrip-indi-mdl-cnt">
               <div id="get_subscription-item-modify-temp-modal"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade login-modl" id="subscription-item-modify-permanent-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="subscrip-indi-mdl-cnt">
               <div id="get_update_subscription_prod_list"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   $('#pause_start_date').Zebra_DatePicker({
      direction: 1,
       format: 'd-m-Y',
       pair: $('#pause_end_date')
   });
   $('#pause_end_date').Zebra_DatePicker({
      direction: true,
       format: 'd-m-Y'
   });
   
   function pause_subscription(subscription_id,prod_id,prod_mes_id){
         $('#pause_subscription_id').val(subscription_id);
          $.ajax({
           url: '<?php echo site_url('subscription/get_pause_subscription_list'); ?>',
           type: 'POST',
           data: {subscription_id: subscription_id,prod_id: prod_id,prod_mes_id: prod_mes_id},
           success: function(data) {
             $('#subscription-item-pause-modal').modal('show'); 
             $('#get_pause_subscription_prod_list').html(data);
           }
       });
   }
   
   function delete_pause_subscription(){
         var subscription_id = $('#delete_subscription_id').val();
         var prod_id = $('#delete_subscription_prod_id').val();
         var prod_mes_id = $('#delete_subscription_prod_mes_id').val();
         $('#pause_subscription_id').val(subscription_id);
         // alert(subscription_id);
          $.ajax({
           url: '<?php echo site_url('subscription/get_pause_subscription_list'); ?>',
           type: 'POST',
           data: {subscription_id: subscription_id,prod_id: prod_id,prod_mes_id: prod_mes_id},
           success: function(data) {
             $('#subscription-item-pause-modal').modal('show'); 
             $('#get_pause_subscription_prod_list').html(data);
           }
       });
   }
   
   function resume_subscription(subscription_id,prod_id,prod_mes_id){
          $.ajax({
           url: '<?php echo site_url('subscription/unpause_the_subscraibe_product'); ?>',
           type: 'POST',
           data: {subscription_id: subscription_id,prod_id: prod_id,prod_mes_id: prod_mes_id},
           success: function(data) {
            if(data==1){
               $.toast({heading:'Success',text:'UnPaused Successfully...',position:'top-right',stack: false,icon:'success'});
               location.reload();
            }else{
               $.toast({heading:'Error',text:'Invalid subscriber id...',position:'top-right',stack: false,icon:'error'});
            }
           }
       });
   }
   
   function delete_subscription(subscription_id,prod_id,prod_mes_id,is_active){
         $('#delete_subscription_id').val(subscription_id);
         $('#delete_subscription_prod_id').val(prod_id);
         $('#delete_subscription_prod_mes_id').val(prod_mes_id);
         var is_activ = $('#is_active').val(is_active);
         // alert(is_active);
         if(is_active==2){
            $('#dlete_pause_button').hide();
         }else{
             $('#dlete_pause_button').show();
         }
         $('#subscription-delete-modal').modal('show'); 
         // $('#get_pause_subscription_prod_list').html(data);
   }
   
   function modify_temporarily1(){
   
         var subscription_id =$('#modify_subscription_id').val();
         var prod_id =$('#modify_subscription_prod_id').val();
         var prod_mes_id =$('#modify_subscription_prod_mes_id').val();
         $('#modify_subscription_id1').val(subscription_id);
         $('#modify_subscription_prod_id1').val(prod_id);
         $('#modify_subscription_prod_mes_id1').val(prod_mes_id);
         $.ajax({
           url: '<?php echo site_url('subscription/get_modify_temporarily_list'); ?>',
           type: 'POST',
           data: {subscription_id: subscription_id,prod_id: prod_id,prod_mes_id: prod_mes_id},
           success: function(data) {
             $('#subscription-item-modify-temp-modal').modal('show'); 
             $('#modify_subscription_qty').val('');
             $('#update_modify_subscription_qty').val('');
             $('#modified_from_date').val('');
             $('#modified_to_date').val('');
             $('#update_permanently_from_date').val('');
             $('#update_permanently_to_date').val('');
             $('#get_subscription-item-modify-temp-modal').html(data);
           }
          });
         // $('#get_pause_subscription_prod_list').html(data);
   }
   
   function update_permanently1(){
         var subscription_id =$('#modify_subscription_id').val();
         var prod_id =$('#modify_subscription_prod_id').val();
         var prod_mes_id =$('#modify_subscription_prod_mes_id').val();
         $('#update_modify_subscription_id').val(subscription_id);
         $('#update_modify_subscription_prod_id').val(prod_id);
         $('#update_modify_subscription_prod_mes_id').val(prod_mes_id);
          $.ajax({
              url: '<?php echo site_url('subscription/get_modify_permently_list'); ?>',
              type: 'POST',
              data: {subscription_id: subscription_id,prod_id: prod_id,prod_mes_id: prod_mes_id},
              success: function(data) {
                $('#subscription-item-modify-permanent-modal').modal('show'); 
                $('#modify_subscription_qty').val('');
                $('#update_modify_subscription_qty').val('');
                $('#modified_from_date').val('');
                $('#modified_to_date').val('');
                $('#update_permanently_from_date').val('');
                $('#update_permanently_to_date').val('');
                $('#get_update_subscription_prod_list').html(data);
              }
          });
         
   }
   
   function modify(subscription_id,prod_id,prod_mes_id,img){
         $('#modify_subscription_id').val(subscription_id);
         $('#modify_subscription_prod_id').val(prod_id);
         $('#modify_subscription_prod_mes_id').val(prod_mes_id);
         // $('#subscrip_mdl_img')
         var url ='<?php echo base_url(); ?>';
         $('#subscrip_mdl_img').attr('src', url+"assets/products/"+img); 
         $('#subscription-modify-modal').modal('show'); 
         // $('#get_pause_subscription_prod_list').html(data);
   }
   
   function delete_subscription_prod(){
         var subscription_id = $('#delete_subscription_id').val();
         var prod_id = $('#delete_subscription_prod_id').val();
         var prod_mes_id = $('#delete_subscription_prod_mes_id').val();
         // alert(prod_mes_id);
          $.ajax({
           url: '<?php echo site_url('subscription/delete_product_subscraibe'); ?>',
           type: 'POST',
           dataType: 'json',
           data: {subscription_id: subscription_id},
           success: function(data) {
             var count = data.subscription_count;
             // alert(count);
            if(count==0){
               $.toast({heading:'Success',text:'Your Subscription deleted successfully...',position:'top-right',stack: false,icon:'success'});
               $('#subscription-delete-modal').modal('hide'); 
               $('#remove_subscription_'+prod_mes_id).remove(); 
               $('#empty_cart').html('<div class="my-sub-empty-crt"><div class="cart_page_left_inner"><div class="cart_page_empty_cart_section"><div class="cart_page_empty_cart_image"><img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"></div><h3>No Data Found</h3><div class="cart_page_empty_continue_btn"><a href="<?php echo base_url(); ?>">Continue Shopping</a></div></div></div> </div>');
            }else{
               $.toast({heading:'Success',text:'Your Subscription deleted successfully...',position:'top-right',stack: false,icon:'success'});
               $('#subscription-delete-modal').modal('hide'); 
               $('#remove_subscription_'+prod_mes_id).remove(); 
             
           }
            }
       });
   }
   
   $("#pause_subscribe_product").validate({
      rules:{pause_start_date:{required:true},pause_end_date:{required:true}},
      messages:{pause_start_date:{required:'Please select from date'},pause_end_date:{required:'Please select to date'}},
   ignore: []
   });
   
</script>