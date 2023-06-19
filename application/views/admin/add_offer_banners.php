<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Add Offer Banners</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Add Offer Banners</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/offer_banners/" >
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
                  <form method="post" action="<?php echo base_url(); ?>admin/save_offer_banners" id="save_offer_banners" name="save_offer_banners" enctype="multipart/form-data" class="custom-validation">
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Select Page</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="page" id="page" required onchange="get_modules();">
                               <option value="">Select Page</option>
                               <option value="home">Home</option>
                               <option value="category">Category</option>  
                            </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Select Module</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="module" id="module" required>
                               <option value="">Select Module</option>
                            </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                           <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Title"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Image</label>
                        <div class="col-sm-10">
                          <input type="file" name="simage"  id="simage" class="filestyle" accept=".png, .jpg, .jpeg" placeholder="Select Image" required alt="image" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                           <input type="text" name="description" id="description" class="form-control" required placeholder="Enter Description"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Select Products</label>
                        <div class="col-sm-10">
                          <select class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Choose ..." name="prods[]" id="prods" required>
                               <option value="">Select Products</option>
                                   <?php if($products){ for($s=0; count($products)>$s; $s++){ ?>
                                       <option value="<?php echo $products[$s]['prod_id']; ?>"><?php echo $products[$s]['prod_title'];?>(<?php echo $products[$s]['prod_title'];?>)</option>
                                   <?php } } ?>
                            </select>
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                           <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/offer_banners/">Cancel</a>
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

<script type="text/javascript">
  function get_modules()
  {
    // $('.select2').selectpicker('refresh');
     $("#module").html('<option value="">Please Select Module</option>');
     var sel_value = $('#page').val();
          $.ajax({
             url:"<?php echo base_url();?>admin/get_offer_banner_modles",
             method:"POST",
             data:{sel_value:sel_value},
             success:function(data) {
                var parse_data = JSON.parse(data);
                $.each(parse_data,function(index,value){
                   var newOption = $('<option value="'+value.cat_id+'">'+value.title+'</option>');
                   $("#module").append(newOption);   
            });
        }
    });
  }
</script>