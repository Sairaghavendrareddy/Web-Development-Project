<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Offer Banners</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Offer Banners</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_offer_banners/" >
                  <i class="mdi mdi-plus mr-2"></i> Add Offer Banners
                  </a>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Page </th>
                           <th>Module </th>
                           <th>Title</th>
                           <th>Image</th>
                           <th>Description</th>
                           <th class="all">Product(s)</th>
                           <th class="all">Status</th>
                           <th class="all">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($offer_banners)>0){ $a=1; foreach($offer_banners as $res){ ?>
                        <tr>
                            <td><?php echo $a; ?></td>
                            <td><?php echo $res['page']; ?></td>
                            <td><?php 
                            $catid = $res['module'];
                            if($catid=='products'){
                              echo "products";
                              }else if($catid=='deal'){
                                echo "deal";
                              }else if($catid=='best'){
                                echo "best";
                              }else if($catid=='subc'){
                                echo "subc";
                              }else if($catid=='offer'){
                                echo "offer";
                              }else{
                                $query =$this->db->query("SELECT `cat_id`, `title` FROM `categories` WHERE `cat_id`=$catid")->row_array();
                                echo $query['title'];
                              }
                            ?>
                              
                            </td>
                            <td><?php echo $res['title']; ?></td>
                            <td><img src="<?php echo  base_url(); ?>assets/banners/<?php echo $res['image']; ?>" class="banner_image_set"  /></td>
                            <td><?php echo $res['description']; ?></td>
                            <td><button type="button" class="btn btn-primary waves-effect waves-light" onclick="view_products('<?php echo $res['id'];  ?>');">View</button></td>
                           <?php if($res['is_active']=='1'){ ?>
                           <td>
                              <button type="button" class="btn btn_success waves-effect waves-light" onclick="change_banner_status('<?php echo $res['id'];  ?>','0');">Active</button>
                          </td>
                           <?php } else{ ?>
                           <td>
                              <button type="button" class="btn btn_warning waves-effect waves-light" onclick="change_banner_status('<?php echo $res['id'];  ?>','1');">Inactive</button>
                          </td>
                           <?php }?>
                           <td>
                              <a href="<?php echo base_url(); ?>admin/edit_offer_banners/<?php echo $res['id'];  ?>"><button class="btn btn-info waves-effect waves-light"> Edit </button></a>
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
      <!-- end row -->
   </div>
   <!-- container-fluid -->
</div>
<!-- End Page-content -->
<!-- Modal -->
<div class="modal fade" id="view-offer-products" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Product(s)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div id="mes_data"></div>
         </div>
      </div>
   </div>
</div>
<!-- END Modal -->
<script>
function change_banner_status(bannerid,sta)
{
      Swal.fire({
     text: "Are you sure want to change the status?",
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Yes'
   }).then((result) => {
         if (result.isConfirmed) {
             window.location="<?php echo base_url();?>admin/change_offer_banner_status/"+bannerid+'/'+sta+'/';
       }
   });
}

function view_products(id){
     $.ajax({
        url: '<?php echo site_url('admin/view_offer_products'); ?>',
        type: 'POST',
        data: {id: id},
        success: function(data) {
          $('#mes_data').html(data);
            $('#view-offer-products').modal('show');
        }
    });
}
</script>