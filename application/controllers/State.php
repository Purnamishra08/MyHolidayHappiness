<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {

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
 		$stateurl = $this->uri->segment(2);
		if(!empty($stateurl))
		{	
			$stateurl = $this->db->escape($stateurl);
			$validstate = $this->Common_model->noof_records("state_id","tbl_state","state_url=$stateurl and status='1'");
			
			if($validstate>0)
			{
				$data['statedata'] = $this->Common_model->get_records("*","tbl_state","state_url=$stateurl and status='1'","");
				
				$this->load->view('state', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
		else
			redirect(base_url(),'refresh');
	}
}


