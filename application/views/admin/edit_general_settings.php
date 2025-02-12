<?php
foreach ($row as $rows)
{
    $parid = $rows['parid'];
    $parameter = $rows['parameter'];
    $par_value = $rows['par_value'];
    $input_type = $rows['input_type'];
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
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="header-title">
                        <h1>General Settings</h1>
                        <small>Edit General Settings</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/general_settings">
                                            <h4><i class="fa fa-plus-circle"></i> Manage General Settings</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php echo $message; ?>                                            
                                    <div class="col-xl-12 col-lg-12">
										<?php echo form_open('', array( 'id' => 'form_cmnstng', 'name' => 'form_cmnstng', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 "> 
													<label><?php echo $parameter; ?></label>
												</div>
												<div class="clearfix"></div> 
												<?php if($input_type==1) {?>
												<div class="col-xl-6 col-lg-6 "> 
                                                    <div class="form-group">
														<input type="text" class="form-control" placeholder="Enter <?php echo $parameter; ?>" name="par_value" id="par_value" value="<?php echo set_value('par_value',$par_value); ?>" />
													</div> 
												</div>	
												<?php } else if ($input_type==2) { ?>
												<div class="col-xl-6 col-lg-6 "> 
                                                    <div class="form-group">
														<textarea class="form-control"  rows="5" name="text_area" id="text_area"><?php echo set_value('text_area',$par_value); ?></textarea>  
													</div> 
												</div>
												<?php  } else if ($input_type==3) { ?>
													<div class="col-xl-12 col-lg-12 "> 
														<div class="form-group">
															<div class="col-md-6">
																<input name="bnrimg" id="bnrimg" type="file">
															</div>
															<div class="col-md-6">
															<?php
																if (file_exists("./uploads/" . $par_value) && ($par_value != '')) {
																	echo '<a href="' . base_url() . 'uploads/' . $par_value . '" target="_blank"><img src="' . base_url() . 'uploads/' . $par_value . '" width="100px" height="100px" /></a>';
																}
															?>
															</div>
																Note:Image size should be 1920px X 400px
															<div class="clearfix"></div>
														</div> 
													</div>
												<?php  } else { ?>
													<div class="col-md-12"> 
														<div class="form-group">
															<textarea name="short_desc" id="short_desc" class="form-control "><?php echo set_value("short_desc", $par_value); ?></textarea>
														</div>
													</div>
												<?php } ?>
                                                <div class="clearfix"></div> 

                                                <div class="col-xl-12 col-lg-12">
                                                    <div class="reset-button"> 
														<input type="hidden" name="input_type" id="input_type" value="<?php echo $input_type; ?>" />
														<button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Update</button>
														<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/general_settings'">Back</button> 
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
            <script type="text/javascript">
                CKEDITOR.replace('short_desc');
            </script>
    </body>
</html>

