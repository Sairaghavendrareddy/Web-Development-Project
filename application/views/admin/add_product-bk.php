<script src="https://presentience-clients.in/soil/assets/js/jquery.validate.min.js"></script>
  <script src="https://presentience-clients.in/soil/assets/js/jquery.min.js"></script>
<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
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
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/measurements/" >
                     <i class="mdi mdi-arrow-left-bold mr-2"></i>Back
                  </a>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                    <form method="post" action="<?php echo base_url();?>admin/save_product" id="products" name="products" enctype="multipart/form-data" onsubmit="return validate()">
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Select Category</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="category_id" id="category_id" >
                               <option value="">Select Category</option>
                                 <?php if($category){ for($s=0; count($category)>$s; $s++){ ?>
                                        <option value="<?php echo $category[$s]['cat_id']; ?>" <?php echo @($product['prod_category']==$category[$s]['cat_id'])?'selected':'';?>><?php echo $category[$s]['title']; ?></option>
                                  <?php } } ?>
                            </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Select Sub Category</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="sub_cat_id" id="sub_cat_id" required>
                               <option value="">Select Sub Category</option>
                                <?php if(count($sub_cat_id)>0){ foreach($sub_cat_id as $cat){ ?>
                                        <option value="<?php echo $cat['sub_cat_id'];?>" <?php echo @($cat['sub_cat_id']==$product['prod_sub_category'])?'selected':'';?>><?php echo $cat['title'];?></option>
                                <?php } } ?>
                            </select>
                        </div>
                     </div>
                  
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Select Brand</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="prod_brand" id="prod_brand" required>
                               <option value="">Select Brand</option>
                                <?php if($brands){ for($s=0; count($brands)>$s; $s++){ ?>
                                      <option value="<?php echo $brands[$s]['brand_id']; ?>" <?php echo @($product['prod_brand']==$brands[$s]['brand_id'])?'selected':'';?>><?php echo $brands[$s]['brand_title']; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                     </div>
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Title</label>
                        <div class="col-sm-10">
                           <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Title"/>
                        </div>
                     </div>
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Is Popular</label>
                        <div class="col-sm-10 custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="is_popular" name="is_popular" value="1" <?php echo @($product['is_popular']==1)?'checked':'';?> required />
                            <label class="custom-control-label" for="is_popular">Is Popular</label>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Is Subscraibe Available</label>
                        <div class="col-sm-10 custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="available_subscraibe" value="1" <?php echo @($product['available_subscraibe']==1)?'checked':'';?> required />
                            <label class="custom-control-label" for="available_subscraibe">Is Subscraibe Available</label>
                        </div>
                     </div>
                     <div id="mesurments_div">
                          <?php echo $pg;?>
                      </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                           <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/measurements/">Cancel</a>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- end row -->    
   </div>
   <!-- container-fluid -->
</div>
<!-- End Page-content -->

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
                    bootbox.alert("<b style='color:red;'>Duplicate Mesurements selected check once</b>");
                }
                return final;
            }else{
                return false;
            }
        });
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
               text: "Are you sure want to change the status?",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes'
             }).then((result) => {
                   if (result.isConfirmed) {
                        if(result)
                        {
                            del_mes(id,mes);
                        }
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
</script>