<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends CI_Controller {
	
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
		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}
 	}
	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$sess_userid = $this->session->userdata('userid');
		$date = date("Y-m-d H:i:s");
		
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{
			$this->form_validation->set_rules('new_pwd', 'New Password', 'required|min_length[6]|max_length[12]|matches[cnf_pwd]');
			$this->form_validation->set_rules('cnf_pwd', 'Confirm Password', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$new_pwd = $this->input->post('new_pwd');
                
                $costvalue = $this->Common_model->costvalue;
                $options = ['cost' => $costvalue,];
                $inspwdfrdb=password_hash("$new_pwd", PASSWORD_BCRYPT, $options);
				
				$update_data = array(
					//'password' 	=>	sha1($new_pwd)
                    'password' 	=> $inspwdfrdb
				);
				
				$updatedb = $this->Common_model->update_records('tbl_admin',$update_data,"adminid='$sess_userid'");
				if($updatedb)
				{
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Password changed successfully.</div>');
				}
				else
				{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Password could not changed. Please try again.</div>');
				}
				redirect(base_url().'admin/change_password','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}	
		}
		
		$this->load->view('admin/change_password',$data);
	}
}
