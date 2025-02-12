<?php
foreach ($row as $rows)
{
	$disid = $rows['blogid'];
	$title = $rows['title'];
	$dis_image = $rows['image'];
	$alttag_image = $rows['alttag_image'];
	$contents = $rows['content'];
	$show_comments = $rows['show_comment'];
    $show_in_home = $rows['show_in_home'];
	$blog_url = $rows['blog_url'];					
	$status = $rows['status'];				
	$blog_meta_title = $rows['blog_meta_title'];				
	$blog_meta_keywords = $rows['blog_meta_keywords'];				
	$blog_meta_description = $rows['blog_meta_description'];
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
                        <i class="fa fa-cc"></i>
                    </div>
                    <div class="header-title">
                        <h1>Blogs</h1>
                        <small>Edit Blog</small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/blog">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Blogs</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $message; ?>
                                    <?php echo form_open('', array( 'id' => 'edit_form_discussion', 'name' => 'edit_form_discussion', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                        <div class="box-main">
                                            <h3>Blog Details </h3>
                                            <div class="row">
										 		<div class="col-md-6">
													<div class="form-group">
														  <label> Post Title </label>
															 <input type="text" class="form-control" placeholder="Enter title" name="title" id="title" value="<?php echo set_value('title',$title); ?>" >
													</div> 
                                                </div>	
												
												 <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Blog Url</label>
                                                    <input type="text" class="form-control" placeholder="Enter blog url" name="blog_url" id="blog_url" value="<?php echo set_value('blog_url', $blog_url ); ?>" >
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div> 
												
												
                                                <div class="col-md-6"> 
												<span id="row1"><img class="img-responsive" src="<?php echo base_url().'uploads/'.$dis_image; ?>" width="150px" height="200px"/>   </span>   													
												 <input name="txthimage" type="hidden" id="txthimage" value="<?php echo $dis_image; ?>">
												  <?php
													  $image = getcwd().'/uploads/'.$dis_image;
													  if (file_exists($image) && !is_dir($image)) {
													  ?>
													  <span>
														<a href="<?php echo base_url().'uploads/'.$dis_image; ?>" target="_blank"><font color="blue"><strong>View Image</strong></font></a>&nbsp;
														<span><a href="javascript:del('row1')">Remove Image</a></span>
													  </span>     
												  <?php } ?>  
                      
                                                   <div class="form-group">
                                                        <label> Featured Image </label>
                                                        <input type="file" name="dis_image" id="dis_image" >
                                                        <span>Image size should be 1140px X 350px </span>
                                                   </div>
                                                    
                                                    
													<div id="placeimo_err">  </div>
                                                </div> 
                                                                                            
                                               <div class="col-md-6">
												   <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label>Show Comments</label>
                                                <input name="show_comments" id="show_comments" value="1" type="checkbox" <?php if($show_comments=='1') {?> checked="" <? }?>  >

													  </div>
                                                    </div>
                                                    <div class="col-md-6">
														<div class="form-group">
                                                        <label>Show home</label>
														<input name="show_home" id="show_home" value="1" type="checkbox" <?php if($show_in_home=='1') {?> checked="" <? }?>  >
                                                        </div>
													</div>    
                                                    <div class="clearfix"></div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label> Alt Tag For Featured Image</label>
                                                            <input type="text" class="form-control" placeholder="Enter Alt tag for featured image" name="alttag_image" id="alttag_image" value="<?php echo set_value('alttag_image', $alttag_image); ?>" maxlength="60">
                                                        </div>
                                                    </div>                                              
                                                </div>                                               
                                                       
                                                <div class="clearfix"></div>
                                                <div class="col-md-12">
														 <div class="form-group">
															<label> Content	</label>
															<textarea name="contents" id="contents" class="form-control "><?php echo set_value('contents',$contents); ?></textarea>
														</div>
												<div id="chkediter"></div>
												</div>      
                                                
                                            </div>
                                        </div>
                                        <div class="box-main">
                                    <h3>  Meta Tags</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="blog_meta_title" id="blog_meta_title"><?php echo $blog_meta_title ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Keyword</label>
                                                <textarea name="blog_meta_keywords" id="blog_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"><?php echo $blog_meta_keywords ?></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Meta Description</label>
                                                <textarea name="blog_meta_description" id="blog_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo $blog_meta_description ?></textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
												
												<button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Update</button>
												<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/blog'">Back</button>
	
	
	
                                                  
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
    <script> var base_url ="<?php echo base_url(); ?>"; </script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>


    <script>
	 function del(rowid)
	  {
		var delConfirm=confirm("Are you sure to Delete This Image?");
		if (delConfirm)
		{
		  document.getElementById("row1").style.display='none';
		  document.getElementById('txthimage').value=''; 
		}
	  }
  
  
    $(document.body).on('keyup change', '#title', function() {
		$("#blog_url").val(name_to_url($(this).val()));
	});
	function name_to_url(name) {
		name = name.toLowerCase(); // lowercase
		name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
		name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
		name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
		name = name.replace(/-+/g,'-'); // convert (continuous) - to one -
		return name;
	}
    </script>

    <script type="text/javascript">
        CKEDITOR.replace( 'contents' );
        </script>

    </body>
</html>

