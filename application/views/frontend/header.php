<!Doctype html>
<html lang="en">
   <head>
      <link rel="icon" href="<?php echo base_url(); ?>assets/frontend/images/logo-sm.png" />
      <title>::THE SOIL SON::</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width , initial-scale=1" />
      <!---css-->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/fonts.css" />
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/fontawesome/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/style.css" />
      <link rel="stylesheet" type="text/css"
         href="<?php echo base_url(); ?>assets/frontend/css/zebra_datepicker.min.css" />
      <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/bootstrap.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/bootstrap-select.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/jquery-ui.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/ruby-custom-menu.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery.toast.css">
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.validate.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/popper.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/bootstrap-select.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/jquery.toast.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/bootbox.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/zebra_datepicker.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/nicescroll.js"></script>
      <style>
         .realod_model{
         position: absolute;
         bottom: 0;
         left: 50%;
         }
         .realod_model span {
         width: 12px;
         height: 17px;
         background: #F39C12;
         margin: 0px 2px;
         display: inline-block;
         vertical-align: middle;
         animation-name: lodering;
         animation-duration: 450ms;
         animation-iteration-count: infinite;
         animation-direction: alternate;
         -webkit-animation-name: lodering;
         -webkit-animation-duration: 450ms;
         -webkit-animation-iteration-count: infinite;
         -webkit-animation-direction: alternate;
         -moz-animation-name: lodering;
         -moz-animation-duration: 450ms;
         -moz-animation-iteration-count: infinite;
         -moz-animation-direction: alternate;
         }
         .realod_model span:nth-of-type(2) {
         animation-delay: 0.2s;
         }
         .realod_model span:nth-of-type(3) {
         animation-delay: 0.4s;
         }
         .realod_model span:nth-of-type(4) {
         animation-delay: 0.6s;
         }
         #load_data .product-box{
         width:23% !important;
         margin: 20px 1% !important;
         }
      </style>
   </head>
   <body>
      <section class="ss-top-header">
         <div class="container-fluid">
            <div class="row align-items-center">
               <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                  <div class="ss-logo">
                     <a href="<?php echo base_url(); ?>">
                     <img src="<?php echo base_url(); ?>assets/frontend/images/logo.png">
                     </a>
                  </div>
               </div>
               <div class="col-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
                  <div class="ss-serch-location">
                     <div class="ss-serch">
                        <form id="form_search" action="<?php echo site_url('product/product_list');?>" method="GET" onsubmit="return search_submit();">
                           <div class="ss-serch-inpt">
                              <input type="search" name="search" id="search" placeholder="Search for products...">
                              <button type="submit"><i class="fas fa-search"></i></button>
                           </div>
                        </form>
                        <form id="product_search" action="<?php echo site_url('product/product_details');?>" method="GET">
                           <div class="ss-serch-inpt">
                              <input type="hidden" name="prod_search" id="prod_search" placeholder="Search for products...">
                              <button type="submit"></button>
                           </div>
                        </form>
                     </div>
                     <?php
                        $user_id =$this->session->userdata('user_id');
                         if($this->session->userdata('user_id')!=''){ 
                          $chk_add =$this->db->query("SELECT `apartment_id` FROM `user_apartment_details` WHERE `user_id`=$user_id")->num_rows();
                          if(($chk_add)>0){
                          ?>
                     <div class="ss-location">
                        <div class="ss-location-cnt ">
                           <p><img src="<?php echo base_url(); ?>assets/frontend/images/location.svg" /> <?php 
                              $address =$this->db->query("SELECT t1.`user_apartment_det_id`, t1.`apartment_id`, t1.`block_id`, t1.`flat_id`, t1.`user_id`, t1.`status`, t1.`is_latest`, t2.`apartment_id`, t2.`apartment_name`, t2.`apartment_address`, t2.`apartment_pincode`  FROM `user_apartment_details` as t1 INNER JOIN apartments as t2 ON t1.`apartment_id`=t2.`apartment_id` WHERE t1.`is_latest`=1 AND t1.`user_id`=$user_id")->row_array();
                              echo $address['apartment_name'];echo $address['apartment_address'];echo $address['apartment_pincode'];echo $address['block_id'];echo $address['flat_id'];
                              ?></p>
                        </div>
                     </div>
                     <?php }else{ ?>
                     <div class="ss-location">
                        <div class="ss-location-cnt">
                           <img src="<?php echo base_url(); ?>assets/frontend/images/location.svg" />
                           <button type="button" href="#address_selection_modal"
                              data-target="#address_selection_modal" data-toggle="modal">Select Address <i class="fas fa-chevron-down"></i></button>
                        </div>
                     </div>
                     <?php } }else{ } ?>
                  </div>
               </div>
               <?php if($this->session->userdata('user_id')!=''){ ?>
               <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                  <div class="ss-profile-dd">
                     <div class="profile-dd-cnt">
                        <div class="dropdown show">
                           <a class="profile-dd-bnt dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="far fa-user"></i> 
                           <?php 
                              $user_id =$this->session->userdata('user_id');
                              $get_user_name =$this->db->query("SELECT `user_id`, `name` FROM `users` WHERE `user_id`=$user_id")->row_array();
                              echo $get_user_name['name']; ?>
                           </a>
                           <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="fas fa-user"></i> My Account</a>
                              <a class="dropdown-item" href="<?php echo base_url(); ?>home/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php 
                  }else{ ?>
               <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-2">
                  <div class="ss-login">
                     <div class="ss-login-cnt">
                        <?php if($this->session->userdata('user_id')!=''){
                           $user_id=$this->session->userdata('user_id');
                           $get_user_name=$this->db->query("SELECT `user_id`, `name` FROM `users` WHERE `user_id`=$user_id")->row_array(); ?>
                        <a href="<?php echo base_url('profile'); ?>">
                        <?php echo $get_user_name['name'];
                           ?></a> 
                        <?php }else{ ?>
                        <div class="ss-innelog">
                           <a href="#login-modal" data-toggle="modal" data-target="#login-modal"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </section>
      <?php
         $success=($this->session->flashdata('success')!='')?$this->session->flashdata('success'):((isset($success) && $success!='')?$success:'');
         $danger=($this->session->flashdata('danger')!='')?$this->session->flashdata('danger'):((isset($danger) && $danger!='')?$danger:'');
         if($success!='' || $danger!=''){
         $head=($success!='')?'Success':'Failed';
         $msg=($success!='')?$success:$danger;
         $icon=($success!='')?'success':'error';
         ?>
      <script type="text/javascript">
         $(document).ready(function(){
         $.toast({heading:'<?php echo $head;?>',text:'<?php echo strip_tags($msg);?>',position:'top-right',stack: false,icon:'<?php  echo $icon;?>'});
         });
      </script>
      <?php
         }
         ?> 
      <!-- <script src="<?php echo base_url().'assets/frontend/js/bootstrap.js'?>" type="text/javascript"></script> -->
      <script src="<?php echo base_url().'assets/frontend/js/jquery-ui.js'?>" type="text/javascript"></script>
      <script type="text/javascript">
         function search_submit(){
            var search_empty =$.trim($('#search').val());
            if(search_empty==''){
               return false;
            }
         }

         $(document).ready(function() {
             $("#search").autocomplete({
                 source: "<?php echo site_url('search/get_autocomplete/?');?>",
                 select: function(event, ui) {
                     $(this).val(ui.item.label);
                     $('#prod_search').val(ui.item.label);
                     $("#product_search").submit();
                 }
             });
         });
      </script>