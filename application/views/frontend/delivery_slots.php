<div class="address_page_delivery_type">
   <h3 class="select_deliver_address_heading">Select Delivery Slot Time</h3>
</div>
<div class="address_page_slot_time_select" id="show_time_slots">
   <ul>
      <input type="hidden" name="get_delivery_slot_time" id="get_delivery_slot_time" />
      <?php 
         if(!empty($slots)){ 
         foreach ($slots as $slot) { 
         if($slot['available']==0){ ?> 
      <li>
         <label class="address_page_radio">
         <input type="radio" name="slot_time" id="slot_time_<?php echo $slot['id']; ?>" disabled value="<?php echo $slot['slot_to']; ?>">
         <span class="address_page_normal_delivery"><?php echo $slot['slot_from']; ?> - <?php echo $slot['slot_to']; ?></span>
         </label>
      </li>
      <?php }else{ ?> 
      <li>
         <label class="address_page_radio">
         <input type="radio" name="slot_time" id="slot_time_<?php echo $slot['id']; ?>" value="<?php echo $slot['id']; ?>">
         <span class="address_page_normal_delivery"><?php echo $slot['slot_from']; ?> - <?php echo $slot['slot_to']; ?></span>
         </label>
      </li>
      <?php } } } ?>
   </ul>
</div>
<script type="text/javascript">
   $("input[name='slot_time']").change(function(){
   var delivery_slot_time = $('input[name="slot_time"]:checked').val();
    $('#get_delivery_slot_time').val(delivery_slot_time);
   });
</script>