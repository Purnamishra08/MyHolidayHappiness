<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?> 
	</head>
    <body>
      <?php include("header.php"); ?> 

        <section>
            <img src="<?php echo base_url(); ?>assets/images/loginbanner.jpg" class="img-fluid">  
        </section>

        <div class="container  mt60 mb100">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 formboxholder text-center">
                    <h1 class="mb-4">Sign in with My Holiday Happiness</h1>
					<?php echo $message; ?>
                    <?php echo form_open(base_url( 'login' ), array( 'id' => 'form_login', 'name' => 'form_login', 'class' =>'row' ));?>
                        <div class="col-md-12">
                            <div class="form-group">                                
                               <input type="email" class="form-control" name="login_email" id="login_email" placeholder="Email address">                               
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                 <input type="password" class="form-control" name="login_password" id="login_password" placeholder="Password">
                            </div>
                        </div>                                  
                        <div class="col-md-12">
							<button type="submit" class="btn requestquotebtn" name="btnSignincust" id="btnSignincust">SignIn</button>
							<!--  <button type="button" class="btn requestquotebtn">SignIn</button> -->
						</div>
						<div class="col-md-12 loginheretxt">
                            <p>New User ? <a href="<?php echo base_url(); ?>register">Signup Here</a></p>
						</div>
                    <?php echo form_close();?>
                    
					<div class="col-md-12 forgotpassword-div">
						<a href="" data-toggle="modal" data-target="#forgotpassword">Forgot password?</a>
					</div> 
					
                    <!--div style="border-top:#ddd 1px solid">
						<div style="margin-top: -14px;margin-bottom: 10px;text-align: center;">
							<span style="background: #fff;padding: 10px;">or</span>
						</div>
					</div>
                    <div class="loginimgholder ">  
						<a href=""> <img src="<?php echo base_url(); ?>assets/images/fbookbtn.jpg" class="img-fluid"></a>
                        <a href=""> <img src="<?php echo base_url(); ?>assets/images/gplusbtn.png" class="img-fluid"></a>
					</div-->
					
                </div>
                <div class="col-md-3"></div>
                <div class="claerfix"></div>
            </div>
        </div>
		
		<div class="modal fade" id="forgotpassword">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header --> 
                    <div class="modal-header">
                        <h2 class="modal-title">Forgot password?</h2>                        
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="frmError"></div>
                        <?php echo form_open('', array('name'=>'forgot_password', 'id'=>'forgot_password', 'class' =>'row' ));?>
							<div class="col-md-12">
								<div class="form-group">                                
									<input type="text" class="form-control" name="forgotemail" id="forgotemail" placeholder="Email address">
								</div>
							</div>                   
							<div class="col-md-12"><button  type="submit" id="forgot-e" class="btn requestquotebtn">Submit</button></div>
							<div id="frmError"></div>
                        <?php echo form_close();?>                        
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
       
		<?php include("footer.php"); ?> 

       <!-- <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script> -->

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
        <script src="<?php echo base_url(); ?>assets/js_validation/validation.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> 
        
          
        <script> 
			
            $(function () {
                $('.selectpicker').selectpicker();
            });
       
        </script>

        <script type="text/javascript">
			$(document).ready(function(){
				jQuery("#forgot_password").validate({
					rules: {            
						forgotemail: {
							required: true,
							email: true
						}
					},
					messages:{
						forgotemail:{
							required:"Enter email id",
							email:"Invalid email id"
						}
					},
					submitHandler: function(form) {
						var forgotemail = $("#forgotemail").val();
						//alert(forgotemail);
						$('#frmError').html('<div style="text-align:center"><i style="color:#377b9e" class="fa fa-spinner fa-spin fa-1x"></i> <span style="color:#377b9e">Processing...</span></div>');
						$.ajax({
							type: "POST",
							data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
							url: "<?php echo base_url(); ?>login/forgot_email/?forgotemail="+forgotemail,
							success: function(result) {
								//alert(result);
								if (result == '1') {
									jQuery("#frmError").html('<div class="successmsg"><i class="fa fa-check"></i> A link has been sent to your Email ID to change your password.</div>');
									jQuery('#forgot_password')[0].reset();
								} else if(result == '2') {
									jQuery("#frmError").html('<div class="errormsg"><i class="fa fa-times"></i> Unable to process your request.</div>');
								}else if(result == '3') {
									jQuery("#frmError").html('<div class="errormsg"><i class="fa fa-times"></i> This email id is inactive.</div>');
								}else{
									jQuery("#frmError").html('<div class="errormsg"><i class="fa fa-times"></i>Invalid email id.</div>');
								}
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
								$('#frmError').html('<div class="errormsg"><i class="fa fa-times"></i> Invalid Username or Password.</div>');
							}
						});
						return false;
					}
				});    
			});    
		</script>   

       
    </body>
</html>