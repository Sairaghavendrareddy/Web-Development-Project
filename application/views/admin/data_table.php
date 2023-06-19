<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Apartments</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Veltrix</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                  <li class="breadcrumb-item active">Apartments</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-settings mr-2"></i> Settings
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                     <a class="dropdown-item" href="#">Action</a>
                     <a class="dropdown-item" href="#">Another action</a>
                     <a class="dropdown-item" href="#">Something else here</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="#">Separated link</a>
                  </div>
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
                        <tr>
                           <td><?php echo $a; ?></td>
                           <td><?php echo $res['apartment_name']; ?></td>
                           <td><?php echo $res['apartment_address']; ?></td>
                           <td><?php echo $res['apartment_pincode']; ?></td>
                           <td><a href="<?php echo base_url(); ?>admin/edit_apartment/<?php echo $res['apartment_id'];  ?>"><button class="save"> Edit </button></a> | <button class="delete" onclick="delete_apartment('<?php echo $res['apartment_id'];  ?>');"> Delete </button></td>
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