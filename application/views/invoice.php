<?php
if( !empty($bookings) )
{
	foreach ($bookings as $booking)
	{
		$invoice_no = $booking['invoice_no'];
		$customer_id = $booking['customer_id'];
		
		$customers = $this->Common_model->get_records("fullname, contact, email_id","tbl_customers","customer_id='$customer_id'");
		foreach ($customers as $customer)
		{
			$customer_name = $customer['fullname'];
			$customer_phone = $customer['contact'];
			$customer_email = $customer['email_id'];
		}		
		
		$date_of_travel = $booking['date_of_travel'];
		$booking_date = $booking['booking_date'];
		
		$package_id = $booking['package_id'];
		$package_name = $this->Common_model->showname_fromid("tpackage_name", "tbl_tourpackages", "tourpackageid ='$package_id'");
		
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
		
		$traveller_name = $booking['traveller_name'];
		$traveller_email = $booking['traveller_email'];
		$traveller_phone = $booking['traveller_phone'];
		$traveller_altphone = $booking['traveller_altphone'];
		$traveller_msg = $booking['traveller_msg'];
		
		$location_address = $booking['location_address'];
		$location_city = $booking['location_city'];
		$location_state = $booking['location_state'];
		$location_pincode = $booking['location_pincode'];
		$location_landmark = $booking['location_landmark'];
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

        <div class="container  mt60 mb100">
			<?php echo $message; ?>
            <div class="invoice-sec">
                <div class="invoice-sub-sec">
                    <h1>Payment Invoice </h1>
                    <h4> Hello <span><?php echo $customer_name; ?></span>, <br><br>Thank you for booking your travel with My Holiday Happiness. We will let you know about your booking status very soon.</h4>
                    
                    <div class="inv-no">
                        <div class="inv-no-t"> Invoice No: <span><?php echo $invoice_no; ?></span></div>
                        <div class="inv-no-t"> Invoice date: <span> <?php echo $this->Common_model->dateformat($booking_date); ?></span></div>
                        <div class="inv-no-t"> travel date: <span> <?php echo $this->Common_model->dateformat($date_of_travel); ?></span></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="inv-pck">
                        <div class="inv-pck-txt"> <?php echo $package_name; ?> <span> ( <?php echo $show_duration; ?> )</span> </div>
                        <div class="inv-pck-txt"> <?php echo $noof_adults; ?> Adults <?php echo $noof_childs; ?> Childrens </div>
                        <div class="inv-pck-txt"> <?php echo $vehicle_name; ?>  </div>
                        <div class="inv-pck-txt"> <?php echo $accomodation_name; ?> <span> ( <?php echo $show_hotel_names; ?> ) </span> </div>
						<div class="inv-pck-txt"> Pickup: <b><?php echo ($airport_pickup == 1)?"Yes":"No"; ?></b> &nbsp; &nbsp; &nbsp; &nbsp;  Drop: <b><?php echo ($airport_drop == 1)?"Yes":"No"; ?></b></div>
						<div class="inv-pck-txt"> 
							<b>Payment Status: 
								<span style="color: #03a84e;">	
									<?php 
										if($payment_status == 1)
										{ 
											echo $this->Common_model->currency.$paid_amount." ( ".$payment_percentage."% ) Paid"; 
										}
										else
										{
											echo $this->Common_model->currency.$paid_amount." ( ".$payment_percentage."% ) Selected to Pay But NOT PAID"; 
										}
									?>	
								</span>
							</b>
						</div>
                        <div class="inv-pck-totaltxt"> Total Price : <span> <?php echo $this->Common_model->currency; ?><?php echo $total_price; ?></span> </div>
                    </div>

                    <div class="invoice-trv-dtls">
                        <h3>Traveller Details</h3>
                        <p><?php echo $traveller_name; ?></p>
                        <p><?php echo $traveller_email; ?></p>
                        <p><?php echo $traveller_phone; ?></p>
                        <p><?php echo $traveller_altphone; ?></p>
                        <p><?php echo $traveller_msg; ?></p>
						<h3>User Details</h3>
						<p><?php echo $customer_name; ?></p>
                        <p><?php echo $customer_email; ?></p>
						<p><?php echo $customer_phone; ?></p>
                    </div>

                    <div class="invoice-trv-dtls invoice-trv-dtls1">
                        <h3>Pickup/Drop Location</h3>
                        <p><?php echo $location_address; ?></p>
                        <p><?php echo $location_city; ?></p>
                        <p><?php echo $location_state; ?></p>
                        <p><?php echo $location_pincode; ?></p>
                        <p><?php echo ($location_landmark != "")?"Landmark: ".$location_landmark:""; ?></p>
                    </div>
					<div class="clearfix"></div>
                    <div class="wishing-txt">Wish You Happy and Safe Journey !</div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <?php include("footer.php"); ?> 

        <script src="https://code.jquery.com/jquery-1.9.1.min.js "></script>
    </body>
</html>