<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Coupons</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Coupons</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_coupons/" >
                  <i class="mdi mdi-plus mr-2"></i> Add Coupons
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
                           <th>Name </th>
                           <th>Coupon Code </th>
                           <th>Description </th>
                           <th>Type</th>
                           <th>Discount</th>
                           <th>Image</th>
                           <th>Max Use</th>
                           <th>Start Date</th>
                           <th>End Date</th>
                           <th>Use Count</th>
                           <th class="all">Userd For</th>
                           <th class="all">Status</th>
                           <th class="all">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($coupons)>0){ $a=1; foreach($coupons as $res){ ?>
                        <tr class="row_<?php echo $a; ?>">
                           <td><?php echo $a; ?></td>
                           <td><?php echo $res['name']; ?></td>
                           <td><?php echo $res['code']; ?></td>
                           <td><?php echo $res['description']; ?></td>
                           <td>
                              <?php 
                                 $type= $res['type'];
                                 if($type=='Rs'){
                                     echo "Rs";
                                 }else{
                                    echo "%"; 
                                 }
                                 echo $type; 
                              ?>
                           </td>
                           <td><?php echo $res['discount']; ?></td>
                           <td><img class="banner_image_set" src ="<?php echo  base_url(); ?>assets/coupon_images/<?php echo $res['image']; ?>" /></td>
                           <td><?php echo $res['max_use']; ?></td>
                           <td><?php echo $res['start_date']; ?></td>
                           <td><?php echo $res['end_date']; ?></td>
                           <td><?php echo $res['use_count']; ?></td>
                           <td>
                              <?php 
                                 $use_for= $res['use_for'];
                                 echo $use_for;
                                 if($use_for=='0'){
                                     echo "All Users";
                                 }else{ ?>
                                   <a target="_blank" href="<?php echo base_url(); ?>admin/coupon_users/<?php echo $res['id'];  ?>"><button class="btn btn-info waves-effect waves-light"> View Users </button></a>
                                <?php } 
                              ?>
                            </td>
                           <?php if($res['status']=='1'){ ?>
                           <td>
                              <button type="button" class="btn btn_success waves-effect waves-light" onclick="change_coupons_status(<?php echo $res['id'];?>,'0');">Active</button>
                           </td>
                           <?php } else{ ?>
                           <td>
                              <button type="button" class="btn btn_warning waves-effect waves-light" onclick="change_coupons_status(<?php echo $res['id'];?>,'1');">Inactive</button>
                           </td>
                           <?php } ?>
                           <td>
                              <a href="<?php echo base_url(); ?>admin/edit_coupons/<?php echo $res['id'];  ?>"><button class="btn btn-info waves-effect waves-light"> Edit </button></a>
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
function change_coupons_status(docid,sta)
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
               window.location="<?php echo base_url();?>admin/change_coupons_status/"+docid+'/'+sta+'/';
       }
   });
}
</script>