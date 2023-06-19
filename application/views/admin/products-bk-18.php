<div class="main-content">
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row align-items-center">
         <div class="col-sm-6">
            <div class="page-title-box">
               <h4 class="font-size-18">Products</h4>
               <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Products</li>
               </ol>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="float-right d-none d-md-block">
               <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle waves-effect waves-light" href="<?php echo base_url(); ?>admin/add_product/" >
                  <i class="mdi mdi-plus mr-2"></i> Add Product
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
                  <?php if($this->session->flashdata('msg') !=''){ ?>
                  <span class="align_text"><?php echo $this->session->flashdata('msg');?></span>
                  <?php } ?>
                  <div class="mt-0 header-title">
                     <select class="select2" id="ispopsubtype" Onchange="Get_Prods(this.value);">
                        <option value="0">All</option>
                        <option value="1">Subscraibe Available</option>
                        <option value="2">Popular</option>
                     </select>
                  </div>
                  <table id="prod_tb" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Title </th>
                           <th>Measurements </th>
                           <th>Category </th>
                           <th>Brand </th>
                           <th class="all">Status</th>
                           <th class="all">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <!-- end col -->
      </div>
      <!-- end row -->
   </div>
   <!-- container fluid -->
</div>
<!-- Page content Wrapper -->
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Please wait...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
               <thead>
                  <tr>
                     <th>S.No</th>
                     <th>Title </th>
                     <th>Original price </th>
                     <th>Offered price </th>
                     <th>Available quantity </th>
                     <th class="all">Image</th>
                  </tr>
               </thead>
               <tbody id="mes_data">
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- END Modal -->

<script>
$(document).ready(function(){
    All_Products_Data(0);
});
function Get_Prods(sno){
    $("#prod_tb").dataTable().fnDestroy();
    All_Products_Data(sno);
}
function All_Products_Data(sno){
    $('#prod_tb').DataTable({
        "order": [[ 1, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
        "url":  "<?php echo base_url();?>admin/get_products",
        "data": function (d) {
            d.ispopsubtype = sno;
        }
        } 
    });
}
function change_prod_status(stid,sta)
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
               window.location="<?php echo base_url();?>admin/change_product_status/"+stid+'/'+sta+'/';
       }
   });
}   
function Get_mess(prod_id){
   $("#mes_data").html('Please wait...');
   $("#exampleModalLongTitle").html('Please wait...');
   $("#exampleModalCenter").modal("show");
   $.ajax({
      type:"POST",
      dataType:"json",
      url: "<?php echo base_url();?>admin/product_measurement",
      data:{'prod_id':prod_id},
      success: function(result){
         $("#exampleModalLongTitle").html(result.tit);
         $("#mes_data").html(result.pg);
      }
   });
}                 
</script>