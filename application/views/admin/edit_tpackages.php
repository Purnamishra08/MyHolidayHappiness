<?php
//$newpakdurations = $pakdurations ;
if (!empty($edittourpackages)) {
    foreach ($edittourpackages as $rowss1) {
        $tourpackageid = $rowss1['tourpackageid'];
        $tpackage_name = $rowss1['tpackage_name'];
        $tpackage_url = $rowss1['tpackage_url'];
        $tpackage_code = $rowss1['tpackage_code'];
        $pmargin_perctage = $rowss1['pmargin_perctage'];
        $package_image = $rowss1['tpackage_image'];
        $tour_thumb = $rowss1['tour_thumb'];
        $alttag_banner = $rowss1['alttag_banner'];
        $alttag_thumb = $rowss1['alttag_thumb'];
        $package_duration = $rowss1['package_duration'];
        $accomodation = $rowss1['accomodation'];
        $price = $rowss1['price'];
        $fakeprice = $rowss1['fakeprice'];
        $tourtransport = $rowss1['tourtransport'];
        $sightseeing = $rowss1['sightseeing'];
        $breakfast = $rowss1['breakfast'];
		$waterbottle = $rowss1['waterbottle'];
        $ratings = $rowss1['ratings'];
        $inclusion_exclusion = $rowss1['inclusion_exclusion'];
		$itinerary_note = $rowss1['itinerary_note'];
        $meta_title = $rowss1['meta_title'];
        $meta_keywords = $rowss1['meta_keywords'];
        $meta_description = $rowss1['meta_description'];
        $status = $rowss1['status'];
        $pack_type = $rowss1['pack_type'];
        $itinerary = $rowss1['itinerary'];
		$starting_city = $rowss1['starting_city'];
		
		$show_video_itinerary = $rowss1['show_video_itinerary'];
		$video_itinerary_link = $rowss1['video_itinerary_link'];
    }
}

