<?php
	foreach ($editplace as $rows)
	{
	$placeid = $rows['placeid'];
    $destination_id = $rows['destination_id'];
	$place_name = $rows['place_name'];
	$place_url = $rows['place_url'];
	$latitude  = $rows['latitude'];
	$longitude = $rows['longitude'];
	$trip_duration = $rows['trip_duration'];
	$distance_from_nearest_city = $rows['distance_from_nearest_city'];
	$placeimg = $rows['placeimg'];
	$placethumbimg = $rows['placethumbimg'];
    $alttag_banner = $rows['alttag_banner'];
    $alttag_thumb = $rows['alttag_thumb'];
	$google_map = $rows['google_map'];
	$travel_tips = $rows['travel_tips'];
	$about_place = $rows['about_place'];
	$status = $rows['status'];
	 $entry_fee = $rows['entry_fee'];
	 $timing = $rows['timing'];
	$rating = $rows['rating'];
	$meta_title = $rows['meta_title'];
	$meta_keywords = $rows['meta_keywords'];
	$meta_description = $rows['meta_description'];
	
	
	  $pckg_meta_title        = $rows['pckg_meta_title'];
    $pckg_meta_keywords     = $rows['pckg_meta_keywords'];
    $pckg_meta_description  = $rows['pckg_meta_description'];
    
    
	$status = $rows['status'];		
	}
	
	//for place types
		
	$getplacetypeids = $this->Common_model->get_records("loc_type_id","tbl_multdest_type","loc_id='$placeid' and loc_type = 2","");
	$typeisarray = '';
	if(!empty($getplacetypeids)){
		foreach($getplacetypeids as $getplacetypeid){
			$typeisarray .= $getplacetypeid['loc_type_id'].', ';
		}
	}

	//for getaways tags
	$getplacetagids = $this->Common_model->get_records("tagid","tbl_tags","type_id='$placeid' and type= 2","");
	$get_tag_array = '';
	if(!empty($getplacetagids)){
		foreach($getplacetagids as $getplacetagid){
			$get_tag_array .= $getplacetagid['tagid'].', ';
		}
	}

	//for transport 
	$getplace_transids = $this->Common_model->get_records("transport_id","tbl_place_transport","place_id='$placeid'","");
	$get_transport_array = '';
	if(!empty($getplace_transids)){
		foreach($getplace_transids as $getplace_transid){
			$get_transport_array .= $getplace_transid['transport_id'].', ';
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
                        <i class="fa fa-bookmark"></i>
                    </div>
                    <div class="header-title">
                        <h1>Places</h1>
                        <small>Edit Place</small>
                    </div>
                </section>
                <!-- Main content --> 
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/places">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Places</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $message; ?>
                                    <?php echo form_open('', array( 'id' => 'form_editplaces', 'name' => 'form_editplaces', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                        <div class="box-main">
                                            <h3>Place Details</h3>
                                            <div class="row">
												
											    <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Place Name</label>
                                                         <input type="text" class="form-control" placeholder="Enter place Name" name="place_name" id="place_name" value="<?php echo set_value('place_name',$place_name); ?>">
                                                </div> 
                                                </div>	
												
												<div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Place Url</label>
                                                    <input type="text" class="form-control" placeholder="Enter place url" name="place_url" id="place_url" value="<?php echo set_value('place_url',$place_url); ?>">
                                                    </div>
                                                </div>
												
												<div class="clearfix"></div>  
												
												<div class="col-md-6"> 
                                                <div class="form-group"> 
                                                    <label>Destination </label>                                                  
                                                        <select class="form-control"  id="destination_id"  name="destination_id" >
                                                             <option value="">-- Select destination --</option>
                                                           <?php  echo $this->Common_model->populate_select($dispid = $destination_id, "destination_id", "destination_name", "tbl_destination", "", "destination_name asc", ""); ?>
                                                        </select> 
													<input type="hidden" name="placeid"  value="<?php echo $placeid; ?>" >
                                                 <div id="placedestin_err">  </div>
                                                </div>
                                                </div>
												
												<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Place Type</label>
                                                    <?php   
                                                          $get_desti = $this->Common_model->get_records("destination_type_id, destination_type_name", "tbl_destination_type", "status = '1'", "destination_type_name asc", "");
                                                        ?>

                                                    <select data-placeholder="Choose place Type" class="chosen-select efilter" multiple tabindex="4" id="place_type"  name="place_type[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_desti as $get_destis) { ?>
                                                            <option value="<?= $get_destis['destination_type_id'] ?>" ><?= $get_destis['destination_type_name'] ?></option>
                                                            <?php } ?>
                                                    </select> 

                                                </div>
                                                </div>
                                               
                                                <div class="clearfix"></div> 
												
                                                <div class="col-md-6"> 
													<?php
														if(file_exists("./uploads/".$placeimg) && ($placeimg!=''))
														{ 
															echo '<a href="'.base_url().'uploads/'.$placeimg.'" target="_blank"><img src="'.base_url().'uploads/'.$placeimg.'" style="width:86px;height:59px" alt="image" /></a>';
													    }
													?>
													
                                                   <div class="form-group">
                                                        <label> Banner Image</label>
                                                        <input type="file"   name="placeimg" id="placeimg">
                                                        <span>Image size should be 1140px X 350px </span>
                                                    </div>
                                                </div> 
                                                
                                                 <div class="col-md-6"> 
													<?php
														if(file_exists("./uploads/".$placethumbimg) && ($placethumbimg!=''))
														{ 
															echo '<a href="'.base_url().'uploads/'.$placethumbimg.'" target="_blank"><img src="'.base_url().'uploads/'.$placethumbimg.'" style="width:86px;height:59px" alt="image" /></a>';
													    }
													?>													
                                                   <div class="form-group">
                                                        <label> Place Image</label>
                                                        <input type="file"   name="placethumbimg" id="placethumbimg">
                                                      <span>Image size should be 500px X 300px </span>
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
                                                        <label> Alt Tag For Place Image</label>
                                                        <input type="text" class="form-control" placeholder="Enter Alt tag for place image" name="alttag_thumb" id="alttag_thumb" value="<?php echo set_value('alttag_thumb', $alttag_thumb); ?>" maxlength="60">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div> 
											   
											   <div class="col-md-6"> 
													<div class="form-group">
														<label>Latitude</label>
														<input type="text" class="form-control" placeholder="Place Latitude" name="latitude" id="latitude" value="<?php echo set_value('latitude', $latitude); ?>" >
													</div>
												</div>
											  
												<div class="col-md-6"> 
													<div class="form-group">
														<label>Longitude</label>
														<input type="text" class="form-control" placeholder="Place Longitude" name="longitude" id="longitude" value="<?php echo set_value('longitude', $longitude); ?>" >
													</div>
												</div>
												
												<div class="clearfix"></div> 
												
												<div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>To Find Latitude and Longitude Click <a href="http://www.latlong.net" target="_blank" style="color:#18c4c0">http://www.latlong.net</a></label>
													</div>
												</div>
                                            
												<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>  Getaway Tags </label>
                                                    <?php   
                                                             $get_getawaytags = $this->Common_model->get_records("tagid, tag_name", "tbl_menutags", "status = '1' and menuid = '1'", "tag_name asc", "");
                                                        ?>

                                                    <select data-placeholder="Choose getaway tags" class="chosen-select" multiple tabindex="4" id="getatagid"  name="getatagid[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_getawaytags as $get_getawaytag) { ?>
                                                            <option value="<?= $get_getawaytag['tagid'] ?>"><?= $get_getawaytag['tag_name'] ?></option>
                                                            <?php } ?>
                                                    </select> 

                                                </div>
                                                </div>
                                               
                                                <div class="clearfix"></div>                                               
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>About Place</label>														 
                                                        <textarea name="short_desc" id="short_desc" class="form-control "><?php echo $about_place; ?></textarea>
                                                        <div id="aboutplace_err"></div>
                                                    </div>
                                                </div>                                                
                                                <div class="clearfix"></div>  
                                                
                                            </div>
                                        </div>
                                        <div class="box-main">
                                            <h3>Common Information</h3>
                                            <div class="row">                                                  
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label> Trip duration (including travel in hours)</label>
                                                        <input type="text" class="form-control" placeholder="2-3 Hours" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration',$trip_duration); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label> Transportation Options</label>

                                                    <?php   
                                                          $get_vehicles = $this->Common_model->get_records("vehicleid, vehicle_name", "tbl_vehicletypes", "status = '1'", "vehicle_name asc", "");
                                                        ?>
                                                     <select data-placeholder="Choose transport" class="chosen-select" multiple tabindex="4" id="transport"  name="transport[]"
                                                         style="width: 100%;height: auto;border: 1px solid #aaa;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));background-image: linear-gradient(#eee 1%, #fff 15%);cursor: text; font-size:13px; padding:5px 7px;">
                                                            <?php foreach ($get_vehicles as $get_vehicle) { ?>
                                                            <option value="<?= $get_vehicle['vehicleid'] ?>"><?= $get_vehicle['vehicle_name'] ?></option>
                                                            <?php } ?>
                                                    </select> 
                                                    
                                                </div>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
														<label> Travel Tips </label>
														<textarea cols="" rows="" placeholder="travel tips..." class="form-control textarea1" name="travel_tips" id="travel_tips" > <?php echo set_value('travel_tips',$travel_tips); ?> </textarea>
													</div>
                                                </div>
												
												<div class="col-md-6"> 
													<div class="form-group">
														<label> Distance from near by city </label>
														 <input type="text" class="form-control" placeholder="Ex-From Mysore Junction : 2.5 Kms" name="distance_from_nearest_city" id="distance_from_nearest_city" value="<?php echo set_value('distance_from_nearest_city',$distance_from_nearest_city); ?>">
													</div>
                                                </div> 												
                                                
                                                <div class="clearfix"></div> 

                                                <div class="col-md-6"> 
                                                    <div class="form-group">
														<label> Google Map </label>
														<textarea cols="" rows="" placeholder="Google map..." class="form-control textarea1" name="google_map" id="google_map"><?php echo set_value('google_map',$google_map); ?></textarea>
													</div>
                                                </div>  
												
												<div class="col-md-6"> 
                                                    <div class="form-group">
														<label> Google Map Example </label><br>
														&lt;iframe src="https://www.google.com/maps/d/embed?mid=19xHbU7LdnDtVsj_gR5u6EpnQ4OM&hl=en" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen&gt; &lt;/iframe&gt;
													</div>
                                                </div> 

                                                <div class="clearfix"></div> 
                                            </div>
                                        </div> 
                                        <div class="box-main">

                                            <h3>Other Information</h3>

                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Entry Fee (In <?php echo $this->Common_model->currency; ?>)</label>
                                                         <input type="text" class="form-control" placeholder="Entry Fee " name="entry_fee" id="entry_fee" value="<?php echo set_value('entry_fee',$entry_fee); ?>">
                                                </div>   
                                                   
                                                </div>
                                             <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Timing </label>
                                                    <input type="text" class="form-control" placeholder="Timing " name="timing" id="timing" value="<?php echo set_value('timing',$timing); ?>">
                                                    </div>
                                                </div>
                                             <div class="clearfix"></div>                                                

                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Rating </label>                                                    
                                                    <select class="form-control" name="rating" id="rating" >
                                                    <option value="0" >-- Select Rating --</option>
                                                    <option value="1" <?php echo ($rating == '1') ? 'selected="selected"' :''; ?> >1</option>
                                                    <option value="1.5" <?php echo ($rating == '1.5') ? 'selected="selected"' :''; ?>>1.5</option>
                                                    <option value="2" <?php echo ($rating == '2') ? 'selected="selected"' :''; ?>>2</option>
                                                    <option value="2.5" <?php echo ($rating == '2.5') ? 'selected="selected"' :''; ?>>2.5</option>
                                                    <option value="3" <?php echo ($rating == '3') ? 'selected="selected"' :''; ?>>3</option>
                                                    <option value="3.5" <?php echo ($rating == '3.5') ? 'selected="selected"' :''; ?>>3.5</option>
                                                    <option value="4" <?php echo ($rating == '4') ? 'selected="selected"' :''; ?>>4</option>
                                                    <option value="4.5" <?php echo ($rating == '4.5') ? 'selected="selected"' :''; ?>>4.5</option>
                                                    <option value="5" <?php echo ($rating == '5') ? 'selected="selected"' :''; ?>>5</option>
                                                </select>
                                                </div>
                                                </div>

                                        </div> 
                                        <div class="box-main">

                                            
										   
											 <h3>Place Meta Tags</h3>
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
                                         <div class="box-main">

                                            
										   
											 <h3>Package Meta Tags</h3>
												<div class="row">  
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Title</label>
															<textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="pckg_meta_title" id="pckg_meta_title"><?php echo set_value('pckg_meta_title',$pckg_meta_title); ?></textarea>
														</div>
													</div>
													<div class="col-md-6"> 
														<div class="form-group">
															<label>Meta Keywords</label>
															<textarea name="pckg_meta_keywords" id="pckg_meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"><?php echo set_value('pckg_meta_keywords',$pckg_meta_keywords); ?></textarea>
														</div>
													</div>
													
													<div class="clearfix"></div>
													
													<div class="col-md-6"> 
														<div class="form-group">
														<label>Meta Description</label>
														  <textarea name="pckg_meta_description" id="pckg_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo set_value('pckg_meta_description',$pckg_meta_description); ?></textarea>
													</div>
													</div>
                                                <div class="clearfix"></div>
                                            </div> 
										   
										   
										    
                                        </div>
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnEditPlace" id="btnEditPlace">Update</button>
                                        		  <button type="button" class="btn blackbtn" onClick="window.location='<?php echo base_url(); ?>admin/places'">back</button> 
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
			 <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
   

    

    <script type="text/javascript">
	CKEDITOR.replace('short_desc');
	$(document).ready(function(){
		$('#edesti').chosen();    
		$('#transport').chosen(); 
		$('#place_type').chosen();
		$('#getatagid').chosen();
		$("#edesti").change(function () {
			var menu = $(this);
		});
	});		
		
   $(document).ready(function () {   
	   //for place type     
		 var type_params = "<?php echo $typeisarray ?>"; 
		  if(type_params != ''){	
			 var rstr = type_params.replace(/,\s*$/, ""); //remove last comma from string
			 var type_array_data = rstr.split(",");
			 $.each(type_array_data, function (index, val) {
				 $("#place_type option[value=" + val + "]").attr('selected', 'selected');
			 });
			 $('#place_type').trigger('chosen:updated');
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
	 
	 
	  //for transport type
		 var transport_params = "<?php echo $get_transport_array ?>"; 
		 if(transport_params != '') {	
			 var rstr = transport_params.replace(/,\s*$/, ""); 
			 var transport_array_data = rstr.split(",");
			 $.each(transport_array_data, function (index, val) {
				 $("#transport option[value=" + val + "]").attr('selected', 'selected');
			 });
			 $('#transport').trigger('chosen:updated');
	    }
    });
    
    
		
		
		
        </script>

    </body>
</html>

