<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Edit Measurement</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Measurement</li>
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
                 <form method="post" action="<?php echo base_url();?>admin/update_measurements/" id="update_measurements" name="update_measurements" enctype="multipart/form-data" class="custom-validation">
                     <input class="form-control" type="hidden" name="mes_id"  id="mes_id" value="<?php echo $measurements[0]['mes_id']; ?>" >
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Select Category</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="cat_id" id="cat_id" required>
                               <option value='' >Select Category</option>
                                    <?php if($category){ for($s=0; count($category)>$s; $s++){ ?> 
                                       <option value="<?php echo $category[$s]['cat_id']; ?>" <?php echo ($category[$s]['cat_id']== $measurements[0]['cat_id'])?'selected':'';?>><?php echo $category[$s]['title']; ?></option>
                              <?php } } ?>
                            </select>
                        </div>
                     </div>
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Title</label>
                        <div class="col-sm-10">
                           <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Title" value="<?php echo $measurements[0]['title']; ?>" />
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
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