<?php
	foreach ($tags as $rows)
	{	
		$tagid = $rows['tagid'];
		$menuid = $rows['menuid'];
		$cat_id = $rows['cat_id'];
		$tag_name = $rows['tag_name'];
		$about_tag = $rows['about_tag'];
		$tag_url = $rows['tag_url'];
		$menutag_img = $rows['menutag_img'];
		$menutagthumb_img = $rows['menutagthumb_img'];
		$alttag_banner = $rows['alttag_banner'];
		$alttag_thumb = $rows['alttag_thumb'];
		$show_on_home = $rows['show_on_home'];
		$meta_title = $rows['meta_title'];
		$meta_keywords = $rows['meta_keywords'];
		$meta_description = $rows['meta_description'];
		$show_on_footer	 = $rows['show_on_footer'];
	}
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
                        <i class="fa fa-tag"></i>
                    </div>
                    <div class="header-title">
                        <h1>Category Tags</h1>
                        <small>Edit category tags </small>
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
									<?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'editform_menutags', 'name' => 'form_menutags', 'class' => 'add-user','enctype' => 'multipart/form-data'));?>
                                        <div class="box-main">
                                            <h3>Tag Details</h3>
                                            <div class="row">
										 		<div class="col-md-6">
													<div class="form-group">
														<label>Tag Name</label>
														<input type="text" class="form-control" placeholder="Enter Tag Name" name="tag_name" id="tag_name" value="<?php echo set_value('tag_name', $tag_name); ?>"> 
													</div> 
                                                </div>	
												
												 <div class="col-md-6"> 
                                                    <div class="form-group">
														<label>Tag URL</label>
														<input type="text" class="form-control" placeholder="Enter Tag URL" name="tag_url" id="tag_url"  value="<?php echo set_value('tag_url', $tag_url); ?>">
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div> 
												
											    <div class="col-md-6"> 
													<div class="form-group"> 
														<label>Menu </label>                                                        
														<select class="form-control" name="menuid" id="menuid">
														   <option value=""> -- Select menu tab --</option>
															<?php  echo $this->Common_model->populate_select($dispid = $menuid, "menuid", "menu_name", "tbl_menus", "menuid != 2", "menu_name asc", ""); ?> 
														</select>
													</div>
                                                </div>
												
                                             	<div class="col-md-6"> 
													<div class="form-group">
														<label>Category</label>
														<select class="form-control" name="catId" id="catId">
															<option value=""> -- Select category --</option> 
															<?php echo $this->Common_model->populate_select($dispid = $cat_id, "catid", "cat_name", "tbl_menucateories", "menuid = $menuid", ""); ?>
														</select>
													</div>
                                                </div>
                                               
                                                <div class="clearfix"></div> 
                                                
                                                 <div class="col-md-6">
													 
													 <?php
														if(file_exists("./uploads/".$menutag_img) && ($menutag_img!=''))
														{ 
															echo '<a href="'.base_url().'uploads/'.$menutag_img.'" target="_blank"><img src="'.base_url().'uploads/'.$menutag_img.'" style="width:86px;height:59px" alt="image" /></a>';
													    }
													?>
													
                                                     <div class="form-group">
                                                        <label> Banner Image </label>
                                                       <input name="menutag_img" id="menutag_img" type="file">
														<span>Image size should be 1920px X 488px </span>
                                                    </div>
                                                </div>  
                                                
                                                
                                                 <div class="col-md-6">
													 
													 <?php
														if(file_exists("./uploads/".$menutagthumb_img) && ($menutagthumb_img!=''))
														{ 
															echo '<a href="'.base_url().'uploads/'.$menutagthumb_img.'" target="_blank"><img src="'.base_url().'uploads/'.$menutagthumb_img.'" style="width:86px;height:59px" alt="image" /></a>';
													    }
													?>													
                                                     <div class="form-group">
                                                        <label> Getaways/Tour Image </label>
                                                       <input name="menutagthumb_img" id="menutagthumb_img" type="file">
														<span>Image size should be 500px X 350px </span>
                                                    </div>
                                                </div> 
                                                
                                                <div class="clearfix"></div>     

												<div class="col-md-6"> 
													<div class="form-group">
														<label> Alt Tag For Banner Image</label>
														<input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="<?php echo set_value('alttag_banner', $alttag_banner); ?>" maxlength="60">
													</div>
												</div>
												<div class="col-md-6"> 
													<div class="form-group">
														<label> Alt Tag For Getaways Image</label>
														<input type="text" class="form-control" placeholder="Enter Alt tag for getaways image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb', $alttag_thumb); ?>" maxlength="60">
													</div>
												</div>
												<div class="clearfix"></div>
                                                 
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
													    <label  for="accomodation">  Show on home page </label>
                                                        <div class="row">															
															<div class="col-md-12">										
															  <input type="checkbox" name="show_on_home" id="show_on_home" value="1" <?php if ($show_on_home == 1) { ?> checked="checked" <?php } ?>>
																For Top weekend getaways / Most popular tours
															</div>
														</div>
													</div>
                                                </div>
                                                
                                                 <div class="col-md-6"> 
                                                   <div class="form-group">
													    <label  for="accomodation">  Show on footer menu </label>
                                                        <div class="row">															
															<div class="col-md-12">										
															  <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1" <?php if ($show_on_footer == 1) { ?> checked="checked" <?php } ?>>
																For footer menu								 
															</div>
														</div>
													</div>
                                                </div>
                                                
                                               <div class="clearfix"></div>  
												                                               
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>About Tag</label>
                                                        <textarea name="about_tag" id="about_tag" class="form-control "><?php echo set_value("about_tag", $about_tag); ?></textarea>
                                                        <div id="aboutplace_err"></div>
                                                    </div>
                                                </div>                                                
                                                <div class="clearfix"></div>
                                                
										<div class="box-main">										   
											<h3>Meta Tags</h3>
												<div class="row">  
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Title</label>
															<textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"><?php echo set_value("meta_title", $meta_title); ?></textarea>
														</div>
													</div>
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Keywords</label>
															<textarea name="meta_keywords" id="meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"><?php echo set_value("meta_keywords", $meta_keywords); ?></textarea>
														</div>
													</div>
													
													<div class="clearfix"></div>
													
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Description</label>
															<textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo set_value("meta_description", $meta_description); ?></textarea>
														</div>
													</div>
                                                <div class="clearfix"></div>
                                            </div> 
                                        </div>								
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button">
												<button type="submit" class="btn redbtn" name="btnUpdatetag" id="btnUpdatetag">Update</button>
                                        		<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/menutags'">back</button> 
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

