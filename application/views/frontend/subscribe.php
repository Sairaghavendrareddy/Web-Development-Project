<section class="ss-breadcrumb">
   <div class="container">
      <div class="ss-breadcrumb-cnt">
         <ul>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="nxt-arw"><i class="fas fa-caret-right"></i></li>
            <li class="active">Add Subscription</li>
         </ul>
      </div>
   </div>
</section>
<form method="post" action="<?php echo base_url(); ?>subscription/add_subscribe_product" id="subscription"
   name="subscription" onsubmit="return save_subscription_form();">
   <section class="ss-product-view">
      <div class="container">
         <?php if(!empty($subscribe)){
            $prdo_decode =$subscribe['prod_mesurements'];
            $prdo_details = json_decode($prdo_decode, true);
            // echo"<pre>";print_r($prdo_details);exit;
            foreach ($prdo_details as $subscribe_list) { 
            $img =json_decode($subscribe_list['prod_image'], true);
            // echo"<pre>";print_r($img);exit;
            ?>
            <div class="add_sub_indi">
         <div class="row">
            <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
               <div class="ss-product-view-slide ss-product-view-slide_sticky">
                  <div class="product-view-subs-pht">
                     <div class="fav-prd subinnner-fav">
                        <a href="javascript:void(0)" class="wsh-shw-cn whishstate wish_icon wishlist_active"
                           data-id="wish_product_details_1"><i class="fas fa-heart"></i></a>
                     </div>
                     <img class="" src="<?php echo base_url(); ?>assets/products/<?php echo $img[0]; ?>" />
                  </div>
               </div>
            </div>
            <div class="col-4 col-sm-12 col-md-7 col-lg-7 col-xl-7">
               <div class="product-info-view prod-sub-innner">
                  <div class="product-info-top">
                     <input type="text" class="d-none" name="prod_id"
                        value="<?php echo $subscribe_list['prod_id']; ?>">
                     <input type="text" name="prod_mes_id[]" class="d-none"
                        value="<?php echo $subscribe_list['prod_mes_id']; ?>">
                     <h1><?php echo $subscribe['prod_title']; ?></h1>
                     <div class="product-view-prc">
                        <ul>
                           <li>
                              <div class="viw-act-prc">MRP: Rs
                                 <span><?php echo $subscribe_list['prod_org_price']; ?></span>
                              </div>
                              <div class="viw-dis-prc">Our Price: Rs <span
                                 class="price_<?php echo $subscribe_list['prod_mes_id']; ?>"><?php echo $subscribe_list['prod_offered_price']; ?></span>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="product-addcrt">
                        <div class="product-addcrt-lb">
                           <h5>Pack Sizes <span class="float-right">:</span></h5>
                        </div>
                        <div class="prodct-bx-wt">
                           <span><?php echo $subscribe_list['title']; ?></span>
                        </div>
                     </div>
                     <div class="product-addcrt">
                        <div class="prod-vw-qnt-set">
                           <input type="text" class="d-none plus_amount" name="plus_amount[]"
                              id="plus_amount_<?php echo $subscribe_list['prod_mes_id']; ?>" value="0">
                           <div class="prod-vw-qnt-view" id="input_div">
                              <label class="viw-plsmin-btn"
                                 for="moins_<?php echo $subscribe_list['prod_mes_id']; ?>"><i
                                 class="fas fa-minus"></i></label>
                              <input class="d-none" type="button" value="-"
                                 id="moins_<?php echo $subscribe_list['prod_mes_id']; ?>"
                                 onclick="subscribe_minus('<?php echo $subscribe_list['prod_mes_id']; ?>')">
                              <input
                                 class="viw-plsmin-vlue chckqty chck_qty_<?php echo $subscribe_list['prod_mes_id']; ?>"
                                 type="text" name="qty[]" size="25" value="0" readonly>
                              <label class="viw-plsmin-btn"
                                 for="plus_<?php echo $subscribe_list['prod_mes_id']; ?>"><i
                                 class="fas fa-plus"></i></label>
                              <input class="d-none" type="button" value="+"
                                 id="plus_<?php echo $subscribe_list['prod_mes_id']; ?>"
                                 onclick="subscribe_plus('<?php echo $subscribe_list['prod_mes_id']; ?>')">
                           </div>
                        </div>
                     </div>
                     <?php
                            $prodid=$subscribe_list['prod_id'];
                            $prodtitle =$subscribe['prod_title'];
                            $combo_products = $this->db->query("SELECT `prod_id`, `prod_title`,`combo_products`, `prod_slug` FROM `products` WHERE `prod_id`=$prodid")->row_array();
                            $combo_products =$combo_products['combo_products'];
                            if(!empty($combo_products)){ ?>
                                <button class="addcrtbn" type="button" onclick="view_combos('<?php echo $prodid; ?>');">View Products</button>
                    <?php } else{ } ?>
                  </div>
               </div>
            </div>
         </div>
         </div>
         <?php } } ?>
         <div class="sub-start-purchse">
            <div class="sub-start-dt">
               <h3 class="sub-prces-hed">Subscription Start Date</h3>
               <div class="sub-start-inp">
                  <div class="subscrip-item-date-inn">
                     <input type="text" placeholder="Select Subscription Start Date" name="sub_date"
                        id="sub_date">
                  </div>
               </div>
            </div>
            <div class="sub-start-pick">
               <h3 class="sub-prces-hed">Pick Schedule</h3>
               <div class="address_page_slot_time_select">
                  <ul>
                     <li>
                        <label class="address_page_radio">
                        <input type="radio" name="pick_schedule" class="pick_schedule" value="daily">
                        <span class="address_page_normal_delivery">Daily</span>
                        </label>
                     </li>
                     <li>
                        <label class="address_page_radio">
                        <input type="radio" name="pick_schedule" class="pick_schedule" value="alternative">
                        <span class="address_page_normal_delivery">Alternate Day</span>
                        </label>
                     </li>
                     <li>
                        <label class="address_page_radio">
                        <input type="radio" name="pick_schedule" class="pick_schedule"
                           value="every_three_days">
                        <span class="address_page_normal_delivery">Every 3 days</span>
                        </label>
                     </li>
                     <li>
                        <label class="address_page_radio">
                        <input type="radio" name="pick_schedule" class="pick_schedule" value="weekely">
                        <span class="address_page_normal_delivery">Weekly</span>
                        </label>
                     </li>
                     <li>
                        <label class="address_page_radio">
                        <input type="radio" name="pick_schedule" class="pick_schedule" value="monthly">
                        <span class="address_page_normal_delivery">Monthly</span>
                        </label>
                     </li>
                  </ul>
               </div>
               <div id="weekely_days" style="display: none;">
                              <div class="shw_week_days">
                                 <ul>
                                    <li>
                                       <label class="container-checkbox">
                                       <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Monday">Monday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                    <li>
                                    <label class="container-checkbox">
                                    <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Tuesday">Tuesday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                    <li>
                                    <label class="container-checkbox">
                                    <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Wednesday">Wednesday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                    <li>
                                    <label class="container-checkbox">
                                    <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Thursday">Thursday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                    <li>
                                    <label class="container-checkbox">
                                    <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Friday">Friday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                    <li>
                                    <label class="container-checkbox">
                                    <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Saturday">Saturday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                    <li>
                                    <label class="container-checkbox">
                                    <input type="checkbox" class="weekely_days_list" name="days_list[]" value="Monday">Sunday
                                       <span class="checkmark"></span>
                                       </label>
                                    </li>
                                 </ul>
                              </div>
               </div>
               <div id="days_list" style="display: none;">
                 
               </div>
               <div class="service-sub-prc">
                  <h4>Service Charge : &#8377<span>25</span></h4>
                  <p><span>Note:</span> Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in
                     laying out print, graphic or web designs. 
                  </p>
               </div>
            </div>
            <div class="sub-start-addrss">
               <h3 class="sub-prces-hed">Select Address</h3> 
                <?php if(!empty($default_address)){ ?>
              
               <div class="sub-start-addrss-box">
                  <div class="address_default_address_main" class="add_delivery_save_address">
                     <div class="address_default_address_left">
                        <label class="address_page_radio">
                           <input type="radio" name="user_apartment_det_id" id="user_apartment_det_id"
                              value="<?php echo $default_address['user_apartment_det_id']; ?>" checked>
                           <span>
                              <div class="address_page_radio_defaultaddress">
                                 <h3 class="address_page_defaultaddress_holder">
                                    <?php echo $default_address['name']; ?>
                                 </h3>
                                 <div class="address_page_defaultaddress_content">Block No:<span
                                    id="delivery_add_blockno"><?php echo $default_address['block_id']; ?></span>,Flot
                                    No:<span
                                       id="delivery_add_floatno"><?php echo $default_address['flat_id']; ?></span>,
                                    <?php echo $default_address['apartment_name']; ?>,<?php echo $default_address['apartment_address']; ?>
                                    - <?php echo $default_address['apartment_pincode']; ?>
                                 </div>
                                 <div class="address_page_defaultaddress_content">Mobile - <span
                                    class="font_bold"><?php echo $default_address['phone']; ?></span>
                                 </div>
                              </div>
                           </span>
                           <input type="hidden" id="" value="">
                        </label>
                     </div>
                     <div class="address_default_address_right">
                        <button type="button" onclick="edit_delivery_address();">Edit</button>
                     </div>
                  </div>
               </div>
             <?php } else {?>
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
            <div class="start-sub-item">
               <!-- <button data-toggle="modal" data-target="#subscription-added-modal" type="button"><i class="far fa-calendar-plus"></i> Add Subscription</button> -->
               <button type="submit"><i class="far fa-calendar-plus"></i> Add Subscription</button>
            </div>
         </div>
      </div>
      <!-- <section style="text-align: center;">
         <h4>TotalPayment per Day:<input type="text" name="pay_amount" id="pay_amount" value=""></h4>
         <input type="text" name="sub_from_date" id="sub_from_date" placeholder="Select From Date"><br>
         <input type="text" name="sub_to_date" id="sub_to_date" placeholder="Select To Date"><br>
         <input type="submit" name="add_subscription" id="add_subscription" value="Add Subscription">
         </section> -->
      </div>
   </section>
</form>
<div class="modal fade login-modl" id="subscription-added-modal" tabindex="-1" role="dialog"
   aria-labelledby="login-modal" aria-hidden="true">
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
                  <img src="<?php echo base_url(); ?>assets/frontend/images/soil-son-bag.svg" />
               </div>
               <div class="subscrip-mdl-sntc">
                  <h2>Success</h2>
                  <p>Your Subscription will start from May 13 2021</p>
               </div>
               <div class="subscrip-mdl-buttons subscrip-mdl-full-buttons">
                  <ul>
                     <li><a href="<?php echo base_url(); ?>product/subscription_list" type="button">My
                        Subscriptions</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo base_url(); ?>assets/frontend/js/zebra_datepicker.js"></script>
<script>
   $('#sub_date,#sub_to_date').Zebra_DatePicker({
       direction: 1,
       format: 'd-m-Y',
        onSelect: function() {
           $('input[name=pick_schedule]').attr("checked", false);
           $('input[name=weekely_days]').attr("checked", false);
           $('.weekely_days_list').prop('checked', false);
           $('.monthly_days_list').prop('checked', false);
           $('#weekely_days').hide();
           $('#days_list').hide();
        },
   });
</script>
<script>
   function subscribe_plus(prod_mes_id) {
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       var price = parseInt($('.price_' + prod_mes_id).html());
       $('.chck_qty_' + prod_mes_id).val(qty + 1);
       var get_qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       var pay_amount = get_qty * price;
       $('#plus_amount_' + prod_mes_id).val(pay_amount);
       // $('#pay_amount').val(pay_amount);
       var values = 0;
       $("input[name='plus_amount[]']").each(function() {
           // values.push($(this).val());
           values = values + parseInt(($(this).val()));
       });
       $('#pay_amount').val(values);
   }
   
   function subscribe_minus(prod_mes_id) {
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       var price = parseInt($('.price_' + prod_mes_id).html());
       if (qty >= 1) {
           $('.chck_qty_' + prod_mes_id).val(qty - 1);
           var get_qty = parseInt($('.chck_qty_' + prod_mes_id).val());
           var pay_amount = get_qty * price;
           $('#plus_amount_' + prod_mes_id).val(pay_amount);
           // $('#pay_amount').val(pay_amount);
           // calTotal();  
           var values = 0;
           $("input[name='plus_amount[]']").each(function() {
               // values.push($(this).val());
               values = values + parseInt(($(this).val()));
           });
           $('#pay_amount').val(values);
       } else {
   
       }
   
   }
   
   function calTotal() {
       var pay_amount1 = $('.plus_amount').val();
       // alert(pay_amount1);
       $('#pay_amount').html(pay_amount1);
   }
   
   //    $('#add_subscription').click( function() {
   //       var from_date =$("#sub_from_date").val();
   //       var to_date =$("#sub_to_date").val();
   //       var chck_qty =$(".chck_qty").val();
   //       if(from_date =='' || to_date==''){
   //          return false;
   //       }else if(chck_qty==''){
   //           return false;
   //         }else{
   //             $.ajax({
   //               url: '<?php echo site_url('product/save_subscription'); ?>',
   //               type: 'POST',
   //               data: {from_date: from_date,to_date: to_date},
   //               success: function(data) {
   //                   console.log(data);
   //               }
   //           });
   //       }
   
   // });
   function edit_delivery_address() {
       $('#edit_delivery_address').modal();
   }
   
   function save_subscription_form() {
       var qty = 0;
       $("input[name='qty[]']").each(function() {
          // values.push($(this).val());
          qty = qty + parseInt(($(this).val()));
       });
       // var qty = $("input[name='qty[]']").val();
      //  alert(qty);
       var sub_date = $('#sub_date').val();
       var pick_schedule =$("input[name='pick_schedule']:checked").val();
       var user_apartment_det_id = $('input:radio[name=user_apartment_det_id]').is(':checked');
       if(qty==0) {
            $.toast({heading:'Error',text:'Please select at least one qty...',position:'top-right',stack: false,icon:'error'});
            return false;
       }else if (sub_date == '') {
           $.toast({heading:'Error',text:'Please Select Date...',position:'top-right',stack: false,icon:'error'});
           return false;
       }else if(pick_schedule == 'weekely'){
           $('.monthly_days_list').prop('checked', false);
           // $('input[name=days_list[]]').attr("checked", false);
           var week_days=$("input[name='days_list[]']:checked").val();
            if(week_days==undefined || week_days==''){
                 $.toast({heading:'Error',text:'Please Select Weekely Days...',position:'top-right',stack: false,icon:'error'});
                 return false;
            }
       }else if(pick_schedule == 'monthly') {
            $('.weekely_days_list').prop('checked', false);
            // $('input[name=days_list[]]').attr("checked", false);
            var days_list=$("input[name='days_list[]']:checked").val();
            if(days_list==undefined || days_list==''){
                 $.toast({heading:'Error',text:'Please Select Monthly Days...',position:'top-right',stack: false,icon:'error'});
                 return false;
            }
       }else if(pick_schedule == undefined) {
            $.toast({heading:'Error',text:'Please Pick Schedule Days...',position:'top-right',stack: false,icon:'error'});
            return false;
            
       }else if(user_apartment_det_id == false) {
          $.toast({heading:'Error',text:'Please Select Address...',position:'top-right',stack: false,icon:'error'});
           return false;
       }
   }

 $("input[name='pick_schedule']").change(function(){
    var pick_schedule = $('input[name="pick_schedule"]:checked').val();
    // alert(pick_schedule);
    if(pick_schedule=='weekely'){
       $('.monthly_days_list').prop('checked', false);
       $('#days_list').hide();
       $('#weekely_days').show();
    }else if(pick_schedule=='monthly'){
       $('.weekely_days_list').prop('checked', false);
        var sub_date =$('#sub_date').val();
           $.ajax({
              url: '<?php echo site_url('subscription/get_month_dates'); ?>',
              type: 'POST',
              data: {sub_date: sub_date},
              success: function(data) {
               $('#weekely_days').hide();
               $('input[name=weekely_days]').attr("checked", false);
               $('#days_list').show();
               $('#days_list').html(data);  
              }
          });
    }else{
       // $('input[name=weekely_days]').attr("checked", false);
       $('.weekely_days_list').prop('checked', false);
       $('.monthly_days_list').prop('checked', false);
       $('#weekely_days').hide();
       $('#days_list').hide();
    }
});

</script>