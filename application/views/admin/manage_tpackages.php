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
					<i class="fa fa-globe"></i>
				</div>
				<div class="header-title">
					<h1>Tour Packages</h1>
					<small>Manage tour packages</small>
				</div>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<?php echo $message; ?>
					<span id="ww"> </span>
					<div class="col-sm-12">
						<div class="panel panel-bd lobidrag">
							<div class="panel-heading">
								<div class="btn-group" id="buttonexport">
									<a href="<?php echo base_url(); ?>admin/tour-packages/add">
										<h4><i class="fa fa-plus-circle"></i> Add Tour Package</h4>
									</a>
								</div>
							</div>
							<div class="panel-body">
								<form class="search-sec" id="search_form">
									<div class="row">

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="packages">Packages</label></div>
													<div class="col-md-9">
														<input type="text" class="form-control" placeholder="Packages" name="packages" id="packages" maxlength="100">
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="starting_city">Starting City</label></div>
													<div class="col-md-9">
														<select class="form-control" name="starting_city" id="starting_city">
															<option value="0">--Select Starting City--</option>
															<?php echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "status = 1", "destination_name asc", ""); ?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="itinerary">Itinerary</label></div>
													<div class="col-md-9">
														<select class="form-control" name="itinerary" id="itinerary">
															<option value="0">--Select Itinerary--</option>
															<?php echo $this->Common_model->populate_select($dispid = 0, "itinerary_id", "itinerary_name", "tbl_itinerary", "status = 1", "itinerary_name asc", ""); ?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="pduration"> Duration</label></div>
													<div class="col-md-9">
														<select class="form-control" name="pduration" id="pduration">
															<option value="0">-- Select Duration --</option>
															<?php  echo $this->Common_model->populate_select($dispid = 0, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="statusid">Status</label></div>
													<div class="col-md-9">
														<select class="form-control" name="statusid" id="statusid">
															<option value="0">--Select Status--</option>
															<option value="1">Active</option>
															<option value="2">Inactive</option>
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group ">
												<a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
											</div>
										</div>

									</div>
								</form>
								<div class="table-responsive">
									<table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/tour_packages/datatable" data-view-url="<?php echo base_url(); ?>admin/tour_packages/view/ID" data-edit-url="<?php echo base_url(); ?>admin/tour_packages/edit/ID" data-delete-url="<?php echo base_url(); ?>admin/tour_packages/delete/ID">
										<thead>
											<tr class="table-heading">
												<th width="6%">Sl #</th>
												<th width="13%">Packages</th>
												<th width="10%">Starting City</th>
												<th width="10%">Package Durations</th>
												<th width="9%">Price (<?php echo $this->Common_model->currency; ?>)</th>
												<th width="13%">Itinerary</th>
												<th width="12%">Banner Images</th>
												<th width="12%">Tour Images</th>
												<th width="6%">Status</th>
												<th width="9%">Action</th>
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
					url: "<?php echo base_url(); ?>admin/tour_packages/view_pop/" + val,
					type: 'post',
					data: {
						'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
					},
					cache: false,
					//processData: false,
					success: function(modal_content) {
						jQuery('#myModal .modal-content').html(modal_content);
						// LOADING THE AJAX MODAL
						$('#myModal').modal('show');
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
						$('#errMessage').html('<div class="errormsg"><i class="fa fa-times"></i> Your query could not executed. Please try again.</div>');
					}
				});
			});

			$(document).on('click', '.status', function() {
				if (confirm('Are you sure to change the status?')) {
					var val = $(this).data("id");
					var valsplit = val.split("-");
					var id = valsplit[1];
					$('[data-id=' + val + ']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
					$.ajax({
						url: "<?php echo base_url(); ?>admin/tour_packages/changestatus/" + id,
						type: 'post',
						data: {
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
						cache: false,
						success: function(data) {
							$('.spinner').remove();
							if (data == '1') //Inactive
							{
								$('[data-id=' + val + ']').html('<a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a>');
							} else if (data == '0') //Active
							{
								$('[data-id=' + val + ']').html('<a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a>');
							} else {
								alert("Sorry! Unable to change status.");
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
						}
					});
				}
			});

			$(document).ready(function() {
				searchValidator();
			});

			function searchValidator() {
				$('#datatable').css('display', 'none');
				if ($('#packages').val() != '') {
					packages = $('#packages').val();
				} else {
					packages = '';
				}

				if ($('#starting_city').val() > 0) {
					starting_city = $('#starting_city').val();
				} else {
					starting_city = 0;
				}

				if ($('#itinerary').val() > 0) {
					itinerary = $('#itinerary').val();
				} else {
					itinerary = 0;
				}

				if ($('#pduration').val() > 0) {
					pduration = $('#pduration').val();
				} else {
					pduration = 0;
				}

				if ($('#statusid').val() > 0) {
					statusid = $('#statusid').val();
				} else {
					statusid = 0;
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
					"lengthChange": true,
					"lengthMenu": [
						[10, 25, 50, 100, -1],
						[10, 25, 50, 100, "All"]
					],
					"ajax": {
						"url": $('#datatable').data('url'),
						"type": "POST",
						"dataType": 'json',
						"data": {
							'packages': packages,
							'starting_city': starting_city,
							'itinerary': itinerary,
							'pduration': pduration,
							'statusid': statusid,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "tpackage_name",
							render: function(data, type, row) {
								var str = '<a href="' + row.tpackage_url + '" target="_blank">' + row.tpackage_name + ' (' + row.tpackage_code + ')</a>';

								return str;
							}
						},
						{
							data: "package_starting_city_name"
						},
						{
							data: "package_durationnew"
						},
						{
							data: "price"
						},
						{
							data: "package_itinerary_name",
							render: function(data, type, row) {
								var str = '<a href="' + row.package_itinerary_url + '" target="_blank">' + row.package_itinerary_name + '</a>';

								return str;
							}
						},
						{
							data: "tpackage_image_url",
							render: function(data, type, row) {
								var str = "";

								if (row.tpackage_image_url != '') {
									str = '<a href="' + row.tpackage_image_url + '" target="_blank"><img src="' + row.tpackage_image_url + '" style="width:90px;" alt="image" /></a>';
								}

								return str;
							}
						},
						{
							data: "tour_thumb",
							render: function(data, type, row) {
								var str = "";

								if (row.tour_thumb != '') {
									str = '<a href="' + row.tour_thumb + '" target="_blank"><img src="' + row.tour_thumb + '" style="width:90px;" alt="image" /></a>';
								}

								return str;
							}
						},
						{
							data: "status",
							render: function(data, type, row) {
								var str = "";
								if (row.status == 1) {
									str = '<span class="status" data-id="status-' + row.tourpackageid + '"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>';
								} else {
									str = '<span class="status" data-id="status-' + row.tourpackageid + '"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>';
								}
								return str;
							}
						},
						{
							data: "tourpackageid",
							render: function(data, type, row) {
								var str = '<a href="' + $('#datatable').data('view-url').replace("ID", row.tourpackageid) + '"  class="btn btn-primary btn-sm view1" title="View"> <i class="fa fa-eye"></i></a>';

								str += '<a href="' + $('#datatable').data('edit-url').replace("ID", row.tourpackageid) + '"  class="btn btn-success btn-sm" title="View"> <i class="fa fa-pencil"></i></a>';

								str += '<a onClick="return confirm(\'Are you sure to delete this package?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.tourpackageid) + '"  class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

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