



<html lang="en">
<head>
<title>Invoice</title>
</head>
<style type="text/css">
body {
margin: 0px;
padding: 0px;
font-family: Arial, Helvetica, sans-serif;
}
</style>
<body>
<?php
$site=base_url();
$email=$this->db->query("SELECT `email` FROM `admin_login` WHERE 1")->row_array();
$email=$email['email'];
$custemail=$order['email'];
$orderid = $order['payment_id'];
$ord_Date = date('d-M-Y (h:i A)', strtotime($order['order_date']));
$invoice_Date = date('d-M-Y (h:i A)', strtotime($order['order_date']));
$address=$order;
$user_apartment_det_id = $order['user_apartment_det_id'];
$address=$this->db->query("SELECT d.`user_apartment_det_id`, d.`apartment_id`, d.`block_id`, d.`flat_id`,d.`user_id`,a.flat_name,b.block_name,c.apartment_name,c.apartment_address,c.apartment_pincode FROM `user_apartment_details` d LEFT JOIN `flats` a ON a.`flat_id`=d.`flat_id` LEFT JOIN blocks b ON d.`block_id`=b.block_id LEFT JOIN apartments c ON d.apartment_id = c.apartment_id WHERE d.status=1 AND d.user_apartment_det_id=$user_apartment_det_id")->row_array();
?>
<div class="container" style="width:100%;float:left;">
<div class="row" style="width:100%;float:left;">
<div class="middle" style="border-top:4px solid #009244;
float: left;background-color: #FFF;padding: 0px;width: 100%;
margin: 0px 0px;">
<div class="row" style="width:100%;float:left;">
<div class="top-sec1" style="width:100%;
float: left;background-color: #f6f6f6;">
<div class="top-sec" style="width:48%;float: left;padding: 10px 0% 30px 2%;">
<div class="new-logo" style="float:left;margin-top:15px;"> <img src="a.jpg" width="80" height="80"> </div>
<h1 style="float:left;margin-top:35px;margin-left:15px;">The Soil Son</h1>
</div>
<div class="shipp1" style="float:right;margin-top:10px;width:48%;
padding-right:2%;margin-top:10px; min-height: 125px; align-items: center; display: flex; max-width: 300px;">
<div style="float: left; width: 100%; ">
    <p style="float:right;width:100%;text-align:left;margin-bottom:3px;margin-top:3px;color:#333;font-size:17px;font-family:Arial, Helvetica, sans-serif;">
