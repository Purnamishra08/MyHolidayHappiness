<?php
$content_id = NULL; $page_name = NULL; $page_content = NULL;
$seo_title = NULL; $seo_description = NULL; $seo_keywords = NULL;

if(!empty($row))
{
    foreach ($row as $rows)
    {
        $content_id = $rows['content_id'];
        $page_name = $rows['page_name'];
        $page_content = $rows['page_content'];
        $seo_title = $rows['seo_title'];
        $seo_description = $rows['seo_description'];
        $seo_keywords = $rows['seo_keywords'];        
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
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="header-title">
                        <h1>CMS</h1>
                        <small>CMS</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                               
								<div class="panel-body">
									<?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_cms', 'name' => 'form_cms', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
										<div class="row">
                                    
											<div class="col-md-6"> 
												<div class="form-group">
													<label>Page</label>
													<select class="form-control" name="selPage" id="selPage">
														<?php
															$selpg = set_value('selPage',$content_id);
															echo $this->Common_model->populate_select($selpg,"content_id","page_name","tbl_contents","","page_name ASC");
														?>
													</select>
												</div>
												<div class="clearfix"></div>
											</div>
											<div class="clearfix"></div>
											
											<div class="col-md-12"> 
												<div class="form-group">
													<label>Description</label>
													<div class="">
														<textarea id="editor" name="editor"><?php echo set_value('editor',$page_content); ?></textarea>
														<div id="chkediter"></div>
													</div>
												</div>
											</div>
											<div class="clearfix m-b-15"></div>

											<div class="col-md-12"> 
												<div class="form-group">
													<label>Seo Title</label>
													<textarea class="form-control" placeholder="Enter Seo Title" rows="2" name="seo_title" id="seo_title"><?php echo set_value('seo_title',$seo_title); ?></textarea>
												</div>
											</div>
											<div class="clearfix"></div>

											<div class="col-md-12"> 
												<div class="form-group">
													<label>Seo Description</label>
													<textarea class="form-control" placeholder="Enter Seo Description" rows="5" name="seo_description" id="seo_description"><?php echo set_value('seo_description',$seo_description); ?></textarea>
												</div>
											</div>
											<div class="col-md-12"> 
												<div class="form-group">
													<label>Seo Keywords</label>
													<textarea class="form-control" placeholder="Enter Seo Keywords" rows="5" name="seo_keywords" id="seo_keywords"><?php echo set_value('seo_keywords',$seo_keywords); ?></textarea>
												</div>
											</div> 
											<div class="clearfix"></div>                                    
                            
											<div class="col-md-12">
												<div class="reset-button"> 
													<button class="redbtn" type="submit" name="btnSubmit" id="btnSubmit">Save</button>
													<button class="blackbtn" type="reset">Reset</button> 
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
									<?php echo form_close();?>

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
			<!--  <script>var base_url = "<?php echo base_url(); ?>"; </script> -->

			<script type="text/javascript">
				CKEDITOR.replace( 'editor');
			</script>

			<script>
				$(document).ready(function()
				{
					$("#selPage").change(function()
					{
						var pageid = $("#selPage").val();
						document.location.href = "<?php echo base_url(); ?>admin/cms/"+pageid;
					});
				}); 
			</script>
    </body>
</html>

