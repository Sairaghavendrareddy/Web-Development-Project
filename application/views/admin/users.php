<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Users List</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Users List</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Name </th>
                           <th>Email Id </th>
                           <th>Phone No</th>
                           <th>Profile Image</th>
                           <th>Registered Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                       
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->
   </div>
   <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>

    $(document).ready(function(){
        $('#datatable').DataTable({
            "order": [[ 1, "desc" ]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":  "<?php echo base_url();?>admin/get_users",
                "data": function (d) {}
            }
        });
    });

</script>