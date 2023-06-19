<div class="page-content-wrapper ">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="float-right page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="">Admin</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/blocks">Back</a></li>
                  <li class="breadcrumb-item active">Edit Block</li>
               </ol>
            </div>
            <h5 class="page-title">Edit Block</h5>
         </div>
      </div>
      <!-- end row -->
      <div class="row">
         <div class="col-12">
            <div class="card m-b-30">
               <form method="post" action="<?php echo base_url();?>admin/update_block" id="block" name="block" enctype="multipart/form-data">
                  <div class="card-body">
                     <input class="form-control" type="hidden" name="block_id"  id="block_id" value="<?php echo $block['block_id']; ?>" >
                     <div class="form-group">
                         <div class="row">
                          <label class="col-sm-12 col-form-label">Select Apartment</label>
                          <div class="col-sm-12">
                              <select class="custom-select" name="apartment_id" id="apartment_id" >
                                  <?php if($apartments){ for($s=0; count($apartments)>$s; $s++){ ?> 
                              <option <?php if($block['apartment_id']==$apartments[$s]['apartment_id']){ echo "selected"; } else{ } ?> value="<?php echo $apartments[$s]['apartment_id']; ?>"><?php echo $apartments[$s]['apartment_name']; ?></option>
                            <?php } } ?>
                            </select>
                          </div>
                      </div>
                    </div>
                     <div class="form-group ">
                        <div class="row">
                           <label for="example-text-input" class="col-sm-12 col-form-label">Block Name</label>
                           <div class="col-sm-12">
                              <input class="form-control" type="text" name="block_name"  id="block_name" value="<?php echo $block['block_name']; ?>" >
                           </div>
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">Submit</button>
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
   $(document).ready(function() {
      $("#block").validate({
     rules: {
      block_name:{
          required:true
      },
       },
     messages: {
      block_name:{
          required:'Please enter block name'
      },
   
           },
     });
     ignore: []
   });
   
</script>