<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tours extends CI_Controller {

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
		$cat_slug = $this->uri->segment(2);
		$tagurl = $this->uri->segment(3);
		
		if(!empty($tagurl))
		{
			// fetch all categories to match it with the url segment
			$data_cat = $this->Common_model->get_records("*","tbl_menucateories","menuid=3 and status='1'","");
			$cat_arr = []; $final_catid = 0;
			if(!empty($data_cat)){
				foreach($data_cat as $row) {
					$catid = $row['catid'];
					$cat_name = $row['cat_name'];
					$seocat_name = $this->Common_model->makeSeoUrl($cat_name);
					$cat_arr[] = $seocat_name;
					if($seocat_name == $cat_slug) {
						$final_catid = $catid;
					}
				}
			}
		
			if( !in_array($cat_slug, $cat_arr) ) {
				redirect(base_url(),'refresh');
			}

			$tagurl = $this->db->escape($tagurl);
			$validtag = $this->Common_model->noof_records("tagid","tbl_menutags","tag_url=$tagurl and cat_id=$final_catid and menuid=3 and status='1'");
			if($validtag>0)
			{
				$data['tag_data']=$this->Common_model->get_records("*","tbl_menutags","tag_url=$tagurl and cat_id=$final_catid and menuid=3 and status='1'","");
				
				$this->load->view('tours', $data);
			}
			else
				redirect(base_url(),'refresh');
				
		}   else if(!empty($cat_slug))
		{
			// fetch all categories to match it with the url segment
			$data_cat = $this->Common_model->get_records("*","tbl_menucateories","menuid=3 and status='1'","");
			$cat_arr = []; $final_catid = 0;
			if(!empty($data_cat)){
				foreach($data_cat as $row) {
					$catid = $row['catid'];
					$cat_name = $row['cat_name'];
					$seocat_name = $this->Common_model->makeSeoUrl($cat_name);
					$cat_arr[] = $seocat_name;
					if($seocat_name == $cat_slug) {
						$final_catid = $catid;
					}
				}
			}
		
			if( !in_array($cat_slug, $cat_arr) ) {
				redirect(base_url(),'refresh');
			}

			$tagurl = $this->db->escape($tagurl);
			$validtag = $this->Common_model->noof_records("tagid","tbl_menutags"," cat_id=$final_catid and menuid=3 and status='1'");
			if($validtag>0)
			{
				//$data['tag_data']=$this->Common_model->get_records("*","tbl_menutags"," cat_id=$final_catid and menuid=3 and status='1'","");
				 $data['tag_data'] = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b", "a.cat_id=b.catid", "a.menuid=3 and a.cat_id=$final_catid and a.status=1 ", "tag_name asc");
                  $data['cat_slug'] =$cat_slug;  
				
				$this->load->view('menu_packages', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
		else{
		   

			$tagurl = $this->db->escape($tagurl);
			$validtag = $this->Common_model->noof_records("tagid","tbl_menutags"," menuid=3 and status='1'");
			if($validtag>0)
			{
				//$data['tag_data']=$this->Common_model->get_records("*","tbl_menutags"," cat_id=$final_catid and menuid=3 and status='1'","");
				 $data['tag_data'] = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b", "a.cat_id=b.catid", "a.menuid=3 and a.status=1 ", "tag_name asc");
                  $data['cat_slug'] =$cat_slug;  
				
				$this->load->view('menu_packages', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
	}
	
	public function search()
	{
		$starting_city = $_REQUEST["starting_city"];
		$trip_duration = $_REQUEST["trip_duration"];
		$tour_tagid = $_REQUEST["tagid"];
		?>
		<div id="loader"></div>		
		<?php
		
		$condition = "";
		
		if($starting_city != "")
			$condition .= " and b.starting_city=$starting_city";
		
		if($trip_duration != "")
			$condition .= " and b.package_duration=$trip_duration";
		
		$tour_packages = $this->Common_model->join_records("a.*, b.*","tbl_tags as a","tbl_tourpackages as b", "a.type_id=b.tourpackageid", "a.tagid=$tour_tagid and a.type=3 and b.status=1 $condition","b.tpackage_name asc");
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
			<div class="col-xl-3 col-lg-4 col-md-6 touristlist-box">
				<div class="touristdetails-imgholder">
					<?php if (!empty($pack_type)) { 
						$class = 	($pack_type == '15') ? 'corner corner2 featuredribbon featuredribbon2' : 'corner featuredribbon' ; 
						?> 
						<div class="<?php echo $class ; ?>">
							<span><?php echo $this->Common_model->showname_fromid("par_value","tbl_parameters","parid ='$pack_type' and param_type = 'PT' "); ?></span>
						</div>
						
					 <?php } ?>
					
					<a href="<?php echo base_url().'packages/'.$tpackage_url; ?>" target="_blank"><img src="<?php echo base_url().'uploads/'.$tour_thumb; ?>" class="img-fluid" alt="<?php echo (!empty($alttag_thumb)) ? $alttag_thumb : "My Holiday Happiness"; ?>"></a>
					<?php if($starting_city_name != ""): ?><div class="explore">Ex-<?php echo $starting_city_name; ?></div><?php endif; ?>
					<div class="tourist-duration"><?php echo $show_duration; ?></div>				 
				</div>
				<div class="tourist-bottom-details">
					<ul class="iconlist">
						<?php if($accomodation == 1): ?><li><img src="<?php echo base_url(); ?>assets/images/bed.png" title="Accomodation" alt="Accomodation"></li><?php endif; ?>
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
		<?php		
			}
		}
		else{
			?>
			<div class="col-md-12 text-center">
				<h1>No Packages Found !</h1>
			</div>
			<?php
			
		}
		exit();
	}
	
	
	
}


?>