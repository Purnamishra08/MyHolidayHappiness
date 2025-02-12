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


        <div class="container  mt60 mb100">
            <div class="row">
                <h1 class="mb20"> Booking</h1>
				
				<?php
				if( !empty($bookings) )
				{
					foreach ($bookings as $booking)
					{						
						$booking_id = $booking['booking_id'];
						$booking_encid = $this->Common_model->encode($booking_id);
						$invoice_no = $booking['invoice_no'];
						$date_of_travel = $booking['date_of_travel'];
						$booking_date = $booking['booking_date'];
						
						$package_id = $booking['package_id'];
						$package_name = $this->Common_model->showname_fromid("tpackage_name", "tbl_tourpackages", "tourpackageid ='$package_id'");
						$package_image = $this->Common_model->showname_fromid("tour_thumb", "tbl_tourpackages", "tourpackageid ='$package_id'");
						$package_url = $this->Common_model->showname_fromid("tpackage_url","tbl_tourpackages","tourpackageid = $package_id");
						
						$package_duration = $booking['package_duration'];
						$show_duration = $this->Common_model->showname_fromid("duration_name", "tbl_package_duration", "durationid ='$package_duration'");
						
						$noof_adults = $booking['noof_adults'];
						$noof_childs = $booking['noof_childs'];
						
						$vehicle_id = $booking['vehicle_id'];
						$vehicle_name = $this->Common_model->showname_fromid("vehicle_name", "tbl_vehicletypes", "vehicleid ='$vehicle_id'");
						
						$accomodation_type = $booking['accomodation_type'];
						$accomodation_name = $this->Common_model->showname_fromid("hotel_type_name", "tbl_hotel_type", "hotel_type_id ='$accomodation_type'");
						
						$accomodation_hotels = $booking['accomodation_hotels'];
						$hotel_ids = explode(",",$accomodation_hotels);
						$hotel_names = array();
						foreach($hotel_ids as $hotel_id)
						{
							$hotel_names[] = $this->Common_model->showname_fromid("hotel_name", "tbl_hotel", "hotel_id ='$hotel_id'");
						}
						
						$show_hotel_names = implode(", ", $hotel_names);
						
						$payment_status = $booking['payment_status'];
						$payment_percentage = $booking['payment_percentage'];
						$paid_amount = $booking['paid_amount'];
						$total_price = $booking['total_price'];
						
						$airport_pickup = $booking['airport_pickup'];
						$airport_drop = $booking['airport_drop'];
				?>
                <div class="inr-booking-box">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9"> 
                            <div class="inr-bokng-invc-list">
                                <ul> 
                                    <li> Invoice No - <?php echo $invoice_no; ?></li>
                                    <li> Invoice date - <?php echo $this->Common_model->dateformat($booking_date); ?></li>
                                    <li> Travel date - <?php echo $this->Common_model->dateformat($date_of_travel); ?></li>
                                </ul> 
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3"> 
                            <a href="<?php echo base_url()."invoice/".$invoice_no."/".$booking_encid ?>" target="_blank" class="inr-bokng-invc-link"> View Invoice</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="line-1"></div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="inr-bokng-img">
                                <img src="<?php echo base_url()."uploads/".$package_image; ?>" class="img-fluid" alt="My Holiday Happiness">  
                            </div>
                            <div class="inr-bokng-txt">
                                <h5><a href="<?php echo base_url().'packages/'.$package_url; ?>" target="_blank"><?php echo $package_name; ?> <span>( <?php echo $show_duration; ?> )</span></a></h5>
                                <div class="inr-bokng-txt1">
									<span> <img src="<?php echo base_url(); ?>assets/images/users.png" class="img-fluid" alt="Adults">  <?php echo $noof_adults; ?> Adults </span> 
									<span> <img src="<?php echo base_url(); ?>assets/images/children.png" class="img-fluid" alt="Childrens">  <?php echo $noof_childs; ?> Childrens </span>
								</div>
                                <div class="inr-bokng-txt1"> <img src="<?php echo base_url(); ?>assets/images/car.png" class="img-fluid" alt="Car"> <?php echo $vehicle_name; ?></div>
                                <div class="inr-bokng-txt1">  <img src="<?php echo base_url(); ?>assets/images/bed.png" alt="Accommodation" class="img-fluid"> <?php echo $accomodation_name; ?> ( <?php echo $show_hotel_names; ?> )</div>
								<div class="inr-bokng-txt1">
								<span style="margin-right:30px;"><img src="<?php echo base_url(); ?>assets/images/<?php echo ($airport_pickup == 1)?"check-icon.png":"check-cross-icon.png"; ?>" class="img-fluid" alt="Pickup"> Pickup</span>
								<span><img src="<?php echo base_url(); ?>assets/images/<?php echo ($airport_drop == 1)?"check-icon.png":"check-cross-icon.png"; ?>" class="img-fluid" alt="Drop">  Drop</span>
								</div>
								
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <div class="inr-total-price"> Total: <?php echo $this->Common_model->currency; ?><?php echo $total_price; ?> </div>
							<div class="paymt-st"> Payment Status: <br>
								<span> 
									<?php 
										if($payment_status == 1)
										{ 
											echo "<span style='color:#007bff'>".$this->Common_model->currency.$paid_amount." ( ".$payment_percentage."% ) Paid</span>"; 
										}
										else
										{
											echo "<span style='color:#fb426d'>".$this->Common_model->currency.$paid_amount." ( ".$payment_percentage."% ) Selected to Pay But NOT PAID</span>"; 
										}
									?>	
								</span>
							</div>
							<div class="paymt-st mt20"> Booking Status: <span style='color:#007bff; font-weight:bold;'>
								<?php
									$booking_status = $booking['booking_status'];
									if($booking_status == 1)
										echo "Approved";
									else if($booking_status == 2)
										echo "Cancelled";
									else
										echo "Pending";
								?></span>
							</div>
                        </div>
                    </div>
                </div>
				<?php } } else {  ?>				
				<div class="clearfix"></div>
				<div class="col-xl-12 col-lg-12">
					<div class="row "> 
						<div class="no-booking-txt ">
							<i class="fa fa-times"></i> No Bookings have been made ! 
						</div>
					</div>
				</div>
				<?php } ?>
				

            </div>
            <div class="clearfix"></div>
        </div>

        <?php include("footer.php"); ?> 

        <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script>
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