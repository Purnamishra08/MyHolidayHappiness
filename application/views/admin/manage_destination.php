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
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="header-title">
                        <h1>Destinations</h1>
                        <small>Manage Destinations</small>
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
                                        <a href="<?php echo base_url(); ?>admin/destination/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Destination</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
                                    
									<form class="search-sec" id="search_form">
										<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="destination_name">Destination Name</label></div>
														<div class="col-md-8">
															<input type="text" class="form-control" placeholder="Destination Name" name="destination_name" id="destination_name" maxlength="100">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3"> <label for="state">State</label></div>
														<div class="col-md-9">
															<select class="form-control" name="state" id="state">
																<option value="0">--Select State--</option>
																<?php echo $this->Common_model->populate_select(0, "state_id", "state_name", "tbl_state", "status='1'", "state_name"); ?>
															</select>
														</div>
													</div>
												</div>
											</div>
                                            <div class="clearfix"></div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="homepage_type">Home page type</label></div>
														<div class="col-md-8">
															<select class="form-control" name="homepage_type" id="homepage_type">
																<option value="0">--Select Home page type--</option>
																<?php echo $this->Common_model->populate_select($dispid = 0, "parid", "par_value", "tbl_parameters", "param_type = 'TD'", "par_value asc", ""); ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
												</div>
											</div>

										</div>
									</form>

                                    <div class="table-responsive">
                                        <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/destination/datatable" data-view-url="<?php echo base_url(); ?>admin/destination/view/ID" data-edit-url="<?php echo base_url(); ?>admin/destination/edit/ID" data-delete-url="<?php echo base_url(); ?>admin/destination/delete_destination/ID">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th width="8%">Sl #</th>
                                                    <th width="20%">Destination Name</th>
                                                    <th width="12%">Destination Banner</th>
                                                    <th width="12%">Destination Image</th>
                                                    <th width="15%">State</th>
													<th width="15%">Home page type</th>
                                                    <th width="8%">Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
										<div class="footer-background border-success text-center" id="norecord" style="display:none">No record found.</div>
                                       
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
						url: "<?php echo base_url(); ?>admin/destination/changestatus/"+id,
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
			$(document).ready(function() {
    			searchValidator();
			});
			
			function searchValidator(){
				$('#datatable').css('display', 'none');
				if($('#destination_name').val() != '') {
					destination_name = $('#destination_name').val();
				}else{
					destination_name = '';
				}
				if($('#state').val() > 0) {
					state = $('#state').val();
				}else{
					state = 0;
				}

				if($('#homepage_type').val() > 0) {
					homepage_type = $('#homepage_type').val();
				}else{
					homepage_type = 0;
				}

				
				var table = $('#datatable').DataTable({
					"processing": true,
					"serverSide": true,
					"autoWidth": true,
					"responsive": true,
					"searching": false,
					"ordering": false,
					"responsive": true,
					"bDestroy": true,
					"lengthChange" : true,
					"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					"ajax": {
						"url": $('#datatable').data('url'),
						"type": "POST",
						"dataType": 'json',
						"data": {
							'destination_name': destination_name,
							'state': state,
							'homepage_type': homepage_type,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "destination_name",
							render: function(data, type, row) {
								var str = '<a href="' + row.durl + '" target="_blank">' + row.destination_name + '</a> ';
								return str;
							}
						},
						{ data: "destpic",
							render: function ( data, type, row ) {
								var str = '<a target="_blank" href="'+row.destpic+'"><img src="'+ row.destpic +'" style="width:100px;height:auto;" alt="destpic"/></a>';
								return str;
							} 
						},
						{ data: "destiimg_thumb",
							render: function ( data, type, row ) {
								var str = '<a target="_blank" href="'+row.destiimg_thumb+'"><img src="'+ row.destiimg_thumb +'" style="width:100px;height:auto;" alt="dest_thumb"/></a>';
								return str;
							} 
						},
						{
							data: "statename"
						},
						{
							data: "desttype_home"
						},
						{
							data: "status",
							render: function(data, type, row) {
								var str = "";
								if (row.status == 1) {
									str = '<span class="status" data-id="status-' + row.destination_id + '"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>';
								} else {
									str = '<span class="status" data-id="status-' + row.destination_id + '"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>';
								}
								return str;
							}
						},
						{
							data: "destination_id",
							render: function(data, type, row) {
								var str = '<a href="' + $('#datatable').data('edit-url').replace("ID", row.destination_id) + '"  class="btn btn-success btn-sm view" title="Edit"> <i class="fa fa-pencil"></i></a>';

								str += '<a href="' + $('#datatable').data('view-url').replace("ID", row.destination_id) + '" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>';

								str += '<a onClick="return confirm(\'Are you sure to delete this destination?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.destination_id) + '" class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

								return str;
							}
						},
					],
					"initComplete": function(settings, json) {
						$("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
					},
					drawCallback: function(settings) {
						if (settings._iRecordsTotal < settings._iDisplayLength) {
							$('#datatable_paginate').css('display', 'none');

						} else {
							$('#datatable_paginate').css('display', 'inline-table');

						}
						$('#datatable_length').addClass('noPrint');
						$('#defaultRcord').css('display', 'none');
						if (settings.aiDisplay.length <= 0) {
							$('#datatable').css('display', 'none');
							$('#norecord').css('display', 'inline-table');
							$('#datatable_wrapper').css('display', 'none');
						} else {
							$('#datatable').css('display', 'inline-table');
							$('#norecord').css('display', 'none');
							$('#datatable_wrapper').css('display', 'inline-table');
						}
					},
					"initComplete": function(settings, json) {
						$("#datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
					},
				});

			}
		</script>
		
    </body>
</html>

