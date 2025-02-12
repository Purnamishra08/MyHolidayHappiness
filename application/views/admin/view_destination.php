<?php
foreach ($dstype as $rows)
{
    $destid    = $rows['destination_id'];
    $dname     = $rows['destination_name'];
    $durl      = $rows['destination_url'];
	$latitude  = $rows['latitude'];
	$longitude = $rows['longitude'];
    $dstate    = $rows['state'];                  
    $dtrip     = $rows['trip_duration'];
    $dcity     = $rows['nearest_city'];
    $dtime     = $rows['visit_time'];
    $dpeak     = $rows['peak_season'];
    $dweather  = $rows['weather_info'];
    $dmap      = $rows['google_map'];
    $ddesc     = $rows['about_destination'];
	$pvdesc    = $rows['places_visit_desc'];
    $internet  = $rows['internet_availability'];
    $std       = $rows['std_code'];
    $lspeak    = $rows['language_spoken'];
    $mfest     = $rows['major_festivals'];
    $ntips     = $rows['note_tips'];
    $desttype_for_home  = $rows['desttype_for_home'];
    $show_on_footer     = $rows['show_on_footer'];
	$pick_drop_price 	= $rows['pick_drop_price'];
	$accomodation_price = $rows['accomodation_price'];
    $destpic = $rows['destiimg']; 
    $destiimg_thumb = $rows['destiimg_thumb']; 
    $status = $rows['status'];
    $meta_title        = $rows['meta_title'];
    $meta_keywords     = $rows['meta_keywords'];
    $meta_description  = $rows['meta_description'];
    
    $place_meta_title        = $rows['place_meta_title'];
    $place_meta_keywords     = $rows['place_meta_keywords'];
    $place_meta_description  = $rows['place_meta_description'];
    
    
    $package_meta_title        = $rows['package_meta_title'];
    $package_meta_keywords     = $rows['package_meta_keywords'];
    $package_meta_description  = $rows['package_meta_description'];
    $statename=$this->Common_model->showname_fromid("state_name","tbl_state","state_id='$dstate'");

	$destypes= $this->Common_model->join_records("b.destination_type_name","tbl_multdest_type as a", "tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$destid and loc_type = 1");
														
	$alldestypes = array();
	$showdestypes = "";
	if($destypes != "")
	{
		foreach($destypes as $destype)
		{
			$alldestypes[] = $destype["destination_type_name"];
		}
		$showdestypes = implode(', ', $alldestypes);
	}	

	$desticatsss= $this->Common_model->join_records("b.cat_name","tbl_destination_cats as a", "tbl_menucateories as b", "a.cat_id=b.catid", "a.destination_id=$destid");

	$alldesticats = array();
	$showalldesticats = "";
	if($desticatsss != "")
	{
		foreach($desticatsss as $desticatss)
		{
			$alldesticats[] = $desticatss["cat_name"];
		}
		$showalldesticats = implode(', ', $alldesticats);
	}

	$destiplace= $this->Common_model->join_records("b.destination_name","tbl_destination_places as a", "tbl_destination as b", "a.simdest_id=b.destination_id", "a.destination_id=$destid and type=2");

	$alldestiplaces = array();
	$showalldestiplaces = "";
	if($destiplace != "")
	{
		foreach($destiplace as $destiplaces)
		{
			$alldestiplaces[] = $destiplaces["destination_name"];
		}
		$showalldestiplaces = implode(', ', $alldestiplaces);
	}

	$destisimdest= $this->Common_model->join_records("b.destination_name","tbl_destination_places as a", "tbl_destination as b", "a.simdest_id=b.destination_id", "a.destination_id=$destid and type=1");

	$alldestisimdest = array();
	$showalldestisimdests = "";
	if($destisimdest != "")
	{
		foreach($destisimdest as $destisimdests)
		{
			$alldestisimdests[] = $destisimdests["destination_name"];
		}
		$showalldestisimdests = implode(', ', $alldestisimdests);
	}	 
	 
	$desti_tags= $this->Common_model->join_records("b.tag_name","tbl_tags as a", "tbl_menutags as b", "a.tagid=b.tagid", "a.type_id=$destid and type = 1");

	$alldestitags = array();
	$showalldestitags = "";
	if($desti_tags != "")
	{
		foreach($desti_tags as $desti_tag)
		{
			$all_dest_tags[] = $desti_tag["tag_name"];
		}
		$showalldestitags = implode(', ', $all_dest_tags);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("head.php"); ?>
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
                        <h1>Destination</h1>
                        <small>View Destination </small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/destination">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Destination</h4>
                                        </a> 
									</div>
								
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Name</label></div>
												<div class="col-md-8"> <?php echo $dname;?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Url </label></div>
												<div class="col-md-8"> <?php echo $durl;?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Type</label></div>
												<div class="col-md-8"><?php echo $showdestypes; ?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> State</label></div>
												<div class="col-md-8"><?php echo $statename; ?></div>
											</div>
										</div> 
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Categories</label></div>
												<div class="col-md-8"><?php echo $showalldesticats; ?></div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Getaway Tags</label></div>
												<div class="col-md-8"><?php echo $showalldestitags; ?></div>
											</div>
										</div>
									
										
                                    
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Banner Image</label></div>
												<div class="col-md-8"> 
													<?php
														if(file_exists("./uploads/".$destpic) && ($destpic!=''))
														{
															echo '<a href="'.base_url().'uploads/'.$destpic.'" target="_blank"><img src="'.base_url().'uploads/'.$destpic.'" style="width:150px;height:auto;" /></a>';
														}
													?>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Image</label></div>
												<div class="col-md-8">												
												    <?php
														if(file_exists("./uploads/".$destiimg_thumb) && ($destiimg_thumb!=''))
														{
															echo '<a href="'.base_url().'uploads/'.$destiimg_thumb.'" target="_blank"><img src="'.base_url().'uploads/'.$destiimg_thumb.'" style="width:90px;height:auto;" /></a>';
														}
													?>
												
												</div>
											</div>
										</div>
                                        <div class="clearfix"></div>
                                        
                                       <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Destination Type (For showing in home page) </label></div>
												<div class="col-md-8"> 
													<?php echo $this->Common_model->showname_fromid("par_value","tbl_parameters","parid ='$desttype_for_home' and param_type = 'TD'"); ?>
												</div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Show on Footer </label></div>
												<div class="col-md-8"> 
												<span><i class="<?php echo ($show_on_footer == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
												 </span>
												</div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Pick / Drop Price </label></div>
												<div class="col-md-8"> <?php echo $this->Common_model->currency.$pick_drop_price; ?></div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Minimum Accomodation Price /Person </label></div>
												<div class="col-md-8"> <?php echo $this->Common_model->currency.$accomodation_price; ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Latitude</label></div>
												<div class="col-md-8"> <?php echo $latitude; ?></div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Longitude</label></div>
												<div class="col-md-8"> <?php echo $longitude; ?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Ideal Trip Duration</label></div>
												<div class="col-md-8"> 
													<?php echo ($dtrip) ? $dtrip : '-'; ?>
												</div>
											</div>
										</div>										
										
                                        <div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Nearest City </label></div>
												<div class="col-md-8"> 
													<?php echo ($dcity) ? $dcity 	: '-'; ?>
												</div>
											</div>
										</div>
										
										<div class="clearfix"></div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Visit Time</label></div>
												<div class="col-md-8"> <?php echo ($dtime) ? $dtime :'-';?></div>
											</div>
										</div>
										
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Peak Season </label></div>
												<div class="col-md-8"> <?php echo ($dpeak) ? $dpeak: '-';?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Weather Info</label></div>
												<div class="col-md-8"> <?php echo ($dweather) ? $dweather: '-';?></div>
											</div>
										</div>									
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Simillar Destination</label></div>
												<div class="col-md-8"> <?php echo $showalldestisimdests;?></div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Near By Place </label></div>
												<div class="col-md-8"><?php echo $showalldestiplaces; ?></div>
											</div>
										</div>

										<div class="clearfix"></div>										
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Internet Availability</label></div>
												<div class="col-md-8"> <?php echo ($internet) ? $internet : '-' ;?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Std Code </label></div>
												<div class="col-md-8"> <?php echo ($std) ? $std : '-';?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>

                                        	<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Language Spoken</label></div>
												<div class="col-md-8"> <?php echo ($lspeak) ? $lspeak : '-';?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Major Festival </label></div>
												<div class="col-md-8"> <?php echo ($mfest) ? $std : '-';?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>

									
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Note Tips</label></div>
												<div class="col-md-8"> <?php echo ($ntips) ? $ntips :'-';?></div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Google Map </label></div>
												<div class="col-md-8"> <?php echo ($dmap) ? $dmap : '-' ;?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>
										
										

										
										<div class="clearfix"></div>
										
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>About Description</label></div>
												<div class="col-md-10"> <?php echo $ddesc;?></div>
											</div>
										</div>

										<div class="clearfix"></div>

										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Places to Visit Text</label></div>
												<div class="col-md-10"> <?php echo $pvdesc;?></div>
											</div>
										</div>

										<div class="clearfix"></div>
                                           <h4 style="margin-left: 15px;margin-top:10px">Overview Meta Tags</h4>    
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label> Meta Title</label></div>
												<div class="col-md-10"> <?php echo ($meta_title) ? $meta_title : '-' ;?></div>
											</div>
										</div>


										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Meta keyword </label></div>
												<div class="col-md-10"> <?php echo ($meta_keywords) ? $meta_keywords : '-' ;?></div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Meta Description</label></div>
												<div class="col-md-10"> <?php echo ($meta_description) ? $meta_description : '-' ;?></div>
											</div>
										</div>
										<div class="clearfix"></div>
										 <h4 style="margin-left: 15px;margin-top:10px">Place Meta Tags</h4>   
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label> Meta Title</label></div>
												<div class="col-md-10"> <?php echo ($place_meta_title) ? $place_meta_title : '-' ;?></div>
											</div>
										</div>


										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Meta keyword </label></div>
												<div class="col-md-10"> <?php echo ($place_meta_keywords) ? $place_meta_keywords : '-' ;?></div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Meta Description</label></div>
												<div class="col-md-10"> <?php echo ($place_meta_description) ? $place_meta_description : '-' ;?></div>
											</div>
										</div>
											<div class="clearfix"></div>
										<h4 style="margin-left: 15px;margin-top:10px"> Package Meta Tags</h4>   
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label> Meta Title</label></div>
												<div class="col-md-10"> <?php echo ($package_meta_title) ? $package_meta_title : '-' ;?></div>
											</div>
										</div>


										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Meta keyword </label></div>
												<div class="col-md-10"> <?php echo ($package_meta_keywords) ? $package_meta_keywords : '-' ;?></div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-2"> <label>Meta Description</label></div>
												<div class="col-md-10"> <?php echo ($package_meta_description) ? $package_meta_description : '-' ;?></div>
											</div>
										</div>
                                        	<div class="clearfix"></div>
									</div>
								</div>						
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php include("footer.php"); ?>
    </body>
</html>

