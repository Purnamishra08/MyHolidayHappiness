<?php
if(!empty($placedata)){
    foreach ($placedata as $placedrec)
    {
        $placeid = $placedrec['placeid'];
        $place_name = $placedrec['place_name'];
        $place_url = $placedrec['place_url'];
		$placeimg = $placedrec['placeimg'];
        $placethumbimg = $placedrec['placethumbimg'];
		$about_place = $placedrec['about_place'];
        $placealttag_banner = $placedrec['alttag_banner'];
		$placealttag_thumb = $placedrec['alttag_thumb'];
		
        $trip_duration = $placedrec['trip_duration'];
		$travel_tips = $placedrec['travel_tips'];
		$google_map = $placedrec['google_map'];
		$distance_from_nearest_city = $placedrec['distance_from_nearest_city'];
		
		$entry_fee = $placedrec['entry_fee'];		
        $timing = $placedrec['timing'];
        $rating = $placedrec['rating'];       
		
        $destination_id = $placedrec['destination_id'];
		
		$dest_data=$this->Common_model->get_records("destination_name, destination_url, state","tbl_destination","destination_id='$destination_id'");
		foreach($dest_data as $destdata)
		{
			$destination_name= $destdata['destination_name']; 
			$destination_url = $destdata['destination_url'];
			$state_id = $destdata['state'];
		}
		
		$state_data=$this->Common_model->get_records("state_name, state_url","tbl_state","state_id='$state_id'");
		foreach($state_data as $state)
		{
			$statenm= $state['state_name']; 
			$stateurl = $state['state_url'];
		}
		
		$noof_places_in_destination =  $this->Common_model->noof_records("placeid","tbl_places","destination_id='$destination_id' and status='1'");
    } 
}

