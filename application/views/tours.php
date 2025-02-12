<?php
if(!empty($tag_data)){
    foreach ($tag_data as $tag_res)
    {
		$tour_tagid = $tag_res['tagid'];
        $tour_menuid = $tag_res['menuid'];
        $tourcat_id = $tag_res['cat_id'];
        $tour_tag_name = $tag_res['tag_name'];
		$tour_about_tag = $tag_res['about_tag'];		
        $tour_img = $tag_res['menutag_img'];        
		$getawayalttag_banner = $tag_res['alttag_banner'];
    } 
}
?>
<?php 
				if(file_exists("./uploads/".$tour_img) && ($tour_img!='')) {
					$tour_img = base_url()."uploads/".$tour_img;
				}
				else 
					$tour_img = base_url()."assets/images/golden-triangel-banner.jpg";
			?>
<!doctype html>
<html lang="en">
	<head>
	   <link rel="preload" href="<?php echo $tour_img; ?>" as="image">
		<?php include("head.php"); ?>
	</head>
    <body>
		<?php include("header.php"); ?> 
		
        <section class="touristmain-banner">
			
            <img src="<?php echo $tour_img; ?>" class="img-fluid" alt="<?php echo (!empty($getawayalttag_banner)) ? $getawayalttag_banner : $tour_tag_name; ?>" style="min-height:386px;min-width: 100%;" width="1200" height="386">
            <div class="tourist-banner-searchcontainer">
                <div class="container">
                   
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <div class="inner-topsearch-box text-center">
                                <h1>
                                    <?php echo $tour_tag_name; ?>
                                    </h1>	
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="clearfix"></div>			  
                    </div>
                </div>		 
            </div>
        </section>

		<?php if(!empty($tour_about_tag)) { ?>
		<div class="container mt60">
		     <ul class="cbreadcrumb my-4">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="/tour-packages">Tour Packages</a></li>
                  <li><a href="#"><?php echo $tour_tag_name; ?></a></li>
                </ul>
			<h2>Best <?php echo $tour_tag_name; ?> by My Holiday Happiness</h2>
		</div>
		<div class="container">
			<div class="aboutdesc" style="padding-top: 15px;">
				<div class="sb-container" style="max-height: 125px;" id="description">
					<?php echo $tour_about_tag; ?>
				</div>						
				<a href="JavaScript:void(0);" class="readshow" style="text-decoration: none;">Read more</a> 
			</div>
		</div>
		<?php } ?>

		<?php
			$noof_tour_packages = $this->Common_model->noof_records("a.tag_id","tbl_tags as a, tbl_tourpackages as b","a.type_id=b.tourpackageid and a.tagid=$tour_tagid and a.type=3 and b.status=1"); 
			
			if($noof_tour_packages>0)
			{
		?>
        <section class="touristlist">
            <div class="container mt40 mb30">
                	<?php if(empty($tour_about_tag)) { ?>
	
		     <ul class="cbreadcrumb my-4">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="/tour-packages">Tour Packages</a></li>
                  <li><a href="#"><?php echo $tour_tag_name; ?></a></li>
                </ul><?php } ?>
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <h3>
                            <?php echo $noof_tour_packages; ?> Best <?php echo $tour_tag_name;  ?> Found.
                            </h3>
                    </div>
                    <div class="col-md-5 mb-4">
						<?php echo form_open(base_url('tours'), array( 'id' => 'search_form', 'name' => 'search_form', 'class' => 'row listform'));?>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">                          
                                    <select class="selectpicker" name="starting_city" id="starting_city">
                                        <option value="">Select Starting City</option>
										<?php
											$destination_qry = $this->db->query("SELECT destination_id, destination_name FROM tbl_destination WHERE status=1 and destination_id in (select distinct(b.starting_city) from tbl_tags as a inner join tbl_tourpackages as b on a.type_id=b.tourpackageid where a.tagid=$tour_tagid and a.type = 3 and b.status = 1) ORDER BY destination_name asc");
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
											$durations_qry = $this->db->query("SELECT durationid, duration_name FROM tbl_package_duration WHERE status=1 and durationid in (select distinct(b.package_duration) from tbl_tags as a inner join tbl_tourpackages as b on a.type_id=b.tourpackageid where a.tagid=$tour_tagid and a.type = 3 and b.status = 1) ORDER BY no_ofdays asc");
											$durations = $durations_qry->result_array();
											foreach($durations as $duration)
											{
										?>
										<option value="<?php echo $duration['durationid']; ?>"><?php echo $duration["duration_name"]; ?></option>
										<?php  
											}
										?>
									</select>
									<input type="hidden" name="tagid" id="tagid" value="<?php echo $tour_tagid; ?>">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php echo form_close();?>
                    </div>
				</div>
				
				<div class="row" id="search_result">	
					<div id="loader"></div>
					<?php
						$tour_packages = $this->Common_model->join_records("a.*, b.*","tbl_tags as a","tbl_tourpackages as b", "a.type_id=b.tourpackageid", "a.tagid=$tour_tagid and a.type=3 and b.status=1","b.tpackage_name asc");
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
								$class = 	($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon' ; 
								?> 
								<div class="<?php echo $class ; ?>">
									<span><?php echo $this->Common_model->showname_fromid("par_value","tbl_parameters","parid ='$pack_type' and param_type = 'PT' "); ?></span>
								</div>
								
							 <?php } ?>
							
                            <a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="#" data-src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid lazy" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : "My Holiday Happiness"; ?>"></a>
                            <?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
                            <div class="tourist-duration"><?php echo $show_duration; ?></div>				 
                        </div>
                        <div class="tourist-bottom-details">
                            <ul class="iconlist">
                                <?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accommodation" width="24" height="24"></li><?php endif; ?>
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
		<?php }else { ?>
        <section class="touristlist">
            <div class="container  mt60 mb30">
                <div class="row">
                    <div class="col-md-12 text-center">
						<h1>No Packages Found !</h1>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>
		
		<?php 
			$faq_data = $this->Common_model->get_records("*","tbl_package_faqs","status = 1 AND tag_id = $tour_tagid","faq_order ASC","" ,"");
			if (!empty($faq_data)) { 
		?>
		<div class="container mb60">
			<div class="row">
				<div class="col-md-12" style="padding: 15px;">
					<h4 class="mb-2">Frequently Asked Questions about <?php echo $tour_tag_name; ?></h4>
					<div id="accordion" role="tablist" aria-multiselectable="true" class="faqaccordion">
						<?php
						$cnt = 0;
							foreach ($faq_data as $key => $rows) {
								$cnt++;
								$faq_id = $rows['faq_id'];
								$created_date = $rows['created_date'];
								$status = $rows['status'];
								?>
						
								<div class="card">							
									<div class="card-header" role="tab" id="heading<?php echo $cnt; ?>">
										<div class="mb-0">
											<a data-toggle="collapse" href="#collapse<?php echo $cnt; ?>" aria-expanded="true" aria-controls="collapse<?php echo $cnt; ?>" class="collapsed">
												<img src="#" data-src="<?php echo base_url(); ?>assets/images/headingarrow.png" class="fa-pull-left lazy" alt="My Holiday Happiness">
												<h5> <?php echo $rows['faq_question']; ?></h5>                                      
											</a>
										</div>
									</div>

									<div id="collapse<?php echo $cnt; ?>" class="collapse" aria-labelledby="heading<?php echo $cnt; ?>" data-parent="#accordion">
										<div class="card-block">
											<?php echo $rows['faq_answer']; ?>
										</div>
									</div>
								</div>
							<?php
							}
						?>                      
					</div>  
				</div>              
			</div>
		</div>
		<?php } ?>

		<div class="clearfix"></div>
		<section class="innergoogle-review" >
            <?php include("verified_reviews.php"); ?>  
        </section>
        
        
		<?php	 
		$getdestIds = $this->db->query("SELECT a.destination_id,a.destination_name,a.destination_url,a.destiimg_thumb, a.alttag_thumb from tbl_destination as a INNER JOIN tbl_tourpackages as b INNER JOIN (SELECT destination_id,itinerary_id FROM tbl_itinerary_destination) as c ON a.destination_id = c.destination_id AND b.itinerary = c.itinerary_id WHERE b.status = 1 and a.status = 1 GROUP BY a.destination_id ORDER BY a.destination_id DESC LIMIT 12");	
		//echo $this->db->last_query();
											
		$destIds = $getdestIds->result(); 
		if(!empty($destIds)){
		?>
        <section class="tours-in-india-bottom-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 text-center">
                        <h4 class="mb-2">Most Popular Tours in India</h4>
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
						<img src="#" data-src="<?php echo $dest_thumb_img ; ?>" class="img-fluid lazy" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : $destIds->destination_name; ?>">
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
					url: "<?php echo base_url(); ?>tours/search",
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
			});

			$(document).ready(function () {
                $(".readshow").click(function () {					
					var readval = $(".readshow").html();
					if(readval=="Read more")
					{
						$("#description").css({"max-height":"200px"});
						$("#description .sb-content").css({"max-height":"200px"});
						$(".readshow").html("Read less");
					}
					else 
					{
						$("#description").css({"max-height":"125px"});
						$("#description .sb-content").css({"max-height":"125px"});
						$(".readshow").html("Read more");
					}
                });
            });
		</script>
		
    </body>
</html>
