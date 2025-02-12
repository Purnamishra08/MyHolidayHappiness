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
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="header-title">
                        <h1>Users</h1>
                        <small>Manage Users</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <?php echo $message; ?>
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/users/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add User</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">
                                                    <th width="6%">Sl #</th>
                                                    <th width="13%">Name</th>
                                                    <th width="9%">Type</th>
                                                    <th width="9%">Contact No.</th>
                                                    <th width="18%">Email</th>
                                                    <th width="18%">Module</th>
                                                    <th width="7%">Status</th>
                                                    <th width="12%">Action</th>
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
														$userid = $rows['adminid'];
														$user_name = $rows['admin_name'];
														$contact_no = $rows['contact_no'];
														$email_id = $rows['email_id'];
														$user_type = $rows['admin_type'];
														$status = $rows['status'];
														 if($user_type == 1)
														$adimtypenm='Super Admin'; 
													elseif($user_type == 2) 
														$adimtypenm='Admin';
													else
														$adimtypenm='User';
												?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
													<td><?php echo $user_name; ?></td>
													<td><?php echo $adimtypenm; ?></td>
													<td><?php echo $contact_no; ?></td>
													<td><?php echo $email_id; ?></td>
													<td>
														<?php
														if(($user_type==1) || ($user_type==2))
															$usermodules = $this->Common_model->get_records("*","tbl_modules","status=1","moduleid ASC");
														else
															$usermodules = $this->Common_model->get_records("a.*, b.module","tbl_admin_modules a, tbl_modules b","a.moduleid=b.moduleid and a.adminid='$userid'","moduleid ASC");

														$module = array();
														foreach($usermodules as $modules)
														{
															$module[] = $modules['module'];             
														}
														echo implode(", ", $module);
														?>
													</td>
                                                    <td>                                        
														<?php if($userid!=1) { if($status==1) { ?>
															<span class="status" data-id="<?php echo "status-".$userid; ?>"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>
														<?php } else { ?>
															<span class="status" data-id="<?php echo "status-".$userid; ?>"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>
														<?php } }else { ?>
															<span class="label-custom label label-success" title="Status is active.">Active</span>
														<?php } ?>
													</td>
                                                    <td>
														<a href="<?php echo base_url().'admin/users/edit/'.$userid; ?>" class="btn btn-success btn-sm view1 tbl-icon-btm" title="View"> <i class="fa fa-pencil"></i></a>
														<a href="javascript:void(0);" data-id="<?php echo $userid; ?>" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>
														<?php if($userid!=1) { ?>
															<a onClick="return confirm('Are you sure to delete this user?')" href="<?php echo base_url().'admin/users/delete/'.$userid; ?>" class="btn btn-danger btn-sm" title=""><i class="fa fa-trash-o"></i> </a>
														<?php } ?>
													</td>
                                                </tr>

                                                <?php
                                        
													}
												}
												else
												{
												?>
												<tr>
													<td class="text-center" colspan="8"> No data available in table </td>
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
        
		<script type="text/javascript">
			$(document).on('click', '.status', function(){
				if(confirm('Are you sure to change the status?'))
				{
					var val = $(this).data("id");
					var valsplit = val.split("-");
					var id = valsplit[1];
					jQuery('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
	
					$.ajax({
						url: "<?php echo base_url(); ?>admin/users/changestatus/"+id,
						type: 'post',
						data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
						cache: false,
						success: function (data) {
							//alert(data);
							jQuery('.spinner').remove();						
							if(data == '1') //Inactive
							{
								jQuery('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
							}
							else if(data == '0') //Active
							{
								jQuery('[data-id='+val+']').html('<a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a>');
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
		</script>

		<script type="text/javascript">
			$(document).on('click', '.view', function(){
				jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
				var val = $(this).data("id");				
				$.ajax({
					url: "<?php echo base_url(); ?>admin/users/view_pop/"+val,
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
		</script>
		
		<script type="text/javascript">
			$(document).ready(function () {
				$('#example').DataTable();
			});
		</script>
		
    </body>
</html>

