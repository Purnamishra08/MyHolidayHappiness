<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
    <body>
		<?php include("header.php"); ?> 
		
        <section class="bannerdesti-package">			
		<?php 		
			$dataDests = $this->Common_model->get_records("destiimg,destination_name,alttag_banner","tbl_destination","destination_id=$destination_id");
			$destiimg = $dataDests[0]['destiimg'];
			$alttag_banner = $dataDests[0]['alttag_banner'];			
			if(file_exists("./uploads/".$destiimg) && ($destiimg!='')) {
				$dest_banner_img = base_url()."uploads/".$destiimg;
			}
			else 
				$dest_banner_img = base_url()."assets/images/golden-triangel-banner.jpg";
		?>
            <img src="<?php echo $dest_banner_img; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_banner)) ? $alttag_banner : $dataDests[0]['destination_name']; ?>">
			<div class="tourist-banner-searchcontainer">
				<div class="container">
					<div class="row">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<div class="inner-topsearch-box text-center">
							
									<?php echo $dataDests[0]['destination_name']; ?> Tour Packages
							
							</div>
						</div>
						<div class="col-lg-3"></div>
						<div class="clearfix"></div>			  
					</div>
				</div>		 
			</div> 
        </section>		
		
        <section class="touristlist">
            <div class="container  mt60 mb60">
                 <ul class="cbreadcrumb my-3">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="/tour-packages">Tour Packages</a></li>
                  <li><a href="#"><?php echo $dataDests[0]['destination_name']; ?> Tour Packages</a></li>
                </ul>
                <div class="row">
                    <div class="col-md-7 mb-4">
                       <?php if(!empty($tour_packages)){ ?> <h1><?php echo count($tour_packages); ?> <?php echo $dataDests[0]['destination_name']; ?>  Tour Packages Found.</h1> <?php } ?>
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
				
				<div class="row" id="search_result">	
					<div id="loader"></div>						
					<?php
						if(!empty($tour_packages)){
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
					
                    <div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
                        <div class="touristdetails-imgholder">
							<?php if (!empty($pack_type)) { 
								$class = ($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon' ; 
							?> 
								<div class="<?php echo $class ; ?>">
									<span><?php echo $this->Common_model->showname_fromid("par_value","tbl_parameters","parid ='$pack_type' and param_type = 'PT' "); ?></span>
								</div>
								
							<?php } ?>
							
                            <a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="My Holiday Happiness"></a>
                            <?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
                            <div class="tourist-duration"><?php echo $show_duration; ?></div>				 
                        </div>
                        <div class="tourist-bottom-details">
                            <ul class="iconlist">
                                <?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation" width="24" height="24"></li><?php endif; ?>
                                <?php if($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation" width="24" height="24"></li><?php endif; ?>
                                <?php if($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing" width="24" height="24"></li><?php endif; ?>	
                                <?php if($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast" width="24" height="24"></li><?php endif; ?>
								<?php if($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle" width="24" height="24"></li><?php endif; ?>
                            </ul>			  
                            <div class="touristlist-hdng"><?php echo $tpackage_name; ?> <?php /*if($noof_assoc_dest > 0): ?>| <?php echo $show_assoc_dests; ?><?php endif;*/ ?></div>
                            <div class="tourbutton"><a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></div>
                            <div class="tourprice"><span class="packageCostOrig priceline"><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
					<?php } ?>
				</div>
            </div>
        </section>
		<?php } else { ?>
			<section class="touristlist">
				<div class="container  mt60 mb60">
					<div class="row">
						<div class="col-md-12 text-center">
							<h1>No Packages Found !</h1>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>
		
		<section class="innergoogle-review" >
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
						$dURL = $destIds->destination_url;
						$alttag_thumb = $destIds->alttag_thumb;
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
        
		<?php include("footer.php"); ?>     
		
        <!--script src="https://code.jquery.com/jquery-1.9.1.min.js"></script-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scrollBar.js"></script>
        
        <script>
            $(function () {
                $('.selectpicker').selectpicker();
            });
            $(".sb-container").scrollBox();
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
