<style type="text/css">
   
</style>
<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Add Apartment</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Add Apartment</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/apartments/" >
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
                  <form method="post" action="<?php echo base_url(); ?>admin/save_apartment" id="apartments" name="apartments" enctype="multipart/form-data" class="custom-validation">
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Apartment Name</label>
                        <div class="col-sm-10">
                           <input type="text" name="apartment_name" id="apartment_name" class="form-control" required parsley-type="email" placeholder="Enter Apartment Name"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Apartment Address</label>
                        <div class="col-sm-10">
                           <input type="text" name="apartment_address" id="apartment_address" class="form-control" required placeholder="Enter Apartment Address"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Pincode</label>
                        <div class="col-sm-10">
                           <input type="text" name="apartment_pincode" id="apartment_pincode" class="form-control" required data-parsley-minlength="6" placeholder="Enter Pincode"/>
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
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