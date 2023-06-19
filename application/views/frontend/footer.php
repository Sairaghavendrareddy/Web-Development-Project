<style>


</style>
<section class="ss-footer">
    <div class="container">
        <div class="ss-footer-cnt">
            <div class="ss-footer-abt">
                <img src="<?php echo base_url(); ?>assets/frontend/images/logo.png" />
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy</p>
            </div>
            <div class="ss-footer-links">
                <h2>Soil son</h2>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">In News</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="ss-footer-links">
                <h2>Help</h2>
                <ul>
                    <li><a href="#">FAQ's</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Report</a></li>
                </ul>
            </div>
            <div class="ss-footer-links">
                <h2>Get to Know Us</h2>
                <ul>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Sustainability</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="btm-footer">
    <div class="container">
        <div class="btm-footer-cnt">
            <div class="btm-footer-left">
                <p>© 2021, Soilson. All rights reserved.</p>
            </div>
            <div class="btm-footer-right">
                <ul>
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!---js-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/js/owl.carousel.min.js"></script>
<script>
$(document).ready(function() {
    $('.owl-ss').owlCarousel({
        loop: false,
        stagePadding: 8,
        navText:["<i class='fas fa-arrow-left'></i>","<i class='fas fa-arrow-right'></i>"],
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: false,
                margin: 20
            }
        }
    })
})
</script>
<script>
$(document).ready(function() {
    $('.owl-ss-semibaner').owlCarousel({
        loop: false,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false,
                margin: 20
            }
        }
    })
})
</script>

<!-- Modal -->
<div class="modal fade login-modl" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="del-logn-titl">
                    <h1>Login</h1>
                    <p>Enter your Mobile number below to continue</p>
                </div>
                <div id="login_form" class="del-logn-here">
                    <div class="del-logn-inp">
                        <label class="upd-pro-label" for="email"><img
                                src="<?php echo base_url(); ?>assets/frontend/images/phone-icon.png"></label>
                        <input type="number" id="login_phone" name="login_phone" placeholder="Mobile Number (10-digit)"
                            required data-parsley-required-message="Enter Mobile Number (10-digit)">
                    </div>
                    <div class="del-logn-sbmt">
                        <button class="btn btn-default" name="login_otp" id="login_otp" data-toggle="modal"
                            data-target="#otp-modal"><i class="fas fa-sign-in-alt"></i> Get OTP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--register -->
<div class="modal fade login-modl" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="register-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="del-logn-titl">
                    <h1>Signup</h1>
                    <p>Enter your details below to register</p>
                </div>
                <div id="registration_form" class="del-logn-here">
                    <!-- <form name="user_reg" id="user_reg" method="post" > -->
                    <div class="del-logn-inp">
                        <label class="upd-pro-label" for="name"><img
                                src="<?php echo base_url(); ?>assets/frontend/images/name-icon.png"></label>
                        <input type="text" id="mobile_no" placeholder="Enter Mobile Number (10-digit)" name="mobile_no"
                            data-parsley-required-message="Enter Mobile Number (10-digit)">
                    </div>
                    <div class="del-logn-sbmt">
                        <button name="signup_using_otp" id="signup_using_otp" data-toggle="modal"
                            data-target="#otp-modal">Signup Using OTP</button>
                    </div>
                    <div class="dnt-hv-acc">
                        <p>Already had an account? <button type="button" data-dismiss="modal" data-toggle="modal"
                                data-target="#login-modal">Login</button></p>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!--otp model -->
<div class="modal fade login-modl" id="otp-modal" tabindex="-1" role="dialog" aria-labelledby="otp-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="del-logn-titl">
                    <h1>Enter Your OTP</h1>
                    <p>Please check the OTP sent to your mobile number</p>
                    <div class="del-logn-shw-num">
                    <input type="text" id="change_mobile_no" readonly name="mobile_no" >
                    </div>
                </div>
                <div id="registration_form" class="del-logn-here">
                    <!-- <form name="user_reg" id="user_reg" method="post" > -->
                    <div class="del-logn-otp">
                        
                        <form method="get" class="digit-group" data-group-name="digits" data-autosubmit="false"
                            autocomplete="off">
                            <input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
                            <input type="text" id="digit-2" name="digit-2" data-next="digit-3"
                                data-previous="digit-1" />
                            <input type="text" id="digit-3" name="digit-3" data-next="digit-4"
                                data-previous="digit-2" />
                            <input type="text" id="digit-4" name="digit-4" data-next="digit-5"
                                data-previous="digit-3" />
                            
                        </form>
                    </div>
                    <div class="del-logn-sbmt">
                        <button name="signup" id="signup">Login</button>
                    </div>
                    <div id="time_counter"></div>
                    <div class="dnt-hv-acc">
                        <p>Didn't get OTP? <button type="button" id="resend_otp" onclick="resend_otp();">Resend</button></p>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--Forgot password -->
