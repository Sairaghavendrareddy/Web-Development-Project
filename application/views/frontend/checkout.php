<section class="ss-inner-brd">
   <div class="container">
      <div class="ss-inner-brd-cnt">
         <h1>The Soil Son <span><i class="fas fa-shopping-basket"></i> Checkout</span></h1>
         <ul>
            <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="brek-lst">/</li>
            <li class="brd-active">Checkout</li>
         </ul>
      </div>
   </div>
</section>
<form method="post" action="<?php echo base_url(); ?>order" id="order" name="order" onsubmit="return checkout_submit();">
   <section class="cart_page_total_section">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-8 col-lg-9 col-xl-9">
               <div class="cart_page_left_inner">
                  <div class="address_page_delivery_type">
                     <h3 class="select_deliver_address_heading">Delivery Mode</h3>
                  </div>
                  <div class="address_page_delivery_mode_radio">
                     <ul>
                        <li>
                           <label class="address_page_radio">
                           <input type="radio" name="deliver_mode" id="deliver_mode" value="normal">
                           <span class="address_page_normal_delivery">Normal Delivery</span>
                           </label>
                        </li>
                        <li>
                           <label class="address_page_radio">
                           <input type="radio" name="deliver_mode" id="express_deliver_mode" value="express">
                           <span class="address_page_normal_delivery">Express Delivery</span>
                           </label>
                        </li>
                     </ul>
                     <input type="hidden" name="get_delivery_mode" id="get_delivery_mode" />
                  </div>
                  <div id="delivery_slot_day">
                     <div class="address_page_delivery_type">
                        <h3 class="select_deliver_address_heading">Select Delivery Slot Day</h3>
                     </div>
                     <div class="address_page_delivery_mode_radio">
                        <ul>
                           <li>
                              <label class="address_page_radio">
                              <input type="radio" name="delivery_slot_day" id="today_slots" value="1" checked>
                              <span class="address_page_normal_delivery">Today</span>
                              </label>
                           </li>
                           <li>
                              <label class="address_page_radio">
                              <input type="radio" name="delivery_slot_day" id="tomorrow_slots" value="2">
                              <span class="address_page_normal_delivery">Tomorrow</span>
                              </label>
                           </li>
                        </ul>
                        <input type="hidden" name="get_delivery_slots_day" id="get_delivery_slots_day">
                     </div>
                     <div id="delivery_slots"></div>
                  </div>
                  <div class="select_address_section">
                     <h3 class="select_deliver_address_heading">Select Delivery Address</h3>
                     <!-- <button type="button" class="address_addnewaddress">Add New Address</button> -->
                  </div>
                  <div class="address_default_address">
                     <h3 class="address_default_address_heading">Default Address</h3>
                  </div>
                  <?php if(!empty($default_address)){ ?>
                  <input type="hidden" name="apartment_id" id="apartment_id" value="<?php echo $default_address['apartment_id']; ?>">
                  <input type="hidden" name="user_apartment_det_id" id="user_apartment_det_id" value="<?php echo $default_address['user_apartment_det_id']; ?>">
                  <div class="address_default_address_main" id="add_delivery_save_address">
                     <div class="address_default_address_left">
                        <label class="address_page_radio">
                           <input type="radio" name="default_address" id="default_address" checked>
                           <span>
                              <div class="address_page_radio_defaultaddress">
                                 <h3 class="address_page_defaultaddress_holder"><?php echo $default_address['name']; ?></h3>
                                 <div class="address_page_defaultaddress_content">Block No:<span id="checkout_delivery_add_blockno"><?php echo $default_address['block_id']; ?></span>,Flot No:<span id="checkout_delivery_add_floatno"><?php echo $default_address['flat_id']; ?></span>, <?php echo $default_address['apartment_name']; ?>,<?php echo $default_address['apartment_address']; ?> - <?php echo $default_address['apartment_pincode']; ?></div>
                                 <div class="address_page_defaultaddress_content">Mobile - <span class="font_bold"><?php echo $default_address['phone']; ?></span></div>
                              </div>
                           </span>
                           <input type="hidden" id="" value="" />
                        </label>
                     </div>
                     <div class="address_default_address_right">
                        <button type="button" onclick="edit_checkout_delivery_address();">Edit</button>
                     </div>
                  </div>
                  <?php } else{ ?>
                 <div class="ajax_add_delivery_save_address"></div>
                   <div class="no_address_found">
                         <div class="no_address_found_pic">
                            <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png">
                         </div>
                         <span id="delivery_add_empty">Delivery Address is Empty Please Add New Address</span>
                         <div class="select_address_section">
                            <button type="button" class="address_addnewaddress" href="#delivery_address_selection_modal" data-target="#delivery_address_selection_modal" data-toggle="modal">Add New Address</button>
                         </div>
                      </div>
                  <?php } ?>
               </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
               <div class="cart_page_right_inner">
                  <h3 class="cart_pge_coupon_code">Order Summary</h3>
                  <div class="cart_page_total_amount_cart">
                     <span class="cart_page_total_left_all_heading">Sub Total:</span>
                     <span class="cart_page_total_right_all_heading" >
                     <?php echo $this->cart->total(); ?>
                     </span>
                  </div>
                  <div class="cart_page_total_amount_cart">
                     <span class="cart_page_total_left_all_heading">Discount:</span>
                     <span class="cart_page_total_right_all_heading" >
                     <?php if($this->session->userdata('coupon_amount')!=''){
                        echo $this->session->userdata('coupon_amount');
                         }else{
                        echo 0;
                        }
                        ?>
                     </span>
                  </div>
                  <div class="cart_page_total_amount_cart">
                     <span class="cart_page_total_left_all_heading" >Delivery Charges:</span>
                     <span class="cart_page_total_right_all_heading" id="delivery_charges">0</span>
                  </div>
                  <div class="cart_page_total_amount_cart cart_page_total_amount_bold">
                     <span class="cart_page_total_left_all_heading" id="remove_tol_amt">Total Amount:</span>
                     <span class="cart_page_total_right_all_heading" id="cart_totl_amnt">
                     <?php if($this->session->userdata('final_order_amt')!=''){
                        echo $this->session->userdata('final_order_amt');
                        }else{
                        echo $this->cart->total();
                        }
                        ?>
                     </span>
                  </div>
                  <div class="final_pay_meth">
                  <h3 class="cart_page_total_left_all_heading">Payment Method</h3>
                  <?php 
                     if($this->session->userdata('final_order_amt')!=''){
                        $amount =$this->session->userdata('final_order_amt');
                     }else{
                        $amount =$this->cart->total();
                     }
                     // print_r($wallet_amount['final_wallet_amount']);exit;
                     if($wallet_amount['final_wallet_amount'] >=$amount){ ?>
                        <div class="final_pay_meth_radio">
                           <label class="pay_method_radio" >
                        <input type="radio" name="wallet_amount" value="wallet">
                           <span>Wallet</span>
                        </label>
                        </div>
                        <!-- HTML to write -->
                           <?php }else{ ?>
                              <div class="final_pay_meth_radio">
                           <label class="pay_method_radio" data-toggle="tooltip" data-placement="top" title="Insufficient Balance">
                        <input type="radio" name="wallet_amount" value="wallet" disabled="">
                           <span>Wallet</span>
                        </label>
                        </div>
                           <?php } ?>
                           
                        <div class="final_pay_meth_radio">
                           <label class="pay_method_radio">
                              <input type="radio" name="wallet_amount" value="cod">
                              <span>COD</span>
                           </label>
                        </div>
                     </div>
                  <div class="cart_page_goto_checkout_btn">

                     <button type="submit" name="make_payment" id="make_payment">Place Order</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</form>
