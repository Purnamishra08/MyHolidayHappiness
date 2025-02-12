<?php
if( !empty($bookings) )
{
	foreach ($bookings as $booking)
	{
		$booking_id = $booking['booking_id'];
		$booking_encid = $this->Common_model->encode($booking_id);
		$invoice_no = $booking['invoice_no'];
		$customer_id = $booking['customer_id'];
		
		$customer_name = '';
		$customer_phone = '';
		$customer_email = '';
														
		$customers = $this->Common_model->get_records("fullname, contact, email_id","tbl_customers","customer_id='$customer_id'");
		if(!empty($customers)){
    		foreach ($customers as $customer)
    		{
    			$customer_name = $customer['fullname'];
    			$customer_phone = $customer['contact'];
    			$customer_email = $customer['email_id'];
    		}		
		}
		
		$date_of_travel = $booking['date_of_travel'];
		$booking_date = $booking['booking_date'];
		
		$package_id = $booking['package_id'];
		$package_name = $this->Common_model->showname_fromid("tpackage_name", "tbl_tourpackages", "tourpackageid ='$package_id'");
		$package_image = $this->Common_model->showname_fromid("tour_thumb", "tbl_tourpackages", "tourpackageid ='$package_id'");
		$tpackage_url = $this->Common_model->showname_fromid("tpackage_url", "tbl_tourpackages", "tourpackageid ='$package_id'");
		
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
		$transactin_id = $booking['transactin_id'];
		
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
		
		$package_noofdays = $booking['package_noofdays'];
		$vehicle_perday_price = $booking['vehicle_perday_price'];
		
		$total_hotel_price = $booking['total_hotel_price'];
		$total_vehicle_price = $booking['total_vehicle_price'];
		$pickup_price = $booking['pickup_price'];
		$drop_price = $booking['drop_price'];
		$sub_total_price = $booking['sub_total_price'];
		
		$percentage_margin = $booking['percentage_margin'];
		$percentage_price = $booking['percentage_price'];
		
		$noof_coupleroom = $booking['noof_coupleroom'];
		$noof_extrabed = $booking['noof_extrabed'];
		$noof_kidsroom = $booking['noof_kidsroom'];
		$coupleroom_price = $booking['coupleroom_price'];
		$extrabed_price = $booking['extrabed_price'];
		$kidsroom_price = $booking['kidsroom_price'];
		$booking_status = $booking['booking_status'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("head.php"); ?>
        <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php include("header.php"); ?>

            <?php include("sidemenu.php"); ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="header-title">
                        <h1>Bookings</h1>
                        <small>View Booking</small>
                    </div>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group" id="buttonexport">
                                        <a href="<?php echo base_url(); ?>admin/bookings">
                                            <h4><i class="fa fa-plus-circle"></i> Bookings</h4>
                                        </a> 
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="booking-top-list">
                                        <ul> 
                                            <li> Invoice No - <a href="<?php echo base_url()."invoice/".$invoice_no."/".$booking_encid ?>" target="_blank" style="color:#1f00f9;"><?php echo $invoice_no; ?></a></li>
                                            <li> Invoice date - <?php echo $this->Common_model->dateformat($booking_date); ?></li>
                                            <li> travel date - <?php echo $this->Common_model->dateformat($date_of_travel); ?></li>
                                        </ul>
                                    </div>
                                    <div class="row">
										<div class="col-md-4">
                                            <div class="booking-dtls-box">
                                                <h3>Customer Details</h3>
                                                <p><?php echo $customer_name; ?></p>
												<p><?php echo $customer_email; ?></p>
												<p><?php echo $customer_phone; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="booking-dtls-box">
                                                <h3>Traveller Details</h3>
                                                <p><?php echo $traveller_name; ?></p>
												<p><?php echo $traveller_email; ?></p>
												<p><?php echo $traveller_phone; ?></p>
												<p><?php echo $traveller_altphone; ?></p>
												<p><?php echo $traveller_msg; ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="booking-dtls-box">
                                                <h3> Pickup/Drop Location</h3>
                                                <p><?php echo $location_address; ?></p>
												<p><?php echo $location_city; ?></p>
												<p><?php echo $location_state; ?></p>
												<p><?php echo $location_pincode; ?></p>
												<p><?php echo ($location_landmark != "")?"Landmark: ".$location_landmark:""; ?></p>
                                            </div>
                                        </div>
										<div class="clearfix"></div>
                                        <div class="col-md-5">
                                            <div class="booking-dtls-box">
                                                <h3> Payment Mode</h3>
                                                <p> <strong>THROUGH PAYTM: 
													<?php 
														if($payment_status == 1)
														{ 
															echo "PAID <br>".$this->Common_model->currency.$paid_amount." ( ".$payment_percentage."% )"; 
														}
														else
														{
															echo "NOT PAID <br>".$this->Common_model->currency.$paid_amount." ( ".$payment_percentage."% ) Selected to Pay"; 
														}
													?>	
												</strong></p>
                                                <p>Transaction Number: <?php echo $transactin_id; ?></p>
                                                <p> <strong>CHANGE PAYMENT STATUS</strong></p>
                                                <?php echo $pmessage; ?>
												<?php echo form_open('', array( 'id' => 'form_payment', 'name' => 'form_payment'));?>
                                                    <div class="form-group">
                                                        <label> Payment Status</label>
                                                        <select class="form-control" name="paymntsts" id="paymntsts">
														   <option value="0">Not Paid</option>
														   <option value="1">Paid</option>
														</select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label> Transaction Number</label>
                                                        <input name="transnumber" id="transnumber" placeholder="Transaction number" type="text" class="form-control">
                                                    </div>
                                                    <input type="submit" name="btnsubpaymnt" id="btnsubpaymnt" value="Update" class="btn redbtn btnUpdate btn-sm">
                                                <?php echo form_close(); ?>

                                            </div>
                                        </div>
										<div class="col-md-2"></div>
										<div class="col-md-5">
                                            <div class="booking-dtls-box">
                                                <h3> Booking Status</h3>
                                                <p> <strong>Booking Status: 
													<?php 
														if($booking_status == 1)
															echo "Approved"; 
														else if($booking_status == 2)
															echo "Cancelled"; 
														else
															echo "Pending";
													?>	
												</strong></p>
                                                <p> <strong>CHANGE Booking STATUS</strong></p>
                                                <?php echo form_open('', array( 'id' => 'form_booking', 'name' => 'form_booking'));?>
                                                    <?php echo $message; ?>
													<div class="form-group">
                                                        <label> Status</label>
                                                        <select class="form-control" id="booking_status" name="booking_status">
                                                            <option value="0" <?php if($booking_status == 0) echo "selected"; ?>>Pending</option>
                                                            <option value="1" <?php if($booking_status == 1) echo "selected"; ?>>Approved</option>
															<option value="2" <?php if($booking_status == 2) echo "selected"; ?>>Cancelled</option>
                                                        </select>
                                                    </div>                                                    
                                                    <input type="submit" name="btnSubBooking" id="btnSubBooking" value="Update" class="btn redbtn btnUpdate btn-sm">
                                                <?php echo form_close(); ?>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="table-responsive">
                                        <table  class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="info">
                                                    <th width="25%">Package</th>
                                                    <th width="12%">Traveler</th>
                                                    <th width="12%">Vehicle </th>
                                                    <th width="18%">Hotel </th>
                                                    <th width="10%">Pickup</th>
                                                    <th width="10%">Dropup</th>
                                                    <th width="12%">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <img src="<?php echo base_url()."uploads/".$package_image; ?>" alt="" class="adm-bkng-img"/> <div class="adminpckg"><a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank" style="color:#1f00f9;"><?php echo $package_name; ?></a><br><span class="all-price-t" > <?php echo $show_duration; ?></span> </div> 
                                                    </td>
                                                    <td> <?php echo $noof_adults; ?> Adults <?php echo $noof_childs; ?> Childrens</td>
                                                    <td> 
														<?php echo $vehicle_name; ?><br>
														(<?php echo $package_noofdays; ?> Days X <?php echo $this->Common_model->currency; ?><?php echo $vehicle_perday_price; ?>)
														<span class="all-price-t"> Price- <?php echo $this->Common_model->currency; ?><?php echo $total_vehicle_price; ?></span>
													</td>
                                                    <td> 
														<?php echo $accomodation_name; ?> ( <?php echo $show_hotel_names; ?> )<br><br>
														No of Couple Room: <?php echo $noof_coupleroom; ?> (<?php echo $this->Common_model->currency; ?><?php echo $coupleroom_price; ?>)<br>
														No of Extra Bed: <?php echo $noof_extrabed; ?> (<?php echo $this->Common_model->currency; ?><?php echo $extrabed_price; ?>)<br>
														No of Kids Room: <?php echo $noof_kidsroom; ?> (<?php echo $this->Common_model->currency; ?><?php echo $kidsroom_price; ?>)<br><br>
														<span class="all-price-t"> Price- <?php echo $this->Common_model->currency; ?><?php echo $total_hotel_price; ?></span>
													</td>
                                                    <td>
														<?php if($airport_pickup == 1){ ?>
														Yes<br><span class="all-price-t"> Price- <?php echo $this->Common_model->currency; ?><?php echo $pickup_price; ?></span>
														<?php } else echo "No"; ?>
													</td>
                                                    <td> 
														<?php if($airport_drop == 1){ ?>
														Yes<br><span class="all-price-t"> Price- <?php echo $this->Common_model->currency; ?><?php echo $drop_price; ?></span>
														<?php } else echo "No"; ?>
													</td>
                                                    <td><div class="sub-total"><?php echo $this->Common_model->currency; ?><?php echo $sub_total_price; ?></div></td>
                                                </tr>  
                                                <tr>
                                                    <td colspan="6"> <div class="all-price-margin"> <?php echo $percentage_margin; ?>% Margine</div></td>
                                                    <td><div class="all-price-total"> <?php echo $this->Common_model->currency; ?><?php echo $percentage_price; ?></div></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><div class="all-price-total1"> Total - <?php echo $this->Common_model->currency; ?><?php echo $total_price; ?></div></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>                          
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php include("footer.php"); ?>

    </body>
</html>