<div class="modal fade login-modl" id="forgotpassword-modal" tabindex="-1" role="dialog"
    aria-labelledby="forgotpassword-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="del-logn-titl">
                    <h1>Find Your Account</h1>
                    <p>Please enter your email address to search for your account.</p>
                </div>
                <div id="forgot_form" class="del-logn-here">
                    <form id="user_forgot" method="post">
                        <div class="del-logn-inp">
                            <label class="upd-pro-label" for="forgotemail"><img
                                    src="<?php echo base_url(); ?>assets/frontend/images/email-icon.png"></label>
                            <input type="email" id="forgotemail" placeholder="Enter email" name="forgotemail" required
                                data-parsley-required-message="Enter email">
                        </div>
                        <div class="del-logn-sbmt">
                            <button type="submit">Submit</button>
                        </div>
                        <div class="dnt-hv-acc">
                            <p>Remembered your password! <button type="button" data-dismiss="modal" data-toggle="modal"
                                    data-target="#login-modal"> Login</button></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Modal -->
<div class="modal fade cart-modl" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="cart-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="del-logn-titl" id="ajaxcart">
                    <h1>Cart</h1>
                    <div class="row"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Select Address-->
<div class="modal fade login-modl" id="address_selection_modal" tabindex="-1" role="dialog"
    aria-labelledby="address_selection_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="ss-address-select">
                    <h1>Select Your Address</h1>
                    <div class="ss-address-show">
                    <?php 
                    if(!empty($address_list)){
                        foreach ($address_list as $address) { ?>
                      
                        <div class="ss-address-box">
                            <div class="ss-address-rad">
                                <label class="radio">
                                <input type="radio" id="apartment_id" name="apartment_id" value="<?php echo $address['apartment_id']; ?>">
                                <span><?php echo $address['apartment_name']; ?>, <?php echo $address['apartment_address']; ?>, <?php echo $address['apartment_pincode']; ?>.</span>
                                </label>
                            </div>
                    
                    <div id="home_and_door" style="display: none;" class=" <?php echo $address['apartment_id']; ?> box">
                        <div class="ss-apt-info">
                            <div class="ss-apt-blk">
                            <input type="text" name="app_block_no" id="<?php echo $address['apartment_id']; ?>_app_block_no" placeholder="Block No">
                            </div>
                            <div class="ss-apt-flt">
                            <input type="text" name="app_flat_no" id="<?php echo $address['apartment_id']; ?>_app_flat_no" placeholder="Flat No">
                            </div>
                            <div class="ss-apt-submit">
                            <label for="address_submit"><i class="fas fa-arrow-right"></i></label>
                            <input type="button" class="d-none" name="address_submit" id="address_submit" value="Submit">
                            </div>
                          </div>
                       </div>
                     </div>
                   <?php } } ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Edit Delivery Address-->

<!--Select Delivery Address-->
<div class="modal fade login-modl" id="delivery_address_selection_modal" tabindex="-1" role="dialog"
    aria-labelledby="delivery_address_selection_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="ss-address-select">
                    <h1>Select Your Address</h1>
                    <div class="ss-address-show">
                    <?php 
                    if(!empty($address_list)){
                        foreach ($address_list as $address) { ?>
                      
                        <div class="ss-address-box">
                            <div class="ss-address-rad">
                                <label class="radio">
                                <input type="radio" id="delivery_apartment_id" name="delivery_apartment_id" value="<?php echo $address['apartment_id']; ?>">
                                <span><?php echo $address['apartment_name']; ?>, <?php echo $address['apartment_address']; ?>, <?php echo $address['apartment_pincode']; ?>.</span>
                                </label>
                            </div>
                    
                    <div id="home_and_door" style="display: none;" class=" <?php echo $address['apartment_id']; ?> box">
                        <div class="ss-apt-info">
                            <div class="ss-apt-blk">
                            <input type="text" name="delivery_app_block_no" id="<?php echo $address['apartment_id']; ?>_delivery_app_block_no" placeholder="Block No">
                            </div>
                            <div class="ss-apt-flt">
                            <input type="text" name="delivery_app_flat_no" id="<?php echo $address['apartment_id']; ?>_delivery_app_flat_no" placeholder="Flat No">
                            </div>
                            <div class="ss-apt-submit">
                            <label for="delivery_address_submit"><i class="fas fa-arrow-right"></i></label>
                            <input type="button" class="d-none" name="delivery_address_submit" id="delivery_address_submit" value="Submit">
                            </div>
                          </div>
                       </div>
                     </div>
                   <?php } } ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Edit Delivery Address-->

