<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
        $this->load->library('pagination');
		 $this->load->model('Common_model');
	}
	
	public function index()
	{
		$destiurl = $this->uri->segment(3);
		$stateurl = $this->uri->segment(2);
		if(!empty($destiurl)) {	
			$stateurl = $this->db->escape($stateurl);
			
			$validstate = $this->Common_model->showname_fromid("state_id","tbl_state","state_url=$stateurl");
			
			if($validstate){
    			$destiurl = $this->db->escape($destiurl);
    			if(isset($_REQUEST['preview'])) {				
    				$de_admin = $this->Common_model->decode($_REQUEST['preview']);
    				if($de_admin=="admin") {
    					$validdesti = $this->Common_model->noof_records("destination_id","tbl_destination","state=$validstate and destination_url=$destiurl");
    					$data['destinm']=$this->Common_model->get_records("*","tbl_destination","state=$validstate and destination_url=$destiurl");
    				} else {
    					redirect(base_url(),'refresh');
    				}
    			} else {
    				$validdesti = $this->Common_model->noof_records("destination_id","tbl_destination","status='1' and state=$validstate and destination_url=$destiurl");
    				$data['destinm']=$this->Common_model->get_records("*","tbl_destination","status='1' and state=$validstate and destination_url=$destiurl");
    			}
			} else {
				redirect(base_url(),'refresh');
			}
			
			if($validdesti > 0) {
				$this->load->view('destination', $data);
			} else { 
				redirect(base_url(),'refresh');
			}
		}else if(!empty($stateurl)) {	
			
			$validstate = $this->Common_model->showname_fromid("state_id","tbl_state","state_url='$stateurl'");
				$validStateName = $this->Common_model->showname_fromid("state_name","tbl_state","state_url='$stateurl'");
			
			if($validstate){
    			if(isset($_REQUEST['preview'])) {				
    				$de_admin = $this->Common_model->decode($_REQUEST['preview']);
    				if($de_admin=="admin") {
    					$validdesti = $this->Common_model->noof_records("destination_id","tbl_destination","state=$validstate");
    					$data['allDestins']=$this->Common_model->get_records("*","tbl_destination","state=$validstate ", "destination_id DESC");
    				} else {
    					redirect(base_url(),'refresh');
    				}
    			} else {
    				$validdesti = $this->Common_model->noof_records("destination_id","tbl_destination","status='1' and state=$validstate ");
    				$data['allDestins']=$this->Common_model->get_records("*","tbl_destination","status='1' and state=$validstate ", "destination_id DESC");
    			}
			} else {
				redirect(base_url(),'refresh');
			}
			
			if($validdesti > 0) {
			    	$data['stateName']=$validStateName;
				$this->load->view('menu_destination', $data);
			} else { 
				redirect(base_url(),'refresh');
			}
		} else {
		    
            
		    $validdesti = $this->Common_model->noof_records("destination_id","tbl_destination","status='1' ");
		    	if($validdesti > 0) {
		    	    $data['stateName']='';
		    $config['base_url'] = base_url() . 'destinations/page/';
            $config['first_url'] = base_url() . 'destinations';
            $config["uri_segment"] = 3;
            $config['total_rows'] = $validdesti;
            $config['per_page'] = 20;
            $config["num_links"] = $this->Common_model->num_links;
            $config["use_page_numbers"] = TRUE;
            //config for bootstrap pagination class integration
            $config['full_tag_open'] = '<ul class="pagination pull-right">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = "&laquo First";
            $config['last_link'] = "Last &raquo";
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $per_page = $config["per_page"];
            $startm = $page;
            if ($page > 1)
                $startm = $page - 1;
            $startfrom = $per_page * $startm;
            $data['startfrom'] = $startfrom;
            $data['pagination'] = $this->pagination->create_links();
    				$data['allDestins']=$this->Common_model->get_records("*","tbl_destination","status='1' ", "destination_id DESC", "$per_page", "$startfrom");
    				  $this->load->view('menu_destination', $data);
		    	}else{
		    	    redirect(base_url(),'refresh');
		    	}
		  
			//
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
		
		$tour_packages = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status= 1 $condition","");
		if(!empty($tour_packages))
		{
			foreach ($tour_packages as $tour_package) {
				$tourpackageid = $tour_package["tourpackageid"];
				$tpackage_name = $tour_package["tpackage_name"];
				$tpackage_url = $tour_package["tpackage_url"];

				$package_duration = $tour_package["package_duration"];
				$show_duration = $this->Common_model->showname_fromid("duration_name", "tbl_package_duration", "durationid ='$package_duration'");

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

				if ($noof_assoc_dest > 0) {
					$assoc_dests_arr = array();
					$assoc_dests = $this->Common_model->join_records("a.itinerary_destinationid, b.destination_name","tbl_itinerary_destination as a","tbl_destination as b", "a.destination_id=b.destination_id", "a.itinerary_id=$itinerary","a.itinerary_destinationid asc");

					foreach ($assoc_dests as $assoc_dest) {
						$assoc_dests_arr[] = $assoc_dest['destination_name'];
					}
					$show_assoc_dests = implode(" - ", $assoc_dests_arr);
				}
				?>
			<div class="col-lg-3 col-md-6  touristlist-box">
				<div class="touristdetails-imgholder">
					<?php
					if (!empty($pack_type)) {
						$class = ($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon';
						?> 
						<div class="<?php echo $class; ?>">
							<span><?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parid ='$pack_type' and param_type = 'PT' "); ?></span>
						</div>								
					<?php } ?>

					<a href="<?php echo base_url() . 'packages/' . $tpackage_url; ?>" target="_blank"><img src="<?php echo base_url() . 'uploads/' . $tour_thumb; ?>" class="img-fluid" alt="My Holiday Happiness"></a>
					<?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
					<div class="tourist-duration"> <?php echo $show_duration; ?> </div>
				</div>
				<div class="tourist-bottom-details">
					<ul class="iconlist">									
						<?php if ($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation"></li><?php endif; ?>
						<?php if ($tourtransport == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/car.png" title="Transportation" alt="Transportation"></li><?php endif; ?>
						<?php if ($sightseeing == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/binoculars.png" title="Sightseeing" alt="Sightseeing"></li><?php endif; ?>	
						<?php if ($breakfast == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/cutlery.png" title="Breakfast" alt="Breakfast"></li><?php endif; ?>
						<?php if ($waterbottle == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/waterbtl.png" title="Water Bottle" alt="Water Bottle"></li><?php endif; ?>
					</ul>
					<div class="touristlist-hdng "><?php echo $tpackage_name; ?> </div>
					<div class="tourbutton "> <span><a href="<?php echo base_url() . 'packages/' . $tpackage_url; ?>" class="viwebtn" target="_blank">View details</a></span></div>
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

