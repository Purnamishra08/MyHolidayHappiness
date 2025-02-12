<?php
if(!empty($statedata)){
    foreach ($statedata as $stateres)
    {
		$state_id = $stateres['state_id'];
		$state_name = $stateres['state_name'];
		$state_urlfinal = $stateres['state_url'];
		$state_bannerimg = $stateres['bannerimg'];
	}
	
	$noof_state_destids = $this->Common_model->noof_records("destination_id","tbl_destination","state=$state_id and status=1"); 
	
	$noof_destids = array();
	if($noof_state_destids>0)
	{
		$state_destids = $this->Common_model->get_records("destination_id","tbl_destination", "state=$state_id and status=1");
		foreach ($state_destids as $statedestids)
		{
			$noof_destids[] = $statedestids["destination_id"];
		}
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
        <section>
            <img src="<?php echo base_url(); ?><?php if(($state_bannerimg!='') && file_exists("./uploads/".$state_bannerimg)){   echo 'uploads/'.$state_bannerimg; }else{   ?>assets/images/getaways.jpg  <?php }?>" class="img-fluid">
		</section>
        <section class=" mb100">
            <div class="container">
                <ul class="cbreadcrumb my-4">
                 
                      <li><a href="/">Home</a></li>
                      <li><a href="#"><?php echo $state_name; ?></a></li>
                    </ul>
                <div class="row">
                    <div class="col-xl-4 co-lg-4">
                        <div class="getway-sec getwaystate">
                            							
                            <div class="packlist mb-4">
								<?php
									if(count($noof_destids) > 0)
									{
										$destination_ids = implode(",", $noof_destids);
										$tourpkg = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id in ($destination_ids)) and `status` = 1","RAND()", "10");
									}
									else										
										$tourpkg = $this->Common_model->get_records("*","tbl_tourpackages","status='1'","RAND()","10");       
									
									if (!empty($tourpkg)) {
								?>                            
								<h2> Popular <?php echo $state_name; ?> Tour Packages</h2>
                                <ul>
									<?php 
										foreach ($tourpkg as $tourpkgs) { 
											$tourpackageid = $tourpkgs['tourpackageid']; 
											$tpackage_name = $tourpkgs['tpackage_name'];
											$tpackage_url = $tourpkgs['tpackage_url'];
											$price = $tourpkgs['price'];
											$fakeprice = $tourpkgs['fakeprice'];
											$itinerary = $tourpkgs["itinerary"];
											
											$starting_city = $tourpkgs["starting_city"];
											$starting_city_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id=$starting_city");
									?>
                                    <li>
										<a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><?php echo $tpackage_name; ?></a>
										<?php if ($starting_city_name != ""): ?><span>Ex-<?php echo $starting_city_name; ?></span><?php endif; ?>
										<div style="float: right;">
											<span class="packageCostOrig" style="text-decoration: line-through; color: #A0A0A0; font-size:14px" ;><?php echo $this->Common_model->currency; ?><?php echo $fakeprice; ?></span>
											<span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $price; ?></span>
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

                    <div class="col-xl-8 col-lg-8">
						<h1 class="mb-2 bluefont"><?php echo $state_name; ?></h1>
                        <div class="getwaybg">	
							<?php
								$noof_state_dests = $this->Common_model->noof_records("destination_id","tbl_destination","state=$state_id and status=1"); 
								
								if($noof_state_dests>0)
								{
									$count = 1;
									$state_dests = $this->Common_model->get_records("*","tbl_destination", "state=$state_id and status=1","destination_name asc");
									foreach ($state_dests as $statedest)
									{
										$state_dest_id = $statedest['destination_id'];
										$state_destinationurl = $statedest['destination_url'];
										$state_about_dest = $statedest['about_destination'];
										
										$dest_types = array();
										$show_dest_types = "";
										$noof_dest_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$state_dest_id and loc_type = 1"); 
										if($noof_dest_types > 0)
										{										
											$dest_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$state_dest_id and a.loc_type = 1 and b.status=1","b.destination_type_name asc");
											foreach ($dest_type_datas as $desttype)
											{
												$dest_types[] = $desttype['destination_type_name'];
											}										
										}
										
										if(count($dest_types) > 0)
										{
											$show_dest_types = implode(" | ", $dest_types);
										}
										
										$state_dest_packages = $this->Common_model->noof_records("DISTINCT(tourpackageid) as package_id", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $state_dest_id) and status=1");

										if (!empty($state_dest_packages)) {	
											$state_dest_minprice = $this->Common_model->showname_fromid("MIN(price)", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $state_dest_id) and status=1");
										}
							?>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <h2 class="mb-2 bluefont"> <?php echo $statedest['destination_name']; ?> </h2>
                                </div>
                                <div class=" col-xl-4 col-lg-4">
                                    <div class="get-image">
                                        <img src="<?php echo base_url()."uploads/".$statedest['destiimg_thumb']; ?>" class="img-fluid" alt="<?php echo (!empty($statedest['alttag_thumb'])) ? $statedest['alttag_thumb'] : $statedest['destination_name']; ?>">
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
                                        <p><?php echo $this->Common_model->short_str("$state_about_dest", "300"); ?></p>									
										<ul class="btn-innersec">
											<li class="v-btn"><a href="<?php echo base_url().'destination/'.$state_urlfinal.'/'.$state_destinationurl; ?>">Overview</a> </li>
											<?php 
												$noofgetaway_dest_places =  $this->Common_model->noof_records("placeid","tbl_places","destination_id=$state_dest_id and status=1"); 
												if($noofgetaway_dest_places > 0)
												{
											?>
											<li class="visit-btn"><a href="<?php echo base_url().'places-to-visit/'.$state_urlfinal.'/'.$state_destinationurl; ?>">Places to Visit</a> </li>
											<?php } ?>
											
											<?php if (!empty($state_dest_packages)) { ?>
											<li class="package-btnnew"><a href="<?php echo base_url().'destination-package/'.$state_destinationurl; ?>">Packages from <?php echo $this->Common_model->currency; ?><?php echo $state_dest_minprice; ?></a> </li>
											<?php } ?>
										</ul>										
									</div>
								</div>
							</div>
							
							<?php if($count < $noof_state_dests) echo "<hr>"; ?>							
							<?php $count++; } } ?>							
							
							<?php if($noof_state_dests<1): ?>
							<h5>No destinations found!</h5>
							<?php endif; ?>
								
                        </div>
                    </div>
                    </div>

                </div>
            </div>
        </section>

        <?php include("footer.php"); ?>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
		<script>
			$(document).ready(function() {
				$("#myModal ").modal('show');
			});
		</script>
	</body>
</html>
