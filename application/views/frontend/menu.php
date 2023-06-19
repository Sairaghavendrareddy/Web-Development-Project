<style>
   .dropdown-submenu {
   position: relative;
   }
   .dropdown-submenu a::after {
   transform: rotate(-90deg);
   position: absolute;
   right: 6px;
   top: .8em;
   }
   .dropdown-submenu .dropdown-menu {
   top: 0;
   left: 100%;
   margin-left: .1rem;
   margin-right: .1rem;
   }
</style>
<section class="ss-btm-header">
   <div class="container-fluid">
   <!-- START: RUBY DEMO HEADER -->
   <div class="ruby-menu-demo-header">
      <!-- ########################### -->
      <!-- START: RUBY HORIZONTAL MENU -->
      <div class="ruby-wrapper">
         <button class="c-hamburger c-hamburger--htx visible-xs">
         <span>toggle menu</span>
         </button>
         <ul class="ruby-menu">
            <!-- <li class=""><a href="#">Home</a></li> -->
            <li class="ruby-menu-mega-blog">
               <a href="#">Shop by Category</a>
               <div style="height: 269.359px;" class="">
                  <ul class="ruby-menu-mega-blog-nav">
                     <?php if(!empty($menu)){
                        $m=0;                       
                          foreach ($menu as $menu_list) {
                          $sub_category = json_decode($menu_list['categories'], true);
                          $brand_cat = json_decode($menu_list['brands'], true); ?>
                     <li class="<?php if($m==0){ ?>ruby-active-menu-item<?php }else{ } ?> menu_subcategory_item">
                        <a href="#"><?php  echo $menu_list['title']; ?></a>
                        <div class="ruby-grid" style="height: 264.359px;">
                           <div class="ruby-row ruby-row_total_height">
                              
                                <?php
                                if(!empty($sub_category)){
                                $sbct=array_chunk($sub_category, 5);
                                if(count($sbct)>0){
                                 foreach ($sbct as $sub_cat) { 
                                ?>
                                <div class="ruby-col-3 ruby-row_total_height_inner">
                                 <ul class="subcategory_list_items_main">
                                    <?php 
                                       foreach ($sub_cat as $sub) { 
                                       $cat_id =$sub['cat_id'];
                                       $sub_cat_id=$sub['sub_cat_id'];
                                       ?>
                                    <li class="subcategory_list_items_inner subcategory_main_heading"><a href="<?php echo base_url(); ?>product/product_list/<?php echo $cat_id; ?>/<?php echo $sub_cat_id; ?>"><?php echo $sub['title']; ?></a></li>
                                    <?php } ?>
                                 </ul>
                                 </div>
                                 <?php
                               }
                             }
                           }
                        ?>
                              
                           </div>
                        </div>
                        <span class="ruby-dropdown-toggle"></span>
                     </li>
                     <?php  $m++; } } ?>
                  </ul>
               </div>
               <span class="ruby-dropdown-toggle"></span>
            </li>
            <li class=""><a href="<?php echo base_url(); ?>product/offers">My Offers</a></li>
            <?php if($this->session->userdata('user_id')!=''){ ?>
            <li class=""><a href="<?php echo base_url(); ?>subscription">My Subscriptions</a></li>
            <?php }else{ ?>
            <li class=""> <a href="#login-modal" data-toggle="modal" data-target="#login-modal">My Subscriptions</a></li>
            <?php } ?>
            <li class=""><a href="#">About us</a></li>
            <?php if($this->session->userdata('user_id')!=''){ ?>
            <li class="ruby-menu-right icon_cart_menu">
               <a class="cart_data_onclick menu_item_hover_off" href="<?php echo base_url('profile/wishlist'); ?>" >
                  <div class="cart-ico">
                     <img src="<?php echo base_url(); ?>assets/frontend/images/wishlift.svg" />
                  </div>
                  <span>Wishlist</span>
               </a>
            </li>
            <?php }else{ ?>
            <li class="ruby-menu-right icon_cart_menu">
               <a class="cart_data_onclick menu_item_hover_off" href="#login-modal" data-toggle="modal" data-target="#login-modal">
                  <div class="cart-ico">
                     <img src="<?php echo base_url(); ?>assets/frontend/images/wishlift.svg" />
                  </div>
                  <span>Wishlist</span>
               </a>
            </li>
            <?php } ?>
            <li class="ruby-menu-right icon_cart_menu dropdown">
               <a  class="nav-link cart_data_onclick menu_item_hover_off" href="javascript:void(0);;" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                  <div class="cart-ico">
                     <img src="<?php echo base_url(); ?>assets/frontend/images/cart.svg" />
                     <span id="cart_count">
                     <?php echo count($this->cart->contents()); ?>
                     </span>
                  </div>
                  <span>Cart</span>
               </a>
               <div id="dontclose" class="dropdown-menu cart-drop-dwn cartdropdown_transform_off" aria-labelledby="navbarDropdown">
                  <div id="ajaxcart"></div>
                  <!-- <span class="ruby-dropdown-toggle"></span> -->
            </li>
         </ul>
         </div>
         <!-- END:   RUBY HORIZONTAL MENU -->
         <!-- ########################### -->
      </div>
      <!-- END: RUBY DEMO HEADER -->
   </div>
</section>
<script>
   $(".cart_data_onclick").click(function(){
       $.ajax({
           url: '<?php echo site_url("home/get_cartdata"); ?>',
           type: 'POST',
           success: function(response) {
               $('#ajaxcart').html(response);
               // $('#cart-modal').modal('show');
   
           }
       });
   });
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script type="text/javascript">
   $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
       if (!$(this).next().hasClass('show')) {
           $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
       }
       var $subMenu = $(this).next(".dropdown-menu");
       $subMenu.toggleClass('show');
   
   
       $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
           $('.dropdown-submenu .show').removeClass("show");
       });
       return false;
   });
</script>
<script>
   $('#dontclose').on("click.bs.dropdown", function (e) {                
        e.stopPropagation();
        e.preventDefault();
   });
</script>