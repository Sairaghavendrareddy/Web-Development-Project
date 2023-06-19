<!-- JAVASCRIPT -->
<!-- <script src="<?php echo base_url(); ?>assets/admin/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/admin/libs/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/pages/form-advanced.init.js"></script>
<div id="div_<?php echo $id;?>">
<?php
if($id>1){
?>
<div style="border:1px solid red;"></div>
<?php
}
?>

<div class="form-group row">
   <label for="example-time-input" class="col-sm-2 col-form-label"> Select Mesurement</label>
   <input type="hidden" name="prod_mes_id[]" value="<?php echo @$mes['prod_mes_id'];?>" id="mes_id_<?php echo $id;?>"/>
   <div class="col-sm-10">
      <select class="form-control select2" name="mesurement_id[]" id="mesurement_id_<?php echo $id;?>" >
         <option value="">Select Mesurement</option>
         <?php if($mesurement){ for($s=0; count($mesurement)>$s; $s++){ ?> 
         <option value="<?php echo $mesurement[$s]['mes_id']; ?>" <?php echo @($mes['mes_id']==$mesurement[$s]['mes_id'])?'selected':'';?>><?php echo $mesurement[$s]['title']; ?></option>
         <?php } } ?>
      </select>
   </div>
</div>

    <div class="form-group row">
        <label for="example-time-input" class="col-sm-2 col-form-label"> Orginal Price</label>
        <div class="col-sm-10">
           <input class="form-control" type="number" name="org_price[]" id="org_price_<?php echo $id;?>" placeholder="Enter original price" value="<?php echo @$mes['prod_org_price'];?>"  />
        </div>
     </div>
     <div class="form-group row">
        <label for="example-time-input" class="col-sm-2 col-form-label"> Offered Price</label>
        <div class="col-sm-10">
           <input class="form-control" type="number" name="offered_price[]" id="offered_price_<?php echo $id;?>" rel="<?php echo $id;?>"  value="<?php echo @$mes['prod_offered_price'];?>" placeholder="Enter offered price"  />
        </div>
     </div>
     <div class="form-group row">
        <label for="example-time-input" class="col-sm-2 col-form-label"> Available Qty</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" name="available_qty[]"  value="<?php echo @$mes['prod_available_qty'];?>" id="available_qty_<?php echo $id;?>" placeholder="Enter quantity"  />
        </div>
     </div>
    <div class="form-group row">
        <label for="example-time-input" class="col-sm-2 col-form-label"> Image <?php echo @($mes['prod_mes_id']=='')?'*':'';?></label>
        <div class="col-sm-10">
            <input class="form-control filestyle" type="file" accept=".png, .jpg, .jpeg" rel="<?php echo @($mes['prod_mes_id']=='')?1:0;?>" name="simage[][]" id="simage_<?php echo $id;?>" onchange="Upload_img(<?php echo $id;?>);" multiple>
            <?php
        if(isset($mes['prod_image'])){
            $img = json_decode($mes['prod_image'],true);
            ?>
            <img src="<?php echo base_url();?>assets/products/<?php echo $img[0];?>" width="100px" height="100px"/>
            <?php
        } 
        ?>
        </div>
     </div>





<?php
if($id>1){
?>

<!-- <div><a href="javascript:void(0);" Onclick="Add_More_Remove_Mes(<?php echo $id;?>,'rmv',<?php echo @$mes['prod_mes_id'];?>);">Remove</a></div> -->
<input data-repeater-create="" type="button" class="btn btn-danger waves-effect waves-light" Onclick="Add_More_Remove_Mes(<?php echo $id;?>,'rmv',<?php echo @$mes['prod_mes_id'];?>);" value="Remove">
<?php
}
?>
<!-- <div class="btn btn-success inner"><a href="javascript:void(0);"  Onclick="Add_More_Remove_Mes(<?php echo $id;?>,'add');">Add more</a></div> -->
<input data-repeater-create="" type="button" class="btn btn-success inner" Onclick="Add_More_Remove_Mes(<?php echo $id;?>,'add');" value="Add More">
</div>