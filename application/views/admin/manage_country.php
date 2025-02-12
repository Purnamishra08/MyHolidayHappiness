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
                        <h1>country</h1>
                        <small>Manage Country</small>
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
                                        <a href="<?php echo base_url(); ?>admin/country/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Country</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">
                                                    <th width="6%">Sl #</th>
                                                        <th width="10%">Country</th>
                                                        <th width="10%">Add States</th>
                                                        <th width="10%">Status</th>
                                                        <th width="14%">Action</th>
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
				                                            $countryid = $rows['countryid'];
				                                            $country_name = $rows['country_name'];
				                                            $status = $rows['status'];
												?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>                                                       
                                                        <td><?php echo $country_name; ?></td>
                                                        <td>

                                                        	<a href="<?php echo base_url().'admin/country/add-state/'.$countryid; ?>" class="" title="Add Question to Set" style="color: #003580;"> Add States  </a>

                                                        </td>
												
	                                                   <td>				                                        
			                                            <?php if($status==1) { ?>
			                                                <span class="status" data-id="<?php echo "status-".$countryid; ?>"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>
			                                           <?php } else { ?>
			                                            <span class="status" data-id="<?php echo "status-".$countryid; ?>"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>
			                                             <?php } ?>
				                                        </td>

                                                    <td>
														<a href="<?php echo base_url().'admin/country/edit/'.$countryid; ?>" class="btn btn-success btn-sm view1 tbl-icon-btm" title="Edit"> <i class="fa fa-pencil"></i></a>

														<a href="#" data-id="" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="Add state"><i class="fa fa-globe"></i></a>
														
														<a onClick="return confirm('Are you sure to delete this user?')" href="<?php echo base_url().'admin/country/delete/'.$countryid; ?>" class="btn btn-danger btn-sm" title=""><i class="fa fa-trash-o"></i> </a>
													</td>
                                                </tr>

                                                <?php
                                        
													}
												}
												else
												{
												?>
												<tr>
													<td class="text-center" colspan="4"> No data available in table </td>
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

		<!-- <script type="text/javascript">
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
		</script> -->
		
		<script type="text/javascript">
			$(document).ready(function () {
				$('#example').DataTable();
			});
		</script>
		
    </body>
</html>

