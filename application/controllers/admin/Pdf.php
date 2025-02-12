<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

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
		$this->load->library('pagination');
		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}		
		
 	}
     public function pdf_generator(){
        $data['message'] = $this->session->flashdata('message');
        $data['row'] = $this->Common_model->get_records("*", "tbl_tourpackages", "", "tourpackageid DESC", "", "");
		$this->load->view('admin/pdf_generator',$data);
    }
}



