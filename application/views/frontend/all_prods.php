<div class="ss-product-right">
   <div class="row" id="load_data"></div>
</div>
<div id="load_data_message"></div>
<script>
   $(document).ready(function(){
     var cat_id ='<?php echo $cat_id; ?>';
     var subcat_id ='<?php echo $subcat_id; ?>';
     var search ='<?php echo $search; ?>';
     var limit = 4;
     var start = 0;
     var action = 'inactive';
   
     function load_data(limit, start,$cat_id,$subcat_id,$search,$banner_id)
     {
       var brand=$("input[name='brand[]']:checked").map(function(){return $(this).val();}).get();
       var title=$("input[name='title[]']:checked").map(function(){return $(this).val();}).get();
       var price=$("input[name='price[]']:checked").map(function(){return $(this).val();}).get();
       // alert(title);
         $('#load_data').append('<div class="realod_model footet_load"><span></span><span></span><span></span></div>');
             $.ajax({
               url:"<?php echo base_url(); ?>product/onscroll_data",
               method:"POST",
               data:{limit:limit, start:start,cat_id:cat_id,subcat_id:subcat_id,search:search,brand:brand,title:title,price:price},
               cache: false,
               success:function(data)
               {
                 $('.realod_model').remove(); 
                 if(data == '')
                 {
                   $('#load_data_message').html('<h3 class="moreno">No More Result Found</h3>');
                   action = 'active';
                 }else{
                   // alert('hhgjhgj');
                   // alert('1');
                   $('#load_data').append(data);
                   $('#load_data_message').html("");
                   action = 'inactive';
                 }
               }
             })
     }
   
     if(action == 'inactive')
     {
       action = 'active';
       load_data(limit, start);
     }
   
     $(window).scroll(function(){
       if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
       {
         // lazzy_loader(limit);
         action = 'active';
         start = start + limit;
         setTimeout(function(){
           load_data(limit, start);
         }, 1000);
       }
     });
   
   });
</script>