<!--Edit Delivery Address-->
<div class="modal fade login-modl" id="edit_checkout_delivery_address" tabindex="-1" role="dialog"
   aria-labelledby="address_selection_modal" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="ss-address-select">
               <h1>Edit Delivery Address</h1>
               <div class="ss-address-show">
                  <?php 
                     if(!empty($default_address)){ ?>
                  <div class="ss-address-box">
                     <div class="ss-address-rad">
                        <label class="radio">
                        <input type="radio" id="checkout_apartment_id" name="checkout_apartment_id" value="<?php echo $default_address['apartment_id']; ?>" checked>
                        <span><?php echo $default_address['apartment_name']; ?>, <?php echo $default_address['apartment_address']; ?>, <?php echo $default_address['apartment_pincode']; ?>.</span>
                        </label>
                     </div>
                     <!-- <form method="post" name="default_address_save" id="default_address_save" action="<?php echo base_url(); ?>checkout/update_user_address"> -->
                     <input type="hidden" name="checkout_address_id" id="checkout_address_id" value="<?php echo $default_address['user_apartment_det_id']; ?>">
                     <div class="ss-apt-info">
                        <div class="ss-apt-blk">
                           <input type="text" name="checkout_app_block_no" id="checkout_app_block_no" placeholder="Block No" value="<?php echo $default_address['block_id']; ?>">
                        </div>
                        <div class="ss-apt-flt">
                           <input type="text" name="checkout_app_flat_no" id="checkout_app_flat_no" placeholder="Flat No" value="<?php echo $default_address['flat_id']; ?>">
                        </div>
                        <div class="ss-apt-submit">
                           <label for="checkout_update_delivery_address"><i class="fas fa-arrow-right"></i></label>
                           <input type="button" class="d-none" name="checkout_update_delivery_address" id="checkout_update_delivery_address" value="Submit">
                        </div>
                     </div>
                  </div>
                  <!-- </form> -->
                  <?php  } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).ready(function(){
       $("#deliver_mode").attr("checked", true);
       var checked_yes_or_no = $('input[name="deliver_mode"]:checked').val();
       $('#get_delivery_mode').val(checked_yes_or_no);
           if(checked_yes_or_no=='normal'){
               $('#delivery_slot_day').hide();
            }else{
               $('#delivery_slot_day').show();
            }
   });
      
       $("input[name='deliver_mode']").change(function(){
       var checked_yes_or_no = $('input[name="deliver_mode"]:checked').val();
       $('#get_delivery_mode').val(checked_yes_or_no);
       $('#get_delivery_slots_day').val('');
         if($(this).val()=="normal"){
           $('#delivery_charges').html(0);
           var total_amount = $('#cart_totl_amnt').html();
           var paid_amount =parseFloat(total_amount) - parseFloat(45);
           $('#cart_totl_amnt').html(paid_amount.toFixed(2));
           $("#delivery_slot_day").hide();
         }else{
             var delivery_slot_day = $('input[name="delivery_slot_day"]:checked').val();
             $('#get_delivery_slots_day').val(delivery_slot_day);
             var delivery_charges = $('#delivery_charges').html(45);
             var total_amount = $('#cart_totl_amnt').html();
             var paid_amount =parseFloat(45) + parseFloat(total_amount);
             $('#cart_totl_amnt').html(paid_amount.toFixed(2));
             $("#delivery_slot_day").show(); 
             var delivery_slots =1;
               $.ajax({
                   url: '<?php echo site_url('checkout/delivery_slots'); ?>',
                   type: 'POST',
                   data:{delivery_slots:delivery_slots},
                   success: function(data){
                       $("#today_slots").attr("checked", true);
                       $('#delivery_slots').html(data);
                   }
               });
           }
      });
   
   $("input[name='delivery_slot_day']").change(function(){
       var delivery_slot_day = $('input[name="delivery_slot_day"]:checked').val();
       $('#get_delivery_slots_day').val(delivery_slot_day);
          if($(this).val()=="1")
          {
              var delivery_slots =1;
              $.ajax({
                   url: '<?php echo site_url('checkout/delivery_slots'); ?>',
                   type: 'POST',
                   data:{delivery_slots:delivery_slots},
                   success: function(data){
                       $("input[name='delivery_slot_day']").attr("checked", true);
                       $('#delivery_slots').html(data);
                    }
               });
          }else{
                 var delivery_slots =2;
                   $.ajax({
                   url: '<?php echo site_url('checkout/delivery_slots'); ?>',
                   type: 'POST',
                   data:{delivery_slots:delivery_slots},
                   success: function(data) {
                     $('#delivery_slots').html(data);
                   }
               });
           }
   });
   
   function edit_checkout_delivery_address()
   {
      $('#edit_checkout_delivery_address').modal();
   }
   
   $('#checkout_update_delivery_address').click( function() {
       var d_address_id = $('#checkout_address_id').val();
       var d_app_block_no =$("#checkout_app_block_no").val();
       var d_app_flat_no =$("#checkout_app_flat_no").val();
       if($.trim(d_app_block_no)=='' || $.trim(d_app_flat_no)==''){
           $.toast({heading:'Error',text:'Please Enter Block No and Flat No',position:'top-right',stack: false,icon:'error'});
           return false;
       }
         $.ajax({
               url: '<?php echo site_url('checkout/update_user_address'); ?>',
               type: 'POST',
               dataType: 'json',
               data: {d_address_id: d_address_id,d_app_block_no: d_app_block_no,d_app_flat_no: d_app_flat_no},
               success: function(data) {
                  if(data==0){
                    $.toast({heading:'Error',text:'Opps! Your Address Not Saved Please try Again..',position:'top-right',stack: false,icon:'error'});
       
                  }else{
                   // alert(data);
                     $('#checkout_delivery_add_blockno').html(data['d_app_block_no']);
                     $('#checkout_delivery_add_floatno').html(data['d_app_flat_no']);
                     $('#edit_checkout_delivery_address').modal('hide');
                       $.toast({heading:'Success',text:'Delivery Address Updated Successfully...',position:'top-right',stack: false,icon:'success'});
                  }
               }
        });
   });
   
