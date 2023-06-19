<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Barcode</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Barcode</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_qrcodes/" >
                  <i class="mdi mdi-plus mr-2"></i> Add Barcode
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
                           <th>Title</th>
                           <th>Product(s)</th>
                           <th>Barcode</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                      <?php 
                        $prods=array();
                        if(count($qrcodes)>0){
                        foreach($qrcodes as $k=>$qr){
                            $explode_prod=explode('##',$qr['prod_ids']);
                            if(count($explode_prod)>0){
                                foreach($explode_prod as $id){
                                    $prod_det=$this->db->query("SELECT `prod_title` FROM `products` WHERE `prod_id`=$id")->row_array();
                                    $prods[]=$prod_det['prod_title'];
                                }
                            }
                        ?>
                       
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo $qr['title']; ?></td>
                            <td>
                            <?php echo (count($prods)>0)?implode(',',$prods):'';?>
                            </td>
                            <td>
                            <img class="banner_image_set" src="<?php echo base_url();?>assets/qrcodes/<?php echo $qr['qr_code'];?>">
                            </td>
                            <td><a class="btn btn-info dropdown-toggle waves-effect waves-light" href="<?php echo base_url().'admin/barcode_download/'.$qr['scanner_id'];?>">Download</a></td>
                        </tr>
                        <?php } } ?>
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
             window.location="<?php echo base_url();?>admin/change_banner_status/"+bannerid+'/'+sta+'/';
       }
   });
}
</script>