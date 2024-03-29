<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>::THE SOIL SON::</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
      <meta content="Themesbrand" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/images/logo-sm.png">
      <!-- Bootstrap Css -->
      <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="<?php echo base_url(); ?>assets/admin/css/icons.min.css" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
   </head>
   <body>
      <div class="home-btn d-none d-sm-block">
         <a href="<?php echo base_url(); ?>master" class="text-dark"><i class="fas fa-home h2"></i></a>
      </div>
      <div class="account-pages my-5 pt-5">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-8 col-lg-6 col-xl-5">
                  <div class="card overflow-hidden">
                     <div class="bg-primary">
                        <div class="text-primary text-center p-4">
                           <h5 class="text-white font-size-20 p-2">Reset Password</h5>
                           <a href="<?php echo base_url(); ?>" class="logo logo-admin">
                           <img src="<?php echo base_url(); ?>assets/admin/images/logo.png" height="50" alt="logo">
                           </a>
                        </div>
                     </div>
                     <div class="card-body p-4">
                        <div class="p-3">
                           <div class="alert alert-success mt-5" role="alert">
                              Enter your Email and instructions will be sent to you!
                           </div>
                           <?php if($this->session->flashdata('msg') !=''){ ?>
                           <div class="alert alert-danger mt-5" role="alert">
                              <?php echo $this->session->flashdata('msg');?>
                           </div>
                         <?php } ?>
                           <form method="post" class="form-horizontal mt-4" action="<?php echo base_url(); ?>master/forgot_password" name="reset_password" id="reset_password" />
                              <div class="form-group">
                                 <label for="useremail">Email</label>
                                 <input type="email" class="form-control" name="name" id="name" placeholder="Enter email">
                              </div>
                              <div class="form-group row  mb-0">
                                 <div class="col-12 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="mt-5 text-center">
                     <p>Remember It ? <a href="<?php echo base_url(); ?>master" class="font-weight-medium text-primary"> Sign In here </a> </p>
                     <p class="mb-0">
                        © <script>document.write(new Date().getFullYear())</script> THE SOIL SON. Crafted with <i class="mdi mdi-heart text-danger"></i> by Headurn
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- JAVASCRIPT -->
      <script src="<?php echo base_url(); ?>assets/admin/libs/jquery/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/libs/metismenu/metisMenu.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/libs/simplebar/simplebar.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/libs/node-waves/waves.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/app.js"></script>
   </body>

<script>
$(document).ready(function() {
    $("#reset_password").validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: 'Please enter username or email id'
            }
        },
        ignore: []
    });
});

</script>
</html>