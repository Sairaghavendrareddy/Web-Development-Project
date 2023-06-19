<?php if(!empty($result)){ ?>
<div class="ss-statement-transations">
   <div class="ss-statement-tran-head">
      <h1>Transactions</h1>
   </div>
   <div class="ss-statement-tran-cnt">
      <div class="ss-statement-tran-table">
         <table class="table">
            <thead>
               <tr>
                  <th>S No.</th>
                  <th>Date</th>
                  <!-- <th>Particulars</th> -->
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Balance</th>
               </tr>
            </thead>
            <tbody>
               <?php $i = 1; foreach($result as $res){ ?>
               <tr>
                  <td><?php echo $i; ?></td>
                  <td>
                     <?php 
                        $originalDate = $res['created_date'];
                        $created_date = date("d-m-Y", strtotime($originalDate));
                        $date = date('d  F', strtotime($created_date));
                        echo $date; ?>
                  </td>
                  <td class="class-debit">- &#8377;
                     <?php 
                        if($res['action_type']==1){
                         echo $res['amount'];
                        }else if($res['action_type']==2){
                        echo $res['amount'];
                        }else if($res['action_type']==3){
                          echo $res['amount'];
                        }else{ 
                        echo " ";
                        } 
                        ?>  
                  </td>
                  <td class="class-credit">+ &#8377; 
                     <?php 
                        if($res['action_type']==0){
                          echo $res['amount'];
                          }else if($res['action_type']==4){
                            echo $res['amount'];
                          }else{ 
                            echo " ";
                         }
                        ?>
                  </td>
                  <td>&#8377; <?php echo $res['amount']; ?></td>
               </tr>
            </tbody>
            <?php $i++;} ?>
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