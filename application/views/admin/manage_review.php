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
                        <i class="fa fa-comment-o"></i>
                    </div>
                    <div class="header-title">
                        <h1>Reviews</h1>
                        <small>Manage Reviews</small>
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
                                        <a href="<?php echo base_url(); ?>admin/review/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Review </h4>
                                        </a> </div>
                                </div> 
                                <div class="panel-body">
                                    
									<form class="search-sec" id="search_form">
										<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3"> <label for="reviewer_name"> Name</label></div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Name" name="reviewer_name" id="reviewer_name" maxlength="100">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
                                                        <div class="col-md-3"> <label for="reviewer_loc"> Location</label></div>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Location" name="reviewer_loc" id="reviewer_loc" maxlength="100">
														</div>
													</div>
												</div>
											</div>
                                            <div class="clearfix"></div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-3"> <label for="ratings">Ratings</label></div>
														<div class="col-md-9">
															<select class="form-control" name="ratings" id="ratings">
																<option value="0">--Select Ratings--</option>
																<option value="1">1</option>
                                                                <option value="1.5">1.5</option>
                                                                <option value="2">2</option>
                                                                <option value="2.5">2.5</option>
                                                                <option value="3">3</option>
                                                                <option value="3.5">3.5</option>
                                                                <option value="4">4</option>
                                                                <option value="4.5">4.5</option>
                                                                <option value="5">5</option>
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

                                        <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/review/datatable" data-view-url="<?php echo base_url(); ?>admin/review/view/ID" data-edit-url="<?php echo base_url(); ?>admin/review/edit/ID" data-delete-url="<?php echo base_url(); ?>admin/review/delete_rvw/ID">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th width="5%">SI #</th>
                                                    <th width="11%">Name</th>
                                                    <th width="10%">Location</th>
                                                    <th width="10%">Tour tags</th>
                                                    <th width="12%">No of Star</th>
                                                    <th width="30%">Review</th>
                                                    <th width="10%">Review Date</th>
                                                    <th width="10%">Status </th>
                                                    <th width="12%">Action</th>
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
		
		
		$(document).on('click', '.view', function(){
            jQuery('#myModal .modal-content').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');
            var val = $(this).data("id");				
            $.ajax({
                url: "<?php echo base_url(); ?>admin/review/view_pop/"+val,
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
						url: "<?php echo base_url(); ?>admin/review/changestatus/"+id,
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
            
        function searchValidator(){
            $('#datatable').css('display', 'none');
            if($('#reviewer_name').val() != '') {
                reviewer_name = $('#reviewer_name').val();
            }else{
                reviewer_name = '';
            }
            if($('#reviewer_loc').val() != '') {
                reviewer_loc = $('#reviewer_loc').val();
            }else{
                reviewer_loc = '';
            }
            if($('#ratings').val() > 0) {
                ratings = $('#ratings').val();
            }else{
                ratings = 0;
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
                        'reviewer_name': reviewer_name,
                        'reviewer_loc': reviewer_loc,
                        'ratings': ratings,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                },
                "columns": [{
                        data: "sl_no"
                    },
                    {
                        data: "reviewer_name"
                    },
                    {
                        data: "reviewer_loc"
                    },
                    {
                        data: "tag_name"
                    },
                    {
                        data: "star_field"
                    },
                    {
                        data: "feedback_msg"
                    },
                    {
                        data: "created_date"
                    },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            var str = "";
                            if (row.status == 1) {
                                str = '<span class="status" data-id="status-' + row.review_id + '"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>';
                            } else {
                                str = '<span class="status" data-id="status-' + row.review_id + '"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>';
                            }
                            return str;
                        }
                    },
                    {
                        data: "review_id",
                        render: function(data, type, row) {
                            var str = '<a href="' + $('#datatable').data('edit-url').replace("ID", row.review_id) + '"  class="btn btn-success btn-sm view1 tbl-icon-btm" title="Edit"> <i class="fa fa-pencil"></i></a>';

                            str += '<a href="javascript:void(0);" data-toggle="modal" data-id="'+ row.review_id +'" data-target="#myModal" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>';

                            str += '<a onClick="return confirm(\'Are you sure to delete this review?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.review_id) + '" class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

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

