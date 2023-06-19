<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Edit Delivery Slots</h4>
               <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Delivery Slots</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/delivery_slots/" >
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
                   <form method="post" action="<?php echo base_url(); ?>admin/update_delivery_slots" id="update_delivery_slots" name="update_delivery_slots" enctype="multipart/form-data" class="custom-validation" onsubmit="return validate()">
                     <input class="form-control" type="hidden" name="id" id="id" value="<?php echo $delivery_slots[0]['id']; ?>" />
                    <div class="form-group row">
                          <label for="example-time-input" class="col-sm-2 col-form-label">Slot From</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" name="slot_from" class="form-control" placeholder="Select Hours" id="slot_from" required value="<?php echo $delivery_slots[0]['slot_from']; ?>" />
                                  <div class="input-group-append">
                                      <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="example-time-input" class="col-sm-2 col-form-label">Slot To</label>
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <input type="text" name="slot_to" class="form-control" placeholder="Select Mintus" id="slot_to" required value="<?php echo $delivery_slots[0]['slot_to']; ?>" />
                                  <div class="input-group-append">
                                      <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                     <div class="form-group mb-0">
                        <div>
                           <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                           <a class="btn btn-danger waves-effect waves-light" href="<?php echo base_url(); ?>admin/delivery_slots/">Cancel</a>
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
$('#slot_from').Zebra_DatePicker({
    format: 'H:i:s A'
});
$('#slot_to').Zebra_DatePicker({
    format: 'H:i:s A'
});
function validate(){
    var slot_from =$('#slot_from').val();
    var slot_to =$('#slot_to').val();
    //convert both time into timestamp

}
</script>