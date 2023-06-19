<?php
$id=$sno;
?>
<div class="ajx_prd_cmbo" id="combo_prods<?php echo $id;?>">
    <div class="form-group row">
    <label for="example-time-input" class="col-sm-2 col-form-label"> Select Product</label>
    <div class="col-sm-10">
        <select class="form-control select2 combo_prod_id" name="combo_prod_id[]" id="combo_prod_id_<?php echo $id;?>" Onchange="Get_Prod_Mes(<?php echo $id;?>)">
            <option value="">Select Product</option>
            <?php if($prods){ for($s=0; count($prods)>$s; $s++){ ?> 
            <option value="<?php echo $prods[$s]['prod_id']; ?>" <?php echo @($prods[$s]['prod_id']==$pid)?'selected':'';?>><?php echo $prods[$s]['prod_title']; ?></option>
            <?php } } ?>
        </select>
    </div>
    </div>
    <div class="form-group row">
    <label for="example-time-input" class="col-sm-2 col-form-label"> Select Product Measurements</label>
    <div class="col-sm-10">
        <select class="form-control select2 combo_prod_mes_id" name="combo_prod_mes_id[]" id="combo_prod_mes_id<?php echo $id;?>" multiple >
        <?php 
            if(!empty($mes)){ 
                for($s=0; count($mes)>$s; $s++){ 
                ?> 
                    <option value="<?php echo $mes[$s]['prod_mes_id']; ?>" <?php echo @in_array($mes[$s]['prod_mes_id'],$prod_mes_id)?'selected':'';?>><?php echo $mes[$s]['title']; ?></option>
                <?php 
                }
            } 
        ?>
        </select>
    </div>
    </div>
    <?php
    $inc = $id;
    if($id>0){
    ?>
    <input data-repeater-create="" type="button" class="btn btn-danger inner combo_prods" Onclick="Add_More_Prods(<?php echo $inc;?>,'rmv');" value="Remove">
    <?php
    }
    ?>
</div>
<?php
//if($type==1){
?>
<div class="cmbo_add_sec">
<input data-repeater-create="" type="button" class="btn btn-success inner combo_prods add_combo" Onclick="Add_More_Prods(<?php echo $inc;?>,'add');" value="Add More">
</div>
<?php
//}
?>