<div class="modal fade login-modl" id="edit_delivery_address" tabindex="-1" role="dialog"
    aria-labelledby="address_selection_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="ss-address-select">
                    <h1>Edit Delivery Address</h1>
                    <div class="ss-address-show">
                    <?php 
                    if(!empty($default_address)){ ?>
                      
                        <div class="ss-address-box">
                            <div class="ss-address-rad">
                                <label class="radio">
                                <input type="radio" id="d_apartment_id" name="d_apartment_id" value="<?php echo $default_address['apartment_id']; ?>" checked>
                                <span><?php echo $default_address['apartment_name']; ?>, <?php echo $default_address['apartment_address']; ?>, <?php echo $default_address['apartment_pincode']; ?>.</span>
                                </label>
                            </div>
                        <!-- <form method="post" name="default_address_save" id="default_address_save" action="<?php echo base_url(); ?>checkout/update_user_address"> -->
                            <input type="hidden" name="d_address_id" id="d_address_id" value="<?php echo $default_address['user_apartment_det_id']; ?>">
                        <div class="ss-apt-info">
                            <div class="ss-apt-blk">
                            <input type="text" name="d_app_block_no" id="d_app_block_no" placeholder="Block No" value="<?php echo $default_address['block_id']; ?>">
                            </div>
                            <div class="ss-apt-flt">
                            <input type="text" name="d_app_flat_no" id="d_app_flat_no" placeholder="Flat No" value="<?php echo $default_address['flat_id']; ?>">
                            </div>
                            <div class="ss-apt-submit">
                            <label for="update_delivery_address"><i class="fas fa-arrow-right"></i></label>
                            <input type="button" class="d-none" name="update_delivery_address" id="update_delivery_address" value="Submit">
                            </div>
                          </div>
                     </div>
                 <!-- </form> -->
                   <?php  } ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajax User Address -->
<div class="modal fade login-modl" id="ajax_edit_delivery_address" tabindex="-1" role="dialog"
    aria-labelledby="address_selection_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div id="ajax_delivery_address"></div>
            </div>
        </div>
    </div>
</div>
<!-- End Ajax User Address -->


<!-- Combo Modal -->
<div class="modal fade login-modl" id="combo-modal" tabindex="-1" role="dialog" aria-labelledby="combo-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="del-logn-cls">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="combo_cnt" id="combo_details">
                   
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Combo Modal -->

<script>
$(document).ready(function(){
$("#default_address_save").validate({
rules:{
    d_app_block_no:{required:true},
    d_app_flat_no:{required:true}
},
messages:{
    d_app_block_no:{required:'Please select block no'},
    d_app_flat_no:{required:'Please select flat no'}
},
ignore: []
});
});

$('#login_otp').prop('disabled', true);
$('#signup_using_otp').prop('disabled', true);

$("#login_phone").on("keyup", function(e) {
    var login_phone = $("#login_phone").val().length;
    // console.log(login_phone);
    if (login_phone == 10) {
       // $("#login_phone").rules("add", {
       //      required: true,
       //      minlenght: 100
       //  });
        $('#login_otp').prop('disabled', false);
    }else {
        $('#login_otp').prop('disabled', true);
    }
})

$("#mobile_no").on("keyup", function(e) {
    var mobile_no = $("#mobile_no").val().length;
     if (mobile_no >= 10) {
        $('#signup_using_otp').prop('disabled', false);
    }else if(mobile_no == 11) {
        alert();
        $("#signup_using_otp").rules("add", {
            required: true,
            minlenght: 100
        });
        $('#signup_using_otp').prop('disabled', true);
    }else {
        $('#signup_using_otp').prop('disabled', true);
    }
})

$('#login_otp').click(function() {
    var mobile_no = $("#login_phone").val();
    $("#login-modal").hide();
    $.ajax({
        url: '<?php echo site_url('home/signup_using_otp'); ?>',
        type: 'POST',
        data: {
            mobile_no: mobile_no
        },
        success: function(data) {
            $("#otp-modal").show();
            $("#change_mobile_no").val(mobile_no);
            $('#resend_otp').prop('disabled', true);
            countdown_timer();
        },
        error: function() {
           $.toast({heading:'Error',text:'Oops! Something Went to Wrong. Please try Again.',position:'top-right',stack: false,icon:'error'});
        }
    });
});

