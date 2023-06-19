<section class="ss-product-view">
   <div class="container">
      <div class="row">
         <div class="col-12 col-sm-12 col-md-12 col-xl-3 col-lg-3">
            <div class="job-filter">
               <h4 class="filter-head">Filters <button class="noeffect" type="button" onclick="clear_all()" id="myCheckbox">Clear all</button></h4>
               <div class="job-filter-indi">
                  <h6>BRAND <button class="noeffect" type="button" onclick="brand_clear()">Clear</button></h6>
                  <div class="filter-indi-opts">
                     <ul class="nicescroll">
                        <?php if(!empty($brands)){ foreach ($brands as $brand) { 
                           if($brand['brand_id']!=''){
                           ?>
                        <li>
                           <label for="<?php echo $brand['brand_id'];?>" class="container-checkbox"><?php echo $brand['brand_title']; ?><span></span>
                           <input type="checkbox"name="brand[]" onclick="filter_data();" id="<?php echo $brand['brand_id'];?>" value="<?php echo $brand['brand_id']; ?>" class="d-none brand_clear">
                           <span class="checkmark"></span>
                           </label>
                        </li>
                        <?php } } } ?>
                     </ul>
                  </div>
               </div>
               <div class="job-filter-indi">
                  <h6>PRICE <button class="noeffect" type="button" onclick="price_clear()">Clear</button></h6>
                  <div class="filter-indi-opts">
                     <ul class="nicescroll" tabindex="3" style="overflow: hidden; outline: none;">
                        <?php if(!empty($prices)){ foreach ($prices as $price) { 
                           if($price['prod_id']!=''){
                           ?>
                        <li>
                           <label for="<?php echo $price['prod_offered_price']; ?>" class="container-checkbox"><span></span>
                           <input type="checkbox"name="price[]" onclick="filter_data();" value="<?php echo $price['prod_offered_price']; ?>" class="price_clear" id="<?php echo $price['prod_offered_price']; ?>">
                           <?php echo $price['prod_offered_price']; ?><span></span>
                           <span class="checkmark"></span>
                        </li>
                        <?php } } } ?> 
                     </ul>
                  </div>
               </div>
               <div class="job-filter-indi">
                  <h6>PACK SIZE <button class="noeffect" type="button" onclick="titles_clear()">Clear</button></h6>
                  <div class="filter-indi-opts">
                     <ul class="nicescroll" tabindex="4" style="overflow: hidden; outline: none;">
                        <?php if(!empty($titles)){ foreach ($titles as $title) { 
                           if($title['mes_id']!=''){
                           ?>
                        <li>
                           <label for="<?php echo $title['title']; ?>" class="container-checkbox"><span></span>
                           <input type="checkbox"name="title[]" onclick="filter_data();" id="<?php echo $title['title']; ?>" value="<?php echo $title['title']; ?>" class="titles_clear">
                           <?php echo $title['title']; ?><span></span>
                           <span class="checkmark"></span>
                        </li>
                        <?php } } } ?> 
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
            <div class="list_inner">
               <div class="row" id="ppage">
                  <?php echo $ppage;?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script type="text/javascript">
   function filter_data()
   {
      $('#load_data').html('');
      $('#ppage').html('<div class="realod_icon" align="center"><span></span><span></span><span></span><div>');
      var brand=$("input[name='brand[]']:checked").map(function(){return $(this).val();}).get();
      var title=$("input[name='title[]']:checked").map(function(){return $(this).val();}).get();
      var price=$("input[name='price[]']:checked").map(function(){return $(this).val();}).get();
      // var model=$("input[name='model[]']:checked").map(function(){return $(this).val();}).get();
      // var price=$("input[name='price']:checked").val();
      // alert(title);
      // console.log(price);
   
            $.ajax({
               url:"<?php echo base_url(); ?>product/getfilter_data",
               method:"POST",
               data:{
                   'cat_id' :'<?php echo $cat_id; ?>',
                   'subcat_id' :'<?php echo $subcat_id; ?>',
                   'search' :'<?php echo $search; ?>',
                   'brand':brand,
                   'title':title,
                   'price':price
               },
               success:function(data)
               {
                 $('#ppage').html(data);
               }
         });
   } 
   
   function clear_all() {
      $(".brand_clear").prop("checked", false);
      $(".price_clear").prop("checked", false);
      $(".titles_clear").prop("checked", false);
      filter_data();
   }
   function brand_clear() {
      $(".brand_clear").prop("checked", false);
      filter_data();
   }
   function price_clear() {
      $(".price_clear").prop("checked", false);
      filter_data();
   }
   function titles_clear() {
      $(".titles_clear").prop("checked", false);
      filter_data();
   }
</script>