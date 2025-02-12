<?php
	if (!empty($rows1)) {
		foreach ($rows1 as $rowss1) {
			$tourpackageid    = $rowss1['tourpackageid'];
			$package_image    = $rowss1['tpackage_image'];
			$tour_thumb    	  = $rowss1['tour_thumb'];
			$package_duration = $rowss1['package_duration'];
			$accomodation     = $rowss1['accomodation'];
			$tourtransport    = $rowss1['tourtransport'];
			$price    		  = $rowss1['price'];
			$fakeprice        = $rowss1['fakeprice'];
			$sightseeing      = $rowss1['sightseeing'];
			$breakfast        = $rowss1['breakfast'];
			$waterbottle      = $rowss1['waterbottle'];
			$ratings          = $rowss1['ratings'];
			$itinerary_note   = $rowss1['itinerary_note'];
			$tpackage_code    = $rowss1['tpackage_code'];
			$pack_type   	  = $rowss1['pack_type'];
			$itinerary        = $rowss1['itinerary'];
			$starting_city    = $rowss1['starting_city'];
			$status = $rowss1['status'];
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
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="header-title">
                        <h1>Tour Package</h1>
                        <small>View Tour Package </small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/tour-packages">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Tour package</h4>
                                        </a>
									</div>
									
									<div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url().'admin/tour-packages/edit/'.$tourpackageid ?>">
                                            <h4><i class="fa fa-plus-circle"></i> Edit Tour Package</h4>
                                        </a>
									</div>
								
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> package Name :</label></div>
												<div class="col-md-8"> <?php echo $rowss1['tpackage_name']; ?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> package URL : </label></div>
												<div class="col-md-8"> <?php echo $rowss1['tpackage_url']; ?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Package Code : </label></div>
												<div class="col-md-8">
													<?php 
														echo $tpackage_code;
													?> 
												</div>
											</div>
										</div>	
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>  Package duration : </label></div>
												<div class="col-md-8"><?php  $getdauraname = $this->Common_model->showname_fromid("duration_name", "tbl_package_duration", "durationid='$package_duration'");
												echo ucfirst($getdauraname);   ?></div>
											</div>
										</div> 
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>  Price (<?php echo $this->Common_model->currency; ?>): </label></div>
												<div class="col-md-8"><?php echo number_format($price,2); ?></div>
											</div>
										</div> 
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>  Fakeprice (<?php echo $this->Common_model->currency; ?>): </label></div>
												<div class="col-md-8"><?php echo number_format($fakeprice,2);   ?></div>
											</div>
										</div> 
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>  Profit Margin Percent (%) : </label></div>
												<div class="col-md-8"><?php  echo $rowss1['pmargin_perctage']; ?></div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Package Ratings : </label></div>
												<div class="col-md-8">														
													<?php
													for ($x = 1; $x <= $ratings; $x++) {
														echo '<i class="fa fa-star"></i> ';
													}
													if (fmod($ratings, 1) !== 0.00) {
														echo '<i class="fa fa-star-half-o"></i> ';
														$x++;
													}
													while ($x <= 5) {
														echo '<i class="fa fa-star-o"></i> ';
														$x++;
													}
													?>	
													(<?php echo $ratings.' Star'; ?>)											
												</div>
												
										    </div>
										</div> 
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Tour Availability : </label></div>
												<div class="col-md-8 checkavail">														
													<span><i class="<?php echo ($accomodation == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
													Accomodation &nbsp;</span>
															
													<span><i class="<?php echo ($tourtransport == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
													Transportation &nbsp;</span>
												
													<span><i class="<?php echo ($sightseeing == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
													Sightseeing	 &nbsp;</span>
														
													<span><i class="<?php echo ($breakfast == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
													Breakfast  &nbsp;</span> 
													
													<span><i class="<?php echo ($waterbottle == '1') ? 'fa fa-check-square' : 'fa fa-window-close' ; ?>"></i>
													Water Bottle </span>
												</div>
											</div>
										</div> 
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Tour Tags : </label></div>
												<div class="col-md-8">
													<?php 
														$getawaystagids = $this->Common_model->get_records("tagid","tbl_tags","type_id='$tourpackageid' and type = 3","");													 
														$hasComma = false;
														if(!empty($getawaystagids)){
															foreach($getawaystagids as $getawaystagid)
															{
																if ($hasComma){ 
																	echo ", "; 
																}
																$newgetawaystagid = $getawaystagid['tagid'];
																$gettagname = $this->Common_model->showname_fromid("tag_name", "tbl_menutags", "tagid='$newgetawaystagid'");
																echo ucfirst($gettagname);   
																$hasComma=true;
															}
														}										
													?> 
												</div>
												</div>
										   </div>
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Banner Image :</label></div>
												<div class="col-md-8"> 
													<?php
														if(!empty($package_image)) {
															if(file_exists("./uploads/".$package_image) && ($package_image!=''))
															{ 
																echo '<a href="'.base_url().'uploads/'.$package_image.'" target="_blank"><img src="'.base_url().'uploads/'.$package_image.'" style="width:86px;height:59px" alt="image" /></a>';
															}
														}
													?>
												</div>
											</div>
										</div> 

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Tour Image :</label></div>
												<div class="col-md-8"> 
													<?php
														if(!empty($tour_thumb)) {
															if(file_exists("./uploads/".$tour_thumb) && ($tour_thumb!=''))
															{ 
																echo '<a href="'.base_url().'uploads/'.$tour_thumb.'" target="_blank"><img src="'.base_url().'uploads/'.$tour_thumb.'" style="width:86px;height:59px" alt="image" /></a>';
															}
														}
													?>
												</div>
											</div>
										</div> 

										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Package Type: </label></div>												
												<div class="col-md-8"> <span><?php echo $this->Common_model->show_parameter($pack_type); ?></span> </div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Itinerary: </label></div>												
												<div class="col-md-8"> <span><a href="<?php echo base_url().'admin/itinerary/view/'.$itinerary; ?>" target="_blank"><?php echo $this->Common_model->showname_fromid("itinerary_name","tbl_itinerary","itinerary_id=$itinerary"); ?></a></span> </div>
											</div>
										</div>	
										
										<div class="clearfix"></div> 
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Starting City: </label></div>												
												<div class="col-md-8"> <span><?php echo $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id=$starting_city"); ?></span> </div>
											</div>
										</div>	
										
										<div class="clearfix"></div> 
					
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-3"> <label>  Inclusion / Exclusion: </label></div>
												<div class="col-md-9"><?php echo $rowss1['inclusion_exclusion']; ?></div>
											</div>
										</div> 										
										<div class="clearfix"></div>
										
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-3"> <label>  Itinerary Note: </label></div>
												<div class="col-md-9"><?php echo $itinerary_note; ?></div>
											</div>
										</div> 										
										<div class="clearfix"></div>
										
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-8">
													<div class="gap row">
														<div class="col-md-4"> <label> Meta Title: </label></div>												
														<div class="col-md-8"> <span><?php echo $rowss1['meta_title']; ?></span> </div>	
													</div>
													<div class="gap row">
														<div class="col-md-4"> <label> Meta Keywords: </label></div>												
														<div class="col-md-8"> <span><?php echo $rowss1['meta_keywords']; ?></span> </div>	
													</div>
													<div class="gap row">
														<div class="col-md-4"> <label> Meta Description: </label></div>												
														<div class="col-md-8"> <span><?php echo $rowss1['meta_description']; ?></span> </div>	
													</div>
												</div>
												<?php
													$get_associted_dests= $this->Common_model->get_records("*", "tbl_package_accomodation", "package_id ='$tourpackageid'", "acc_id ASC", "", "");
													if(!empty($get_associted_dests)) {
												?>
												<div class="col-md-4">
													<div class="asso-details" >Accomodation</div>
													<div class="billad">														
														<table class="table associate-head">
														    <thead>
																<tr>
																	<th>Destination Name</th>
																	<th>No of Nights</th>
																</tr>
														    </thead class="associateh">
														    <tbody>
																<?php																
																foreach($get_associted_dests as $get_associted_dest) {
																	$dest_id = $get_associted_dest['destination_id'];
																	$nodays = $get_associted_dest['noof_days'];																  
																	$dest_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id='$dest_id'");
																?>
																<tr>
																	<td><?php echo $dest_name; ?></td>
																	<td><?php echo $nodays ?></td>
																</tr>
																<?php } ?>
															</tbody>
														</table>
                                                    </div>
												</div>
													<?php } ?>
											</div>
										</div> 										
										<div class="clearfix"></div>
									
										<br><br>
								
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

