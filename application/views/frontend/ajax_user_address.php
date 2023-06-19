<div class="ss-address-select">
   <h1>Edit Delivery Address</h1>
   <div class="ss-address-show">
      <?php 
         if(!empty($default_address)){ ?>
      <div class="ss-address-box">
         <div class="ss-address-rad">
            <label class="radio">
            <input type="radio" id="d_apartment_id" name="d_apartment_id" value="<?php echo $default_address['apartment_id']; ?>" checked>
            <span><?php echo $default_address['apartment_name']; ?>, <?php echo $default_address['apartment_address']; ?>, <?php echo $default_address['apartment_pincode']; ?>.</span>
            </label>
         </div>
         <!-- <form method="post" name="default_address_save" id="default_address_save" action="<?php echo base_url(); ?>checkout/update_user_address"> -->
         <input type="hidden" name="d_address_id" id="d_address_id" value="<?php echo $default_address['user_apartment_det_id']; ?>">
         <div class="ss-apt-info">
            <div class="ss-apt-blk">
               <input type="text" name="d_app_block_no" id="d_app_block_no" placeholder="Block No" value="<?php echo $default_address['block_id']; ?>">
            </div>
            <div class="ss-apt-flt">
               <input type="text" name="d_app_flat_no" id="d_app_flat_no" placeholder="Flat No" value="<?php echo $default_address['flat_id']; ?>">
            </div>
            <div class="ss-apt-submit">
               <label for="ajax_update_delivery_address"><i class="fas fa-arrow-right"></i></label>
               <input type="button" class="d-none" name="ajax_update_delivery_address" id="ajax_update_delivery_address" value="Submit">
            </div>
         </div>
      </div>
      <!-- </form> -->
      <?php  } ?>
   </div>
</div>

<script>
   $('#ajax_update_delivery_address').click( function() {
    var d_address_id = $('#d_address_id').val();
    var d_app_block_no =$("#d_app_block_no").val();
    var d_app_flat_no =$("#d_app_flat_no").val();
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
              $('#delivery_add_blockno').html(data['d_app_block_no']);
              $('#delivery_add_floatno').html(data['d_app_flat_no']);
              $('#delivery_add_blockno').html(data['d_app_block_no']);
              $('#delivery_add_floatno').html(data['d_app_flat_no']);
              $('#ajax_edit_delivery_address').modal('hide');
                $.toast({heading:'Success',text:'Delivery Address Updated Successfully...',position:'top-right',stack: false,icon:'success'});
           }
        }
    });
}); 
</script>