<strong>Invoice ID:</strong>
<?php echo $orderid;?>
</p>
<p style="float:right;width:100%;text-align:left;margin-bottom:3px;margin-top:3px;color:#333;font-size:17px;font-family:Arial, Helvetica, sans-serif;">
<strong>Order Date:</strong> 
<?php echo $ord_Date;?>
</p>
<p style="float:right;width:100%;text-align:left;margin-bottom:3px;margin-top:3px;color:#333;font-size:17px;font-family:Arial, Helvetica, sans-serif;">
<strong>Invoice Date:</strong> 
<?php echo $invoice_Date;?>
</p>
</div>
</div>
</div>
</div>
<div class="address_section" style="margin-top:15px;float:left;width:100%;">
<div class="row" style="width:100%;float:left;">
<div class="new-invoice" style="float:left;width:30%;">
<h1 style="float:left;width:100%;font-size:35px;color:#b50d0d;margin-top:75px;text-align:center;font-family:Arial, Helvetica, sans-serif;">INVOICE</h1>
</div>
<div class="new-swa" style="width:40%;float:left;margin:0px;padding:0px;">
<h3 style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:19px;color:#333;margin-bottom:3px;">The Soil Son</h3>
<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;">
D.No: 38-8-58,  Opposite PWD grounds,<br />
M.G.Road, Vijayawada,<br />
Andhra Pradesh-520010.
</p>
<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;"> <span class="phone1" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;"><img src="<?php echo $site;?>assets/images/phone_icon.jpg" width="17" height="16"> 0866-2475763</span></p>
<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;"> <span class="email1" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;"> <a href="mailto:<?php echo $email;?>" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;text-decoration:none;color:#333;"><img src="<?php echo $site;?>assets/images/email-icon.jpg" width="17" height="16"> <?php echo $email;?></a></span></p>
<!--<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;"><span class="email1" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;"> <a target="_blank" href="<?php echo $site;?>" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;text-decoration:none;color:#333;"><img src="<?php echo $site;?>assets/images/web_icon.jpg" width="17" height="16"><?php echo $site;?></a></span></p>-->
</div>
<div class="new-swa1" style="width:30%;float:left;margin:0px;padding:0px;">
<h3 style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:19px;  color:#333;margin-bottom:3px;">Shipping Address</h3>
<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;">
<strong style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:14px;color:#d3a004;margin-bottom:0px;">  
<?php 
echo $order['name']; 
?> 
</strong> 
<br />
<?php echo ($address['apartment_name']!='')?$address['apartment_name']:''; ?>
<?php echo ($address['block_name']!='')?','.$address['block_name']:''; ?> 
<?php echo ($address['flat_name']!='')?','.$address['flat_name']:''; ?> 
<?php echo ($address['apartment_address']!='')?','.$address['apartment_address']:''; ?>  
<?php echo ($address['apartment_pincode']!='')?','.$address['apartment_pincode']:''; ?> 
</p>
<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;"> 
<span class="phone1" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;"> <img src="<?php echo $site;?>assets/images/phone_icon.jpg" width="17" height="16">
<?php 
echo $order['phone'];
?>
,</span>
</p>
<p style="width:100%;float:left;font-family:Arial, Helvetica, sans-serif;font-size:15px;color:#333;margin-bottom:9px;margin-top:2px;"> <span class="email1" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;"><a href="mailto: <?php echo $custemail;?>" style="float:left;font-family:Arial, Helvetica, sans-serif;font-size:17px;text-decoration:none;color:#333;"><img src="<?php echo $site;?>assets/images/email-icon.jpg" width="17" height="16">
<?php echo $custemail; ?>
</a></span></p>
</div>
</div>
</div>
<div class="items_status_new" style="width:98%; float:left;margin-left:1%;margin-right:1%;margin-top:40px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<th style="background:#dbdbdb;padding-top:12px;padding-bottom:12px;font:bold 15px Arial, Helvetica, sans-serif; text-align:center;border-right:1px solid #fff;">ITEM</th>
<th style="background:#dbdbdb;padding-top:12px;padding-bottom:12px;font:bold 15px Arial, Helvetica, sans-serif; text-align:center;border-right:1px solid #fff;">QUANTITY (Kgs)</th>
<th style="background:#dbdbdb;padding-top:12px;padding-bottom:12px;font:bold 15px Arial, Helvetica, sans-serif; text-align:center;border-right:1px solid #fff;">UNIT PRICE</th>
<th style="background:#dbdbdb;padding-top:12px;padding-bottom:12px;font:bold 15px Arial, Helvetica, sans-serif; text-align:center;">TOTAL</th>
</tr>
<?php
$all_amt=array();
for($i=0;$i<count($products);$i++){
?>
<tr>
<td style="padding-top:9px;padding-bottom:9px;font:normal 14px Arial, Helvetica, sans-serif;color:#009244;text-align:center;border-bottom:1px solid #ecf0f1;"><?php echo $products[$i]['prod_title']?></td>
<td style="padding-top:9px;padding-bottom:9px;font:normal 14px Arial, Helvetica, sans-serif;color:#333;text-align:center;border-bottom:1px solid #ecf0f1;"><?php echo $products[$i]['qty'];?></td>
<td style="padding-top:9px;padding-bottom:9px;font:normal 14px Arial, Helvetica, sans-serif;color:#333;text-align:center;border-bottom:1px solid #ecf0f1;">$<?php 
    $prod_mesurements=$products[$i]['prod_mesurements'];
    $mes=json_decode($prod_mesurements,true);
    $price=0;
    if(count($mes)>0){
        foreach($mes as $ms){
            if($products[$i]['prod_mes_id'] == $ms['prod_mes_id']){
                $price = $ms['prod_offered_price'];
            }
        }
    }
    echo $price;
?>
</td>
<td style="padding-top:9px;padding-bottom:9px;font:normal 14px Arial, Helvetica, sans-serif;color:#333;text-align:center;border-bottom:1px solid #ecf0f1;">$<?php 
    $pr = $products[$i]['qty']*$price;
    echo $final = number_format($pr,2); 
    $all_amt[]=$final;
    ?>
</td>
</tr>
<?php
}
?>
<tr>
<td style="background:#009244;padding-top:9px;padding-bottom:9px;font:normal 15px Arial, Helvetica, sans-serif;color:#333;text-align:center;">&nbsp;</td>
<td style="background:#009244;padding-top:9px;padding-bottom:9px;font:normal 15px Arial, Helvetica, sans-serif;color:#333;text-align:center;">&nbsp;</td>
<td style="background:#027a3a;padding-top:9px;padding-bottom:9px;font:normal 15px Arial, Helvetica, sans-serif;color:#333;text-align:center;">
<p style="font:normal 16px Arial, Helvetica, sans-serif;color:#fff;text-align:center;">
<?php 
echo 'Total Amount';
?>
</p>
</td>
<td style="background:#027a3a;padding-top:9px;padding-bottom:9px;font:normal 15px Arial, Helvetica, sans-serif;color:#333;text-align:center;">
<p style="font:normal 16px Arial, Helvetica, sans-serif;color:#fff;text-align:center;">
$
<?php 
//$amt=$order['order_amount'];
$amt = array_sum($all_amt);
echo number_format($amt,2);
?>
</p>
</td>
</tr>
</table>
</div>
<div class="thank" style="width:100%;text-align:center;font-family:Arial, Helvetica, sans-serif;font-weight:bold;font-size:25px;color:#008f40;float:left;margin-top:20px;">Thanks For Your Business</div>
<p>&nbsp;</p>
</div>
</div>
</div>
</body>
</html>