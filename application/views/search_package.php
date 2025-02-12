<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?>
	</head>
    <body>
		<?php include("header.php"); ?> 
		
        <section class="main">
            <div id="ri-grid" class="ri-grid ri-grid-size-2 ">
                <img class="ri-loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif" alt="My Holiday Happiness"/>
                <ul>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/1.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/2.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/3.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/4.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/5.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/6.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/7.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/8.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/9.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/10.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/11.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/12.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/13.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/14.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/15.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/16.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/17.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/18.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/19.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/20.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/21.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/22.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/23.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/24.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/25.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/26.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/27.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/28.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/29.jpg" alt="My Holiday Happiness"/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/30.jpg" alt="My Holiday Happiness"/></a></li>

                </ul>
            </div>              
        </section>
		
		
        <section class="touristlist">
            <div class="container  mt60 mb60">
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <h3><?php echo $noof_tour_packages; ?> Tour Packages Found.</h3>
                    </div>
					
                    <div class="col-md-5 mb-4">
						<?php echo form_open(base_url('search-package'), array( 'id' => 'form_contact', 'name' => 'form_contact', 'class' => 'row listform', 'method'=> 'get' ));?>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">                          
                                    <select class="selectpicker" title="Select Destination" id="destination" name="destination" onchange="this.form.duration.value='';this.form.submit()">
                                        <option value="">Select Destination</option>
                                        <?php
											if((isset($_REQUEST["destination"])) && ($_REQUEST["destination"] != ""))
												$destination = $_REQUEST["destination"];
											else
												$destination = "";
                                            echo $this->Common_model->populate_destination($destination);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">                          
                                    <select class="selectpicker" title="Select Trip Duration" id="duration" name="duration" onchange="this.form.submit()">
                                        <option value="">Select Duration</option>
										<?php 
											if((isset($_REQUEST["duration"])) && ($_REQUEST["duration"] != ""))
												$duration = $_REQUEST["duration"];
											else
												$duration = "";
											echo $this->Common_model->populate_duration($destination, $duration);
										?>
									</select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php echo form_close();?>
                    </div>
					
					
					<?php
					if($noof_tour_packages>0)
					{
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
							$alttag_banner = $tour_package["alttag_banner"];
							
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
							
                            <a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : "My Holiday Happiness"; ?>"></a>
                            <?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
                            <div class="tourist-duration"><?php echo $show_duration; ?></div>				 
                        </div>
                        <div class="tourist-bottom-details">
                            <ul class="iconlist">
                                <?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accommodation"></li><?php endif; ?>
                                <?php if($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li><?php endif; ?>
                                <?php if($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li><?php endif; ?>	
                                <?php if($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li><?php endif; ?>
								<?php if($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li><?php endif; ?>
                            </ul>			  
                            <div class="touristlist-hdng"><?php echo $tpackage_name; ?> <?php /*if($noof_assoc_dest > 0): ?>| <?php echo $show_assoc_dests; ?><?php endif;*/ ?></div>
                            <div class="tourbutton"><a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></div>
                            <div class="tourprice"><span class="packageCostOrig priceline"><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
					
					<?php } } else { ?>
						<div class="col-md-12 text-center">
							<h1>No Packages Found !</h1>
						</div>					
					<?php } ?>
				</div>
            </div>
        </section>
		       
        
		<?php include("footer.php"); ?>     
		
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/scrollBar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.gridrotator.js"></script>
        
        <script>          
            $(".sb-container").scrollBox();
        </script>   
       
         <script type="text/javascript">
            $(function () {

                $('#ri-grid').gridrotator({
                    rows: 2,
                    columns: 10,
                    animType: 'fadeInOut',
                    animSpeed: 1000,
                    interval: 600,
                    step: 1,
                    w320: {
                        rows: 3,
                        columns: 4
                    },
                    w240: {
                        rows: 3,
                        columns: 4
                    }
                });

            });
        </script>
        
       
    </body>
</html>
