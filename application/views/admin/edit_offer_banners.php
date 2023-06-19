<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Edit Offer Banners</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Offer Banners</li>
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
                  <form method="post" action="<?php echo base_url(); ?>admin/update_offer_banners" id="update_offer_banners" name="update_offer_banners" enctype="multipart/form-data" class="custom-validation">
                    <input class="form-control" type="hidden" name="id"  id="id" value="<?php echo $offer_banners['id']; ?>" />
                     <input class="form-control" type="hidden" name="oldpic"  id="oldpic" value="<?php echo $offer_banners['image']; ?>" >
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Select Page</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="page" id="page" required onchange="get_modules();">
                               <option value="">Select Page</option>
                               <option value="home"<?php if($offer_banners['page'] == 'home') { ?> selected="selected"<?php } ?>>Home</option>
                              <option value="category"<?php if($offer_banners['page'] == 'category') { ?> selected="selected"<?php } ?>>Category</option>
                            </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Select Module</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="module" id="module" required>
                                 <option value="">Select Category</option>
                                 <?php if($offer_banners['module']=='products' || $offer_banners['module']=='deal' || $offer_banners['module']=='best' || $offer_banners['module']=='subc' || $offer_banners['module']=='offer'){ ?>
                                      <option value="products"<?php if($offer_banners['module'] == 'products') { ?> selected="selected"<?php } ?>>products</option>
                                      <option value="deal"<?php if($offer_banners['module'] == 'deal') { ?> selected="selected"<?php } ?>>deal</option>
                                      <option value="best"<?php if($offer_banners['module'] == 'best') { ?> selected="selected"<?php } ?>>best</option>
                                      <option value="subc"<?php if($offer_banners['module'] == 'subc') { ?> selected="selected"<?php } ?>>subc</option>
                                      <option value="offer"<?php if($offer_banners['module'] == 'offer') { ?> selected="selected"<?php } ?>>offer</option>
                                 <?php }else{
                                    if(count($category)>0){ foreach($category as $cat){ ?>
                                    <option value="<?php echo $cat['cat_id'];?>" <?php echo ($cat['cat_id']==$offer_banners['module'])?'selected':'';?>><?php echo $cat['title'];?></option>
                              <?php } } ?>
                                <?php } ?>

                                 
                            </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Title</label>
                        <div class="col-sm-10">
                           <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Title" value="<?php echo $offer_banners['title']; ?>" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Image</label>
                        <div class="col-sm-10">
                          <input type="file" name="simage"  id="simage" class="filestyle" accept=".png, .jpg, .jpeg" placeholder="Select Image" alt="image" />
                          <img class="banner_image_set2"  src="<?php echo  base_url(); ?>assets/banners/<?php echo $offer_banners['image']; ?>" style="margin-top:4px" alt="image" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                           <input type="text" name="description" id="description" class="form-control" required placeholder="Enter Description" value="<?php echo $offer_banners['description']; ?>" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Select Products</label>
                        <div class="col-sm-10">
                          <select class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Choose ..." name="prods[]" id="prods" required>
                               <option value="">Select Products</option>
                                <?php 
                                   if($products){ for($s=0; count($products)>$s; $s++){ ?>
                                    <option <?php if (in_array($products[$s]['prod_id'], $arr_prods)){ echo "selected"; }else{ } ?> value="<?php echo $products[$s]['prod_id']; ?>"><?php echo $products[$s]['prod_title'];?>(<?php echo $products[$s]['prod_title'];?>)</option>
                                <?php } } ?>
                            </select>
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
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
    $("#module").html('<option value="">Please Select Module</option>');
    // $('.select2').selectpicker('refresh');
     var sel_value = $('#page').val();
          $.ajax({
             url:"<?php echo base_url();?>admin/get_offer_banner_modles",
             method:"POST",
             data:{sel_value:sel_value},
             success:function(data) {
                var parse_data = JSON.parse(data);
                $.each(parse_data,function(index,value){
                  // alert(value.title);
                   var newOption = $('<option value="'+value.cat_id+'">'+value.title+'</option>');
                   $("#module").append(newOption);   
            });
        }
    });
  }
</script>