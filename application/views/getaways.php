<?php
if(!empty($getawaydata)){
    foreach ($getawaydata as $getaway)
    {
		$getaway_id = $getaway['tagid'];
		$getaway_name = $getaway['tag_name'];
		$getaway_url = $getaway['tag_url'];
		$getaway_about = $getaway['about_tag'];
		$getaway_img = $getaway['menutag_img'];
		$getawayalttag_banner = $getaway['alttag_banner'];
	}
}
?>
<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
        <section style="position:relative;">
			<?php 
				if(file_exists("./uploads/".$getaway_img) && ($getaway_img!='')) {
					$getaway_img = base_url()."uploads/".$getaway_img;
				}
				else 
					$getaway_img = base_url()."assets/images/getaways.jpg";
			?>
            <img src="<?php echo $getaway_img; ?>" class="img-fluid" alt="<?php echo (!empty($getawayalttag_banner)) ? $getawayalttag_banner : $getaway_name; ?>">
			<div class="courtesy-txt"> Courtesy - Flickr </div>
		</section>
        <section class=" mb100">
            <div class="container">
                <ul class="cbreadcrumb my-3">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="/getaway">Getaways</a></li>
                  <li><a href="#"><?php echo $getaway_name; ?></a></li>
                </ul>
                <div class="row sec-right-left">
                    
                 
                  

                    <div class="col-xl-8 col-lg-8 sec-right">
						<h1 class="mb-2 bluefont"><?php echo $getaway_name; ?></h1>
                        <div class="getwaybg">	
							<?php
								$noof_getaway_dests = $this->Common_model->noof_records("a.tag_id","tbl_tags as a, tbl_destination as b","a.type_id=b.destination_id and a.tagid=$getaway_id and a.type=1 and b.status=1"); 
								
								if($noof_getaway_dests>0)
								{
									$count = 1;
									$getaway_dests = $this->Common_model->join_records("a.*, b.destination_url, b.destination_name, b.destiimg_thumb, b.alttag_thumb, b.state, b.about_destination","tbl_tags as a","tbl_destination as b", "a.type_id=b.destination_id", "a.tagid=$getaway_id and a.type=1 and b.status=1","b.destination_name asc");
									foreach ($getaway_dests as $getawaydest)
									{
										$getaway_dest_id = $getawaydest['type_id'];
										$getaway_destinationurl = $getawaydest['destination_url'];
										$getaway_about_dest = $getawaydest['about_destination'];
										$getaway_stateid = $getawaydest['state'];		
										$alttag_thumb = $getawaydest['alttag_thumb'];	
										$getaway_state_url = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$getaway_stateid'");
										
										$dest_types = array();
										$show_dest_types = "";
										$noof_dest_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$getaway_dest_id and loc_type = 1"); 
										if($noof_dest_types > 0)
										{										
											$dest_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$getaway_dest_id and a.loc_type = 1 and b.status=1","b.destination_type_name asc");
											foreach ($dest_type_datas as $desttype)
											{
												$dest_types[] = $desttype['destination_type_name'];
											}										
										}
										
										if(count($dest_types) > 0)
										{
											$show_dest_types = implode(" | ", $dest_types);
										}
										
										$getaway_dest_packages = $this->Common_model->noof_records("DISTINCT(tourpackageid) as package_id", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $getaway_dest_id) and status=1");

										if (!empty($getaway_dest_packages)) {	
											$getaway_dest_minprice = $this->Common_model->showname_fromid("MIN(price)", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $getaway_dest_id) and status=1");
										}
							?>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4 class="mb-2 bluefont"> <?php echo $getawaydest['destination_name']; ?> </h4>
                                </div>
                                <div class=" col-xl-4 col-lg-4">
                                    <div class="get-image">
                                        <img src="<?php echo base_url()."uploads/".$getawaydest['destiimg_thumb']; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : $getawaydest['destination_name']; ?>">
                                    </div>
                                </div>
                                <div class=" col-xl-8 col-lg-8">
                                    <div class="getwaycontent">
										<?php if($show_dest_types !="") { ?>
										<div class="tag-list">
											<ul>
												<li><i class="fas fa-tags"></i> <?php echo $show_dest_types; ?></li>
											</ul>
										</div>
										<?php } ?>
                                        <p><?php echo $this->Common_model->short_str("$getaway_about_dest", "300"); ?></p>									
										<ul class="btn-innersec">
											<li class="v-btn"><a href="<?php echo base_url().'destination/'.$getaway_state_url.'/'.$getaway_destinationurl; ?>" target="_blank">Overview</a> </li>
											<?php 
												$noofgetaway_dest_places =  $this->Common_model->noof_records("placeid","tbl_places","destination_id=$getaway_dest_id and status=1"); 
												if($noofgetaway_dest_places > 0)
												{
											?>
											<li class="visit-btn"><a href="<?php echo base_url().'places-to-visit/'.$getaway_state_url.'/'.$getaway_destinationurl; ?>" target="_blank">Places to Visit</a> </li>
											<?php } ?>
											
											<?php if (!empty($getaway_dest_packages)) { ?>
											<li class="package-btnnew"><a href="<?php echo base_url().'destination-package/'.$getaway_destinationurl; ?>" target="_blank">Packages from <?php echo $this->Common_model->currency; ?><?php echo $getaway_dest_minprice; ?></a> </li>
											<?php } ?>
										</ul>										
									</div>
								</div>
							</div>
							
							<?php if($count < $noof_getaway_dests) echo "<hr>"; ?>							
							<?php $count++; } } ?>
							
							
							<?php
								$noof_getaway_places = $this->Common_model->noof_records("a.tag_id","tbl_tags as a, tbl_places as b","a.type_id=b.placeid and a.tagid=$getaway_id and a.type=2 and b.status=1"); 
								if($noof_getaway_places>0)
								{
							?>
							<hr>						
								<?php
									$count1 = 1;
									$getaway_places = $this->Common_model->join_records("a.*, b.destination_id, b.place_name, b.place_url, b.placethumbimg, b.alttag_thumb, b.about_place","tbl_tags as a","tbl_places as b", "a.type_id=b.placeid", "a.tagid=$getaway_id and a.type=2 and b.status=1","b.place_name asc");
									foreach ($getaway_places as $getawayplace)
									{
										$getaway_place_id = $getawayplace['type_id'];
										$getawayplace_destid = $getawayplace['destination_id'];
										$getaway_place_url = $getawayplace['place_url'];
										$getaway_aboutplace = $getawayplace['about_place'];
										
										$getaway_place_dest_data = $this->Common_model->join_records("a.destination_url, b.state_url","tbl_destination as a","tbl_state as b", "a.state=b.state_id", "a.destination_id=$getawayplace_destid");
										foreach ($getaway_place_dest_data as $getaway_placedest)
										{
											$getawayplace_destinationurl = $getaway_placedest['destination_url'];
											$getawayplace_state_url =  $getaway_placedest['state_url'];
										}
										
										$place_types = array();
										$show_place_types = "";
										$noof_place_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$getaway_place_id and loc_type = 2"); 
										if($noof_place_types > 0)
										{										
											$place_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$getaway_place_id and a.loc_type=2 and b.status=1","b.destination_type_name asc");
											foreach ($place_type_datas as $placetype)
											{
												$place_types[] = $placetype['destination_type_name'];
											}									
										}
										
										if(count($place_types) > 0)
										{
											$show_place_types = implode(" | ", $place_types);
										}
										
										$getaway_place_packages = $this->Common_model->noof_records("DISTINCT(tourpackageid) as package_id", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$getaway_place_id' or place_id like '$getaway_place_id,%' or place_id like '%,$getaway_place_id' or place_id like '%,$getaway_place_id,%') and status=1");
		
										if(!empty($getaway_place_packages)) {	
											$getaway_place_minprice = $this->Common_model->showname_fromid("MIN(price)", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$getaway_place_id' or place_id like '$getaway_place_id,%' or place_id like '%,$getaway_place_id' or place_id like '%,$getaway_place_id,%') and status=1");
										}
								?>
							<div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h4 class="mb-2 bluefont"> <?php echo $getawayplace['place_name']; ?> </h4>
                                </div>
                                <div class=" col-xl-4 col-lg-4">
                                    <div class="get-image">
                                        <img src="<?php echo base_url()."uploads/".$getawayplace['placethumbimg']; ?>" class="img-fluid" alt="<?php echo (!empty($getawayplace['alttag_thumb'])) ? $getawayplace['alttag_thumb'] : $getawayplace['place_name']; ?>">
                                    </div>
                                </div>
                                <div class=" col-xl-8 col-lg-8">
                                    <div class="getwaycontent">
										<?php if($show_place_types !="") { ?>
										<div class="tag-list">
											<ul>
												<li><i class="fas fa-tags"></i> <?php echo $show_place_types; ?></li>
											</ul>
										</div>
										<?php } ?>
                                        <p><?php echo $this->Common_model->short_str("$getaway_aboutplace", "300"); ?></p>									
										<ul class="btn-innersec">
											<li class="v-btn"><a href="<?php echo base_url().'place/'.$getawayplace_state_url.'/'.$getawayplace_destinationurl.'/'.$getaway_place_url; ?>" target="_blank">Overview</a> </li>
											<?php if(!empty($getaway_place_packages)) { ?>
											<li class="package-btnnew"><a href="<?php echo base_url().'place-package/'.$getaway_place_url;  ?>" target="_blank">Packages from <?php echo $this->Common_model->currency; ?><?php echo $getaway_place_minprice; ?></a> </li>
											<?php } ?>
										</ul>										
									</div>
								</div>
                            </div>
							<?php if($count1 < $noof_getaway_places) echo "<hr>"; ?>	
							<?php $count1++; } } ?>
							
							<?php if(($noof_getaway_dests<1) && ($noof_getaway_places<1)): ?>
							<h5>No destinations or places found!</h5>
							<?php endif; ?>
								
                        </div>
                    </div>
                    
                    
                        <div class="col-xl-4 co-lg-4 sec-left">
                        <div class="getway-sec">
                            <?php
								$popular_getaways = $this->Common_model->join_records("a.tag_name, a.tag_url, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b","a.cat_id=b.catid", "a.menuid=1 and a.status=1 and tagid!=$getaway_id","RAND()","10");
								if( !empty($popular_getaways))
								{
							?>
							<h5>Popular Getaways</h5>
                            <nav class="leftsidemenulist mb-4">
                                <ul>
									<?php
										foreach ($popular_getaways as $getaways_data)
										{
											$popular_getaway_name = $getaways_data['tag_name'];
											$popular_getaway_url = $getaways_data['tag_url'];
											$popular_cat_name = $getaways_data['cat_name'];
											$popular_cat_seomenu = $this->Common_model->makeSeoUrl($popular_cat_name);
									?>
                                    <li><a href="<?php echo base_url().'getaways/'.$popular_cat_seomenu.'/'.$popular_getaway_url; ?>" target="_blank"><?php echo $popular_getaway_name; ?></a></li>
									<?php } ?>
                                </ul>
                            </nav>
							<?php } ?>
							
                            <div class="packlist mb-4">
								<?php
									$mostpopular_tours = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b","a.cat_id=b.catid", "a.menuid=3 and a.status=1 and show_on_home=1 and a.tagid IN (SELECT tagid FROM `tbl_tags` WHERE type=3)","RAND()","10");
									if( !empty($mostpopular_tours))
									{
								?>                            
								<h2>Most Popular Tours</h2>
                                <ul>
									<?php 
										foreach($mostpopular_tours as $mostpopular_tours_data)
										{
											$mostpopular_tagid = $mostpopular_tours_data['tagid']; 
											$mostpopular_tagname = $mostpopular_tours_data['tag_name'];
											$mostpopular_tagurl = $mostpopular_tours_data['tag_url'];
											$mostpopular_thumbimg = $mostpopular_tours_data['menutagthumb_img'];
											$mostpopular_catname = $mostpopular_tours_data['cat_name'];
											$mostpopular_cat_seomenu = $this->Common_model->makeSeoUrl($mostpopular_catname);
											
											$noof_popular_tourpackages = $this->Common_model->noof_records("DISTINCT(a.type_id) as package_id","tbl_tags as a, tbl_tourpackages as b","a.type_id = b.tourpackageid and a.tagid ='$mostpopular_tagid' and a.type=3 and b.status=1");
											
											$tourpackages_MinPrice = $this->Common_model->showname_fromid("MIN(b.price)", "tbl_tags as a, tbl_tourpackages as b", "a.type_id=b.tourpackageid and a.tagid ='$mostpopular_tagid' and a.type=3 and b.status=1");
									?>
                                    <li>
										<a href="<?php echo base_url().'tours/'.$mostpopular_cat_seomenu.'/'.$mostpopular_tagurl; ?>" target="_blank"><?php echo $mostpopular_tagname; ?></a>
										<span><?php echo $noof_popular_tourpackages; ?> Tour Packages</span>
										<div style="float: right;">
											<span class="packageCostOrig" style="color: #A0A0A0; font-size:14px" ;>Tour Starts From</span>
											<span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $tourpackages_MinPrice; ?></span>
										</div>
										<div class="clearfix"></div>
									</li>									
									<?php } ?>
                                </ul>                           
								<?php } ?>
								
								<div class="rightbookingbox">
									<h3>Get our assistance for easy booking</h3>
									<a href="<?php echo base_url().'contactus#contactform'; ?>" target="_blank"><span class="cullusbtn">Want us to call you?</span></a>
									<p>Or call us at</p>
									<h5><?php echo $this->Common_model->show_parameter(3); ?></h5>
								</div>							
							</div>
							
						</div>
                    </div>
                    
                    
                    
                     
                    
                    
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
        </section>

        <?php include("footer.php"); ?>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> 
        
          
        <script> 
			
            $(function () {
                $('.selectpicker').selectpicker();
            });
       
        </script>
		<script>
			$(document).ready(function() {
				$("#myModal ").modal('show');
			});
		</script>
	</body>
</html>
