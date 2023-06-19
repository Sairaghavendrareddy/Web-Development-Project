 <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="float-right page-breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="">Admin</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/locations">Back</a></li>
                                            <li class="breadcrumb-item active">Edit Location</li>
                                        </ol>
                                    </div>
                                    <h5 class="page-title">Edit Location</h5>
                                </div>
                            </div>
                            <!-- end row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
									<form method="post" action="<?php echo base_url();?>admin/update_location" id="location_formvalidation" name="location_formvalidation" enctype="multipart/form-data">
                                        <div class="card-body">
                                        <input class="form-control" type="hidden" name="loc_id"  id="loc_id" value="<?php echo $location[0]['loc_id']; ?>" >
                                            <input class="form-control" type="hidden" name="oldpic"  id="oldpic" value="<?php echo $location[0]['icon']; ?>" >
                                            <div class="form-group ">
                                                <div class="row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Location Name</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" name="title"  id="title" value="<?php echo $location[0]['title']; ?>" >
                                                </div>
                                            </div></div>
											<div class="form-group ">
											    <div class="row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label"> Image</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" name="simage"  id="simage">
                                                    <img height="50px" width="50px" src="<?php echo  base_url(); ?>assets/location/<?php echo $location[0]['icon']; ?>" style="margin-top:4px"/>
                                                </div>
												
                                            </div></div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
											</form>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
            
                        </div><!-- container fluid -->

                    </div> <!-- Page content Wrapper -->
<script>					
$(document).ready(function() {
   $("#location_formvalidation").validate({
  rules: {
	  title:{
		  required:true
	  },
    },
  messages: {
	  title:{
		  required:'Please enter location name'
	  },

        },
  });
  ignore: []
});

</script>					