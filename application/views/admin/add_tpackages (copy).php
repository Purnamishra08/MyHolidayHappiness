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
                                        <a href="<?php echo base_url(); ?>admin/places">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Tour Package</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                   <?php echo $messageadd; ?>
                                    <?php echo form_open('', array( 'id' => 'form_places', 'name' => 'form_places', 'class' => 'add-user', 'enctype' => 'multipart/form-data'));?>
                                        <div class="box-main">
                                            <h3>Package Details</h3>
                                            <div class="row">
												
											    <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Package Name</label>
                                                         <input type="text" class="form-control" placeholder="Enter package name" name="tpackage_name" id="tpackage_name" value="<?php echo set_value('tpackage_name'); ?>">
                                                </div>   
                                                   
                                                </div>
												
												
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Package Url</label>
                                                    <input type="text" class="form-control" placeholder="Enter tour package url" name="tpackage_url" id="tpackage_url" value="<?php echo set_value('tpackage_url'); ?>">
                                                    </div>
                                                </div>
												
												
												<div class="clearfix"></div>  
																								
												<div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Package Code</label>
                                                    <input type="text" class="form-control" placeholder="Enter tour package code" name="tpackage_code" id="tpackage_code" value="<?php echo set_value('tpackage_code'); ?>">
                                                    </div>
                                                </div>
																								
												<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>  Tour Tags </label>
                                                    <?php   
                                                             $get_getawaytags = $this->Common_model->get_records("tagid, tag_name", "tbl_menutags", "status = '1' and menuid = '2'", "tag_name asc", "");
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
                                                    <div class="form-group">
                                                    <label>No of Days</label>
                                                    <input type="text" class="form-control" placeholder="Enter no. of days" name="noof_days" id="noof_days" value="<?php echo set_value('noof_days'); ?>">
                                                    </div>
                                                </div>
												
												
												
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
                                                        <label> No of Nights</label>
                                                         <input type="text" class="form-control" placeholder="Enter no. of nights" name="noof_night" id="noof_night" value="<?php echo set_value('noof_night'); ?>">                                                      
                                                    </div>
													<div id="placeimo_err">  </div>
                                                </div> 
												
                                                <div class="clearfix"></div>  
												
											    <div class="col-md-6"> 
                                                   <div class="form-group">
                                                        <label> Tour Image</label>
                                                        <input type="file"   name="placeimg" id="placeimg" value="<?php echo set_value('placeimg'); ?>">
                                                        <span>Image size should be 880px X 450px </span>
                                                    </div>
													<div id="placeimo_err">  </div>
                                                </div>
												
												 <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label> Profit Margin Percentage </label>
                                                        <input type="text" class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>">
                                                    </div>
                                                </div>
												
											    <div class="clearfix"></div>  
												
                                                <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label>About Tour package</label>
                                                        <textarea name="short_desc" id="short_desc" class="form-control "><?php echo set_value("short_desc"); ?></textarea>
                                                        <div id="abouttpackage_err"></div>
                                                    </div>
                                                </div>                                                
                                                <div class="clearfix"></div>  
                                                
                                            </div>
                                        </div>
									
										<div class="box-main">
                                            <h3>Destination Information</h3>
                                            <div class="row"> 
												 <div class="col-md-12 dest-title">  Start From Destination  </div>                                      
                                                <div class="col-md-6"> 
                                                   <div class="form-group">
                                                      <div class="col-md-6">    <label>Destination Name: </label>  </div>
                                                        <div class="col-md-6">  
                                                          <input type="text" class="form-control" placeholder="Enter destination name" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-md-6">    <label>No. of Days: </label>  </div>
                                                        <div class="col-md-6">    <input type="text" class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>"> 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-md-6"> <label>No. of Night:</label>  </div>
                                                        <div class="col-md-6"> <input type="text" class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>"> 
                                                        </div>
                                                    </div>
                                                </div>     
                                                
                                                <div class="clearfix"></div>   
                                                <div class="col-md-12 dest-title">  Associated destinations: </div>

												<div class="col-md-12">

                                                <div class="col-md-9 new-associated">
                                                    <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label> Destination Name </label> <input type="text" class="form-control" placeholder="Enter destination name" name="destination_name" id="destination_name" value="<?php echo set_value('destination_name'); ?>"> 
                                                    </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                    <div class="form-group">
    													<label> No. of Days: </label> <input type="text" class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>"> 
    												</div>
                                                    </div>

                                                    <div class="col-md-2">
                                                    <div class="form-group">
    												    <label> No. of Night: </label> <input type="text" class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>"> 
                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="margin-left: -26px;">
                                                    <a href="javascript:;" onclick="return dltSingleVocabularyword('<?php// echo $related_familie['family_id'] ?>', '<?php //echo $related_familie['word_id'] ?>');" title="Delete"> <i class="fa fa-fw fa-trash" style="color: #1b4266;"></i></a>
                                                </div>

                                                <a href="javascript:void(0);" class="btn btn-success btn-sm view addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm view delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa fa-trash-o"></i></a>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-sm btn-primary pull-right add-new">+</button>
                                                    </div>
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
                                                        <input type="text" class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="<?php echo set_value('trip_duration'); ?>">
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
													<div id="transport_err"></div>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label> Travel Tips </label>
                                                    <textarea cols="" rows="" placeholder="travel tips..." class="form-control textarea1" name="travel_tips" id="travel_tips"></textarea>
                                                </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label> Google Map </label>
                                                     <textarea cols="" rows="" placeholder="Google map..." class="form-control textarea1" name="google_map" id="google_map"></textarea>
                                                </div>
                                                </div>  
                                                <div class="clearfix"></div> 

                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Distance from near by city </label>
                                                     <input type="text" class="form-control" placeholder="Ex-From Mysore Junction : 2.5 Kms" name="distance_from_nearest_city" id="distance_from_nearest_city" value="<?php echo set_value('distance_from_nearest_city'); ?>">
                                                </div>
                                                </div>  

                                                <div class="clearfix"></div> 
                                            </div>
                                        </div> 
                                        <div class="box-main">

                                            <h3>Other Information</h3>
                                            

                                             <div class="col-md-6">
                                                <div class="form-group">
                                                      <label>Entry Fee</label>
                                                         <input type="text" class="form-control" placeholder="Entry Fee " name="entry_fee" id="entry_fee" value="<?php echo set_value('entry_fee'); ?>">
                                                </div>   
                                                   
                                                </div>
                                             <div class="col-md-6"> 
                                                    <div class="form-group">
                                                    <label>Timing </label>
                                                    <input type="text" class="form-control" placeholder="Timing " name="timing" id="timing" value="<?php echo set_value('timing'); ?>">
                                                    </div>
                                                </div>
                                             <div class="clearfix"></div>                                                

                                                <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>Rating </label>                                                    
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

                                        </div> 
                                        <div class="box-main">

                                            <h3>Meta Tags</h3>
                                             <div class="col-md-6"> 
                                              <div class="row"> 
                                            	<div class="form-group">
                                                <div class="col-md-5"> <label>Meta Title</label></div>
                                                <div class="col-md-7">  
                                                       <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title"></textarea>
                                                </div>                                                
                                            </div>
                                              </div>
											 </div>

                                             <div class="col-md-6"> 
                                              <div class="row"> 
													<div class="form-group">
														<div class="col-md-5"> <label>Meta Keywords</label></div>
														<div class="col-md-7">  
															<textarea name="meta_keywords" id="meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"></textarea>
														</div>
													</div>
											  </div>
											  </div>                                          
                                        
                                            <div class="clearfix"></div>
      
                                           <div class="col-md-6"> 
                                              <div class="row"> 
                                            	<div class="form-group">
                                                <div class="col-md-5"> <label>Meta Description</label></div>
                                                <div class="col-md-7">  
                                                    <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"></textarea>
                                                </div>
                                               
                                            </div>
										   </div>
										   </div>  
                                        </div>								
                                        <div class="clearfix"></div>  
                                        <div class="col-md-6">
                                            <div class="reset-button"> 
                                                  <button type="submit" class="btn redbtn" name="btnSubmitPlace" id="btnSubmitPlace">Save</button>
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
    <script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.js" type="text/javascript"></script>

    <script>
    $(document.body).on('keyup change', '#place_name', function() {
        $("#place_url").val(name_to_url($(this).val()));
    });
    function name_to_url(name) {
        name = name.toLowerCase(); // lowercase
        name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
        name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
        name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
        return name;
    }
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('short_desc');
		$(document).ready(function(){
			$('#edesti').chosen();    
			$('#transport').chosen();   
			   $('#place_typedfd').chosen(); 
			$('#place_type').chosen();
			$('#getatagid').chosen();
			$("#edesti").change(function () {
				var menu = $(this);
			});
		});
        </script>

        <script type="text/javascript">
                
                  //for add row 
                $(document).on('click', '.add-new', function () {
                  
                    var html = '<div class="col-md-9"><div class="col-md-5"><div class="form-group"><label> Destination Name </label> <input class="form-control" placeholder="Enter destination name" name="trip_duration" id="trip_duration" value="" type="text"></div></div><div class="col-md-2"><div class="form-group"><label> No. of Days: </label> <input class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="" type="text"></div></div><div class="col-md-2"><div class="form-group"><label> No. of Night: </label> <input class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="" type="text"></div></div></div>';

                    $('.new-associated').before(html);
                    //$('.new-associated').parents().find('.form-group').eq(-2).before(html);
                });
                 //for delete rowz
                $(document).on('click', '.delete-row', function () {
                    $(this).closest('.form-group').remove();
                }); 


                // <div class="col-md-9"><div class="col-md-3"><div class="form-group"><label> Destination Name </label> <input class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="" type="text"></div></div><div class="col-md-3"><div class="form-group"><label> No. of Days: </label> <input class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="" type="text"></div></div><div class="col-md-3"><div class="form-group"><label> No. of Night: </label> <input class="form-control" placeholder="2-3 Days" name="trip_duration" id="trip_duration" value="" type="text"></div></div></div>


            </script>

    </body>
</html>

	
