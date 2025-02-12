<?php
if(!empty($destinm)){
    foreach ($destinm as $desti)
    {
        $destination_id = $desti['destination_id'];
        $destiname = $desti['destination_name'];
        $destination_url = $desti['destination_url'];
        $about_destination = $desti['about_destination'];
		$destiimg = $desti['destiimg'];
		$alttag_banner = $desti['alttag_banner'];
		
        $trip_duration = $desti['trip_duration'];
        $nearest_city = $desti['nearest_city'];
        $visit_time = $desti['visit_time'];
        $peak_season = $desti['peak_season'];
        $weather_info = $desti['weather_info'];
		
		$google_map = $desti['google_map'];
		
        $internet_availability = $desti['internet_availability'];
        $std_code = $desti['std_code'];
        $language_spoken = $desti['language_spoken'];
        $major_festivals = $desti['major_festivals'];
        $note_tips = $desti['note_tips']; 
		
        $state_id = $desti['state'];
		
		$state_data=$this->Common_model->get_records("state_name, state_url","tbl_state","state_id='$state_id'");
		foreach($state_data as $state)
		{
			$statenm= $state['state_name']; 
			$stateurl = $state['state_url'];
		}
		
		$places_visit_desc = $desti['places_visit_desc'];

		$noof_places_in_destination =  $this->Common_model->noof_records("placeid","tbl_places","destination_id='$destination_id' and status='1'");
    } 
}
/* * ***********Pop package information************** */
$noof_popup_packages = $this->Common_model->noof_records("DISTINCT(tourpackageid) as package_id", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status=1");

if (!empty($noof_popup_packages)) {	
	$tourPackMinPrice = $this->Common_model->showname_fromid("MIN(price)", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status=1");
}
?>
<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?> 
	</head>
    <body>	
	
		<?php include("header.php"); ?> 
		
		<section class="bannerdesti">
			<?php 
				if(file_exists("./uploads/".$destiimg) && ($destiimg!='')) {
					$destiimg = base_url()."uploads/".$destiimg;
				}
				else 
					$destiimg = base_url()."assets/images/delhicity.jpg";
			?>
			<img src="<?php echo $destiimg; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_banner)) ? $alttag_banner : $destiname; ?>">
		</section>

        <section class="">
            <div class="container">
                 <ul class="cbreadcrumb my-4">
                 
                      <li><a href="/">Home</a></li>
                       <li><a href="/destinations">Destinations</a></li>
                      <li><a href="<?php echo base_url() . 'destination/' . $stateurl . '/' . $destination_url; ?>"><?php echo $destiname; ?></a></li>
                      <li><a href="#" data-id="<?php echo $destination_id; ?>">Places to visit in <?php echo $destiname; ?></a></li>
                    </ul>
                <div class="row">
                    <div class="col-lg-4 col-md-6" style="padding-right:22px">
                        <?php include("destination_sidebar.php"); ?> 
					</div>
                    <div class="col-lg-8 col-md-6 inner-rightcontent">   
						<?php 
							$noof_dest_places =  $this->Common_model->noof_records("placeid","tbl_places","destination_id=$destination_id and status=1"); 
							if($noof_dest_places > 0)
							{								
						?>
						<div class="row mb-4">
                            <div class="col-lg-8 col-md-12">
								<h1 class="mb-2 bluefont" style="font-size: 24px;">Top <?php echo $noof_dest_places; ?> places to visit in <?php echo $destiname; ?></h1>
							</div>
                            <div class="col-lg-4 col-md-12">
								<div class="btn-group">									
									<a href="javascript:void(0)" id="list" class="btn btn-default btn-sm"><i class="pe-7s-menu"></i>List View</a>
									<a href="javascript:void(0)" id="grid" class="btn btn-default btn-sm"><i class="pe-7s-map-marker"></i>Map View</a>
                                </div>
							</div>
                        </div>
						<?php echo form_open(base_url('places_to_visit'), array( 'id' => 'place_form', 'name' => 'place_form', 'class' => 'row listform'));?>
                            <div class="col-lg-4" id="search_div">
                                <div class="form-group">
                                    <select class="selectpicker" name="place_type" id="place_type">
                                        <option value="">Select Place Type</option>
										<?php
											$place_type_qry = $this->db->query("SELECT DISTINCT(a.loc_type_id) as dist_type_id, b.destination_type_name FROM tbl_multdest_type as a JOIN tbl_destination_type as b ON a.loc_type_id=b.destination_type_id WHERE a.loc_id in (SELECT placeid from tbl_places where destination_id=$destination_id and status=1) and a.loc_type = 2 and b.status = 1 ORDER BY b.destination_type_name asc");
											$place_type_res = $place_type_qry->result_array();
											foreach($place_type_res as $place_type_data)
											{
										?>
										<option value="<?php echo $place_type_data['dist_type_id']; ?>"><?php echo $place_type_data["destination_type_name"]; ?></option>
										<?php  
											}
										?>
                                    </select>
									<input type="hidden" name="destination_id" id="destination_id" value="<?php echo $destination_id; ?>">
                                </div>
                            </div>
                            
                        <?php echo form_close();?>
                        <div class="row" id="place_result">
							<div id="place_loader"></div>
							<?php
								$count = 1;
								$dest_places = $this->Common_model->get_records("*", "tbl_places", "destination_id=$destination_id and status=1","place_name asc");
								
								foreach ($dest_places as $destplace)
								{
									$dest_placeid = $destplace['placeid'];
									$dest_place_url = $destplace['place_url'];
									$dest_about_place = $destplace['about_place'];
									
									$place_types = array();
									$show_place_types = "";
									$noof_place_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$dest_placeid and loc_type=2"); 
									if($noof_place_types > 0)
									{										
										$place_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$dest_placeid and a.loc_type=2 and b.status=1","b.destination_type_name asc");
										//$this->db->last_query();
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
                                <div class="placebox">                                 
                                    <div class="placeimg-holder">
                                        <a href="<?php echo base_url().'place/'.$stateurl.'/'.$destination_url.'/'.$dest_place_url; ?>">
											<img src="<?php echo base_url()."uploads/".$destplace['placethumbimg']; ?>" class="img-fluid" alt="<?php echo (!empty($destplace['alttag_thumb'])) ? $destplace['alttag_thumb'] : $destplace['place_name']; ?>"/>
										</a>
                                        <?php if($show_place_types !="") { ?><span class="placetaglist"><?php echo $show_place_types; ?></span><?php } ?>
                                    </div>
                                    <div class="mt-2 placeheading"><?php echo $destplace['place_name']; ?></div>
                                    <p><?php echo $this->Common_model->short_str("$dest_about_place", "85"); ?></p>
                                    <a href="<?php echo base_url().'place/'.$stateurl.'/'.$destination_url.'/'.$dest_place_url; ?>" class="viwebtn">View details</a>
                                </div>
                            </div>														
							<?php if ($count % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>							
							<?php $count++; } ?>
                        </div>
						
						<div id="map" style="height:500px; display:none;"></div>
						<?php }else { ?>
							<h4 class="mb-2 bluefont">No places added to the Destination !</h4>
						<?php } ?>
					</div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>
		
		<?php if(!empty($places_visit_desc)) { ?>
		<section class="mt20 mb100">
			<div class="container">
				<div class="aboutdesc" style="padding-top: 15px;">
					<div class="sb-container" style="max-height: 50px;" id="description">
						<?php echo $places_visit_desc; ?>
					</div>						
					<a href="JavaScript:void(0);" class="readshow" style="text-decoration: none;">Read more</a> 
				</div>
			</div>
		</section>
		<?php } ?>

        <?php		
		$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and `status` = 1","");
        if (!empty($tour_packages)) {
		?>
            <section class="tourpackage-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 mb-4">
                            <h2 style="font-size: 22px;">Most Popular <?php echo $destiname; ?> Tour Packages</h2>
                        </div>
                        <div class="col-md-5 mb-4">
							<?php echo form_open(base_url('places_to_visit'), array( 'id' => 'search_form', 'name' => 'search_form', 'class' => 'row listform'));?>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <select class="selectpicker" name="starting_city" id="starting_city">
											<option value="">Select Starting City</option>
											<?php
												$destination_qry = $this->db->query("SELECT destination_id, destination_name FROM tbl_destination WHERE status=1 and destination_id in (select distinct(starting_city) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status=1) ORDER BY destination_name asc");
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
												$durations_qry = $this->db->query("SELECT durationid, duration_name FROM tbl_package_duration WHERE status=1 and durationid in (select distinct(package_duration) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status= 1) ORDER BY no_ofdays asc");
												$durations = $durations_qry->result_array();
												foreach($durations as $duration)
												{
											?>
											<option value="<?php echo $duration['durationid']; ?>"><?php echo $duration["duration_name"]; ?></option>
											<?php  
												}
											?>
										</select>
										<input type="hidden" name="destination_id" id="destination_id" value="<?php echo $destination_id; ?>">
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
                        $alttag_thumb = $tour_package["alttag_thumb"];

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

                                <a href="<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank"><img src="<?php echo base_url() . 'uploads/' . $tour_thumb; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : "My Holiday Happiness"; ?>"></a>

                                <?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
                                <div class="tourist-duration"> <?php echo $show_duration; ?> </div>
                            </div>
                            <div class="tourist-bottom-details">
                                <ul class="iconlist">									
                                    <?php if ($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation" width="24" height="24"></li><?php endif; ?>
                                    <?php if ($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation" width="24" height="24"></li><?php endif; ?>
                                    <?php if ($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing" width="24" height="24"></li><?php endif; ?>	
                                    <?php if ($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast width="24" height="24""></li><?php endif; ?>
                                    <?php if ($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle" width="24" height="24"></li><?php endif; ?>
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
        <?php } ?>	
		
		
		<?php if (!empty($noof_popup_packages)) { ?>
			<div id="myModal" class="modal fade ">
				<div class="modal-dialog formmodal">
					<div class="modal-content">
						<div class="modal-header text-center">
							<button type="button" class="close modalclosebtn" data-dismiss="modal" aria-hidden="true">&times;</button>
							<div class="col-md-12"><h4 class="modal-title">Planning a Trip to <?php echo $destiname; ?>?</h4>
								<h5><a href="<?php echo base_url() . 'destination-package/' . $destination_url; ?>" class="modalsubtxt" target="_blank"><?php echo $noof_popup_packages . ' ' . $destiname; ?> Tours from <?php echo $this->Common_model->currency; ?><?php echo $tourPackMinPrice; ?></a></h5>
								<div><a href="<?php echo base_url().'destination-package/'.$destination_url; ?>" class="viwebtn viewbtn2" target="_blank">Explore & Book Online</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		<?php } ?>
		
		<?php include("footer.php"); ?>  
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js "></script>
        <script src="<?php echo base_url(); ?>assets/js/slick.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js "></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scrollBar.js"></script>
		
		<script>
            $(function () {
                $('.selectpicker').selectpicker();
            });
            $(document).ready(function () {
                $("#myModal ").modal('show');
            });
			
			$(function () {
                $("#list").click(function () {
					$("#place_result").show();
					$("#search_div").show();					
					$("#map").hide();
				});
				
				$("#grid").click(function () {
					$("#map").show();
					$("#place_result").hide();
					$("#search_div").hide();
				});
            });
			
			$(function () {
                $(".readshow").click(function () {					
					var readval = $(".readshow").html();
					if(readval=="Read more")
					{
						$("#description").css({"max-height":"100px"});
						$("#description .sb-content").css({"max-height":"100px"});
						$(".readshow").html("Read less");
					}
					else 
					{
						$("#description").css({"max-height":"25px"});
						$("#description .sb-content").css({"max-height":"25px"});
						$(".readshow").html("Read more");
					}
                });
            });
			$(".sb-container").scrollBox();
        </script>
		
		<script>
            $('.sub-menu ul').hide();
            $(".sub-menu a").click(function () {
                $(this).parent(".sub-menu").children("ul").slideToggle("100");
                $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
            });
        </script>
		
		<script>
			$(document).on('change', '#place_type', function(){	
				//alert("hi");
				$.ajax({
					url: "<?php echo base_url(); ?>places_to_visit/placesearch",
					type: 'post',
					//dataType: "json",
					//cache: false,
					//processData: false,
					data: $('#place_form').serialize(),
					beforeSend: function () {                       
						$('#place_result').addClass('loder-bg');
						$('#place_loader').addClass('loder-gif');
						$("#place_loader").html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
					},  
					success: function(result) {
						$('#place_result').html(result);
						$("#place_loader").html('');
						$('#place_result').removeClass('loder-bg');
						$('#place_loader').removeClass('loder-gif');								
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
					}
				});
			})
		</script>
		
		<script>
			$(document).on('change', '#starting_city, #trip_duration', function(){	
				//alert("hi");
				$.ajax({
					url: "<?php echo base_url(); ?>places_to_visit/search",
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
			if($noof_dest_places > 0)
			{		
				$starting_latitude = $this->Common_model->showname_fromid("latitude", "tbl_destination", "destination_id ='$destination_id'");
				$starting_longitude = $this->Common_model->showname_fromid("longitude", "tbl_destination", "destination_id ='$destination_id'");
		?>
		<script>
			function initMap() {
			
				var map = new google.maps.Map(document.getElementById('map'), {
				  center: new google.maps.LatLng(<?php echo $starting_latitude; ?>, <?php echo $starting_longitude; ?>),
				  zoom: 10
				});
				
				var infoWindow = new google.maps.InfoWindow;

				// Change this depending on the name of your PHP or XML file
				downloadUrl('<?php echo base_url(); ?>mapmarkers/places/<?php echo $destination_id; ?>', function(data) {
					var xml = data.responseXML;
					//alert(xml);
					var markers = xml.documentElement.getElementsByTagName('marker');
					Array.prototype.forEach.call(markers, function(markerElem) {
						var id = markerElem.getAttribute('id');
						var name = markerElem.getAttribute('name');
						var placeurl = markerElem.getAttribute('placeurl');
						var point = new google.maps.LatLng(
							parseFloat(markerElem.getAttribute('lat')),
							parseFloat(markerElem.getAttribute('lng')));
						var marker = new google.maps.Marker({
							map: map,
							position: point,
							label: {
								text: name,
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