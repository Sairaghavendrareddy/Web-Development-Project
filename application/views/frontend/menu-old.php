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
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if(!empty($menu)){
                        foreach ($menu as $menu_list) {
                           $sub_category = json_decode($menu_list['categories'], true);
                           $brand_cat = json_decode($menu_list['brands'], true);
                           echo $menu_list['title']; ?><br>
                            <?php  } }
                       // echo "<pre>";print_r($sub_category);exit;
                        ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php 
                            foreach ($sub_category as $sub) { 
                                $cat_id =$sub['cat_id'];
                                $sub_cat_id=$sub['sub_cat_id'];
                                ?>
                            <li>
                                <a href="<?php echo base_url(); ?>product/product_list/<?php echo $cat_id; ?>/<?php echo $sub_cat_id; ?>"><?php echo $sub['title']; ?></a>

                            </li><?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">My Subscriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Customer Service</a>
                    </li>
                </ul>
                <ul class="navbar-nav ryt-mnu my-2 my-lg-0">
                   
                    <li class="nav-item dropdown">
                        <a class="cart_data_onclick nav-link" href="javascript:void(0);;" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="cart-ico">
                                <img src="<?php echo base_url(); ?>assets/frontend/images/cart.svg" />
                                <span id="cart_count">
                                    <?php echo count($this->cart->contents()); ?>
                                </span>
                            </div>
                            <span>Cart</span>
                        </a>
                        <div id="dontclose" class="dropdown-menu cart-drop-dwn" aria-labelledby="navbarDropdown">
                       
                    <div id="ajaxcart"></div>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="cart-ico">
                                <img src="
                              <?php echo base_url(); ?>assets/frontend/images/wishlift.svg" />
                            </div>
                            <span>Wishlist</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
