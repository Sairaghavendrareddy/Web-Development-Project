<div class="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="float-right page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Admin</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/blocks">Back</a></li>
							<li class="breadcrumb-item active">Add Block</li>
						</ol>
					</div>
					<h5 class="page-title">Add Block</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
					<form method="post" action="<?php echo base_url(); ?>admin/save_block" id="block" name="block" enctype="multipart/form-data">
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
						<div class="card-body">
							<div class="form-group ">
							    <div class="row">
								<label for="example-text-input" class="col-sm-12 col-form-label">Block</label>
								<div class="col-sm-12">
									<input class="form-control" type="text" name="block_name" id="block_name">
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
  $("#block").validate({
  rules:{
    apartment_id:{required:true},
    block_name:{required:true},
  },
  messages:{
    apartment_id:{required:'Please select apartment'},
    block_name:{required:'Please enter block name'},
  },
  ignore: []
  });
}); 				

</script>					