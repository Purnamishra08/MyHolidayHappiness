<?php
	if (!empty($itinerary)) {
		foreach ($itinerary as $rows) {
			$itinerary_id    = $rows['itinerary_id'];
			$itinerary_name  = $rows['itinerary_name'];
			$itinerary_url   = $rows['itinerary_url'];
			$ratings    	 = $rows['ratings'];
			$iti_travelmode  = $rows['iti_travelmode'];
			$iti_idealstime  = $rows['iti_idealstime'];
			$iti_duration  	 = $rows['iti_duration'];
			$show_in_home 	 = $rows['show_in_home'];
			$itineraryimg 	 = $rows['itineraryimg'];
			$itinerarythumbimg = $rows['itinerarythumbimg'];
			$starting_city    = $rows['starting_city'];
			$meta_title = $rows['meta_title'];
			$meta_keywords = $rows['meta_keywords'];
			$meta_description = $rows['meta_description'];

			$iti_duratn=$this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid='$iti_duration'");			

			$tourtag= $this->Common_model->join_records("b.tag_name","tbl_itinerary_tourtags as a", "tbl_menutags as b", "a.tourtagid=b.tagid", "a.itinerary_id=$itinerary_id");
			$alltourtags = array();
			$showtourtags = "";
			if($tourtag != "")
			{
				foreach($tourtag as $tourtags)
				{
					$alltourtags[] = $tourtags["tag_name"];
				}
				$showtourtags = implode(', ', $alltourtags);
			}

			$destypes= $this->Common_model->join_records("b.destination_type_name","tbl_itinerary_placetype as a", "tbl_destination_type as b", "a.placetype_id=b.destination_type_id", "a.itinerary_id=$itinerary_id");															
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
                        <i class="fa fa-superpowers"></i>
                    </div>
                    <div class="header-title">
                        <h1>Itinerary</h1>
                        <small>View Itinerary</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/itinerary">
                                            <h4><i class="fa fa-plus-circle"></i> Manage Itinerary</h4>
                                        </a>                                      
									</div>
                                    <div class="btn-group" id="buttonexport">
                                       <a href="<?php echo base_url().'admin/itinerary/edit/'.$itinerary_id ?>">
                                          <h4><i class="fa fa-plus-circle"></i> Edit Itinerary</h4>
                                        </a>
									</div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Itinerary Name :</label></div>
												<div class="col-md-8"> <?php echo $itinerary_name; ?></div>
											</div>
										</div>
									
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Itinerary Url : </label></div>
												<div class="col-md-8"> <?php echo $itinerary_url; ?></div>
											</div>
										</div>
                                    
										<div class="clearfix"></div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>  Place Type : </label></div>
												<div class="col-md-8"> <?php echo $showdestypes;  ?> </div>												
										    </div>
										</div>										

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Associated Tour Tag : </label></div>
												<div class="col-md-8">
													<?php 														
														echo $showtourtags;										
													?> 
												</div>
											</div>
										</div>
										
										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Mode Of Travel : </label></div>
												<div class="col-md-8"><?php echo $iti_travelmode; ?></div>
											</div>
										</div> 
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Ideal Start Time : </label></div>
												<div class="col-md-8"><?php echo $iti_idealstime;   ?></div>
											</div>
										</div>	

										<div class="clearfix"></div>
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>Trip Duration : </label></div>
												<div class="col-md-8">														
													<?php echo $iti_duratn;  ?>
												</div>												
										    </div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label>  Rating : </label></div>
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
												<div class="col-md-4"> <label>Banner Image</label></div>
												<div class="col-md-8"> 
													<?php
														if(file_exists("./uploads/".$itineraryimg) && ($itineraryimg!=''))
														{
															echo '<a href="'.base_url().'uploads/'.$itineraryimg.'" target="_blank"><img src="'.base_url().'uploads/'.$itineraryimg.'" style="width:150px;height:auto;" /></a>';
														}
													?>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Itinerary Image</label></div>
												<div class="col-md-8">												
												    <?php
														if(file_exists("./uploads/".$itinerarythumbimg) && ($itinerarythumbimg!=''))
														{
															echo '<a href="'.base_url().'uploads/'.$itinerarythumbimg.'" target="_blank"><img src="'.base_url().'uploads/'.$itinerarythumbimg.'" style="width:90px;height:auto;" /></a>';
														}
													?>												
												</div>
											</div>
										</div>
                                        <div class="clearfix"></div>										
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-4"> <label> Starting City: </label></div>												
												<div class="col-md-8"> <span><?php echo $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id=$starting_city"); ?></span> </div>
											</div>
										</div>	
										
										<div class="col-md-6">
											<div class="gap row">
												<div class="col-md-8"> <label>Show on home page (For Popular Itineraries) : </label></div>
												<div class="col-md-4">														
													<?php if($show_in_home==1){?> Yes <?php } else {?> No <?php } ?>														
												</div>												
										    </div>
										</div> 

										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-4"> <label>Meta Title : </label></div>
												<div class="col-md-8">														
													<?php echo $meta_title ; ?>														
												</div>												
										    </div>
										</div> 

										<div class="clearfix"></div>
								
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-4"> <label> Meta Description : </label></div>
												<div class="col-md-8">														
													<?php echo $meta_description ?>														
												</div>												
										    </div>
										</div> 

										<div class="clearfix"></div>
								
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-4"> <label> Meta Keywords : </label></div>
												<div class="col-md-8">														
													<?php echo $meta_keywords ?>														
												</div>												
										    </div>
										</div> 

										<div class="clearfix"></div>
								
								
									</div>
								</div>						
                            </div>
                        </div>
                    </div>
                </section>
            
				<!--  xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
				<?php            
					$get_associted_dests= $this->Common_model->get_records("*", "tbl_itinerary_destination", "itinerary_id ='$itinerary_id'", "itinerary_destinationid ASC", "", "");
					$get_daywise = $this->Common_model->get_records("*", "tbl_itinerary_daywise", "itinerary_id ='$itinerary_id'", "itinerary_daywiseid ASC", "", "");
					if(!empty($get_associted_dests) && (!empty($get_daywise))) { 
				?>
				<section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-body">
                                    <div class="row">                                    	
										<div class="col-md-12">
											<div class="gap row">
												<div class="col-md-4">
													<div class="asso-details" >Associated Destinations</div>
													<div class="billad">														
														<table class="table associate-head">
														    <thead>
																<tr>
																	<th>Destination Name</th>
																	<th>No of Days</th>
																	<th> No of Nights</th>
																</tr>
														    </thead class="associateh">
														    <tbody>
																<?php
																foreach($get_associted_dests as $get_associted_dest) {
																	$associate_dest_id = $get_associted_dest['itinerary_destinationid'];
																	$dest_id = $get_associted_dest['destination_id'];
																	$nodays = $get_associted_dest['noof_days'];					   
																	$nonights = $get_associted_dest['noof_nights'];
															  
																	$dest_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id='$dest_id'");
																?>
																<tr>
																	<td><?php echo $dest_name; ?></td>
																	<td><?php echo $nodays ?></td>
																	<td><?php echo $nonights ?></td>
																</tr>
																<?php } ?>
															</tbody>
														</table>
                                                    </div>
												</div>
												
												<div class="col-md-8">
													<div class="asso-details" >Iternary Details</div>
													<div class="billad">																											  
														<table class="table associate-head">
															<thead class="iternaryh">
																<tr>
																	<th>Day</th>
																	<th>Title </th>
																	<th>Place</th>
																</tr>
															</thead>
														    <tbody>
																<?php 
																	$day=1;
																	foreach($get_daywise as $get_daywis) 
																	{
																		$get_titl = $get_daywis['title'];
																		$get_iter = $get_daywis['place_id'];	
																		$get_place_array = array();
																		if($get_iter != "")
																		{
																			$get_places = $this->Common_model->get_records("place_name", "tbl_places", "placeid in($get_iter)");
																			if (!empty($get_places)) {
																				foreach ($get_places as $get_place) {
																					$get_place_array[] = $get_place['place_name'];
																				}
																			}
																		}
																?>
																<tr>
																	<td><?php echo $day; ?></td>
																	<td><?php echo $get_titl;?></td>
																	<td><?php if( count($get_place_array)>0 )echo implode(", ", $get_place_array); ?></td>
																</tr>
																<?php $day++; } ?>
															</tbody>
														</table>														
													</div>
												</div>									
												<div class="clearfix"></div>
										
											</div>
										</div>						
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>          
				<?php } ?>            
            </div>
        <?php include("footer.php"); ?>
    </body>
</html>

