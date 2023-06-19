<script src="<?php echo  base_url(); ?>assets/js/additional-methods.min.js"></script>
<!-- <div class="page-content-wrapper "> -->
    <!-- <div class="container-fluid"> -->
       <!-- start page title -->
       <div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Add Product</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Add Product</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/products/" >
                     <i class="mdi mdi-arrow-left-bold mr-2"></i>Back
                  </a>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <form method="post" action="<?php echo base_url();?>admin/save_product" id="products" name="products" enctype="multipart/form-data" >
                        <input type="hidden" name="prod_id" value="<?php echo @$prod_id;?>"/>
                        <div class="card-body">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-sm-12 col-form-label pl-0">Category <span class="star">*</span></label>
                                        <select class="custom-select select2" name="category_id" id="category_id" Onchange="Get_Brand_Mess(this.value);">
                                            <option value='' >Select Category</option>
                                            <?php if($category){ for($s=0; count($category)>$s; $s++){ ?>
                                                <option value="<?php echo $category[$s]['cat_id']; ?>" <?php echo @($product['prod_category']==$category[$s]['cat_id'])?'selected':'';?>><?php echo $category[$s]['title']; ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="example-text-input" class="col-sm-12 col-form-label pl-0">Select Sub category <span class="star">*</span></label>
                                        <select class="form-control select2" name="sub_cat_id" id="sub_cat_id">
                                            <option value="">Select Sub Category</option>
                                            <?php
                                            if(count($sub_cat_id)>0){
                                                foreach($sub_cat_id as $cat){
                                                    ?>
                                                    <option value="<?php echo $cat['sub_cat_id'];?>" <?php echo @($cat['sub_cat_id']==$product['prod_sub_category'])?'selected':'';?>><?php echo $cat['title'];?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-sm-12 col-form-label pl-0">Brand
                                            <!--<span class="star">*</span>-->
                                        </label>
                                        <select class="custom-select select2" name="prod_brand" id="prod_brand" >
                                            <option value='' >Select Brand</option>
                                            <?php if($brands){ for($s=0; count($brands)>$s; $s++){ ?>
                                                <option value="<?php echo $brands[$s]['brand_id']; ?>" <?php echo @($product['prod_brand']==$brands[$s]['brand_id'])?'selected':'';?>><?php echo $brands[$s]['brand_title']; ?></option>
                                            <?php } } ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="example-text-input" class="col-sm-12 col-form-label pl-0">Title <span class="star">*</span></label>
                                        <input class="form-control" type="text" name="title" id="title" value="<?php echo @$product['prod_title'];?>" placeholder="Enter title">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-time-input" class="col-sm-2 col-form-label"> Is Popular</label>
                                <div class="col-sm-10 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_popular" name="is_popular" value="1" <?php echo @($product['is_popular']==1)?'checked':'';?>  />
                                    <label class="custom-control-label" for="is_popular">Is Popular</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-time-input" class="col-sm-2 col-form-label"> Is Subscription Available</label>
                                <div class="col-sm-10 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="available_subscraibe" value="1" <?php echo @($product['available_subscraibe']==1)?'checked':'';?>  />
                                    <label class="custom-control-label" for="available_subscraibe">Is Subscription Available</label>
                                </div>
                            </div>
                            <div id="mesurments_div"> <?php echo $pg;?></div>
                            <div id="combo_mes_prods" <?php echo @($product['combo_products']!='')?'':'style="display:none;';?>"><?php echo $combos;?></div>
                            <div class="abt-cnt-pdset">
                                <div class="row">
                                    <label for="example-text-input" class="col-sm-12 col-form-label">About this product <span class="star">*</span></label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" placeholder="Enter product description" name="about" id="about" placeholder="Enter title"><?php echo @$product['prod_description'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="btm_btns_set">
                            <button id="submit_button" type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?php echo base_url(); ?>admin/products"> <button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button></a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- container fluid -->
</div></div>
<!-- Page content Wrapper -->
<script>
    var cond='<?php echo $prod_id;?>';
    var cond = (cond=='' || cond==0)?true:false;
    $(document).ready(function(){
        jQuery.validator.addMethod('validPrice', function (value, element, params) {
            var rel = $(element).attr('rel');
            var org = $("#org_price_"+rel).val();
            if(parseFloat(value)<=parseFloat(org) || org==''){
                return true;
            }else{
                return false;
            }
        });
        jQuery.validator.addMethod('validImg', function (value, element, params) {
            if(parseFloat($(element).attr('rel'))==1){
                return false;
            }else{
                return true;
            }
        });
        $("#products").validate({
            rules:{
                'title':{required:true},
                'sub_cat_id':{required:true},
                'category_id':{required:true},
                'about':{required:true},
                'mesurement_id[]':{required:true},
                'org_price[]':{required:true},
                'offered_price[]':{required:true,validPrice:true},
                'available_qty[]':{required:true},
                'simage[][]':{validImg:true},
            },
            messages:{
                'title':{required:'Please enter title'},
                'sub_cat_id':{required:'Please select sucategory'},
                'mesurement_id[]':{required:'Please select mesurement'},
                'category_id':{required:'Please select category'},
                'about':{required:'Please enter product description'},
                'org_price[]':{required:'Please enter orginal price'},
                'offered_price[]':{required:'Please enter offered price','validPrice':'Offer price cannot greater than original price'},
                'available_qty[]':{required:'Please enter qty'},
                'simage[][]':{validImg:'Please select image'},
            },
            ignore: []
        });
        $("#products").submit(function(event){
            if($("#products").valid()){
                var me_ss=[];
                $('select[name="mesurement_id[]"] option:selected').each(function(){
                    if($(this).val()!=''){
                        me_ss.push($(this).val());
                    }
                });
                var final = me_ss.every(num => me_ss.indexOf(num) === me_ss.lastIndexOf(num));
                if(final == false){
                   Swal.fire('Duplicate Mesurements selected check once');
                }
                return final;
            }else{
                return false;
            }
        });
        var check = '<?php echo @$product['combo_products'];?>';
        if(check!=''){
            $(".normal_prods").hide();
        }
    });
    function Get_Brand_Mess(id){
        Get_Subcat(id);
        $("#prod_brand").html('<option value="">Select Brand</option>');
        $('.mesurement_id').html('<option value="">Select Mesurement</option>');
        $.ajax({
            type:"POST",
            dataType:"json",
            url: "<?php echo base_url(); ?>admin/Get_Brands",
            data:{'cat_id':id},
            success: function(result){
                $("#prod_brand").html(result.brand);
                $('.mesurement_id').html(result.mes);
                if(result.cat==result.ct){
                    $(".normal_prods").hide();
                    $("#combo_mes_prods").show();
                }else{
                    $("#combo_mes_prods").hide();
                    $(".normal_prods").show();
                }
            }
        });
    }
    function Add_More_Remove_Mes(id,type,mes=0){
        if(type=='add'){
            var cat_id = $("#category_id").val();
            $.ajax({
                type:"POST",
                url: "<?php echo base_url(); ?>admin/Get_Prods_MesurMents",
                data:{'id':id,'cat_id':cat_id},
                success: function(result){
                    $(".common_a").remove();
                    $("#mesurments_div").append(result);
                }
            });
        }else{
           Swal.fire({
                 text: "Are you sure want to delete?",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes'
               }).then((result) => {
                     if (result.isConfirmed) {
                         del_mes(id,mes);
                   }
               });
        }
    }
    function del_mes(id,mes){
        $("#div_"+id).remove();
        if(mes>0){
            $.ajax({
                type:"POST",
                url: "<?php echo base_url(); ?>admin/removemes",
                data:{'id':mes},
                success: function(result){}
            });
        }
    }
    function Upload_img(id){
        $("#simage_"+id).attr("rel",0);
    }
    function Get_Subcat(id){
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>admin/Get_Sub_Cat",
            data:{'id':id},
            success: function(result){
                $("#sub_cat_id").html(result);
            }
        });
    }
    function Get_Brands(id){
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>admin/Get_SubBrands",
            data:{'cat_id':id},
            success: function(result){
                $("#prod_brand").html(result);
            }
        });
    }
    function Get_Prod_Mes(id){
        var prod_id = $("#combo_prod_id_"+id).val();
        $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>admin/Get_Prod_Mes",
            data:{'prod_id':prod_id,'id':id},
            success: function(result){
               $("#combo_prod_mes_id"+id).html(result);
            }
        });
    }
    function Add_More_Prods(id,type){
        var prod_id = $("#combo_prod_id_"+id).val();
        var existed_prod_id = '<?php echo @($prod_id>0)?$prod_id:0;?>';
        if(type=='add'){
            var combo_prod_mes_id = $("#combo_prod_mes_id"+id).val();
            var select_button_text = $('#combo_prod_mes_id'+id).map(function(){
            if ($(this).val())
            return $(this).val();
            }).get();
            if (select_button_text.length > 0) {
                $.ajax({
                    type:"POST",
                    url: "<?php echo base_url();?>admin/all_product_mes",
                    data:{'id':id},
                    success: function(result){
                        $(".add_combo").remove();
                        $("#combo_mes_prods").append(result);
                    }
                });
            }else{
                alert('Select product mesurments');
            }
        }else{
            var all_ids = 
            $.ajax({
            type:"POST",
            url: "<?php echo base_url();?>admin/delete_prod_mess",
            data:{'prod_id':prod_id,'existed_prod_id':existed_prod_id},
            success: function(result){
                $("#combo_prods"+id).remove();
            }
            });
        }
    }
</script>