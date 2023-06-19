<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Edit Subscription Cancell Reason</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Subscription Cancell Reason</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/subscription_cancell_reason/" >
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
                 <form method="post" action="<?php echo base_url();?>admin/update_subscription_cancell_reason/" id="update_subscription_cancell_reason" name="update_subscription_cancell_reason" enctype="multipart/form-data" class="custom-validation">
                     <input class="form-control" type="hidden" name="id"  id="id" value="<?php echo $subscription_cancell_reason[0]['id']; ?>" >
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Title</label>
                        <div class="col-sm-10">
                           <input type="text" name="reason" id="reason" class="form-control" required placeholder="Enter Reason" value="<?php echo $subscription_cancell_reason[0]['reason']; ?>" />
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                           <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/subscription_cancell_reason/">Cancel</a>
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