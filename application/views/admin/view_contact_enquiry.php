<?php
if (!empty($contact)) {
	foreach ($contact as $rows)
	{
		$enq_id = $rows['enq_id'];
		$cont_name = $rows['cont_name'];
		$cont_email = $rows['cont_email'];
		$cont_phone = $rows['cont_phone'];
		$cont_enquiry_details = $rows['cont_enquiry_details'];
		$cont_date = $rows['cont_date'];
		$page_name = $rows['page_name'];
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
                        <i class="fa fa-user-o"></i>
                    </div>
                    <div class="header-title">
                        <h1>Enquiry</h1>
                        <small>View Enquiry</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/enquiry">
                                            <h4><i class="fa fa-plus-circle"></i>Manage Enquiry</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Name</label></div>
												<div class="col-md-8"> <?php echo $cont_name; ?></div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Email Id</label></div>
												<div class="col-md-8"><?php echo $cont_email; ?></div>
											</div>
										</div>	

										<div class="clearfix"></div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Phone no</label></div>
												<div class="col-md-8"> <?php echo $cont_phone ; ?></div>
											</div>
										</div>
										
                                        <div class="col-md-6">
                                            <div class="gap row">
                                                <div class="col-md-4"> <label> Enquiry Date</label></div>
                                                <div class="col-md-8"><?php echo $this->Common_model->dateformat($cont_date); ?></div>
                                            </div>
                                        </div>  

                                        <div class="clearfix"></div>
										
										<div class="col-md-6">
                                            <div class="gap row">
                                                <div class="col-md-4"> <label> Page Name</label></div>
                                                <div class="col-md-8"><?php echo $page_name; ?></div>
                                            </div>
                                        </div>  

                                        <div class="clearfix"></div>

										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Enquiry Details</label></div>
												<div class="col-md-10"> <?php echo $cont_enquiry_details;?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>


                                       

                                 <hr>
                               
                                  <?php echo form_open('', array( 'id' => 'form_reply', 'name' => 'form_reply', 'class' => 'add-user'));?>
                                <!--  <form class="add-user" name="form_reply" id="form_reply" method="post"> -->
                                      <?php echo $message; ?>
                                        <div class="col-md-12">
                                        <div class="form-group">
                                        <label>Send Reply</label>
                                      <textarea class="form-control" rows="10" name="reply" id="reply" style="margin: 0px 617px 0px 0px; width: 474px; height: 211px;"></textarea>
                                      <input type="hidden" name="hdnenquiry_id" value="<?php echo $enq_id ; ?>">
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
                                                    $getPreviousMessages = $this->Common_model->get_records("*","tbl_reply_enquiry","enq_id='$enq_id' and type = 1","enq_id ASC"); 
                                                    // print_r($getPreviousMessages[0]['message']);  
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

