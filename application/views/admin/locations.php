<div class="page-content-wrapper ">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="float-right page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Admin</a></li>
                  <li class="breadcrumb-item active">Locations</li>
               </ol>
            </div>
            <h5 class="page-title">Locations </h5>
         </div>
      </div>
      <!-- end row -->
      <div class="row">
         <div class="col-12">
            <div class="card m-b-30">
               <div class="card-body">
                  <?php if($this->session->flashdata('msg') !=''){ ?>
                  <span class="align_text"><?php echo $this->session->flashdata('msg');?></span>
                  <?php } ?>
                  <h4 class="mt-0 header-title">Locations <a  href="<?php echo  base_url(); ?>admin/add_location/" class="addblocks">+ ADD </a></h4>
                  <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Title </th>
                           <th>Icon</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(count($locations)>0){ $a=1; foreach($locations as $res){ ?>
                        <tr>
                           <td><?php echo $a; ?></td>
                           <td><?php echo $res['title']; ?></td>
                           <td><img height="50px" width="50px" src="<?php echo  base_url(); ?>assets/location/<?php echo $res['icon']; ?>" /></td>
                           <td><a href="<?php echo base_url(); ?>admin/edit_location/<?php echo $res['loc_id'];  ?>"><button class="save"> Edit </button></a> | <button class="delete" onclick="delete_location('<?php echo $res['loc_id'];  ?>');"> Delete </button></td>
                        </tr>
                        <?php   $a++; } } ?>
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
<script>
 function delete_location (loc_id)

{

 bootbox.confirm({

    message: "Are you sure want to delete?",

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

      if(result)

      {

       window.location="<?php echo base_url();?>admin/delete_location/"+loc_id+'/';

      }



    }

  });

}                   
   
</script>