//for getaways tags
$getTourTagIds = $this->Common_model->get_records("tagid", "tbl_tags", "type_id='$tourpackageid' and type = 3", "");
$get_tag_array = '';
if (!empty($getTourTagIds)) {
	foreach ($getTourTagIds as $getTourTagId) {
		$get_tag_array .= $getTourTagId['tagid'] . ', ';
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
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="header-title">
                        <h1>Tour Packages</h1>
                        <small>Add Tour Package</small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/tour-packages">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Tour Package</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">

                                    <?php echo $message; ?>
                                    <?php echo form_open('', array('id' => 'form_edit_tpackages', 'name' => 'form_edit_tpackages', 'class' => 'add-user', 'enctype' => 'multipart/form-data')); ?>
                                    <div class="box-main">
                                        <h3>Package Details</h3>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Package Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter package name" name="tpackage_name" id="tpackage_name" value="<?php echo set_value('tpackage_name', $tpackage_name); ?>">
                                                </div>   

                                            </div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Package Url</label>
                                                    <input type="text" class="form-control" placeholder="Enter tour package url" name="tpackage_url" id="tpackage_url" value="<?php echo set_value('tpackage_url', $tpackage_url); ?>">
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>  

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Package Code</label>
                                                    <input type="text" class="form-control" placeholder="Enter tour package code" name="tpackage_code" id="tpackage_code" value="<?php echo set_value('tpackage_code', $tpackage_code); ?>">
                                                </div>
                                            </div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Package Duration</label>
                                                    <select class="form-control" name="pduration" id="pduration">
                                                        <option value=''>-- Select Duration --</option>
                                                        <?php echo $this->Common_model->populate_select($dispid = $package_duration, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
                                                    </select>                                                     
                                                </div>
                                            </div>	

                                            <div class="clearfix"></div> 
                                            
                                             <div class="col-md-6"> 
												<div class="form-group">
													<label> Price (<?php echo $this->Common_model->currency; ?>) </label>
													<input type="text" class="form-control" placeholder="Enter price for package" name="price" id="price" value="<?php echo set_value('price',$price); ?>">
												</div>
                                            </div>
                                                
											<div class="col-md-6"> 
												<div class="form-group">
													<label> Fake Price (<?php echo $this->Common_model->currency; ?>) </label>
													<input type="text" class="form-control" placeholder="Enter fake price for package " name="fakeprice" id="fakeprice" value="<?php echo set_value('fakeprice',$fakeprice); ?>">
												</div>
											</div>

                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Profit Margin Percentage (%) </label>
                                                    <input type="text" class="form-control" placeholder="Enter profit margin percentage" name="pmargin_perctage" id="pmargin_perctage" value="<?php echo set_value('pmargin_perctage', $pmargin_perctage); ?>">
                                                </div>
                                            </div>
											
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Package ratings</label>
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
                                                <div class="form-group">
                                                    <label  for="accomodation">  Tour Availability </label>
                                                    <div class="row">															
                                                        <div class="col-md-12"> 
                                                            <input type="checkbox" name="accomodation" id="accomodation" value="1" <?php if ($accomodation == 1) { ?> checked="checked" <?php } ?> > Accomodation &nbsp;				
                                                            <input type="checkbox" name="tourtransport" id="tourtransport" value="1" <?php if ($tourtransport == 1) { ?> checked="checked" <?php } ?>> Transportation &nbsp;	  
                                                            <input type="checkbox" name="sightseeing" id="sightseeing" value="1" <?php if ($sightseeing == 1) { ?> checked="checked" <?php } ?>> Sightseeing &nbsp;	
                                                            <input type="checkbox" name="breakfast" id="breakfast" value="1" <?php if ($breakfast == 1) { ?> checked="checked" <?php } ?>> Breakfast &nbsp;	
															<input type="checkbox" name="waterbottle" id="waterbottle" value="1" <?php if ($waterbottle == 1) { ?> checked="checked" <?php } ?>> Water Bottle
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tour_avai_err">  </div>
                                            </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Tour Tags </label>
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
                                                <div id="gettourtag_err">  </div>
                                            </div>

                                            <div class="clearfix"></div> 
                                            <div class="col-md-6">                                                
                                              <label> Banner Image</label>
                                                    <div class="form-group">
                                                    
                                                    <?php
													if (file_exists("./uploads/" . $package_image) && ($package_image != '')) {
														echo '<a href="' . base_url() . 'uploads/' . $package_image . '" target="_blank"><img src="' . base_url() . 'uploads/' . $package_image . '" style="width:86px;height:59px" alt="image" /></a>';
													}
													?>
                                                    <input type="file" name="tourimo" id="tourimo">
                                                    <span>Image size should be 745px X 450px </span>
                                                </div>
                                                <div id="placeimo_err">  </div>
                                            </div> 


                                            <div class="col-md-6">                                                 
												<label> Tour Image</label>
                                                <div class="form-group">                                                    
                                                    <?php
													if (file_exists("./uploads/" . $tour_thumb) && ($tour_thumb != '')) {
														echo '<a href="' . base_url() . 'uploads/' . $tour_thumb . '" target="_blank"><img src="' . base_url() . 'uploads/' . $tour_thumb . '" style="width:86px;height:59px" alt="image" /></a>';
													}
													?>                                                
                                                    <input type="file" name="tourthumb" id="tourthumb">
                                                    <span>Image size should be 300px X 225px </span>
                                                </div>
                                                <div id="placeimo_err"></div>
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
                                                    <label> Alt Tag For Tour Image</label>
                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for tour image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb', $alttag_thumb); ?>" maxlength="60">
                                                </div>
                                            </div>
                                            <div class="clearfix"></div> 

											<div class="col-md-6"> 
												<div class="form-group">
                                                    <label> Package Type</label>
                                                    <select class="form-control" name="packtype" id="packtype">
                                                        <option value=''>-- Select Package Type --</option>
                                                        <?php  echo $this->Common_model->populate_select($dispid = $pack_type, "parid", "par_value", "tbl_parameters", "param_type = 'PT'", "par_value asc", ""); ?>
                                                    </select>                                                     
												</div>
											</div>
                                           
											<div class="col-md-6"> 
											   <div class="form-group">
													<label>Choose Itinerary</label>
													<select class="form-control" name="itinerary" id="itinerary">
														<option value=''>-- Select Itinerary --</option>
														 <?php  echo $this->Common_model->populate_select($dispid = $itinerary, "itinerary_id", "itinerary_name", "tbl_itinerary", "status = 1", "itinerary_name asc", ""); ?>
													</select>   
												</div>
											</div>   
                                                
                                           <div class="clearfix"></div>
                                            <div class="col-md-2"> 
                                                    <div class="form-group">
														<input type="checkbox" name="show_video_itinerary" id="show_video_itinerary" <?php if ($show_video_itinerary == 1) { ?> checked="checked" <?php } ?>> Show Video Itinerary                                                    
                                                    </div>
                                                </div>
                                                 <div class="col-md-10"> 
                                                    <div class="form-group">
                                                        <label> Video Itinerary Link</label>
														<input type="text" name="video_itinerary_link" id="video_itinerary_link" value="<?php echo $video_itinerary_link; ?>" placeholder="https://www.youtube.com/embed/XXXXXXXXXX" class="form-control">                                                   
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
											
											<div class="clearfix"></div>
												
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label> Inclusion / Exclusion	</label>
                                                    <textarea name="inclusion" id="inclusion" class="form-control "><?php echo $inclusion_exclusion; ?></textarea>
                                                </div>
                                                <div id="inclusion_err"></div>
                                            </div>                                              
                                            <div class="clearfix"></div> 

											<div class="col-md-12">
												<div class="form-group">
													<label> Itinerary Note</label>
													<textarea name="itinerary_note" id="itinerary_note" class="form-control"><?php echo $itinerary_note; ?></textarea>
												</div>
											</div>
											<div class="clearfix"></div> 

                                        </div>
                                    </div>
									
									<div class="clearfix"></div>
									
									<div class="box-main">
										<h3>Accomodation</h3>
										<div class="row">                                                
											<div class="col-md-8">                                                 
												<table id="addRowTable" class="table table-bordered table-striped table-hover">
													<thead>
														<tr class="info">
															<th width="50%">Destination name</th>
															<th width="40%">No of Nights Booking in Hotel</th>
															<th width="10%"></th>
														</tr>
													</thead>
													<tbody>  
														<?php 
															$max_noof_days = $this->Common_model->showname_fromid("max(no_ofdays)", "tbl_package_duration", "");
															$max_noof_nights = $this->Common_model->showname_fromid("max(no_ofnights)", "tbl_package_duration", "");
															
															$get_destinations = $this->Common_model->get_records("*","tbl_package_accomodation","package_id='$tourpackageid'","acc_id asc");
		
															if(!empty($get_destinations)) {
																$i=0;
																foreach ($get_destinations as $rowss1) {							
																	$destination_id = $rowss1['destination_id'];
																	$noof_days = $rowss1['noof_days'];
														?>
														<tr>
															<td>						
																<select class="form-control" id="destination_id"  name="destination_id[]" >
																	<option value="">-- Select destination --</option>
																	<?php  echo $this->Common_model->populate_select($dispid = $destination_id, "destination_id", "destination_name", "tbl_destination", "destination_id in (select distinct(destination_name) from tbl_hotel where status=1)", "destination_name asc", ""); ?>
																</select> 
																<div id="seasontype_err">  </div>
															</td>      
															
															<?php $max_noof_days = $this->Common_model->showname_fromid("max(no_ofdays)", "tbl_package_duration", ""); ?>
															<td>
																<select class="form-control" name="no_ofdays[]" id="no_ofdays">
																	<option value=''>-- Select No of Nights --</option>
																	<?php  echo $this->Common_model->generate_numberbox(0, $max_noof_days,$noof_days); ?>
																</select>    
															</td>
																
															<td>
																<a href="javascript:void(0);" class="btn btn-success btn-sm views addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
																<a href="javascript:void(0);" class="btn btn-danger btn-sm views delrowbtn" title="Delete" name="del[]" id="del_<?php echo $i; ?>"><i class="fa fa-trash-o"></i></a>  
															</td>
														</tr>  
														<?php $i++; } } else { ?>
														<tr>
															<td>						
																<select class="form-control" id="destination_id"  name="destination_id[]" >
																	<option value="">-- Select destination --</option>
																	<?php  echo $this->Common_model->populate_select($dispid = 0, "destination_id", "destination_name", "tbl_destination", "destination_id in (select distinct(destination_name) from tbl_hotel where status=1)", "destination_name asc", ""); ?>
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
																
															<td>
																<a href="javascript:void(0);" class="btn btn-success btn-sm views addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
																<a href="javascript:void(0);" class="btn btn-danger btn-sm views delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa fa-trash-o"></i></a>  
															</td>
														</tr>     
														<?php } ?>
													</tbody>
												</table>
											</div>
											<div class="clearfix"></div>
										</div>
									</div> 
									
									<div class="clearfix"></div>

                                    <div class="box-main">
											<h3>Meta Tags</h3>
												<div class="row">  
													<div class="col-md-6"> 
													<div class="form-group">
														<label>Meta Title</label>
														 <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"><?php echo $meta_title ;?></textarea>
													</div>
													</div>
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Keywords</label>
														 <textarea name="meta_keywords" id="meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"><?php echo $meta_keywords ;?></textarea>
													</div>
													</div>
													
													<div class="clearfix"></div>
													
													
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Description</label>
														  <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"> <?php echo $meta_description ; ?></textarea>
													</div>
													</div>
													
													
                                                <div class="clearfix"></div>
                                            </div> 
                                   
                                    </div>								
                                    <div class="clearfix"></div>  
                                    <div class="col-md-6">
                                        <div class="reset-button"> 
                                            <button type="submit" class="btn redbtn" name="btnSubmitPlace" id="btnSubmitPlace">Save</button>
											<button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/tour-packages'">Back</button> 
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
            <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js?v=1.0"></script>
            <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>

            <script type="text/javascript">
                CKEDITOR.replace('inclusion');
				CKEDITOR.replace('itinerary_note'); 

                $(document).ready(function () {
                    $('#getatagid').chosen();
                });

                $(document).ready(function () {
                    //for tag type
                    var tag_params = "<?php echo $get_tag_array ?>";
                    var rstr = tag_params.replace(/,\s*$/, ""); //remove last comma from string
                    var tag_array_data = rstr.split(",");
                    $.each(tag_array_data, function (index, val) {
                        $("#getatagid option[value=" + val + "]").attr('selected', 'selected');
                    });
                    $('#getatagid').trigger('chosen:updated');
                });
            </script>
    </body>
</html>




