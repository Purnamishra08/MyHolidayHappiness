<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Place_package extends CI_Controller {

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
		$placeurl = $this->uri->segment(2);
		if(!empty($placeurl))
		{	
			$placeurl = $this->db->escape($placeurl);
			$validplaceurl = $this->Common_model->noof_records("placeid","tbl_places","place_url=$placeurl and status='1'");
			if($validplaceurl > 0)
			{
				$place_id = $this->Common_model->showname_fromid("placeid", "tbl_places", "place_url = $placeurl and status='1'");	
				$data['placeid'] = $place_id ;
				
				$data['place_tour_packages'] = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_daywise WHERE place_id ='$place_id' or place_id like '$place_id,%' or place_id like '%,$place_id' or place_id like '%,$place_id,%') and status = 1","tourpackageid desc");	
				 
				 $this->load->view('place_package', $data);
			}
			else
				redirect(base_url().'place-package/'.$placeurl,'refresh');
		}
		else
			redirect(base_url(),'refresh');
	}
}

