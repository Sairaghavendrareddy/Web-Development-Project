<script src="<?php echo  base_url(); ?>assets/js/additional-methods.min.js"></script>
<div class="page-content-wrapper ">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="float-right page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="">Admin</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/products/">Back</a></li>
                  <li class="breadcrumb-item active">Add Product</li>
               </ol>
            </div>
            <h5 class="page-title">Add Product</h5>
         </div>
      </div>
      <!-- end row -->
      <div class="row">
         <div class="col-12">
            <div class="card m-b-30">
               <form method="post" action="<?php echo base_url();?>admin/save_product" id="products" name="products" enctype="multipart/form-data" onsubmit="return validate()">
                  <div class="card-body">
                     <div class="form-group ">
                        <div class="row">
                           <label for="example-text-input" class="col-sm-12 col-form-label">Title <span class="star">*</span></label>
                           <div class="col-sm-12">
                              <input class="form-control" type="text" name="title" id="title">
                           </div>
                        </div>
                     </div>
                      <div class="form-group ">
                        <div class="row">
                          <label class="col-sm-12 col-form-label">Select Category <span class="star">*</span></label>
                          <div class="col-sm-12">
                              <select class="custom-select" name="category_id" id="category_id" Onchange="Get_Brand_Mess(this.value);">
                                  <option value='' >Please select Category</option>
                                  <?php if($category){ for($s=0; count($category)>$s; $s++){ ?> 
                                    <option value="<?php echo $category[$s]['cat_id']; ?>"><?php echo $category[$s]['title']; ?></option>
                               <?php } } ?>
                                  
                              </select>
                          </div>
                          </div>
                      </div>
                      <div class="form-group ">
                        <div class="row">
                          <label class="col-sm-12 col-form-label">Select Brand <span class="star">*</span></label>
                          <div class="col-sm-12">
                              <select class="custom-select" name="prod_brand" id="prod_brand" >
                                  <option value='' >Please select Brand</option>
                                  <?php if($category){ for($s=0; count($category)>$s; $s++){ ?> 
                                    <option value="<?php echo $category[$s]['cat_id']; ?>"><?php echo $category[$s]['title']; ?></option>
                               <?php } } ?>
                                  
                              </select>
                          </div>
                          </div>
                      </div>
                     <div id="mesurments_div">
                        <?php echo $pg;?>
                     </div>
                     <button id="submit_button" type="submit" class="btn btn-primary">Submit</button>
               </form>
               </div>
            </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->
   </div>
   <!-- container fluid -->
</div>
<!-- Page content Wrapper -->
<script>

$(document).ready(function(){
  $("#products").validate({
  rules:{
    title:{required:true},
    mesurement_id:{required:true},
    category_id:{required:true},
    org_price:{required:true},
    offered_price:{required:true},
    available_qty:{required:true},
    available_locations:{required:true},
    simage:{required:true},
  },
  messages:{
    title:{required:'Please enter title'},
    mesurement_id:{required:'Please select mesurement'},
    category_id:{required:'Please select category'},
    org_price:{required:'Please enter orginal price'},
    offered_price:{required:'Please enter offered price'},
    available_qty:{required:'Please enter qty'},
    available_locations:{required:'Please enter location'},
    simage:{required:'Please select image'},
  },
  ignore: []
  });
});  
function Get_Brand_Mess(id){
   Get_Subcat(id);
}
function Add_More_Remove_Mes(id,type){
   $.ajax({
   type:"POST",
   url: "<?php echo base_url(); ?>admin/Get_Prods_MesurMents",
   data:{'id':id},
   success: function(result){
      $(".common_a").remove();
      $("#mesurments_div").append(result);
   }
   });
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
</script>