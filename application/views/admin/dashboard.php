<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Dashboard</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item active">Welcome to THE SOIL SON Dashboard</li>
               </ol>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row">
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/orders.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">Today Orders</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo count($today_orders); ?> <i
                        class="mdi mdi-arrow-up text-success ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/orders.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">This Week Orders</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo count($week_orders); ?> <i
                        class="mdi mdi-arrow-up text-success ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/orders.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">This Month Orders</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo count($month_orders); ?> <i
                        class="mdi mdi-arrow-up text-success ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/orders.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">Last Month Orders</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo $last_month; ?> <i
                        class="mdi mdi-arrow-down text-danger ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/orders.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">Total Orders</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo $total_orders; ?> <i
                        class="mdi mdi-arrow-up text-success ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/sale.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">Total Sale</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo $total_sales[0]['total_sales']; ?> <i class="mdi mdi-arrow-up text-success ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/soldout.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">Soldout Products</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo $sold_out ?> 
                     <i class="mdi mdi-arrow-down text-danger ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg_default text-white">
               <div class="card-body">
                  <div class="mb-4">
                     <div class="float-left mini-stat-img mr-4">
                        <img src="<?php echo base_url(); ?>assets/admin/images/services-icon/user.svg" alt="">
                     </div>
                     <h5 class="font-size-16 text-uppercase mt-0 text-white-50 min_height_38">Total Users</h5>
                     <h4 class="font-weight-medium font-size-24"><?php echo $total_users; ?> 
                      <i class="mdi mdi-arrow-up text-success ml-2"></i></h4>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end row -->
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <!-- <h4 class="card-title mb-4">Orders Status</h4> -->
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="text-center">
                                 <p class="text-muted mb-4">Failed Orders</p>
                                 <h3><?php echo $orders_failed; ?><i class="mdi mdi-arrow-down text-danger ml-2"></i></h3>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="text-center">
                                 <p class="text-muted mb-4">Canceller Orders</p>
                                 <h3><?php echo $orders_cancelled; ?> <i class="mdi mdi-arrow-down text-danger ml-2"></i></h3>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="text-center">
                                 <p class="text-muted mb-4">Delivered Orders</p>
                                 <h3><?php echo $orders_delivered; ?><i class="mdi mdi-arrow-up text-success ml-2"></i></h3>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end row -->
               </div>
            </div>
            <!-- end card -->
         </div>
      </div>
      <!-- end row -->
   </div>
   <!-- container-fluid -->
</div>
<!-- End Page-content -->