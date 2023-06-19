<!doctype html>
<html lang="en">
   <head>
     
      <meta charset="utf-8" />
      <title>::The Soil Son::</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="The Soil Son" name="description" />
      <meta content="The Soil Son" name="author" />
      <!-- App favicon -->
      <style type="text/css">
         .active_menu{
            color: #b4c9de!important;
            background-color: #383b4e;
         }
         .active_menu i {
            color: #b4c9de!important;
         }
      </style>
       <script>
         var base_url ='<?php echo base_url(); ?>';
      </script>
      <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/images/logo-sm.png">
        <link href="<?php echo base_url(); ?>assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
      <!-- DataTables -->
      <link href="<?php echo base_url(); ?>assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url(); ?>assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
      <!-- Sweet Alert-->
      <!-- <link href="<?php echo base_url(); ?>assets/admin/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" /> -->
      <!-- Responsive datatable examples -->
      <link href="<?php echo base_url(); ?>assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
      <!-- Bootstrap Css -->
      <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="<?php echo base_url(); ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
       <link href="<?php echo base_url(); ?>assets/admin/css/zebra_datepicker.min.css" rel="stylesheet" type="text/css" />
      <script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/sweetalert2@10.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/sweetalert.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/zebra_datepicker.min.js"></script>
      <?php
       $success=($this->session->flashdata('success')!='')?strip_tags($this->session->flashdata('success')):((isset($success) && $success!='')?$success:'');
       $error=($this->session->flashdata('failed')!='')?strip_tags($this->session->flashdata('failed')):((isset($failed) && $failed!='')?$failed:'');
       $notif=($this->session->flashdata('notif')!='')?strip_tags($this->session->flashdata('notif')):((isset($notif) && $notif!='')?$notif:'');
    ?>
    <script type="text/javascript">

        $(document).ready(function(){
            <?php
            if($success!=''){
            ?>
            Swal.fire({
               icon: 'success',
               title: '<?php echo $success;?>',
            });
            
            <?php
            }
            if($error!=''){
            ?>
            Swal.fire({
                title: "<?php echo $error;?>",
                icon: "error",
            });
            <?php
            }
            if($notif!=''){
            ?>
            Swal.fire({
                title: "<?php echo $notif;?>",
                icon: "error",
            });
            <?php
            }
            ?>
        });
    </script>
   </head>
   <body data-sidebar="dark">
      <!-- Begin page -->
      <div id="layout-wrapper">
      <header id="page-topbar">
         <div class="navbar-header">
            <div class="d-flex">
               <!-- LOGO -->
               <div class="navbar-brand-box p-0">
                  <a href="index.html" class="logo top-ad-logo logo-dark">
                  <span class="logo-sm">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo.svg" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt="" height="17">
                  </span>
                  </a>
                  <a href="index.html" class="logo top-ad-logo logo-light">
                  <span class="logo-sm">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo-sm.png" alt="" height="22">
                  </span>
                  <span class="logo-lg">
                  <img src="<?php echo base_url(); ?>assets/admin/images/logo.png" alt="" height="18">
                  </span>
                  </a>
               </div>
               <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
               <i class="mdi mdi-menu"></i>
               </button>
            </div>
            <div class="d-flex">
               <div class="dropdown d-inline-block d-lg-none ml-2">
                  <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-magnify"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                     aria-labelledby="page-header-search-dropdown">
                     <form class="p-3">
                        <div class="form-group m-0">
                           <div class="input-group">
                              <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                              <div class="input-group-append">
                                 <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="dropdown d-none d-lg-inline-block">
                  <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                  <i class="mdi mdi-fullscreen"></i>
                  </button>
               </div>
               <div class="dropdown d-inline-block">
                  <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="far fa-user"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                     <!-- item-->
                     <a class="dropdown-item" href="<?php echo base_url(); ?>admin/change_password"><i class="mdi mdi-lock font-size-17 align-middle mr-1"></i> Change Password</a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item text-danger" href="<?php echo base_url(); ?>admin/logout"><i class="mdi mdi-power font-size-17 align-middle mr-1 text-danger"></i> Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- ========== Left Sidebar Start ========== -->
      <div class="vertical-menu">
         <div data-simplebar class="h-100">
            <!--- Sidemenu -->
            <div id="sidebar-menu">
               <!-- Left Menu Start -->
               <ul class="metismenu list-unstyled" id="side-menu">
                  <li class="menu-title">Menu</li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/dashboard" class="waves-effect">
                     <i class="ti-bar-chart"></i><span class="badge badge-pill badge-primary float-right"></span>
                     <span>Dashboard</span>
                     </a>
                  </li>
                  <li>
                      <a href="<?php echo base_url(); ?>admin/apartments" <?php if($active_menu=='apartments'){echo 'class="active_menu"';}?> ><i class="ti-home"></i><span>Apartments</span></a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/users" class="waves-effect">
                        <i class="ti-user"></i><span>Users</span>
                     </a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/banners" <?php if($active_menu=='banners'){echo 'class="active_menu"';}?> ><i class="ti-image"></i><span>Banners</span></a>
                     </a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/sliders"<?php if($active_menu=='slider'){echo 'class="active_menu"';}?> ><i class="ti-layout-slider-alt"></i><span>Sliders</span></a>
                     </a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/offer_banners"<?php if($active_menu=='offer_banners'){echo 'class="active_menu"';}?> ><i class="ti-layout-slider"></i><span>Offer Banners</span></a>
                  </li>
                  <li>
                     <a href="javascript: void(0);" class="has-arrow waves-effect">
                     <i class="ti-menu-alt"></i>
                     <span>Categories </span>
                     </a>
                     <ul class="sub-menu" aria-expanded="false">
                        <li>
                           <a href="<?php echo base_url(); ?>admin/category"<?php if($active_menu=='category'){echo 'class="active_menu"';}?> ></i><span>Category</span></a>
                        </li>
                        <li>
                           <a href="<?php echo base_url(); ?>admin/subcategory"<?php if($active_menu=='subcategory'){echo 'class="active_menu"';}?> ></i><span>Sub Category</span></a>
                        </li>
                     </ul>
                  </li>
                  <li>
                      <a href="<?php echo base_url(); ?>admin/brands"<?php if($active_menu=='brand'){echo 'class="active_menu"';}?> ><i class="ti-layout-grid2"></i><span>Brands</span></a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/measurements"<?php if($active_menu=='measurements'){echo 'class="active_menu"';}?> ><i class="ti-ruler-pencil"></i><span>Measurements</span></a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/products"<?php if($active_menu=='products'){echo 'class="active_menu"';}?> ><i class="ti-bag"></i><span>Products</span></a>
                  </li>
                  <!-- <li>
                     <a href="<?php echo base_url(); ?>admin/combos" class="waves-effect">
                        <i class="ti-home"></i><span>Combos</span>
                     </a>
                  </li> -->
                  <li>
                     <a href="<?php echo base_url(); ?>admin/coupons"<?php if($active_menu=='coupons'){echo 'class="active_menu"';}?> ><i class="ti-receipt"></i><span>Coupons</span></a>
                  </li>
                  <!-- <li>
                     <a href="<?php echo base_url(); ?>admin/subscription_cancell_reason" class="waves-effect">
                        <i class="ti-home"></i><span>Subscription Cancell Reason</span>
                     </a>
                  </li> -->
                  <li>
                      <a href="<?php echo base_url(); ?>admin/delivery_slots"<?php if($active_menu=='delivery_slots'){echo 'class="active_menu"';}?> ><i class="ti-truck"></i><span>Delivery Slots</span></a>
                  </li>
                  <li>
                     <a href="<?php echo base_url(); ?>admin/orders"<?php if($active_menu=='orders'){echo 'class="active_menu"';}?> ><i class="ti-shopping-cart-full"></i><span> Orders</span></a>
                  </li>
                  <li>
                      <a href="<?php echo base_url(); ?>admin/qrcodes"<?php if($active_menu=='qrcodes'){echo 'class="active_menu"';}?> ><i class="ti-layout-sidebar-right"></i><span> Product Barcodes</span></a>
                  </li>
               </ul>
            </div>
            <!-- Sidebar -->
         </div>
      </div>
      <!-- Left Sidebar End -->