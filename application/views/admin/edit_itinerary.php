<?php
foreach ($edititerdatas as $rows)
{
	$itinerary_id = $rows['itinerary_id'];
	$itinerary_name = $rows['itinerary_name'];
	$itinerary_url = $rows['itinerary_url'];
	$ratings    = $rows['ratings'];
	$iti_travelmode = $rows['iti_travelmode'];
	$iti_idealstime = $rows['iti_idealstime'];
	$iti_duration = $rows['iti_duration'];
	$show_in_home = $rows['show_in_home'];
	$itineraryimg = $rows['itineraryimg'];
	$itinerarythumbimg = $rows['itinerarythumbimg'];
    $alttag_banner = $rows['alttag_banner'];
    $alttag_thumb = $rows['alttag_thumb'];
	$starting_city = $rows['starting_city'];
	$meta_title = $rows['meta_title'];
	$meta_keywords = $rows['meta_keywords'];
	$meta_description = $rows['meta_description'];
}

$getTourTagIds = $this->Common_model->get_records("tourtagid", "tbl_itinerary_tourtags", "itinerary_id='$itinerary_id'", "");
$get_tag_array = '';
if (!empty($getTourTagIds)) 
{
	foreach ($getTourTagIds as $getTourTagId) {
		$get_tag_array .= $getTourTagId['tourtagid'] . ', ';
	}
}

