<!doctype html>
<html>
	<head>
		<?php include("head.php"); ?> 
	</head>
    <body>
      <?php include("header.php"); ?>
      
      <section class="main">
            <div id="ri-grid" class="ri-grid ri-grid-size-2 ">
                <img class="ri-loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif"/>
                <ul>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/1.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/2.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/3.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/4.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/5.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/6.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/7.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/8.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/9.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/10.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/11.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/12.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/13.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/14.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/15.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/16.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/17.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/18.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/19.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/20.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/21.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/22.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/23.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/24.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/25.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/26.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/27.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/28.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/29.jpg" alt=""/></a></li>
                    <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/slider/30.jpg" alt=""/></a></li>

                </ul>
            </div>              
        </section>

		
		<div class="container">
		    <ul class="cbreadcrumb mt-3">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">About</a></li>
                </ul>
			<div class="about-content-text">
				 <?php
					$about=$this->Common_model->showname_fromid("page_content","tbl_contents","content_id='4'");
					echo $about; 
				?> 
			</div>
		</div>

        <section class="about-package-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>     
                    <div class="col-md-8"></div>
                    <div class="col-md-2"></div><div class="clearfix"></div>             


                    <div class="col-md-6">
                        <h3 class="mb-4 mt-4">Discover best Tourist Destinations, Getaways, Itineraries & Tour Packages in India</h3>             
                        <div class="package-img-holder">
                            <img src="<?php echo base_url(); ?>assets/images/tours-packagebg.jpg" class="img-fluid" alt="">
                            <div class="imgholdercontent">
                                <h1>500+ Tour Packages</h1>
                                <span class="package-subheading">For 100+ Destinations</span> <div class="clearfix"></div>  
                                <a href="#" class="explorebtn">Explore All Tours Packages</a>
                            </div>
                        </div>   
                    </div>
                    <div class="col-md-6">
                        <div class="package-img-holder mt-4">
                            <img src="<?php echo base_url(); ?>assets/images/travel-destination.jpg" class="img-fluid" alt="">
                            <div class="imgholdercontent">
                                <h1>250+ Weekend Gateways</h1>
                                <span class="package-subheading">From 20+ Cities & States</span> <div class="clearfix"></div>   
                                <a href="#" class="explorebtn">All Weekend Getaways</a>
                            </div>
                        </div>
                        <div class="package-img-holder">
                            <img src="<?php echo base_url(); ?>assets/images/gatewaypackages.jpg" class="img-fluid mt-4" alt="">
                            <div class="imgholdercontent">
                                <h1>150+ Travel Destinations</h1>
                                <span class="package-subheading">From 10+ States</span> <div class="clearfix"></div>    
                                <a href="#" class="explorebtn">Explore All Destinations</a>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>    
                </div>
            </div>
        </section> 

		<?php include("footer.php"); ?> 
		 <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script>
		 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.gridrotator.js"></script>
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
