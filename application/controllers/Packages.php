<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/lib/config_paytm.php");
require_once(APPPATH."libraries/lib/encdec_paytm.php");

class Packages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->helper('captcha');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
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
		//$data = array();
		$vals = array(
			'word'          => '',
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url().'assets/captcha/',
			'font_path'     => './assets/fonts/raavib_0.ttf',
			'img_width'     => '140',
			'img_height'    => 38,
			'expiration'    => 7200,
			'word_length'   => 5,
			'font_size'     => 18,
			'img_id'        => 'Imageid',
			'pool'          => '123456789ABCDEFGHJKLMNPQRSTUVWXYZ',
	
			// White background and border, black text and red grid
			'colors'        => array(
					'background' => array(255, 255, 255),
					'border' => array(255, 255, 255),
					'text' => array(0, 0, 0),
					'grid' => array(255, 40, 40)
			)
		);
		$cap = create_captcha($vals);
		$this->session->set_userdata('captchaWord', $cap['word']);
		$data = array_merge($data, $cap);
		$vals = array(
			'word'          => '',
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url().'assets/captcha/',
			'font_path'     => './assets/fonts/raavib_0.ttf',
			'img_width'     => '140',
			'img_height'    => 38,
			'expiration'    => 7200,
			'word_length'   => 5,
			'font_size'     => 18,
			'img_id'        => 'Imageid',
			'pool'          => '123456789ABCDEFGHJKLMNPQRSTUVWXYZ',
	
			// White background and border, black text and red grid
			'colors'        => array(
					'background' => array(255, 255, 255),
					'border' => array(255, 255, 255),
					'text' => array(0, 0, 0),
					'grid' => array(255, 40, 40)
			)
		);
		$cap = create_captcha($vals);
		$this->session->set_userdata('captchaWord', $cap['word']);
		$data = array_merge($data, $cap);
		
				$this->load->view('packages', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
		else
			redirect(base_url(),'refresh');		
	}
	
	
	public function captcha_refresh()
	{
		$vals = array(
			'word'          => '',
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url().'assets/captcha/',
			'font_path'     => './assets/fonts/raavib_0.ttf',
			'img_width'     => '120',
			'img_height'    => 35,
			'expiration'    => 7200,
			'word_length'   => 5,
			'font_size'     => 18,
			'img_id'        => 'Imageid',
			'pool'          => '123456789ABCDEFGHJKLMNPQRSTUVWXYZ',
	
			// White background and border, black text and red grid
			'colors'        => array(
					'background' => array(255, 255, 255),
					'border' => array(255, 255, 255),
					'text' => array(0, 0, 0),
					'grid' => array(255, 40, 40)
			)
		);

		$cap = create_captcha($vals);
		$this->session->set_userdata('captchaWord', $cap['word']);
		echo $cap['image'];	
	}
	public function get_package_max_capacity()
	{
	   
		    $package_data=$this->Common_model->get_records("starting_city","tbl_tourpackages","tourpackageid=".$_REQUEST["package_id"]);
    		foreach ($package_data as $packages) {
    			$package_startingcity = $this->db->escape($packages["starting_city"]);
    		} 
		
	      
		 $noof_vehicle = $this->Common_model->noof_records("a.priceid", "tbl_vehicleprices as a, tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid and a.destination=$package_startingcity and a.status=1");

            $max_vehicle_capacity = 0;
            if ($noof_vehicle > 0) {
                $max_vehicle_capacity = $this->Common_model->showname_fromid("max(b.capacity)", "tbl_vehicleprices as a, tbl_vehicletypes as b", "a.vehicle_name=b.vehicleid and a.destination=$package_startingcity and a.status=1");
            }
        echo $max_vehicle_capacity;
		exit();
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
						
						<a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : "My Holiday Happiness"; ?>"></a>							
						<?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
						<div class="tourist-duration"> <?php echo $show_duration; ?> </div>
					</div>
					<div class="tourist-bottom-details">
						<ul class="iconlist">									
							<?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation"></li><?php endif; ?>
							<?php if($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li><?php endif; ?>
							<?php if($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li><?php endif; ?>	
							<?php if($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li><?php endif; ?>
							<?php if($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li><?php endif; ?>
						</ul>
						<div class="touristlist-hdng "><?php echo $tpackage_name; ?> <?php /*if($noof_assoc_dest > 0): ?> |  <?php echo $show_assoc_dests; ?><?php endif;*/ ?></div>
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
	
		public function get_package_iternaries()
	{
	       $package_data=$this->Common_model->get_records("itinerary","tbl_tourpackages","tourpackageid=".$_REQUEST["package_id"]);
    		foreach ($package_data as $packages) {
    			$itinerary = $packages["itinerary"];
    		}  
        
	    $noof_itinerary = $this->Common_model->noof_records("itinerary_daywiseid", "tbl_itinerary_daywise", "itinerary_id=$itinerary");
         if ($noof_itinerary > 0) { ?>
            <ul class="timeline">
            <?php  $day = 1;
                    $itineraries = $this->Common_model->get_records("*", "tbl_itinerary_daywise", "itinerary_id=$itinerary", "itinerary_daywiseid asc");
                foreach ($itineraries as $itinerary_res) {
                    ?>
                    <li>
                        <div class="item">
                            
                            <div class="timelineheading"> <span style="padding-top: 15px;">Day <?php echo $day; ?> </span> - <?php echo $itinerary_res["title"]; ?></div>
                            <?php
                            $get_iter = $itinerary_res['place_id'];
                            if ($get_iter != "") {
                                $get_places = $this->Common_model->get_records("placeid, destination_id, place_name, place_url", "tbl_places", "placeid in($get_iter)");
                                if (!empty($get_places)) {
                                    foreach ($get_places as $get_place) {
                                        $getplace_name = $get_place['place_name'];
                                        $getplace_destid = $get_place['destination_id'];
                                        $getplace_url = $get_place['place_url'];

                                        $getplace_dest_data = $this->Common_model->join_records("a.destination_url, b.state_url", "tbl_destination as a", "tbl_state as b", "a.state=b.state_id", "a.destination_id=$getplace_destid");
                                        foreach ($getplace_dest_data as $getplace_placedest) {
                                            $getplace_destinationurl = $getplace_placedest['destination_url'];
                                            $getplace_state_url = $getplace_placedest['state_url'];
                                        }
                                        ?>
                                       <!--  <div style="text-indent: 10px;"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $getplace_name; ?></div> -->
                                        <div style="text-indent: 10px;color: #000;"><a href="<?php echo base_url() . 'place/' . $getplace_state_url . '/' . $getplace_destinationurl . '/' . $getplace_url; ?>" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $getplace_name; ?></a></div> 
                                        <?php
                                    }
                                }
                            }
                            foreach(explode(', ',$itinerary_res["other_iternary_places"]) as $other_place){ if($other_place){?>
                                <div style="text-indent: 10px;color: #000;"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $other_place; ?></div>
                           <?php }}
                            ?>
                        </div>
                    </li> 
                    <?php
                    $day++;
                }
                ?>
            </ul>
        <?php }
		exit();
	}
		public function get_package_accommodations()
	{
	    
		    $package_data=$this->Common_model->get_records("starting_city","tbl_tourpackages","tourpackageid=".$_REQUEST["package_id"]);
    		foreach ($package_data as $packages) {
    			$package_startingcity = $this->db->escape($packages["starting_city"]);
    		} 
		
		    $tourpackageid=$_REQUEST["package_id"];
	
		  $accommodation_types = $this->Common_model->join_records("DISTINCT(a.hotel_type) as hotel_type_id", "tbl_hotel as a", "tbl_hotel_type as b", "a.hotel_type=b.hotel_type_id", "a.status=1 and a.destination_name in ( select destination_id from tbl_package_accomodation where package_id=$tourpackageid)", "b.hotel_type_name desc");
            ?>  <option value=""> - - Select Accommodation - - </option> <?php
            $hotel_typeids = array();
            if (!empty($accommodation_types)) {
                foreach ($accommodation_types as $accommodation_type) {
                    $hotel_typeids[] = $accommodation_type["hotel_type_id"];
                }
                $hotel_typeid = implode(", ", $hotel_typeids);
                
                echo $this->Common_model->populate_select($dispid = "", "hotel_type_id", "hotel_type_name", " tbl_hotel_type", "hotel_type_id in ($hotel_typeid)", "hotel_type_name desc", "");
             /*  $get_hotel_types=$this->Common_model->get_records("hotel_type_id,hotel_type_name","tbl_hotel_type","hotel_type_id in ($hotel_typeid)", "hotel_type_name desc");
               $options = "<option value=''>-Select Vehicle-</option>";
        		if (!empty($get_hotel_types)) {
        			foreach ($get_hotel_types as $hotel_types) {
        				$options .= "<option value=".$hotel_types['hotel_type_id'].">".$hotel_types['hotel_type_name']."</option>";	
        			}
        		}
        		echo $options;*/
            }
		exit();
	}
	public function getvehicles()
	{
		$totalcount = $_REQUEST["totalcount"];
		if(isset($_REQUEST['package_id'])){
		    $package_data=$this->Common_model->get_records("starting_city","tbl_tourpackages","tourpackageid=".$_REQUEST["package_id"]);
    		foreach ($package_data as $packages) {
    			$package_startingcity = $this->db->escape($packages["starting_city"]);
    		} 
		}else{
		    $package_startingcity = $this->db->escape($_REQUEST["destination"]);
		}
			
		
		
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
/*	public function getvehicles()
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
	}*/
	
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
    			 
    			 $accommodation_hotels = $this->Common_model->get_records("*", "tbl_hotel", "destination_name='$accommodation_destination' and hotel_type='$first_hoteltype' and status = 1","default_price asc");	
    			 
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
    							echo str_repeat('<i class="fas fa-star"></i>', (int) $acc_star_floorval);
    							echo ( $acc_star_decval > 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
    							echo str_repeat('<i class="far fa-star"></i>', (int) $acc_star_balanceint);
    							?>
    						</div>
    					</div>
    				</div>
    				<?php $sel_count++; } } else {
    				echo "No hotel Available";	
    				}?>
    			</div>
    		</div>
    		
    		<div class="clearfix"></div>
    		<?php if($hotelcount < $noof_hotels){ ?><div  class="col-md-12"><hr></div><?php } ?>
    		
    		<?php $hotelcount++; } } ?>
    		<?php
    	}	
    	
		public function get_pdfs(){
	    
		$hid_packageid = $_REQUEST["hid_packageid"];
		$quantity_adult = $_REQUEST["quantity_adult"];
		$quantity_child = $_REQUEST["quantity_child"];		
		$travel_date = $_REQUEST["travel_date"];
		$splitdate = explode("/",$travel_date);		
		$travel_date_foramt = $splitdate[2]."-".$splitdate[1]."-".$splitdate[0];
		$travel_year = date("Y", strtotime($travel_date_foramt));
		
		$package_data=$this->Common_model->get_records("tpackage_name, package_duration, pmargin_perctage, starting_city, itinerary","tbl_tourpackages","tourpackageid=$hid_packageid");
		foreach ($package_data as $packages) {
			$package_duration = $packages['package_duration'];
			$pmargin_perctage = $packages['pmargin_perctage'];
			$starting_city = $packages['starting_city'];
			$tpackage_name = $packages['tpackage_name'];
			$itinerary = $packages['itinerary'];
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
		$all_hotel_ids = implode(",",$field_value);
	    $rowspan=1;
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
				$rowspan++;
			}
			
			$total_coupleroom_price += $hotel_coupleroom_price;
			$total_extrabed_price += $hotel_extrabed_price;
			$total_kidsroom_price += $hotel_kidsroom_price;
		}
		
		$total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;		
		$total_vehicle_price = $vehicle_price*$no_ofdays;
		
		$airport_pickup = 0;
		$airport_pickup_price = 0;
		if(isset($_REQUEST["airport_pickup"])) {
			$airport_pickup_price = $pick_drop_price;
			$airport_pickup = 1;
		}
		
		$airport_drop = 0;
		$airport_drop_price = 0;
		if(isset($_REQUEST["airport_drop"])) {
			$airport_drop_price = $pick_drop_price;
			$airport_drop = 1;
		}
		
		$sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;
		?>
		
			<script type="text/javascript">

			    function enhanceWordBreak({doc, cell, column}) {
                    if (cell === undefined) {
                      return;
                    }
                
                    const hasCustomWidth = (typeof cell.styles.cellWidth === 'number');
                
                    if (hasCustomWidth || cell.raw == null || cell.colSpan > 1) {
                      return
                    }
                
                    let text;
                
                    if (cell.raw instanceof Node) {
                      text = cell.raw.innerText;
                    } else {
                      if (typeof cell.raw == 'object') {
                        // not implemented yet
                        // when a cell contains other cells (colSpan)
                        return;
                      } else {
                        text = '' + cell.raw;
                      }
                    }
                
                    // split cell string by spaces
                    const words = text.split(/\s+/);
                
                    // calculate longest word width
                    const maxWordUnitWidth = words.map(s => Math.floor(doc.getStringUnitWidth(s) * 100) / 100).reduce((a, b) => Math.max(a, b), 0);
                    const maxWordWidth = maxWordUnitWidth * (cell.styles.fontSize / doc.internal.scaleFactor)
                
                    const minWidth = cell.padding('horizontal') + maxWordWidth;
                
                    // update minWidth for cell & column
                
                    if (minWidth > cell.minWidth) {
                      cell.minWidth = minWidth;
                    }
                
                    if (cell.minWidth > cell.wrappedWidth) {
                      cell.wrappedWidth = cell.minWidth;
                    }
                
                    if (cell.minWidth > column.minWidth) {
                      column.minWidth = cell.minWidth;
                    }
                
                    if (column.minWidth > column.wrappedWidth) {
                      column.wrappedWidth = column.minWidth;
                    }
                  }
				
					
				function downloadDetails(){
					
						const { jsPDF } = window.jspdf;
						var doc = new jsPDF();
						
						let packageName="<?php echo $tpackage_name ?>";
						let spackageName="<?php echo explode("|",$tpackage_name)[0].'|'.(isset(explode("|",$tpackage_name)[1])?explode("|",$tpackage_name)[1]:'')  ?>";
						var splitTitle = doc.splitTextToSize(spackageName, 240);
						var splitTitle1 = doc.splitTextToSize( (splitTitle[1]?splitTitle[1]:'')+(splitTitle[2]?splitTitle[2]:''), 300);
						let no_of_passengers="No. of pax – <?php echo $quantity_adult; ?> Adults, <?php echo $quantity_child; ?> Childrens";
						

						var c = document.createElement('canvas');
						//var img = document.querySelector('#main_site_logo');
						var img = new Image;
						//img.src= "<?php echo base_url();?>"+'assets/images/My_Holiday_Logo-min.png';
						//img.src= "<?php echo base_url();?>"+'/assets/images/south_logo_3.png';
						img.src= "<?php echo base_url();?>"+'assets/images/My_Holiday_Logo_3.png';
						
						img.onload = () => {
						c.height = img.naturalHeight;
						c.width = img.naturalWidth;
						var ctx = c.getContext('2d');

						ctx.drawImage(img, 0, 0, c.width, c.height);
						var base64String = c.toDataURL();
						//console.log(base64String);
						//var base64String = "";
							doc.addImage(base64String, "PNG", 165, 10,  35, 15, undefined,'FAST');
						//doc.addImage(base64String, "PNG", 160, 0,  45, 40, undefined,'FAST');

						//doc.addImage(base64String, "PNG", 160, 5,  45, 20, undefined,'FAST');


						doc.setFontSize(9);
						doc.setFont("Helvetica", "bold");
						doc.text("“"+splitTitle[0]+(splitTitle1[0]?"":"”"), 100 - (doc.getTextDimensions("“"+splitTitle[0]+(splitTitle1[0]?"":"”")).w / 2) , 35);
						var height=5;
						/*if(splitTitle1[0]){doc.text(splitTitle1[0]+(splitTitle1[1]?"":"”"), 15, 35+height, { align : "left" }); height+=5;}
						if(splitTitle1[1]){doc.text(splitTitle1[1]+"”", 15, 35+height, { align : "left" }); height+=5;}*/
						
						
						if(splitTitle1[0]){doc.text(splitTitle1[0]+(splitTitle1[1]?"":"”"),  100 - (doc.getTextDimensions(splitTitle1[0]+(splitTitle1[1]?"":"”")).w / 2), 35+height); height+=5;}
						if(splitTitle1[1]){doc.text(splitTitle1[1]+"”",  100 - (doc.getTextDimensions(splitTitle1[1]+"”").w / 2), 35+height); height+=5;}
						
						
						
						doc.setFont("Helvetica","normal");
						doc.text("Dear Sir/Madam,", 15, 40+height);

						doc.text("Please find requested ", 15, 48+height);
						let strlength=doc.getTextDimensions("Please find requested ").w;
						doc.setFont("Helvetica", "bold");

						/*doc.text("“"+spackageName+"” ", (strlength+15), 58+height);
						strlength+=(15+doc.getTextDimensions("“"+spackageName+"” ").w);*/
						
						
						doc.text("“"+splitTitle[0]+(splitTitle1[0]?"":"”"), (strlength+15) , 48+height);
						strlength+=(15+doc.getTextDimensions("“"+splitTitle[0]+(splitTitle1[0]?"":"”")).w);
						  
						if(splitTitle1[0]){ height+=5;doc.text(splitTitle1[0]+(splitTitle1[1]?"":"” "), 15, 48+height); strlength=(15+doc.getTextDimensions(splitTitle1[0]+(splitTitle1[1]?"":"” ")).w);}
						if(splitTitle1[1]){ height+=5; doc.text(splitTitle1[1]+"”", 15, 48+height);  strlength=(15+doc.getTextDimensions(splitTitle1[1]+"”").w);}
						
						doc.setFont("Helvetica","normal");
						if((doc.getTextDimensions("trip details.").w + strlength)%300==0){
						    height+=5;
						}
						
						doc.text("trip details.", (strlength%300)+1, 48+height);
						
						
						doc.setDrawColor(0);
						doc.setFillColor(255, 255, 0);
						doc.rect(14, 53+height, doc.getTextDimensions(no_of_passengers).w+1, doc.getTextDimensions(no_of_passengers).h+1, "F");
						doc.text(no_of_passengers, 14, 56+height);

						
						 let result = [];
						<?php $nights=0; foreach($field_value as $index => $hotel_id)
						{
							$hotel_details = $this->Common_model->get_records("hotel_name, destination_name, room_type", "tbl_hotel", "hotel_id=$hotel_id");

							$hotel_name=$hotel_details[0]['hotel_name'];
							$room_type=$hotel_details[0]['room_type'];

							$acc_destiantion_id = $this->Common_model->showname_fromid("destination_name", "tbl_hotel", "hotel_id=$hotel_id");
							$noof_nights = $this->Common_model->showname_fromid("noof_days", "tbl_package_accomodation", "package_id=$hid_packageid and destination_id=$acc_destiantion_id");
							$destination_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", " destination_id=$acc_destiantion_id");
                                for($n=0; $n<$noof_nights; $n++)
			                    {
				            //        $hoteldate = date("Y-m-d", strtotime("+$n days", strtotime("$travel_date_foramt")));
								$hoteldate = date("dS M", strtotime("+".($nights)." days", strtotime("$travel_date_foramt")));?>
								
								if(0==<?php echo $index; ?> && 0==<?php echo $nights; ?> ){

									result.push(["<?php echo $hoteldate ?>","<?php echo $hotel_name ?>","<?php echo $destination_name ?>","<?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?>", "Breakfast" ,{ content: "<?php echo $vehicle_name ?>", rowSpan: <?php echo $rowspan; ?>, styles: { valign: 'middle' }} , { content: "<?php echo 'Rs. '. preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_price); ?>", rowSpan: <?php echo $rowspan; ?>, styles: { valign: 'middle' }}]);
								}else{
									
									result.push(["<?php echo $hoteldate ?>","<?php echo $hotel_name ?>","<?php echo $destination_name ?>","<?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?>", "Breakfast" ]);
								}
								
									
							<?php 
							    $nights++;
			                    }
						}?>
						let yPos = 0;

						doc.autoTable({
					       theme: 'grid',    
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216],textColor: [2, 0, 0] , lineWidth: 0.25,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },     
					      pageBreak: 'avoid',	   
					      startY : 62+height,
					      head:  [["Date","Hotel", "Place","No. of rooms","Notes","Vehicle","Total Cost"]],
					      body: result,   
					      didParseCell:enhanceWordBreak,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    }
					    });
						yPos+=5;
						var tableWidth=0;
						for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							var timelineheadingWidth=doc.getTextDimensions(document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','')).w
							tableWidth=tableWidth<timelineheadingWidth?timelineheadingWidth:tableWidth;
						}
						for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							let iternaryHeader=[], iternaryBody="",iternaryResult=[];
								iternaryHeader=[document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','')];

								var iternaryElements=document.querySelectorAll('.timeline li')[i].querySelectorAll('li div:not(.item):not(.timelineheading)');

								for (var j = 0; j < iternaryElements.length; j++) {
									//iternaryElement[i]
									//iternaryBody+=iternaryElements[j].innerText+(j==iternaryElements.length-1?'':'\n');
									iternaryResult.push([iternaryElements[j].innerText]);
								}

								
									//console.log(iternaryBody);	
									
								//let iternaryResult=[iternaryBody];
								//console.log(iternaryResult);	
								doc.autoTable({
							       theme: 'grid',     
							       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0] },
							      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
							      startY : yPos,
							      pageBreak: 'avoid',
							      tableWidth:tableWidth,
							      head:  [iternaryHeader],
							      body: iternaryResult,
							      columnStyles: {
                                     0: {cellWidth: 150},
							          
							      },
					             didParseCell:enhanceWordBreak,
							      didDrawPage: function(data) {
								        yPos = data.cursor.y;
								    },
								     willDrawCell: function(data) {
		      							doc.setDrawColor(0, 0, 0); 
			      							
								    	if((data.row.index==iternaryResult.length-1 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		 doc.line(
										        data.cell.x,
										        data.cell.y + data.cell.height,
										        data.cell.x + data.cell.width,
										        data.cell.y + data.cell.height
										      );
										      doc.setLineWidth(0.25);	
								    	}

								    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }           
								   }

							    });
							
						}

						

						var div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Inclusions'");?>`;
	 						inclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });


	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Exclusions'"); ?>`;
	 						exclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

						




						let totalExclustion=inclusions.length>exclusions.length? inclusions.length : exclusions.length;
						let inclusionsResults=[];
						for (var i = 0; i < totalExclustion; i++) {
								
							if(inclusions[i] || exclusions[i] ){
								var inclusionsText= inclusions[i];
								var exclusionsText=exclusions[i];
								inclusionsResults.push([
									inclusionsText?'• '+inclusionsText.replace("\t", "") : '',
									exclusionsText?'• '+exclusionsText.replace("\t", "") : ''
								])
							}
							
						}
						/*let InclusionsText= "";
						let ExclusionsText="";
						for (var i = 0; i < inclusions.length; i++) {
							if(inclusions[i]){
								InclusionsText+='• '+inclusions[i].replace("\t", "")+(i==inclusions.length-1?'':'\n')
							}
							
						}
						//console.log(exclusions);
						for (var i = 0; i < exclusions.length; i++) {
							if(exclusions[i]){
								ExclusionsText+='• '+exclusions[i].replace("\t", "")+(i==exclusions.length-1?'':'\n')
							}
						}*/


						
						//inclusionsResults.push([InclusionsText,ExclusionsText]);

						



						doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3}, fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth:0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},  cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3}, fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					      head:  [['Inclusions', 'Exclusions']],
					      body: inclusionsResults,
					      pageBreak: 'avoid',
					      didParseCell:enhanceWordBreak,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    },
						    willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
	      							
						    	//if(data.row.index==inclusionsResults.length-1 && data.section=='body'){
						    		if((data.row.index==inclusionsResults.length-1 && data.section=='body' )){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						    		
						      }        

					    });


	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Cancellation Charges'"); ?>`;
	 						var cancallations=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						//console.log(cancallations);
	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Refunds'"); ?>`;
	 						var refunds=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						//console.log(refunds);
	 						/*let CancellationText= "";
							let RefundText="";
						for (var i = 0; i < cancallations.length; i++) {
							if(cancallations[i]){
								CancellationText+='• '+cancallations[i].replace("\t", "")+(i==cancallations.length-1?'':'\n')
							}
							
						}
						for (var i = 0; i < refunds.length; i++) {
							if(refunds[i]){
								RefundText+='• '+refunds[i].replace("\t", "")+(i==refunds.length-1?'':'\n')
							}
						}
						let cancallationResults=[[CancellationText,RefundText]];
							
						*/
	 					let totalCancallations=cancallations.length>refunds.length? cancallations.length : refunds.length;
						let cancallationResults=[];
						for (var i = 0; i < totalCancallations; i++) {
								
							if(cancallations[i] || refunds[i] ){
								var cancallationsText= cancallations[i];
								var refundsText=refunds[i];
								cancallationResults.push([
									cancallationsText?'• '+cancallationsText.replace("\t", "") : '',
									refundsText?'• '+refundsText.replace("\t", "") : ''
								])
							}
							
						}

						
						
					    doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25}, fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					      pageBreak: 'avoid',
					      head:  [['Cancellation Charges', 'Refunds']],
					      didParseCell:enhanceWordBreak,
					     /* body: [ ["• 16 day or more before the journey:35% deduction \n• 14 day or more before the journey:50% deduction \n• 7 to 14 days before the journey: 75% deduction \n • 1 to 6 days before the journey: Non-refundable","Refunds All refunds are processed with 7 working days. "]],*/
					       body: cancallationResults,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    } , 
						    willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
	      							
						    	//if(data.row.index==cancallationResults.length-1 && data.section=='body'){
						    		if((data.row.index==cancallationResults.length-1 && data.section=='body' )){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						    		
						      }         

					    });

					    	div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Bank Account'"); ?>`;
	 						var bankAccounts=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - UPI'"); ?>`;
	 						var upis=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

	 						let bankAccountsText= "";
							let upiText="";
							let bankResults=[];
						/*for (var i = 0; i < bankAccounts.length; i++) {
							if(bankAccounts[i]){
								bankAccountsText+=bankAccounts[i].replace("\t", "")+(i==bankAccounts.length-1?'':'\n')
							}
							
						}
						for (var i = 0; i < upis.length; i++) {
							if(upis[i]){
								upiText+='• '+upis[i].replace("\t", "")+(i==upis.length-1?'':'\n')
							}
						}

						let bankResults=[ [bankAccountsText , upiText]];*/

							let totalAccounts=bankAccounts.length>upis.length? bankAccounts.length : upis.length;
						//let bankResults=[];
						for (var i = 0; i < totalAccounts; i++) {
								
							if(bankAccounts[i] || upis[i] ){
								bankAccountsText= bankAccounts[i];
								 upiText=upis[i];
								bankResults.push([
									bankAccountsText?bankAccountsText.replace("\t", "") : '',
									upiText?'• '+upiText.replace("\t", "") : ''
								])
							}
							
						}


					    doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					       pageBreak: 'avoid',
					      head:  [['Bank Account', 'UPI (Google Pay/BHIM/UPI/PhonePe)']],
					      didParseCell:enhanceWordBreak,
					      /*body: [ ["Bank name - IDFC First Bank \nAccount name - My Holiday Happiness \nAccount number - 10034757831 \nAccount type - Current \nIFSC Code - IDFB0080151 (Residency Road" ,"• UPI ID - 9886525253@okbizaxis \n• PhonePe - 9886525253 \n• Google Pay - 9886525253"]],*/
					      body: bankResults ,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    },          
						     willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
	      						
						    	if((data.row.index==bankResults.length-1 && data.section=='body' )){	
						    	//if(data.row.index==bankResults.length-1 && data.section=='body'){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						    		
						      }
					    });

					   // doc.html('<p>Please read our company reviews by clicking the link - <a href="">My Holiday Happiness reviews</p></a>',function() {});
					    doc.text("Please read our company reviews by clicking the link - ", 15, yPos+10);

						//doc.setFont("Helvetica","normal");
						//doc.text("trip details.", doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+1, 58);
						doc.setTextColor(0, 0, 255);
					    doc.textWithLink('My Holiday Happiness reviews', doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16, yPos+10, { url: 'https://www.google.com/search?q=my+holiday+happiness&oq=My+ho&aqs=chrome.0.69i59j69i57j69i60l2j69i59l2.1246j0j7&sourceid=chrome&ie=UTF-8#lrd=0x3bae3f2ed2301e45:0x89e7ba8485a43c37,1,,,' });
					    doc.setDrawColor( 0, 0,255);
					    doc.line( 
					    			 doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16, 
					    			yPos+8+doc.getTextDimensions("My Holiday Happiness reviews").h,
					    			doc.getTextDimensions("My Holiday Happiness reviews").w +  doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16,
					    			yPos+8+doc.getTextDimensions("My Holiday Happiness reviews").h);

						var pageCount = doc.internal.getNumberOfPages();
						for(i = 0; i < pageCount; i++) { 
						  doc.setPage(i); 
						  let pageCurrent = doc.internal.getCurrentPageInfo().pageNumber; 
						  doc.setFontSize(9);
						  doc.setTextColor(255, 0, 0);
						  
						  doc.text('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Email Id'"); ?>', 10, doc.internal.pageSize.height - 10);
						  doc.text('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Phone No'"); ?>', doc.internal.pageSize.width-10-doc.getTextDimensions('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Email Id'"); ?>').w, doc.internal.pageSize.height - 10);

						    doc.saveGraphicsState();
						    doc.setGState(new doc.GState({opacity: 0.1}));
						    doc.addImage(base64String, "PNG", 40, 80, 120, 60, undefined,'FAST');
						    doc.restoreGraphicsState();

						}
						/*for(i = 0; i < pageCount; i++) { 
						    doc.setPage(i)
						    doc.saveGraphicsState();
						    doc.setGState(new doc.GState({opacity: 0.2}));
						    doc.addImage(base64String, "PNG", 40, 40, 150, 75);
						    doc.restoreGraphicsState();
						}*/
						 
						doc.save(spackageName+".pdf");
						};
				}
			
				setTimeout(function () {
                  	downloadDetails();
                }, 1000);
			</script>
		<!-- HTML to print -->		
		
		</div>
		<?php		
		exit();
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
		
		$package_data=$this->Common_model->get_records("tpackage_name, package_duration, pmargin_perctage, starting_city, itinerary","tbl_tourpackages","tourpackageid=$hid_packageid");
		foreach ($package_data as $packages) {
			$package_duration = $packages['package_duration'];
			$pmargin_perctage = $packages['pmargin_perctage'];
			$starting_city = $packages['starting_city'];
			$tpackage_name = $packages['tpackage_name'];
			$itinerary = $packages['itinerary'];
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
		$all_hotel_ids = implode(",",$field_value);
		$rowspan=1;
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
				$rowspan++;
			}
			
			$total_coupleroom_price += $hotel_coupleroom_price;
			$total_extrabed_price += $hotel_extrabed_price;
			$total_kidsroom_price += $hotel_kidsroom_price;
			
		}
		
		$total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;		
		$total_vehicle_price = $vehicle_price*$no_ofdays;
		
		$airport_pickup = 0;
		$airport_pickup_price = 0;
		if(isset($_REQUEST["airport_pickup"])) {
			$airport_pickup_price = $pick_drop_price;
			$airport_pickup = 1;
		}
		
		$airport_drop = 0;
		$airport_drop_price = 0;
		if(isset($_REQUEST["airport_drop"])) {
			$airport_drop_price = $pick_drop_price;
			$airport_drop = 1;
		}
		
		$sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;
		?>
		<?php if($this->Common_model->show_parameter(37)){	?><marquee style="color:red"><?php echo $this->Common_model->show_parameter(37); ?></marquee><?php } ?>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/users.png" alt="users"><?php echo $quantity_adult; ?> Adults</div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/children.png" alt="children"><?php echo $quantity_child; ?> Childrens</div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/car.png" alt="car"><?php echo $vehicle_name; ?></div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/modal-small-calendar.png" alt="calendar"><?php echo $travel_date; ?></div>
		<div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/bed.png" alt="bed"><?php echo $accommodation_name; ?></div>
		<?php if(isset($_REQUEST["airport_pickup"])) { ?><div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/car-icon.png" alt="Pickup">Pickup</div><?php } ?>
		<?php if(isset($_REQUEST["airport_drop"])) { ?><div class="formlistcol"><img src="<?php echo base_url(); ?>assets/images/car-icon1.png" alt="Drop">Drop</div><?php } ?>
		<div class="clearfix"></div>
		<hr>
		<p>Fare includes Stay, Cab, Driver Charges, Toll, Parking, GST & Inter-state Tax (if any)</p>
		<div style="color: #000">
			<img src="<?php echo base_url(); ?>assets/images/pricetag.png" alt="Price">Total price<br>
			<h4><span class="packageCost"><?php echo $this->Common_model->currency; ?><?php echo $total_price; ?></span></h4>

		<!-- HTML to print -->
			<script type="text/javascript">
                
			    function enhanceWordBreak({doc, cell, column}) {
                    if (cell === undefined) {
                      return;
                    }
                
                    const hasCustomWidth = (typeof cell.styles.cellWidth === 'number');
                
                    if (hasCustomWidth || cell.raw == null || cell.colSpan > 1) {
                      return
                    }
                
                    let text;
                
                    if (cell.raw instanceof Node) {
                      text = cell.raw.innerText;
                    } else {
                      if (typeof cell.raw == 'object') {
                        // not implemented yet
                        // when a cell contains other cells (colSpan)
                        return;
                      } else {
                        text = '' + cell.raw;
                      }
                    }
                
                    // split cell string by spaces
                    const words = text.split(/\s+/);
                
                    // calculate longest word width
                    const maxWordUnitWidth = words.map(s => Math.floor(doc.getStringUnitWidth(s) * 100) / 100).reduce((a, b) => Math.max(a, b), 0);
                    const maxWordWidth = maxWordUnitWidth * (cell.styles.fontSize / doc.internal.scaleFactor)
                
                    const minWidth = cell.padding('horizontal') + maxWordWidth;
                
                    // update minWidth for cell & column
                
                    if (minWidth > cell.minWidth) {
                      cell.minWidth = minWidth;
                    }
                
                    if (cell.minWidth > cell.wrappedWidth) {
                      cell.wrappedWidth = cell.minWidth;
                    }
                
                    if (cell.minWidth > column.minWidth) {
                      column.minWidth = cell.minWidth;
                    }
                
                    if (column.minWidth > column.wrappedWidth) {
                      column.wrappedWidth = column.minWidth;
                    }
                  }
			
				
					
				function downloadDetails(){
					    
                                $("#download_pdf_button").prop("disabled", true);
                                $("#download_pdf_button").html('<span style="font-size:9px;"><i class="fa fa-spinner fa-spin fa-2x"></i></span> Downloading...');
						const { jsPDF } = window.jspdf;
						var doc = new jsPDF();
						
						let packageName="<?php echo $tpackage_name ?>";
						let spackageName="<?php echo explode("|",$tpackage_name)[0].'|'.(isset(explode("|",$tpackage_name)[1])?explode("|",$tpackage_name)[1]:'')  ?>";

						var splitTitle = doc.splitTextToSize(spackageName, 240);
						var splitTitle1 = doc.splitTextToSize( (splitTitle[1]?splitTitle[1]:'')+(splitTitle[2]?splitTitle[2]:''), 300);
						let no_of_passengers="No. of pax – <?php echo $quantity_adult; ?> Adults, <?php echo $quantity_child; ?> Childrens";
						

						var c = document.createElement('canvas');
						var img = new Image;
						//img.src= "<?php echo base_url();?>"+'assets/images/My_Holiday_Logo-min.png';
						img.src= "<?php echo base_url();?>"+'assets/images/My_Holiday_Logo_3.png';
					
						//img.src= "<?php echo base_url();?>"+'/assets/images/south_logo_3.png';

						img.onload = () => {
						    console.log('loaded');
						c.height = img.naturalHeight;
						c.width = img.naturalWidth;
						var ctx = c.getContext('2d');

						ctx.drawImage(img, 0, 0, c.width, c.height);
						var base64String = c.toDataURL();
						//var base64String = "";

						doc.addImage(base64String, "PNG", 165, 10,  35, 15, undefined,'FAST');
						//doc.addImage(base64String, "PNG", 160, 5,  45, 20, undefined,'FAST');
                          console.log('base64 loaded');
						doc.setFontSize(9);
						doc.setFont("Helvetica", "bold");
						/*doc.text("“"+spackageName+"”", Math.round(80-spackageName.length/2), 35);*/

						doc.text("“"+splitTitle[0]+(splitTitle1[0]?"":"”"), 100 - (doc.getTextDimensions("“"+splitTitle[0]+(splitTitle1[0]?"":"”")).w / 2) , 35);
						var height=5;
						/*if(splitTitle1[0]){doc.text(splitTitle1[0]+(splitTitle1[1]?"":"”"), 15, 35+height, { align : "left" }); height+=5;}
						if(splitTitle1[1]){doc.text(splitTitle1[1]+"”", 15, 35+height, { align : "left" }); height+=5;}*/
						if(splitTitle1[0]){doc.text(splitTitle1[0]+(splitTitle1[1]?"":"”"),  100 - (doc.getTextDimensions(splitTitle1[0]+(splitTitle1[1]?"":"”")).w / 2), 35+height); height+=5;}
						if(splitTitle1[1]){doc.text(splitTitle1[1]+"”",  100 - (doc.getTextDimensions(splitTitle1[1]+"”").w / 2), 35+height); height+=5;}



						doc.setFont("Helvetica","normal");
						doc.text("Dear Sir/Madam,", 15, 40+height);

						doc.text("Please find requested ", 15, 48+height);
						let strlength=doc.getTextDimensions("Please find requested ").w;
						doc.setFont("Helvetica", "bold");

						/*doc.text("“"+spackageName+"” ", (strlength+15), 58);
						strlength+=(15+doc.getTextDimensions("“"+spackageName+"” ").w);

						doc.setFont("Helvetica","normal");
						doc.text("trip details.", strlength+1, 58);*/


    
						doc.text("“"+splitTitle[0]+(splitTitle1[0]?"":"”"), (strlength+15) , 48+height);
						strlength+=(15+doc.getTextDimensions("“"+splitTitle[0]+(splitTitle1[0]?"":"”")).w);
						   
						if(splitTitle1[0]){ height+=5; doc.text(splitTitle1[0]+(splitTitle1[1]?"":"” "), 15, 48+height); strlength=(15+doc.getTextDimensions(splitTitle1[0]+(splitTitle1[1]?"":"” ")).w);}
						if(splitTitle1[1]){ height+=5; doc.text(splitTitle1[1]+"”", 15, 48+height);  strlength=(15+doc.getTextDimensions(splitTitle1[1]+"”").w);}
						
						doc.setFont("Helvetica","normal");
						if((doc.getTextDimensions("trip details.").w + strlength)%300==0){
						    height+=5;
						}
						
						doc.text("trip details.", (strlength%300)+1, 48+height);
						
                              console.log("trip details.");





						doc.setDrawColor(0);
						doc.setFillColor(255, 255, 0);
						doc.rect(14, 53+height, doc.getTextDimensions(no_of_passengers).w+1, doc.getTextDimensions(no_of_passengers).h+1, "F");
						doc.text(no_of_passengers, 14, 56+height);

						
						 let result = [];
						//let  tableHight=doc.getTextDimensions(document.querySelectorAll('.detailmenulist')[0].innerText).w;
						<?php $nights=0; foreach($field_value as $index => $hotel_id)
						{
							$hotel_details = $this->Common_model->get_records("hotel_name, destination_name, room_type", "tbl_hotel", "hotel_id=$hotel_id");

							$hotel_name=$hotel_details[0]['hotel_name'];
							$room_type=$hotel_details[0]['room_type'];

							$acc_destiantion_id = $this->Common_model->showname_fromid("destination_name", "tbl_hotel", "hotel_id=$hotel_id");
							$noof_nights = $this->Common_model->showname_fromid("noof_days", "tbl_package_accomodation", "package_id=$hid_packageid and destination_id=$acc_destiantion_id");
						    $destination_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", " destination_id=$acc_destiantion_id");
                                for($n=0; $n<$noof_nights; $n++)
			                    {
				            //        $hoteldate = date("Y-m-d", strtotime("+$n days", strtotime("$travel_date_foramt")));
								$hoteldate = date("dS M", strtotime("+".($nights)." days", strtotime("$travel_date_foramt")));?>
								
								if(0==<?php echo $index; ?> && 0==<?php echo $nights; ?> ){

									result.push(["<?php echo $hoteldate ?>","<?php echo $hotel_name ?>","<?php echo $destination_name ?>","<?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?>", "Breakfast" ,{ content: "<?php echo $vehicle_name ?>", rowSpan: <?php echo $rowspan; ?>, styles: { valign: 'middle' }} , { content: "<?php echo 'Rs. '. preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_price);?>", rowSpan: <?php echo $rowspan; ?>, styles: { valign: 'middle' }}]);
								}else{
									
									result.push(["<?php echo $hoteldate ?>","<?php echo $hotel_name ?>","<?php echo $destination_name ?>","<?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?>", "Breakfast" ]);
								}
								
									
							<?php 
							    $nights++;
			                    }
						}?>
						
						
						let yPos = 0;

						doc.autoTable({
					       theme: 'grid',    
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216],textColor: [2, 0, 0] , lineWidth: 0.25,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },     
					      pageBreak: 'avoid',	   
					      startY : 62+height,
					      head:  [["Date","Hotel", "Place","No. of rooms","Notes","Vehicle","Total Cost"]],
					      body: result, 
					      didParseCell:enhanceWordBreak,         
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    }
					    });
					    console.log(" Hotel Table");
						yPos+=5;
						var tableWidth=0;
						for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							var timelineheadingWidth=doc.getTextDimensions(document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','')).w
							tableWidth=tableWidth<timelineheadingWidth?timelineheadingWidth:tableWidth;
						}
						for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							let iternaryHeader=[], iternaryBody="",iternaryResult=[];
								iternaryHeader=[document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','')];

								var iternaryElements=document.querySelectorAll('.timeline li')[i].querySelectorAll('li div:not(.item):not(.timelineheading)');

								for (var j = 0; j < iternaryElements.length; j++) {
									//iternaryElement[i]
									//iternaryBody+=iternaryElements[j].innerText+(j==iternaryElements.length-1?'':'\n');
									iternaryResult.push([iternaryElements[j].innerText]);
								}

								
									//console.log(iternaryBody);	
									
								//let iternaryResult=[iternaryBody];
								//console.log(iternaryResult);	
								doc.autoTable({
							       theme: 'grid',     
							       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0] },
							      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
							      startY : yPos,
							      pageBreak: 'avoid',
							      tableWidth:tableWidth,
							      head:  [iternaryHeader],
							      body: iternaryResult,
							      columnStyles: {
                                     0: {cellWidth: 150},
							          
							      },
					              didParseCell:enhanceWordBreak,
							      didDrawPage: function(data) {
								        yPos = data.cursor.y;
								    },
								     willDrawCell: function(data) {
		      							doc.setDrawColor(0, 0, 0); 
			      							
								    	if((data.row.index==iternaryResult.length-1 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		 doc.line(
										        data.cell.x,
										        data.cell.y + data.cell.height,
										        data.cell.x + data.cell.width,
										        data.cell.y + data.cell.height
										      );
										      doc.setLineWidth(0.25);	
								    	}

								    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }           
								   }

							    });
							
						}

						    console.log("IternaryTable");

						var div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Inclusions'");?>`;
	 						inclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });


	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Exclusions'"); ?>`;
	 						exclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

						




						let totalExclustion=inclusions.length>exclusions.length? inclusions.length : exclusions.length;
						let inclusionsResults=[];
						for (var i = 0; i < totalExclustion; i++) {
								
							if(inclusions[i] || exclusions[i] ){
								var inclusionsText= inclusions[i];
								var exclusionsText=exclusions[i];
								inclusionsResults.push([
									inclusionsText?'• '+inclusionsText.replace("\t", "") : '',
									exclusionsText?'• '+exclusionsText.replace("\t", "") : ''
								])
							}
							
						}
						/*let InclusionsText= "";
						let ExclusionsText="";
						for (var i = 0; i < inclusions.length; i++) {
							if(inclusions[i]){
								InclusionsText+='• '+inclusions[i].replace("\t", "")+(i==inclusions.length-1?'':'\n')
							}
							
						}
						//console.log(exclusions);
						for (var i = 0; i < exclusions.length; i++) {
							if(exclusions[i]){
								ExclusionsText+='• '+exclusions[i].replace("\t", "")+(i==exclusions.length-1?'':'\n')
							}
						}*/


						
						//inclusionsResults.push([InclusionsText,ExclusionsText]);

						



						doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3}, fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth:0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},  cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3}, fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					      head:  [['Inclusions', 'Exclusions']],
					      body: inclusionsResults,
					      pageBreak: 'avoid',
					      didParseCell:enhanceWordBreak,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    },
						    willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
	      							
						    	//if(data.row.index==inclusionsResults.length-1 && data.section=='body'){
						    		if((data.row.index==inclusionsResults.length-1 && data.section=='body' )){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						    		
						      }        

					    });


	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Cancellation Charges'"); ?>`;
	 						var cancallations=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						//console.log(cancallations);
	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Refunds'"); ?>`;
	 						var refunds=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						//console.log(refunds);
	 						/*let CancellationText= "";
							let RefundText="";
						for (var i = 0; i < cancallations.length; i++) {
							if(cancallations[i]){
								CancellationText+='• '+cancallations[i].replace("\t", "")+(i==cancallations.length-1?'':'\n')
							}
							
						}
						for (var i = 0; i < refunds.length; i++) {
							if(refunds[i]){
								RefundText+='• '+refunds[i].replace("\t", "")+(i==refunds.length-1?'':'\n')
							}
						}
						let cancallationResults=[[CancellationText,RefundText]];
							
						*/
	 					let totalCancallations=cancallations.length>refunds.length? cancallations.length : refunds.length;
						let cancallationResults=[];
						for (var i = 0; i < totalCancallations; i++) {
								
							if(cancallations[i] || refunds[i] ){
								var cancallationsText= cancallations[i];
								var refundsText=refunds[i];
								cancallationResults.push([
									cancallationsText?'• '+cancallationsText.replace("\t", "") : '',
									refundsText?'• '+refundsText.replace("\t", "") : ''
								])
							}
							
						}

						
						
					    doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25}, fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					      pageBreak: 'avoid',
					      didParseCell:enhanceWordBreak,
					      head:  [['Cancellation Charges', 'Refunds']],
					     /* body: [ ["• 16 day or more before the journey:35% deduction \n• 14 day or more before the journey:50% deduction \n• 7 to 14 days before the journey: 75% deduction \n • 1 to 6 days before the journey: Non-refundable","Refunds All refunds are processed with 7 working days. "]],*/
					       body: cancallationResults,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    } , 
						    willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
	      							
						    	//if(data.row.index==cancallationResults.length-1 && data.section=='body'){
						    		if((data.row.index==cancallationResults.length-1 && data.section=='body' )){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						    		
						      }         

					    });

					    	div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Bank Account'"); ?>`;
	 						var bankAccounts=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - UPI'"); ?>`;
	 						var upis=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

	 						let bankAccountsText= "";
							let upiText="";
							let bankResults=[];
						/*for (var i = 0; i < bankAccounts.length; i++) {
							if(bankAccounts[i]){
								bankAccountsText+=bankAccounts[i].replace("\t", "")+(i==bankAccounts.length-1?'':'\n')
							}
							
						}
						for (var i = 0; i < upis.length; i++) {
							if(upis[i]){
								upiText+='• '+upis[i].replace("\t", "")+(i==upis.length-1?'':'\n')
							}
						}

						let bankResults=[ [bankAccountsText , upiText]];*/

							let totalAccounts=bankAccounts.length>upis.length? bankAccounts.length : upis.length;
						//let bankResults=[];
						for (var i = 0; i < totalAccounts; i++) {
								
							if(bankAccounts[i] || upis[i] ){
								bankAccountsText= bankAccounts[i];
								 upiText=upis[i];
								bankResults.push([
									bankAccountsText?bankAccountsText.replace("\t", "") : '',
									upiText?'• '+upiText.replace("\t", "") : ''
								])
							}
							
						}


					    doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					       pageBreak: 'avoid',
					      didParseCell:enhanceWordBreak,
					      head:  [['Bank Account', 'UPI (Google Pay/BHIM/UPI/PhonePe)']],
					      /*body: [ ["Bank name - IDFC First Bank \nAccount name - My Holiday Happiness \nAccount number - 10034757831 \nAccount type - Current \nIFSC Code - IDFB0080151 (Residency Road" ,"• UPI ID - 9886525253@okbizaxis \n• PhonePe - 9886525253 \n• Google Pay - 9886525253"]],*/
					      body: bankResults ,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    },          
						     willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
	      						
						    	if((data.row.index==bankResults.length-1 && data.section=='body' )){	
						    	//if(data.row.index==bankResults.length-1 && data.section=='body'){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						    		
						      }
					    });

					   // doc.html('<p>Please read our company reviews by clicking the link - <a href="">My Holiday Happiness reviews</p></a>',function() {});
					    doc.text("Please read our company reviews by clicking the link - ", 15, yPos+10);

						//doc.setFont("Helvetica","normal");
						//doc.text("trip details.", doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+1, 58);
						doc.setTextColor(0, 0, 255);
					    doc.textWithLink('My Holiday Happiness reviews', doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16, yPos+10, { url: 'https://www.google.com/search?q=my+holiday+happiness&oq=My+ho&aqs=chrome.0.69i59j69i57j69i60l2j69i59l2.1246j0j7&sourceid=chrome&ie=UTF-8#lrd=0x3bae3f2ed2301e45:0x89e7ba8485a43c37,1,,,' });
					    doc.setDrawColor( 0, 0,255);
					    doc.line( 
					    			 doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16, 
					    			yPos+8+doc.getTextDimensions("My Holiday Happiness reviews").h,
					    			doc.getTextDimensions("My Holiday Happiness reviews").w +  doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16,
					    			yPos+8+doc.getTextDimensions("My Holiday Happiness reviews").h);

						var pageCount = doc.internal.getNumberOfPages();
						for(i = 0; i < pageCount; i++) { 
						  doc.setPage(i); 
						  let pageCurrent = doc.internal.getCurrentPageInfo().pageNumber; 
						  doc.setFontSize(9);
						  doc.setTextColor(255, 0, 0);
						  
						  doc.text('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Email Id'"); ?>', 10, doc.internal.pageSize.height - 10);
						  doc.text('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Phone No'"); ?>', doc.internal.pageSize.width-10-doc.getTextDimensions('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Email Id'"); ?>').w, doc.internal.pageSize.height - 10);

						    doc.saveGraphicsState();
						    doc.setGState(new doc.GState({opacity: 0.1}));
						    doc.addImage(base64String, "PNG", 40, 80, 120, 60, undefined,'FAST');
						    doc.restoreGraphicsState();

						}
						 console.log('loaded');
						/*for(i = 0; i < pageCount; i++) { 
						    doc.setPage(i)
						    doc.saveGraphicsState();
						    doc.setGState(new doc.GState({opacity: 0.2}));
						    doc.addImage(base64String, "PNG", 40, 40, 150, 75);
						    doc.restoreGraphicsState();
						}*/
						 /*if(( window.innerWidth <= 800 ) && ( window.innerHeight <= 600 )){

							doc.save(spackageName+".pdf");
							alert("File has been downloaded");
						 }else{
						 	doc.output('dataurlnewwindow');
						 }*/
						doc.save(spackageName+".pdf");
						//doc.output('dataurlnewwindow');

						
                                 $("#download_pdf_button").prop("disabled", false);
                                $("#download_pdf_button").html('Download');
                                alert("File has been downloaded");
						};
				}
			</script>
		<!-- HTML to print -->		
			<input type="hidden" id="package_id" name="package_id" value="<?php echo $hid_packageid; ?>">
			<input type="hidden" id="package_duration" name="package_duration" value="<?php echo $package_duration; ?>">
			<input type="hidden" id="package_noofdays" name="package_noofdays" value="<?php echo $no_ofdays; ?>">
			<input type="hidden" id="starting_city" name="starting_city" value="<?php echo $starting_city; ?>">
			<input type="hidden" id="noof_adults" name="noof_adults" value="<?php echo $quantity_adult; ?>">
			<input type="hidden" id="noof_childs" name="noof_childs" value="<?php echo $quantity_child; ?>">
			<input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $vehicle; ?>">
			<input type="hidden" id="date_of_travel" name="date_of_travel" value="<?php echo $travel_date_foramt; ?>">
			<input type="hidden" id="accomodation_type" name="accomodation_type" value="<?php echo $accommodation_type; ?>">
			<input type="hidden" id="accomodation_hotels" name="accomodation_hotels" value="<?php echo $all_hotel_ids; ?>">
			<input type="hidden" id="airport_pickup" name="airport_pickup" value="<?php echo $airport_pickup; ?>">
			<input type="hidden" id="airport_drop" name="airport_drop" value="<?php echo $airport_drop; ?>">
			<input type="hidden" id="noof_coupleroom" name="noof_coupleroom" value="<?php echo $noof_coupleroom; ?>">
			<input type="hidden" id="noof_extrabed" name="noof_extrabed" value="<?php echo $noof_extrabed; ?>">
			<input type="hidden" id="noof_kidsroom" name="noof_kidsroom" value="<?php echo $noof_kidsroom; ?>">
			<input type="hidden" id="noof_nights" name="noof_nights" value="<?php echo $noof_nights; ?>">
			<input type="hidden" id="coupleroom_price" name="coupleroom_price" value="<?php echo $total_coupleroom_price; ?>">
			<input type="hidden" id="extrabed_price" name="extrabed_price" value="<?php echo $total_extrabed_price; ?>">
			<input type="hidden" id="kidsroom_price" name="kidsroom_price" value="<?php echo $total_kidsroom_price; ?>">
			<input type="hidden" id="total_hotel_price" name="total_hotel_price" value="<?php echo $total_hotel_price; ?>">
			<input type="hidden" id="vehicle_perday_price" name="vehicle_perday_price" value="<?php echo $vehicle_price; ?>">
			<input type="hidden" id="total_vehicle_price" name="total_vehicle_price" value="<?php echo $total_vehicle_price; ?>">
			<input type="hidden" id="pickup_price" name="pickup_price" value="<?php echo $airport_pickup_price; ?>">
			<input type="hidden" id="drop_price" name="drop_price" value="<?php echo $airport_drop_price; ?>">
			<input type="hidden" id="sub_total_price" name="sub_total_price" value="<?php echo $sub_total_price; ?>">
			<input type="hidden" id="percentage_margin" name="percentage_margin" value="<?php echo $pmargin_perctage; ?>">
			<input type="hidden" id="percentage_price" name="percentage_price" value="<?php echo $percentage_price; ?>">
			<input type="hidden" id="total_price" name="total_price" value="<?php echo $total_price; ?>">			
		</div>
		<?php		
		exit();
	}
	public function get_docs(){
	    
		$hid_packageid = $_REQUEST["hid_packageid"];
		$quantity_adult = $_REQUEST["quantity_adult"];
		$quantity_child = $_REQUEST["quantity_child"];		
		$travel_date = $_REQUEST["travel_date"];
		$splitdate = explode("/",$travel_date);		
		$travel_date_foramt = $splitdate[2]."-".$splitdate[1]."-".$splitdate[0];
		$travel_year = date("Y", strtotime($travel_date_foramt));
		
		$package_data=$this->Common_model->get_records("tpackage_name, package_duration, pmargin_perctage, starting_city, itinerary","tbl_tourpackages","tourpackageid=$hid_packageid");
		foreach ($package_data as $packages) {
			$package_duration = $packages['package_duration'];
			$pmargin_perctage = $packages['pmargin_perctage'];
			$starting_city = $packages['starting_city'];
			$tpackage_name = $packages['tpackage_name'];
			$itinerary = $packages['itinerary'];
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
		$all_hotel_ids = implode(",",$field_value);
	    $rowspan=1;
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
				$rowspan++;
			}
			
			$total_coupleroom_price += $hotel_coupleroom_price;
			$total_extrabed_price += $hotel_extrabed_price;
			$total_kidsroom_price += $hotel_kidsroom_price;
		}
		
		$total_hotel_price = $total_coupleroom_price + $total_extrabed_price + $total_kidsroom_price;		
		$total_vehicle_price = $vehicle_price*$no_ofdays;
		
		$airport_pickup = 0;
		$airport_pickup_price = 0;
		if(isset($_REQUEST["airport_pickup"])) {
			$airport_pickup_price = $pick_drop_price;
			$airport_pickup = 1;
		}
		
		$airport_drop = 0;
		$airport_drop_price = 0;
		if(isset($_REQUEST["airport_drop"])) {
			$airport_drop_price = $pick_drop_price;
			$airport_drop = 1;
		}
		
		$sub_total_price = $total_hotel_price + $total_vehicle_price + $airport_pickup_price + $airport_drop_price;
		
		$percentage_price = $sub_total_price*($pmargin_perctage/100);
		$total_price = $sub_total_price+$percentage_price;
		?>
			<div id="source-html" >
			    <style>
                			        
                .hlf-bordered-table td {
                    border-left: 1px solid black;
                    border-right: 1px solid black;
                    border-top: 0px solid white;
                    border-top: 0px solid white;
                  border-collapse: collapse;
                }
                .bordered-table,.bordered-table th,.bordered-table td {
                  border: 1px solid black;
                  border-collapse: collapse;
                }
                .small-text{
                	font-size: 16px;
                }
                #btn-export {
                    background: #484848;
                    color: #FFF;
                    border: #000 1px solid;
                    padding: 10px 20px;
                    font-size: 12px;
                    border-radius: 3px;
                }
                
                .content-footer {
                    text-align: center;
                }
                .source-html-outer {
                    border: #d0d0d0 1px solid;
                    border-radius: 3px;
                    padding: 10px 20px 20px 20px;
                }
                .bordered-table th, .hlf-bordered-table th{
                    text-align: left !important;
                    background-color: #d9d9d9 ;
                    
                }
			    </style>
     <p style="display: flex;justify-content: end;width: 95%;" align="right"> <img src="<?php echo base_url();?>/assets/images/My_Holiday_Logo_5.png" width="150" height="66" border="0" style="width:150px;border:0px" border="false" /> </p>
        <center><b><p class="small-text">“<?php echo explode("|",$tpackage_name)[0].'|'.(isset(explode("|",$tpackage_name)[1])?explode("|",$tpackage_name)[1]:''); ?>”</p></b></center>
       
        <p class="small-text"> Dear Sir/Madam,</p>
		<p class="small-text"> Please find requested <b>“<?php echo explode("|",$tpackage_name)[0].'|'.(isset(explode("|",$tpackage_name)[1])?explode("|",$tpackage_name)[1]:''); ?>”</b> trip details.</p></b>
		<span class="small-text" style="background-color:yellow;width:30% ;" width="30%"> "No. of pax – <?php echo $quantity_adult; ?> Adults, <?php echo $quantity_child; ?> Childrens"</span>
        <table class="small-text bordered-table" style="width:100%;" width="100%" border="1">
            <thead  >
                <tr style="background-color: #d9d9d9;border: solid 1px black">
                    <th align="left" style="font-size: 16px;padding:0px 5px;">Date</th>
                    <th align="left" style="font-size: 16px;padding:0px 5px;">Hotel</th>
                    <th align="left" style="font-size: 16px;padding:0px 5px;">Place</th>
                    <th align="left" style="font-size: 16px;padding:0px 5px;">No. of rooms </th>
                    <th align="left" style="font-size: 16px;padding:0px 5px;">Notes</th>
                    <th align="left" style="font-size: 16px;padding:0px 5px;">Vehicle</th>
                    <th align="left" style="font-size: 16px;padding:0px 5px;">Total Cost</th>
                </tr>
            </thead>
            <tbody>
            	<?php $nights=0; foreach($field_value as $index => $hotel_id)
						{
							$hotel_details = $this->Common_model->get_records("hotel_name, destination_name, room_type", "tbl_hotel", "hotel_id=$hotel_id");

							$hotel_name=$hotel_details[0]['hotel_name'];
							$room_type=$hotel_details[0]['room_type'];

							$acc_destiantion_id = $this->Common_model->showname_fromid("destination_name", "tbl_hotel", "hotel_id=$hotel_id");
							$noof_nights = $this->Common_model->showname_fromid("noof_days", "tbl_package_accomodation", "package_id=$hid_packageid and destination_id=$acc_destiantion_id");
							$destination_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", " destination_id=$acc_destiantion_id");
                                for($n=0; $n<$noof_nights; $n++)
			                    {
								$hoteldate = date("dS M", strtotime("+".($nights)." days", strtotime("$travel_date_foramt")));

								if(0==$index && 0==$nights) {?>
                <tr style="">
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo $hoteldate ?></td>
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo $hotel_name ?></td>
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo $destination_name ?></td>
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?> </td>
                    <td style="font-size: 16px;padding:0px 5px;">Breakfast</td>
                    <td style="font-size: 16px;padding:0px 5px;" rowspan="<?php echo $rowspan ?>"><?php echo $vehicle_name ?></td>
                    <td style="font-size: 16px;padding:0px 5px;" rowspan="<?php echo $rowspan ?>"><?php echo 'Rs. '.number_format($total_price) ?></td>
                </tr>
                <?php 
							    }else{?>
							    		<tr  style="">
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo $hoteldate ?></td>
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo $hotel_name ?></td>
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo $destination_name ?></td>
                    <td style="font-size: 16px;padding:0px 5px;"><?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?> </td>
                    <td style="font-size: 16px;padding:0px 5px;">Breakfast</td>
                </tr>
							  <?php   } $nights++;
			                    }
						}?>
            </tbody>
                
        </table>
        <br />
        <br />
        <p style="border:none" id="iternary_result"></p>
        
         <br />
        <br />
        <p style="border:none"id="inclusions_result"></p>

        <br />
        <br />
         <p style="border:none" id="refund_result"></p>

        <br />
        <br />
        <p style="border:none" id="bank_result"></p>
        <br />
        <br />
        <p class="small-text"> Please read our company reviews by clicking the link - <a href="https://www.google.com/search?q=my+holiday+happiness&oq=My+ho&aqs=chrome.0.69i59j69i57j69i60l2j69i59l2.1246j0j7&sourceid=chrome&ie=UTF-8#lrd=0x3bae3f2ed2301e45:0x89e7ba8485a43c37,1,,,">My Holiday Happiness reviews</a></p>
    </div>
    