/*************place Pop package information***************/
$noof_place_popup_packages = $this->Common_model->noof_records("DISTINCT(tourpackageid) as package_id", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$placeid' or place_id like '$placeid,%' or place_id like '%,$placeid' or place_id like '%,$placeid,%') and status=1");
		
if(!empty($noof_place_popup_packages)) {	
	$tourPlacePackMinPrice = $this->Common_model->showname_fromid("MIN(price)", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$placeid' or place_id like '$placeid,%' or place_id like '%,$placeid' or place_id like '%,$placeid,%') and status=1");
}	

?>

<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?> 
	</head>
    <body>
		<?php include("header.php"); ?>
		
        <section class="tourist-details-banner2" style="background:#da995a; padding-bottom: 30px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt-4 placebanner-details">				    
                        <h1><?php echo $place_name; ?></h1>
                        <ul class="breadcrumb">
                            <li><a href="<?php echo base_url().'state/'.$stateurl; ?>"><?php echo $statenm; ?></a></li>
                            <li><a href="<?php echo base_url().'destination/'.$stateurl.'/'.$destination_url; ?>"><?php echo $destination_name; ?></a></li>
                            <li><a href="<?php echo base_url().'places-to-visit/'.$stateurl.'/'.$destination_url; ?>">Places to Visit in <?php echo $destination_name; ?></a></li>
                            <li class="active"><?php echo $place_name; ?></li></ul>
                    </div>
                </div>
            </div>
        </section>
	

        <section class="tourdetailstop2">
            <div class="container">
                <div class="col-md-12 singletourdetails">		 	
                    <div class="row">                
                        <div class="col-md-12"> 
							<div class="iti-tourdetailsimg" style="position:relative">
								<?php 
									if(file_exists("./uploads/".$placeimg) && ($placeimg!='')) {
										$placeimg = base_url()."uploads/".$placeimg;
									}
									else 
										$placeimg = base_url()."assets/images/Jama_Masjid.jpg";
								?>
								<div style="position:relative">
							 	<img src="<?php echo $placeimg; ?>" class="img-fluid" alt="<?php echo (!empty($placealttag_banner)) ? $placealttag_banner : $place_name; ?>">	
							 		<div class="courtesy-txt"> Courtesy - Flickr </div>
								</div>
								<div class="tour2details">
									<?php
										$place_types = array();
										$show_place_types = "";
										$noof_place_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$placeid and loc_type=2"); 
										if($noof_place_types > 0)
										{										
											$place_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$placeid and a.loc_type=2 and b.status=1","b.destination_type_name asc");
											foreach ($place_type_datas as $placetype)
											{
												$place_types[] = $placetype['destination_type_name'];
											}										
										}
									?>
									<?php if(count($place_types) > 0) { ?>
									<div style="font-size:15px;"><?php echo $show_place_types = implode(" | ", $place_types); ?></div>
									<?php } ?>
									<?php if($rating > 0) { ?>
									<div class="mb-2 redstariconholder">
										<?php 
											$floorval = floor($rating);															
											$decval = $rating-$floorval; 
											$balanceint = 5-$rating;
											echo str_repeat('<i class="fas fa-star"></i>', (int) $floorval);
											echo ($decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
											echo str_repeat('<i class="far fa-star"></i>',  (int) $balanceint);
										?>
										<span class="ratingnumber" style="color:#000"><?php echo $rating; ?> / 5</span>
									</div>
									<?php } ?>
									<?php if(($entry_fee != "") || ($timing != "")) { ?>
									<ul class="itinerarylist"> 
										<?php if($timing != "") { ?>
										<li><strong>Timings : </strong><?php echo $timing; ?></li>
										<?php } ?>
										<?php if($entry_fee != "") { ?>
										<li><strong>Entry Fee : </strong> <?php echo $entry_fee; ?></li> 
										<?php } ?>
									</ul>
									<?php } ?>
								</div>
								
							</div>
                        </div>
                    </div>	
                </div>  
            </div>
        </section>

        <section class="mt70 mb70">
            <div class="container">
                <div class="row">		   
                    <div class="col-md-5">
                        <ul class="iti-summary-list inneritilist">
							<?php if($distance_from_nearest_city != "") { ?>
                            <li><img src="<?php echo base_url(); ?>assets/images/b-checkicon.png" alt="My Holiday Happiness">Distance from near by city <span><?php echo $distance_from_nearest_city; ?></span></li>
							<?php } ?>
							
							<?php if($trip_duration != "") { ?>
                            <li><img src="<?php echo base_url(); ?>assets/images/b-checkicon.png" alt="My Holiday Happiness">Trip duration (including travel in hours)<span><?php echo $trip_duration; ?></span></li>
							<?php } ?>
							
							<?php
								$noof_transportation = $this->Common_model->noof_records("transportid","tbl_place_transport","place_id=$placeid");
								if($noof_transportation>0)
								{
									$transportations = $this->Common_model->join_records("a.transportid, b.vehicle_name","tbl_place_transport as a","tbl_vehicletypes as b", "a.transport_id=b.vehicleid", "a.place_id=$placeid","b.vehicle_name asc");
									$transport_name = array();
									foreach ($transportations as $transportation)
									{
										$transport_name[] = $transportation['vehicle_name'];
									}	
									$all_transport = implode(", ", $transport_name);									
							?>
                            <li><img src="<?php echo base_url(); ?>assets/images/b-checkicon.png" alt="My Holiday Happiness">Transportation Options<span><?php echo $all_transport; ?></span></li>
							<?php } ?>
							
							<?php if($noof_place_popup_packages > 0) { ?>
							<li><img src="<?php echo base_url(); ?>assets/images/b-checkicon.png" alt="My Holiday Happiness"><a href="<?php echo base_url().'place-package/'.$place_url;  ?>" style="text-decoration:none;"><?php echo $noof_place_popup_packages; ?> package starts from <span><?php echo $this->Common_model->currency; ?> <?php echo $tourPlacePackMinPrice; ?></span></a></li>
							<?php } ?>
							
							<?php if($travel_tips != "") { ?>
							<li><img src="<?php echo base_url(); ?>assets/images/b-checkicon.png" alt="My Holiday Happiness">Travel Tips <span><?php echo $travel_tips; ?></span></li>
							<?php } ?>
							
                        </ul>
                    </div>
                    <div class="col-md-7 placedescp">
						<div class="description" id="description">
							<?php echo $about_place; ?>
						</div>						
						<a href="JavaScript:Void(0);" class="readshow" style="color:#000;text-decoration:none; border-bottom:#000 2px solid">Read more</a> 
                    </div>

                    <div class="col-md-12 mt-5">
                       <?php echo $google_map; ?>
                    </div>
                </div>  


            </div>
        </section>
        
		<?php 
			$noof_dest_places =  $this->Common_model->noof_records("placeid","tbl_places","destination_id=$destination_id and placeid!=$placeid and status=1"); 
			if($noof_dest_places > 0)
			{
		?>
        <section class="tours-in-india-bottom-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="mb-2"><?php echo $noof_dest_places; ?> places to visit & things to do in <?php echo $destination_name; ?></h2>					
                    </div>
                    <!--div class="col-md-4">
                        <select class="form-control" id="">
                            <option>Show all places</option>								
                            <option value="ALL" selected="" style="color:#009900">Show All Places</option>
                            <option value="BC">Beaches</option>
                            <option value="HH">Historical / Heritage</option>
                            <option value="HS">Hill Stations</option>
                            <option value="PL">Pilgrimage</option>
                            <option value="WF">Waterfalls</option>
                            <option value="NW">Wildlife</option>
                            <option value="TK">Adventure / Trekking</option>
                            <option value="LR">Lakes / Backwaters</option>
                            <option value="NL">Nature</option>
                            <option value="MG">Museum / Gallery</option>
                            <option value="CT">Cities</option>
                        </select>
					</div-->
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>		
		
        <div class="container mb100 tours-in-india-section">
            <div class="row">
				<?php
					$dest_places = $this->Common_model->get_records("*", "tbl_places", "destination_id=$destination_id and placeid!=$placeid and status=1","place_name asc");
					
					foreach ($dest_places as $destplace)
					{
						$dest_placeid = $destplace['placeid'];
						$dest_place_url = $destplace['place_url'];
						$dest_about_place = $destplace['about_place'];	
				?>
                <div class="col-lg-2 col-md-3 toursimgholder">
					<a href="<?php echo base_url().'place/'.$stateurl.'/'.$destination_url.'/'.$dest_place_url; ?>">
						<img src="<?php echo base_url()."uploads/".$destplace['placethumbimg']; ?>" class="img-fluid" alt="<?php echo (!empty($destplace['alttag_thumb'])) ? $destplace['alttag_thumb'] : $destplace['place_name']; ?>"/>
					</a>
                    <h5 class="overlaybacktxt"><?php echo $destplace['place_name']; ?></h5>		
                    <div class="overlay">
                        <div class="package-tour-title">					
                            <a href="<?php echo base_url().'place/'.$stateurl.'/'.$destination_url.'/'.$dest_place_url; ?>" class="viewbtn">View details</a>
                        </div>					
                    </div>
                </div>   			
                <?php } ?>
				<div class="clearfix"></div>
            </div> 
        </div>
        <?php } ?>	
		
		<?php				
			$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$placeid' or place_id like '$placeid,%' or place_id like '%,$placeid' or place_id like '%,$placeid,%') and status=1","");	
			
			//echo $this->db->last_query();
			
			if(!empty($tour_packages)) {					
		?>
        <section class="tourpackage-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <h2>Popular <?php echo $place_name; ?> Tour Packages</h2>
                    </div>
                    <div class="col-md-5 mb-4">
                        <?php echo form_open(base_url('place'), array( 'id' => 'search_form', 'name' => 'search_form', 'class' => 'row listform'));?>
							<div class="col-lg-6 col-md-12">
								<div class="form-group">
									<select class="selectpicker" name="starting_city" id="starting_city">
										<option value="">Select Starting City</option>
										<?php
											$destination_qry = $this->db->query("SELECT destination_id, destination_name FROM tbl_destination WHERE status=1 and destination_id in (select distinct(starting_city) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$placeid' or place_id like '$placeid,%' or place_id like '%,$placeid' or place_id like '%,$placeid,%') and status=1) ORDER BY destination_name asc");
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
											$durations_qry = $this->db->query("SELECT durationid, duration_name FROM tbl_package_duration WHERE status=1 and durationid in (select distinct(package_duration) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$placeid' or place_id like '$placeid,%' or place_id like '%,$placeid' or place_id like '%,$placeid,%') and status= 1) ORDER BY no_ofdays asc");
											$durations = $durations_qry->result_array();
											foreach($durations as $duration)
											{
										?>
										<option value="<?php echo $duration['durationid']; ?>"><?php echo $duration["duration_name"]; ?></option>
										<?php  
											}
										?>
									</select>
									<input type="hidden" name="placeid" id="placeid" value="<?php echo $placeid; ?>">
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
					foreach ($tour_packages as $tour_package)
					{
						$tourpackageid = $tour_package["tourpackageid"];
						$tpackage_name = $tour_package["tpackage_name"];
						$tpackage_url = $tour_package["tpackage_url"];
						
						$package_duration = $tour_package["package_duration"];
						$show_duration = $this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid ='$package_duration'");
						
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
						
						if($noof_assoc_dest > 0)
						{	
							$assoc_dests_arr = array();
							
							$assoc_dests = $this->Common_model->join_records("a.itinerary_destinationid, b.destination_name","tbl_itinerary_destination as a","tbl_destination as b", "a.destination_id=b.destination_id", "a.itinerary_id=$itinerary","a.itinerary_destinationid asc");
							
							foreach ($assoc_dests as $assoc_dest)
							{
								$assoc_dests_arr[] = $assoc_dest['destination_name'];
							}
							$show_assoc_dests =  implode(" - ", $assoc_dests_arr);
						}				
				?>				
					<div class="col-lg-3 col-md-6  touristlist-box">
						<div class="touristdetails-imgholder">
							<?php 
								if (!empty($pack_type)) 
								{ 
									$class = ($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon' ; 
							?> 
								<div class="<?php echo $class ; ?>">
									<span><?php echo $this->Common_model->showname_fromid("par_value","tbl_parameters","parid ='$pack_type' and param_type = 'PT' "); ?></span>
								</div>								
							<?php } ?>
							
							<a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="My Holiday Happiness"></a>							
							<?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
							<div class="tourist-duration"> <?php echo $show_duration; ?> </div>
						</div>
						<div class="tourist-bottom-details">
							<ul class="iconlist">									
								<?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation"></li><?php endif; ?>
								<?php if($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li><?php endif; ?>
								<?php if($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li><?php endif; ?>	
								<?php if($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li><?php endif; ?>
								<?php if($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li><?php endif; ?>
							</ul>
							<div class="touristlist-hdng "><?php echo $tpackage_name; ?> </div>
							<div class="tourbutton "> <span><a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></span></div>
							<div class="tourprice "><span class="packageCostOrig " style="text-decoration: line-through; color: #A0A0A0; font-size:14px "><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span></div>
							<div class="clearfix "></div>
						</div>
					</div>                
                <?php } ?>               
            </div>
        </div>
		
		<?php } ?>	
		
		<?php 		
			if(!empty($noof_place_popup_packages)) {						
	    ?>
        <div id="myModal" class="modal fade ">
            <div class="modal-dialog formmodal">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close modalclosebtn" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="col-md-12"><h4 class="modal-title">Planning a Trip to <?php echo $place_name ?> ?</h4>
                            <h5><a href="<?php echo base_url().'place-package/'.$place_url;  ?>" class="modalsubtxt" target="_blank"><?php echo $noof_place_popup_packages .' '. $place_name ?> Tours from <?php echo $this->Common_model->currency; ?><?php echo $tourPlacePackMinPrice; ?> </a></h5>
                            <div><a href="<?php echo base_url().'place-package/'.$place_url;  ?>" class="viwebtn viewbtn2" target="_blank">Explore & Book Online</a></div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

	<?php include("footer.php"); ?>  
		<script>                     
            $(document).ready(function () {
                $("#myModal").modal('show');
            });
			
			$(document).ready(function () {
                $(".readshow").click(function () {					
					var readval = $(".readshow").html();
					if(readval=="Read more")
					{
						$("#description").addClass("redescription");
						$("#description").removeClass("description");
						$(".readshow").html("Read less");
					}
					else 
					{
						$("#description").addClass("description");
						$("#description").removeClass("redescription");
						$(".readshow").html("Read more");
					}
                });
            });
        </script>
		<!--script src="https://code.jquery.com/jquery-1.9.1.min.js"></script-->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/slick.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
		
		<script>
            $(function () {
                $('.selectpicker').selectpicker();
            }); 
        </script>
		
		<script>
			$(document).on('change', '#starting_city, #trip_duration', function(){	
				//alert("hi");
				$.ajax({
					url: "<?php echo base_url(); ?>place/search",
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
    </body>
</html>
