<?php
if (!empty($ITIENQdETAIL)) {
	foreach ($ITIENQdETAIL as $rows)
	{
		$tripcust_id = $rows['tripcust_id'];
		$email = $rows['email'];
		$phone = $rows['phone'];
		$tsdate = $rows['tsdate'];
		$duration = $rows['duration'];
		$tnote = $rows['tnote'];
		$itinerary_id = $rows['itinerary_id'];
		$package_id = $rows['package_id'];
		
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
                        <h1>Itinerary Enquiry</h1>
                        <small>View Itinerary Enquiry</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/itinerary-enquiry">
                                            <h4><i class="fa fa-plus-circle"></i>Manage Itinerary Enquiry</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										
										 <div class="col-md-6">
                                            <div class="gap row">
                                                <div class="col-md-4"> <label> Package Name </label></div>
                                                <div class="col-md-8"><?php echo $this->Common_model->showname_fromid("tpackage_name","tbl_tourpackages","tourpackageid='$package_id' "); ?></div>
                                            </div>
                                        </div>  
   
                                        <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Itinerary</label></div>
												<div class="col-md-8"> <?php echo $this->Common_model->showname_fromid("itinerary_name","tbl_itinerary","itinerary_id='$itinerary_id' ") ; ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Email Id</label></div>
												<div class="col-md-8"><?php echo $email; ?></div>
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
                                                <div class="col-md-4"> <label> Tour Start Date</label></div>
                                                <div class="col-md-8"><?php echo $this->Common_model->dateformat($tsdate); ?></div>
                                            </div>
                                        </div>  
   
                                        <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Duration</label></div>
												<div class="col-md-8"> <?php echo $this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid='$duration' ") ; ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
                                       
										
                                     
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label> Itinerary Enquiry Details</label></div>
												<div class="col-md-10"> <?php echo $tnote;?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>


                                       

                                 <hr>
                               
                                  <?php echo form_open('', array( 'id' => 'form_itireply', 'name' => 'form_itireply', 'class' => 'add-user'));?>
                                      <?php echo $message; ?>
                                        <div class="col-md-12">
                                        <div class="form-group">
                                        <label>Send Reply</label>
                                      <textarea class="form-control" rows="10" name="reply" id="reply" style="margin: 0px 617px 0px 0px; width: 474px; height: 211px;"></textarea>
                                      <input type="hidden" name="hdntripcust_id" value="<?php echo $tripcust_id ; ?>">
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
                                                    $getPreviousMessages = $this->Common_model->get_records("*","tbl_reply_enquiry","enq_id='$tripcust_id' AND type = 2","enq_id ASC"); 
                                                    if($getPreviousMessages){
                                                      $count=0;
                                                      foreach ($getPreviousMessages as $getPreviousMessage) { 
                                                      ?>
                                                    <div class="col-md-10 msgsection"><span class="messagedate"><?php echo $this->Common_model->dateformat($getPreviousMessage['created_date']); ?> :</span> <?php echo $getPreviousMessage['message']; ?> </div>
                                                    <?php     

                                                       $count++ ;
                                                      } 
                                                     } else { ?>
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

