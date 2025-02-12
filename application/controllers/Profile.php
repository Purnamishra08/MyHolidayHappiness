<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');	
        $this->load->database();
        $this->load->model('Common_model');
		
		if($this->session->userdata('customer_id') == "")
		{
			redirect(base_url().'logout','refresh');
		}
    }

    public function index() {
		$data['message'] = $this->session->flashdata('message');
		$data['m_message'] = $this->session->flashdata('m_message');	
		$customer_id = $this->session->userdata('customer_id');
		
		if (isset($_POST['updateProfile']) && !empty($_POST))
		{
			$this->form_validation->set_rules('fullname','Full Name','trim|required');
			$this->form_validation->set_rules('contact','Phone','trim|required');	
			
			if ($this->form_validation->run() == true)
			{
				$date = date("Y-m-d H:i:s");				
				$fullname = $this->input->post('fullname');
				$contact = $this->input->post('contact');	
				
                $query_data = array(
					'fullname'		=> $fullname,
					'contact'       => $contact,
					'updated_date'	=> $date
				);
				
				$querydb = $this->Common_model->update_records('tbl_customers', $query_data, "customer_id='$customer_id'");
				if($querydb)
				{
					$data['message'] = '<div class="successmsg notification"><i class="fa fa-check"></i> Profile updated successfully.</div>';
				}
				else
				{
					$data['message'] = '<div class="errormsg notification"><i class="fa fa-times"></i> Profile could not updated. Please try again.</div>';
				}
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
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
				$date = date("Y-m-d H:i:s");	
                
				$update_data = array(
                    'password'		=> $inspwdfrdb,
					'updated_date'	=> $date
				);
				$updatedb = $this->Common_model->update_records('tbl_customers',$update_data,"customer_id='$customer_id'");
				if($updatedb)
				{
					$data['m_message'] = '<div class="successmsg notification"><i class="fa fa-check"></i> Password changed successfully.</div>';
				}
				else
				{
					$data['m_message'] = '<div class="errormsg notification"><i class="fa fa-times"></i> Password could not changed. Please try again.</div>';
				}
			}
			else
			{
				//set the flash data error message if there is one
				$data['m_message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('m_message'));
			}
		}		
		
		$data['customers'] = $this->Common_model->get_records("*","tbl_customers","customer_id='$customer_id'");		
        $this->load->view('profile', $data);
    }
	

}
