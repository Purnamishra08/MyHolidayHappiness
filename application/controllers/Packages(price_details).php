<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		 $this->load->model('Common_model');
	}
	
	public function index()
	{		
		$packageurl = $this->uri->segment(2);
		if(!empty($packageurl))
		{	
			$packageurl = $this->db->escape($packageurl);
			if(isset($_REQUEST['preview']))
			{				
				$de_admin = $this->Common_model->decode($_REQUEST['preview']);
				if($de_admin=="admin")
				{
					$validpackage = $this->Common_model->noof_records("tourpackageid","tbl_tourpackages","tpackage_url=$packageurl");
					$data['package_data']=$this->Common_model->get_records("*","tbl_tourpackages","tpackage_url=$packageurl");
				}
				else
					redirect(base_url(),'refresh');
			}
			else
			{
				$validpackage = $this->Common_model->noof_records("tourpackageid","tbl_tourpackages","tpackage_url=$packageurl and status='1'");
				$data['package_data']=$this->Common_model->get_records("*","tbl_tourpackages","tpackage_url=$packageurl and status='1'");
			}
			
			if($validpackage>0)
			{
				$this->load->view('packages', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
		else
			redirect(base_url(),'refresh');		
	}
	
	public function search()
	{
		$starting_city = $_REQUEST["starting_city"];
		$trip_duration = $_REQUEST["trip_duration"];
		$get_pkg_tag = $_REQUEST["get_pkg_tag"];
		$tourpackageid = $_REQUEST["tourpackageid"];
		?>
		<div id="loader"></div>		
		<?php
		$condition = "";
		
		if($starting_city != "")
			$condition .= " and starting_city=$starting_city";
		
		if($trip_duration != "")
			$condition .= " and package_duration=$trip_duration";

		$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "tourpackageid in (SELECT distinct(type_id) FROM tbl_tags WHERE type='3' and tagid=$get_pkg_tag and type_id!=$tourpackageid) and status = 1 $condition","");	
		if(!empty($tour_packages))
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
				<div class="col-lg-3 col-md-6  touristlist-box">
					<div class="touristdetails-imgholder">
						<?php 
							if (!empty($pack_type)) 
							{ 
								$class = ($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon' ; 
						?> 
							<div class="<?php echo $class ; ?>">
								<span><?php echo $this->Common_model->showname_fromid("par_value","tbl_parameters","parid ='$pack_type' and param_type = 'PT' "); ?></span>
							</div>								
						<?php } ?>
						
						<a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid"></a>							
						<?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
						<div class="tourist-duration"> <?php echo $show_duration; ?> </div>
					</div>
					<div class="tourist-bottom-details">
						<ul class="iconlist">									
							<?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation"></li><?php endif; ?>
							<?php if($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation"></li><?php endif; ?>
							<?php if($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing"></li><?php endif; ?>	
							<?php if($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast"></li><?php endif; ?>
							<?php if($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle"></li><?php endif; ?>
						</ul>
						<div class="touristlist-hdng "><?php echo $tpackage_name; ?> <?php if($noof_assoc_dest > 0): ?> |  <?php echo $show_assoc_dests; ?><?php endif; ?></div>
						<div class="tourbutton "> <span><a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></span></div>
						<div class="tourprice "><span class="packageCostOrig " style="text-decoration: line-through; color: #A0A0A0; font-size:14px "><?php echo $this->Common_model->currency; ?><?php echo $package_fakeprice; ?></span><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $package_price; ?></span></div>
						<div class="clearfix "></div>
					</div>
				</div>  
			<?php
				}
			}else{
			?>
			<div class="col-md-12 text-center">
				<h1>No Packages Found !</h1>
			</div>
			<?php	
		}
	}
	
	public function getvehicles()
	{
		$totalcount = $_REQUEST["totalcount"];
		$package_startingcity = $this->db->escape($_REQUEST["destination"]);
		
		$get_vehicles = $this->Common_model->join_records("b.vehicle_name, b.vehicleid", "tbl_vehicleprices as a", "tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid", "a.destination=$package_startingcity and (b.capacity>$totalcount or b.capacity=$totalcount) and a.status=1", "b.capacity asc");
		$options = "<option value=''>-Select Vehicle-</option>";
		if (!empty($get_vehicles)) {
			foreach ($get_vehicles as $get_vehicle) {
				$options .= "<option value=".$get_vehicle['vehicleid'].">".$get_vehicle['vehicle_name']."</option>";	
			}
		}
		echo $options;
		exit();
	}
	
	public function getaccomodation()
	{
		$first_hoteltype = $_REQUEST["accommodation_type"];
		$tourpackageid = $_REQUEST["packageid"];
		?>
		<div class="col-xl-12 col-lg-12">
			<h4 style="color:#6583bb; padding-bottom:20px;"><?php echo $this->Common_model->showname_fromid("hotel_type_name", "tbl_hotel_type", "hotel_type_id=$first_hoteltype"); ?></h4>
		</div>
		<?php
			$accommodation_hotels = $this->Common_model->get_records("*", "tbl_package_accomodation", "package_id='$tourpackageid'");
			if (!empty($accommodation_hotels)) {
				$noof_hotels = count($accommodation_hotels);
				$hotelcount = 1;
				foreach ($accommodation_hotels as $accommodation_hotel) {
					$accommodation_destination = $accommodation_hotel['destination_id'];
					$accommodation_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", "destination_id=$accommodation_destination");
					$stay_nights = $accommodation_hotel['noof_days'];
		?>
		<div class="col-xl-3 col-lg-3">
			<h5><?php echo $accommodation_name; ?></h5>
			<h6><?php if($stay_nights > 0) echo "(".$stay_nights."Nights)"; ?></h6>
		</div>
		
		<div class="col-xl-9 col-lg-9">
			<div class="row">
				<?php
				$accommodation_hotels = $this->Common_model->get_records("*", "tbl_hotel", "destination_name='$accommodation_destination' and hotel_type=$first_hoteltype and status=1", "default_price");
				if (!empty($accommodation_hotels)) {
					$sel_count = 1;
					foreach ($accommodation_hotels as $accommodation_hotel) {
						$acc_hotel_id = $accommodation_hotel['hotel_id'];
						$acc_hotel_name = $accommodation_hotel['hotel_name'];		
						$acc_room_type  = $accommodation_hotel['room_type'];
						$acc_star_rating= $accommodation_hotel['star_rating'];
				?>	
				<div class="col-xl-4 col-lg-4">
					<div class="hoteldetails">
						<div class="form-check hotelplace">
							<label class="form-check-label" for="hotelradio_<?php echo $sel_count; ?>">
								<input type="radio" class="form-check-input" id="hotelradio_<?php echo $sel_count; ?>" name="hotelradio_<?php echo $hotelcount; ?>" value="<?php echo $acc_hotel_id; ?>" <?php if($sel_count==1){ echo "checked"; } ?>><?php echo $acc_hotel_name; ?>
							</label>
						</div>
						<?php if($acc_room_type != ""): ?><div class="hotelrating">(<?php echo $acc_room_type; ?>)</div><?php endif; ?>
						<div class="hotelrating">
							<?php
							$acc_star_floorval = floor($acc_star_rating);
							$acc_star_decval = $acc_star_rating - $acc_star_floorval;
							$acc_star_balanceint = 5 - $acc_star_rating;
							echo str_repeat('<i class="fas fa-star"></i>', $acc_star_floorval);
							echo ($acc_star_decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
							echo str_repeat('<i class="far fa-star"></i>', $acc_star_balanceint);
							?>
						</div>
					</div>
				</div>
				<?php $sel_count++; } } ?>
			</div>
		</div>
		
		<div class="clearfix"></div>
		<?php if($hotelcount < $noof_hotels){ ?><div  class="col-md-12"><hr></div><?php } ?>
		
		<?php $hotelcount++; } } ?>
		<?php
	}	
	
	public function geprice()
	{
		//print_r($_REQUEST);
		$hid_packageid = $_REQUEST["hid_packageid"];
		$quantity_adult = $_REQUEST["quantity_adult"];
		$quantity_child = $_REQUEST["quantity_child"];		
		$travel_date = $_REQUEST["travel_date"];
		$splitdate = explode("/",$travel_date);		
		$travel_date_foramt = $splitdate[2]."-".$splitdate[1]."-".$splitdate[0];
		$travel_year = date("Y", strtotime($travel_date_foramt));
		
		$package_data=$this->Common_model->get_records("package_duration, pmargin_perctage, starting_city","tbl_tourpackages","tourpackageid=$hid_packageid");
		foreach ($package_data as $packages) {
			$package_duration = $packages['package_duration'];
			$pmargin_perctage = $packages['pmargin_perctage'];
			$starting_city = $packages['starting_city'];
		}	
		
		$no_ofdays = $this->Common_model->showname_fromid("no_ofdays", "tbl_package_duration", "durationid=$package_duration");
		$pick_drop_price = $this->Common_model->showname_fromid("pick_drop_price", "tbl_destination", "destination_id=$starting_city");
		
		$vehicle = $_REQUEST["vehicle"];
		
		$get_vehicles = $this->Common_model->join_records("a.price, b.vehicle_name, b.vehicleid", "tbl_vehicleprices as a", "tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid", "a.destination=$starting_city and a.vehicle_name=$vehicle");
		foreach ($get_vehicles as $get_vehicle) {
			$vehicle_name = $get_vehicle['vehicle_name'];
			$vehicle_price = $get_vehicle['price'];
		}
		
		$noof_coupleroom = 0;
		$noof_extrabed = 0;
		$noof_kidsroom = 0;
		$noof_coupleroom_price = 0;
		$noof_extrabed_price = 0;
		$noof_kidsroom_price = 0;
		$total_coupleroom_price = 0;
		$total_extrabed_price = 0;
		$total_kidsroom_price = 0;
		$total_traveller = $quantity_adult+$quantity_child;
		if($total_traveller <=2)
		{
			$noof_coupleroom = 1;
		}
		else 
		{			
			if($total_traveller % 2 == 0)
			{
				$noof_coupleroom = $total_traveller/2;
			}
			else
			{
				$noof_coupleroom = floor($total_traveller/2);
				if($quantity_child > 0)
					$noof_kidsroom = 1;
				else
					$noof_extrabed = 1;
			}
		}		
		
		$accommodation_type = $_REQUEST["accommodation_type"];
		$accommodation_name = $this->Common_model->showname_fromid("hotel_type_name", "tbl_hotel_type", "hotel_type_id=$accommodation_type");
		$noof_hotels = $this->Common_model->noof_records("acc_id", "tbl_package_accomodation", "package_id='$hid_packageid'");
		
		$field_value = array();
		for($i=1;$i<=$noof_hotels;$i++)
		{
			$fieldname = "hotelradio_".$i;
			if(isset($_REQUEST[$fieldname]))
				$field_value[] = $_REQUEST[$fieldname];
		}
		//print_r($field_value);
		foreach($field_value as $hotel_id)
		{
			$hotel_coupleroom_price = 0;
			$hotel_extrabed_price = 0;
			$hotel_kidsroom_price = 0;
				
			$acc_destiantion_id = $this->Common_model->showname_fromid("destination_name", "tbl_hotel", "hotel_id=$hotel_id");
			$noof_nights = $this->Common_model->showname_fromid("noof_days", "tbl_package_accomodation", "package_id=$hid_packageid and destination_id=$acc_destiantion_id");
			for($n=0; $n<$noof_nights; $n++)
			{
				$hoteldate = date("Y-m-d", strtotime("+$n days", strtotime("$travel_date_foramt")));
				$query = $this->db->query("SELECT * FROM `tbl_season` WHERE hotel_id=$hotel_id and '$hoteldate' between STR_TO_DATE(CONCAT('$travel_year','-',sesonstart_month,'-',sesonstart_day), '%Y-%m-%d') and STR_TO_DATE(CONCAT('$travel_year','-',sesonend_month,'-',sesonend_day), '%Y-%m-%d')");
				if ($query->num_rows() > 0) {
					$hotel_results = $query->result_array();
					foreach($hotel_results as $hotel_result){
						$noof_coupleroom_price = $hotel_result['couple_price'];
						$noof_extrabed_price = $hotel_result['adult_extra'];
						$noof_kidsroom_price = $hotel_result['kid_price'];
					}
				}
				else
				{
					$acc_default_price = $this->Common_model->showname_fromid("default_price", "tbl_hotel", "hotel_id=$hotel_id");
					$noof_coupleroom_price = $acc_default_price;
					$noof_extrabed_price = $acc_default_price;
					$noof_kidsroom_price = $acc_default_price;
				}			
				
				$hotel_coupleroom_price += $noof_coupleroom_price * $noof_coupleroom;
				$hotel_extrabed_price += $noof_extrabed_price * $noof_extrabed;
				$hotel_kidsroom_price += $noof_kidsroom_price * $noof_kidsroom;			
			}
			
			$total_coupleroom_price += $hotel_coupleroom_price;
			$total_extrabed_price += $hotel_extrabed_price;
			$total_kidsroom_price += $hotel_kidsroom_price;
		}
		
		$total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;		
		$total_vehicle_price = $vehicle_price*$no_ofdays;
		
		$airport_pickup_price = 0;
		if(isset($_REQUEST["airport_pickup"])) {
			$airport_pickup_price = $pick_drop_price;
		}
		
		$airport_drop_price = 0;
		if(isset($_REQUEST["airport_drop"])) {
			$airport_drop_price = $pick_drop_price;
		}
		
		$sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;
		?>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/users.png"><?php echo $quantity_adult; ?> Adults</div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/children.png"><?php echo $quantity_child; ?> Childrens</div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/car.png"><?php echo $vehicle_name; ?></div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/modal-small-calendar.png"><?php echo $travel_date; ?></div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/bed.png"><?php echo $accommodation_name; ?></div>
		<?php if(isset($_REQUEST["airport_pickup"])) { ?><div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/car-icon.png">Pickup</div><?php } ?>
		<?php if(isset($_REQUEST["airport_drop"])) { ?><div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/car-icon1.png">Drop</div><?php } ?>
		<div class="clearfix"></div>
		<hr>
		<p>Fare includes Stay, Cab, Driver Charges, Toll, Parking, GST & Inter-state Tax (if any)</p>
		<div style="color: #000">
			<img src="<?php echo base_url(); ?>assets/images/pricetag.png">Total price<br>
			<h4><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $total_price; ?></span></h4>
			<!--h4><span class="packageCostOrig" style="text-decoration: line-through; color:#232323;font-size: 16px;">₹32900</span><span class="packageCost">₹28560</span></h4>
			Package duration: <?php //echo $no_ofdays; ?><br>
			No of couple room: <?php //echo $noof_coupleroom; ?>, Price : <?php //echo $noof_coupleroom_price; ?>, Total Price : <?php //echo $total_coupleroom_price; ?><br>
			No of extrabed: <?php //echo $noof_extrabed; ?>, Price : <?php //echo $noof_extrabed_price; ?>, Total Price : <?php //echo $total_extrabed_price; ?><br>
			No of kidsroom: <?php //echo $noof_kidsroom; ?>, Price : <?php //echo $noof_kidsroom_price; ?>, Total Price : <?php //echo $total_kidsroom_price; ?><br>
			No of Nights : <?php //echo $noof_nights; ?><br>
			Total Hotel Price : <?php //echo $total_hotel_price; ?><br>
			Vehicle per day price: <?php //echo $vehicle_price; ?><br>
			Vehicle price: <?php //echo $total_vehicle_price; ?><br>
			Pick up price: <?php //echo $airport_pickup_price; ?><br>
			Drop price: <?php //echo $airport_drop_price; ?><br>
			Sub Total price : <?php //echo $sub_total_price; ?><br>
			Percentage margin : <?php //echo $pmargin_perctage; ?><br>
			Percentage price: <?php //echo $percentage_price; ?><br>
			Total price: <?php //echo $total_price; ?><br>-->
			
		</div>
		<?php		
		exit();
	}
	
	public function enquiry()
	{
		$first_name    	= $this->input->post('first_name');
		$last_name   	= $this->input->post('last_name');
		$emailid   		= $this->input->post('emailid');
		$contact_no 	= $this->input->post('contact_no');
		$message 		= $this->input->post('message');
		$noof_adult   	= $this->input->post('noof_adult');
		$noof_child   	= $this->input->post('noof_child');		
		$accommodation 	= $this->input->post('accommodation');
		$packageid 		= $this->input->post('packageid');
		$tsdate   		= $this->input->post('tsdate');
		$c_tsdate1 		= str_replace('/', '-', $tsdate);
		$c_tsdate 		= date('Y-m-d', strtotime($c_tsdate1));
		$date 			= date("Y-m-d H:i:s");		
		
		if( ($first_name != '') && ($emailid != '') && ($contact_no != ''))
		{
			$query_data = array(
				'first_name'	=> $first_name,
				'last_name'		=> $last_name,
				'emailid'		=> $emailid,
				'phone'			=> $contact_no,
				'message'		=> $message,
				'noof_adult'	=> $noof_adult,
				'noof_child'	=> $noof_child,
				'tour_date'		=> $c_tsdate,
				'accomodation'	=> $accommodation,
				'packageid'		=> $packageid,
				'inquiry_date'	=> $date
			);
			
			$insert_rec = $this->Common_model->insert_records("tbl_package_inquiry", $query_data);
			if($insert_rec)
			{			
				$accomodation_name = $this->Common_model->showname_fromid("hotel_type_name","tbl_hotel_type","hotel_type_id = $accommodation");
				$package_name = $this->Common_model->showname_fromid("tpackage_name","tbl_tourpackages","tourpackageid = $packageid");	
				
				$mailconfig   = Array(
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE,
					'newline' => '\n',
					'crlf' => '\n'
				);
				
				$mailcontent = "<!doctype html>
				<html>
					<head>
						<meta charset='utf-8'>
					</head>
					<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
						<div style='width: 100%;background: #F5F5F5;color: #000;'>
							<div style='text-align:center'><a href='".base_url()."'><img src='".base_url()."assets/images/logo.png'></a></div>				
							<div style='clear:both'></div>
						</div>
						
						<div style='padding:10px 30px;'>				  	
							<p style='margin-top:30px;'>There is an enquiry from website. Please have a look below details : </p>
							<div style='line-height:25px;font-size:14px'>
								<div><strong>TOUR PACKAGE : </strong>$package_name </div>
								<div><strong>NAME : </strong>$first_name $last_name</div>
								<div><strong>EMAIL : </strong>$emailid</div>
								<div><strong>PHONE : </strong>$contact_no</div>
								<div><strong>TRAVELLERS : </strong>$noof_adult Adult $noof_child child</div>
								<div><strong>DATE OF TRAVEL : </strong>$tsdate</div>
								<div><strong>ACCOMODATION TYPE : </strong>$accomodation_name</div>						
								<div><strong>ENQUIRY DETAILS : </strong>$message</div>
							</div>						
						</div>				
						
						<div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
							<div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
								&copy; ".date("Y")." All right reserved. myholidayhappiness.com
							</div>
						</div>
					</body>
				</html>";
				
				$subject = "New tour package enquiry from MyHolidayHapiness.";
				$from_mail = $this->Common_model->show_parameter(9);
				$to_mail = $this->Common_model->show_parameter(2);

                // $this->load->library('email', $mailconfig);
                // $this->email->from($from_mail, "myholidayhappiness.com");
                // $this->email->to($to_mail);
                // $this->email->reply_to($emailid, $first_name);
                // $this->email->subject($subject);
                // $this->email->message($mailcontent);
                // @$this->email->send(); 
                
                    $headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
                        
                        'X-Mailer: PHP/' . phpversion();
                 $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
                mail($to_mail, $subject, $mailcontent, $headers);
                
				//echo $mailcontent ; exit;
				/** End - Send Mail **/				
				echo "success";
			}
			else
				echo "error";
		}
		else
			echo "error";

		exit();
	}
	
	
}

