<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

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
		$data['row'] = $this->Common_model->get_records("*","tbl_faqs","status = 1","faq_order ASC","" ,"");
		$this->load->view('faq',$data);
	}
}
