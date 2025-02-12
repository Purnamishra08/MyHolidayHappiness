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
                        <i class="fa fa-superpowers"></i>
                    </div>
                    <div class="header-title">
                        <h1>Itinerary</h1>
                        <small>Manage Itinerary</small>
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
                                        <a href="<?php echo base_url(); ?>admin/itinerary/add">
                                            <h4><i class="fa fa-plus-circle"></i> Add Itinerary</h4>
                                        </a> 
                                    </div>
                                </div>
                                <div class="panel-body">
                                    
									<form class="search-sec" id="search_form">
										<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="itinerary_name">Itinerary Name</label></div>
														<div class="col-md-8">
															<input type="text" class="form-control" placeholder="Itinerary Name" name="itinerary_name" id="itinerary_name" maxlength="100">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="starting_city">Starting City</label></div>
														<div class="col-md-8">
															<select class="form-control" name="starting_city" id="starting_city">
																<option value="0">--Select Starting City--</option>
																<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "status = 1", "destination_name asc", ""); ?>
															</select>
														</div>
													</div>
												</div>
											</div>
                                            <div class="clearfix"></div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="trip_duration">Trip Duration</label></div>
														<div class="col-md-8">
															<select class="form-control" name="trip_duration" id="trip_duration">
																<option value="0">--Select Trip Duration--</option>
																<?php  echo $this->Common_model->populate_select($dispid = 0, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="row">
														<div class="col-md-4"> <label for="ratings">Ratings</label></div>
														<div class="col-md-8">
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
											<div class="col-md-12">
												<div class="form-group text-center">
													<a href="javascript:void(0)" class="btn redbtn" onclick="return searchValidator();"><i class="fa fa-search"></i> Search</a>
												</div>
											</div>

										</div>
									</form>

                                    <div class="table-responsive">
                                        <table id="datatable" data-toggle="table" class="table table-bordered table-striped table-hover" data-url="<?php echo base_url(); ?>admin/itinerary/datatable" data-view-url="<?php echo base_url(); ?>admin/itinerary/view/ID" data-edit-url="<?php echo base_url(); ?>admin/itinerary/edit/ID" data-delete-url="<?php echo base_url(); ?>admin/itinerary/delete/ID">
                                            <thead>
                                                <tr class="table-heading">
                                                    <th width="6%">Sl #</th>
                                                    <th width="15%">Itinerary Name</th> 
                                                    <th width="14%">Starting City</th>
													<th width="12%">Trip Duration</th>
													<th width="8%">Ratings</th> 
													<th width="10%">Banner Images</th>
													<th width="10%">Itinerary Images</th>
													<th width="9%">Home page</th>
                                                    <th width="6%">Status</th>
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
                        url: "<?php echo base_url(); ?>admin/itinerary/changestatus/"+id,
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
      
      
       /* Featured*/
			
			$(document).on('click', '.unfeatured', function() {   
				var tid = $(this).data("id");
				if(confirm("Are you sure, you want to unfeature this package?")) { 
				$.ajax({
					url: "<?php echo base_url(); ?>admin/itinerary/mark_as_unfeatured",
					type: 'post',   
					data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',tid : tid},   
					success: function (data) {
						$("#ww").html(data);  
						location.reload();
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
					}
				});
			  }
			});
			
			 /* Unfeatured*/
			
			$(document).on('click', '.featured', function() {   
				var tid = $(this).data("id");
				if(confirm("Are you sure, you want to feature this package?")) { 
				$.ajax({
					url: "<?php echo base_url(); ?>admin/itinerary/mark_as_featured",
					type: 'post',   
					data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',tid : tid},   
					success: function (data) {
						$("#ww").html(data);  
						location.reload();
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
					}
				});
			  }
			});




            $(document).ready(function () {
    			searchValidator();
            });
            
			function searchValidator(){
				$('#datatable').css('display', 'none');
				if($('#itinerary_name').val() != '') {
					itinerary_name = $('#itinerary_name').val();
				}else{
					itinerary_name = '';
				}
				if($('#starting_city').val() > 0) {
					starting_city = $('#starting_city').val();
				}else{
					starting_city = 0;
				}
				if($('#trip_duration').val() > 0) {
					trip_duration = $('#trip_duration').val();
				}else{
					trip_duration = 0;
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
							'itinerary_name': itinerary_name,
							'starting_city': starting_city,
							'trip_duration': trip_duration,
							'ratings': ratings,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
						},
					},
					"columns": [{
							data: "sl_no"
						},
						{
							data: "itinerary_name",
							render: function(data, type, row) {
								var str = '<a href="' + row.itinerary_url + '" target="_blank">' + row.itinerary_name + '</a> ';
								return str;
							}
						},
						{
							data: "iti_starting_city_name"
						},
						{
							data: "duration_name"
						},
						{
							data: "iti_ratings"
						},
						{ data: "iti_image",
							render: function ( data, type, row ) {
								var str = '<a target="_blank" href="'+row.iti_image+'"><img src="'+ row.iti_image +'" style="width:90px;height:auto;" alt="iti_image"/></a>';
								return str;
							} 
						},
						{ data: "iti_thumb",
							render: function ( data, type, row ) {
								var str = '<a target="_blank" href="'+row.iti_thumb+'"><img src="'+ row.iti_thumb +'" style="width:90px;height:auto;" alt="iti_thumb"/></a>';
								return str;
							} 
						},
						{
							data: "show_in_home",
							render: function(data, type, row) {
								var str = "";
								if (row.show_in_home == 1) {
									str = '<span class="btn btn-success" title="Yes"><i class="fa fa-check"></i></span>';
								} else {
									str = '<span class="btn btn-danger" title="No"><i class="fa fa-times"></i></span>';
								}
								return str;
							}
						},
						{
							data: "status",
							render: function(data, type, row) {
								var str = "";
								if (row.status == 1) {
									str = '<span class="status" data-id="status-' + row.itinerary_id + '"><a href="javascript:void(0)" title="Status is active. Click here to make it inactive."><span class="label-custom label label-success">Active</span></a></span>';
								} else {
									str = '<span class="status" data-id="status-' + row.itinerary_id + '"><a href="javascript:void(0)" title="Status is inactive. Click here to make it active."><span class="label-custom label label-danger">Inactive</span></a></span>';
								}
								return str;
							}
						},
						{
							data: "itinerary_id",
							render: function(data, type, row) {
								var str = '<a href="' + $('#datatable').data('edit-url').replace("ID", row.itinerary_id) + '"  class="btn btn-success btn-sm view" title="Edit"> <i class="fa fa-pencil"></i></a>';

								str += '<a href="' + $('#datatable').data('view-url').replace("ID", row.itinerary_id) + '" class="btn btn-primary btn-sm view" title="View"><i class="fa fa-eye"></i></a>';

								str += '<a onClick="return confirm(\'Are you sure to delete this itinerary?\')" href="' + $('#datatable').data('delete-url').replace("ID", row.itinerary_id) + '" class="btn btn-danger btn-sm " title="Delete"><i class="fa fa-trash-o"></i> </a>';

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

