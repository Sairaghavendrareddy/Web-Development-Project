<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Apartments</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Apartments</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_apartment/" >
                     <i class="mdi mdi-plus mr-2"></i> Add Apartment
                  </a>
               </div>
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
                           <th>Apartment Name </th>
                           <th>Apartment Address </th>
                           <th>Pincode</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                       <?php if(count($apartments)>0){ $a=1; foreach($apartments as $res){ ?>
                        <tr class="row_<?php echo $a; ?>">
                           <td><?php echo $a; ?></td>
                           <td><?php echo $res['apartment_name']; ?></td>
                           <td><?php echo $res['apartment_address']; ?></td>
                           <td><?php echo $res['apartment_pincode']; ?></td>
                           <td><a href="<?php echo base_url(); ?>admin/edit_apartment/<?php echo $res['apartment_id'];  ?>"><button class="btn btn-info waves-effect waves-light"> Edit </button></a> | 
                              <button type="button" class="btn btn-danger waves-effect waves-light" onclick="delete_apartment('<?php echo $res['apartment_id'];  ?>','<?php echo $a; ?>');">Delete</button>
                           </td>
                        </tr>
                        <?php $a++; } } ?>
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
function delete_apartment(apartment_id,row_id)
{
      Swal.fire({
     title: 'Are you sure?',
     text: "You won't be able to revert this!",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes, delete it!'
   }).then((result) => {
         if (result.isConfirmed) {
               $.ajax({
                    url: '<?php echo site_url('admin/delete_apartment'); ?>',
                    type: 'POST',
                    data: {apartment_id: apartment_id},
                    success: function(data)
                    {
                        if(data==1){
                              Swal.fire(
                              'Deleted!',
                              'Your file has been deleted.',
                              'success'
                            )
                              $('.row_'+row_id).remove();
                           }else{
                              alert('failed');
                           }
                    }
            });
       }
   });
}
</script>