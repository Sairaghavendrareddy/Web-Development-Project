<form method="post" action="<?php echo base_url(); ?>subscription/temporarly_modify_subscribe_product" id="modify_temporarily" name="modify_temporarily" onsubmit="return temporarly_modify_product();">
   <input type="hidden" name="temporarily_prod_id" id="temporarily_prod_id" value="<?php echo $pause_list[0]['prod_id']; ?>" />
   
         <div class="del-logn-cls">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
         </div>
         <div class="subscrip-indi-mdl-cnt">
            <?php foreach ($pause_list as $res) {
               $image =$res['prod_image'];
               $image_decode = json_decode($image, true);
               $img =$image_decode[0];
               ?>
            <input type="hidden" name="modify_subscription_prod_mes_id1[]" id="modify_subscription_prod_mes_id1_<?php echo $res['mes_id']; ?>" value="<?php echo $res['mes_id']; ?>" />
            <div class="subscrip-item">
               <img src="<?php echo base_url(); ?>assets/products/<?php echo $img; ?>"/>
               <div class="subscrip-item-info">
                  <h2><?php echo $res['prod_title']; ?></h2>
                  <p><?php echo $res['title']; ?></p>
                  <!-- <p>Qty : <span><?php echo $res['title']; ?></span></p> -->
                  <p>MRP : &#8377<span><?php echo $res['prod_offered_price']; ?></span></p>
                  <?php 
                     $mes_id =$res['id'];
                     $chk =$this->db->query("SELECT `subscribe_id`, `user_id`, `prod_id`, `prod_mes_id`, `qty` FROM `prod_subscriptions` WHERE `prod_mes_id`=$mes_id")->row_array(); 
                     $get_qty =$chk['qty'];
                     ?>
                  <?php if($get_qty!=''){ ?>
                  <div class="subscrip-item-qnty">
                     <div class="prodct-plsmin" id="input_div">
                        <button type="button" onclick="modify_minus('<?php echo $res['mes_id']; ?>');"><i
                           class="fas fa-minus"></i> </button>
                        <input class="plsmin-vlue temporarly_qty chck_qty_<?php echo $res['mes_id']; ?>" type="text" size="25" name="qty[]" id="qty_<?php echo $res['mes_id']; ?>" value="<?php echo $get_qty; ?>" readonly/>
                        <button type="button" onclick="modify_plus('<?php echo $res['mes_id']; ?>');"><i
                           class="fas fa-plus"></i></button>
                     </div>
                  </div>
                  <?php } else{ ?>
                  <div class="subscrip-item-qnty">
                     <div class="prodct-plsmin" id="input_div">
                        <button type="button" onclick="modify_minus('<?php echo $res['mes_id']; ?>');"><i
                           class="fas fa-minus"></i> </button>
                        <input class="plsmin-vlue temporarly_qty chck_qty_<?php echo $res['mes_id']; ?>" type="text" size="25" name="qty[]" id="qty_<?php echo $res['mes_id']; ?>" value="0" readonly/>
                        <button type="button" onclick="modify_plus('<?php echo $res['mes_id']; ?>');"><i
                           class="fas fa-plus"></i></button>
                     </div>
                  </div>
                  <?php } ?>
               </div>
            </div>
            <?php } ?>
            <div class="subscrip-item-dates">
            <h1>Select Dates</h1>
            <div class="subscrip-item-date-cnt">
               <div class="subscrip-item-date-inn">
                  <label>From Date</label>
                  <input type="text" name="modified_from_date" id="modified_from_date" placeholder="Select From">
               </div>
               <div class="subscrip-item-date-inn">
                  <label>To Date</label>
                  <input type="text" name="modified_to_date" id="modified_to_date" placeholder="Select From">
               </div>
            </div>
         </div>
         <div class="subscrip-item-sub">
            <button type="submit">Modify Temporarily</button>
         </div>
   </div>
</form>
<script>
   function modify_plus(prod_mes_id){
   	 var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
   	 var total_qty =qty + 1;	
   	 $('#qty_'+prod_mes_id).val(total_qty);
   	 $('#modify_subscription_qty').val(total_qty);
   	 $('#update_modify_subscription_qty').val(total_qty);
   }
   function modify_minus(prod_mes_id){
   	 var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
   	 var total_qty =qty - 1;
   	 if(qty==0){
   	 	return false;
   	 }else{
   	 	$('#qty_'+prod_mes_id).val(total_qty);
   	    $('#modify_subscription_qty').val(total_qty);
   	    $('#update_modify_subscription_qty').val(total_qty);
   	 }	
   	 
   }

$("#modify_temporarily").validate({
   rules:{modified_from_date:{required:true},modified_to_date:{required:true}},
   messages:{modified_from_date:{required:'Please select from date'},modified_to_date:{required:'Please select to date'}},
ignore: []
});

$('#modified_from_date').Zebra_DatePicker({
   direction: 1,
    format: 'd-m-Y',
    pair: $('#modified_to_date')
});
$('#modified_to_date').Zebra_DatePicker({
   direction: true,
    format: 'd-m-Y'
});

function temporarly_modify_product() {
    var qty = $('.temporarly_qty').val();
    // alert(qty);
    if(qty==0) {
        $.toast({heading: 'Error',text: 'Please select at least one qty...',position: 'top-right',stack: false,icon: 'error'});
        return false;
    }else{
      
    }
}

</script>