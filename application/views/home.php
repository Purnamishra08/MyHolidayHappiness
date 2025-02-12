<!doctype html>
<html lang="en">
	<head>
		<?php include("head.php"); ?> 
		
	</head>
    <body>
        <style>
          .videocontainer img{
                width: 100%;
    height: 500px;
    object-fit: cover;
          }
        </style>
		<?php include("header.php"); ?> 
      
        <div class="videocontainer">            
           <video autoplay="" muted="" loop="" id="myVideo"> <source src="<?php echo base_url(); ?>assets/images/mainvdo0.mp4" type="video/mp4"> </video>

            <div class="formcontainer">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-md-12 col-12 text-center mb-3">
							<h1 style="color: #fff;font-size: 26px;letter-spacing: 0;font-weight: 300;margin-bottom: 0;font-family: Questrial, sans-serif;line-height: 1.2;margin-top: 0;text-align: center;">Package Tours & Travel</h1>
							<!-- p>Your happiness is Our happiness</p -->
                        </div>
                         
                    </div>

                    <div class="row">
                        <div class="col-md-2"></div>
						<?php echo form_open(base_url('search-package'), array( 'id' => 'form_contact', 'name' => 'form_contact', 'class' => 'col-md-8 row bookingform-container', 'method'=> 'get' ));?>
                            <div class="col-lg-5 col-md-12 formbox selectdiv currentlocationbox">
                                <div class="form-group">
                                    <i class="pe-7s-map-marker"></i>
                                    <label for="destination" class="mt-3 labelheading">Destination</label>
                                    <select class="selectpicker" id="searchDestination" name="destination" required>
                                        <option value="">Select Destination</option>
                                        <?php echo $this->Common_model->populate_destination(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-12 formbox selectdiv destinationbox">
                                <div class="form-group">
                                    <i class="pe-7s-clock"></i>
                                    <label for="duration" class="mt-3 labelheading">Duration</label>
                                    <select class="selectpicker" id="searchDuration" name="duration">							
                                        <option value="">Select Duration</option>
										<?php  // echo $this->Common_model->populate_duration("", "", "no_ofdays asc"); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-12 formsubmitbutton">
                                <button type="submit" class="btn btn-primary" style="">Submit</button>
                            </div>
                            <div class="clearfix"></div>
                        <?php echo form_close();?>
                        <div class="col-md-2"></div> <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <section class="featuredsection">
			<?php echo  $this->Common_model->showname_fromid("page_content","tbl_contents","content_id ='1'"); ?>        
        </section>
		<?php
			$mostpopular_tours = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b","a.cat_id=b.catid", "a.menuid=3 and a.status=1 and show_on_home=1 and a.tagid IN (SELECT tagid FROM `tbl_tags` WHERE type=3)","","8");
			if( !empty($mostpopular_tours))
			{
		?>
        <section class="bg01">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <h2>Most Popular Tour Packages</h2>
                        <p class="headingcontent">check out our best promotion tours!</p>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <a href="<?php echo base_url().'tour-packages'?>" class="morebutton mt-3">View all tours</a>
                    </div>
					<div class="clearfix"></div>
					
					<?php
						foreach($mostpopular_tours as $mostpopular_tours_data)
						{
							$mostpopular_tagid = $mostpopular_tours_data['tagid']; 
							$mostpopular_tagname = $mostpopular_tours_data['tag_name'];
							$mostpopular_tagurl = $mostpopular_tours_data['tag_url'];
							$mostpopular_thumbimg = $mostpopular_tours_data['menutagthumb_img'];
							$mostpopular_alttag_thumb = $mostpopular_tours_data['alttag_thumb'];
							$mostpopular_catname = $mostpopular_tours_data['cat_name'];
							$mostpopular_cat_seomenu = $this->Common_model->makeSeoUrl($mostpopular_catname);
							
							$noof_popular_tourpackages = $this->Common_model->noof_records("DISTINCT(a.type_id) as package_id","tbl_tags as a, tbl_tourpackages as b","a.type_id = b.tourpackageid and a.tagid ='$mostpopular_tagid' and a.type=3 and b.status=1");
							
							$tourpackages_MinPrice = $this->Common_model->showname_fromid("MIN(b.price)", "tbl_tags as a, tbl_tourpackages as b", "a.type_id=b.tourpackageid and a.tagid ='$mostpopular_tagid' and a.type=3 and b.status=1");	
					?>
                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="tour-item">
                            <h3 class="tour-heading"><a href="<?php echo base_url().'tours/'.$mostpopular_cat_seomenu.'/'.$mostpopular_tagurl; ?>"><?php echo $mostpopular_tagname; ?></a></h3>
                            <div class="tour-head">                                
								<a href="<?php echo base_url().'tours/'.$mostpopular_cat_seomenu.'/'.$mostpopular_tagurl; ?>">
                                    <img src="#" data-src="<?php echo base_url().'uploads/'.$mostpopular_thumbimg; ?>" class="img-fluid lazy" alt="<?php echo (!empty($mostpopular_alttag_thumb)) ? $mostpopular_alttag_thumb : $mostpopular_tagname; ?>">
                                </a>
								<div class="explore hometag"><?php echo $noof_popular_tourpackages; ?> Tour Packages</div>
                            </div>
                            <div class="tour-content">
								<div class="tour-sub-content"><span style="font-size:15px;">Tour Starts From</span> <span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $tourpackages_MinPrice; ?></span></div>
								<div class="clearfix"></div>
                                <div class="tourbutton"><a href="<?php echo base_url().'tours/'.$mostpopular_cat_seomenu.'/'.$mostpopular_tagurl; ?>" class="viwebtn">View details</a></div>
                                <div class="tourprice">
									<ul class="iconlist">
										<li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accommodation" width="24" height="24"></li>
										<li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"  width="24" height="24"></li>
										<li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"  width="24" height="24"></li>	
										<li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"  width="24" height="24"></li>
										<li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle" width="24" height="24"></li>
									</ul>	
								</div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
					<?php } ?> 

                    <div class="clearfix"></div>
                </div>
            </div>
        </section>
		<?php } ?>
		
        <section class="destinationsection">
		
            <div class="destinationtop">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $topdesti= $this->Common_model->get_records("*","tbl_destination","status='1' and desttype_for_home='18'","destination_name asc","4","0");
						//echo $this->db->last_query();
                        if (!empty($topdesti)) {
                            foreach ($topdesti as $topdestis) {
                                $destination_id = $topdestis['destination_id']; 
                                $destination_name = $topdestis['destination_name'];
                                $destination_url = $topdestis['destination_url'];  
                                $destiimg_thumb = $topdestis['destiimg_thumb'];
                                $alttag_thumb_topi = $topdestis['alttag_thumb'];
                                $stateid = $topdestis['state']; 
                                $state_url = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$stateid'");
                    
						?>                    
                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="<?php echo base_url().'destination/'.$state_url.'/'.$destination_url; ?>">
                                <div class="newimg">
                                    <img src="#" class="lazy" data-src="<?php echo base_url().'uploads/'.$destiimg_thumb; ?>" alt="<?php echo (!empty($alttag_thumb_topi)) ? $alttag_thumb_topi : $destination_name; ?>">
                                </div>
                                <div class="padcontent">
                                    <p><?php echo $destination_name; ?></p>
                                </div>
                            </a>
                        </div>

                         <?php }} ?>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="destinationmiddle">
                <div class="container-fluid">
                    <div class="row">
                         <?php
                        $topdestib= $this->Common_model->get_records("*","tbl_destination","status='1' and desttype_for_home='18'","destination_name asc","1","4");                               
                        if (!empty($topdestib)) {
                            foreach ($topdestib as $topdestibs) {
                                $destination_idb = $topdestibs['destination_id']; 
                                $destination_nameb = $topdestibs['destination_name'];
                                $destination_urlb = $topdestibs['destination_url'];  
                                $destiimg_thumbb = $topdestibs['destiimg_thumb'];
                                $alttag_thumb_topb = $topdestibs['alttag_thumb'];
                                $stateidb = $topdestibs['state']; 
                                $state_urlb = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$stateidb'");
                    
                        ?>                
                        <div class="col-md-3 destinationholder">
                            <a href="<?php echo base_url().'destination/'.$state_urlb.'/'.$destination_urlb; ?>">
                                <div class="newimg">
                                    <img  src="#" class="lazy" data-src="<?php echo base_url().'uploads/'.$destiimg_thumbb; ?>" alt="<?php echo (!empty($alttag_thumb_topb)) ? $alttag_thumb_topb : $destination_nameb; ?>">
                                </div>
                                <div class="padcontent">
                                    <p><?php echo $destination_nameb; ?></p>
                                </div>
                            </a>
                        </div>
                         <?php }} ?>

                        <div class="col-md-6 destinationcontent text-center">
                            <h3>Top Destinations to visit</h3>
                            <a href="<?php echo base_url().'destinations' ?>" class="morebutton">View all destinations</a>
                        </div>

                        <?php
                        $topdestic= $this->Common_model->get_records("*","tbl_destination","status='1' and desttype_for_home='18'","destination_name asc","1","5");                               
                        if (!empty($topdestic)) {
                            foreach ($topdestic as $topdestics) {
                                $destination_idc = $topdestics['destination_id']; 
                                $destination_namec = $topdestics['destination_name'];
                                $destination_urlc = $topdestics['destination_url'];  
                                $destiimg_thumbc = $topdestics['destiimg_thumb'];
                                $alttag_thumb_topc = $topdestics['alttag_thumb'];
                                $stateidc = $topdestics['state']; 
                                $state_urlc = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$stateidc'");
                         ?>            

                        <div class="col-md-3 destinationholder">
                            <a href="<?php echo base_url().'destination/'.$state_urlc.'/'.$destination_urlc; ?>">
                                <div class="newimg">
                                    <img  src="#" class="lazy" data-src="<?php echo base_url().'uploads/'.$destiimg_thumbc; ?>" alt="<?php echo (!empty($alttag_thumb_topc)) ? $alttag_thumb_topc : $destination_namec; ?>">
                                </div>
                                <div class="padcontent">
                                    <p><?php echo $destination_namec; ?></p>
                                </div>
                            </a>
                        </div>
                        <?php }} ?>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="destinationbottom">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $topdestia= $this->Common_model->get_records("*","tbl_destination","status='1' and desttype_for_home='18'","destination_name asc","4","6");                               
                        if (!empty($topdestia)) {
                            foreach ($topdestia as $topdestias) {
                                $destination_ida = $topdestias['destination_id']; 
                                $destination_namea = $topdestias['destination_name'];
                                $destination_urla = $topdestias['destination_url'];  
                                $destiimg_thumba = $topdestias['destiimg_thumb'];
                                $alttag_thumb_topa = $topdestias['alttag_thumb'];
                                $stateida = $topdestias['state']; 
                                $state_urla = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$stateida'");
                        ?>  
                        <div class="col-lg-3 col-md-6 destinationholder">
                            <a href="<?php echo base_url().'destination/'.$state_urla.'/'.$destination_urla; ?>">
                                <div class="newimg">
                                    <img  src="#" class="lazy" data-src="<?php echo base_url().'uploads/'.$destiimg_thumba; ?>" alt="<?php echo (!empty($alttag_thumb_topa)) ? $alttag_thumb_topa : $destination_namea; ?>">
                                </div>
                                <div class="padcontent">
                                    <p><?php echo $destination_namea; ?></p>
                                </div>
                            </a>
                        </div>
                      <?php }} ?>

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
                    <div class="col-md-6 mb-4"><a href="<?php echo base_url().'destinations' ?>" class="morebutton">View all destinations</a></div>
                    <div class="clearfix"></div>

                     <?php
							 $seasondesti= $this->Common_model->get_records("*","tbl_season_destinations","","","5");
								if (!empty($seasondesti)) {
									 $cnt = 0;
									 $countseasondesti = count($seasondesti);
										foreach ($seasondesti as $seasondestis) {
										$destination_id1 = $seasondestis['destination_id'];
										$par_value_image = $seasondestis['par_value']; 
										
										$seasondesti= $this->Common_model->get_records("destination_url,destination_name","tbl_destination","destination_id ='$destination_id1'","","5"); 
										$cnt++;
											if (!empty($par_value_image)) {
										?>  
											<div class=" <?php if($cnt == 1 ) { ?> col-md-8  <?php } else { ?> col-md-4 <?php } ?> seasondestination">
												<a href="<?php echo base_url().'destination-package/'.$seasondesti[0]['destination_url']; ?>">
													<div class="seasondestination-imgholder">
														 <?php if($cnt == 1 ) { ?>
														 <img  src="#" data-src="<?php echo base_url().'uploads/'.$par_value_image; ?>"  class="img-fluid lazy" alt="<?php echo $seasondesti[0]['destination_name']; ?>">
														  <?php } else { ?>
														  <img  src="#"  data-src="<?php echo base_url().'uploads/'.$par_value_image ; ?>"  class="img-fluid lazy" alt="<?php echo $seasondesti[0]['destination_name']; ?>">
														  <?php } ?>
													 </div>
													<div class="padcontent">
														<p><?php echo $seasondesti[0]['destination_name']; ?></p>
													</div>
												</a>
											 </div>
								<?php } 
							}
						} ?>

                </div>
            </div>
        </section>
		<?php
			$weekend_getaways = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b","a.cat_id=b.catid", "a.menuid=1 and a.status=1 and show_on_home=1","","3");
			if( !empty($weekend_getaways))
			{
		?>
        <section class="weekend-destinations">
            <div class="container weekendcontainer">
                <div class="row">
                    <div class="col-md-12 mb-5 text-center">
                        <h3 class="weekend-title">Top weekend getways</h3>
                        <a href="<?php echo base_url().'getaway' ?>" class="morebutton">View all getways</a>
                    </div>
                </div>

                <div class="weekend-destinations-slider">
                     <div class="row">
                    <?php
						foreach($weekend_getaways as $weekend_getaways_data)
						{
							$weekend_tagid = $weekend_getaways_data['tagid']; 
							$weekend_tagname = $weekend_getaways_data['tag_name'];
							$weekend_tagurl = $weekend_getaways_data['tag_url'];
							$weekend_thumbimg = $weekend_getaways_data['menutagthumb_img'];
							$weekend_catname = $weekend_getaways_data['cat_name'];
							$weekend_cat_seomenu = $this->Common_model->makeSeoUrl($weekend_catname);
					?>
                    <div class="col-lg-4">
                        <div class="destination-sliderbox text-center">
                            <img src="#" data-src="<?php echo base_url().'uploads/'.$weekend_thumbimg; ?>" class="img-fluid lazy" alt="My Holiday Happiness" width="343" height="240">
                            <h4><?php echo $weekend_tagname; ?> </h4>
                            <a href="<?php echo base_url().'getaways/'.$weekend_cat_seomenu.'/'.$weekend_tagurl; ?>" class="morebutton">View details</a>
                        </div>
                    </div>
					<?php } ?>
					 </div>
                </div>
            </div>
        </section>
		<?php } ?>
		
        <section class="itineraries-section lazy-background">
            <div class="container">
                <div class="itinerariesbg">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mt-3">Popular Itineraries</h3></div>
                        <div class="col-md-4 mb-4"><a href="<?php echo base_url(); ?>itineraries" class="morebutton">View all</a></div>
                        <div class="clearfix"></div>                        
                        
                        <?php 
							$itirnary_for_homes=$this->Common_model->get_records("*","tbl_itinerary","show_in_home=1","itinerary_id desc","4","");	
							if(!empty($itirnary_for_homes)) {	
							foreach($itirnary_for_homes as $itirnary_for_home) {				
                        ?>
							<div class="col-xl-3 col-lg-6 col-md-6 itinerariesdestination">
								<a href="<?php echo base_url() . 'itinerary/'.$itirnary_for_home['itinerary_url'] ; ?>">
									<div class="itinerariesdestination-imgholder">
										<img src="#" data-src="<?php echo base_url() . 'uploads/'.$itirnary_for_home['itinerarythumbimg'] ; ?>" class="img-fluid lazy" alt="<?php echo (!empty($itirnary_for_home['alttag_thumb'])) ? $itirnary_for_home['alttag_thumb'] : $itirnary_for_home['itinerary_name']; ?>">
									</div>
									<div class="itinerariescontent"><?php echo $itirnary_for_home['itinerary_name']; ?></div>
								</a>
							</div>
                        <?php 
							}
							}							
						?>
                     
                    </div>
                </div>
            </div>        
        </section>

     <!--   <section class="map-section mb100">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt100">
                        <h3 class="mb-4 text-center">Explore tours on Map</h3>
						<div id="map" style="height:500px"></div>
                        <!--img src="<?php //echo base_url(); ?>assets/images/map.jpg" class="img-fluid" alt=""-->
                    <!--</div>
                </div>
            </div>
        </section> -->

        <section class="testimonialsection">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-4">Recent traveller google reviews</h3>
                        <a href="https://www.google.com/search?q=my+holiday+happiness&oq=my+&aqs=chrome.0.69i59j69i57j69i60l2j69i61j69i60.1286j0j4&sourceid=chrome&ie=UTF-8" target="_blank" class="morebutton  mb-4">View all reviews</a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="testimonial-slider">
                          <div class="row">
                        
					<?php
					   $get_all_reviews = $this->Common_model->get_records("*","tbl_reviews","status=1","review_id desc","3","");
					   foreach($get_all_reviews as $get_all_review) {
						 $no_of_star = $get_all_review['no_of_star'];
					?>
                        <div class="col-lg-4">
                            <div class="reviewbox">
                                <div class="clientname mt-2"><?php echo $get_all_review['reviewer_name']; ?></div>
                                <div class="clientplace"><?php echo $get_all_review['reviewer_loc']; ?></div>
                                <?php
									for ($x = 1; $x <= $no_of_star; $x++) {
										echo '<i class="fas fa-star"></i> ';
									}
									if (fmod($no_of_star, 1) !== 0.00) {
										echo '<i class="fas fa-star-half-alt"></i> ';
										$x++;
									}
									while ($x <= 5) {
										echo '<i class="far fa-star"></i> ';
										$x++;
									}
								?>	
                                <p> <?php echo $this->Common_model->short_str($get_all_review['feedback_msg'],180); ?> 
                                
                                 <?php if(strlen($get_all_review['feedback_msg']) > 180){ ?>
									
										<a href="https://www.google.com/search?q=my+holiday+happiness&oq=my+&aqs=chrome.0.69i59j69i57j69i60l2j69i61j69i60.1286j0j4&sourceid=chrome&ie=UTF-8" style="color:#e8ae71" target="_blank"  aria-label="<?php echo $get_all_review['reviewer_name']; ?>">Read More</a>
									
								<?php } ?>
                                
                                </p>
                                
                               
                            </div>
                        </div>
                        
                        <?php } ?>
</div>
                    </div>	
                </div>
            </div>
        </section>

        <?php

        $getBlogs= $this->Common_model->get_records("*","tbl_blog","status='1' and show_in_home='1'","blogid desc","1","0"); 
        if (!empty($getBlogs)) {
        ?>  
        <section class="blog-section">
            <div class="container">
                <div class="row mt100">
                	
	                    <div class="col-lg-6">
	                        <div class="blogleft">
	                            <div class="mb-4 blogheading">Our blog posts</div><a href="<?php echo base_url()?>blog" class="morebutton">View all</a>	

	                            <div class="blogimage">
	                            	<a href="<?php echo base_url().'blog/'.$getBlogs[0]['blog_url']; ?>"><img src="#" data-src="<?php echo base_url().'uploads/'.$getBlogs[0]['image']; ?>" class="img-fluid lazy" alt="My Holiday Happiness"></a>
	                            </div>
	                            <h4 class="blogtitle"><a href="<?php echo base_url().'blog/'.$getBlogs[0]['blog_url']; ?>"> <?php echo $getBlogs[0]['title'] ?> </a></h4>
	                            <p class="blogcontent"> <?php echo $this->Common_model->short_str($getBlogs[0]['content'],130)  ?></p>
	                        </div>
	                    </div>

                    <div class="col-lg-6">

                    	<?php

                    	$getBlogs= $this->Common_model->get_records("*","tbl_blog","status='1' and show_in_home='1'","blogid desc","2","1");
                    	foreach ($getBlogs as $getBlog) {
		                $title = $getBlog['title']; 
		                $blog_url = $getBlog['blog_url'];  
		                $bimage = $getBlog['image']; 
		                $content = $getBlog['content'];
                        $blog_url = $getBlog['blog_url']; 
		                //$cnt++;  ?>
                        <div class="row mb-2">
                            <div class="rightbloglist blogimage col-md-6"><a href="<?php echo base_url().'blog/'.$blog_url; ?>"><img src="#" data-src="<?php echo base_url().'uploads/'.$bimage; ?>" class="img-fluid lazy" alt="My Holiday Happiness"></a></div>
                            <div class="col-md-6">
                                <h4 class="blogtitle mt-3"><a href="<?php echo base_url().'blog/'.$blog_url; ?>">	<?php echo $title ?> </a></h4>
                                <p class="blogcontent"><?php  echo $this->Common_model->short_str($content,200) ?></p>
                            </div>
                        </div> 

                    	<?php } ?>

	                   
                        <div class="clearfix"></div>
                    </div>
                </div>              
            </div>   
        </section>
    <?php } ?>

		<?php include("footer.php"); ?> 

        <script src="<?php echo base_url(); ?>assets/js/slick.min.js" type="text/javascript"></script>
        <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> 
        
       
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
		
		<script>
		/*	function initMap() {
			    if(document.getElementById('map')){
			        	var map = new google.maps.Map(document.getElementById('map'), {
        				  center: new google.maps.LatLng(11.343730, 76.793854),
        				  zoom: 7
        				});
        				
        				var infoWindow = new google.maps.InfoWindow;
        
        				// Change this depending on the name of your PHP or XML file
        				downloadUrl('<?php echo base_url(); ?>mapmarkers/destinations', function(data) {
        					var xml = data.responseXML;
        					//alert(xml);
        					var markers = xml.documentElement.getElementsByTagName('marker');
        					Array.prototype.forEach.call(markers, function(markerElem) {
        						var id = markerElem.getAttribute('id');
        						var name = markerElem.getAttribute('name');
        						var address = markerElem.getAttribute('address');
        						var price = markerElem.getAttribute('price');
        						var point = new google.maps.LatLng(
        							parseFloat(markerElem.getAttribute('lat')),
        							parseFloat(markerElem.getAttribute('lng')));
        						var title = name+" @"+price;
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
        								scaledSize: new google.maps.Size(160, 40)
        							}
        						});
        						marker.addListener('click', function() {
        							window.location = '<?php echo base_url()."destination-package/"; ?>'+address;						
        						});
        						
        					});
        				});
			    }
			
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
			}*/

			function doNothing() {}
		</script>
		
<!--	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-kVx0UE86TuBIo7cQnKyaeem2SxzeHK0&callback=initMap">
		</script>-->
    </body>
</html>
