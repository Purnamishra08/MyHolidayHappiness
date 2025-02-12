<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?> 
	</head>
    <body>
      <?php include("header.php"); ?> 

        <div class="videocontainer">
            <video autoplay="" muted="" loop="" id="myVideo">
                <source src="<?php echo base_url(); ?>assets/images/mainvdo.mp4" type="video/mp4"> </video>

            <div class="formcontainer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center mb-3">
                            <h1 style="color:white">Love where you are going</h1>
                            <p style="color:white">Nam dapibus nisl vitae elit fringilla rutrum. Aenean sollicitudin, erat a elementum rutrum.</p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2"></div>
                        <form class="col-md-8 row bookingform-container">
                            <div class="col-lg-5 col-md-12 formbox selectdiv currentlocationbox">
                                <div class="form-group">
                                    <i class="pe-7s-map-marker"></i>
                                    <label for="destination" class="mt-3 labelheading">Destination</label>
                                    <select class="selectpicker" data-live-search="true"  data-live-search-placeholder="Search">
                                        <option data-tokens="">Delhi</option>
                                        <option data-tokens="">Darjeeling</option>
                                        <option data-tokens="">Andamans</option>
                                        <option data-tokens="">Agra</option>
                                        <option data-tokens="">Jaipur</option>
                                        <option data-tokens="">Udaipur</option>
                                        <option data-tokens="">Simla</option>
                                        <option data-tokens="">Ooty</option>
                                        <option data-tokens="">Coorg</option>
                                        <option data-tokens="">Nainital</option>
                                        <option data-tokens="">Rajasthan</option>
                                        <option data-tokens="">Munnar</option>							
                                        <option data-tokens=" ">Manali</option>
                                        <option data-tokens="">Mysore</option>
                                        <option data-tokens="">Kodaikanal</option>
                                        <option data-tokens="">Aurangabad</option>
                                        <option data-tokens="">Lonavala</option>
                                        <option data-tokens="">Panchgani</option>
                                        <option data-tokens=" ">Wayanad</option>
                                        <option data-tokens="">Satara</option>
                                        <option data-tokens="">Madurai</option>
                                        <option data-tokens="">Pondicherry</option>
                                        <option data-tokens="">Andhra Pradesh</option>
                                        <option data-tokens="">Himachal Pradesh</option></select>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-12 formbox selectdiv destinationbox">
                                <div class="form-group">
                                    <i class="pe-7s-clock"></i>
                                    <label for="duration" class="mt-3 labelheading">Duration</label>
                                    <select class="selectpicker" data-live-search="true"  data-live-search-placeholder="Search" >							
                                        <option data-tokens="">3Days/2Nights</option>
                                        <option data-tokens="">2Days/1Nights</option>
                                        <option data-tokens="">5Days/4Nights</option>
                                        <option data-tokens="">6Days/5Nights</option>
                                        <option data-tokens="">7Days/6Nights</option></select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-12 formsubmitbutton">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                        <div class="col-md-2"></div> <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="featuredsection">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="featuredbox-top">
                            <img src="<?php echo base_url(); ?>assets/images/guide.png">
                            <div class="featuredbox-title"><span>1,000+</span> local guides </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="featuredbox-top">
                            <img src="<?php echo base_url(); ?>assets/images/experience.png">
                            <div class="featuredbox-title"><span>Handcrafted</span> experiences </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="featuredbox-top">
                            <img src="<?php echo base_url(); ?>assets/images/traveller.png">
                            <div class="featuredbox-title"><span>96% </span> happy travellers</div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <section class="bg01">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <h2>Most Popular Tours</h2>
                        <p class="headingcontent">check out our best promotion tours!</p>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <a href="tour-packages.html" class="morebutton mt-3">View all tours</a>
                    </div><div class="clearfix"></div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">

                            <h3 class="tour-heading"><a href="#">Coorg Tour Packages</a></h3>
                            <div class="tour-head">
                                <div class="corner featuredribbon"><span>Featured</span></div>
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/Kumarakom.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Delhi</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Dubare, Bylakuppe, Madikeri, Talakaveri</span>
                                <div class="tourbutton"><a href="#" class="viwebtn">View details</a></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Ooty Tour Packages</a></h3>
                            <div class="tour-head">
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/ooty.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Kochi</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Ooty Lake, Pykara, Ketti, Doddabetta</span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Wayanad Tour Packages</a></h3>
                            <div class="tour-head">
                                <div class="corner featuredribbon"><span>Featured</span></div>
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/wayanad.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Bangalore</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Bansura, Meenmutty, Edakkal </span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Munnar Tour Packages</a></h3>
                            <div class="tour-head">
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/munnar.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Kerala</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Dubare, Bylakuppe, Madikeri, Talakaveri</span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Pondicherry Tour Packages</a></h3>
                            <div class="tour-head">
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/pondicherry.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Goa</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Pondicherry Sightseeing</span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Kerala Tour Packages</a></h3>
                            <div class="tour-head">
                                <div class="corner featuredribbon"><span>Featured</span></div>
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/kerala.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Rajasthan</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Munnar, Thekkady, Alleppey, Kovalam</span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Kerala Tour Packages</a></h3>
                            <div class="tour-head">
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/kerala.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Delhi</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Munnar, Thekkady, Alleppey, Kovalam</span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="#">Kerala Tour Packages</a></h3>
                            <div class="tour-head">
                                <div class="corner featuredribbon"><span>Featured</span></div>
                                <a href=""><img src="<?php echo base_url(); ?>assets/images/kerala.jpg" alt="" class="img-fluid"></a>
                                <div class="explore hometag">Ex-Sikkim</div>
                            </div>

                            <div class="tour-content">

                                <span class="tour-sub-content">Munnar, Thekkady, Alleppey, Kovalam</span>
                                <div class="tourbutton"> <span><a href="#" class="viwebtn">View details</a></span></div>

                                <div class="tourprice"><span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px">₹ 6100</span>
                                    <span class="packageCost">₹4850</span></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>

        <section class="destinationsection">
            <div class="destinationtop">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/kerala-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Kerala</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/goa-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Goa</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/coorg-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Coorg</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/ooty-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Ooty</p>
                                </div>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="destinationmiddle">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/rajasthan-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Rajasthan</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6 destinationcontent text-center">
                            <h3>Our top Destinations</h3>
                            <a href="destinations.html" class="morebutton">View all tours</a>
                        </div>

                        <div class="col-md-3 destinationholder">
                            <a href="golden-triangle.html">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/temple-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Golden Traingle</p>
                                </div>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="destinationbottom">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/himachal-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Himachal Pradesh</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="#">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/uttarakhand-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Uttarakhand</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="" title="">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/mahabaleshwar-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Mahabaleswar</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="" title="">
                                <div class="newimg">
                                    <img src="<?php echo base_url(); ?>assets/images/tamilnadu-destination.jpg" alt="">
                                </div>
                                <div class="padcontent">
                                    <p>Tamilnadu</p>
                                </div>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="destination-season">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h3 class="mt-2">Destinations of the season</h3> </div>
                    <div class="col-md-6 mb-4"><a href="destinations.html" class="morebutton">View all destinations</a></div>
                    <div class="clearfix"></div>

                    <div class="col-md-8 seasondestination">
                        <a href="#">
                            <div class="seasondestination-imgholder">
                                <img src="<?php echo base_url(); ?>assets/images/kodaikana.jpg" class="img-fluid">
                            </div>
                            <div class="padcontent">
                                <p>Tamilnadu</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 seasondestination">
                        <a href="#">
                            <div class="seasondestination-imgholder">
                                <img src="<?php echo base_url(); ?>assets/images/kerala-season.jpg" class="img-fluid">
                            </div>
                            <div class="padcontent">
                                <p>Kerala</p>
                            </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-4 seasondestination">
                        <a href="#">
                            <div class="seasondestination-imgholder">
                                <img src="<?php echo base_url(); ?>assets/images/rajasthan-season.jpg" class="img-fluid">
                            </div>
                            <div class="padcontent">
                                <p>Rajasthan</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 seasondestination">
                        <a href="#">
                            <div class="seasondestination-imgholder">
                                <img src="<?php echo base_url(); ?>assets/images/andaman-season.jpg" class="img-fluid">
                            </div>
                            <div class="padcontent">
                                <p>Andamans</p>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 seasondestination">
                        <a href="#">
                            <div class="seasondestination-imgholder">
                                <img src="<?php echo base_url(); ?>assets/images/himachal-season.jpg" class="img-fluid">
                            </div>
                            <div class="padcontent">
                                <p>Tamilnadu</p>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <section class="weekend-destinations">
            <div class="container weekendcontainer">
                <div class="row">
                    <div class="col-md-12 mb-5 text-center">
                        <h3 class="weekend-title">Top weekend getways</h3>
                        <a href="" class="morebutton">View all destinations</a>
                    </div>
                </div>

                <div class="weekend-destinations-slider">
                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="<?php echo base_url(); ?>assets/images/ooty-destination.jpg" alt="" class="img-fluid" />
                            <h4>Best mountains in Ooty </h4>
                            <a href="" class="morebutton">View details</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="<?php echo base_url(); ?>assets/images/tamilnadu-destination.jpg" alt="" class="img-fluid" />
                            <h4>Best places in Tamilnadu </h4> <a href="" class="morebutton">View details</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="<?php echo base_url(); ?>assets/images/mahabaleshwar-destination.jpg" alt="" class="img-fluid" />
                            <h4>Best temples in Maharashtra </h4> <a href="" class="morebutton">View details</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="<?php echo base_url(); ?>assets/images/temple-destination.jpg" alt="" class="img-fluid" />
                            <h4>Best places in Tamilnadu</h4> <a href="" class="morebutton">View details</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="<?php echo base_url(); ?>assets/images/rajasthan-destination.jpg" alt="" class="img-fluid" />
                            <h4>Best mountains in Ooty </h4> <a href="" class="morebutton">View details</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="<?php echo base_url(); ?>assets/images/coorg-destination.jpg" alt="" class="img-fluid" />
                            <h4>Best mountains in Ooty </h4> <a href="" class="morebutton">View details</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="itineraries-section">
            <div class="container">
                <div class="itinerariesbg">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mt-3">Popular Itineraries</h3></div>
                        <div class="col-md-4 mb-4"><a href="" class="morebutton">View all</a></div>
                        <div class="clearfix"></div>

                        <div class="col-xl-3 col-lg-6 col-md-6 itinerariesdestination">
                            <a href="#">
                                <div class="itinerariesdestination-imgholder">
                                    <img src="<?php echo base_url(); ?>assets/images/coorg-destination.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="itinerariescontent">2-day Trips from Bangalore</div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-6  itinerariesdestination">
                            <a href="#">
                                <div class="itinerariesdestination-imgholder">
                                    <img src="<?php echo base_url(); ?>assets/images/goa-destination.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="itinerariescontent">2-day Trips from Delhi</div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-6  itinerariesdestination">
                            <a href="#">
                                <div class="itinerariesdestination-imgholder">
                                    <img src="<?php echo base_url(); ?>assets/images/goa-destination.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="itinerariescontent">2-day Trips from Mumbai</div>
                            </a>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-6  itinerariesdestination">
                            <a href="#">
                                <div class="itinerariesdestination-imgholder">
                                    <img src="<?php echo base_url(); ?>assets/images/goa-destination.jpg" class="img-fluid" alt="">
                                </div>
                                <div class="itinerariescontent">2-day Trips from Mumbai</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>        
        </section>

        <section class="map-section mb100">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt100">
                        <h3 class="mb-4 text-center">Explore tours on Map</h3>
                        <img src="<?php echo base_url(); ?>assets/images/map.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonialsection">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-4">Recent traveller review</h3>
                        <a href="" class="morebutton  mb-4">View all reviews</a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="testimonial-slider">
                        <div class="col-lg-3">
                            <div class="reviewbox">
                                <div class="clientname mt-2">Omkar Joshi</div>
                                <div class="clientplace">Bangalore</div>
                                <img src="<?php echo base_url(); ?>assets/images/rating.jpg" class="img-fluid rating mb-2" alt="">
                                <p>Very comfortable tour as driver shreedher was on time n familiar n friendly n well behaved n overall good family tour ,tq for arranging memorable tour</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="reviewbox">
                                <div class="clientname mt-2">Omkar Joshi</div>
                                <div class="clientplace">Bangalore</div>
                                <img src="<?php echo base_url(); ?>assets/images/rating.jpg" class="img-fluid rating mb-2" alt="">
                                <p>Very comfortable tour as driver shreedher was on time n familiar n friendly n well behaved n overall good family tour ,tq for arranging memorable tour</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="reviewbox">
                                <div class="clientname mt-2">Endner Michael</div>
                                <div class="clientplace">Bangalore</div>
                                <img src="<?php echo base_url(); ?>assets/images/rating.jpg" class="img-fluid rating mb-2" alt="">
                                <p>Very comfortable tour as driver shreedher was on time n familiar n friendly n well behaved n overall good family tour ,tq for arranging memorable tour</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="reviewbox">
                                <div class="clientname mt-2">Endner Michael</div>
                                <div class="clientplace">Bangalore</div>
                                <img src="<?php echo base_url(); ?>assets/images/rating.jpg" class="img-fluid rating mb-2" alt="">
                                <p>Very comfortable tour as driver shreedher was on time n familiar n friendly n well behaved n overall good family tour ,tq for arranging memorable tour</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="reviewbox">
                                <div class="clientname mt-2">Endner Michael</div>
                                <div class="clientplace">Bangalore</div>
                                <img src="<?php echo base_url(); ?>assets/images/rating.jpg" class="img-fluid rating mb-2" alt="">
                                <p>Very comfortable tour as driver shreedher was on time n familiar n friendly n well behaved n overall good family tour ,tq for arranging memorable tour</p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="reviewbox">
                                <div class="clientname mt-2">Endner Michael</div>
                                <div class="clientplace">Bangalore</div>
                                <img src="<?php echo base_url(); ?>assets/images/rating.jpg" class="img-fluid rating mb-2" alt="">
                                <p>Very comfortable tour as driver shreedher was on time n familiar n friendly n well behaved n overall good family tour ,tq for arranging memorable tour</p>
                            </div>
                        </div>

                    </div>	
                </div>
            </div>
        </section>

        <section class="blog-section">
            <div class="container">
                <div class="row mt100">
                    <div class="col-lg-6">
                        <div class="blogleft">
                            <h3 class="mb-4 blogheading">Our blog posts</h3><a href="" class="morebutton">View all</a>
                            <div class="blogimage"><a href="#"><img src="<?php echo base_url(); ?>assets/images/goa-destination.jpg" class="img-fluid" alt=""></a></div>
                            <h4 class="blogtitle"><a href="#">12 stunning places to visit in July in India</a></h4>
                            <p class="blogcontent">Lorem ipsum dolor sit amet, consectetur adipisicing Suscipit tas aperiam Sorem ipsum dolor consectur adipisicing. Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row mb-2">
                            <div class="rightbloglist blogimage col-md-6"><a href="#"><img src="<?php echo base_url(); ?>assets/images/andaman-season.jpg" class="img-fluid" alt=""></a></div>
                            <div class="col-md-6">
                                <h4 class="blogtitle mt-3"><a href="#">10 promising festivals and events in India</a></h4>
                                <p class="blogcontent">Lorem ipsum dolor sit amet, consectetur adipisicing Suscipit tas aperiam ipsum dolor sit amet, consectetur adipisicing Suscipit tas aperiam..</p>
                            </div>
                        </div> 

                        <div class="row mb-2">
                            <div class="rightbloglist blogimage col-md-6"><a href="#"><img src="<?php echo base_url(); ?>assets/images/kerala-season.jpg" class="img-fluid" alt=""></a></div>
                            <div class="col-md-6">
                                <h4 class="blogtitle mt-3"><a href="#">12 stunning places to visit in July in India</a></h4>
                                <p class="blogcontent">Lorem ipsum dolor sit amet, consectetur adipisicing Suscipit tas ipsum dolor.sit amet, consectetur adipisicing.consectetur..</p>
                            </div>
                        </div><div class="clearfix"></div>
                    </div>
                </div>              
            </div>   
        </section>

		<?php include("footer.php"); ?> 

        <script src="<?php echo base_url(); ?>assets/js/slick.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

        <script>          
           
            $(function () {
                $('.selectpicker').selectpicker();
            });
        </script>

         <script>
            $('.weekend-destinations-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                responsive: [

                    {
                        breakpoint: 1399,
                        settings: {
                            slidesToShow: 3
                        }
                    },

                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3
                        }
                    }, {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 1
                        }
                    }, {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $('.testimonial-slider').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                responsive: [

                    {
                        breakpoint: 1399,
                        settings: {
                            slidesToShow: 3
                        }
                    },

                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 3
                        }
                    }, {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 1
                        }
                    }, {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        </script>

       
        <script>
            var video = document.getElementById("myVideo");
            var btn = document.getElementById("myBtn");

            function myFunction() {
                if (video.paused) {
                    video.play();
                    btn.innerHTML = "Pause";
                } else {
                    video.pause();
                    btn.innerHTML = "Play";
                }
            }
        </script>


    </body>
</html>