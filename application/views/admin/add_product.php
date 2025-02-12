<!DOCTYPE html>
<html lang="en">

    <head>
		<?php include("head.php"); ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery-ui.css">
		<link href="<?php echo base_url(); ?>assets/admin/css/bootstrap-select.css" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
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
                        <h1>Products</h1>
                        <small>Add Product</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/product">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Products</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <ul class="tab-btn">
                                            <li class="active"><a href="<?php echo base_url(); ?>admin/product/add">Details</a></li>
                                            <li ><a href="javascript:void(0);">Variants </a></li>
                                        </ul>
                                    </div>
                                    <?php echo $message; ?>
                                    <form class="add-user"  name="productadd" id="productadd" method="post" enctype="multipart/form-data">
                                        <div class="box-main">

                                            <h3>Option</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Stock</label>
                                                    <div class="">
                                                        <div class="radio radio-info radio-inner">
                                                            <input name="prod_status" id="prodsts1" value="1" type="radio"> <label for="prodsts1"><strong>In Stock</strong> </label>
                                                        </div>
                                                        <div class="radio radio-info radio-inner">
                                                            <input name="prod_status" id="prodsts2" value="2" type="radio"> <label for="prodsts2"><strong>Out Stock</strong></label>
                                                        </div>
                                                        <div id="prodsts_errorloc"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label>Product Name</label>
                                                        <input type="text" class="form-control" placeholder="Enter Product Name" name="prod_name" id="prod_name" value="<?php echo set_value("prod_name"); ?>">
                                                    </div>
                                                </div>
												<div class="clearfix"></div> 												

												<div class="col-md-6"> 
													<div class="form-group">
														<label>Menus</label>
														<?php
														  $get_menu = $this->Common_model->get_records("id, menu_name", "tbl_menu", "status = '1'", "menu_name asc", "");
														?>
														<select data-placeholder="Choose Menu" class="chosen-select efilter" multiple tabindex="4" id="emenu"  name="emenu[]"
														 style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
															<?php foreach ($get_menu as $get_menus) { ?>
															<option value="<?= $get_menus['id'] ?>"><?= $get_menus['menu_name'] ?></option>
															<?php } ?>
														</select> 
													</div>
												</div>
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Tags</label>
														<?php
														  $get_tag = $this->Common_model->get_records("id, menu_name", "tbl_menu", "status = '1'", "menu_name asc", "");
														?>
														<select data-placeholder="Choose Tag" class="chosen-select efilter etags" multiple tabindex="4" id="etags"  name="etags[]"
														 style="width: 100%;height: auto;border: 1px solid #aaa;background-color: #fff;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
															<?php foreach ($get_tag as $get_tags) { ?>
															<option value="<?= $get_tags['id'] ?>"><?= $get_tags['menu_name'] ?></option>
															<?php } ?>
														</select> 
													</div>
												</div>

												<div class="clearfix"></div>
												
												<div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label>Sold Quantity</label>
                                                        <input type="text" class="form-control" placeholder="Enter Sold Quantity" name="sold_quantity" id="sold_quantity" value="<?php echo set_value("sold_quantity"); ?>">
                                                    </div>
                                                </div>
												
												<div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label>Selling Time (in Hours)</label>
                                                        <input type="text" class="form-control" placeholder="Enter Selling Time (in Hours)" name="selling_time" id="selling_time" value="<?php echo set_value("selling_time"); ?>">
                                                    </div>
                                                </div>

												<div class="clearfix"></div>
                                            
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label>Product Image</label>
                                                        <input name="proimg" id="proimg" type="file">
                                                    </div>
                                                </div>
												<div class="clearfix"></div>  

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Short Description</label>
                                                        <textarea name="short_desc" id="short_desc" class="form-control "><?php echo set_value("short_desc"); ?></textarea>
                                                        <div id="proddesc_errorloc"></div>
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div>  

												<div class="chkbx-inner">
													<div class="col-md-6">
														<div class="form-group">
															<div class="checkbox checkbox-info">
																<input name="storefront" id="storefront" type="checkbox" value="1">
																<label for="storefront"><strong>Show this product on storefront<strong></label>
															</div>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>

                                        <div class="box-main">

                                            <h3>Meta Tags</h3>
                                            <div class="form-group">
                                                <div class="col-md-3"> <label>Meta Title</label></div>
                                                <div class="col-md-5">  
                                                       <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"></textarea>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <div class="col-md-3"> <label>Meta Keywords</label></div>
                                                <div class="col-md-5">  
                                                    <textarea name="meta_keywords" id="meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1"></textarea>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                                <div class="col-md-3"> <label>Meta Description</label></div>
                                                <div class="col-md-5">  
                                                    <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"></textarea>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
											<div class="clearfix"></div>
											<div class="form-group">
                                                <div class="col-md-3"> <label>Pixel Id</label></div>
                                                <div class="col-md-5">  
                                                    <textarea name="pixel_code" id="pixel_code" cols="" rows="" placeholder="Pixel code here..." class="form-control textarea1"></textarea>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>

                                        </div>

                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
												<button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
												<button type="reset" class="btn blackbtn">Reset</button>
                                            </div>
                                        </div>
                                    </form>

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
			<script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>
  
			<script type="text/javascript">
				CKEDITOR.replace('short_desc');
				function displaysubcat(val)
				{
					if(val != 0)
					{
						$.ajax({
							url:"<?php echo base_url();?>/admin/product/getsubcat",
							data:"categoryid="+val,
							method:"post",
							success:function(data){
								$("#prod_subcat").html(data);
							}
						})
					}
					else
						$("#prod_subcat").html('<option value="0">Select Subcategory</option>');
				}
			</script>

			<script type="text/javascript">
				$(document).ready(function(){
					$('#emenu').chosen();
					$("#emenu").change(function () {
						var menu = $(this);
					});
				});
			</script>

			<script type="text/javascript">
				$(document).ready(function(){
					$('#etags').chosen();
					$("#etags").change(function () {
						var menu = $(this); 					
					});
				});
			</script> 
    </body>
</html>

