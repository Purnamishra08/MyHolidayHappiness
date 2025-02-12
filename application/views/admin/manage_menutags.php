<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("head.php"); ?>
        <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
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
                        <small>Manage category tags </small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
							<div class="panel panel-bd lobidrag">
								<div class="panel-heading">
									<div class="btn-group" id="buttonexport">
										<a href="<?php echo base_url(); ?>admin/menutags/add">
											<h4><i class="fa fa-plus-circle"></i> Add Tag</h4>
										</a> 
									</div>
								</div>
								<div class="panel-body">
									<?php echo $message; ?>                           
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped table-hover">
											<thead>

												 <tr class="info">
													<th width="6%" style="text-align: center;">Sl #</th>    
													<th width="20%">Menus</th>
													<th width="28%">Categories</th>
													<th width="28%">Tags</th>
													<th width="8%">Status</th>
													<th width="8%">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$cnt = 0;
												if( !empty($row) )
												{
													foreach ($row as $rows)
													{                                                        
														$cnt++;
														$tagid = $rows['tagid'];    
														$catId = $rows['cat_id'];    
														$menuid = $rows['menuid'];  
														$status = $rows['status'];
														$tag_url = $rows['tag_url'];
														
														$menu_name = $this->Common_model->showname_fromid("menu_name","tbl_menus","menuid ='$menuid'");
														$seomenu_name = $this->Common_model->makeSeoUrl($menu_name);	
														
														$cat_name = $this->Common_model->showname_fromid("cat_name","tbl_menucateories","catid ='$catId'");
														$seocat_name = $this->Common_model->makeSeoUrl($cat_name);															
												?>
												<tr>
													<td><?php echo $cnt; ?></td>                                                       
													<td><?php echo $menu_name; ?></td>                                                      
													<td><?php echo $cat_name; ?></td>
													<td><a href="<?php echo base_url().$seomenu_name.'/'.$seocat_name.'/'.$tag_url; ?>" target="_blank"><?php echo $rows['tag_name']; ?></a></td>
													<td>                                                        
														<?php if($status==1) { ?>
															<span class="status" data-id="<?php echo "status-".$tagid; ?>"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>
														<?php } else { ?>
															<span class="status" data-id="<?php echo "status-".$tagid; ?>"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>
														<?php } ?>
													</td>
													<td>														
														<a href="<?php echo base_url().'admin/menutags/edit/'.$tagid; ?>" class="btn btn-success btn-sm view1 tbl-icon-btm" title="Edit"> <i class="fa fa-pencil"></i></a>
														
														<a href="javascript:void(0);" data-id="<?php echo $tagid; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>				
														
														<a onClick="return confirm('Are you sure to delete this tag?')" href="<?php echo base_url().'admin/menutags/delete/'.$tagid; ?>" class="btn btn-danger btn-sm" title=""><i class="fa fa-trash-o"></i> </a>
													</td>
												</tr>
												<?php										
													}
												}
												else
												{
												?>
												<tr>
													<td class="text-center" colspan="6"> No data available in table </td>
												</tr>
												<?php
												}
												?>                                                
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
                    </div>      
                </section>
            </div>
            
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content"> </div>
                </div>
            </div>


			<?php include("footer.php"); ?>
  
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script> var base_url = "<?php echo base_url(); ?>"; </script>

           
    <script type="text/javascript">  
		$(document).on('click', '.status', function(){
			if(confirm('Are you sure to change the status?'))
			{
				var val = $(this).data("id");
				var valsplit = val.split("-");
				var id = valsplit[1];
				$('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
				$.ajax({
					url: "<?php echo base_url(); ?>admin/menutags/changestatus/"+id,
					type: 'post',
					data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
					cache: false,
					success: function (data) {
						$('.spinner').remove();                        
						if(data == '1') //Inactive
						{                                
							$('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
						}
						else if(data == '0') //Active
						{
							$('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a>');
						}
						else
						{
							alert("Sorry! Unable to change status.");
						}
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
					}
				});
			}
		});
		
		$(document).on('click', '.view', function() {
			jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
			var val = $(this).data("id");				
			$.ajax({
				url: "<?php echo base_url(); ?>admin/menutags/view_pop/"+val,
				type: 'post',
				data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
				cache: false,					
				//processData: false,
				success: function (modal_content) {
					jQuery('#myModal .modal-content').html(modal_content);
					// LOADING THE AJAX MODAL
					$('#myModal').modal('show');
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
					$('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> Your query could not executed. Please try again.</div>');
				}	
			});
		});
			
		
		$(document).ready(function () {
			$('#example1').DataTable();
		});
	</script>
  </body>
</html>
