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
                        <i class="fa fa-bookmark"></i>
                    </div>
                    <div class="header-title">
                        <h1>Places</h1>
                        <small>Manage Places</small>
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
                                        <a href="<?php echo base_url(); ?>admin/places/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Place</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
											
									<form class="search-sec" id="search_form">
										<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3"> <label for="place_name">Place</label></div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Place Name" name="place_name" id="place_name" maxlength="100">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3"> <label for="destination_name">Destination</label></div>
														<div class="col-md-9">
															<select class="form-control" name="destination_name" id="destination_name">
																<option value="0">--Select Destination--</option>
																<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3"> <label for="t_status">Status</label></div>
														<div class="col-md-9">
															<select class="form-control" name="t_status" id="t_status">
																<option value="0">--Select Status--</option>
																<option value="1">Active</option>
																<option value="2">Inactive</option>
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
                                        <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/places/datatable" data-edit-url="<?php echo base_url(); ?>admin/places/edit/ID" data-delete-url="<?php echo base_url(); ?>admin/places/delete/ID">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th width="5%">Sl #</th>
                                                    <th width="25%">Place</th>
                                                    <th width="25%">Destination</th>
                                                    <th width="15%">Banner Image</th>
                                                    <th width="15%">Place Image</th>
                                                    <th width="5%">Status</th>
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
			$(document).on('click', '.view', function() {
				jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
				var val = $(this).data("id");				
				$.ajax({
					url: "<?php echo base_url(); ?>admin/places/view_pop/"+val,
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
			
		   $(document).on('click', '.status', function(){
				if(confirm('Are you sure to change the status?'))
				{
					var val = $(this).data("id");
					var valsplit = val.split("-");
					var id = valsplit[1];
					$('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
					$.ajax({
						url: "<?php echo base_url(); ?>admin/places/changestatus/"+id,
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

		</script>
		
		<script type="text/javascript">
			$(document).ready(function() {
    			searchValidator();
			});
			
			function searchValidator(){
				$('#datatable').css('display', 'none');
				if($('#place_name').val() != '') {
					place_name = $('#place_name').val();
				}else{
					place_name = '';
				}
				if($('#destination_name').val() > 0) {
					destination_name = $('#destination_name').val();
				}else{
					destination_name = 0;
				}

				if($('#t_status').val() > 0) {
					t_status = $('#t_status').val();
				}else{
					t_status = 0;
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
							'place_name': place_name,
							'destination_name': destination_name,
							't_status': t_status,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "place_name",
							render: function(data, type, row) {
								var str = '<a href="' + row.place_url + '" target="_blank">' + row.place_name + '</a> ';
								return str;
							}
						},
						{
							data: "destination_name"
						},
						{ data: "placeimg",
							render: function ( data, type, row ) {
								var str = '<a target="_blank" href="'+row.placeimg+'"><img class="newsmange" src="'+ row.placeimg +'" style="width:86px;height:59px" alt="image"/></a>';
								return str;
							} 
						},
						{ data: "placethumbimg",
							render: function ( data, type, row ) {
								var str = '<a target="_blank" href="'+row.placethumbimg+'"><img class="newsmange" src="'+ row.placethumbimg +'" style="width:86px;height:59px" alt="image"/></a>';
								return str;
							} 
						},
						{
							data: "status",
							render: function(data, type, row) {
								var str = "";
								if (row.status == 1) {
									str = '<span class="status" data-id="status-' + row.placeid + '"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>';
								} else {
									str = '<span class="status" data-id="status-' + row.placeid + '"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>';
								}
								return str;
							}
						},
						{
							data: "placeid",
							render: function(data, type, row) {
								var str = '<a href="' + $('#datatable').data('edit-url').replace("ID", row.placeid) + '"  class="btn btn-success btn-sm view" title="View"> <i class="fa fa-pencil"></i></a>';

								str += '<a href="javascript:void(0);" data-id="'+ row.placeid +'" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>';

								str += '<a onClick="return confirm(\'Are you sure to delete this place?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.placeid) + '"  class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

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

