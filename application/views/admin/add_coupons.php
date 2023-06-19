<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Add Coupon</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Add Coupon</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/coupons/" >
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
                   <form method="post" action="<?php echo base_url(); ?>admin/save_coupons" id="save_coupons" name="save_coupons" enctype="multipart/form-data" class="custom-validation">
                     
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Name</label>
                        <div class="col-sm-10">
                           <input type="text" name="name" id="name" class="form-control" required placeholder="Enter Name"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Code</label>
                        <div class="col-sm-10">
                           <input type="text" name="code" id="code" class="form-control" required placeholder="Enter Code"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Desription</label>
                        <div class="col-sm-10">
                           <input type="text" name="desription" id="desription" class="form-control" required placeholder="Enter Desription"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Type</label>
                        <div class="col-sm-10">
                          <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline1" name="type" class="custom-control-input">
                              <label class="custom-control-label" for="customRadioInline1">Rs</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="type" class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline2">%</label>
                            </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Discount</label>
                        <div class="col-sm-10">
                           <input type="text" name="discount" id="discount" class="form-control" required placeholder="Enter Discount" data-parsley-type="digits"/>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Image</label>
                        <div class="col-sm-10">
                          <input type="file" name="simage"  id="simage" class="filestyle" accept=".png, .jpg, .jpeg" placeholder="Select Image" required alt="not found image" />
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Max Use</label>
                        <div class="col-sm-10">
                           <input type="text" name="max_use" id="max_use" class="form-control" required placeholder="Enter Max Use" data-parsley-type="digits"/>
                        </div>
                     </div>
                     <div class="form-group row">
                          <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Start Date</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" name="start_date" class="form-control" placeholder="Select Start Date" id="start_date">
                                  <div class="input-group-append">
                                      <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="example-time-input" class="col-sm-2 col-form-label">Coupon End Date</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" name="end_date" class="form-control" placeholder="Select End Date" id="end_date">
                                  <div class="input-group-append">
                                      <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                  </div>
                              </div><!-- input-group -->
                          </div>
                      </div>
                     <!-- <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label"> Coupon Use Count</label>
                        <div class="col-sm-10">
                           <input type="text" name="use_count" id="use_count" class="form-control" required placeholder="Enter Use Count" data-parsley-type="digits"/>
                        </div>
                     </div> -->
                      <div class="form-group row">
                        <label for="example-time-input" class="col-sm-2 col-form-label">Coupon Select Users</label>
                        <div class="col-sm-10">
                           <select class="form-control select2" name="cat_id" id="cat_id" required>
                               <option value="">Coupon Select Users</option>
                                  <?php if(count($users)>0){ foreach($users as $all_users){ ?>
                                       <option value="<?php echo $all_users['user_id']; ?>"><?php echo $all_users['name']; ?></option>
                                 <?php } } ?>
                            </select>
                        </div>
                     </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Submit</button>
                           <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/coupons/">Cancel</a>
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
  $('#start_date').Zebra_DatePicker({
  direction: true,
    format: 'd-m-Y',
    pair: $('#end_date')
});
$('#end_date').Zebra_DatePicker({
  direction: true,
    format: 'd-m-Y'
});
</script>