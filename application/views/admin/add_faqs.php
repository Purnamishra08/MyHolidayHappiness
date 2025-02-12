<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include("head.php"); ?>
        <link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
           <?php include("header.php"); ?>

           <?php include("sidemenu.php"); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-question"></i>
                    </div>
                    <div class="header-title">
                        <h1>Faqs</h1>
                        <small>Add Faq</small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/faqs">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Faqs</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $message; ?>
                                    <?php echo form_open('', array( 'id' => 'form_faqs', 'name' => 'form_faqs', 'class' => 'add-user'));?>
                                        <div class="box-main">
                                            <h3>Faqs Details</h3>
                                            <div class="row">
										 		<div class="col-md-12">
													<div class="form-group">
														<label>Question</label>
														<input type="text" class="form-control" placeholder="Faq Question" name="faq_question" id="faq_question" value="<?php echo set_value('faq_question'); ?>" >      
													</div> 
                                                </div>	
												
												 <div class="col-md-12"> 
                                                    <div class="form-group">
                                                    <label>Order</label>
                                                     <input type="number" class="form-control" placeholder="Order No" name="faq_order" id="faq_order" value="<?php echo set_value('faq_order'); ?>">
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div> 
                                               
                                                <div class="clearfix"></div>                                               
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>Answer</label>
                                                        <textarea name="faq_answer" id="faq_answer" class="form-control "><?php echo set_value("faq_answer"); ?></textarea>
                                                        <div id="chkediter"></div>
                                                    </div>
                                                </div>                                                
                                                <div class="clearfix"></div>  
                                                
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmitFaq" id="btnSubmitFaq">Save</button>
                                        		  <button name='reset' type="reset" value='Reset' class="btn blackbtn">Reset</button> 
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>                                   
                                </div> 
                            </div>
                        </div>
                    </div>
                </section>
            </div>
		
    <?php include("footer.php"); ?>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>

   

    <script type="text/javascript">
        CKEDITOR.replace('faq_answer');
        </script>

    </body>
</html>

