<div class="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="float-right page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Admin</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/flats">Back</a></li>
							<li class="breadcrumb-item active">Add Flat</li>
						</ol>
					</div>
					<h5 class="page-title">Add Flat</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
					<form method="post" action="<?php echo base_url(); ?>admin/save_flat" id="flat" name="flat" enctype="multipart/form-data">
						<div class="form-group ">
                          <label class="col-sm-12 col-form-label">Select Apartment <span class="star">*</span></label>
                          <div class="col-sm-12">
                              <select class="custom-select" name="apartment_id" id="apartment_id" >
                                  <option value='' >Please select Apartment</option>
                                  <?php if($apartments){ for($s=0; count($apartments)>$s; $s++){ ?> 
                                    <option value="<?php echo $apartments[$s]['apartment_id']; ?>"><?php echo $apartments[$s]['apartment_name']; ?></option>
                               <?php } } ?>
                                  
                              </select>
                          </div>
                         </div>
                         <div class="form-group ">
                        <div class="row">
                          <label class="col-sm-12 col-form-label">Select Block <span class="star">*</span></label>
                          <div class="col-sm-12">
                              <select class="custom-select" name="block_id" id="block_id" >
                                  <option value='' >Please select Block</option>
                              </select>
                          </div>
                          </div>
                      </div>
                         <!-- <div class="form-group ">
                          <label class="col-sm-12 col-form-label">Select Block <span class="star">*</span></label>
                          <div class="col-sm-12">
                              <select class="custom-select" name="block_id" id="block_id" >
                                  <option value='' >Please select Apartment</option>
                                  <?php if($blocks){ for($s=0; count($blocks)>$s; $s++){ ?> 
                                    <option value="<?php echo $blocks[$s]['block_id']; ?>"><?php echo $blocks[$s]['block_name']; ?></option>
                               <?php } } ?>
                                  
                              </select>
                          </div>
                         </div> -->
						<div class="card-body">
							<div class="form-group ">
							    <div class="row">
								<label for="example-text-input" class="col-sm-12 col-form-label">Flat</label>
								<div class="col-sm-12">
									<input class="form-control" type="text" name="flat_name" id="flat_name">
								</div>
							</div></div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>	
$(document).ready(function(){
  $("#flat").validate({
  rules:{
    apartment_id:{required:true},
    block_id:{required:true},
    flat_name:{required:true},
  },
  messages:{
    apartment_id:{required:'Please select apartment'},
    block_id:{required:'Please select block'},
    flat_name:{required:'Please enter flat name'},
  },
  ignore: []
  });
}); 				

 $('#apartment_id').change(function(){
      var apartment_id = $(this).val();
      $.ajax({
          url:'<?=base_url()?>admin/getproduct_lists',
          method: 'post',
          data: {apartment_id: apartment_id},
          dataType: 'json',
          success: function(response){
            $('#block_id').find('option').not(':first').remove();
            $('#product_id').find('option').not(':first').remove();
            $.each(response,function(index,data){
               $('#block_id').append('<option value="'+data['block_id']+'">'+data['block_name']+'</option>');
            });
          }
     });
   }); 
</script>					