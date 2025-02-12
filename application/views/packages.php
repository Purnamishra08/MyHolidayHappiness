<?php
if (!empty($package_data)) {
    foreach ($package_data as $packagedata) {
        $tourpackageid = $packagedata["tourpackageid"];
        $tpackage_name = $packagedata["tpackage_name"];
        $tpackage_url = $packagedata["tpackage_url"];

        $package_duration = $packagedata["package_duration"];
        $show_duration = $this->Common_model->showname_fromid("duration_name", "tbl_package_duration", "durationid ='$package_duration'");

        $package_price = $packagedata["price"];
        $package_fakeprice = $packagedata["fakeprice"];
        $inclusion_exclusion = $packagedata["inclusion_exclusion"];

        $tpackage_image = $packagedata["tpackage_image"];
        $tour_thumb = $packagedata["tour_thumb"];
        $alttag_banner = $packagedata["alttag_banner"];
        $alttag_thumb = $packagedata["alttag_thumb"];
        $ratings = $packagedata["ratings"];
        $itinerary_note = $packagedata["itinerary_note"];

        $accomodation = $packagedata["accomodation"];
        $tourtransport = $packagedata["tourtransport"];
        $sightseeing = $packagedata["sightseeing"];
        $breakfast = $packagedata["breakfast"];
        $waterbottle = $packagedata["waterbottle"];
        
		
		$show_video_itinerary = $packagedata['show_video_itinerary'];
		$video_itinerary_link = $packagedata['video_itinerary_link'];
		
        $package_startingcity = $packagedata["starting_city"];
        $package_startingcity_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id=$package_startingcity");

        $itinerary = $packagedata["itinerary"];
        $noof_assoc_dest = $this->Common_model->noof_records("a.itinerary_destinationid", "tbl_itinerary_destination as a, tbl_destination as b", "a.destination_id=b.destination_id and a.itinerary_id=$itinerary");

        if ($noof_assoc_dest > 0) {
            $assoc_dests_arr = array();
            $assoc_dests = $this->Common_model->join_records("a.itinerary_destinationid, b.destination_name", "tbl_itinerary_destination as a", "tbl_destination as b", "a.destination_id=b.destination_id", "a.itinerary_id=$itinerary", "a.itinerary_destinationid asc");

            foreach ($assoc_dests as $assoc_dest) {
                $assoc_dests_arr[] = $assoc_dest['destination_name'];
            }
            $show_assoc_dests = implode(" - ", $assoc_dests_arr);
        }
    }

    $noof_vehicle = $this->Common_model->noof_records("a.priceid", "tbl_vehicleprices as a, tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid and a.destination='$package_startingcity' and a.status=1");

    $max_vehicle_capacity = 0;
    if ($noof_vehicle > 0) {
        $max_vehicle_capacity = $this->Common_model->showname_fromid("max(b.capacity)", "tbl_vehicleprices as a, tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid and a.destination=$package_startingcity and a.status=1");
    }

    $accommodation_types = $this->Common_model->join_records("DISTINCT(a.hotel_type) as hotel_type_id", "tbl_hotel as a", "tbl_hotel_type as b", "a.hotel_type=b.hotel_type_id", "a.status=1 and a.destination_name in ( select destination_id from tbl_package_accomodation where package_id=$tourpackageid)", "b.hotel_type_name desc");

    $hotel_typeids = array();
    if (!empty($accommodation_types)) {
        foreach ($accommodation_types as $accommodation_type) {
            $hotel_typeids[] = $accommodation_type["hotel_type_id"];
        }
        $hotel_typeid = implode(", ", $hotel_typeids);
        $first_hoteltype = $hotel_typeids[0];
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
        <style>
            .sign-up-sec{
                height:360px;
            }
        </style>
        <?php include("header.php"); ?> 
        <section class="tourist-details-banner">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-8 mt-4">

                        <?php if ($package_startingcity != ""): ?>
                        <span style="font-size:18px; color:white;">Ex-<?php echo $package_startingcity_name; ?></span>

                        <?php endif; ?>
                        <h1><?php echo $tpackage_name; ?> <?php /*if ($noof_assoc_dest > 0): ?>| <?php echo $show_assoc_dests; ?><?php endif;*/ ?></h1>
                        <?php
                        $floorval = floor($ratings);
                        $decval = $ratings - $floorval;
                        $balanceint = 5 - $ratings;
                        echo str_repeat('<i class="fas fa-star"></i>',(int) $floorval);
                        echo ($decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
                        echo str_repeat('<i class="far fa-star"></i>',(int) $balanceint);
                        ?>
                        <span class="ratingnumber"><?php echo $ratings; ?> / 5</span>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="tourimgtop-details">
                            <div>
                                <span class="packageCostOrig" style="text-decoration: line-through; color:#f5d17e;font-size: 16px;"><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span>
                                <span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span> <span class="priceright">(per adult)</span>
                            </div>
                            <div><?php echo $show_duration; ?></div>
                        </div>
                        <div class="bannericons mt-2">
                            <?php if ($accomodation == 1): ?><img src="<?php echo base_url(); ?>assets/images/bed-w.png" title="Accomodation" alt="Accomodation" width="24" height="24" /><?php endif; ?>
                            <?php if ($tourtransport == 1): ?><img src="<?php echo base_url(); ?>assets/images/car-w.png" title="Transportation" alt="Transportation" width="24" height="24" /><?php endif; ?>
                            <?php if ($sightseeing == 1): ?><img src="<?php echo base_url(); ?>assets/images/binoculars-w.png" title="Sightseeing" alt="Sightseeing" width="24" height="24"/><?php endif; ?>
                            <?php if ($breakfast == 1): ?><img src="<?php echo base_url(); ?>assets/images/cutlery-w.png" title="Breakfast" alt="Breakfast"  width="24" height="24"/><?php endif; ?>
                            <?php if ($waterbottle == 1): ?><img src="<?php echo base_url(); ?>assets/images/waterbtl-white.png" title="Water Bottle" alt="Water Bottle" width="24" height="24" /><?php endif; ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <section class="tourdetailstop">
            <div class="container">
                <ul class="cbreadcrumb my-4">
                 
                      <li><a href="/">Home</a></li>
                      <li><a href="/tour-packages">Tour Packages</a></li>
                      <li><a href="#"><?php echo $tpackage_name; ?></a></li>
                    </ul>
                <div class="row">
                    <div class="col-xl-8 col-lg-7 col-md-12 tourdetails mb-5">
                        <div class="tourdetailsimg">
                            <?php
                            if (file_exists("./uploads/" . $tpackage_image) && ($tpackage_image != '')) {
                                $tpackage_image = base_url() . "uploads/" . $tpackage_image;
                            } else {
                                $tpackage_image = base_url() . "assets/images/golden-triangel-banner.jpg";
                            }
                            ?>
                            <img src="<?php echo $tpackage_image; ?>" class="img-fluid" alt="<?php echo !empty($alttag_banner) ? $alttag_banner : "My Holiday Happiness"; ?>">
							<div class="courtesy-txt"> Courtesy - Flickr </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-5 col-md-12 formright-container mb-5">

                        <?php echo form_open(base_url('packages'), array('id' => 'form_calculate', 'name' => 'form_calculate', 'class' => 'formright')); ?>	
                        <div class="row">
							<div class="col-md-12">
								<?php if((isset($_REQUEST['error'])) && ($_REQUEST['error'] == 1)){ ?>
                                <div class="errormsg" style="font-size:13px;"><i class="fa fa-times"></i> Booking failed. Please try again.</div>
								<?php } ?>
								<?php if((isset($_REQUEST['error'])) && ($_REQUEST['error'] == 2)){ ?>
                                <div class="errormsg" style="font-size:13px;"><i class="fa fa-times"></i> Fill up all mandatory fields and try again.</div>
								<?php } ?>
								<?php if((isset($_REQUEST['error'])) && ($_REQUEST['error'] == 3)){ ?>
                                <div class="errormsg" style="font-size:13px;"><i class="fa fa-times"></i> Login to your account to book the package.</div>
								<?php } ?>
                            </div>
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Travellers #</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="formsubheading">(Adults: 12+ Yrs)</span>
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity_adult">
                                        <input type="text" step="1" max="<?php echo $max_vehicle_capacity; ?>" value="0" name="quantity_adult" id="quantity_adult" class="quantity-field" readonly>
                                        <input type="button" value="+" class="button-plus" data-field="quantity_adult">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <span class="formsubheading">(Children: 6-12 Yrs)</span>
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity_child">
                                        <input type="text" step="1" max="<?php echo $max_vehicle_capacity; ?>" value="0" name="quantity_child" id="quantity_child" class="quantity-field" readonly>
                                        <input type="button" value="+" class="button-plus" data-field="quantity_child">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-12">
                                <div class="form-group">
                                    <label for="vehicle">Vehicle</label>
                                    <select class="form-control" id="vehicle" name="vehicle">
                                        <option value="">-Select Vehicle-</option>
                                        <?php
                                        if ($noof_vehicle > 0) {
                                            $get_vehicles = $this->Common_model->join_records("b.vehicle_name, b.vehicleid", "tbl_vehicleprices as a", "tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid", "a.destination=$package_startingcity and a.status=1", "b.capacity asc");

                                            foreach ($get_vehicles as $get_vehicle) {
                                                ?>
                                                <option value="<?php echo $get_vehicle['vehicleid']; ?>"><?php echo $get_vehicle['vehicle_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-xl-6 col-lg-12">
                                <div class="form-group datepickerbox">
                                    <label for="date">Date of travel</label>
                                    <input type="text" class="form-control datepicker" id="travel_date" name="travel_date" placeholder="dd/mm/yyyy" readonly >
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6">
                                            <label for="accomodation">Accommodation</label>
                                        </div>
                                        <?php if (!empty($accommodation_types)) { ?>
                                            <div class="col-xl-6 col-lg-6">
                                                <label for="accomodation" class="chk-hotl" data-toggle="modal" data-target="#Hotel-check">Check Hotels</label>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <select class="form-control" id="accommodation_type" name="accommodation_type">		
                                        <option value=""> - - Select Accommodation - - </option>
                                        <?php
                                        if (!empty($accommodation_types)) {
                                            echo $this->Common_model->populate_select($dispid = "", "hotel_type_id", "hotel_type_name", " tbl_hotel_type", "hotel_type_id in ($hotel_typeid)", "hotel_type_name desc", "");
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pickup"> Airport pickup & drop</label>
                                    <div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="airport_pickup" id="airport_pickup" value="1">Pickup
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="airport_drop" id="airport_drop" value="2">Drop
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="error_message"></div>								

                            <div class="col-md-12">
                                <input type="hidden" id="hid_packageid" name="hid_packageid" value="<?php echo $tourpackageid; ?>">
                                <button type="button" class="btn formcalculatebtn" id="calculate_price">Calculate price</button>
                                <button type="button" class="btn btn2" data-toggle="modal" data-target="#Enquiry-now">Enquiry/Customize</button>
                            </div>
                        </div>
                        <div class="modal fade" id="insurance-option-content">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?php echo $this->Common_model->show_parameter(40); ?> </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="hotel-chk-sec">
                                                <div class="row" id="">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <h4 ><?php echo $this->Common_model->show_parameter(41); ?></h4>
                                                    </div>
                                                </div>
												
                                            </div>
                                        </div>

                                        <!-- Modal footer -->

                                    </div>
                                </div>
                            </div>
                        <?php if (!empty($accommodation_types)) { ?>
                            <!--Start Check hotel form modal pop up-->
                            <div class="modal fade" id="Hotel-check">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?php echo $tpackage_name; ?> </h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="hotel-chk-sec">
                                                <div class="row" id="accomodation_result">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <h4 style="color:#6583bb; padding-bottom:20px;">Select accommodation first to check hotels.</h4>
                                                    </div>
                                                </div>
												<div class="row">
													<div class="col-xl-12 col-lg-12 text-center">
                                                        <input type="button" class="btn btn-primary" value="OK" data-dismiss="modal">
                                                    </div>
												</div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->

                                    </div>
                                </div>
                            </div>
                            <!--End Check hotel form modal pop up-->
                        <?php } ?>
                        <?php echo form_close();?>
                        <?php echo form_open(base_url('packages/booking'), array('id' => 'form_price', 'name' => 'form_price')); ?>	 	
							<!--Start check price sliding form-->
							<div class="calculatepricediv" style="display:none;">
								<a href="javascript:void(0)" class="editbtn"><img src="<?php echo base_url(); ?>assets/images/edit.png" alt="My Holiday Happiness"></a>
								<div class="price-txt"></div>
								<div class="pay-txt">
									<ul>
										<li> 
											<div class="form-check ">
												<label class="form-check-label" for="pay_radio1">
													<input type="radio" class="form-check-input" id="pay_radio1" name="pay_radio" value="100" checked >Pay 100%
												</label>
											</div>
										</li>
										<li> 
											<div class="form-check ">
												<label class="form-check-label" for="pay_radio2">
													<input type="radio" class="form-check-input" id="pay_radio2" name="pay_radio" value="50" >Pay 50%
												</label>
											</div>
										</li>
										<li> 
											<div class="form-check ">
												<label class="form-check-label" for="pay_radio3">
													<input type="radio" class="form-check-input" id="pay_radio3" name="pay_radio" value="30" >Pay 30%
												</label>
											</div>
										</li>
									</ul>
									<?php 
										if(($this->session->userdata('customer_id') != "") && ($this->session->userdata('customer_id')>0)) 
											$data_target = "#Book-now";
										else
											$data_target = "#sign-up";
									?>
								<!--	<div><a href="javascript:void(0)" id="booknowbtn" class="formbookbtn" data-toggle="modal" data-target="<?php echo $data_target; ?>">Book Now</a></div>-->
									<div style="display:flex;justify-content: space-around;"><a href="javascript:void(0)" id="booknowbtn" class="formbookbtn" data-toggle="modal" data-target="<?php echo $data_target; ?>">Book Now</a> <a href="javascript:void(0)" onclick="downloadDetails()" class="formbookbtn" id="download_pdf_button">Download</a></div>
									
									<div class="form-check-inline acceptxt">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" value="1" checked disabled>I accept the booking policy
										</label>
									</div>
									<div><img src="<?php echo base_url(); ?>assets/images/pricingpolicy.jpg" class="mt-2 paymenticons" alt="My Holiday Happiness"></div>
									<hr>
									<script>function openInsuranceModal(){
									$('#insurance-option-content').modal('show');}</script>
									<div style="font-size: 14px;line-height: 1.5;background: #6583bb;color:white;text-transform: capitalize;padding: 4px 0;"><a href="javascript:void(0)" onclick="openInsuranceModal()" style="color:white"><?php echo $this->Common_model->show_parameter(38);?></a></div>
									   <!--<?php //if($this->Common_model->show_parameter(38)) {?>
									
									<div style="font-size: 14px;line-height: 1.5;"><?php /* $insuranceDetails= $this->Common_model->show_parameter(38); if(strlen($insuranceDetails)>100){ echo substr($insuranceDetails,0,100); ?>  <span id="dots">...</span><span id="more" style="display:none"> <?php echo substr($insuranceDetails,100,strlen($insuranceDetails));?></span></p><a href="javascript:void(0)" onclick="readMore()" id="readMoreButton">Read more</a> <?php  }else{echo $insuranceDetails; } */ ?></div>
                                    <script>
                                    function readMore() {
                                      var dots = document.getElementById("dots");
                                      var moreText = document.getElementById("more");
                                      var btnText = document.getElementById("readMoreButton");
                                    
                                      if (dots.style.display === "none") {
                                        dots.style.display = "inline";
                                        btnText.innerHTML = "Read more"; 
                                        moreText.style.display = "none";
                                      } else {
                                        dots.style.display = "none";
                                        btnText.innerHTML = "Read less"; 
                                        moreText.style.display = "inline";
                                      }
                                    }
                                    </script>   <?php // } ?>-->




								</div>
							</div>
							<!--End check price sliding form-->

							<!--Start modal for traveller details-->
							<div class="modal fade login-fade" id="Book-now">
								<div class="modal-dialog modal-lg">
									<div class="modal-content book-login-bg">
										<button type="button" class="close book-close" data-dismiss="modal">&times;</button>
										<!-- Modal body -->
										<div class="modal-body">											
											<div id="BookGeustopen">
												<div class="book-a-geust-sec pop-book-s">
													<h4><?php echo $tpackage_name; ?> <?php if ($noof_assoc_dest > 0): ?>| <?php echo $show_assoc_dests; ?><?php endif; ?></h4>
													<div class="book-sub-hdng">Traveller Details</div>
													<div class="row">
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="Primary Traveller Name" id="traveller_name" name="traveller_name" maxlength="40"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="email" class="p-login-fld" placeholder="Email Id" id="traveller_email" name="traveller_email" maxlength="80"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="Phone" id="traveller_phone" name="traveller_phone" maxlength="10"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="Alternate Phone" id="traveller_altphone" name="traveller_altphone" maxlength="10"> 
															</div>
														</div>
														<div class="col-xl-12 col-lg-12">
															<div class="form-group">
																<textarea class="p-login-fld height-fld" placeholder="Any Special Requests (Maximum 800 Character)" id="traveller_msg" name="traveller_msg" maxlength="800"></textarea>
															</div>
														</div>
														<div class="col-xl-12 col-lg-12">
															<div class="book-sub-hdng">Pickup/Drop Location (Optional)</div>
														</div>
														<div class="col-xl-12 col-lg-12">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="Address" id="location_address" name="location_address" maxlength="100"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="City" id="location_city" name="location_city" maxlength="50"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="State" id="location_state" name="location_state" maxlength="50"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="Pincode" id="location_pincode" name="location_pincode" maxlength="6"> 
															</div>
														</div>
														<div class="col-xl-6 col-lg-6">
															<div class="form-group">
																<input type="text" class="p-login-fld" placeholder="Landmark" id="location_landmark" name="location_landmark" maxlength="50"> 
															</div>
														</div>
                                                        
														<div class="col-xl-12 col-lg-12">
															<button type="submit" class="log-in-btm" name="btnPayment" id="btnPayment">Proceed To Pay</button>
														</div>
													</div>
												</div>
											</div>																			
										</div>
									</div>
								</div>
							</div>
							<!--End modal for traveller details-->
                        <?php echo form_close();?>

                        <!--Start modal signup or login-->
                        <div class="modal fade login-fade" id="sign-up">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content book-login-bg height-auto">
                                    <button type="button" class="close book-close" data-dismiss="modal">&times;</button>
                                    <!-- Modal body -->
                                    <div class="modal-body ">
                                        <!--Start modal signup-->
										<?php echo form_open(base_url('packages'), array( 'id' => 'form_signup', 'name' => 'form_signup'));?>
                                        <div id="login-1st">
                                            <div class="sign-up-sec">
                                                <div class="login-txt-hdng"> Signup</div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group"> 
															<input type="text" class="p-login-fld" name="fullname" id="fullname" placeholder="Full Name *" maxlength="50">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
															<input type="text" class="p-login-fld" name="contact" id="contact" placeholder="Mobile No *" maxlength="10">
                                                        </div>
                                                    </div>
													<div class="col-xl-12 col-lg-12">
                                                        <div class="form-group">
															<input type="email" class="p-login-fld" name="emailida" id="emailida" placeholder="Email Id *" maxlength="80">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
															<input type="password" class="p-login-fld" name="passworda" id="passworda" placeholder="Password *" maxlength="24">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
															<input type="password" class="p-login-fld" name="cpassworda" id="cpassworda" placeholder="Confirm password *" maxlength="24">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12">
                                                        <div class="form-group">
                											<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>">
                											</div>
                                                        </div> 
                                                    </div>
													<div class="col-xl-4 col-lg-4">
														<button type="submit" name="btn_custsignup" id="btn_custsignup" class="log-in-btm">Create Account</button>
													</div>
													<div class="col-xl-8 col-lg-8" id="signupMessage">
													</div>
                                                </div>												
                                                <div class="already-txt"> Already Created Account? <span id="btn-1">Login Here</span></div>
                                            </div>
                                        </div>
                                        <?php echo form_close();?>
										<!--End modal signup-->

                                        <!--Start modal login-->
										
                                        <div id="login-2nd" class="collapse">
                                            <div class="login-sec">
                                                <div class="login-txt-hdng"> Login</div>
												<?php echo form_open(base_url( 'packages' ), array( 'id' => 'form_login', 'name' => 'form_login'));?>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
															<input type="email" class="p-login-fld" name="login_email" id="login_email" placeholder="Email address" maxlength="80"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="form-group">
															<input type="password" class="p-login-fld" name="login_password" id="login_password" placeholder="Password" maxlength="24">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12">
                                                        <div class="form-group">
                											<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>">
                											</div>
                                                        </div> 
                                                    </div>
													<div class="col-xl-4 col-lg-4">
														<button type="submit" class="log-in-btm" name="btnSignincust" id="btnSignincust">SignIn</button>
													</div>
													<div class="col-xl-8 col-lg-8" id="signinMessage"></div>													
                                                </div>
												<?php echo form_close();?>
                                                <div class="p-forgot-txt" data-toggle="collapse" data-target="#ForgetPasword">Forgot Password?</div>
												
												<?php echo form_open('', array( 'name'=>'forgot_password', 'id'=>'forgot_password' ));?>
                                                <div id="ForgetPasword" class="collapse">
                                                    <div class="row">
														<div class="col-xl-12 col-lg-12" id="frmError"></div>
                                                        <div class="col-xl-7 col-lg-7">
                                                            <div class="form-group">
																<input type="email" class="p-login-fld" name="forgotemail" id="forgotemail" placeholder="Email address">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-5 col-lg-5">
															<button type="submit" id="forgot-e" class="log-in-btm">Send Reset Link</button>
														</div>
                                                    </div>
                                                </div>
												<?php echo form_close();?>
                                                <div class="already-txt"> New User? <span id="btn-2">Sign Up Here</span></div>
                                            </div>
                                        </div>
                                        
										<!--End modal login-->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--End modal signup or login-->

                        <!--Start Enquiry form modal pop up-->
                        <div class="modal fade" id="Enquiry-now">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content book-login-bg height-auto">
                                    <!-- Modal Header -->
                                    <button type="button" class="close book-close" data-dismiss="modal">&times;</button>
                                    <div class="modal-body">
                                        <div class="login-txt-hdng"> Enquiry Now</div>
                                        <?php echo form_open(base_url('packages'), array('id' => 'form_enquiry', 'name' => 'form_enquiry')); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="number" class="pack-enquiry-fld" placeholder="Enter no of adult" name="noof_adult" id="noof_adult" min="0" oninput="this.value=this.value.slice(0,3)">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="number" class="pack-enquiry-fld" placeholder="Enter no of child" name="noof_child" id="noof_child" min="0" oninput="this.value=this.value.slice(0,3)">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group datepickerbox modalicon ">
                                                    <input type="text" class="form-control" placeholder="Enter date of travel" name="tsdate" id="tsdate" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <select class="pack-enquiry-fld" id="accommodation" name="accommodation">
                                                        <option value=""> - - Enter accommodation type - - </option>
                                                        <?php echo $this->Common_model->populate_select($dispid = 0, "hotel_type_id", "hotel_type_name", " tbl_hotel_type", "", "hotel_type_name asc", ""); ?>
                                                    </select>
                                                </div>
                                            </div>		
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="pack-enquiry-fld" placeholder="First Name" name="first_name" id="first_name" maxlength="40">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="pack-enquiry-fld" placeholder="Last Name" name="last_name" id="last_name" maxlength="40">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" class="pack-enquiry-fld" placeholder="Your Email " name="emailid" id="emailid" maxlength="80">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="pack-enquiry-fld" placeholder="Contact No" name="contact_no" id="contact_no" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="pack-enquiry-fld  txt-height" placeholder="Message (Maximum 800 Character)" id="message" name="message" maxlength="800"></textarea>
                                                </div>
                                            </div>
                                           <div class="col-lg-12 col-md-12">
                                                 <div class="form-group">
            											<div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>">
            											</div>
                                                    </div> 
                                            </div> 
                                           <!-- <div class="col-lg-6 col-md-12">
                                     <div class="form-group">
											<input type="text" class="form-control" name="captcha" id="captcha" placeholder="Captcha" required>
											</div>
                                        </div>
										<div class="col-lg-6 col-md-12">
										    <div class="form-group">
											<div class="image"><?php echo $image; ?></div>
											<a href="javascript:void(0)" class="refresh">Refresh code</a>
											</div>
                                        </div>-->
                                        
                                        <div class="clearfix"></div>
                                            <div class="col-md-4">
                                                <input type="hidden" id="packageid" name="packageid" value="<?php echo $tourpackageid; ?>">
                                                <button type="submit" class="pack-enquiry-submit" name="inquiry_submit" id="inquiry_submit">Submit</button>
                                            </div>
                                            <div class="col-md-8" id="showMessage"></div>
                                        </div>
                                        <?php echo form_close(); ?>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--End Enquiry form modal pop up-->



                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <section class="mb100">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 col-md-12 tabdetails">
                        <ul id="tabsJustified" class="nav nav-tabs mt-5">
                            <li class="nav-item"><a href="" data-target="#tab1" data-toggle="tab" class="nav-link small active">Itinerary</a></li>
                            <li class="nav-item"><a href="" data-target="#tab2" data-toggle="tab" class="nav-link small ">Inclusions / Exclusions</a></li>
                            <li class="nav-item"><a href="" data-target="#tab3" data-toggle="tab" class="nav-link small">Hotels</a></li>
                            <li class="nav-item"><a href="" data-target="#tab4" data-toggle="tab" class="nav-link small ">Booking Policy</a></li>
                        </ul>
                        <br>
                        <div id="tabsJustifiedContent" class="tab-content">
                            <div id="tab1" class="tab-pane fade  active show">
                                <?php
                                $noof_itinerary = $this->Common_model->noof_records("itinerary_daywiseid", "tbl_itinerary_daywise", "itinerary_id=$itinerary");
                                if ($noof_itinerary > 0) {
                                    ?>
                                    <ul class="timeline">
                                        <?php
                                        $day = 1;
                                        $itineraries = $this->Common_model->get_records("*", "tbl_itinerary_daywise", "itinerary_id=$itinerary", "itinerary_daywiseid asc");
                                        foreach ($itineraries as $itinerary_res) {
                                            ?>
                                            <li>
                                                <div class="item">
                                                    
                                                    <div class="timelineheading"> <span style="padding-top: 15px;">Day <?php echo $day; ?> </span> - <?php echo $itinerary_res["title"]; ?></div>
                                                    <?php
                                                    $get_iter = $itinerary_res['place_id'];
                                                    if ($get_iter != "") {
                                                        $get_places = $this->Common_model->get_records("placeid, destination_id, place_name, place_url", "tbl_places", "placeid in($get_iter)");
                                                        if (!empty($get_places)) {
                                                            foreach ($get_places as $get_place) {
                                                                $getplace_name = $get_place['place_name'];
                                                                $getplace_destid = $get_place['destination_id'];
                                                                $getplace_url = $get_place['place_url'];

                                                                $getplace_dest_data = $this->Common_model->join_records("a.destination_url, b.state_url", "tbl_destination as a", "tbl_state as b", "a.state=b.state_id", "a.destination_id=$getplace_destid");
                                                                foreach ($getplace_dest_data as $getplace_placedest) {
                                                                    $getplace_destinationurl = $getplace_placedest['destination_url'];
                                                                    $getplace_state_url = $getplace_placedest['state_url'];
                                                                }
                                                                ?>
                                                               <!--  <div style="text-indent: 10px;"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $getplace_name; ?></div> -->
                                                                <div style="text-indent: 10px;color: #000;"><a href="<?php echo base_url() . 'place/' . $getplace_state_url . '/' . $getplace_destinationurl . '/' . $getplace_url; ?>" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $getplace_name; ?></a></div> 
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    foreach(explode(', ',$itinerary_res["other_iternary_places"]??'') as $other_place){ if($other_place){?>
                                                        <div style="text-indent: 10px;color: #000;"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $other_place; ?></div>
                                                   <?php }}
                                                    ?>
                                                </div>
                                            </li> 
                                            <?php
                                            $day++;
                                        }
                                        ?>
                                    </ul>
                                <?php } ?>
                                <div id="itinerary">
                                    <div>
                                        <?php echo $itinerary_note; ?>
                                    </div>
                                    <?php
                                    $get_itinerary = $this->Common_model->get_records("itinerary_name, itinerary_url", "tbl_itinerary", "itinerary_id='$itinerary'");
                                    if (!empty($get_itinerary)) {
                                        foreach ($get_itinerary as $itinerary_data) {
                                            $pkg_itinerary_url = $itinerary_data['itinerary_url'];
                                            $pkg_itinerary_name = $itinerary_data['itinerary_name'];
                                        }
                                        ?>								
                                        <a href="<?php echo base_url() . 'itinerary/' . $pkg_itinerary_url; ?>" title="<?php echo $pkg_itinerary_name; ?>" class="viwebtn" target="_blank">View complete Itinerary</a>
                                          <?php if($show_video_itinerary && $video_itinerary_link){?>  
                                         <a href="javascript:void(0)" class="viwebtn"  id="show_video_itinerary" onclick="$('#show_video_itinerary').toggle();$('#hide_video_itinerary').toggle();$('#video_itinerary').toggle(); ">Show Video Itinerary</a>
                                         <a  href="javascript:void(0)" class="viwebtn"  id="hide_video_itinerary" style="display:none" onclick="$('#show_video_itinerary').toggle();$('#hide_video_itinerary').toggle();$('#video_itinerary').toggle(); ">Hide Video Itinerary</a>
                                         <div class="col-md-12 mt-3 embed-responsive embed-responsive-16by9" id="video_itinerary"  style="display:none">
                                             <iframe class="embed-responsive-item" src="<?php echo $video_itinerary_link;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                         </div>
                                          <?php } ?>
                                    <?php } ?>

                                    <div class="shareicons mt-3">
                                        <i class="pe-7s-share" style="font-weight: 600"></i>Share										
                                        <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank" class=""><i class="fab fa-facebook-f"></i></a>
                                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank" class=""> <i class="fab fa-linkedin-in"></i></a>
                                        <a href="https://plus.google.com/share?url=<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank" class=""><i class="fab fa-google-plus-g"></i></a>
                                        <a href="https://twitter.com/share?url=<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank" class=""><i class="fab fa-twitter"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div id="tab2" class="tab-pane fade">
                                <div id="inclusions">
                                    <?php echo $inclusion_exclusion; ?>                                    
                                </div>
                            </div>
                            <div id="tab3" class="tab-pane fade">
                                <div class="hotellist-rgt">
                                    <div class="row">

                                        <?php
                                        $package_hotels = $this->Common_model->get_records("*", "tbl_package_accomodation", "package_id='$tourpackageid'");
                                        if (!empty($package_hotels)) {
                                            $noof_hotel = count($package_hotels);
                                            $hotel = 1;
                                            foreach ($package_hotels as $package_hotel) {
                                                $hotel_destination = $package_hotel['destination_id'];
                                                $hotel_destination_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id=$hotel_destination");
                                                $hotel_nights = $package_hotel['noof_days'];
                                                ?>		
                                                <div class="col-md-3">
                                                    <h5 class="mt-4"><?php echo $hotel_destination_name; ?> <?php if ($hotel_nights > 0) echo "(" . $hotel_nights . "N)"; ?></h5>
                                                </div>

                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <?php
                                                        $get_hotels = $this->Common_model->get_records("*", "tbl_hotel", "destination_name='$hotel_destination' and status=1", "hotel_type asc, hotel_name asc");
                                                        if (!empty($get_hotels)) {
                                                            foreach ($get_hotels as $get_hotel) {
                                                                $hotel_name = $get_hotel['hotel_name'];
                                                                $hotel_type = $get_hotel['hotel_type'];
                                                                $hotel_type_name = $this->Common_model->showname_fromid("hotel_type_name", "tbl_hotel_type", "hotel_type_id=$hotel_type");
                                                                $default_price = $get_hotel['default_price'];

                                                                $room_type = $get_hotel['room_type'];
                                                                $trip_advisor_url = $get_hotel['trip_advisor_url'];
                                                                $star_rating = $get_hotel['star_rating'];
                                                                if ($trip_advisor_url == "")
                                                                    $trip_advisor_url = "javascript:void(0)";
                                                                ?>		
                                                                <div class="col-md-4">
                                                                    <div class="hoteldetails mb-3">
                                                                        <div class="hotelplace">
                                                                            <i class="fas fa-hotel"></i> <a href="<?php echo $trip_advisor_url; ?>" target="_blank"><b><?php echo $hotel_name; ?></b></a>
                                                                        </div>
                                                                        <div class="hotelrating">
                                                                            <?php
                                                                            $hotel_floorval = floor($star_rating);
                                                                            $hotel_decval = $star_rating - $hotel_floorval;
                                                                            $hotel_balanceint = 5 - $star_rating;
                                                                            echo str_repeat('<i class="fas fa-star"></i>', (int) $hotel_floorval);
                                                                            echo ($hotel_decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
                                                                            echo str_repeat('<i class="far fa-star"></i>', (int) $hotel_balanceint);
                                                                            ?>
                                                                        </div>
                                                                        <div class="hotelname"><?php echo $hotel_type_name; ?></div>
                                                                        <?php if ($room_type != ""): ?><div class="hotelrating">(<?php echo $room_type; ?>)</div><?php endif; ?>
                                                                        <div><img src="<?php echo base_url(); ?>assets/images/4.0.png" alt="My Holiday Happiness"></div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div> 
                                                <div class="clearfix"></div>
                                                <?php if ($hotel < $noof_hotel) { ?><div  class="col-md-12"><hr></div><?php } ?>

                                                <?php
                                                $hotel++;
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div id="tab4" class="tab-pane fade">
                                <div class="sb-container2 container-example2">
                                    <div id="bookingpolicy">                              
                                        <?php echo $this->Common_model->show_parameter(21); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 mt-5">
                        <div class="rightbookingbox">
                            <h3>Get our assistance for easy booking</h3>
                            <a href="<?php echo base_url() . 'contactus#contactform'; ?>"> <span class="cullusbtn">Want us to call you?</span></a>
                            <p>Or call us at</p>
                            <h5><?php echo $this->Common_model->show_parameter(3); ?></h5>
                        </div>

                        <div class="sidebanner mt-5"> 
                            <img src="<?php echo base_url(); ?>assets/images/Delhi-side-Banner.jpg" alt="My Holiday Happiness" class="img-fluid">
                            <div class="sidebannercontent">
                                <h5> Delhi tours<br> starts from <span class="packageCostOrig" style="text-decoration: line-through; color:#46488c;font-size: 16px;">₹ 6100</span>
                                    <span class="packageCost">₹4850</span> <span class="priceright">(per adult)</span></h5>                        
                                <p>Need customization?</p>
                                <a href="" class="viewbtn">Send Enquiry</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <section class="innergoogle-review">
            <?php include("verified_reviews.php"); ?>  
        </section>
        <?php
        $get_pkg_tag = $this->Common_model->get_package_id($tourpackageid);
        if (!empty($get_pkg_tag)) {
            $tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "tourpackageid in (SELECT distinct(type_id) FROM tbl_tags WHERE type='3' and tagid=$get_pkg_tag and type_id!=$tourpackageid) and status = 1", "");
            if (!empty($tour_packages)) {
                ?>	
                <section class="tourpackage-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 mb-4">
                                <h2 style="font-size: 22px;">Most Popular <?php echo $this->Common_model->showname_fromid("tag_name", "tbl_menutags", "tagid=$get_pkg_tag"); ?></h2>
                            </div>
                            <div class="col-md-5 mb-4">
                                <?php echo form_open(base_url('destination'), array('id' => 'search_form', 'name' => 'search_form', 'class' => 'row listform')); ?>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <select class="selectpicker" name="starting_city" id="starting_city">
                                            <option value="">Select Starting City</option>
                                            <?php
                                            $destination_qry = $this->db->query("SELECT destination_id, destination_name FROM tbl_destination WHERE status=1 and destination_id in (select distinct(starting_city) from tbl_tourpackages where tourpackageid in (SELECT distinct(type_id) FROM tbl_tags WHERE type='3' and tagid=$get_pkg_tag and type_id!=$tourpackageid) and status= 1) ORDER BY destination_name asc");
                                            $destinations = $destination_qry->result_array();
                                            foreach ($destinations as $destination) {
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
                                            $durations_qry = $this->db->query("SELECT durationid, duration_name FROM tbl_package_duration WHERE status=1 and durationid in (select distinct(package_duration) from tbl_tourpackages where tourpackageid in (SELECT distinct(type_id) FROM tbl_tags WHERE type='3' and tagid=$get_pkg_tag and type_id!=$tourpackageid) and status= 1) ORDER BY no_ofdays asc");
                                            $durations = $durations_qry->result_array();
                                            foreach ($durations as $duration) {
                                                ?>
                                                <option value="<?php echo $duration['durationid']; ?>"><?php echo $duration["duration_name"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="get_pkg_tag" id="get_pkg_tag" value="<?php echo $get_pkg_tag; ?>">
                                        <input type="hidden" name="tourpackageid" id="tourpackageid" value="<?php echo $tourpackageid; ?>">
                                    </div>
                                </div>
                                <div class="clearfix "></div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container mb100 tours-in-india-section">        	
                    <div class="row" id="search_result">	
                        <div id="loader"></div>				
                        <?php
                        foreach ($tour_packages as $tour_package) {
                            //$tourpackageid = $tour_package["tourpackageid"];
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
                            $starting_city_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id=$starting_city");

                            $noof_assoc_dest = $this->Common_model->noof_records("a.itinerary_destinationid", "tbl_itinerary_destination as a, tbl_destination as b", "a.destination_id=b.destination_id and a.itinerary_id=$itinerary");

                            if ($noof_assoc_dest > 0) {
                                $assoc_dests_arr = array();

                                $assoc_dests = $this->Common_model->join_records("a.itinerary_destinationid, b.destination_name", "tbl_itinerary_destination as a", "tbl_destination as b", "a.destination_id=b.destination_id", "a.itinerary_id=$itinerary", "a.itinerary_destinationid asc");

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
                                    <?php if ($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
                                    <div class="tourist-duration"> <?php echo $show_duration; ?> </div>
                                </div>
                                <div class="tourist-bottom-details">
                                    <ul class="iconlist">									
                                        <?php if ($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation"  alt="Accommodation"></li><?php endif; ?>
                                        <?php if ($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li><?php endif; ?>
                                        <?php if ($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li><?php endif; ?>	
                                        <?php if ($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li><?php endif; ?>
                                        <?php if ($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li><?php endif; ?>
                                    </ul>
                                  <!--  <div class="touristlist-hdng "><?php echo $tpackage_name; ?> <?php if ($noof_assoc_dest > 0): ?> |  <?php echo $show_assoc_dests; ?><?php endif; ?></div>-->
                                      <div class="touristlist-hdng "><?php echo $tpackage_name; ?> <?php if ($noof_assoc_dest > 0): ?> <?php endif; ?></div>
                                      
                                    <div class="tourbutton "> <span><a href="<?php echo base_url() . 'packages/' . $tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></span></div>
                                    <div class="tourprice "><span class="packageCostOrig " style="text-decoration: line-through; color: #A0A0A0; font-size:14px "><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span></div>
                                    <div class="clearfix "></div>
                                </div>
                            </div>                
                        <?php } ?>               
                    </div>
                </div>

                <?php
            }
        }
        ?>

        <?php include("footer.php"); ?>     

        <!--script src="https://code.jquery.com/jquery-1.9.1.min.js"></script-->

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scrollBar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js_validation/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script>
            $(document).ready(function () {
                $("#btn-1").click(function () {
                    $("#login-1st").hide();
                    $("#login-2nd").fadeIn(1000);
                });

                $("#btn-2").click(function () {
                    $("#login-2nd").hide();
                    $("#login-1st").fadeIn(1000);
                });

                $("#Bookageust").click(function () {
                    $("#login-2nd").hide();
                    $("#login-1st").hide();
                    $("#BookGeustopen").fadeIn(1000);
                    $("#Bookageust").hide();
                });
            });
        </script>


        <script>
            $(function () {
                $('.selectpicker').selectpicker();
            });
        </script>

        <script>
            $(document).ready(function () {
                $(".editbtn").click(function () {
                    $(".calculatepricediv").slideToggle();
                });

                $(".formcalculatebtn").click(function () {

                    var error = 0;
                    var quantity_adult = $("#quantity_adult").val();
                    var vehicle = $("#vehicle").val();
                    var travel_date = $("#travel_date").val();
                    var accommodation_type = $("#accommodation_type").val();
                    if (quantity_adult == 0)
                    {
                        $("#quantity_adult").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#quantity_adult").removeClass("errorfield");
                    }

                    if (vehicle == "")
                    {
                        $("#vehicle").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#vehicle").removeClass("errorfield");
                    }

                    if (travel_date == "")
                    {
                        $("#travel_date").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#travel_date").removeClass("errorfield");
                    }

                    if (accommodation_type == "")
                    {
                        $("#accommodation_type").addClass("errorfield");
                        error += 1;
                    } else
                    {
                        $("#accommodation_type").removeClass("errorfield");
                    }

                    if (error == 0)
                    {
                        $("#error_message").html('');
                        $.ajax({
                            url: "<?php echo base_url(); ?>packages/geprice",
                            type: 'post',
                            data: $('#form_calculate').serialize(),
                            beforeSend: function () {
                                $("#calculate_price").prop("disabled", true);
                                $("#calculate_price").html('<span style="font-size:9px;"><i class="fa fa-spinner fa-spin fa-2x"></i></span> Calculating...');
                            },
                            success: function (result) {
                                //alert(result);
                                $('.price-txt').html(result);
                                $(".calculatepricediv").slideToggle();
                                $("#calculate_price").prop("disabled", false);
                                $("#calculate_price").html('Calculate price');
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                            }
                        });
                    } else
                    {
                        $("#error_message").html('<div class="errormsg" style="font-size:15px;">Please fill up all above mandatory fields.</div>');
                        return false;
                    }
                });
            });

            $(function () {
                $(".datepicker").datepicker({
                    minDate: +2,
                    showOtherMonths: true,
                    dateFormat: 'dd/mm/yy',
                    showOn: "both",
                    buttonImage: "<?php echo base_url(); ?>assets/images/modal-small-calendar.jpg",
                    buttonImageOnly: true,
                    buttonText: "Select date",
                    changeMonth: true,
                    changeYear: true
                });
            });

            $(function () {
                $("#tsdate").datepicker({
                    minDate: 0,
                    showOtherMonths: true,
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    beforeShow: function () {
                        setTimeout(function () {
                            $('.ui-datepicker').css('z-index', 9999);
                        }, 0);
                    }
                });
            });

            $(".sb-container").scrollBox();
            $(".sb-container2").scrollBox();
        </script>

        <script>
            //plus/minus input//
            function incrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal)) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
            }

            function decrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal) && currentVal > 0) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
            }

            $('.input-group').on('click', '.button-plus', function (e) {
                incrementValue(e);
                checkcapacity();
            });

            $('.input-group').on('click', '.button-minus', function (e) {
                decrementValue(e);
                checkcapacity();
            });

            function checkcapacity()
            {
                var maxcapacity = <?php echo $max_vehicle_capacity; ?>;
                var adultcount = $("#quantity_adult").val();
                var childcount = $("#quantity_child").val();
                var totalcount = parseInt(adultcount) + parseInt(childcount);
                if (totalcount > maxcapacity)
                {
                    $("#calculate_price").prop("disabled", true);
                    alert("Maximum <?php echo $max_vehicle_capacity; ?> no of travellers can be booked for this package. Please make a inquiry below for more traveller.");
                    $("#Enquiry-now").modal('show');
                    $("#noof_adult").val(adultcount);
                    $("#noof_child").val(childcount);
                } else
                {
                    $("#calculate_price").prop("disabled", false);
                    $("#noof_adult").val(adultcount);
                    $("#noof_child").val(childcount);
                }

                $.ajax({
                    url: "<?php echo base_url(); ?>packages/getvehicles?totalcount=" + totalcount + "&destination=" +<?php echo $package_startingcity; ?>,
                    type: 'post',
                    data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                    success: function (result) {
                        //alert(result);
                        $('#vehicle').html(result);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });

            }
        </script>

        <script>
            $(document).on('change', '#starting_city, #trip_duration', function () {
                //alert("hi");
                $.ajax({
                    url: "<?php echo base_url(); ?>packages/search",
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
                    success: function (result) {
                        $('#search_result').html(result);
                        $("#loader").html('');
                        $('#search_result').removeClass('loder-bg');
                        $('#loader').removeClass('loder-gif');
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                    }
                });
            })

            $(document).on('change', '#accommodation_type', function () {
                var accommodation_type = $(this).val();
                if (accommodation_type != "")
                {
                    $("#Hotel-check").modal('show');
                    //alert(accommodation_type);
                    
                    $.ajax({
                        url: "<?php echo base_url(); ?>packages/getaccomodation?accommodation_type=" + accommodation_type + "&packageid=" +<?php echo $tourpackageid; ?>,
                        type: 'post',
                        data: {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                        beforeSend: function () {
                            $("#accomodation_result").html('<div style="text-align:center; padding:50px;"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading Hotels</div>');
                        },
                        success: function (result) {
                            console.log('coming');
                            $('#accomodation_result').html(result);
                            $('#accommodation').val(accommodation_type);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
                        }
                    });
                } else
                {
                    $("#accomodation_result").html('<h4 style="color:#6583bb; padding-bottom:20px;">Select accommodation first to check hotels.</h4>');
                }
            })

			jQuery(document).ready(function () {
				
				jQuery("#form_enquiry").validate({
					rules: {
						noof_adult: {
							// required: true,
							number: true
						},
						noof_child: {
							number: true
						},
						tsdate: {
							required: true
						},
						accommodation: {
							required: true
						},
						first_name: {
							required: true
						},
						emailid: {
							required: true,
							email: true
						},
						contact_no: {
							required: true,
							regex: "^[0-9 \+-]+$",
						    minlength:10
						},
						captcha: {
							required: true
						}
					},
					messages: {
						noof_adult: {
							required: "Enter no of adult.",
							number: "Enter a valid number"
						},
						noof_child: {
							number: "Enter a valid number"
						},
						tsdate: {
							required: "Enter date of travel"
						},
						accommodation: {
							required: "Enter accommodation type"
						},
						first_name: {
							required: "Enter first name"
						},
						emailid: {
							required: "Enter email id",
							email: "Enter valid email id"
						},
						contact_no: {
							required: "Enter contact no",
							regex: "Numbers only"
						},
						captcha: {
							required: "Enter captcha",
						}
					},
					submitHandler: function (form) {
						$.ajax({
							url: base_url + "packages/enquiry",
							type: 'post',
							cache: false,
							processData: false,
							data: $('#form_enquiry').serialize(),
							beforeSend: function () {
								$('#showMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-spinner fa-spin fa-lg"></i> <span style="color:#fff">Processing...</span></div>');
							},
							success: function (data) {
								grecaptcha.reset();
                                data = jQuery.parseJSON(data); 
								if (data.status == "success") {
									$('#form_enquiry')[0].reset();
									$('#showMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-check"></i> '+data.message+' </div>');
								} else {
									$('#showMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> '+data.message+' </div>');
								}
							},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
                                grecaptcha.reset();
								alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
								$('#showMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> Your enquiry could not submitted. Please try again.</div>');
							}
						});
						return false;
					}
				});
			});
        </script>
		<script>
			jQuery(document).ready(function () {
				jQuery.validator.addMethod("regex",function(value,element,regexp){
					var re= new RegExp(regexp);
					return this.optional(element) || re.test(value);
				},"Remove Special Chars");
				
				jQuery("#form_login").validate({
					rules: {
						login_email: {
							required: true,
							email: true
						},
						login_password: {
							required: true,
							regex:"^[a-zA-Z0-9\-_#!`~\/\\*?@}{&$%^();,.+=|:\ \r\n]+$",
							rangelength: [6, 12]
						}
					},
					messages: {
						login_email: {
							required: "Enter email id",
							email: "Enter valid email"
						},
						login_password: {
							required: "Enter password",
							rangelength: "Password length must be between {0} to {1}"
						}
					},
					submitHandler: function (form) {
						$.ajax({
							url: base_url + "login/booking_login",
							type: 'post',
							cache: false,
							processData: false,
							data: $('#form_login').serialize(),
							beforeSend: function () {
								$("#btnSignincust").prop("disabled", true);
                                $("#btnSignincust").html('<span style="font-size:9px;"><i class="fa fa-spinner fa-spin fa-2x"></i></span> Processing...');
							},
							success: function (data) {
								//alert(data);
                                grecaptcha.reset();
								if (data == "success") {
									$('#form_login')[0].reset();
									$("#Book-now").modal('show');
									$("#sign-up").modal('hide');
									$('#header_account').html('<li><a href="<?php echo base_url()?>booking">Bookings</a></li> <li><a href="<?php echo base_url()?>profile">Profile</a></li><li><a href="<?php echo base_url()?>logout">Log out</a></li>');
									$('#booknowbtn').attr('data-target','#Book-now');
								}  else if (data == "captcha-error") {
                                    $('#signinMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> Captcha code error, please verify the captcha.</div>');
                                    $("#btnSignincust").prop("disabled", false);
                                    $("#btnSignincust").html('SignIn');
                                }else {
									$('#signinMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> Invalid email id or password. Please try again.</div>');
									$("#btnSignincust").prop("disabled", false);
									$("#btnSignincust").html('SignIn');
								}
							},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
								alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
								$('#signinMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> Invalid email id or password. Please try again.</div>');
								$("#btnSignincust").prop("disabled", false);
								$("#btnSignincust").html('SignIn');
							}
						});
						return false;
					} 
				});
			});
		</script>	
		<script>
            jQuery(document).ready(function () {
                
                jQuery.validator.addMethod("regex",function(value,element,regexp){
                    var re= new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },"Remove Special Chars");
                
                jQuery("#form_signup").validate({
					rules: {
						fullname: {
							required: true                
						},
						contact: {
							required: true,
							regex: "^[0-9 \+-]+$",
                            minlength:10
						},
						emailida: {
							required: true,
							email: true,
							remote: {
								url: base_url + 'register/check_email',
								type: "post",
								data: {
									chkemail: function () { return $("#emailida").val(); },'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
								}
							}
						},
						passworda: {
							required: true,   
							rangelength: [6, 15]
						},
						cpassworda: {
						   required: true,
						   equalTo: "#passworda"                
						}   
					},
					messages: {
						fullname: {
						   required: "Enter full name."                
						},
						contact: {
							required: "Enter phone no.",
							 regex: "Numbers only"
						},
						emailida: {
							required: "Enter email id.",
							email: "Enter valid email",
							remote: "Email already exist."
						},
						passworda: {
							required: "Enter password.",
							rangelength: "Password Must Contain 6 To 15 Characters"
						},
						cpassworda: {
							required: "Enter confirm password.",
							equalTo: "Enter same password again."                
						}             
					},
					submitHandler: function (form) {
						$.ajax({
							url: base_url + "register/booking_signup",
							type: 'post',
							cache: false,
							processData: false,
							data: $('#form_signup').serialize(),
							beforeSend: function () {
								$("#btn_custsignup").prop("disabled", true);
                                $("#btn_custsignup").html('<span style="font-size:9px;"><i class="fa fa-spinner fa-spin fa-2x"></i></span> Processing...');
							},
							success: function (data) {
								grecaptcha.reset();
                                data = jQuery.parseJSON(data);
								if (data.status == "success") { 
									$('#form_signup')[0].reset();
									$("#Book-now").modal('show');
									$("#sign-up").modal('hide');
									$('#header_account').html('<li><a href="<?php echo base_url()?>booking">Bookings</a></li> <li><a href="<?php echo base_url()?>profile">Profile</a></li><li><a href="<?php echo base_url()?>logout">Log out</a></li>');
									$('#booknowbtn').attr('data-target','#Book-now');
								} else {
									$('#signupMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> '+data.message+' </div>');
									$("#btn_custsignup").prop("disabled", false);
									$("#btn_custsignup").html('Create Account');
								}
							},
							error: function (XMLHttpRequest, textStatus, errorThrown) {
								alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
								$('#signupMessage').html('<div style="padding-top:10px;"><i style="color:#fff" class="fa fa-times"></i> Could not proceed to signup. Please try again.</div>');
								$("#btn_custsignup").prop("disabled", false);
								$("#btn_custsignup").html('Create Account');
							}
						});
						return false;
					}   
				});
			});
		</script>   
		
		<script type="text/javascript">
			$(document).ready(function(){
				jQuery("#forgot_password").validate({
					rules: {            
						forgotemail: {
							required: true,
							email: true
						}
					},
					messages:{
						forgotemail:{
							required:"Enter email id",
							email:"Invalid email id"
						}
					},
					submitHandler: function(form) {
						var forgotemail = $("#forgotemail").val();
						$.ajax({
							type: "POST",
							data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'},
							url: "<?php echo base_url(); ?>login/forgot_email/?forgotemail="+forgotemail,
							beforeSend: function () {
								$("#forgot-e").prop("disabled", true);
                                $("#forgot-e").html('<span style="font-size:9px;"><i class="fa fa-spinner fa-spin fa-2x"></i></span> Processing...');
							},
							success: function(result) {
								//alert(result);
								if (result == '1') {
									$("#frmError").html('<div class="successmsg"><i class="fa fa-check"></i> A link has been sent to your Email ID to change your password.</div>');
									$('#forgot_password')[0].reset();
								} else if(result == '2') {
									$("#frmError").html('<div class="errormsg"><i class="fa fa-times"></i> Unable to process your request.</div>');
								}else if(result == '3') {
									$("#frmError").html('<div class="errormsg"><i class="fa fa-times"></i> This email id is inactive.</div>');
								}else{
									$("#frmError").html('<div class="errormsg"><i class="fa fa-times"></i>Invalid email id.</div>');
								}
								$("#forgot-e").prop("disabled", false);
                                $("#forgot-e").html('Send Reset Link');
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								alert("Status: " + textStatus + "\n" + "Error: " + errorThrown);
								$('#frmError').html('<div class="errormsg"><i class="fa fa-times"></i> Invalid Username or Password.</div>');
							}
						});
						return false;
					}
				});    
			});    
		</script>
		
		<script>
			jQuery(document).ready(function () {
				jQuery("#form_price").validate({
					rules: {						
						traveller_name: {
							required: true
						},
						traveller_email: {
							required: true,
							email: true
						},
						traveller_phone: {
							required: true,
							regex: "^[0-9 \+-]+$",
						    minlength:10
						}
					},
					messages: {						
						traveller_name: {
							required: "Enter primary traveller name"
						},
						traveller_email: {
							required: "Enter email id",
							email: "Enter valid email id"
						},
						traveller_phone: {
							required: "Enter phone no",
							regex: "Numbers only"
						}
					}
				});
			});
			
			$(document).on('change', '#travel_date', function() { 
            var q = $(this).val();
            $("#tsdate").val(q);
          });
		</script>
		
		   <script>
          $(document).ready(function() {
	$("a.refresh").click(function() {
		$.ajax({
			type: "POST",
			data: {
								'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
								},
			url: "<?php echo base_url(); ?>" + "packages/captcha_refresh",
			//alert(url);
			success: function(res) {
			    alert(res);
				if (res)
				{
					$("div.image").html(res);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				alert("xhr "+jqXHR+" status "+textStatus+" error "+errorThrown);
				// Handle errors here
				console.log('ERRORS: ' + textStatus);
				// STOP LOADING SPINNER
			}
		});
	});
});
      </script>

    </body>
</html>
