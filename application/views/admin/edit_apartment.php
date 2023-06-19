<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Edit Apartment</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Apartment</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/apartments/" >
                     <i class="mdi mdi-arrow-left-bold mr-2"></i>Back
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                     <a class="dropdown-item" href="#">Action</a>
                     <a class="dropdown-item" href="#">Another action</a>
                     <a class="dropdown-item" href="#">Something else here</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="#">Separated link</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <form method="post" action="<?php echo base_url(); ?>admin/update_apartment" id="apartments" name="apartments" enctype="multipart/form-data" class="custom-validation">
                     <input class="form-control" type="hidden" name="apartment_id"  id="apartment_id" value="<?php echo $apartment['apartment_id']; ?>" />
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Apartment Name</label>
                        <div class="col-sm-10">
                           <input type="text" name="apartment_name" id="apartment_name" class="form-control" required placeholder="Enter Apartment Name" value="<?php echo $apartment['apartment_name']; ?>" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Apartment Address</label>
                        <div class="col-sm-10">
                           <input type="text" name="apartment_address" id="apartment_address" class="form-control" required placeholder="Enter Apartment Address" value="<?php echo $apartment['apartment_address']; ?>" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Pincode</label>
                        <div class="col-sm-10">
                           <input type="text" name="apartment_pincode" id="apartment_pincode" class="form-control" required data-parsley-minlength="6" placeholder="Enter Pincode" value="<?php echo $apartment['apartment_pincode']; ?>" />
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                          <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/apartments/">Cancel</a>
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