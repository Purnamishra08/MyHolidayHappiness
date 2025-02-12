<?php
if (!empty($inquiry_details)) {
	foreach ($inquiry_details as $rows)
	{
		$enq_id  		= $rows['enq_id'];
		$first_name 	= $rows['first_name'];
		$last_name 		= $rows['last_name'];
		$emailid 		= $rows['emailid'];
		$phone 			= $rows['phone'];
		$enq_message 	= $rows['message'];
		
		$noof_adult 	= $rows['noof_adult'];		
		$noof_child 	= $rows['noof_child'];		
		$tour_date 		= $rows['tour_date'];		
		$inquiry_date 	= $rows['inquiry_date'];
		
		$accomodation 	= $rows['accomodation'];
		$accomodation_name = $this->Common_model->showname_fromid("hotel_type_name","tbl_hotel_type","hotel_type_id = $accomodation");
		
		$packageid   	= $rows['packageid'];
		$package_name 	= $this->Common_model->showname_fromid("tpackage_name","tbl_tourpackages","tourpackageid = $packageid");	
	} 
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include("head.php"); ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php include("header.php"); ?>
            <?php include("sidemenu.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-question-circle"></i>
                    </div>
                    <div class="header-title">
                        <h1>Package Enquiry</h1>
                        <small>View Package Enquiry</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/package-enquiry">
                                            <h4><i class="fa fa-plus-circle"></i>Manage Package Enquiry</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										
										 <div class="col-md-6">
                                            <div class="gap row">
                                                <div class="col-md-4"> <label> Package Name </label></div>
                                                <div class="col-md-8"><?php echo $package_name; ?></div>
                                            </div>
                                        </div>  
   
                                        <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Enquiry Date</label></div>
												<div class="col-md-8"> <?php echo $this->Common_model->dateformat($inquiry_date); ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>First Name</label></div>
												<div class="col-md-8"><?php echo $first_name; ?></div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Last Name</label></div>
												<div class="col-md-8"> <?php echo $last_name ; ?></div>
											</div>
										</div>
																				
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Email Id</label></div>
												<div class="col-md-8"><?php echo $emailid; ?></div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Phone no</label></div>
												<div class="col-md-8"> <?php echo $phone ; ?></div>
											</div>
										</div>
																				
										<div class="clearfix"></div>
										
                                        <div class="col-md-6">
                                            <div class="gap row">
                                                <div class="col-md-4"> <label>No of Adult</label></div>
                                                <div class="col-md-8"><?php echo $noof_adult; ?></div>
                                            </div>
                                        </div>  
   
                                        <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>No of Child</label></div>
												<div class="col-md-8"> <?php echo $noof_child; ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
                                            <div class="gap row">
                                                <div class="col-md-4"> <label>Date of Travel</label></div>
                                                <div class="col-md-8"><?php echo $this->Common_model->dateformat($tour_date); ?></div>
                                            </div>
                                        </div>  
   
                                        <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Accomodation Type</label></div>
												<div class="col-md-8"> <?php echo $accomodation_name; ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
                                     
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Enquiry Details</label></div>
												<div class="col-md-10"> <?php echo $enq_message; ?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>

										<hr>
                               
										<?php echo form_open('', array( 'id' => 'form_packagereply', 'name' => 'form_packagereply', 'class' => 'add-user'));?>
											<?php echo $message; ?>
											<div class="col-md-12">
												<div class="form-group">
													<label>Send Reply</label>
													<textarea class="form-control" rows="10" name="reply" id="reply" style="margin: 0px 617px 0px 0px; width: 474px; height: 211px;"></textarea>
													<input type="hidden" name="enq_id" value="<?php echo $enq_id ; ?>">
												</div>
											</div>
											<div class="clearfix"></div>											
											<div class="col-md-6">
												<div class="reset-button"> 
													<button class="redbtn" type="submit" name="btnReply" id="btnReply">Reply</button>
												</div>
											</div>
										<?php echo form_close(); ?>

										<div style="margin-top: 5px;"><hr></div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-12">Messages has been already sent:</label>

                                                <?php 
                                                    $getPreviousMessages = $this->Common_model->get_records("*","tbl_reply_enquiry","enq_id='$enq_id' AND type = 3","enq_id ASC"); 
                                                    if($getPreviousMessages){
														$count=0;
														foreach ($getPreviousMessages as $getPreviousMessage) { 
                                                ?>
                                                    <div class="col-md-10 msgsection"><span class="messagedate"><?php echo $this->Common_model->dateformat($getPreviousMessage['created_date']); ?> :</span> <?php echo $getPreviousMessage['message']; ?> </div>
                                                <?php 
															$count++ ;
														} 
                                                    } else 
													{ 
												?>
                                                    <div class="col-md-10 msgsection"> <?php echo "No messages sent yet"; ?> </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                     

                                </div>
                                                     
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php include("footer.php"); ?>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    </body>
</html>

