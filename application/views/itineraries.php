<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?> 


    </head>
    <body>
        <?php include("header.php"); ?> 


		<?php 			
			$getIMoItinerear = $this->Common_model->show_parameter(35);			
				if(file_exists("./uploads/".$getIMoItinerear) && ($getIMoItinerear!='')) {
				$getIMoItinerear = base_url()."uploads/".$getIMoItinerear;
		?>
        <section style="position:relative;">
            <img src="<?php echo $getIMoItinerear; ?>" class="img-fluid">
			<div class="courtesy-txt"> Courtesy - Flickr </div>
		</section>
		<?php } else { ?>
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
			
		<?php } ?>
        <section class="destinationsection mb100 mt-5">
            <div class="destinationtop">
                <div class="container">
                     <ul class="cbreadcrumb">
                 
                  <li><a href="/">Home</a></li>
                  <li><a href="#">Itineraries</a></li>
                </ul>
                    <div class="row">
                        <div class="col-md-12"><h1> Most popular itinaries in India</h1></div>

                        <?php
                        if (!empty($allItineraries)) {

                            foreach ($allItineraries as $allItinery) {
                                $itinerarythumbimg = $allItinery['itinerarythumbimg'];
                                $itineraryalttag_thumb = $allItinery['alttag_thumb'];

                                if (file_exists("./uploads/" . $itinerarythumbimg) && ($itinerarythumbimg != '')) {
                                    $itinerarythumbimg = base_url() . "uploads/" . $itinerarythumbimg;
                                } else
                                    $itinerarythumbimg = base_url() . "assets/images/noimgavail.jpg";
                                ?>
                                <div class="col-lg-3 col-md-6 singledestination destinationholder mb-3">
                                    <a href="<?php echo base_url() . 'itinerary/' . $allItinery['itinerary_url']; ?>" target="_blank">
                                        <div class="newimg">
                                            <img src="<?php echo $itinerarythumbimg; ?>" alt="<?php echo (!empty($itineraryalttag_thumb)) ? $itineraryalttag_thumb : $allItinery['itinerary_name']; ?>">
                                        </div>
                                        <div class="padcontent">
                                            <p><?php echo $allItinery['itinerary_name']; ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                        }
                        ?>

                    </div>
<?php echo $pagination; ?>
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
