<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
               <thead>
                  <tr>
                     <th>S.No</th>
                     <th>Product </th>
                     <th>Product Image </th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $prodid =$offer_products['prods'];
                     $prod_id =json_decode($prodid,true);
                     if(count($prod_id)>0){ $a=1; foreach($prod_id as $res){ 
                        $getid =$res;
                        $get_prodid =$this->db->query("SELECT t1.`prod_id`, t1.`prod_title`,t2.`prod_id`,t2.`prod_image` FROM `products` as t1 LEFT JOIN product_mesurments t2 ON t1.`prod_id`=t2.`prod_id` WHERE t1.`prod_id`=$getid")->row_array();
                     ?>
                  <tr>
                     <td><?php echo $a; ?></td>
                     <td><?php echo $get_prodid['prod_title']; ?></td>
                     <td><?php 
                           $image  =$get_prodid['prod_image'];
                           $decode_prod_image = json_decode($image, true);
                           $product_img =$decode_prod_image[0];
                         ?>
                        <img class="banner_image_set" src ="<?php echo  base_url(); ?>assets/products/<?php echo $product_img; ?>" />
                     </td>
                     </td>
                  </tr>
                  <?php $a++; } } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <!-- end col -->
</div>