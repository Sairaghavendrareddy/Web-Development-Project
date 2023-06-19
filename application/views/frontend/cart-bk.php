
<?php 
$cart = $this->cart->contents();
if(!empty($cart)){
    ?>
    <table id="empty_cart">
        <tr>
            <td>
                <h3><u>Cart page</u></h3>
            </td>
        </tr>
        <tr>
            <th>Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php
        foreach ($cart as $contents) {
            ?><tr id="remove_rowid_<?php echo $contents['rowid']; ?>">

                <td> <a href="<?php echo base_url(); ?>products/product_details/<?php echo $contents['options']['prod_id']; ?>"><img
                    src="<?php echo $contents['options']['prod_image']; ?>" alt="product img" style="width:100px"></td>
                    <td><?php echo $contents['options']['prod_title']; ?><br><?php echo $contents['options']['prod_mes_title']; ?></a></td>
                    <td>
                        <div class="prodct-add-plsmin addtocart_<?php echo $contents['options']['prod_mes_id']; ?>">
                            <div class="prodct-plsmin" id="input_div">
                                <button type="button" value="-" id="moins"
                                onclick="minus('<?php echo $contents['options']['prod_id']; ?>','<?php echo $contents['name']; ?>','<?php echo $contents['rowid']; ?>')"><i
                                class="fas fa-minus"></i> </button>
                                <input class="plsmin-vlue chck_qty_<?php echo $contents['name']; ?>" type="text" size="25"
                                value="<?php echo@$contents['qty'];?>" readonly />
                                <button type="button" value="+" id="plus" onclick="plus('<?php echo $contents['name']; ?>')"><i
                                    class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </td>
                        <?php 
                        $chk_qty =$contents['qty'];
                        $price =$contents['price'];
                        $totoal_price =$chk_qty * $price;
                        ?>
                        <input type="hidden" name="price" class="price_<?php echo $contents['name']; ?>"
                        value="<?php echo $totoal_price; ?>">
                        <td id="price_<?php echo $contents['name']; ?>"><?php echo $totoal_price; ?><br></td>
                        <td><strike><?php echo $contents['options']['prod_org_price']; ?></strike></td>
                        <td><button onclick="removecart('<?php echo $contents['rowid']; ?>');">Remove to Cart</button></td>
                    </tr>

                <?php } ?>
                <h4 id="remove_tol_amt">Total Amount: <span id="cart_totl_amnt"><?php echo $this->cart->total(); ?></span></h4>
            </table>
        <?php }else{ echo "cart empty";} ?>


<script>
function removecart(rowid) {
    // alert(rowid);
    $.ajax({
        url: '<?php echo site_url("home/removecart"); ?>',
        type: 'POST',
        data: {
            rowid: rowid
        },
        success: function(data) {
            if (data!= '') {
                $("#remove_rowid_" + rowid).remove();
                 var obj =$.parseJSON(data);
                        if(obj['cart_count']==0){
                            $("#remove_tol_amt").remove();
                            $("#empty_cart").html('<h4>cart empty</h4>');
                            $('#cart_count').html(cart_count);
                        }else{
                            $("#cart_count").html(obj['cart_count']);
                        }
                   $("#cart_totl_amnt").html(obj['cart_tatl']);
            }else {
                alert('fail');
            }
         },error: function (data) {
          alert("opps! something went to wrong");
         }
    });
}

function plus(prod_mes_id) {
    var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var price = parseInt($('.price_' + prod_mes_id).val());
    $.ajax({
        url: '<?php echo site_url('home/plus_prod_qty'); ?>',
        type: 'POST',
        data: {
            prod_mes_id: prod_mes_id,
            qty: qty
        },
        success: function(data) {
            if (data !== '') {
                $('.chck_qty_' + prod_mes_id).val(qty + 1);
                var multi_qty = $('.chck_qty_' + prod_mes_id).val();
                var plus_price = multi_qty * price;
                var price1 = parseInt($('#price_' + prod_mes_id).html(plus_price));
                var cart_totl_amt = $('#cart_totl_amnt').html(data);
            } else {
                alert('fail');
            }
        }
    });
}

function minus(prod_id, prod_mes_id, rowid) {
    var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
    var price = parseInt($('.price_' + prod_mes_id).val());
    $.ajax({
        url: '<?php echo site_url('home/minus_prod_qty'); ?>',
        type: 'POST',
        data: {
            prod_mes_id: prod_mes_id,
            qty: qty
        },
        dataType: "json",
        success: function(data) {
            var cart_cunt = data.cart_count;
            var cart_tatl = data.cart_tatl;
            // alert(cart_tatl);
            if (data !== '') {
                $('.chck_qty_' + prod_mes_id).val(qty - 1);
                var minus_qty = $('.chck_qty_' + prod_mes_id).val();
                var minus_price = minus_qty * price;
                var finl_prc = parseInt($('#price_' + prod_mes_id).html(minus_price));
                var cart_totl_amt = $('#cart_totl_amnt').html(cart_tatl);
                $('#cart_count').html(cart_count);
                if (cart_cunt == 0) {
                    $("#remove_tol_amt").remove();
                    $("#empty_cart").html('<h4>cart empty</h4>');
                    $('#cart_count').html(cart_count);
                } else if (qty == 1) {
                    $("#remove_rowid_" + rowid).remove();
                    var cart_totl_amt = $('#cart_totl_amnt').html(cart_tatl);
                    $('#cart_count').html(cart_count);
                }
            } else {
                alert('fail');
            }
        }
    });
}
</script>