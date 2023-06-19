<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Edit Banner</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Banner</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/banners/" >
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
                  <form method="post" action="<?php echo base_url(); ?>admin/update_banner" id="update_banner" name="update_banner" enctype="multipart/form-data" class="custom-validation">
                     <input class="form-control" type="hidden" name="banner_id"  id="banner_id" value="<?php echo $banner[0]['banner_id']; ?>" />
                      <input class="form-control" type="hidden" name="oldpic"  id="oldpic" value="<?php echo $banner[0]['icon']; ?>" >
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Banner Title</label>
                        <div class="col-sm-10">
                           <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Banner Ttile" value="<?php echo $banner[0]['title']; ?>" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Banner Image</label>
                        <div class="col-sm-10">
                          <input type="file" name="simage"  id="simage" class="filestyle" accept=".png, .jpg, .jpeg" placeholder="Select Image" alt="not found image" />
                          <img class="banner_image_set2" src="<?php echo  base_url(); ?>assets/banners/<?php echo $banner[0]['icon']; ?>" style="margin-top:4px" alt="image" />
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                          <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/banners/">Cancel</a>
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