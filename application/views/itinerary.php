<?php
if(!empty($itinerary_data)){
    foreach ($itinerary_data as $itinerarydata)
    {
        $itinerary_id = $itinerarydata["itinerary_id"];
		$itinerary_name = $itinerarydata["itinerary_name"];
		$iti_travelmode = $itinerarydata["iti_travelmode"];
		$iti_idealstime = $itinerarydata["iti_idealstime"];
		$itinerary_url = $itinerarydata["itinerary_url"];
		$itineraryimg = $itinerarydata["itineraryimg"];
		$itineraryalttag_banner = $itinerarydata["alttag_banner"];
		$itineraryalttag_thumb = $itinerarydata["alttag_thumb"];
		$iti_starting_city    = $itinerarydata['starting_city'];
		$ratings = $itinerarydata["ratings"];		
		
		$iti_duration = $itinerarydata["iti_duration"];
		$show_duration = $this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid ='$iti_duration'");
		
		$package_details = $this->Common_model->get_records("tpackage_name, tpackage_url, price, fakeprice","tbl_tourpackages","itinerary ='$itinerary_id'");
		if(!empty($package_details)){
			foreach ($package_details as $package_res)
			{
				$package_name = $package_res["tpackage_name"];
				$package_url = $package_res["tpackage_url"];
				$package_price = $package_res["price"];
				$package_fakeprice = $package_res["fakeprice"];
			}
		}
		
		/***********No of Associated Destinations************/
		$noof_assoc_dest = $this->Common_model->noof_records("a.itinerary_destinationid","tbl_itinerary_destination as a, tbl_destination as b","a.destination_id=b.destination_id and a.itinerary_id=$itinerary_id");		
		if($noof_assoc_dest > 0)
		{	
			$assoc_dests_arr = array();
			$assoc_dests = $this->Common_model->join_records("a.itinerary_destinationid, a.destination_id, b.destination_name, a.noof_days, a.noof_nights","tbl_itinerary_destination as a","tbl_destination as b", "a.destination_id=b.destination_id", "a.itinerary_id=$itinerary_id","a.itinerary_destinationid asc");
			
			foreach ($assoc_dests as $assoc_dest)
			{
				$assoc_dests_arr[] = $assoc_dest['destination_name'];
				$assoc_dests_ids[] = $assoc_dest['destination_id'];
			}
			$show_assoc_dests =  implode(" - ", $assoc_dests_arr);
		}
		
		/***********Itinerary Types************/
		$itinerary_types = array();
		$show_itinerary_types = "";
		$noof_itinerary_types =  $this->Common_model->noof_records("itinerary_placetype","tbl_itinerary_placetype","itinerary_id=$itinerary_id"); 
		if($noof_itinerary_types > 0)
		{										
			$itinerary_type_datas = $this->Common_model->join_records("a.placetype_id, b.destination_type_name","tbl_itinerary_placetype as a","tbl_destination_type as b", "a.placetype_id=b.destination_type_id", "a.itinerary_id=$itinerary_id and b.status=1","b.destination_type_name asc");
			foreach ($itinerary_type_datas as $itinerarytype)
			{
				$itinerary_types[] = $itinerarytype['destination_type_name'];
			}										
		}
		
		/***********No of places to cover************/
		$countplaces = 0;
		$noof_places = $this->Common_model->noof_records("itinerary_daywiseid","tbl_itinerary_daywise","itinerary_id=$itinerary_id");		
		if($noof_places > 0)
		{	
			$assoc_places_arr = array();
			$assoc_places = $this->Common_model->get_records("*","tbl_itinerary_daywise","itinerary_id=$itinerary_id and place_id!=''");
			
			foreach ($assoc_places as $assoc_place)
			{
				$assoc_places_arr[] = $assoc_place['place_id'];
			}
			$show_assoc_places =  implode(",", $assoc_places_arr);
			$countplaces = count(explode(",", $show_assoc_places));
		}		
	}
}
?>
<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?>
		<link href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed:400,500,600|Questrial&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	</head>
    <body>
		<?php include("header.php"); ?> 
		
		<section class="bannerdesti">
			<?php 
				if(file_exists("./uploads/".$itineraryimg) && ($itineraryimg!='')) {
					$itineraryimg = base_url()."uploads/".$itineraryimg;
				}
				else 
					$itineraryimg = base_url()."assets/images/TajMahal1_sm.jpg";
			?>
			<img src="<?php echo $itineraryimg; ?>" class="img-fluid" class="img-fluid" style="width: 100%; height: 450px; object-fit: cover;" alt="<?php echo (!empty($itineraryalttag_banner)) ? $itineraryalttag_banner : $itinerary_name; ?>">
		</section>   
		
        <section style="background:#e4e8ec;padding-bottom:30px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banneritinerarybottom-holder">
                            <div class="row">
                                <div class="col-md-7 summerybox">
                                    <div class="mb-2 stariconholder">
										<?php 
											$floorval = floor($ratings);															
											$decval = $ratings-$floorval; 
											$balanceint = 5-$ratings;
											echo str_repeat('<i class="fas fa-star"></i>', (int) $floorval);
											echo ($decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
											echo str_repeat('<i class="far fa-star"></i>',(int)  $balanceint);
										?>
										<span class="ratingnumber" style="color:#000"><?php echo $ratings; ?> / 5</span>
									</div>
									<?php if(count($itinerary_types) > 0) { ?>
                                    <span class="iti-btm-tag"><?php echo $show_itinerary_types = implode(" | ", $itinerary_types); ?></span>
									<?php } ?>
									<h1><?php echo $itinerary_name; ?> <?php if($noof_assoc_dest > 0): ?>| <?php echo $show_assoc_dests; ?><?php endif; ?></h1>
									
									<?php if(!empty($package_details)){ ?>
                                    <div class="mb-2 mt-2">Tour Starts from
										<span class="packageCostOrig" style="text-decoration: line-through; font-size:14px; margin-left:10px;"><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span>
                                        <span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span>
									</div>
                                    <div><a href="<?php echo base_url()."packages/".$package_url; ?>" class="interlinkheading" target="_blank">Calculate price</a></div>
									<?php } ?>

                                </div>
                                <div class="col-md-5 itineraryrightbox">
                                    <h4>Itinerary Summery</h4>
                                    <a href="<?php echo base_url()."packages/".$package_url; ?>" class="downloaditi-btn" target="_blank">  Download Itinerary</a>
                                    <ul class="iti-summary-list mt-3">
                                        <?php if($iti_starting_city != ""): ?><li>Trip Starts From: <span><?php echo $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id=$iti_starting_city"); ?></span></li><?php endif; ?>
                                        <?php if($iti_travelmode != "") { ?><li>Mode of Travel: <span><?php echo $iti_travelmode; ?></span></li><?php } ?>
                                        <?php if($iti_idealstime != "") { ?><li>Ideal Start Time: <span><?php echo $iti_idealstime; ?></span></li><?php } ?>
                                        <?php if($countplaces > 0) { ?><li>Total Places Visited: <span><?php echo $countplaces; ?></span></li><?php } ?>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
			</div>
        </section>

        <section class="mt-5 mb-5 iti-summery-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
						<?php
							if($noof_assoc_dest > 0)
							{
								$c = 1;
								$show_dest = "";
								foreach ($assoc_dests as $assoc_dest)
								{
									$show_dest .= $assoc_dest['destination_name'];
									if(($assoc_dest['noof_days'] > 0) || ($assoc_dest['noof_nights'] > 0))
									{
										$show_dest .= "(";
										
										if($assoc_dest['noof_days'] > 0)
											$show_dest .= $assoc_dest['noof_days']."D";
										
										if($assoc_dest['noof_nights'] > 0)
											$show_dest .= "/".$assoc_dest['noof_nights']."N";
										
										$show_dest .= ")";
									}
									if($c < $noof_assoc_dest)
										$show_dest .= " - ";
						?>
							
						<?php $c++; } echo $show_dest; } ?>
                        <h3 class="mt-2 mb-1" style="font-style: 1.5rem;">Travel Summery</h3>
						<?php 
							if($noof_places > 0)
							{
						?>
                        <ul class="travelsummery">	
							<?php $day = 1; foreach ($assoc_places as $assoc_place) { ?>
                            <li>Day <?php echo $day; ?> : <?php echo $assoc_place["title"]; ?></li>
							<?php $day++; } ?>
                        </ul>
						<?php } ?>
                        <div class="shareicons">
							<i class="pe-7s-share" style="font-weight: 600"></i>Share
							<a href="http://www.facebook.com/sharer.php?u=<?php echo base_url().'itinerary/'.$itinerary_url; ?>" target="_blank" class=""><i class="fab fa-facebook-f"></i></a>
							<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url().'itinerary/'.$itinerary_url; ?>" target="_blank" class=""> <i class="fab fa-linkedin-in"></i></a>
							<a href="https://plus.google.com/share?url=<?php echo base_url().'itinerary/'.$itinerary_url; ?>" target="_blank" class=""><i class="fab fa-google-plus-g"></i></a>
							<a href="https://twitter.com/share?url=<?php echo base_url().'itinerary/'.$itinerary_url; ?>" target="_blank" class=""><i class="fab fa-twitter"></i></a>
						</div>
                    </div>

                    <div class="col-lg-5 iti-summery-side-img-holder">
                       
                       <?php 
							$itinerary_thumb_img = $itinerarydata['itinerarythumbimg'] 
							;
							if(file_exists("./uploads/".$itinerary_thumb_img) && ($itinerary_thumb_img!='')) {
								$itinerary_thumb_img = base_url()."uploads/".$itinerary_thumb_img;
							}
							else 
								$itinerary_thumb_img = base_url()."assets/images/noimgavail.jpg";				
					   ?>
			
			
                        <img src="<?php echo $itinerary_thumb_img; ?>" class="img-fluid summeryright-sideimg" alt="<?php echo (!empty($itineraryalttag_thumb)) ? $itineraryalttag_thumb : $itinerary_name; ?>">

                        <div style="background:#28a745;text-align: center;padding:35px 25px;">
                            <h4 style="color:#fff; font-size:20px; margin-bottom:8px; line-height:20px; margin-bottom:10px;">Need Customization?  </h4>
                            <a href="<?php echo base_url().'contactus' ?>" target="_blank"><span style="padding: 7px 16px;
                                  background: -moz-linear-gradient(90deg,#e7e7e8 0,#fff 100%);
                                  background: -webkit-gradient(linear,left top,left bottom,color-stop(0,#fff),color-stop(100%,#e7e7e8));
                                  background: -webkit-linear-gradient(90deg,#e7e7e8 0,#fff 100%);
                                  background: -o-linear-gradient(90deg,#e7e7e8 0,#fff 100%);
                                  background: -ms-linear-gradient(90deg,#e7e7e8 0,#fff 100%);
                                  background: linear-gradient(0deg,#e7e7e8 0,#fff 100%);border-radius: 50px;

                                  display: inline-block;
                                  margin-bottom: 10px;">Send 
                                  enquiry</span></a>
                            <p style="     font-size: 15px;
                               color: #fff;
                               border-top:#3dc15b 1px solid;
                               margin-bottom: 0;
                               margin-top: 12px;
                               padding-top: 14px;">Call us at (Toll Free No.)</p>
                            <h5 style="color:#fff;"><?php echo $this->Common_model->show_parameter(3); ?></h5>
                        </div>

                    </div>
                </div>
            </div>
        </section>
		
		<?php
			if($noof_places > 0)
			{
		?>
        <section class="mb100">
            <div class="container">
                <div class="btn-group">
                    <a href="javascript:void(0)" id="list" class="btn btn-default btn-sm"><i class="pe-7s-menu"></i>List View</a>
                    <a href="javascript:void(0)" id="grid" class="btn btn-default btn-sm"><i class="pe-7s-map-marker"></i>Map View</a>
                </div>
				
				<?php 
					$dayno = 1; 
					foreach ($assoc_places as $assoc_place) 
					{ 
						$daywise_places = $assoc_place['place_id']
				?>
                <div class="<?php echo ($dayno%2==0)?'oddbox':'evenbox'; ?>" id="list_view">
                    <div class="col-md-col-md-12 <?php echo ($dayno%2==0)?'text-right':''; ?>">
                        <div class="itineraryheadingbg">
                            <h3>Day <?php echo $dayno; ?>: <?php echo $assoc_place["title"]; ?></h3>
						</div>
                    </div>
					<?php if($daywise_places != "") { ?>
                    <div class="row">
						<?php
							$itinerary_places = $this->Common_model->get_records("*","tbl_places","placeid in ($daywise_places)");
							//echo $this->db->last_query();
							foreach($itinerary_places as $place_data)
							{	
								$itinerary_place_id = $place_data['placeid'];
								$itinerary_destid = $place_data['destination_id'];
								$itinerary_place_url = $place_data['place_url'];
								$itinerary_aboutplace = $place_data['about_place'];
								$itinerary_trip_duration = $place_data['trip_duration'];
								$itinerary_rating = $place_data['rating'];
								
								$place_dest_data = $this->Common_model->join_records("a.destination_url, b.state_url","tbl_destination as a","tbl_state as b", "a.state=b.state_id", "a.destination_id=$itinerary_destid");
								foreach ($place_dest_data as $itinerary_placedest)
								{
									$itinerary_destinationurl = $itinerary_placedest['destination_url'];
									$itinerary_state_url =  $itinerary_placedest['state_url'];
								}
								
								$place_types = array();
								$show_place_types = "";
								$noof_place_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$itinerary_place_id and loc_type = 2"); 
								if($noof_place_types > 0)
								{										
									$place_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$itinerary_place_id and a.loc_type=2 and b.status=1","b.destination_type_name asc");
									foreach ($place_type_datas as $placetype)
									{
										$place_types[] = $placetype['destination_type_name'];
									}									
								}
								
								if(count($place_types) > 0)
								{
									$show_place_types = implode(" | ", $place_types);
								}
						?>					
                        <div class="col-lg-6">
                            <div class="itinerarybox">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="<?php echo base_url().'place/'.$itinerary_state_url.'/'.$itinerary_destinationurl.'/'.$itinerary_place_url; ?>" target="_blank"> 
											<img src="<?php echo base_url()."uploads/".$place_data['placethumbimg']; ?>" class="img-fluid iti-img" alt="<?php echo (!empty($place_data['alttag_thumb'])) ? $place_data['alttag_thumb'] : $place_data['place_name']; ?>" target="_blank">
										</a>
                                    </div>
                                    <div class="col-md-8 itilistholder">
                                        <h4 class="mt-2"><?php echo $place_data['place_name']; ?></h4> 
										
										<?php 
											$rating_floorval = floor($itinerary_rating);															
											$rating_decval = $itinerary_rating-$rating_floorval; 
											$rating_balanceint = 5-$itinerary_rating;
											echo str_repeat('<i class="fas fa-star"></i>',(int) $rating_floorval);
											echo ($rating_decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
											echo str_repeat('<i class="far fa-star"></i>', (int) $rating_balanceint);
										?>
										
                                        <ul class="itinerarylist">
											<?php if($show_place_types !="") { ?>
                                            <li><?php echo $show_place_types; ?></li>
											<?php } ?>
											<?php if($itinerary_trip_duration !="") { ?>
                                            <li><strong>Trip duration:</strong> <?php echo $itinerary_trip_duration; ?></li>
											<?php } ?>
                                        </ul>
                                    </div>

                                    <div class="col-md-12">
                                        <p class="iti-desc"> <?php echo $this->Common_model->short_str("$itinerary_aboutplace", "220"); ?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="<?php echo base_url().'place/'.$itinerary_state_url.'/'.$itinerary_destinationurl.'/'.$itinerary_place_url; ?>" class="viwebtn" target="_blank">View details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php } ?>

                    </div>
					<?php } ?>
				</div>
				
				<div id="map" style="height:500px; display:none;"></div>
				<?php $dayno++; } ?>
                
				<?php if(!empty($package_details)) { ?>
                <div class="customizationtxt mt-2"><h4 style="font-size:20px">Need Customization?</h4><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal">Send Enquiry</a></div>
				<?php } ?>
				
            </div>
        </section>
		<?php } ?>
		
		<?php	
		if($noof_assoc_dest > 0)
		{
			$tour_package_dests = implode(", ", $assoc_dests_arr);
			$tour_package_destids = implode(", ", $assoc_dests_ids);
			$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id in ($tour_package_destids)) and `status` = 1","");
			//echo $this->db->last_query();
			if (!empty($tour_packages)) {
        ?>
            <section class="tourpackage-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 mb-4">
                            <h2 style="font-size: 22px;">Most Popular <?php echo $tour_package_dests; ?> Tour Packages</h2>
                        </div>
                        <div class="col-md-5 mb-4">
                            <?php echo form_open(base_url('place'), array( 'id' => 'search_form', 'name' => 'search_form', 'class' => 'row listform'));?>
								<div class="col-lg-6 col-md-12">
									<div class="form-group">
										<select class="selectpicker" name="starting_city" id="starting_city">
											<option value="">Select Starting City</option>
											<?php
												$destination_qry = $this->db->query("SELECT destination_id, destination_name FROM tbl_destination WHERE status=1 and destination_id in (select distinct(starting_city) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id in ($tour_package_destids)) and status=1) ORDER BY destination_name asc");
												$destinations = $destination_qry->result_array();
												foreach($destinations as $destination)
												{
											?>
											<option value="<?php echo $destination['destination_id']; ?>"><?php echo $destination["destination_name"]; ?></option>
											<?php  
												}
											?>
										</select>
									</div>
								</div>

								<div class="col-lg-6 col-md-12">
									<div class="form-group">
										<select class="selectpicker" name="trip_duration" id="trip_duration">
											<option value="">Select Trip Duration</option>
											<?php
												$durations_qry = $this->db->query("SELECT durationid, duration_name FROM tbl_package_duration WHERE status=1 and durationid in (select distinct(package_duration) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id in ($tour_package_destids)) and status= 1) ORDER BY no_ofdays asc");
												$durations = $durations_qry->result_array();
												foreach($durations as $duration)
												{
											?>
											<option value="<?php echo $duration['durationid']; ?>"><?php echo $duration["duration_name"]; ?></option>
											<?php  
												}
											?>
										</select>
										<input type="hidden" name="destination_id" id="destination_id" value="<?php echo $tour_package_destids; ?>">
									</div>
								</div>
								<div class="clearfix "></div>
							<?php echo form_close();?>
                        </div>
                    </div> 
                </div>
            </section>

            <div class="container mb100 tours-in-india-section">        	
                <div class="row" id="search_result">
					<div id="loader"></div>
                    <?php
                    foreach ($tour_packages as $tour_package) {
                        $tourpackageid = $tour_package["tourpackageid"];
                        $tpackage_name = $tour_package["tpackage_name"];
                        $tpackage_url = $tour_package["tpackage_url"];

                        $package_duration = $tour_package["package_duration"];
                        $show_duration = $this->Common_model->showname_fromid("duration_name", "tbl_package_duration", "durationid ='$package_duration'");

                        $package_price = $tour_package["price"];
                        $package_fakeprice = $tour_package["fakeprice"];
                        $tour_thumb = $tour_package["tour_thumb"];

                        $accomodation = $tour_package["accomodation"];
                        $tourtransport = $tour_package["tourtransport"];
                        $sightseeing = $tour_package["sightseeing"];
                        $breakfast = $tour_package["breakfast"];
                        $waterbottle = $tour_package["waterbottle"];
                        $pack_type = $tour_package["pack_type"];
						$itinerary = $tour_package["itinerary"];

						$starting_city = $tour_package["starting_city"];							
						$starting_city_name = $this->Common_model->showname_fromid("destination_name","tbl_destination","destination_id=$starting_city");

						$noof_assoc_dest = $this->Common_model->noof_records("a.itinerary_destinationid","tbl_itinerary_destination as a, tbl_destination as b","a.destination_id=b.destination_id and a.itinerary_id=$itinerary");

                        if ($noof_assoc_dest > 0) {
                            $assoc_dests_arr = array();
							$assoc_dests = $this->Common_model->join_records("a.itinerary_destinationid, b.destination_name","tbl_itinerary_destination as a","tbl_destination as b", "a.destination_id=b.destination_id", "a.itinerary_id=$itinerary","a.itinerary_destinationid asc");

                            foreach ($assoc_dests as $assoc_dest) {
                                $assoc_dests_arr[] = $assoc_dest['destination_name'];
                            }
                            $show_assoc_dests = implode(" - ", $assoc_dests_arr);
                        }
                        ?>				
                        <div class="col-lg-3 col-md-6  touristlist-box">
                            <div class="touristdetails-imgholder">
                                <?php
                                if (!empty($pack_type)) {
                                    $class = ($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon';
                                    ?> 
                                    <div class="<?php echo $class; ?>">
                                        <span><?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parid ='$pack_type' and param_type = 'PT' "); ?></span>
                                    </div>								
                                <?php } ?>

                                <a href="<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank"><img src="<?php echo base_url() . 'uploads/' . $tour_thumb; ?>" class="img-fluid" alt="My Holiday Happiness"></a>
                                <?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
                                <div class="tourist-duration"> <?php echo $show_duration; ?> </div>
                            </div>
                            <div class="tourist-bottom-details">
                                <ul class="iconlist">									
                                    <?php if ($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation"></li><?php endif; ?>
                                    <?php if ($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li><?php endif; ?>
                                    <?php if ($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li><?php endif; ?>	
                                    <?php if ($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li><?php endif; ?>
                                    <?php if ($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li><?php endif; ?>
                                </ul>
                                <div class="touristlist-hdng "><?php echo $tpackage_name; ?> </div>
                                <div class="tourbutton "> <span><a href="<?php echo base_url() . 'packages/' . $tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></span></div>
                                <div class="tourprice "><span class="packageCostOrig " style="text-decoration: line-through; color: #A0A0A0; font-size:14px "><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span></div>
                                <div class="clearfix "></div>
                            </div>
                        </div>                
                    <?php } ?>               
                </div>
            </div>
        <?php } } ?>	

        <section class="innergoogle-review ">
            <?php include("verified_reviews.php"); ?> 
		</section>
        
		<?php	 
			$getdestIds = $this->db->query("SELECT a.destination_id,a.destination_name,a.destination_url,a.destiimg_thumb,a.alttag_thumb from tbl_destination as a INNER JOIN tbl_tourpackages as b INNER JOIN (SELECT destination_id,itinerary_id FROM tbl_itinerary_destination) as c ON a.destination_id = c.destination_id AND b.itinerary = c.itinerary_id WHERE b.status = 1 and a.status = 1 GROUP BY a.destination_id ORDER BY a.destination_id DESC LIMIT 12");
												
			$destIds = $getdestIds->result(); 
			if(!empty($destIds)){
		?>
        <section class="tours-in-india-bottom-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 text-center">
                        <h2 class="mb-2">Most Popular Tours in India</h2>
                        <a href="<?php echo base_url(); ?>tour-packages" class="innerbotttom-btn" target="_blank">Our popular tour packages</a>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <div class="container mb100 tours-in-india-section">
            <div class="row">
                <?php 
					foreach ($destIds as $destIds) {
						$dImg = $destIds->destiimg_thumb;
						$alttag_thumb = $destIds->alttag_thumb;
						$dURL = $destIds->destination_url;
						$dURLName = str_replace("'", "", $dURL);						
						
						if(file_exists("./uploads/".$dImg) && ($dImg!='')) {
							$dest_thumb_img = base_url()."uploads/".$dImg;
						}
						else 
							$dest_thumb_img = base_url()."assets/images/kerala.jpg";
						
				?>
					<div class="col-lg-2 col-md-3 toursimgholder">
						<img src="<?php echo $dest_thumb_img ; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : $destIds->destination_name; ?>">
						<h5 class="overlaybacktxt"> <?php echo $destIds->destination_name?>	</h5>		
						<div class="overlay">
							<div class="package-tour-title">					
								<a href="<?php echo base_url().'destination-package/'.$dURLName ?>" class="viewbtn" target="_blank"><?php echo $destIds->destination_name?></a>
							</div>					
						</div>
					</div> 
				<?php } ?>            			  
                <div class="clearfix"></div>
            </div> 
        </div>
		<?php } ?>		
		
		
        <?php if(!empty($package_details)) { ?>
		<div id="myModal" class="modal fade ">
            <div class="modal-dialog formmodal ">
                <div class="modal-content ">
                    <div class="modal-header" style="background:rgb(234, 244, 255);">
                        <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="col-md-12 ">
                            <h4 class="modal-title ">Interested in <?php echo $package_name ?>?</h4>
                            <div>
                                <h5>This Tour Starts @ <span class="" style="font-size: 12px; text-decoration: line-through; "><?php echo $this->Common_model->currency . $package_fakeprice ?></span> <?php echo $this->Common_model->currency . $package_price ?></h5>
                               
                                <a href="<?php echo base_url()."packages/".$package_url; ?>" class="viwebtn" target="_blank">Book Now</a>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">

                      <?php echo form_open('',array( 'id' => 'form_itinerary_popup', 'name' => 'form_itinerary_popup', 'class' => 'formright' ));?>
                            <h5 class="mb-2 ">Need customization? Contact us !</h5>
                            <div class="row">

                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <input type="text" class="form-control" value="" placeholder="Email" name="email" id="email" maxlength="80">
                                        <input type = "hidden" name ="itinerary_id" id ="itinerary_id" value="<?php echo set_value('itinerary_id', $itinerary_id); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <input type="text" class="form-control" value="" placeholder="Phone" name="phone" id="phone" maxlength="10">
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group datepickerbox modalicon ">
                                        <input type="text" class="form-control" value="" placeholder="Trip start date" name="tsdate" id="tsdate">
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <select class="form-control" id="duration" name ="duration">
                                            <option value=''>Trip Duration</option>
                                            <?php  echo $this->Common_model->populate_select($dispid = 0, "durationid", "duration_name", "tbl_package_duration", "", "duration_name asc", ""); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 ">
                                    <div class="form-group ">
                                        <textarea class="form-control text-area-height" rows="2" name ="tnote" id="tnote" placeholder="Enter trip details (Maximum 500 Character)" maxlength="500"></textarea>
                                    </div>
                                </div>
								
								<div class="col-md-12 ">
                                    <div class="form-group ">
										<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <button type="submit" class="btn requestquotebtn">Request Quote</button>
                                </div>
                                <div class="col-md-12">
                                     <div id="errMessage" style="margin-top: 10px;"></div>  
                                </div>
                            </div>
                       <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
		<?php } ?>
		
	   
        <?php include("footer.php"); ?>     
		
		<script>var base_url = "<?php echo base_url(); ?>";</script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scrollBar.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
        <script src="<?php echo base_url(); ?>assets/js_validation/validation.js"></script>
		<script>
            $(function () {
                $('.selectpicker').selectpicker();
            }); 
			
			$(function () {
                $("#list").click(function () {
					$("#list_view").show();
					$("#map").hide();
				});
				
				$("#grid").click(function () {
					$("#map").show();
					$("#list_view").hide();
				});
            }); 
        </script>
		
		<script>			       
             $(function () {
                $("#tsdate").datepicker({
                    minDate: 0,
                    showOtherMonths: true,
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:+0"
                });
            });
			
			$(".sb-container").scrollBox();
			
            $(document).ready(function () {
                $("#myModal").modal('show');
            });            
        </script>
		
		<script>
			$(document).on('change', '#starting_city, #trip_duration', function(){	
				//alert("hi");
				$.ajax({
					url: "<?php echo base_url(); ?>itinerary/search",
					type: 'post',
					//dataType: "json",
					//cache: false,
					//processData: false,
					data: $('#search_form').serialize(),
					beforeSend: function () {                       
						$('#search_result').addClass('loder-bg');
						$('#loader').addClass('loder-gif');
						$("#loader").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
					},  
					success: function(result) {
						$('#search_result').html(result);
						$("#loader").html('');
						$('#search_result').removeClass('loder-bg');
						$('#loader').removeClass('loder-gif');								
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
					}
				});
			})
		</script>
		
		<?php
			if($noof_places > 0)
			{		
				$starting_latitude = $this->Common_model->showname_fromid("latitude", "tbl_destination", "destination_id ='$iti_starting_city'");
				$starting_longitude = $this->Common_model->showname_fromid("longitude", "tbl_destination", "destination_id ='$iti_starting_city'");
		?>
		<script>
			function initMap() {
			
				var map = new google.maps.Map(document.getElementById('map'), {
				  center: new google.maps.LatLng(<?php echo $starting_latitude; ?>, <?php echo $starting_longitude; ?>),
				  zoom: 8
				});
				
				var infoWindow = new google.maps.InfoWindow;

				// Change this depending on the name of your PHP or XML file
				downloadUrl('<?php echo base_url(); ?>mapmarkers/itinerary/<?php echo $itinerary_id; ?>', function(data) {
					var xml = data.responseXML;
					//alert(xml);
					var markers = xml.documentElement.getElementsByTagName('marker');
					Array.prototype.forEach.call(markers, function(markerElem) {
						var id = markerElem.getAttribute('id');
						var name = markerElem.getAttribute('name');
						var placeurl = markerElem.getAttribute('placeurl');
						var day = markerElem.getAttribute('day');
						var point = new google.maps.LatLng(
							parseFloat(markerElem.getAttribute('lat')),
							parseFloat(markerElem.getAttribute('lng')));
						var title = "Day "+day+": "+name;
						var marker = new google.maps.Marker({
							map: map,
							position: point,
							label: {
								text: title,
								color: '#fff',
								fontSize: '12px'
							},
							icon: {
								url: "<?php echo base_url(); ?>assets/images/map-icon.png",
								scaledSize: new google.maps.Size(220, 40)
							}
						});
						marker.addListener('click', function() {
							window.location = '<?php echo base_url(); ?>'+placeurl;						
						});
						
					});
				});
			}

			function downloadUrl(url, callback) {
				var request = window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;

				request.onreadystatechange = function() {
				  if (request.readyState == 4) {
					request.onreadystatechange = doNothing;
					callback(request, request.status);
				  }
				};

				request.open('GET', url, true);
				request.send(null);
			}

			function doNothing() {}
		</script>
		
		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-kVx0UE86TuBIo7cQnKyaeem2SxzeHK0&callback=initMap">
		</script>
		<?php } ?>
        
    </body>
</html>