</script>
<script>
   $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

function checkout_submit()
{
   var deliver_mode =$("input[name='deliver_mode']:checked").val();
   var default_address =$("input[name='default_address']:checked").val();
   var payment_mode =$("input[name='wallet_amount']:checked").val();
   if(deliver_mode==undefined || deliver_mode==''){
       $.toast({heading:'Error',text:'Please Select Delivery Mode',position:'top-right',stack: false,icon:'error'});
      return false;
   }else if(deliver_mode=='express'){
            var delivery_slot_day =$("input[name='delivery_slot_day']:checked").val();
            var slot_time =$("input[name='slot_time']:checked").val();
            if(delivery_slot_day==undefined || deliver_mode=='')
            {
              $.toast({heading:'Error',text:'Please Select Delivery Slot Day',position:'top-right',stack: false,icon:'error'});
              return false;
            }
            else if(slot_time==undefined || slot_time=='')
            {
                 $.toast({heading:'Error',text:'Please Select Delivery Slot Time',position:'top-right',stack: false,icon:'error'});
                 return false;
            }else if(default_address==undefined || default_address=='')
            {
                $.toast({heading:'Error',text:'Please Select Address',position:'top-right',stack: false,icon:'error'});
                return false;
            }else if(payment_mode==undefined || payment_mode=='')
            {
                $.toast({heading:'Error',text:'Please Select Payment Mode',position:'top-right',stack: false,icon:'error'});
                return false;
            }
   }else if(default_address==undefined || default_address==''){
       $.toast({heading:'Error',text:'Please Select Address',position:'top-right',stack: false,icon:'error'});
      return false;
   }else if(payment_mode==undefined || payment_mode==''){
      $.toast({heading:'Error',text:'Please Select Payment Mode',position:'top-right',stack: false,icon:'error'});
      return false;
   }
  
}
</script>