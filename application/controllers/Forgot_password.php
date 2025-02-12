<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	
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
		$this->load->library('cart');
 	}
	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$linkid = $this->input->get('id');
		
		$data['validmsg'] = ''; $data['diffrnc'] = ''; $data['numuserforgot'] = 0; $data['getuserid'] = '';
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{
			$this->form_validation->set_rules('new_pwd', 'New Password', 'required|min_length[6]|max_length[12]|matches[cnf_pwd]');
			$this->form_validation->set_rules('cnf_pwd', 'Confirm Password', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$new_pwd = $this->input->post('new_pwd');
				$hiduserid = $this->input->post('hiduserid');
                
                $costvalue = $this->Common_model->costvalue;
                $options = ['cost' => $costvalue,];
                $inspwdfrdb=password_hash("$new_pwd", PASSWORD_BCRYPT, $options);
                
				$update_data = array(
					//'password'		=> sha1($new_pwd),
                    'password'		=> $inspwdfrdb,
					'temp_password'	=> NULL,
					'pwd_created'	=> NULL
				);
				$updatedb = $this->Common_model->update_records('tbl_customers',$update_data,"customer_id='$hiduserid'");
				if($updatedb)
				{
					$data['message'] = '<div class="successmsg notification"><i class="fa fa-check"></i> Password changed successfully.</div>';
				}
				else
				{
					$data['message'] = '<div class="errormsg notification"><i class="fa fa-times"></i> Password could not changed. Please try again.</div>';
				}
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		else if(isset($linkid))
		{
			$hashlink=hash('sha1',$linkid);
			
			$numuserforgot = $this->Common_model->noof_records("customer_id","tbl_customers","temp_password='$hashlink'");
			$data['numuserforgot'] = $numuserforgot;
			if($numuserforgot > 0)
			{
				$userforgotqry = $this->Common_model->get_records("*","tbl_customers","temp_password='$hashlink'","");
				foreach ($userforgotqry as $rows)
				{
					$data['getuserid'] = $rows['customer_id'];
					$pwd_created = $rows['pwd_created'];
				}
				/*****************************/
				$curdatetime = strtotime("now");
				$expire_time = strtotime('+1 day', $pwd_created);
				$diffrnc = $expire_time-$curdatetime;
				$data['diffrnc'] = $diffrnc;
				if($diffrnc>=0) //Link is valid
				{
					$data['validmsg'] = '';
				}
				else
				{
					$data['validmsg'] = 'Sorry, Link has been expired.';
				}
			}
			else
			{	
				$data['validmsg'] = 'The Requested Link is Invalid ';
			}
		}
		$this->load->view('forgot_password', $data);
	}
}
