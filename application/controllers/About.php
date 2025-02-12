<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

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
		$this->load->view('about');
	}
	
	public function getstateurl()
	{
		$destinationurl = $_REQUEST["destinationurl"];
		
		$stateid = $this->Common_model->showname_fromid("state","tbl_destination","destination_url='$destinationurl' and status='1'");
		$state_url = $this->Common_model->showname_fromid("state_url","tbl_state","state_id ='$stateid'");
		
		echo $state_url;
		exit;
		
	}
}
