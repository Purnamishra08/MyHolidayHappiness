<!DOCTYPE html>
<html lang="en">
  <head>
      <?php include("head.php"); ?>
      <link href="<?php echo base_url(); ?>assets/admin/css/chosen.css" rel="stylesheet" type="text/css"/>
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
                      <small>Add Itinerary</small>
                  </div>
              </section>
              <!-- Main content -->
			  
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-bd lobidrag">
								<div class="panel-heading">
									<div class="btn-group" id="buttonexport">
										<a href="<?php echo base_url(); ?>admin/itinerary">
											<h4><i class="fa fa-plus-circle"></i> Manage Itinerary</h4>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_itinerary', 'name' => 'form_itinerary', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                    
									<div class="box-main">
										<h3>Itinerary Details</h3>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Itinerary Name</label>
													<input type="text" class="form-control" placeholder="Enter Itinerary Name" name="itinerary_name" id="itinerary_name" value="<?php echo set_value('itinerary_name'); ?>">
												</div>                                                 
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label>Itinerary Url</label>
													<input type="text" class="form-control" placeholder="Enter Itinerary Url" name="itinerary_url" id="itinerary_url" value="<?php echo set_value('itinerary_url'); ?>">
												</div>   
											</div>

											<div class="clearfix"></div> 

											<div class="col-md-6"> 
												<div class="form-group">
													<label> Place Type </label>
													<?php   
														$get_placetype = $this->Common_model->get_records("destination_type_id, destination_type_name", "tbl_destination_type", "status = '1' ", "destination_type_name asc", "");
													?>
													<select data-placeholder="Choose tour Place Type" class="chosen-select" multiple tabindex="4" id="getplacetypeid"  name="getplacetypeid[]"
													style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
														<?php foreach ($get_placetype as $get_placetypes) { ?>
														<option value="<?= $get_placetypes['destination_type_id'] ?>"><?= $get_placetypes['destination_type_name'] ?></option>
														<?php } ?>
													</select> 
												</div>
												<div id="getplacetype_err"></div>
											</div>											      
                                            
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Associated Tour Tag </label>
													<?php   
													$get_getawaytags = $this->Common_model->get_records("tagid, tag_name", "tbl_menutags", "status = '1' and menuid = '3'", "tag_name asc", "");
													?>
													<select data-placeholder="Choose tour tags" class="chosen-select" multiple tabindex="4" id="getatagid"  name="getatagid[]"
													style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
														<?php foreach ($get_getawaytags as $get_getawaytag) { ?>
														<option value="<?= $get_getawaytag['tagid'] ?>"><?= $get_getawaytag['tag_name'] ?></option>
														<?php } ?>
													</select> 
												</div>
												<div id="gettourtag_err"></div>
											</div>
											
											<div class="clearfix"></div> 

											<div class="col-md-6"> 
												<div class="form-group">
													<label>Mode Of Travel</label>
													<input type="text" class="form-control" placeholder="Enter mode of travel" name="travel_mode" id="travel_mode" value="<?php echo set_value('travel_mode'); ?>">
												</div>
												<div id="mode_err"> </div>
											</div>                                    
													   
											<div class="col-md-6"> 
												<div class="form-group">
													<label>Ideal Start Time</label>
													<input type="text" class="form-control" placeholder="Enter Ideal Start Time" name="ideal_time" id="ideal_time" value="<?php echo set_value('ideal_time'); ?>">
												</div>
											</div>
											
											<div class="clearfix"></div>   

											<div class="col-md-6"> 
												<div class="form-group">
													<label>Trip Duration</label>
													<select class="form-control drtn" name="duration" id="duration">
														<option value=''>-- Select Duration --</option>
														<?php  echo $this->Common_model->populate_select($dispid = 0, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
													</select>                                                     
												</div>
											</div> 
											
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Itinerary ratings</label>
													<select class="form-control" name="rating" id="rating" >
														<option value="0">Select Rating</option>
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
                                              
										
											<div class="clearfix"></div>
										 
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Banner Image</label>
													<input type="file" name="itineraryimg" id="itineraryimg" >
													<span>Image size should be 2000px X 450px </span>
												</div>
											</div> 
													
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Itirnary Image</label>
													<input type="file" name="itinerarythumbimg" id="itinerarythumbimg" >
													<span>Image size should be 400px X 500px </span>
												</div>
											</div> 
										
											<div class="clearfix"></div> 
											
											<div class="col-md-6"> 
												<div class="form-group">
													<label>Starting City</label>
													<select class="form-control" name="starting_city" id="starting_city">
														<option value="">-- Select Starting City --</option>
														<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "status = 1", "destination_name asc", ""); ?>
													</select>                                                     
												</div>
											</div>	
											
											<div class="col-md-6"> 
												<div class="form-group mt30">
													<input type="checkbox" name="show_in_home" id="show_in_home" value="1">
													<label> Show on home page (For Popular Itineraries)</label>
												</div>
											</div> 
											
											<div class="clearfix"></div>                                              
										</div>
									</div>

									<div class="box-main">
										<h3>Associated destinations</h3>
										<div class="row">                                                
											<div class="col-md-12">                                                 
												<table id="addRowTable" class="table table-bordered table-striped table-hover">
													<thead>
														<tr class="info">
															<th width="17%">Destination name</th>
															<th width="20%">No of Days</th>
															<th width="20%">No of Nights</th>
															<th width="7%"></th>
														</tr>
													</thead>
													<tbody>  
														<tr>
															<td>						
																<select class="form-control"  id="destination_id"  name="destination_id[]" >
																	<option value="">-- Select destination --</option>
																	<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
																</select> 
																<div id="seasontype_err">  </div>
															</td>      
															
															<?php $max_noof_days = $this->Common_model->showname_fromid("max(no_ofdays)", "tbl_package_duration", ""); ?>
															<td>
																<select class="form-control" name="no_ofdays[]" id="no_ofdays">
																	<option value=''>-- Select Days --</option>
																	<?php  echo $this->Common_model->generate_numberbox(0, $max_noof_days,"1"); ?>
																</select>    
															</td>
															
															<?php $max_noof_nights = $this->Common_model->showname_fromid("max(no_ofnights)", "tbl_package_duration", ""); ?>
															<td>
																<select class="form-control" name="no_ofnight[]" id="no_ofnight">
																	<option value=''>-- Select Nights --</option>
																	<?php  echo $this->Common_model->generate_numberbox(0, $max_noof_nights); ?>
																</select> 
															</td>
																
															<td>
																<a href="javascript:void(0);" class="btn btn-success btn-sm views addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
																<a href="javascript:void(0);" class="btn btn-danger btn-sm views delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa fa-trash-o"></i></a>  
															</td>
														</tr>           
													</tbody>
												</table>
											</div>
											<div class="clearfix"></div>
										</div>
									</div> 
									
									<div class="clearfix"></div>

									<div id="show_day_wise"></div>
									
									
									<div class="box-main">
										   
										      <h3>Meta Tags</h3>
												<div class="row">  
													<div class="col-md-6"> 
													<div class="form-group">
														<label>Meta Title</label>
														<textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"></textarea>
													</div>
													</div>
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Keywords</label>
														<textarea name="meta_keywords" id="meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"></textarea>
													</div>
													</div>
													
													<div class="clearfix"></div>
													
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Description</label>
														  <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"></textarea>
													</div>
													</div>
                                                <div class="clearfix"></div>
                                            </div> 
                                        </div>								
                                   
      
									<div class="clearfix"></div>
									<div class="col-md-6">
										<div class="reset-button"> 
											<button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
											<button name='reset' type="reset" value='Reset' class="btn blackbtn">Reset</button> 
										</div>
									</div>
									<?php echo form_close(); ?>                                
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		<?php include("footer.php"); ?>
		<script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>

		<script>
			$(document.body).on('keyup change', '#itinerary_name', function() {
				$("#itinerary_url").val(name_to_url($(this).val()));
			});
			function name_to_url(name) {
				name = name.toLowerCase(); // lowercase
				name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
				name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
				name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
				return name;
			}
		</script> 

		<script>
			$(document).ready(function(){
				$('#getatagid').chosen();			
				$('#getplacetypeid').chosen();
			});
		</script>

		<script>
			$(document).on('change', '.drtn', function(){       
				var val = $(this).val();
				//alert(val);
				if(val != 0)
				{
					$.ajax({
						url:"<?php echo base_url();?>/admin/itinerary/getdaywise/"+val,
						//data:"durationid="+val,
						data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
						method:"post",
						success:function(data){
							//alert(data);
							$("#show_day_wise").html(data);
						}
					})
				}
				else
					$("#show_day_wise").html('');
			});    
		</script>
  </body>
</html>

