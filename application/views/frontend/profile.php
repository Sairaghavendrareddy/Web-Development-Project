<section class="ss-inner-brd">
   <div class="container">
      <div class="ss-inner-brd-cnt">
         <h1>The Soil Son <span><i class="fas fa-store"></i> Account</span></h1>
         <ul>
            <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Home</a></li>
            <li class="brek-lst">/</li>
            <li class="brd-active">Account</li>
         </ul>
      </div>
   </div>
</section>
<section class="ss-profile">
   <div class="container">
      <div class="row">
         <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <div class="ss-profile-left-nav">
               <ul class="nav" id="myTab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-user"></i> Profile</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-map-marker-alt"></i> Manage Address</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="messages" aria-selected="false"><i class="fas fa-shopping-basket"></i> My Orders</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="wallet" aria-selected="false"><i class="fas fa-wallet"></i> My Wallet</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="statement-tab" data-toggle="tab" href="#statement" role="tab" aria-controls="statement" aria-selected="false"><i class="far fa-file"></i> Statement History </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="refund-tab" data-toggle="tab" href="#refund" role="tab" aria-controls="settings" aria-selected="false"><i class="fas fa-money-check"></i> Refund History</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="mini-statement-tab" data-toggle="tab" href="#mini-statement" role="tab" aria-controls="mini-statement" aria-selected="false"><i class="fas fa-list"></i> Mini Statement</a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 ">
            <div class="ss-profile-right-shw">
               <div class="tab-content">
                  <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="far fa-user"></i> Profile</h1>
                        <div class="ss-propage-right-cnt">
                           <div class="profle-tab-img">
                              <?php if($profile['profile_pic']!=''){ ?>
                              <img src="<?php echo base_url();?>assets/user_images/<?php echo $profile['profile_pic'];?>" alt="profile pic">
                              <?php }else { ?>
                              <img src="<?php echo base_url(); ?>assets/frontend/images/user.png"/>
                              <?php } ?>
                           </div>
                           <div class="profle-tab-info">
                              <div class="row">
                                 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="profle-tab-name">
                                       <h4>First Name</h4>
                                       <p><?php echo $profile['fname']; ?></p>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="profle-tab-name">
                                       <h4>Last Name</h4>
                                       <p><?php echo $profile['lname']; ?></p>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="profle-tab-name">
                                       <h4>Phone</h4>
                                       <p><?php echo $profile['phone']; ?></p>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="profle-tab-name">
                                       <h4>Email</h4>
                                       <p><?php echo $profile['email']; ?></p>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="profile-updt-btn">
                                       <button type="button" data-toggle="modal" data-target="#edit-profile-modal"><i class="far fa-edit"></i> Update Profile</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="fas fa-map-marker-alt"></i> Manage Address 
                           <button class="up-rt-btn" href="#address_selection_modal"
                              data-target="#address_selection_modal" data-toggle="modal"><i class="fas fa-plus"></i> Add Address</button>
                        </h1>
                        <div class="ss-propage-right-cnt">
                           <div class="row">
                              <?php 
                                 if(!empty($address)){foreach ($address as $addres) { ?>
                              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" id="get_user_add_id_<?php echo $addres['user_apartment_det_id']; ?>">
                                 <?php if($addres['is_latest']==1){ ?>
                                 <div class="acc-address-mang selected-add-els">
                                    <h4>Delivery Address</h4>
                                    <p><?php echo $addres['apartment_name']; ?>, <?php echo $addres['apartment_address']; ?>, <?php echo $addres['apartment_pincode']; ?>,<br> Block No:&nbsp;<b><?php echo $addres['block_id']; ?></b>, Flat No:&nbsp;<b><?php echo $addres['flat_id']; ?></b></p>
                                    <div class="acc-address-sclted">
                                       <ul>
                                          <li>
                                             <p>Selected Delivery Address</p>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <?php }else{ ?>
                                 <div class="acc-address-mang">
                                    <h4>Delivery Address</h4>
                                    <p><?php echo $addres['apartment_name']; ?>, <?php echo $addres['apartment_address']; ?>, <?php echo $addres['apartment_pincode']; ?>,<br> Block No:&nbsp;<b><?php echo $addres['block_id']; ?></b>, Flat No:&nbsp;<b><?php echo $addres['flat_id']; ?></b></p>
                                    <div class="acc-address-btns">
                                       
                                    <form method="post" action="<?php echo base_url(); ?>profile/change_delivery_address">
                                       <ul>
                                             <input type="hidden" name="user_apartment_det_id" id="user_apartment_det_id" value="<?php echo $addres['user_apartment_det_id']; ?>" />
                                             <li><button class="dlh-btn" type="submit">Deliver Here</button></li>
                                          
                                          <li><button class="del-btn" type="button" class="" onclick="remove_address('<?php echo $addres['user_apartment_det_id']; ?>');">Remove</button></li>
                                       </ul>
                                       </form>
                                    </div>
                                 </div>
                                 <?php } ?>
                              </div>
                              <?php } }else { ?>
                              <div class="nodatafound">
                                 <div class="nodatafound-cnt">
                                    <div class="nodatafound-pic">
                                       <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"/>
                                    </div>
                                    <p>No Data Found</p>
                                 </div>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="fas fa-shopping-basket"></i> My Orders</h1>
                        <div class="ss-propage-right-cnt">
                           <div class="row">
                              <?php 
                                 if(!empty($orders)){
                                   foreach ($orders as $order) { ?>
                              <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                 <div class="ss-myorderslist">
                                    <div class="myorderslist-cnt">
                                       <h5>Invoice : <span><?php echo $order['invoice_id']; ?></span></h5>
                                       <h5>Ordered Date : <span><?php echo $order['order_date']; ?></span></h5>
                                       <h5>Total Amount : <span>Rs. <?php echo $order['order_amount']; ?></span></h5>
                                       <h5>Total Items : <span><?php echo $order['tot_items']; ?> Items</span></h5>
                                       <h5>Payment Status : <span class="sspymt-status"><?php echo ucfirst($order['payment_status']); ?></span></h5>
                                    </div>
                                    <div class="myorderslist-bnts">
                                       <div class="acc-address-btns">
                                          <ul>
                                             <li><a href="<?php echo base_url(); ?>assets/invoices/Invoice_<?php echo $order['order_id']; ?>.pdf" target="_blank">View Invoice</a></li>
                                             <li>
                                                <?php if($order['order_status']=='Success'){ ?>
                                                <button class="del-btn" type="button" name="cancel_order" id="cancel_order"  onclick="order_cancellation('<?php echo $order['order_id']; ?>');" >
                                                Cancel</button>
                                                <?php }else if($order['order_status']=='Failed'){ ?>
                                                <a style="background-color:#ff0000;border-color:#ff0000" href="javascript:void(0);;">Failed</a> 
                                                <?php }else if($order['order_status']=='Cancelled'){ ?>
                                                <a style="background-color:#ff0000;border-color:#ff0000" href="javascript:void(0);;">Cancelled</a>
                                                <?php }else if($order['order_status']=='Processing'){ ?>
                                                <a style="background-color:#cccc00;border-color:#cccc00" href="javascript:void(0);;">Processing</a>
                                                <?php } ?>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php } }else{ ?>
                              <div class="nodatafound">
                                 <div class="nodatafound-cnt">
                                    <div class="nodatafound-pic">
                                       <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"/>
                                    </div>
                                    <p>No Data Found</p>
                                 </div>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="fas fa-wallet"></i> My Wallet</h1>
                        <div class="ss-propage-right-cnt">
                           <div class="ss-wallet-sec">
                              <div class="ss-wallet-bal">
                                 <div class="ss-bal-num">
                                    <h1><i class="fas fa-rupee-sign"></i> <span>Rs <?php echo $wallet_amount['final_wallet_amount']; ?></span></h1>
                                    <p>Current Wallet Balance</p>
                                 </div>
                                 <div class="ss-bal-add">
                                    <button type="button" data-toggle="modal" data-target="#add-money-wallet"><i class="fas fa-plus"></i> Add Money to Wallet</button>
                                 </div>
                              </div>
                              <div class="ss-recharge-history">
                                 <div class="ss-recharge-head">
                                    <h1>Recharge History</h1>
                                 </div>
                                 <!--------month start---->
                                 <?php
                                    if(!empty($recharge_history)){
                                        $recharge=0;
                                    foreach ($recharge_history as $r_history) { ?>
                                 <div class="ss-recharge-mntwise">
                                    <div class="panel-group" id="accordionSingleOpen" role="tablist" aria-multiselectable="true">
                                       <div class="panel panel-default">
                                          <div class="panel-heading" role="tab" id="headingOne">
                                             <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" href="#history_mnt_1" aria-expanded="true" aria-controls="history_mnt_1">
                                                <?php echo $r_history['mnth']; ?>&nbsp; <?php echo $r_history['yr']; ?>
                                                </a>
                                             </h4>
                                          </div>
                                          <div id="history_mnt_1" class="panel-collapse in collapse <?php if($recharge==0){ ?>show<?php }else{ } ?>" role="tabpanel" aria-labelledby="headingOne">
                                             <div class="panel-body">
                                                <div class="ss-recharge-trns">
                                                   <?php foreach ($r_history['history'] as $rhistory){ ?>
                                                   <!--box -->
                                                   <div class="ss-recharge-trns-indi">
                                                      <?php
                                                         if($rhistory['status']==1){ ?>
                                                      <i class="sucess-show far fa-check-circle"></i>
                                                      <?php }else{ ?>
                                                      <i class="fail-show far fa-times-circle"></i>         
                                                      <?php } ?>
                                                      <div class="ss-recharge-info">
                                                         <div class="ss-recharge-text">
                                                            <h4>
                                                               <?php
                                                                  if($rhistory['description']=='Added by User'){
                                                                  echo "Recharge on &nbsp;";
                                                                  }else{
                                                                  echo "Paid on";
                                                                  }
                                                                  echo $rhistory['created_date'];
                                                                  ?>
                                                            </h4>
                                                            <p>Transaction type: PaymentService</p>
                                                         </div>
                                                         <div class="ss-recharge-amt">
                                                            <p><i class="fas fa-rupee-sign"></i> <span><?php echo $rhistory['amount']; ?></span></p>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <!--box end-->
                                                   <?php } ?>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!----month end----->
                                 <?php $recharge++; } }else { ?>
                                 <div class="nodatafound">
                                    <div class="nodatafound-cnt">
                                       <div class="nodatafound-pic">
                                          <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"/>
                                       </div>
                                       <p>No Data Found</p>
                                    </div>
                                 </div>
                                 <?php } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="statement" role="tabpanel" aria-labelledby="statement-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="far fa-file"></i>  Statement History </h1>
                        <div class="ss-propage-right-cnt">
                           <div class="ss-statement-his">
                              <div class="row">
                                 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="ss-statement-field">
                                       <label>From Date</label>
                                       <input type="text" name="start_date" id="start_date" placeholder="Select From Date"/>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="ss-statement-field">
                                       <label>To Date</label>
                                       <input type="text"  name="end_date" id="end_date"  placeholder="Select To Date"/>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="ss-statement-button">
                                       <button type="button" name="statement_history" id="statement_history">Get Statement <i class="fas fa-arrow-right"></i></button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="ajax_statement_history">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="refund-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="fas fa-money-check"></i> Refund History </h1>
                        <div class="ss-propage-right-cnt">
                           <div class="ss-refund-history">
                              <div class="ss-recharge-head">
                                 <h1>Refunds</h1>
                              </div>
                              <!--------month start---->
                              <?php 
                                 if(!empty($refund_history)){
                                    $i=0;
                                 foreach ($refund_history as $history) { ?>
                              <div class="ss-recharge-mntwise">
                                 <div class="panel-group" id="accordionSingleOpen" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                       <div class="panel-heading" role="tab" id="headingOne">
                                          <h4 class="panel-title">
                                             <a role="button" data-toggle="collapse" href="#refund_mnt_1" aria-expanded="true" aria-controls="refund_mnt_1">
                                             <?php echo $history['mnth'];?>&nbsp;<?php echo $history['yr']; ?>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="refund_mnt_1" class="panel-collapse in collapse <?php if($i == 0) { ?>show <?php }else{ } ?>" role="tabpanel" aria-labelledby="headingOne">
                                          <div class="panel-body">
                                             <div class="ss-recharge-trns">
                                                <!--box -->
                                                <?php foreach ($history['history'] as $rhistory) { ?>
                                                <div class="ss-recharge-trns-indi">
                                                   <?php
                                                      if($rhistory['status']==1){ ?>
                                                   <i class="sucess-show far fa-check-circle"></i>
                                                   <?php }else{ ?>
                                                   <i class="fail-show far fa-times-circle"></i>
                                                   <?php } ?>
                                                   <div class="ss-recharge-info">
                                                      <div class="ss-recharge-text">
                                                         <h4>
                                                            <?php 
                                                               if($rhistory=='Added by User'){
                                                               echo "Added to wallet on";
                                                               }else{
                                                               echo "Refund on &nbsp;";
                                                               } 
                                                               echo $rhistory['created_date']; 
                                                               
                                                               ?>
                                                         </h4>
                                                      </div>
                                                      <div class="ss-recharge-amt">
                                                         <p><i class="fas fa-rupee-sign"></i> <span><?php echo $rhistory['amount']; ?>
                                                            </span>
                                                         </p>
                                                      </div>
                                                   </div>
                                                </div>
                                                <?php } ?>
                                                <!--box end-->
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php  $i++; } }else{?>
                              <div class="nodatafound">
                                 <div class="nodatafound-cnt">
                                    <div class="nodatafound-pic">
                                       <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"/>
                                    </div>
                                    <p>No Data Found</p>
                                 </div>
                              </div>
                              <?php }?>
                              <!----month end----->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="mini-statement" role="tabpanel" aria-labelledby="mini-statement-tab">
                     <div class="ss-propage-right">
                        <h1 class="propage-heading"><i class="fas fa-list"></i> Mini Statement </h1>
                        <div class="ss-propage-right-cnt">
                           <div class="ss-mini-statement">
                              <div class="ss-statement-transations">
                                 <div class="ss-statement-tran-head">
                                    <h1>Transactions</h1>
                                 </div>
                                 <div class="ss-statement-tran-cnt">
                                    <div class="ss-statement-tran-table">
                                       <?php if(!empty($mini_statement)){ ?>
                                       <table class="table">
                                          <thead>
                                             <tr>
                                                <th>S No.</th>
                                                <th>Date</th>
                                                <th>Particulars</th>
                                                <th></th>
                                                <th>Balance</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $m = 1; foreach($mini_statement as $min_statement){ ?>
                                             <tr>
                                                <td><?php echo $m; ?></td>
                                                <td>
                                                   <?php 
                                                      $originalDate1 = $min_statement['created_date'];
                                                      $created_date1 = date("d-m-Y", strtotime($originalDate1));
                                                      echo $created_date1; ?>
                                                </td>
                                                <td>
                                                   <?php 
                                                      if($min_statement['action_type']==0){
                                                        echo "Recharge";
                                                      }else if($min_statement['action_type']==1){
                                                        echo $min_statement['transaction_id'];
                                                      }else if($min_statement['action_type']==2){
                                                        echo "ServiceCharge";
                                                      }else if($min_statement['action_type']==3){
                                                        echo $min_statement['transaction_id'];
                                                      }else{ 
                                                        echo "Refund"; 
                                                      } 
                                                      ?>
                                                </td>
                                                <td class="class-credit">
                                                   <?php 
                                                      if($min_statement['action_type']==0){ ?>
                                                   + &#8377; 
                                                   <?php }else if($min_statement['action_type']==1){ ?>
                                                   + &#8377; 
                                                   <?php }else if($min_statement['action_type']==2){ ?>
                                                   + &#8377; 
                                                   <?php }else if($min_statement['action_type']==3){ ?>
                                                   + &#8377; 
                                                   <?php }else{ ?>
                                                   + &#8377; 
                                                   <?php }
                                                      echo $min_statement['amount']; ?>
                                                </td>
                                                <td>&#8377; <?php echo $min_statement['amount']; ?></td>
                                             </tr>
                                             <?php $m++;} ?> 
                                          </tbody>
                                       </table>
                                       <?php } else { ?>
                                       <div class="nodatafound">
                                          <div class="nodatafound-cnt">
                                             <div class="nodatafound-pic">
                                                <img src="<?php echo base_url(); ?>assets/frontend/images/datanotfound.png"/>
                                             </div>
                                             <p>No Data Found</p>
                                          </div>
                                       </div>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade" id="add-money-wallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="add-mny-pop">
               <div class="add-mny-pop-top">
                  <img src="<?php echo base_url(); ?>assets/frontend/images/add-money-2wallet.png">
                  <p>Add Money to your Wallet</p>
               </div>
               <form class="form-horizontal" method="post" id="add_wallet_amount" name="add_wallet_amount" action="<?php echo base_url(); ?>profile/add_amount_to_wallet/">
                  <div class="add-mny-pop-btm">
                     <input type="text" name="wallet_amount" id="wallet_amount" placeholder="Enter Amount to be Added in Wallet"/>
                  </div>
                  <div class="add-mny-pop-butn">
                     <button type="submit">
                     Add <i class="fas fa-arrow-right"></i>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="edit-profile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="del-logn-cls">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><i class="fas fa-times"></i></span>
               </button>
            </div>
            <div class="del-logn-titl">
               <h1>Update Profile</h1>
               <p>Enter your details below to update</p>
            </div>
            <form class="form-horizontal" method="post" id="update_profile" name="update_profile" enctype="multipart/form-data" action="<?php echo base_url(); ?>profile/update_profile/">
               <!-- <input type="text" class="form-control" id="id" name="id" value="<?php echo $profile['user_id']; ?>" /> -->
               <div id="registration_form" class="del-logn-here">
                  <div class="del-logn-inp">
                     <label class="upd-pro-label" for="name"><img src="<?php echo base_url(); ?>assets/frontend/images/name-icon.png"></label>
                     <input type="text" id="fname" placeholder="Enter your First Name" name="fname" value="<?php echo $profile['fname']; ?>" />
                  </div>
                  <div class="del-logn-inp">
                     <label class="upd-pro-label" for="name"><img src="<?php echo base_url(); ?>assets/frontend/images/name-icon.png"></label>
                     <input type="text" id="lname" placeholder="Enter your Last Name" name="lname" value="<?php echo $profile['lname']; ?>" />
                  </div>
                  <!-- <div class="del-logn-inp">
                     <label class="upd-pro-label" for="email"><img src="<?php echo base_url(); ?>assets/frontend/images/phone-icon.png"></label>
                     <input type="number" id="phone" name="phone" placeholder="Mobile Number (10-digit)" value="<?php echo $profile['phone']; ?>" />
                     </div> -->
                  <div class="del-logn-inp">
                     <label class="upd-pro-label" for="newemail"><img src="<?php echo base_url(); ?>assets/frontend/images/email-icon.png"></label>
                     <input type="text" id="email" placeholder="Enter Your Email Id" name="email" value="<?php echo $profile['email']; ?>" />
                  </div>
                  <div class="del-logn-inp">
                     <label class="upd-pro-label" for="name"><img src="<?php echo base_url(); ?>assets/frontend/images/image-icon.png"></label>
                     <input type="file" id="simage" name="simage" accept=".jpeg, .jpg, .png" />
                     <input type="hidden" name="oldpic" id="oldpic" value="<?php echo $profile['profile_pic']; ?>">
                  </div>
                  <div class="del-logn-sbmt">
                     <button type="submit" >Save & Continue</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).ready(function() {
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
           localStorage.setItem('activeTab', $(e.target).attr('href'));
       });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
   
       $("#update_profile").validate({
        rules: {fname:{required:true},lname:{required:true},email:{required:true,email:true},},
        messages: {fname:{required:'Please enter first name'},lname:{required: "Please enter last name"},email:{required: "Please enter email id",email:"Please enter valid email id"},},
        ignore: []
      }); 
   
    jQuery.validator.addMethod("noSpace", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
   }, "Spaces are Not Allowed");
   $("#add_wallet_amount").validate({
        rules: {wallet_amount:{required:true,noSpace: true,number:true},},
        messages: {wallet_amount:{required:'Please enter amount',number:'Please enter only digits'}},
        ignore: []
      }); 
   });
   
   $('#start_date').Zebra_DatePicker({
       direction: false,
       format: 'd-m-Y',
       pair: $('#end_date')
   });
   $('#end_date').Zebra_DatePicker({
       direction: true,
       format: 'd-m-Y'
   });
   
   $('#statement_history').click(function() {
        var start_date =$('#start_date').val();
        var end_date =$('#end_date').val();
        if(start_date=='' || end_date==''){
            return false;
        }
       $.ajax({
           url: '<?php echo site_url('profile/statement_history'); ?>',
           type: 'POST',
           data: {start_date: start_date,end_date: end_date},
           success: function(data) {
            if(data==0){
                $.toast({heading:'Error',text:'End date must be grater or equal to start date',position:'top-right',stack: false,icon:'error'});
               }else if(data==''){
                $.toast({heading:'Error',text:'No data found',position:'top-right',stack: false,icon:'error'});
               }else{
                $("#ajax_statement_history").html(data);
               }
           }
       });
     }); 
