<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("head.php"); ?>
	<link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
	<style>.hdnForm{ display: none;}</style>
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
					<h1>Enquiries</h1>
					<small>Manage Enquiries Report</small>
				</div>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="row">
					<?php echo $message; ?>
					<div class="col-sm-12">
						<div class="panel panel-bd lobidrag">
							<div class="panel-body">

								<form class="search-sec" id="search_form">
									<div class="row">

									<div class="col-md-6">
											<div class="form-group datepickerbox">
												<div class="row">
													<div class="col-md-4">
														<label for="from_date">Followup From Date</label>
													</div>
													<div class="col-md-8">
														<input type="text" class="form-control datepicker" id="from_date" name="from_date" placeholder="dd/mm/yyyy" style="background-color:#fff;" readonly>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group datepickerbox">
												<div class="row">
													<div class="col-md-4">
														<label for="to_date">To Date</label>
													</div>
													<div class="col-md-8">
														<input type="text" class="form-control datepicker" id="to_date" name="to_date" placeholder="dd/mm/yyyy" style="background-color:#fff;" readonly>
													</div>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-4"> <label for="customer_name">Customer Name</label></div>
													<div class="col-md-8">
														<input type="text" class="form-control" placeholder="Customer Name" name="customer_name" id="customer_name" maxlength="100">
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-4"> <label for="phone_number">Phone Number</label></div>
													<div class="col-md-8">
														<input type="text" class="form-control" placeholder="Phone Number" name="phone_number" id="phone_number" maxlength="100">
													</div>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
										
										
										<div class="col-md-6">
											<?php //if ($this->session->userdata('usertype') == 1) { ?>
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="assign_to">Assign To</label></div>
														<div class="col-md-8">
															<select class="form-control" name="assign_to" id="assign_to">
																<option value="0">--Select Assign To--</option>
																<?php echo $this->Common_model->populate_select($dispid = 0, "adminid", "admin_name", "tbl_admin", "status = 1 and adminid in (select adminid from tbl_admin_modules where moduleid = 20)", "admin_name asc", ""); ?>
															</select>
														</div>
													</div>
												</div>
											<?php //} ?>
										</div>										

										<div class="col-md-6">
											<div class="form-group">
												<a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
												<a href="<?php echo base_url(); ?>admin/enquiries-report" class="btn blackbtn">Reset</a>
											</div>
										</div>

									</div>
								</form>

								<div class="table-responsive">
									<div class="text-right mt10">
										<a href="javascript:void(0)" onclick="return exportExcel();" class="btn btn-primary">Export CSV</a>
									</div>

									<table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/enquiries-report/datatable" >
										<thead>
											<tr class="table-heading">
												<th width="5%">Sl #</th>
												<th width="10%">Enquiry Number</th>
												<th width="17%">Customer Name</th>
												<th width="15%">Email Address</th>
												<th width="13%">Phone Number</th>
												<th width="10%">Followup Date</th>
												<th width="10%">Followup By</th>
												<th width="10%">Status</th>
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
			<div class="modal-dialog modal-lg" style="width: 940px;">
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
					url: "<?php echo base_url(); ?>admin/enquiries-entry/view/" + val,
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

			$(document).on('click', '.edit', function() {
				jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
				var val = $(this).data("id");
				$.ajax({
					url: "<?php echo base_url(); ?>admin/enquiries-report/edit_pop/" + val,
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

			$(document).on('click', '.assignto', function() {
				jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
				var val = $(this).data("id");
				$.ajax({
					url: "<?php echo base_url(); ?>admin/enquiries-report/edit_assignto/" + val,
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

			$(document).ready(function() {
				$('.datepicker').datepicker({
					format: 'dd/mm/yyyy',
					todayHighlight: true,
					autoclose: true,
				});

				searchValidator();
			});

			function exportExcel() {
				if ($('#customer_name').val() != '') {
					customer_name = $('#customer_name').val();
				} else {
					customer_name = '';
				}
				if ($('#phone_number').val() != '') {
					phone_number = $('#phone_number').val();
				} else {
					phone_number = '';
				}
				if ($('#assign_to').val() > 0) {
					assign_to = $('#assign_to').val();
				} else {
					assign_to = 0;
				}
				if ($('#from_date').val() != '') {
					from_date = $('#from_date').val();
				} else {
					from_date = '';
				}
				if ($('#to_date').val() != '') {
					to_date = $('#to_date').val();
				} else {
					to_date = '';
				}

				var url = "<?php echo base_url(); ?>admin/enquiries-report/export_data";
				var form = $(`<?php echo form_open(base_url().'admin/enquiries-report/export_data', array('id' => 'form_excel', 'name' => 'form_excel', 'class' => 'hdnForm', 'enctype' => 'multipart/form-data')); ?>` +
				'<input type="text" name="customer_name" value="' + customer_name + '" />' +
				'<input type="text" name="phone_number" value="' + phone_number + '" />' +
				'<input type="text" name="assign_to" value="' + assign_to + '" />' +
				'<input type="text" name="from_date" value="' + from_date + '" />' +
				'<input type="text" name="to_date" value="' + to_date + '" />' +
				'</form>');
				$('body').append(form);
				$(form).submit();
    			document.body.removeChild(form);
			}

			function searchValidator() {
				$('#datatable').css('display', 'none');
				if ($('#customer_name').val() != '') {
					customer_name = $('#customer_name').val();
				} else {
					customer_name = '';
				}

				if ($('#phone_number').val() != '') {
					phone_number = $('#phone_number').val();
				} else {
					phone_number = '';
				}

				if ($('#assign_to').val() > 0) {
					assign_to = $('#assign_to').val();
				} else {
					assign_to = 0;
				}

				if ($('#from_date').val() != '') {
					from_date = $('#from_date').val();
				} else {
					from_date = '';
				}

				if ($('#to_date').val() != '') {
					to_date = $('#to_date').val();
				} else {
					to_date = '';
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
					buttons: [
                'excel'
            ],
					"ajax": {
						"url": $('#datatable').data('url'),
						"type": "POST",
						"dataType": 'json',
						"data": {
							'customer_name': customer_name,
							'phone_number': phone_number,
							'assign_to': assign_to,
							'from_date': from_date,
							'to_date': to_date,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "inquiry_number"
						},
						{
							data: "customer_name"
						},
						{
							data: "email_address"
						},
						{
							data: "phone_number"
						},
						{
							data: "followup_date"
						},
						{
							data: "assign_to"
						},
						{
							data: "status"
						},
						{
							data: "id",
							render: function(data, type, row) {

								var str = '<a data-id="' + row.id + '" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>';

								str += '<a data-id="' + row.id + '" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-sm edit" title="Edit"> <i class="fa fa-pencil"></i></a>';

								str += '<a data-id="' + row.id + '" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-sm assignto" title="Assign To"> <i class="fa fa-paper-plane"></i></a>';

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