</div>
	 <script>
    function exportHTML(){
    	var html="";
    	for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							//let iternaryHeader=[], iternaryBody="",iternaryResult=[];
							html+='<table class="small-text hlf-bordered-table" style="width:80%" width="80%" border="1"> <thead><tr  style="background-color: #d9d9d9"><th align="left" style="font-size: 16px;padding:0px 5px;">';
								html+=document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','');
								html+='</th></tr></thead><tbody>';
								var iternaryElements=document.querySelectorAll('.timeline li')[i].querySelectorAll('li div:not(.item):not(.timelineheading)');

								for (var j = 0; j < iternaryElements.length; j++) {
									html+='<tr style="border-bottom: none;"><td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;" border="0">';
									html+=iternaryElements[j].innerText;
									html+='</td></tr>';
								}

									html+='</tbody></table>';
				}
				document.getElementById("iternary_result").innerHTML=html;
				html="";
				var div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Inclusions'");?>`;
	 						inclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });


	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Exclusions'"); ?>`;
	 						exclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

						
	 						html+='<table class="small-text hlf-bordered-table" style="width:100%" width="100%"  border="1"> <thead><tr  style="background-color: #d9d9d9"><th align="left" style="font-size: 16px;padding:0px 5px;">Inclusions</th><th align="left" style="font-size: 16px;padding:0px 5px;">Exclusions</th></tr></thead><tbody>';



						let totalExclustion=inclusions.length>exclusions.length? inclusions.length : exclusions.length;
						let inclusionsResults=[];
						for (var i = 0; i < totalExclustion; i++) {
								
							if(inclusions[i] || exclusions[i] ){
								var inclusionsText= inclusions[i];
								var exclusionsText=exclusions[i];
								/*inclusionsResults.push([
									inclusionsText?'• '+inclusionsText.replace("\t", "") : '',
									exclusionsText?'• '+exclusionsText.replace("\t", "") : ''
								])*/
								html+='<tr ><td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;">';
									html+=inclusionsText?'• '+inclusionsText.replace("\t", "") : '';
									html+='</td>';
										html+='<td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;">';
									html+= exclusionsText?'• '+exclusionsText.replace("\t", "") : '';
									html+='</td></tr>';
							}
							
						}
						html+='</tbody></table>';

						document.getElementById("inclusions_result").innerHTML=html;


						html="";
						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Cancellation Charges'"); ?>`;
	 						var cancallations=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Refunds'"); ?>`;
	 						var refunds=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 					let totalCancallations=cancallations.length>refunds.length? cancallations.length : refunds.length;
						let cancallationResults=[];
						html+='<table class="small-text hlf-bordered-table" style="width:100%"  width="100%"  border="1"> <thead><tr  style="background-color: #d9d9d9"><th align="left" style="font-size: 16px;padding:0px 5px;">Cancellation Charges</th><th align="left" style="font-size: 16px;padding:0px 5px;">Refunds</th></tr></thead><tbody>';
						for (var i = 0; i < totalCancallations; i++) {
								
							if(cancallations[i] || refunds[i] ){
								var cancallationsText= cancallations[i];
								var refundsText=refunds[i];
								/*cancallationResults.push([
									cancallationsText?'• '+cancallationsText.replace("\t", "") : '',
									refundsText?'• '+refundsText.replace("\t", "") : ''
								])*/
								html+='<tr ><td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;"><p>';
									html+=cancallationsText?'• '+cancallationsText.replace("\t", "") : '';
									html+='</p></td>';
										html+='<td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;">';
									html+= refundsText?'• '+refundsText.replace("\t", "") : '';
									html+='</td></tr>';
							}
							
						}
							html+='</tbody></table>';
							document.getElementById("refund_result").innerHTML=html;

							html="";
						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Bank Account'"); ?>`;
	 						var bankAccounts=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - UPI'"); ?>`;
	 						var upis=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });

	 						let bankAccountsText= "";
							let upiText="";
							let bankResults=[];
						html+='<table class="small-text hlf-bordered-table"  style="width:100%"  width="100%"  border="1"> <thead><tr  style="background-color: #d9d9d9"><th align="left" style="font-size: 16px;padding:0px 5px;">Bank Account</th><th align="left" style="font-size: 16px;padding:0px 5px;">UPI (Google Pay/BHIM/UPI/PhonePe)</th></tr></thead><tbody>';
						let totalAccounts=bankAccounts.length>upis.length? bankAccounts.length : upis.length;
						//let bankResults=[];
						for (var i = 0; i < totalAccounts; i++) {
								
							if(bankAccounts[i] || upis[i] ){
								bankAccountsText= bankAccounts[i];
								 upiText=upis[i];
								/*bankResults.push([
									bankAccountsText?bankAccountsText.replace("\t", "") : '',
									upiText?'• '+upiText.replace("\t", "") : ''
								])*/

								html+='<tr ><td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;">';
									html+=bankAccountsText?bankAccountsText.replace("\t", "") : '';
									html+='</td>';
										html+='<td style="border-bottom: none;border-top: none;font-size: 16px;padding:0px 5px;">';
									html+= upiText?'• '+upiText.replace("\t", "") : '';
									html+='</td></tr>';
							}
							
						}
							html+='</tbody></table>';
							document.getElementById("bank_result").innerHTML=html;



       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
       var footer = "</body></html>";
       var sourceHTML = header+document.getElementById("source-html").innerHTML+footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = '<?php echo explode("|",$tpackage_name)[0].'_'.(isset(explode("|",$tpackage_name)[1])?explode("|",$tpackage_name)[1]:'');?>.doc';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }
    exportHTML();
