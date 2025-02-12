<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_enquiry extends CI_Controller {
	
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
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(16, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}
 	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['row'] = $this->Common_model->get_records("*","tbl_contact","","enq_id desc","","");
		$this->load->view('admin/contact_enquiry', $data);
	}


	public function delete_contact()	
	{		
        $delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("enq_id","tbl_contact","enq_id='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_contact","enq_id=$delid");
			if($del){

				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i>Contact has been deleted successfully.</div>');				
			}
			else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>Contact could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/contact_enquiry','refresh');		
	}

	public function view()
	{
		$data['message'] = $this->session->flashdata('message');
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("enq_id","tbl_contact","enq_id='$viewid'");
		if($noof_rec>0)
		{
			$data['contact'] = $this->Common_model->get_records("*","tbl_contact","enq_id=$viewid","");
			$this->load->view('admin/view_contact_enquiry',$data);
		}
	}

	
}