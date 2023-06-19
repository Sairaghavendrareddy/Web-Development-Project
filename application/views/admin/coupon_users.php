<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Coupons Available Users</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Coupons Available  Users</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <!-- <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_coupons/" >
                  <i class="mdi mdi-plus mr-2"></i> Add Coupons
                  </a>
               </div>
            </div> -->
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
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($coupon_users)>0){ $a=1; $users_id =json_decode($coupon_users['use_for']);
                                foreach($users_id as $res){ 
                                  $user =$res;
                                  $get_user =$this->db->query("SELECT `user_id`, `name` FROM `users` WHERE `user_id`=$user")->row_array();
                            ?>
                        <tr>
                           <td><?php echo $a; ?></td>
                           <td><?php echo $get_user['name']; ?></td>
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
