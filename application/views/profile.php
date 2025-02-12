<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 
        <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/input-material.css' ?>">
    </head>
    <body>
        <?php include("header.php"); ?> 

        <section class="main">
            <div id="ri-grid" class="ri-grid ri-grid-size-2 ">
                <img class="ri-loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif"/>
                <ul>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/1.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/2.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/3.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/4.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/5.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/6.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/7.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/8.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/9.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/10.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/11.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/12.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/13.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/14.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/15.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/16.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/17.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/18.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/19.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/20.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/21.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/22.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/23.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/24.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/25.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/26.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/27.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/28.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/29.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/30.jpg" alt=""/></a></li>

                </ul>
            </div>              
        </section>


        <div class="container  mt60 mb100">
            <h1 class="mb20"> Profile </h1>

            <div class="row">




                <div class="col-xl-7 col-lg-7">
                    <div class="profile-txt-sec">
                        <h5>Update Profile Details</h5>
						<?php echo $message; ?>    
						<?php 
						foreach($customers as $customer)
						{
							$customer_id = $customer['customer_id'];
							$fullname = $customer['fullname'];
							$email_id = $customer['email_id'];
							$contact = $customer['contact'];
						}
						?>
						<?php echo form_open(base_url('profile'), array( 'id' => 'form_profile', 'name' => 'form_profile', 'class' => 'profile-form' ));?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name *" value="<?php echo $fullname; ?>">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="emailida" id="emailida" placeholder="Email Id *" value="<?php echo $email_id; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="contact" id="contact" placeholder="Mobile No *" value="<?php echo $contact; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary profileSubmit" name="updateProfile">Update</button>
                        <?php echo form_close();?>

                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="profile-chng-pwd">
                        <h5> Change Password</h5>
						<?php echo $m_message; ?>    
						<?php echo form_open(base_url('profile'), array( 'id' => 'change_password', 'name' => 'change_password'));?>
							<div class="form-group input-material">
								<input type="password" class="form-control" id="new_pwd" name="new_pwd" maxlength="20"/>
								<label for="name-field">New Password</label>
							</div>

							<div class="form-group input-material">
								<input type="password" class="form-control" id="cnf_pwd" name="cnf_pwd" maxlength="20"/>
								<label for="name-field">Confirm New Password</label>
							</div>
							<button type="submit" class="btn btn-primary contactsubmit" id="btnSubmit" name="btnSubmit">Submit</button>
						<?php echo form_close();?>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
        </div>


        <?php include("footer.php"); ?> 

        <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.gridrotator.js"></script>
        <script type="text/javascript">
            $(function () {

                $('#ri-grid').gridrotator({
                    rows: 2,
                    columns: 10,
                    animType: 'fadeInOut',
                    animSpeed: 1000,
                    interval: 600,
                    step: 1,
                    w320: {
                        rows: 3,
                        columns: 4
                    },
                    w240: {
                        rows: 3,
                        columns: 4
                    }
                });

            });
        </script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
        <script>
            jQuery(document).ready(function () {
				
                jQuery.validator.addMethod("regex",function(value,element,regexp){
					var re= new RegExp(regexp);
					return this.optional(element) || re.test(value);
				},"Remove Special Chars");
				
				jQuery("#form_profile").validate({
					rules: {
						fullname: {
							required: true                
						},
						contact: {
							required: true
						}
					},
					messages: {
						fullname: {
						   required: "Enter full name."                
						},
						contact: {
							required: "Enter phone no."
						}          
					}        
				});
				
				jQuery("#change_password").validate({
					rules: {
						new_pwd: {
							required: true,
							regex:"^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
							rangelength: [6, 12]
						},
						cnf_pwd: {
							required: true,
							equalTo: "#new_pwd"
						}
					},
					messages:{
						new_pwd: {
							required:"Enter new password.",
							rangelength:"Password length must be between {0} to {1}"
						},
						cnf_pwd: {
							required:"Enter confirm password.",
							equalTo: "Enter same password again."
						}			
					}
				});
			});
		</script>   


    </body>
</html>