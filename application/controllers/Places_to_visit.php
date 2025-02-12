<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Places_to_visit extends CI_Controller {

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
		$destiurl = $this->uri->segment(3);
		$stateurl = $this->uri->segment(2);
		if(!empty($destiurl)){	
			$stateurl = $this->db->escape($stateurl);
			
			$validstate = $this->Common_model->showname_fromid("state_id","tbl_state","state_url=$stateurl");
			
			if($validstate){
    			$destiurl = $this->db->escape($destiurl);
    			$validdesti = $this->Common_model->noof_records("destination_url","tbl_destination","state=$validstate and destination_url=$destiurl and status='1'");
    			if($validdesti>0){
    				$data['destinm']=$this->Common_model->get_records("*","tbl_destination","state=$validstate and destination_url=$destiurl and status='1'","");
    				
    				$this->load->view('places_to_visit', $data);
    			}else{
    				redirect(base_url(),'refresh');
    			}
			} else {
				redirect(base_url(),'refresh');
			}
		}else{
			redirect(base_url(),'refresh');
		}
	}
	
	public function placesearch()
	{
		$place_type = $_REQUEST["place_type"];
		$destination_id = $_REQUEST["destination_id"];
		
		$destinm=$this->Common_model->get_records("destination_url, state","tbl_destination","destination_id=$destination_id");
		foreach ($destinm as $desti)
		{
			$destination_url = $desti['destination_url'];
			$state_id = $desti['state'];
		
			$state_data=$this->Common_model->get_records("state_name, state_url","tbl_state","state_id='$state_id'");
			foreach($state_data as $state)
			{
				$statenm= $state['state_name']; 
				$stateurl = $state['state_url'];
			}
		}
		
		$condition = "";
		
		if($place_type != "")
			$condition .= " and placeid in ( select loc_id from tbl_multdest_type where loc_type=2 and loc_type_id='$place_type')";
		
		?>
		<div id="place_loader"></div>
		<?php
			$count = 1;
			$dest_places = $this->Common_model->get_records("*", "tbl_places", "destination_id=$destination_id and status=1 $condition","place_name asc");
			if(!empty($dest_places))
			{
				foreach ($dest_places as $destplace)
				{
					$dest_placeid = $destplace['placeid'];
					$dest_place_url = $destplace['place_url'];
					$dest_about_place = $destplace['about_place'];
					
					$place_types = array();
					$show_place_types = "";
					$noof_place_types =  $this->Common_model->noof_records("multdest_id","tbl_multdest_type","loc_id=$dest_placeid and loc_type=2"); 
					if($noof_place_types > 0)
					{										
						$place_type_datas = $this->Common_model->join_records("a.multdest_id, a.loc_id, a.loc_type_id, b.destination_type_name","tbl_multdest_type as a","tbl_destination_type as b", "a.loc_type_id=b.destination_type_id", "a.loc_id=$dest_placeid and a.loc_type=2 and b.status=1","b.destination_type_name asc");
						//$this->db->last_query();
						foreach ($place_type_datas as $placetype)
						{
							$place_types[] = $placetype['destination_type_name'];
						}										
					}
					
					if(count($place_types) > 0)
					{
						$show_place_types = implode(" | ", $place_types);
					}
		?>
		<div class="col-lg-6">
			<div class="placebox">                                 
				<div class="placeimg-holder">
					<a href="<?php echo base_url().'place/'.$stateurl.'/'.$destination_url.'/'.$dest_place_url; ?>"><img src="<?php echo base_url()."uploads/".$destplace['placethumbimg']; ?>" class="img-fluid" alt="My Holiday Happiness"/></a>
					<?php if($show_place_types !="") { ?><span class="placetaglist"><?php echo $show_place_types; ?></span><?php } ?>
				</div>
				<div class="mt-2 placeheading"><?php echo $destplace['place_name']; ?></div>
				<p><?php echo $this->Common_model->short_str("$dest_about_place", "85"); ?></p>
				<a href="<?php echo base_url().'place/'.$stateurl.'/'.$destination_url.'/'.$dest_place_url; ?>" class="viwebtn">View details</a>
			</div>
		</div>														
		<?php if ($count % 2 == 0): ?><div class="clearfix"></div><?php endif; ?>							
		<?php $count++; } } else { ?>
		<div class="col-lg-12 text-center">
			<h1>No Related Places Found!</h1>
		</div>
		<?php
		}
	}
	
	public function search()
	{
		$starting_city = $_REQUEST["starting_city"];
		$trip_duration = $_REQUEST["trip_duration"];
		$destination_id = $_REQUEST["destination_id"];
		?>
		<div id="loader"></div>		
		<?php
		$condition = "";
		
		if($starting_city != "")
			$condition .= " and starting_city=$starting_city";
		
		if($trip_duration != "")
			$condition .= " and package_duration=$trip_duration";
		
		$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and `status` = 1 $condition","");
		
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
						
						<a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="My Holiday Happiness"></a>							
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
						<div class="touristlist-hdng "><?php echo $tpackage_name; ?> </div>
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
}

