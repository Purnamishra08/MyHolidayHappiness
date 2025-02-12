<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 
    </head>
    <body>
        <?php include("header.php"); ?>      

        <section>
            <img src="<?php echo base_url(); ?>assets/images/reviewbanner.jpg" class="img-fluid" alt="Travel agents advertise"/>  
        </section>

        <div class="container  ">
            <ul class="cbreadcrumb my-4">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">Advertise</a></li>
                </ul>
            <div class="about-content-text">
                <?php
					$advertise=$this->Common_model->showname_fromid("page_content","tbl_contents","content_id='9'");
					echo $advertise; 
				?> 

                <div class="row">

                    <div class="col-md-12 mt-3 mb-3"><hr></div>                
                    <div class="col-md-12 text-center ">
                        <h2>Didn't find an answer to your question?</h2>
                        <p>Get in touch with us for details on additional services and custom work pricing</p>
                        <a href="#" class="faqbtn" data-toggle="modal" data-target="#Inr_Contact">Contact us</a>


                    </div> 
                    <div class="col-md-12 mt-3 mb-3"><hr></div>                
                </div>
            </div>
            <div class="modal fade show" id="Inr_Contact" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content book-login-bg height-auto">

                        <!-- Modal Header -->
                        <button type="button" class="close book-close" data-dismiss="modal">&times;</button>
                        <div class="modal-body">
                            <div class="login-txt-hdng"> Contact Us</div>
							<?php echo form_open(base_url('contactus'), array( 'id' => 'form_contact', 'name' => 'form_contact'));?>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="pack-enquiry-fld" placeholder="Full Name" name="cont_name" id="cont_name" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="pack-enquiry-fld" placeholder="Contact No" name="cont_phone" id="cont_phone"  >
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="email" class="pack-enquiry-fld" placeholder="Your Email" name="cont_email" id="cont_email" >
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group">
											<textarea class="pack-enquiry-fld  txt-height" placeholder="Message" name="cont_details" id="cont_details"></textarea>
										</div>
									</div>
									<div class="col-md-4">
										<input type="hidden" name="pagename" id="pagename" value="Advertise Page">
										<button type="submit" class="pack-enquiry-submit">Submit</button>
									</div>
									<div class="col-md-8">
										<div id="errMessage"></div>
									</div>
								</div>
							<?php echo form_close();?>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?> 
		
		<script>var base_url = "<?php echo base_url(); ?>";</script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
        <script src="<?php echo base_url(); ?>assets/js_validation/validation.js"></script>

    </body>
</html>
