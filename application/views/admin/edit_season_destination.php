<?php
foreach ($row as $rows)
{
    $parid = $rows['seadestinationid'];	
    $par_value = $rows['par_value'];
    $param_type = $rows['param_type'];
    $destination_id = $rows['destination_id'];
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
                        <i class="fa fa-picture-o"></i>
                    </div>
                    <div class="header-title">
                        <h1>Season Destination </h1>
                        <small>Edit Season Destination</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/season-destination">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Season Destination </h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>                                            
                                    <div class="col-xl-12 col-lg-12">
										<?php echo form_open('', array( 'id' => 'form_season_dest', 'name' => 'form_season_dest', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                            <div class="row">
                                               
												
												<div class="col-xl-6 col-lg-6 "> 
                                                    <div class="form-group">
														<label>Destination </label>                                                  
                                                        <select class="form-control"  id="destination_id"  name="destination_id" >
                                                             <option value="">-- Select destination --</option>
                                                           <?php  echo $this->Common_model->populate_select($dispid = $destination_id, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
                                                        </select> 
													</div> 
												</div>	
												
												<div class="clearfix"></div>
																								
												
												<div class="col-xl-12 col-lg-12"> 
														<div class="form-group">	
														<label>Season Destination Image (For Home)</label>
														<input name="bnrimg" id="bnrimg" type="file">
														<div class="col-md-6">
														 <span>Image size should be <?php  if ($param_type=='SD1')  echo '900px X 500px';  else  echo '550px X 500px' ; ?></span>
														 </div> 	
														<div class="col-md-6">	
														<?php
															if (file_exists("./uploads/" . $par_value) && ($par_value != '')) {
																echo '<a href="' . base_url() . 'uploads/' . $par_value . '" target="_blank"><img src="' . base_url() . 'uploads/' . $par_value . '"  width="100px" height="100px"/></a>';
															}
														?>
															
															</div> 
															<div class="clearfix"></div>
														</div> 
												</div>
												
													
													
                                                <div class="clearfix"></div> 

                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="reset-button"> 
														<input type="hidden" name="param_type" id="param_type" value="<?php echo $param_type; ?>" />
														<button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Update</button>
														<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/season-destination'">Back</button> 
                                                    </div>
                                                </div>
                                            </div>
										<?php echo form_close();?>
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
			<script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    </body>
</html>

