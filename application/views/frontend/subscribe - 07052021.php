<section class="ss-breadcrumb">
    <div class="container">
        <div class="ss-breadcrumb-cnt">
            <ul>
                <li><a href="#">Home</a></li>
                <li class="nxt-arw"><i class="fas fa-caret-right"></i></li>
                <li class="active">Product</li>
            </ul>
        </div>
    </div>
</section>
<section class="ss-product-view">
    <form name="save_subscription" id="save_subscription" method="post"
        action="<?php echo base_url(); ?>product/save_subscription">
        <div class="container">
            <?php if(!empty($subscribe)){
            $prdo_decode =$subscribe['prod_mesurements'];
            $prdo_details = json_decode($prdo_decode, true);
             // echo"<pre>";print_r($prdo_details);exit;
            foreach ($prdo_details as $subscribe_list) { 
               $img =json_decode($subscribe_list['prod_image'], true);
               // echo"<pre>";print_r($img);exit;
               ?>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                    <div class="ss-product-view-slide">
                        <img class="product-view-pht"
                            src="<?php echo base_url(); ?>assets/products/<?php echo $img[0]; ?>" />
                    </div>
                </div>
                <div class="col-4 col-sm-12 col-md-7 col-lg-4 col-xl-4">
                    <div class="product-info-view">
                        <div class="product-info-top">
                            <input type="text" name="prod_id[]" value="<?php echo $subscribe_list['prod_id']; ?>">
                            <input type="text" name="prod_mes_id[]"
                                value="<?php echo $subscribe_list['prod_mes_id']; ?>">
                            <h1><?php echo $subscribe['prod_title']; ?></h1>
                            <div class="product-view-prc">
                                <ul>
                                    <li>
                                        <div class="viw-act-prc">MRP: RS
                                            <span><?php echo $subscribe_list['prod_org_price']; ?></span>
                                        </div>
                                        <div class="viw-dis-prc">Our Price: RS <span
                                                class="price_<?php echo $subscribe_list['prod_mes_id']; ?>"><?php echo $subscribe_list['prod_offered_price']; ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="product-addcrt">
                                <div class="product-addcrt-lb">
                                    <h5>Pack Sizes <span class="float-right">:</span></h5>
                                </div>
                                <div class="prodct-bx-wt">
                                    <span><?php echo $subscribe_list['title']; ?></span>
                                </div>
                            </div>
                            <div class="product-addcrt">
                                <!-- <div class="product-addcrt-lb">
                        <h5>Quantity <span class="float-right">:</span></h5>
                     </div> -->
                                <div class="prod-vw-qnt-set">
                                    <input type="text" class="plus_amount" name="plus_amount[]"
                                        id="plus_amount_<?php echo $subscribe_list['prod_mes_id']; ?>" value="0">
                                    <div class="prod-vw-qnt-view" id="input_div">
                                        <label class="viw-plsmin-btn" for="moins_<?php echo $subscribe_list['prod_mes_id']; ?>"><i class="fas fa-minus"></i></label>
                                        <input class="d-none" type="button" value="-"
                                            id="moins_<?php echo $subscribe_list['prod_mes_id']; ?>"
                                            onclick="minus('<?php echo $subscribe_list['prod_mes_id']; ?>')">
                                        <input
                                            class="viw-plsmin-vlue chck_qty_<?php echo $subscribe_list['prod_mes_id']; ?>"
                                            type="text" name="chck_qty[]" size="25" value="0" readonly>
                                        <label class="viw-plsmin-btn" for="plus_<?php echo $subscribe_list['prod_mes_id']; ?>"><i class="fas fa-plus"></i></label>
                                        <input class="d-none" type="button" value="+"
                                            id="plus_<?php echo $subscribe_list['prod_mes_id']; ?>"
                                            onclick="plus('<?php echo $subscribe_list['prod_mes_id']; ?>')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
        <section style="text-align: center;">
            <h4>TotalPayment per Day:<input type="text" name="pay_amount" id="pay_amount" value=""></h4>
            <input type="text" name="sub_from_date" id="sub_from_date" placeholder="Select From Date"><br>
            <input type="text" name="sub_to_date" id="sub_to_date" placeholder="Select To Date"><br>
            <input type="submit" name="add_subscription" id="add_subscription" value="Add Subscription">
        </section>
    </form>
    </div>
</section>

<script src="<?php echo base_url(); ?>assets/frontend/js/zebra_datepicker.js"></script>
<script>
$('#sub_from_date,#sub_to_date').Zebra_DatePicker({
    direction: 1
});
</script>
<script>
function plus(prod_mes_id) {
    var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var price = parseInt($('.price_' + prod_mes_id).html());
    $('.chck_qty_' + prod_mes_id).val(qty + 1);
    var get_qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var pay_amount = get_qty * price;
    $('#plus_amount_' + prod_mes_id).val(pay_amount);
    // $('#pay_amount').val(pay_amount);
    var values = 0;
    $("input[name='plus_amount[]']").each(function() {
        // values.push($(this).val());
        values =values+parseInt(($(this).val()));
    });
   $('#pay_amount').val(values);
}

function minus(prod_mes_id) {
    var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var price = parseInt($('.price_' + prod_mes_id).html());
    if (qty >= 1) {
        $('.chck_qty_' + prod_mes_id).val(qty - 1);
        var get_qty = parseInt($('.chck_qty_' + prod_mes_id).val());
        var pay_amount = get_qty * price;
        $('#plus_amount_' + prod_mes_id).val(pay_amount);
        // $('#pay_amount').val(pay_amount);
        // calTotal();  
            var values = 0;
            $("input[name='plus_amount[]']").each(function() {
                // values.push($(this).val());
                values =values+parseInt(($(this).val()));
            });
           $('#pay_amount').val(values);
    } else {

    }

}

function calTotal() {
    var pay_amount1 = $('.plus_amount').val();
    // alert(pay_amount1);
    $('#pay_amount').html(pay_amount1);
}

//    $('#add_subscription').click( function() {
//       var from_date =$("#sub_from_date").val();
//       var to_date =$("#sub_to_date").val();
//       var chck_qty =$(".chck_qty").val();
//       if(from_date =='' || to_date==''){
//          return false;
//       }else if(chck_qty==''){
//           return false;
//         }else{
//             $.ajax({
//               url: '<?php echo site_url('product/save_subscription'); ?>',
//               type: 'POST',
//               data: {from_date: from_date,to_date: to_date},
//               success: function(data) {
//                   console.log(data);
//               }
//           });
//       }

// });
</script>