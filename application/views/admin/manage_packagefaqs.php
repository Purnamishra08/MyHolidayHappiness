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
                        <i class="fa fa-question"></i>
                    </div>
                    <div class="header-title">
                        <h1>Package Faqs</h1>
                        <small>Manage Package Faqs</small>
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
                                        <a href="<?php echo base_url(); ?>admin/packagefaqs/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Package Faq	</h4>
                                        </a> 
									</div>
                                </div>
                                <div class="panel-body">
								<form class="search-sec" id="search_form">
									<div class="row">

									<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="packageid">Tour Package</label></div>
													<div class="col-md-9">
													<select class="form-control" name="packageid" id="packageid">
                                                        <option value=""> --Select Package--</option>
                                                        <?php  echo $this->Common_model->populate_select($dispid = 0, "tagid", "tag_name", "tbl_menutags", "menuid = 3", "tag_name asc", ""); ?>
                                                    </select>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="question">Question</label></div>
													<div class="col-md-9">
														<input type="text" class="form-control" placeholder="Question" name="question" id="question" maxlength="100">
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<div class="col-md-3"> <label for="answer">Answer</label></div>
													<div class="col-md-9">
														<input type="text" class="form-control" placeholder="Answer" name="answer" id="answer" maxlength="100">
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

										<div class="col-md-12">
											<div class="form-group text-center">
												<a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
											</div>
										</div>

									</div>
								</form>
                                    <div class="table-responsive">
                                        <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/packagefaqs/datatable" data-edit-url="<?php echo base_url(); ?>admin/packagefaqs/edit/ID" data-delete-url="<?php echo base_url(); ?>admin/packagefaqs/delete/ID">
                                            <thead>
                                                <tr class="info">
                                                	<th>Sl #</th>
												   <th>Package</th> 
												   <th>Questions</th> 
												   <th>Answers</th>
												   <th>Order</th>
												   <th>Created</th>
												   <th>Status</th>
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
					$('[data-id='+val+']').after('<div class="spinner" style="text-align:center;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-1x"></i></div>');
					$.ajax({
						url: "<?php echo base_url(); ?>admin/packagefaqs/changestatus/"+id,
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

			function searchValidator() {
				$('#datatable').css('display', 'none');
				if ($('#packageid').val() > 0) {
					packageid = $('#packageid').val();
				} else {
					packageid = 0;
				}

				if ($('#question').val() != '') {
					question = $('#question').val();
				} else {
					question = '';
				}
				if ($('#answer').val() != '') {
					answer = $('#answer').val();
				} else {
					answer = '';
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
							'packageid': packageid,
							'question': question,
							'answer': answer,
							'statusid': statusid,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "tag_name"
						},
						{
							data: "faq_question"
						},
						{
							data: "faq_answer"
						},
						{
							data: "faq_order"
						},
						{
							data: "created_date"
						},
						{
							data: "status",
							render: function(data, type, row) {
								var str = "";
								if (row.status == 1) {
									str = '<span class="status" data-id="status-' + row.faq_id + '"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>';
								} else {
									str = '<span class="status" data-id="status-' + row.faq_id + '"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>';
								}
								return str;
							}
						},
						{
							data: "hotel_id",
							render: function(data, type, row) {
								var str = '<a href="' + $('#datatable').data('edit-url').replace("ID", row.faq_id) + '"  class="btn btn-success btn-sm view" title="View"> <i class="fa fa-pencil"></i></a>';

								str += '<a onClick="return confirm(\'Are you sure to delete this faq?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.faq_id) + '"  class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

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

