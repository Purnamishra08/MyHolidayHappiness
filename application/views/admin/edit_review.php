<?php
	foreach ($editplace as $rows)
	{
        $itinerary_id = $rows['tourtagid'];
		$review_id = $rows['review_id'];
		$reviewer_name = $rows['reviewer_name'];
		$reviewer_loc = $rows['reviewer_loc'];
		$no_of_star = $rows['no_of_star'];
		$feedback_msg = $rows['feedback_msg'];
		$status = $rows['status'];
		$created_date = $rows['created_date'];		
	}
    $get_tag_array = $itinerary_id;
?>
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
                        <small>Edit Review</small>
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
                                   <?php echo $message; ?>
                                    <?php echo form_open('', array( 'id' => 'form_review', 'name' => 'form_review', 'class' => 'add-user', ));?>
                                        <div class="box-main">
                                            <h3>Review Details</h3>
                                            <div class="row">
												
											    <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Name</label>
                                                         <input type="text" class="form-control" placeholder="Enter Name" name="reviewer_name" id="reviewer_name" value="<?php echo set_value('reviewer_name',$reviewer_name); ?>">
                                                </div> 
                                                </div>	
												
												<div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Location </label>
                                                    <input type="text" class="form-control" placeholder="Enter Location" name="reviewer_loc" id="reviewer_loc" value="<?php echo set_value('reviewer_loc',$reviewer_loc); ?>">
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div>  
												                                              
                                                <div class="col-md-6"> 
                                                <div class="form-group">
													
                                                    <label> Rating </label>                                                    
                                                    <select class="form-control" name="no_of_star" id="no_of_star" >
                                                    <option value="" >-- Select Rating --</option>
                                                    <option value="1" <?php echo ($no_of_star == '1') ? 'selected="selected"' :''; ?> >1</option>
                                                    <option value="1.5" <?php echo ($no_of_star == '1.5') ? 'selected="selected"' :''; ?>>1.5</option>
                                                    <option value="2" <?php echo ($no_of_star == '2') ? 'selected="selected"' :''; ?>>2</option>
                                                    <option value="2.5" <?php echo ($no_of_star == '2.5') ? 'selected="selected"' :''; ?>>2.5</option>
                                                    <option value="3" <?php echo ($no_of_star == '3') ? 'selected="selected"' :''; ?>>3</option>
                                                    <option value="3.5" <?php echo ($no_of_star == '3.5') ? 'selected="selected"' :''; ?>>3.5</option>
                                                    <option value="4" <?php echo ($no_of_star == '4') ? 'selected="selected"' :''; ?>>4</option>
                                                    <option value="4.5" <?php echo ($no_of_star == '4.5') ? 'selected="selected"' :''; ?>>4.5</option>
                                                    <option value="5" <?php echo ($no_of_star == '5') ? 'selected="selected"' :''; ?>>5</option>
                                                </select>
                                                </div>
                                                </div>
                                                
                                                <div class="col-md-6"> 
                                                <div class="form-group"> 
                                                    <label>Feedback </label>                                                  
                                                        <textarea name="feedback_msg" id="feedback_msg" class="form-control "><?php echo $feedback_msg; ?></textarea>
                                                </div>
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
                                      
										   
										    
                                        </div>								
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnEditReview" id="btnEditReview">Update</button>
                                        		  <button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/review'">back</button> 
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
                //for tag type
				var tag_params = "<?php echo $itinerary_id ?>";
				if(tag_params != '') {	
					var rstr = tag_params.replace(/,\s*$/, ""); //remove last comma from string
					var tag_array_data = rstr.split(",");
					$.each(tag_array_data, function (index, val) {
						$("#getatagid option[value=" + val + "]").attr('selected', 'selected');
					});
					$('#getatagid').trigger('chosen:updated');
				}
		});
    </script>
    </body>
</html>