</script>
		<?php		
		exit();
	}
	
	public function enquiry()
	{
		$status 	= "error";
		$message	= "";	

		$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
		if ($recaptchaResponse)  //Captcha Successfull
		{
			$this->form_validation->set_message('required', '{field} can not be empty.');
			$this->form_validation->set_message('min_length', '{field} must be at least {param} characters long.');
			$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
			$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');
			$this->form_validation->set_message('regex_match', '{field} must be a valid 10 digit number.');

			$this->form_validation->set_rules('noof_adult', 'No of adult', 'trim|required');
			$this->form_validation->set_rules('tsdate', 'Date of travel', 'trim|required');
			$this->form_validation->set_rules('accommodation', 'Accommodation type', 'trim|required');
			$this->form_validation->set_rules('first_name', 'First name', 'trim|required|max_length[40]');
			$this->form_validation->set_rules('emailid', 'Email', 'trim|required|valid_email|max_length[80]');
			$this->form_validation->set_rules('contact_no', 'Contact No', 'trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('message', 'Message', 'trim|max_length[800]');

			if ($this->form_validation->run() == FALSE) {
				$errorMsg	= "";
				if(!empty(form_error('noof_adult'))){
					$errorMsg	= form_error('noof_adult');
				} else if(!empty(form_error('tsdate'))){
					$errorMsg	= form_error('tsdate');
				} else if(!empty(form_error('accommodation'))){
					$errorMsg	= form_error('accommodation');
				} else if(!empty(form_error('first_name'))){
					$errorMsg	= form_error('first_name');
				} else if(!empty(form_error('emailid'))){
					$errorMsg	= form_error('emailid');
				} else if(!empty(form_error('contact_no'))){
					$errorMsg	= form_error('contact_no');
				} else if(!empty(form_error('message'))){
					$errorMsg	= form_error('message');
				} else {
					$errorMsg	= "Fill all mandatory fields with valid data.";
				}

				$status 	= "error";
				$message	= $errorMsg;
			} else {
				$first_name    	= $this->Common_model->htmlencode($this->input->post('first_name'));
				$last_name   	= $this->Common_model->htmlencode($this->input->post('last_name'));
				$emailid   		= $this->Common_model->htmlencode($this->input->post('emailid'));
				$contact_no 	= $this->Common_model->htmlencode($this->input->post('contact_no'));
				$message 		= $this->Common_model->htmlencode($this->input->post('message'));
				$noof_adult   	= (int) $this->input->post('noof_adult');
				$noof_child   	= (int) $this->input->post('noof_child');		
				$accommodation 	= $this->Common_model->htmlencode($this->input->post('accommodation'));
				$packageid 		= $this->Common_model->htmlencode($this->input->post('packageid'));
				$tsdate   		= $this->Common_model->htmlencode($this->input->post('tsdate'));
				$c_tsdate1 		= str_replace('/', '-', $tsdate);
				$c_tsdate 		= date('Y-m-d', strtotime($c_tsdate1));
				$date 			= date("Y-m-d H:i:s");
				
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
					$package_url = $this->Common_model->showname_fromid("tpackage_url","tbl_tourpackages","tourpackageid = $packageid");
					$full_package_url = base_url().'packages/'.$package_url;
					$site_url = base_url();
					
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
									<div><strong>TOUR PACKAGE : </strong><a href='$full_package_url'>$package_name</a></div>
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
							'Reply-To: '.$first_name.' <'.$emailid.">\r\n" .
							'X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
					mail($to_mail, $subject, $mailcontent, $headers);
					
					
					
					$customer_mailcontent = "<!doctype html>
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
								<div style='margin-top:30px;margin-bottom:20px;line-height:30px;font-size:14px'>
									Dear Sir/Madam,<br>
									Greetings from My Holiday Happiness (MHH).<br>
									Many thanks for contacting <a href='$site_url'><b>My Holiday Happiness</b></a><br>
									We are acknowledging that we have received you travel enquiry and one of you executive will assess the same and share the details for your requested travel plan within 6-8 hours.<br>
									For immediate assistance you can contact +91 9886525253 <br>
									Tour name - <a href='$full_package_url'><b>$package_name</b></a><br>
									Thank you for your time with us.
								</div>
													
							</div>				
							
							<div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
								<div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
									&copy; ".date("Y")." All right reserved. myholidayhappiness.com
								</div>
							</div>
						</body>
					</html>";
					
					$customer_subject = "Travel enquiry with My Holiday Happiness";
					$customer_tomail = $emailid;

					// $this->email->from($from_mail, "myholidayhappiness.com");
					// $this->email->to($customer_tomail);
					// $this->email->reply_to($from_mail, "myholidayhappiness.com");
					// $this->email->subject($customer_subject);
					// $this->email->message($customer_mailcontent);
					// @$this->email->send(); 
					
						$headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
							'Reply-To: myholidayhappiness.com <'.$from_mail.">\r\n" .
							'X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
					mail($customer_tomail, $customer_subject, $customer_mailcontent, $headers);
					
					//echo $mailcontent ; exit;
					/** End - Send Mail **/				
					$status 	= "success";
					$message	= "Your enquiry has been submitted successfully. We will contact you soon.";
				} else {
					$status 	= "error";
					$message	= "Your enquiry could not submitted. Please try again.";
				}   
			}
		} else {
			$status 	= "error";
			$message	= "reCAPTCHA verification failed. Please try again.";
		}
		echo json_encode(array('status' => $status, 'message' => $message));
		exit();
	}
	
	public function booking()
	{
		if (isset($_POST['btnPayment']) && !empty($_POST))
		{
			$package_id = $this->Common_model->htmlencode($_REQUEST["package_id"]);
			$package_url = $this->Common_model->showname_fromid("tpackage_url","tbl_tourpackages","tourpackageid=$package_id");
			if($this->session->userdata('customer_id') != "")
			{
				$customer_id = $this->session->userdata('customer_id');
				
				$traveller_name = $this->Common_model->htmlencode($_REQUEST["traveller_name"]);
				$traveller_email = $this->Common_model->htmlencode($_REQUEST["traveller_email"]);
				$traveller_phone = $this->Common_model->htmlencode($_REQUEST["traveller_phone"]);
				$payment_percentage = $this->Common_model->htmlencode($_REQUEST["pay_radio"]);
				
				if( ($traveller_name != '') && ($traveller_email != '') && ($traveller_phone != '') && ($payment_percentage != ''))
				{	
					$traveller_altphone = $this->Common_model->htmlencode($_REQUEST["traveller_altphone"]);
					$traveller_msg = $this->Common_model->htmlencode($_REQUEST["traveller_msg"]);
					$location_address = $this->Common_model->htmlencode($_REQUEST["location_address"]);
					$location_city = $this->Common_model->htmlencode($_REQUEST["location_city"]);
					$location_state = $this->Common_model->htmlencode($_REQUEST["location_state"]);
					$location_pincode = $this->Common_model->htmlencode($_REQUEST["location_pincode"]);
					$location_landmark = $this->Common_model->htmlencode($_REQUEST["location_landmark"]);
					
					$package_duration = $this->Common_model->htmlencode($_REQUEST["package_duration"]);
					$package_noofdays = $this->Common_model->htmlencode($_REQUEST["package_noofdays"]);
					$starting_city = $this->Common_model->htmlencode($_REQUEST["starting_city"]);
					$noof_adults = $this->Common_model->htmlencode($_REQUEST["noof_adults"]);
					$noof_childs = $this->Common_model->htmlencode($_REQUEST["noof_childs"]);
					$vehicle_id = $this->Common_model->htmlencode($_REQUEST["vehicle_id"]);
					$date_of_travel = $this->Common_model->htmlencode($_REQUEST["date_of_travel"]);
					$accomodation_type = $this->Common_model->htmlencode($_REQUEST["accomodation_type"]);
					$accomodation_hotels = $this->Common_model->htmlencode($_REQUEST["accomodation_hotels"]);
					$airport_pickup = $this->Common_model->htmlencode($_REQUEST["airport_pickup"]);
					$airport_drop = $this->Common_model->htmlencode($_REQUEST["airport_drop"]);
					$noof_coupleroom = $this->Common_model->htmlencode($_REQUEST["noof_coupleroom"]);
					$noof_extrabed = $this->Common_model->htmlencode($_REQUEST["noof_extrabed"]);
					$noof_kidsroom = $this->Common_model->htmlencode($_REQUEST["noof_kidsroom"]);
					$noof_nights = $this->Common_model->htmlencode($_REQUEST["noof_nights"]);
					$coupleroom_price = $this->Common_model->htmlencode($_REQUEST["coupleroom_price"]);
					$extrabed_price = $this->Common_model->htmlencode($_REQUEST["extrabed_price"]);
					$kidsroom_price = $this->Common_model->htmlencode($_REQUEST["kidsroom_price"]);
					$total_hotel_price = $this->Common_model->htmlencode($_REQUEST["total_hotel_price"]);
					$vehicle_perday_price = $this->Common_model->htmlencode($_REQUEST["vehicle_perday_price"]);
					$total_vehicle_price = $this->Common_model->htmlencode($_REQUEST["total_vehicle_price"]);
					$pickup_price = $this->Common_model->htmlencode($_REQUEST["pickup_price"]);
					$drop_price = $this->Common_model->htmlencode($_REQUEST["drop_price"]);
					$sub_total_price = $this->Common_model->htmlencode($_REQUEST["sub_total_price"]);
					$percentage_margin = $this->Common_model->htmlencode($_REQUEST["percentage_margin"]);
					$percentage_price = $this->Common_model->htmlencode($_REQUEST["percentage_price"]);
					$total_price = $this->Common_model->htmlencode($_REQUEST["total_price"]);
					
					$paid_amount = $total_price*($payment_percentage/100);
					
					$booking_date = date("Y-m-d H:i:s");
					
					$insert_data = array(
						'customer_id'		=> $customer_id ,
						'package_id'	    => $package_id,
						'package_duration'	=> $package_duration,
						'package_noofdays'	=> $package_noofdays,
						'starting_city'	   	=> $starting_city,
						'noof_adults'		=> $noof_adults,
						'noof_childs'		=> $noof_childs,
						'vehicle_id'		=> $vehicle_id,
						'date_of_travel'	=> $date_of_travel,
						'accomodation_type'	=> $accomodation_type,
						'accomodation_hotels' => $accomodation_hotels ,
						'airport_pickup'	=> $airport_pickup,
						'airport_drop'		=> $airport_drop,
						'traveller_name'	=> $traveller_name,
						'traveller_email'	=> $traveller_email,
						'traveller_phone'	=> $traveller_phone,
						'traveller_altphone'=> $traveller_altphone,
						'traveller_msg'		=> $traveller_msg,
						'location_address'	=> $location_address,
						'location_city'	    => $location_city,
						'location_state'	=> $location_state ,
						'location_pincode'	=> $location_pincode,
						'location_landmark'	=> $location_landmark,
						'noof_coupleroom'	=> $noof_coupleroom,
						'noof_extrabed'	   	=> $noof_extrabed,
						'noof_kidsroom'		=> $noof_kidsroom,
						'noof_nights'		=> $noof_nights,
						'coupleroom_price'	=> $coupleroom_price,
						'extrabed_price'	=> $extrabed_price,
						'kidsroom_price'	=> $kidsroom_price,
						'total_hotel_price'	=> $total_hotel_price ,
						'vehicle_perday_price'	=> $vehicle_perday_price,
						'total_vehicle_price'	=> $total_vehicle_price,
						'pickup_price'		=> $pickup_price,
						'drop_price'	   	=> $drop_price,
						'sub_total_price'	=> $sub_total_price,
						'percentage_margin'	=> $percentage_margin,
						'percentage_price'	=> $percentage_price,
						'total_price'	    => $total_price,
						'payment_percentage'=> $payment_percentage,
						'paid_amount'		=> $paid_amount,
						'payment_status'	=> 0,
						'booking_status'	=> 0,
						'booking_date'	    => $booking_date
					);
					$insertdb = $this->Common_model->insert_records('tbl_bookings', $insert_data);
				
					if($insertdb) 
					{
						$insertid = $this->db->insert_id();
						//Update invoice Number
						$orderno_id = str_pad($insertid, 5, '0', STR_PAD_LEFT);
						$order_prefix = $this->Common_model->show_parameter(28);
						$order_no = $order_prefix.$orderno_id;
						$updatedata = array('invoice_no' => $order_no);
						$updatequery = $this->Common_model->update_records("tbl_bookings",$updatedata,"booking_id=$insertid");
						$booking_encid = $this->Common_model->encode($insertid);						
						//redirect(base_url()."invoice/".$order_no."/".$booking_encid,'refresh');

						//Start Payment transaction by paytm gateway
						$checkSum = "";
						$paramList = array();

						$ORDER_ID = $order_no;
						$CUST_ID = $customer_id;
						$INDUSTRY_TYPE_ID = "Retail";
						$CHANNEL_ID = "WEB";
						$TXN_AMOUNT = $paid_amount;
						$CALLBACK_URL = base_url()."invoice/".$order_no."/".$booking_encid;

						// Create an array having all required parameters for creating checksum.
						$paramList["MID"] = PAYTM_MERCHANT_MID;
						$paramList["ORDER_ID"] = $ORDER_ID;
						$paramList["CUST_ID"] = $CUST_ID;
						$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
						$paramList["CHANNEL_ID"] = $CHANNEL_ID;
						$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
						$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
						$paramList["CALLBACK_URL"] = $CALLBACK_URL;
						
						//Here checksum string will return by getChecksumFromArray() function.
						$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY)
						?>
						<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="form_paytm">
							<table border="1">
								<tbody>
								<?php
								foreach($paramList as $name => $value) {
									echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
								}
								?>
								<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
								</tbody>
							</table>
							<script type="text/javascript">
								document.form_paytm.submit();
							</script>
						</form>
						<?php

					}
					else
					{			
						redirect(base_url().'packages/'.$package_url."?error=1",'refresh'); // if not inserted to table			
					}	
				}
				else
				{			
					redirect(base_url().'packages/'.$package_url."?error=2",'refresh'); // if not filled up madatory fields			
				}				
			}	
			else
			{			
				redirect(base_url().'packages/'.$package_url."?error=3",'refresh'); //	if not loggedin
			}
		}
		else
		{			
			redirect(base_url(),'refresh');			
		}
	}
}

