<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
 	{
		parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
        $this->load->database();
        $this->load->library('pagination');
        $this->load->model('Common_model');
        if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}
 	}

	public function index()
	{
		
        $this->load->view('admin/dashboard');
	}
}
