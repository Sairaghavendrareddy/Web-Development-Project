<div class="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="float-right page-breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Admin</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/locations">Back</a></li>
							<li class="breadcrumb-item active">Add Location</li>
						</ol>
					</div>
					<h5 class="page-title">Add Location</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card m-b-30">
					<form method="post" action="<?php echo base_url(); ?>admin/save_location" id="location" name="location" enctype="multipart/form-data">
						<div class="card-body">
							<div class="form-group ">
							    <div class="row">
								<label for="example-text-input" class="col-sm-12 col-form-label">Location</label>
								<div class="col-sm-12">
									<input class="form-control" type="text" name="title" id="title">
								</div>
							</div></div>
							<div class="form-group ">
                        <div class="row">
                           <label for="example-text-input" class="col-sm-12 col-form-label"> Image</label>
                           <div class="col-sm-12">
                              <input class="form-control" type="file" name="simage"  id="simage">
                           </div>
                        </div>
                     </div>
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
$("#location").validate({
rules:{title:{required:true},simage:{required:true}},
messages:{title:{required:'Please enter location'},simage:{required:'Please select image'}},
ignore: []
});
});
</script>					