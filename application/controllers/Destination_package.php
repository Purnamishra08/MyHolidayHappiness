<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination_package extends CI_Controller {

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
		$desturl = $this->uri->segment(2);
		if(!empty($desturl))
		{	
			$desturl = $this->db->escape($desturl);
			$validdest = $this->Common_model->noof_records("destination_id","tbl_destination","destination_url=$desturl and status='1'");
			if($validdest > 0)
			{
				$destination_id = $this->Common_model->showname_fromid("destination_id", "tbl_destination", "destination_url=$desturl and status='1'");	
				$data['destination_id'] = $destination_id ;
				 
				$data['tour_packages'] = $this->Common_model->get_records("*", "tbl_tourpackages", "itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destination_id) and status = 1","tourpackageid desc");	
				 
				$this->load->view('destination_package', $data);
			}
			else
				redirect(base_url().'destination-package/'.$desturl,'refresh');
		}
		else
			redirect(base_url(),'refresh');
	}
}

