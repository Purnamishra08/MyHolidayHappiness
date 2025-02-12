<?php
if (!empty($destinm)) {
    foreach ($destinm as $desti) {
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

        $state_data = $this->Common_model->get_records("state_name, state_url", "tbl_state", "state_id='$state_id'");
        foreach ($state_data as $state) {
            $statenm = $state['state_name'];
            $stateurl = $state['state_url'];
        }

        $noof_places_in_destination = $this->Common_model->noof_records("placeid", "tbl_places", "destination_id='$destination_id' and status='1'");
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
            if (file_exists("./uploads/" . $destiimg) && ($destiimg != '')) {
                $destiimg = base_url() . "uploads/" . $destiimg;
            } else
                $destiimg = base_url() . "assets/images/delhicity.jpg";
            ?>
            <img src="<?php echo $destiimg; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_banner)) ? $alttag_banner : $destiname; ?>">
			<div class="courtesy-txt"> Courtesy - Flickr </div>
        </section>

        <section class="">
            <div class="container">
                 <ul class="cbreadcrumb my-4">
                 
                      <li><a href="/">Home</a></li>
                      <li><a href="/destinations">Destinations</a></li>
                      <li><a href="#"><?php echo $destiname; ?></a></li>
                    </ul>
                <div class="row">
                    <div class="col-lg-4 col-md-5" style="padding-right:22px">
                        <?php include("destination_sidebar.php"); ?> 
                    </div>
                    <div class="col-lg-8 col-md-7 inner-rightcontent" id="profile">
                        <h1 class="mb-2 bluefont" ><?php echo $destiname; ?> Overview</h1>

                        <ul class="placelist">
                            <?php if ($trip_duration != "") { ?>
                                <li>Ideal Trip Duration: <span><?php echo $trip_duration; ?></span></li>
                            <?php } ?>
                            <?php if ($nearest_city != "") { ?>
                                <li>Nearest City <?php echo $destiname; ?>: <span><?php echo $nearest_city; ?></span></li>
                            <?php } ?>
                            <?php if ($visit_time != "") { ?>
                                <li>Best Time to Visit <?php echo $destiname; ?>: <span><?php echo $visit_time; ?></span></li>
                            <?php } ?>
                            <?php if ($peak_season != "") { ?>
                                <li>Peak Season: <span><?php echo $peak_season; ?></span></li>
                            <?php } ?>
                            <?php if ($weather_info != "") { ?>
                                <li>Weather Info: <span><?php echo $weather_info; ?></span></li>
                            <?php } ?>
                            <li>State: <span><?php echo $statenm; ?></span></li>
                        </ul>

                        <div class="placedescp mb-4">
                            <div class="description" id="description">
                                <?php echo $about_destination; ?>
                            </div>							

                            <a href="JavaScript:Void(0);" class="readshow" style="color:#000;text-decoration:none; border-bottom:#000 2px solid">Read more</a> 

                            <div class="shareicons mt-3">
                                <i class="pe-7s-share" style="font-weight: 600"></i>Share
                                <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url() . 'destination/' . $stateurl . '/' . $destination_url; ?>" target="_blank" class=""><i class="fab fa-facebook-f"></i></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url() . 'destination/' . $stateurl . '/' . $destination_url; ?>" target="_blank" class=""> <i class="fab fa-linkedin-in"></i></a>
                                <a href="https://plus.google.com/share?url=<?php echo base_url() . 'destination/' . $stateurl . '/' . $destination_url; ?>" target="_blank" class=""><i class="fab fa-google-plus-g"></i></a>
                                <a href="https://twitter.com/share?url=<?php echo base_url() . 'destination/' . $stateurl . '/' . $destination_url; ?>" target="_blank" class=""><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>

                        <?php
                        $noof_dest_places = $this->Common_model->noof_records("placeid", "tbl_places", "destination_id=$destination_id and status=1");
                        if ($noof_dest_places > 0) {
                            $destlimit = 4;
                            $showdestlimit = ($destlimit > $noof_dest_places) ? $noof_dest_places : $destlimit;
                            ?>
                            <h2 class="mt-5 mb-3" style="background: #4679a1; color: #fff; padding: 5px 15px; font-size: 24px;">Top <?php echo $showdestlimit; ?> Places to Visit in <?php echo $destiname; ?></h2>
                            <div class="row">
                                <?php
                                $count = 1;
                                $dest_places = $this->Common_model->get_records("*", "tbl_places", "destination_id=$destination_id and status=1", "place_name asc", "$showdestlimit");

                                foreach ($dest_places as $destplace) {
                                    $dest_placeid = $destplace['placeid'];
                                    $dest_place_url = $destplace['place_url'];
                                    $dest_about_place = $destplace['about_place'];

                                    $place_types = array();
                                    $show_place_types = "";
                                    $noof_place_types = $this->Common_model->noof_records("multdest_id", "tbl_multdest_type", "loc_id=$dest_placeid and loc_type=2");
                                    if ($noof_place_types > 0) {
                                        $place_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name", "tbl_multdest_type as a", "tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$dest_placeid and a.loc_type=2 and b.status=1", "b.destination_type_name asc");
                                        foreach ($place_type_datas as $placetype) {
                                            $place_types[] = $placetype['destination_type_name'];
                                        }
                                    }

                                    if (count($place_types) > 0) {
                                        $show_place_types = implode(" | ", $place_types);
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <div class="placebox">                                 
                                            <div class="placeimg-holder">
                                                <a href="<?php echo base_url() . 'place/' . $stateurl . '/' . $destination_url . '/' . $dest_place_url; ?>" target="_blank">
                                                    <img src="<?php echo base_url() . "uploads/" . $destplace['placethumbimg']; ?>" class="img-fluid" alt="<?php echo (!empty($destplace['alttag_thumb'])) ? $destplace['alttag_thumb'] : $destplace['place_name']; ?>"/>
                                                </a>
                                                <?php if ($show_place_types != "") { ?><span class="placetaglist"><?php echo $show_place_types; ?></span><?php } ?>
                                            </div>
                                            <div class="mt-2 placeheading"><?php echo $destplace['place_name']; ?></div>
                                            <!--h6>#1 of 34 Places to Visit in Delhi City</h6-->
                                            <p><?php echo $this->Common_model->short_str("$dest_about_place", "85"); ?></p>
                                            <a href="<?php echo base_url() . 'place/' . $stateurl . '/' . $destination_url . '/' . $dest_place_url; ?>" class="viwebtn" target="_blank">View details</a>
                                        </div>
                                    </div>														
                                    <?php if ($count % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>

                                    <?php
                                    $count++;
                                }
                                ?>

                                <?php if ($noof_dest_places > $destlimit) { ?>
                                    <a href="<?php echo base_url() . 'places-to-visit/' . $stateurl . '/' . $destination_url; ?>" class="blockbtn">View all <?php echo $noof_dest_places; ?> places in <?php echo $destiname; ?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <div class="mobile-view">

                            <?php
                            $noof_near_places = $this->Common_model->noof_records("a.dest_placeid", "tbl_destination_places as a, tbl_destination as b", "a.simdest_id=b.destination_id and a.destination_id=$destination_id and a.type=2 and b.status=1");
                            if ($noof_near_places > 0) {
                                ?>
                                <div class="thumbplaces">
                                    <h5 class="mt-5 mb-2">Near by places</h5>
                                    <div class="row">
                                        <?php
                                        $count = 1;
                                        $near_places = $this->Common_model->join_records("a.*, b.destination_url, b.destination_name, b.destiimg_thumb, b.alttag_thumb, b.state", "tbl_destination_places as a", "tbl_destination as b", "a.simdest_id=b.destination_id", "a.destination_id=$destination_id and a.type=2 and b.status=1", "b.destination_name asc");
                                        foreach ($near_places as $nearplace) {
                                            $place_destinationurl = $nearplace['destination_url'];
                                            $place_stateid = $nearplace['state'];
                                            $alttag_thumb = $nearplace['alttag_thumb'];
                                            $place_state_url = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$place_stateid'");
                                            ?>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 nearplacesbox">
                                                <a href="<?php echo base_url() . 'destination/' . $place_state_url . '/' . $place_destinationurl; ?>" target="_blank"> 
                                                    <div class="thumbimgholder">
                                                        <img src="<?php echo base_url() . "uploads/" . $nearplace['destiimg_thumb']; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : $nearplace['destination_name']; ?>">
                                                        <div class="thumbheadingname"><?php echo $nearplace['destination_name']; ?></div>
                                                    </div>                                            
                                                </a>
                                            </div>
                                            <?php if ($count % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>
                                            <?php
                                            $count++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php
                            $noof_similar_dest = $this->Common_model->noof_records("a.dest_placeid", "tbl_destination_places as a, tbl_destination as b", "a.simdest_id=b.destination_id and a.destination_id=$destination_id and a.type=1 and b.status=1");
                            if ($noof_similar_dest > 0) {
                                ?>
                                <div class="thumbplaces">
                                    <h5 class="mt-5 mb-2">Similar destinations</h5>
                                    <div class="row">
                                        <?php
                                        $count1 = 1;
                                        $similar_dests = $this->Common_model->join_records("a.*, b.destination_url, b.destination_name, b.destiimg_thumb, b.alttag_thumb, b.state", "tbl_destination_places as a", "tbl_destination as b", "a.simdest_id=b.destination_id", "a.destination_id=$destination_id and a.type=1 and b.status=1", "b.destination_name asc");

                                        foreach ($similar_dests as $similardest) {
                                            $dest_destinationurl = $similardest['destination_url'];
                                            $dest_stateid = $similardest['state'];
                                            $salttag_thumb = $similardest['alttag_thumb'];
                                            $dest_state_url = $this->Common_model->showname_fromid("state_url", "tbl_state", "state_id ='$dest_stateid'");
                                            ?>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 nearplacesbox">
                                                <a href="<?php echo base_url() . 'destination/' . $dest_state_url . '/' . $dest_destinationurl; ?>" target="_blank"> 
                                                    <div class="thumbimgholder">
                                                        <img src="<?php echo base_url() . "uploads/" . $similardest['destiimg_thumb']; ?>" class="img-fluid" alt="<?php echo (!empty($salttag_thumb)) ? $salttag_thumb : $similardest['destination_name']; ?>">
                                                        <div class="thumbheadingname"><?php echo $similardest['destination_name']; ?></div>
                                                    </div>                                            
                                                </a>
                                            </div> 

                                            <?php if ($count1 % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>
                                            <?php
                                            $count1++;
                                        }
                                        ?>		
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="rightbookingbox">
                                <h3>Get our assistance for easy booking</h3>
                                <a href="<?php echo base_url().'contactus#contactform'; ?>" target="_blank"><span class="cullusbtn">Want us to call you?</span></a>
                                <p>Or call us at</p>
                                <h5> <?php echo $this->Common_model->show_parameter(3); ?> </h5>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <?php		
		$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status= 1","");
        if (!empty($tour_packages)) {
            ?>
            <section class="tourpackage-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 mb-4">
                            <h2 style="font-size: 22px;">Most Popular <?php echo $destiname; ?> Tour Packages</h2>
                        </div>
                        <div class="col-md-5 mb-4">
							<?php echo form_open(base_url('destination'), array( 'id' => 'search_form', 'name' => 'search_form', 'class' => 'row listform'));?>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <select class="selectpicker" name="starting_city" id="starting_city">
											<option value="">Select Starting City</option>
											<?php
												$destination_qry = $this->db->query("SELECT destination_id, destination_name FROM tbl_destination WHERE status=1 and destination_id in (select distinct(starting_city) from tbl_tourpackages where itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status= 1) ORDER BY destination_name asc");
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
                                    <?php if ($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation" width="24" height="24"></li><?php endif; ?>
                                    <?php if ($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation" width="24" height="24"></li><?php endif; ?>
                                    <?php if ($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing" width="24" height="24"></li><?php endif; ?>	
                                    <?php if ($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast" width="24" height="24"></li><?php endif; ?>
                                    <?php if ($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle" width="24" height="24"></li><?php endif; ?>
                                </ul>
                                <div class="touristlist-hdng "><?php echo $tpackage_name; ?></div>
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
                            <div class="col-md-12">
                                <h4 class="modal-title">Planning a Trip to <?php echo $destiname; ?> ?</h4>						   
                                <h5><a href="<?php echo base_url() . 'destination-package/' . $destination_url; ?>" class="modalsubtxt" target="_blank"><?php echo $noof_popup_packages . ' ' . $destiname; ?> Tours from <?php echo $this->Common_model->currency; ?><?php echo $tourPackMinPrice; ?></a></h5>
                                <div>
                                <a href="<?php echo base_url().'destination-package/'. $destination_url; ?>" class="viwebtn viewbtn2" target="_blank"> Explore & Book Online</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>			
        <?php } ?>

        <?php include("footer.php"); ?>      
        <script>
            $(document).ready(function () {
                $("#myModal ").modal('show');
            });

            $(document).ready(function () {
                $(".readshow").click(function () {
                    var readval = $(".readshow").html();
                    if (readval == "Read more")
                    {
                        $("#description").addClass("redescription");
                        $("#description").removeClass("description");
                        $(".readshow").html("Read less");
                    } else
                    {
                        $("#description").addClass("description");
                        $("#description").removeClass("redescription");
                        $(".readshow").html("Read more");
                    }
                });
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script>
            $(function () {
                $('.selectpicker').selectpicker();
            });
            
			$("#pscroll").click(function() {
				$([document.documentElement, document.body]).animate({
					scrollTop: $("#profile").offset().top -100
				}, 1000);
			});
        </script>    
		
		<script>
			$(document).on('change', '#starting_city, #trip_duration', function(){	
				//alert("hi");
				$.ajax({
					url: "<?php echo base_url(); ?>destination/search",
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