function countdown_timer(){
    $('#resend_otp').prop('disabled', true);
    var timeLeft1 = 30;
    var elem1 = document.getElementById('time_counter');
    var timerId1 = setInterval(countdown1, 1000);
    $('#time_counter').show();
        function countdown1()
        {
            if (timeLeft1 == -1) {
                clearTimeout(timerId1);
                countDownComplete();
            }else {
                elem1.innerHTML = '00:'+timeLeft1;
                timeLeft1--;
            }
        }
            function countDownComplete() 
            {
                $('#time_counter').hide();
                $('#resend_otp').prop('disabled', false);
            }
    }

$('#signup_using_otp').click(function() {
    var mobile_no = $("#mobile_no").val();
    $("#register-modal").hide();
    $.ajax({
        url: '<?php echo site_url('home/signup_using_otp'); ?>',
        type: 'POST',
        data: {
            mobile_no: mobile_no
        },
        success: function(data) {
            $("#otp-modal").show();
            $("#change_mobile_no").val(mobile_no);
        },
        error: function() {
           $.toast({heading:'Error',text:'Oops! Something Went to Wrong. Please try Again.',position:'top-right',stack: false,icon:'error'});
        }
    });
});

$('#signup').click(function() {
    var mobile_no = $("#change_mobile_no").val();
    var digit1 = $.trim($("#digit-1").val());
    var digit2 = $.trim($("#digit-2").val());
    var digit3 = $.trim($("#digit-3").val());
    var digit4 = $.trim($("#digit-4").val());
    if(digit1=='' || digit2=='' || digit3=='' || digit4==''){
        return false;
        
    }else{
         $("#register-modal").hide();
        $.ajax({
            url: '<?php echo site_url('home/chk_signup_otp'); ?>',
            type: 'POST',
            data: {mobile_no: mobile_no,digit1: digit1,digit2: digit2,digit3: digit3,digit4: digit4},
            success: function(data) {
                if (data == 1) {
                    $('#time_counter').hide();
                    $.toast({heading:'Success',text:'You Are Logged in Successfully...',position:'top-right',stack: false,icon:'success'});
                          setTimeout(function () {
                            location.reload(true);
                          }, 3000);
                }else {
                   $.toast({heading:'Error',text:'You Have Entered Incorrect OTP Please try Again.',position:'top-right',stack: false,icon:'error'});
                }
            },
            error: function() {
                 $.toast({heading:'Error',text:'Oops! Something Went to Wrong. Please try Again.',position:'top-right',stack: false,icon:'error'});
            }
        });
    }
});

$('.digit-group').find('input').each(function() {
    $(this).attr('maxlength', 1);
    $(this).on('keyup', function(e) {
        var parent = $($(this).parent());
        if (e.keyCode === 8 || e.keyCode === 37) {
            var prev = parent.find('input#' + $(this).data('previous'));

            if (prev.length) {
                $(prev).select();
            }
        } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e
                .keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
            var next = parent.find('input#' + $(this).data('next'));

            if (next.length) {
                $(next).select();
            } else {
                if (parent.data('autosubmit')) {
                    parent.submit();
                }
            }
        }
    });
});

