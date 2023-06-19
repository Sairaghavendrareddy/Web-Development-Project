<?php
if($days_count!=''){
for ($x = 1; $x <= $days_count; $x++) { ?>
<input type="checkbox" class="monthly_days_list" name="days_list[]" value="<?php echo $x; ?>"><?php echo $x; ?>
<?php } }
?>