$getplacetypeid = $this->Common_model->get_records("placetype_id", "tbl_itinerary_placetype", "itinerary_id='$itinerary_id'", "");
$get_plctype_array = '';
if (!empty($getplacetypeid)) {
	foreach ($getplacetypeid as $getplacetypeids) {
		$get_plctype_array .= $getplacetypeids['placetype_id'] . ', ';
	}
}
?>

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
						<small> Edit Iternary </small>
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
									<div class="btn-group" id="buttonexport">
										<a href="<?php echo base_url().'admin/itinerary/view/'.$itinerary_id ?>">
											<h4><i class="fa fa-plus-circle"></i> View Itinerary</h4>
										</a>
									</div>                                  
								</div>
								<div class="panel-body">
									<?php echo $message; ?>
									<?php echo form_open('', array( 'id' => 'form_edititinerary', 'name' => 'form_edititinerary', 'class' => 'add-user','enctype' => 'multipart/form-data'));?>
                                    
									<div class="box-main">
                                        <h3>Itinerary Details</h3>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Itinerary Name</label>
													<input type="text" class="form-control" placeholder="Enter Itinerary Name" name="itinerary_name" id="itinerary_name" value="<?php echo set_value('itinerary_name',$itinerary_name); ?>">                                              
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Itinerary Url</label>
													<input type="text" class="form-control" placeholder="Enter Itinerary Url" name="itinerary_url" id="itinerary_url" value="<?php echo set_value('itinerary_url', $itinerary_url); ?>">                                              
												</div>   
											</div>
											
                                            <div class="clearfix"></div>
											
											<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Place Type </label>
                                                    <?php   
                                                        $get_placetype = $this->Common_model->get_records("destination_type_id, destination_type_name", "tbl_destination_type", "status = '1' ", "destination_type_name asc", "");
                                                    ?>
                                                    <select data-placeholder="Choose tour Place Type" class="chosen-select" multiple tabindex="4" id="getplacetypeid"  name="getplacetypeid[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
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
                                                    <select data-placeholder="Choose tour tags" class="chosen-select" multiple tabindex="4" id="getatagid"  name="getatagid[]" style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
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
													<input type="text" class="form-control" placeholder="Enter mode of travel" name="travel_mode" id="travel_mode" value="<?php echo set_value('travel_mode', $iti_travelmode); ?>">
												</div>
												<div id="mode_err"></div>
											</div>                                                                                           
                                                   
                                            <div class="col-md-6"> 
												<div class="form-group">
													<label>Ideal Start Time</label>
													<input type="text" class="form-control" placeholder="Enter Ideal Start Time" name="ideal_time" id="ideal_time" value="<?php echo set_value('ideal_time',$iti_idealstime); ?>">
												</div>
                                            </div>
											
											<div class="clearfix"></div> 

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Trip Duration</label>
                                                    <select class="form-control drtn" name="duration" id="duration">
														<option value=''>-- Select Duration --</option>
                                                        <?php  echo $this->Common_model->populate_select($dispid = $iti_duration, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
                                                    </select>                                                     
												</div>
											</div>  
											
											<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Itinerary ratings</label>
                                                    <select class="form-control" name="rating" id="rating" >
                                                        <option value="0">Select Rating</option>
                                                        <option value="1" <?php if ($ratings == '1') { ?>selected="selected" <?php } ?> >1</option>
                                                        <option value="1.5" <?php if ($ratings == '1.5') { ?>selected="selected" <?php } ?> >1.5</option>
                                                        <option value="2" <?php if ($ratings == '2') { ?>selected="selected" <?php } ?> >2</option>
                                                        <option value="2.5" <?php if ($ratings == '2.5') { ?>selected="selected" <?php } ?> >2.5</option>
                                                        <option value="3" <?php if ($ratings == '3') { ?>selected="selected" <?php } ?> >3</option>
                                                        <option value="3.5" <?php if ($ratings == '3.5') { ?>selected="selected" <?php } ?> >3.5</option>
                                                        <option value="4" <?php if ($ratings == '4') { ?>selected="selected" <?php } ?> >4</option>
                                                        <option value="4.5" <?php if ($ratings == '4.5') { ?>selected="selected" <?php } ?> >4.5</option>
                                                        <option value="5" <?php if ($ratings == '5') { ?>selected="selected" <?php } ?> >5</option>
                                                    </select>                                                     
                                                </div>                          
                                            </div>

											<div class="clearfix"></div>                                                
                                                 
											<div class="col-md-6"> 
												<?php
													if(file_exists("./uploads/".$itineraryimg) && ($itineraryimg!=''))
													{ 
														echo '<a href="'.base_url().'uploads/'.$itineraryimg.'" target="_blank"><img src="'.base_url().'uploads/'.$itineraryimg.'" style="width:86px;height:59px" alt="image" /></a>';
													}
												?>													
											   <div class="form-group">
													<label> Banner Image</label>
													<input type="file"   name="itineraryimg" id="itineraryimg">
													<span>Image size should be 2000px X 450px </span>
												</div>
											</div> 
                                                
											<div class="col-md-6"> 
												<?php
													if(file_exists("./uploads/".$itinerarythumbimg) && ($itinerarythumbimg!=''))
													{ 
														echo '<a href="'.base_url().'uploads/'.$itinerarythumbimg.'" target="_blank"><img src="'.base_url().'uploads/'.$itinerarythumbimg.'" style="width:86px;height:59px" alt="image" /></a>';
													}
												?>													
												<div class="form-group">
													<label> Itinerary Image</label>
													<input type="file"   name="itinerarythumbimg" id="itinerarythumbimg">
													<span>Image size should be 400px X 500px </span>
												</div>
											</div>
                                                
                                            <div class="clearfix"></div> 

											<div class="col-md-6"> 
												<div class="form-group">
													<label> Alt Tag For Banner Image</label>
													<input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="<?php echo set_value('alttag_banner', $alttag_banner); ?>" maxlength="60">
												</div>
											</div>
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Alt Tag For Itinerary Image</label>
													<input type="text" class="form-control" placeholder="Enter Alt tag for itinerary image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb', $alttag_thumb); ?>" maxlength="60">
												</div>
											</div>
											<div class="clearfix"></div>
                                              
											<div class="col-md-6"> 
												<div class="form-group">
													<label>Starting City</label>
													<select class="form-control" name="starting_city" id="starting_city">
														<option value="">-- Select Starting City --</option>
														<?php  echo $this->Common_model->populate_select($dispid = $starting_city, "destination_id", "destination_name", "tbl_destination", "status = 1", "destination_name asc", ""); ?>
													</select>                                                     
												</div>
											</div>	
											
                                            <div class="col-md-6"> 
												<div class="form-group mt30">
													<input type="checkbox" name="show_in_home" id="show_in_home" value="1" <?php if($show_in_home == 1) { ?> checked = "checked" <?php } ?> >        
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
														<?php 
															$max_noof_days = $this->Common_model->showname_fromid("max(no_ofdays)", "tbl_package_duration", "");
															$max_noof_nights = $this->Common_model->showname_fromid("max(no_ofnights)", "tbl_package_duration", "");
															
															$get_destinations = $this->Common_model->get_records("*","tbl_itinerary_destination","itinerary_id='$itinerary_id'","itinerary_destinationid asc");
		
															if(!empty($get_destinations)) {
																$i=0;
																foreach ($get_destinations as $rowss1) {							
																	$destination_id = $rowss1['destination_id'];
																	$noof_days = $rowss1['noof_days'];
																	$noof_nights = $rowss1['noof_nights'];
														?>
														<tr>					
															<td>																
																<select class="form-control"  id="destination_id"  name="destination_id[]" >
																	<option value="">-- Select destination --</option>
																   <?php  echo $this->Common_model->populate_select($dispid = $destination_id, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
																</select>
															</td>                                                             

															<td>
																<select class="form-control" name="no_ofdays[]" id="no_ofdays">
																	<option value=''>-- Select Days --</option>
																	<?php  echo $this->Common_model->generate_numberbox(0, $max_noof_days, $noof_days); ?>
															   </select>    
															</td>

															<td>
																<select class="form-control" name="no_ofnight[]" id="no_ofnight">
																	<option value=''>-- Select Nights --</option>
																	<?php  echo $this->Common_model->generate_numberbox(0, $max_noof_nights, $noof_nights); ?>
																</select> 
															</td>
                                                            
															<td>
																<a href="javascript:void(0);" class="btn btn-success btn-sm views addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
																<a href="javascript:void(0);" class="btn btn-danger btn-sm views delrowbtn" title="Delete" name="del[]" id="del_<?php echo $i; ?>"><i class="fa fa-trash-o"></i></a>
															</td>

                                                        </tr>  
                                                        <?php $i++; } } ?>         
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
														<textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"><?php echo set_value('meta_title',$meta_title); ?></textarea>
													</div>
													</div>
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Keywords</label>
														<textarea name="meta_keywords" id="meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"><?php echo set_value('meta_keywords',$meta_keywords); ?></textarea>
													</div>
													</div>
													
													<div class="clearfix"></div>
													
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Description</label>
														  <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo set_value('meta_description',$meta_description); ?></textarea>
													</div>
													</div>
                                                <div class="clearfix"></div>
                                            </div> 
                                        </div>		
								
      
                                    <div class="clearfix"></div>
                                    <div class="col-md-6">
										<div class="reset-button"> 
											<button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
											<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/itinerary'">Back</button> 
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
			/*$(document.body).on('keyup change', '#itinerary_name', function() {
				$("#itinerary_url").val(name_to_url($(this).val()));
			});
			function name_to_url(name) {
				name = name.toLowerCase(); // lowercase
				name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
				name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
				name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
				return name;
			}*/
		</script> 
			
		<script>
			$(document).ready(function(){
				$('#getplacetypeid').chosen();
				$('#getatagid').chosen();						
			
				//for place type
				var place_params = "<?php echo $get_plctype_array ?>";
				if(place_params != '') {	
					var rstr = place_params.replace(/,\s*$/, ""); //remove last comma from string
					var place_array_data = rstr.split(",");
					$.each(place_array_data, function (index, val) {
						$("#getplacetypeid option[value=" + val + "]").attr('selected', 'selected');
					});
					$('#getplacetypeid').trigger('chosen:updated');
				}
				
				//for tag type
				var tag_params = "<?php echo $get_tag_array ?>";
				if(tag_params != '') {	
					var rstr = tag_params.replace(/,\s*$/, ""); //remove last comma from string
					var tag_array_data = rstr.split(",");
					$.each(tag_array_data, function (index, val) {
						$("#getatagid option[value=" + val + "]").attr('selected', 'selected');
					});
					$('#getatagid').trigger('chosen:updated');
				}
			});
		</script>

		<script>   
			$(document).on('change', '.drtn', function(){       
				var val = $(this).val();
				//alert(val);
				if(val != 0)
				{
					$.ajax({
						url:"<?php echo base_url();?>/admin/itinerary/editdaywise/"+val+"/"+<?php echo $itinerary_id; ?>,
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
		
		<script>   
			$(document).ready(function(){       
				var val = <?php echo $iti_duration; ?>;
				//alert(val);
				if(val != 0)
				{
					$.ajax({
						url:"<?php echo base_url();?>/admin/itinerary/editdaywise/"+val+"/"+<?php echo $itinerary_id; ?>,
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