$('input[name="apartment_id"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });

$('input[name="delivery_apartment_id"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });

$('#address_submit').click( function() {
    var apartment_id = $('input[name="apartment_id"]:checked').val();
    var app_block_no =$("#"+apartment_id+'_'+'app_block_no').val();
    var app_flat_no =$("#"+apartment_id+'_'+'app_flat_no').val();
        if(app_block_no=='' || app_flat_no==''){
            $.toast({heading:'Error',text:'Please Enter Block No And Flat No',position:'top-right',stack: false,icon:'error'});
          return false;  
        }
      $.ajax({
        url: '<?php echo site_url('profile/save_user_address'); ?>',
        type: 'POST',
        dataType:'json',
        data: {apartment_id: apartment_id,app_block_no: app_block_no,app_flat_no: app_flat_no},
        success: function(data) {
           if(data==1){
            location.reload();
           }else if(data==2){
                $.toast({heading:'Error',text:'This Address Already Saved... Please Enter Valid Address',position:'top-right',stack: false,icon:'error'});
           }else{
           $.toast({heading:'Error',text:'Opps! Your Address Not Saved Please try Again..',position:'top-right',stack: false,icon:'error'});
           }
        }
    });
});

$('#delivery_address_submit').click( function() {
    var apartment_id = $('input[name="delivery_apartment_id"]:checked').val();
    var app_block_no =$("#"+apartment_id+'_'+'delivery_app_block_no').val();
    var app_flat_no =$("#"+apartment_id+'_'+'delivery_app_flat_no').val();
    if(app_block_no=='' || app_flat_no==''){
            $.toast({heading:'Error',text:'Please Enter Block No And Flat No',position:'top-right',stack: false,icon:'error'});
          return false;  
        }
      $.ajax({
        url: '<?php echo site_url('checkout/save_user_delivery_address'); ?>',
        type: 'POST',
        dataType:'json',
        data: {apartment_id: apartment_id,app_block_no: app_block_no,app_flat_no: app_flat_no},
        success: function(data) {
            var name =data['name'];
            var block_id =data['block_id'];
            var flat_id =data['flat_id'];
            var apartment_name =data['apartment_name'];
            var apartment_address =data['apartment_address'];
            var apartment_pincode =data['apartment_pincode'];
            var phone =data['phone'];
           if(data==0){
                $('#delivery_address_selection_modal').modal('hide');
                $.toast({heading:'Error',text:'Opps! Your Address Not Saved Please try Again..',position:'top-right',stack: false,icon:'error'});
           }else if(data==2){
                $.toast({heading:'Error',text:'This Address Already Saved... Please Enter Valid Address',position:'top-right',stack: false,icon:'error'});
           }else{
                $('#delivery_add_empty').remove();
                $('#delivery_address_selection_modal').modal('hide');
                $('.ajax_add_delivery_save_address').html('<div class="address_default_address_left"><label class="address_page_radio"><input type="radio" name="default_address" id="default_address" checked><span><div class="address_page_radio_defaultaddress"><h3 class="address_page_defaultaddress_holder">'+name+'</h3><div class="address_page_defaultaddress_content">Block No:<span id="delivery_add_blockno">'+block_id+'</span>,Flot No:<span id="delivery_add_floatno">'+flat_id+'</span>,'+apartment_name+', '+apartment_address+' - '+apartment_pincode+'</div><div class="address_page_defaultaddress_content">Mobile - <span class="font_bold">'+phone+'</span></div></div></span></label><div class="address_default_address_right"><button type="button" onclick="ajax_edit_delivery_address();">Edit</button></div></div>');
                $('.no_address_found').hide();
                $.toast({heading:'Success',text:'Your Address Saved Successfully..',position:'top-right',stack: false,icon:'success'});
           }
        }
    });
});

function ajax_edit_delivery_address() 
{
     $.ajax({
        url: '<?php echo base_url('product/ajaxcall_get_user_address'); ?>',
        success: function(data) {
            $('#ajax_edit_delivery_address').modal();
            $('#ajax_delivery_address').html(data);
        }
    });
    
}
function resend_otp(){
    $('#time_counter').html('');
    countdown_timer();
    var mobile_no =$('#change_mobile_no').val();
         $.ajax({
            url: '<?php echo site_url('home/resend_otp'); ?>',
            type: 'POST',
            data: {mobile_no: mobile_no},
            dataType: 'json',
            success: function(data) {
               if (data == 1) {
                    $.toast({heading:'Success',text:'OTP Sent Successfully...',position:'top-right',stack: false,icon:'success'});
                }else {
                   $.toast({heading:'Error',text:'OTP Sent Failed Please try Again.',position:'top-right',stack: false,icon:'error'});
                }
            }
        });
}

    function addtowishlist(prod_id, type) {
       var user_id = '<?php echo $this->session->userdata("user_id");?>';
       if(user_id!=''){
             $.ajax({
                 url: '<?php echo site_url('profile/addtowishlist'); ?>',
                 type: 'POST',
                 data: {
                     user_id: user_id,
                     prod_id: prod_id
                 },
                 success: function(result) {
                     if ($.trim(result) == 1) {
                         $('a[data-id=wish_' + type + '_' + prod_id + ']').addClass('wishlist_active');
                         $.toast({heading:'Success',text:'Added to your wishlist successfully...',position:'top-right',stack: false,icon:'success'});
                     }else {
                         $('a[data-id=wish_' + type + '_' + prod_id + ']').removeClass('wishlist_active');
                         $.toast({heading:'Success',text:'Removed from your wishlist successfully...',position:'top-right',stack: false,icon:'success'});
                     }
                 }
             });
      }else{
         $('#login-modal').modal('show');
       }      
   }

function remove_coupon(){
    $.ajax({
        url: '<?php echo site_url('cart/remove_coupon'); ?>',
        type: 'POST',
        success: function(data) {
          if(data==1){
             var final_order_amt = $("#cart_totl_amnt").html();
            $("#coupon_code").val('');
            $("#discount").html(0);
            $("#final_order_amt").html(final_order_amt);
            $("#coupon_code").prop('disabled', false);
            $("#coupon_code").removeAttr("readonly");
            $("#coupon_remove").html('<input type="button" class="cart_page_coupon_apply" name="coupon" id="coupon" value="Apply" onclick="apply_coupon();" />');
          }else{
            alert('fail');
          }
         
        }
    });
}
</script>
<script>
  $(function() {  
    $(".nicescroll").niceScroll({cursorcolor:"rgb(115 1 174 / 25%)"});
});
</script>

<script>
function change_prod_mesid(idtype,sel, id, pid)
{
    var prod_mes_id = sel.value;
    $.ajax({
           url: '<?php echo site_url('home/get_measurement_id_by_products'); ?>',
           type: 'POST',
           dataType: 'json',
           data: {id:id,prod_mes_id: prod_mes_id},
           success: function(response) {
               var rowid = response.rowid;
               var img = response.img;
               var prod_org_price = response.prod_org_price;
               var prod_offered_price = response.prod_offered_price;
               var prod_id1 = response.prod_id;
               var prod_mes_id1 = response.prod_mes_id;
               var prod_mes_title1 = response.prod_mes_title;
               // alert(prod_mes_title1);
               var prod_mes_title = response.prod_mes_title;
               var chk_prod_exits = response.chk_prod_exits;
               var prod_mes_id_qty = response.prod_mes_id_qty;
               $('#'+idtype+'_'+pid).val(prod_mes_title1);
               // alert(('#'+idtype+'_'+pid));
              // $(".selectpicker_"+prod_id1).selectpicker('refresh');
              // $(".selectpicker_"+prod_id1).val(prod_mes_title1);
              // $('.selectpicker_'+prod_id1).val(prod_mes_title1);
               // alert($("#"+idtype+"_"+pid).val(prod_mes_title1));
               // alert(idtype);
               if(idtype==1){
                    $('.'+idtype+'_'+'img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.'+idtype+'_'+'prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.'+idtype+'_'+'prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.'+idtype+'_'+'img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.'+idtype+'_'+'prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.'+idtype+'_'+'prod_offered_price_' + prod_id1).text(prod_offered_price);

                    
                     // alert(('#2_'+pid));
                     // $(".selectpicker selectpicker_4").selectpicker('refresh');
              // $(".selectpicker_"+prod_id1).val(prod_mes_title1);
              // $('#2_'+pid).val(prod_mes_title1);
              // $('.selectpicker').selectpicker('refresh');
              $(".selectpicker_"+prod_id1).val(prod_mes_id1).selectpicker("refresh");
             
               // $(".selectpicker").val(prod_mes_title1);
               // $(".selectpicker_"+prod_id1).val(prod_mes_title1);
                    $('.2_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.2_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.2_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.2_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.2_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.2_prod_offered_price_' + prod_id1).text(prod_offered_price);

                    $('.3_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.3_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.3_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.3_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.3_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.3_prod_offered_price_' + prod_id1).text(prod_offered_price);

                    $('.4_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.4_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.4_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.4_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.4_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.4_prod_offered_price_' + prod_id1).text(prod_offered_price);
               }else if(idtype==3){
                    $('.'+idtype+'_'+'img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.'+idtype+'_'+'prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.'+idtype+'_'+'prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.'+idtype+'_'+'img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.'+idtype+'_'+'prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.'+idtype+'_'+'prod_offered_price_' + prod_id1).text(prod_offered_price);

                    $(".selectpicker_"+prod_id1).val(prod_mes_id1).selectpicker("refresh");
                    $('#2_'+pid).val(prod_mes_title1);
                    $('.2_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.2_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.2_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.2_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.2_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.2_prod_offered_price_' + prod_id1).text(prod_offered_price);

                    $('#1_'+pid).val(prod_mes_title1);
                    $('.1_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.1_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.1_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.1_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.1_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.1_prod_offered_price_' + prod_id1).text(prod_offered_price);
               }else {
                    $('.'+idtype+'_'+'img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.'+idtype+'_'+'prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.'+idtype+'_'+'prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.'+idtype+'_'+'img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.'+idtype+'_'+'prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.'+idtype+'_'+'prod_offered_price_' + prod_id1).text(prod_offered_price);

                    $(".selectpicker_"+prod_id1).val(prod_mes_id1).selectpicker("refresh");
                    $('#1_'+pid).val(prod_mes_title1);
                    $('.1_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.1_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.1_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.1_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.1_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.1_prod_offered_price_' + prod_id1).text(prod_offered_price);

                    // $('#1_'+pid).val(prod_mes_title1);
                    $('.3_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.3_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.3_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.1_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.3_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.3_prod_offered_price_' + prod_id1).text(prod_offered_price);

                    $('.4_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.4_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.4_prod_offered_price_' + prod_id1).text(prod_offered_price);
                    $('.4_img_id_' + prod_id1).html("<img class="+idtype+"_"+"change-image_" + pid + " src=" + img +" alt='product img' style='width:100%' >");
                    $('.4_prod_org_price_' + prod_id1).text(prod_org_price);
                    $('.4_prod_offered_price_' + prod_id1).text(prod_offered_price);
               }
               
               if (chk_prod_exits!= ''){
                 $(".1_addtocart_" + prod_id1).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin " id="input_div"><button type="button" value="-" onclick="minus(1,' +prod_id1 + ',' + prod_mes_id1 +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' +prod_mes_id + '" type="text" size="25" value=' + prod_mes_id_qty +' readonly /><button type="button" value="+" onclick="plus(1,' +prod_id1 + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                 $(".2_addtocart_" + prod_id1).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin " id="input_div"><button type="button" value="-" onclick="minus(1,' +prod_id1 + ',' + prod_mes_id1 +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' +prod_mes_id + '" type="text" size="25" value=' + prod_mes_id_qty +' readonly /><button type="button" value="+" onclick="plus(2,' +prod_id1 + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                 $(".3_addtocart_" + prod_id1).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin " id="input_div"><button type="button" value="-" onclick="minus(1,' +prod_id1 + ',' + prod_mes_id1 +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' +prod_mes_id + '" type="text" size="25" value=' + prod_mes_id_qty +' readonly /><button type="button" value="+" onclick="plus(3,' +prod_id1 + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                 $(".4_addtocart_" + prod_id1).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin " id="input_div"><button type="button" value="-" onclick="minus(1,' +prod_id1 + ',' + prod_mes_id1 +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' +prod_mes_id + '" type="text" size="25" value=' + prod_mes_id_qty +' readonly /><button type="button" value="+" onclick="plus(4,' +prod_id1 + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                 $(".5_addtocart_" + prod_id1).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin " id="input_div"><button type="button" value="-" onclick="minus(1,' +prod_id1 + ',' + prod_mes_id1 +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' +prod_mes_id + '" type="text" size="25" value=' + prod_mes_id_qty +' readonly /><button type="button" value="+" onclick="plus(5,' +prod_id1 + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
               }else{
                    // $(".addtocart_" + prod_id1).html(
                    //        "<div class='prodct-add'><button class='button' onclick='addtocart(" +prod_id1 + "," + prod_mes_id + "," +prod_mes_title + ")'>ChAddd</button></div>");
                     $(".1_addtocart_" + prod_id1).html('<div class="prodct-add"><button class="addcrtbn" onclick="addtocart('+idtype+','+prod_id1+','+prod_mes_id+')">Add</button></div>');
                     $(".2_addtocart_" + prod_id1).html('<div class="prodct-add"><button class="addcrtbn" onclick="addtocart('+idtype+','+prod_id1+','+prod_mes_id+')">Add</button></div>');
                     $(".3_addtocart_" + prod_id1).html('<div class="prodct-add"><button class="addcrtbn" onclick="addtocart('+idtype+','+prod_id1+','+prod_mes_id+')">Add</button></div>');
                     $(".4_addtocart_" + prod_id1).html('<div class="prodct-add"><button class="addcrtbn" onclick="addtocart('+idtype+','+prod_id1+','+prod_mes_id+')">Add</button></div>');
                     $(".5_addtocart_" + prod_id1).html('<div class="prodct-add"><button class="addcrtbn" onclick="addtocart('+idtype+','+prod_id1+','+prod_mes_id+')">Add</button></div>');
               }
   
           }
       });
   }
   
   function addtocart(idtype,prod_id,prod_mes_id) {
       var prod_title = $('.'+idtype+'_'+'prod_title_' + prod_id).text();
       var prod_mes_title = $('#'+idtype+'_'+prod_id).val();
       var prod_available_qty = $("#prod_available_qty_" + prod_id).val();
       var prod_org_price = $('.'+idtype+'_'+'prod_org_price_' + prod_id).html();
       var prod_offered_price = $('.'+idtype+'_'+'prod_offered_price_' + prod_id).html();
       var prod_img = $('.'+idtype+'_'+'change-image_' + prod_id).attr('src');
       var qty = $("#qty").val();
       var url = '<?php echo base_url();?>';
       $.ajax({
           url: '<?php echo site_url('home/addtocart'); ?>',
           type: 'POST',
           data: {prod_id: prod_id,prod_mes_title: prod_mes_title,prod_title: prod_title,prod_mes_id: prod_mes_id,prod_available_qty: prod_available_qty,prod_org_price: prod_org_price,
               prod_offered_price: prod_offered_price,prod_img: prod_img},
           dataType: 'json',
           success: function(data){
             var rowid = data.rowid;
             // var sdsdfdsds =rowid.replace(/\s+/g, " ").trim();
             var cart_count = data.cart_count;
             // alert(rowid);
               $("#cart_count").html(cart_count);
               // alert(('.'+idtype+'_'+"addtocart_" + prod_id));
               $(".1_addtocart_" + prod_id).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +
                   prod_id + ',' + prod_mes_id +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value="1" readonly/><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
               $(".2_addtocart_" + prod_id).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +
                   prod_id + ',' + prod_mes_id +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value="1" readonly/><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
               $(".3_addtocart_" + prod_id).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +
                   prod_id + ',' + prod_mes_id +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value="1" readonly/><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                $(".4_addtocart_" + prod_id).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +
                   prod_id + ',' + prod_mes_id +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value="1" readonly/><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
                $(".5_addtocart_" + prod_id).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +prod_id + ',' + prod_mes_id +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value="1" readonly/><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');

                $(".pdetails_addtocart_" + prod_id).html('<div class="prodct-add-plsmin"><div class="prodct-plsmin" id="input_div"><button type="button" onclick="minus(' +idtype + ',' +prod_id + ',' + prod_mes_id +',\''+rowid+'\')"><i class="fas fa-minus"></i></button><input class="plsmin-vlue chck_qty_' + prod_mes_id +'" type="text" size="25" value="1" readonly/><button type="button" onclick="plus(' +idtype + ',' +prod_id + ',' +prod_mes_id + ',\''+rowid+'\')"><i class="fas fa-plus"></i></button></div></div>');
           }
       });
   }
   
function plus(id_type,prod_id,prod_mes_id,rowid) {
       var qty = parseInt($('.chck_qty_' + prod_mes_id).val());
       var price = parseInt($('.prod_price_' + prod_mes_id).val());
       $.ajax({
           url: '<?php echo site_url('home/plus_prod_qty'); ?>',
           type: 'POST',
           data: {prod_id: prod_id,prod_mes_id: prod_mes_id,qty: qty,rowid: rowid},
           success: function(data) {
               if(data=='no_qty') {
                   $.toast({heading:'Error',text:'Sorry! We don"t much have stock',position:'top-right',stack: false,icon:'error'});
               }else if(data=='error'){
                  $.toast({heading:'Error',text:'Opps! something went to wrong...',position:'top-right',stack: false,icon:'error'});
               }else{
                    $('.chck_qty_' + prod_mes_id).val(qty + 1);
                    var final_qty =(qty + 1);
                    var mesprice =final_qty*price;
                    $('#price_'+prod_mes_id).html(mesprice);
                    $('#final_order_amt').html(data);
                    $('#cart_totl_amnt').html(data);
               }
           }
       });
   }
 
$('#update_delivery_address').click( function() {
    var d_address_id = $('#d_address_id').val();
    var d_app_block_no =$("#d_app_block_no").val();
    var d_app_flat_no =$("#d_app_flat_no").val();
    if($.trim(d_app_block_no)=='' || $.trim(d_app_flat_no)==''){
        $.toast({heading:'Error',text:'Please Enter Block No and Flat No',position:'top-right',stack: false,icon:'error'});
        return false;
    }
      $.ajax({
        url: '<?php echo site_url('checkout/update_user_address'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {d_address_id: d_address_id,d_app_block_no: d_app_block_no,d_app_flat_no: d_app_flat_no},
        success: function(data) {
           if(data==0){
             $.toast({heading:'Error',text:'Opps! Your Address Not Saved Please try Again..',position:'top-right',stack: false,icon:'error'});

           }else{
              $('#delivery_add_blockno').html(data['d_app_block_no']);
              $('#delivery_add_floatno').html(data['d_app_flat_no']);
              $('#delivery_add_blockno').html(data['d_app_block_no']);
              $('#delivery_add_floatno').html(data['d_app_flat_no']);
              $('#edit_delivery_address').modal('hide');
                $.toast({heading:'Success',text:'Delivery Address Updated Successfully...',position:'top-right',stack: false,icon:'success'});
           }
        }
    });
}); 

function view_combos(prod_id){
    $.ajax({
          url: '<?php echo site_url('product/get_combo_details'); ?>',
          type: 'POST',
          data: {prod_id: prod_id},
          success: function(data) {
             $('#combo_details').html(data);
             $('#combo-modal').modal('show');
          },error: function (request, status, error) {
              $.toast({heading:'Error',text:'Opps! something went to wrong...',position:'top-right',stack: false,icon:'error'});
           }
      });
 } 

</script>
</body>

</html>