</script>
<script>
   function remove_address(user_apartment_det_id){
        bootbox.confirm({
        message: "Are you sure you want to remove this?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result){
                 $.ajax({
                    url: '<?php echo site_url('profile/delete_user_address'); ?>',
                    type: 'POST',
                    data: {user_apartment_det_id: user_apartment_det_id},
                    success: function(data) {
                       if(data==1){
                        $('#get_user_add_id_'+user_apartment_det_id).remove();
                            $.toast({heading:'Success',text:'Address deleted successfully',position:'top-right',stack: false,icon:'success'});
                       }else{
                            $.toast({heading:'Error',text:'Address deted Failed Please try Again...',position:'top-right',stack: false,icon:'error'});
                       }
                    }
                });
            }
        }
    });
   }
   function change_delivery_address(change_delivery_address_id){
           bootbox.confirm({
           message: "Are you sure you want to change delivery address ?",
           buttons: {
               confirm: {
                   label: 'Yes',
                   className: 'btn-success'
               },
               cancel: {
                   label: 'No',
                   className: 'btn-danger'
               }
           },
           callback: function (result) {
               if(result){
                    $.ajax({
                       url: '<?php echo site_url('profile/change_delivery_address'); ?>',
                       type: 'POST',
                       data: {change_delivery_address_id: change_delivery_address_id},
                       success: function(data) {
                          if(data==1){
                           // $('#get_user_add_id_'+user_apartment_det_id).remove();
                               // $.toast({heading:'Success',text:'Delivery Address Changed Successfully...',position:'top-right',stack: false,icon:'success'});
                               // setTimeout(function () {
                               //     location.reload(true);
                               //   }, 3000);
                          }else{
                               // $.toast({heading:'Error',text:'Delivery Address Changed Failed...',position:'top-right',stack: false,icon:'error'});
                               // setTimeout(function () {
                               //     location.reload(true);
                               //   }, 3000);
                          }
                       }
                   });
               }
           }
       });
   }
   
   function order_cancellation(order_id){
           bootbox.confirm({
           message: "Are you sure you want to cancel this order ?",
           buttons: {
               confirm: {
                   label: 'Yes',
                   className: 'btn-success'
               },
               cancel: {
                   label: 'No',
                   className: 'btn-danger'
               }
           },
           callback: function (result) {
               if(result){
                    $.ajax({
                       url: '<?php echo site_url('order/user_order_cancellation'); ?>',
                       type: 'POST',
                       data: {order_id: order_id},
                       success: function(data) {
                          if(data==0){
                               $.toast({heading:'Error',text:'This order already cancelled...',position:'top-right',stack: false,icon:'error'});
                          }else if(data==1){
                               $.toast({heading:'Success',text:'Order cancelled successfully...',position:'top-right',stack: false,icon:'success'});
                               setTimeout(function () {
                                   location.reload(true);
                                 }, 3000);
                          }else{
                             $.toast({heading:'Error',text:'Order cancellation not allowed',position:'top-right',stack: false,icon:'error'});
                          }
                       }
                   });
               }
           }
       });
   }
   
</script>