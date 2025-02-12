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
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="header-title">
                        <h1>Bookings</h1>
                        <small>Manage Bookings</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
						 <span id="ww"> </span>
                        <?php echo $message; ?>
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <h4><i class="fa fa-plus-circle"></i> Manage Bookings</h4>
                                    </div>
                                </div>
                                <div class="panel-body">

                                    <form class="search-sec" id="search_form">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3"> <label for="invoice_no">Invoice #</label></div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Invoice #" name="invoice_no" id="invoice_no" maxlength="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3"> <label for="package_name">Package Name</label></div>
                                                        <div class="col-md-9">
                                                            <select class="form-control" name="package_name" id="package_name">
                                                                <option value="0">--Select Destination--</option>
                                                                <?php  echo $this->Common_model->populate_select($dispid = 0, "tourpackageid", "tpackage_name", "tbl_tourpackages", "", "tpackage_name asc", ""); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3"> <label for="customer_info">Customer Info</label></div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" placeholder="Customer Info" name="customer_info" id="customer_info" maxlength="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3"> <label for="booking_status">Booking Status</label></div>
                                                        <div class="col-md-9">
                                                            <select class="form-control" name="booking_status" id="booking_status">
                                                                <option value="0">--Select Status--</option>
                                                                <option value="1">Approved</option>
                                                                <option value="2">Cancelled</option>
                                                                <option value="3">Pending</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group text-center">
                                                    <a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/bookings/datatable" data-view-url="<?php echo base_url(); ?>admin/bookings/view/ID" data-delete-url="<?php echo base_url(); ?>admin/bookings/delete/ID">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th width="6%">Sl #</th>
													<th width="12%">Invoice #</th>
                                                    <th width="16%">Package Name</th> 
                                                    <th width="12%">Customer</th>                  
													<th width="8%">Total Price</th>
													<th width="12%">Payment Status</th>													
													<th width="9%">Travel date</th>
                                                    <th width="8%">Invoice date</th>
													<th width="9%">Booking Status</th>
                                                    <th width="8%">Action</th>
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
            $(document).ready(function () {
                searchValidator();
            });
            
			function searchValidator(){
				$('#datatable').css('display', 'none');
				if($('#invoice_no').val() != '') {
					invoice_no = $('#invoice_no').val();
				}else{
					invoice_no = '';
				}
				if($('#package_name').val() > 0) {
					package_name = $('#package_name').val();
				}else{
					package_name = 0;
				}

				if($('#customer_info').val() != '') {
					customer_info = $('#customer_info').val();
				}else{
					customer_info = '';
				}

				if($('#booking_status').val() > 0) {
					booking_status = $('#booking_status').val();
				}else{
					booking_status = 0;
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
							'invoice_no': invoice_no,
							'package_name': package_name,
							'customer_info': customer_info,
							'booking_status': booking_status,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "invoice_no",
							render: function(data, type, row) {
								var str = '<a href="' + row.booking_url + '" target="_blank">' + row.invoice_no + '</a> ';
								return str;
							}
						},
                        {
							data: "package_name",
							render: function(data, type, row) {
								var str = '<a href="' + row.package_url + '" target="_blank">' + row.package_name + '</a> ';
								return str;
							}
						},
                        {
							data: "fullname",
							render: function(data, type, row) {
								var str = row.fullname + "<br>";
                                str += row.contact + "<br>";
                                str += row.email_id;
								return str;
							}
						},
						{
							data: "total_price"
						},
						{
							data: "payment_status"
						},
						{
							data: "date_of_travel"
						},
						{
							data: "booking_date"
						},
						{
							data: "booking_status"
						},
						{
							data: "booking_id",
							render: function(data, type, row) {
                                var str = '';
								str += '<a href="' + $('#datatable').data('view-url').replace("ID", row.booking_id) + '" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>';

								str += '<a onClick="return confirm(\'Are you sure to delete this booking?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.booking_id) + '"  class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

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

