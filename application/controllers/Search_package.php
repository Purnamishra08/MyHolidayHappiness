<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_package extends CI_Controller {

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
		$condition = "";
		if((isset($_REQUEST["destination"])) && ($_REQUEST["destination"] != ""))
		{
			$destination = $this->Common_model->decode($_REQUEST["destination"]);			
			$destinationid = $this->db->escape($destination);
			$condition .= " and itinerary in (SELECT DISTINCT(itinerary_id) FROM tbl_itinerary_destination WHERE destination_id = $destinationid)";
		}
		
		if((isset($_REQUEST["duration"])) && ($_REQUEST["duration"] != ""))
		{
			$duration = $this->Common_model->decode($_REQUEST["duration"]);			
			$durationid = $this->db->escape($duration);
			$condition .= " and package_duration=$durationid";
		}
		
		$data['tour_packages']=$this->Common_model->get_records("*", "tbl_tourpackages", "status=1 $condition","tpackage_name asc");
		$data['noof_tour_packages'] = $this->Common_model->noof_records("tourpackageid","tbl_tourpackages","status=1 $condition");
		
		$this->load->view('search_package', $data);
	}
}

