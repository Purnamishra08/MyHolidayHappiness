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
                        <i class="fa fa-tag"></i>
                    </div>
                    <div class="header-title">
                        <h1>Category Tags</h1>
                        <small>Add category tags </small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/menutags">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Tags</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $messageadd; ?>
									<?php echo form_open('', array( 'id' => 'form_menutags', 'name' => 'form_menutags', 'class' => 'add-user','enctype' => 'multipart/form-data'));?>
                                        <div class="box-main">
                                            <h3>Tag Details</h3>
                                            <div class="row">
										 		<div class="col-md-6">
													<div class="form-group">
														<label>Tag Name</label>
														<input type="text" class="form-control" placeholder="Enter Tag Name" name="tag_name"  id="tag_name" value="<?php echo set_value('tag_name'); ?>"> 
													</div> 
                                                </div>	
												
												 <div class="col-md-6"> 
                                                    <div class="form-group">
														<label>Tag URL</label>
														<input type="text" class="form-control" placeholder="Enter Tag URL" name="tag_url" id="tag_url" readonly value="<?php echo set_value('tag_url'); ?>">
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div> 
												
											    <div class="col-md-6"> 
													<div class="form-group"> 
														<label>Menu </label>                                                        
														<select class="form-control" name="menuid" id="menuid">
														   <option value=""> -- Select menu tab --</option>
															<?php  echo $this->Common_model->populate_select($dispid = 0, "menuid", "menu_name", "tbl_menus", "menuid != 2", "menu_name asc", ""); ?> 
														</select>
													</div>
                                                </div>
												
                                             	<div class="col-md-6"> 
													<div class="form-group">
														<label>Category</label>
														<select class="form-control" name="catId" id="catId">
															<option value=""> -- Select category --</option>                                           
														</select>
													</div>
                                                </div>
                                               
                                                <div class="clearfix"></div> 
												                                               
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label>Banner Image </label>
                                                       <input name="menutag_img" id="menutag_img" type="file">
														<span>Image size should be 1920px X 488px </span>
                                                    </div>
                                                </div>    
                                                                                            
                                                <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label>Getaways/Tour Image </label>
	                                                       <input name="menutagthumb_img" id="menutagthumb_img" type="file">
														<span>Image size should be 500px X 350px </span>
                                                    </div>
                                                </div>                                                
                                                <div class="clearfix"></div>  

												<div class="col-md-6"> 
													<div class="form-group">
														<label> Alt Tag For Banner Image</label>
														<input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="<?php echo set_value('alttag_banner'); ?>" maxlength="60">
													</div>
												</div>
												<div class="col-md-6"> 
													<div class="form-group">
														<label> Alt Tag For Getaways Image</label>
														<input type="text" class="form-control" placeholder="Enter Alt tag for getaways image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb'); ?>" maxlength="60">
													</div>
												</div>
												<div class="clearfix"></div>
													   
											    <div class="col-md-6"> 
                                                   <div class="form-group">
													    <label>  Show on home page </label>
                                                        <div class="row">															
															<div class="col-md-12">										
															  <input type="checkbox" name="show_on_home" id="show_on_home" value="1">
																Top weekend getaways / Most popular tours
															</div>
                                                        </div>
                                                    </div>
                                              </div>
                                              <div class="col-md-6"> 
                                                   <div class="form-group">
													    <label>  Show on footer menu</label>
                                                        <div class="row">															
															<div class="col-md-12">										
															  <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1">
																For footer menu	
															</div>
                                                        </div>
                                                    </div>
                                              </div>
                                                      
                                              <div class="clearfix"></div>                                         
											<div class="col-md-12">
												 <div class="form-group">
													<label>About Tag</label>
													<textarea name="about_tag" id="about_tag" class="form-control "><?php echo set_value("about_tag"); ?></textarea>
													<div id="aboutplace_err"></div>
												</div>
											</div>
                                                
                                                
                                        </div>										
                                      
										<div class="box-main">										   
											<h3>Meta Tags</h3>
												<div class="row">  
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Title</label>
															<textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"><?php echo set_value("meta_title"); ?></textarea>
														</div>
													</div>
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Keywords</label>
															<textarea name="meta_keywords" id="meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"><?php echo set_value("meta_keywords"); ?></textarea>
														</div>
													</div>
													
													<div class="clearfix"></div>
													
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Description</label>
															<textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo set_value("meta_description"); ?></textarea>
														</div>
													</div>
                                                <div class="clearfix"></div>
                                            </div> 
                                        </div>								
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmitcats" id="btnSubmitcats">Save</button>
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

    <script>
		$(document.body).on('keyup change', '#tag_name', function() {
			$("#tag_url").val(name_to_url($(this).val()));
		});
		function name_to_url(name) {
			name = name.toLowerCase(); // lowercase
			name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
			name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
			name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
			return name;
		}
		
		$(document).ready(function(){
			$('#menuid').on("change",function () {                   
				var categoryId = $(this).find('option:selected').val();
				var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
					csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
					var dataJson = { [csrfName]: csrfHash, categoryId: categoryId};
				$.ajax({
					url: "<?php echo base_url() ?>admin/menutags/getcategory",
					type: "POST",
					data: dataJson,
					success: function (response) {
						console.log(response);
						if(categoryId == '3') {
							$("#catId").html(response);
							$("#abouttour").show();
						} else {
							$("#catId").html(response);
							$("#abouttour").hide();
						}

					},
				});
			}); 
		});
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('about_tag');		
    </script>

    </body>
</html>

