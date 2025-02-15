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
                        <i class="fa fa-comment-o"></i>
                    </div>
                    <div class="header-title">
                        <h1>Reviews</h1>
                        <small>Add Review</small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/review">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Review</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $messageadd; ?>
                                    <?php echo form_open('', array( 'id' => 'form_review', 'name' => 'form_review', 'class' => 'add-user'));?>
                                        <div class="box-main">
                                            <h3>Review Details</h3>
                                            <div class="row">
												
										 		<div class="col-md-6">
													<div class="form-group">
														<label> Name</label>
														<input type="text" class="form-control" placeholder="Enter Name" name="reviewer_name" id="reviewer_name" value="<?php echo set_value('reviewer_name'); ?>">
													</div> 
                                                </div>	
												
												<div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Location</label>
                                                    <input type="text" class="form-control"  placeholder="Enter Location" name="reviewer_loc" id="reviewer_loc" value="<?php echo set_value('reviewer_loc'); ?>">
                                                    </div>
                                                </div>
												
											 <div class="clearfix"></div> 
												
											   <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Rating </label>                                                    
                                                    <select class="form-control" name="no_of_star" id="no_of_star">
														<option value="">Select Rating</option>
														<option value="1">1</option>
														<option value="1.5">1.5</option>
														<option value="2">2</option>
														<option value="2.5">2.5</option>
														<option value="3">3</option>
														<option value="3.5">3.5</option>
														<option value="4">4</option>
														<option value="4.5">4.5</option>
														<option value="5">5</option>
                                                </select>
                                                </div>
                                                </div>
												
                                             	<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Feedback </label>
														<textarea name="feedback_msg" id="feedback_msg" cols="" rows="" placeholder="Enter Feedback" class="form-control textarea"></textarea>

                                                </div>
                                                <div id="placetype_err">  </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Associated Tour Tag </label>
                                                    <?php   
                                                        $get_getawaytags = $this->Common_model->get_records("tagid, tag_name", "tbl_menutags", "status = '1' and menuid = '3'", "tag_name asc", "");
													?>
                                                    <select data-placeholder="Choose tour tags" class="chosen-select" multiple tabindex="4" id="getatagid"  name="getatagid[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
														<?php foreach ($get_getawaytags as $get_getawaytag) { ?>
														<option value="<?= $get_getawaytag['tagid'] ?>"><?= $get_getawaytag['tag_name'] ?></option>
														<?php } ?>
                                                    </select> 
                                                </div>
                                                <div id="gettourtag_err"></div>
											</div>
                                               
                                                <div class="clearfix"></div> 
												
                                                							
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmitPlace" id="btnSubmitPlace">Save</button>
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
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>

    <script>
        $(document).ready(function(){
			$('#getatagid').chosen();
		});
    $(document.body).on('keyup change', '#place_name', function() {
        $("#place_url").val(name_to_url($(this).val()));
    });
    function name_to_url(name) {
        name = name.toLowerCase(); // lowercase
        name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
        name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
        name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
        return name;
    }	
    </script>
    </body>
</html>