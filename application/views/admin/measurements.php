<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Measurements</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Measurements</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_measurements/" >
                  <i class="mdi mdi-plus mr-2"></i> Add Measurements
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
                           <th>Title </th>
                           <th>Category </th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($measurements)>0){ $a=1; foreach($measurements as $res){ ?>
                        <tr class="row_<?php echo $a; ?>">
                           <td><?php echo $a; ?></td>
                           <td><?php echo $res['title']; ?></td>
                           <td><?php echo $res['cat_title']; ?></td>
                           <?php if($res['status']=='1')
                              { ?>
                           <td><button type="button" class="btn btn_success waves-effect waves-light" onclick="change_measurements_status(<?php echo $res['mes_id'];?>,'0');">Active</button></td>
                           <?php    } else{ ?>
                           <td><button type="button" class="btn btn_warning waves-effect waves-light" onclick="change_measurements_status(<?php echo $res['mes_id'];?>,'1');">Inactive</button></td>
                           <?php }?>
                           <td><a href="<?php echo base_url(); ?>admin/edit_measurements/<?php echo $res['mes_id'];  ?>"><button class="btn btn-info waves-effect waves-light"> Edit </button></a></td>
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
function change_measurements_status(docid,sta)
{
      Swal.fire({
     text: "Are you sure want to change the status?",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes'
   }).then((result) => {
         if (result.isConfirmed) {
               window.location="<?php echo base_url();?>admin/change_measurements_status/"+docid+'/'+sta+'/';
       }
   });
}
</script>