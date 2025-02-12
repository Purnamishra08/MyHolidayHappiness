<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends CI_Controller {

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

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['row'] = $this->Common_model->get_records("*","tbl_country","","country_name ASC","","");
		$this->load->view('admin/manage_country',$data);
	}

	public function add()
	{

		$data['message'] = $this->session->flashdata('message');
		//print_r($_POST);
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{

			$this->form_validation->set_rules('country_name', 'Country', 'trim|required|xss_clean');
			
			$sess_userid = $this->session->userdata('userid');
			//echo "$sess_userid";
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				
				$country_name = $this->input->post('country_name');
				 
				 $noof_duprec = $this->Common_model->noof_records("countryid","tbl_country","country_name='$country_name'");
				 if($noof_duprec < 1)
					{
				$insert_data = array(
					'country_name'	=> $country_name,
					'status'		=> 1
					
				);
				//print_r($insert_data);
				$insertdb = $this->Common_model->insert_records('tbl_country', $insert_data);
				if($insertdb){
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Country added successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Country could not added. Please try again.</div>');
				}
			}
			else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> counrty field must contain a unique value.</div>');
					}
				redirect(base_url().'admin/country/add','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}

		$this->load->view('admin/add_country',$data);
		
		
	}

	public function view()
	{
		
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("countryid","tbl_country","countryid='$viewid'");
		if($noof_rec>0)
		{
			
			$data['countrynm'] = $this->Common_model->get_records("*","tbl_country","countryid=$viewid","");
			
			$this->load->view('admin/view_country',$data);
		}
	}

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("countryid","tbl_country","countryid='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_country","countryid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Country has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Country could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/country','refresh');
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("countryid","tbl_country","countryid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_country","countryid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_country",$updatedata,"countryid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("countryid","tbl_country","countryid='$editid'");
		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			
			$data['countrynmm'] = $this->Common_model->get_records("*","tbl_country","countryid=$editid","");
			
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
	$this->form_validation->set_rules('country_name', 'Country', 'trim|required|xss_clean');
				
				
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
				$country_name = $this->input->post('country_name');

				$noof_duprec = $this->Common_model->noof_records("countryid","tbl_country","country_name='$country_name' and countryid!='$editid'");

				if($noof_duprec < 1)
					{

					$update_data = array(
					'country_name'	=> $country_name,	
					'status'		=> 1
					
				);	
						$updatedb = $this->Common_model->update_records('tbl_country',$update_data,"countryid=$editid");
						if($updatedb)
						{
							
							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Country edited successfully.</div>');
						}
						else
						{	
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Country could not edited. Please try again.</div>');
						}
					}

					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> The country field must contain a unique value.</div>');
					}
					
					redirect(base_url().'admin/country/edit/'.$editid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_country', $data);
		}
		else
			redirect(base_url().'admin/country','refresh');
	}




	public function select($str)
	{
		if($str=='0' || $str=='')
		{
			$this->form_validation->set_message('select',  'The %s field is required.');
			return false;
		}
		else
			return true;
	}


	public function add_state() {

        $data['message'] = $this->session->flashdata('message');
        $cid = $this->uri->segment(4);     

		if (isset($_POST['btnSubmitstate']) && !empty($_POST)) { 

            $this->form_validation->set_rules('state_name[]', 'State', 'required');  
            // $this->form_validation->set_rules('checkstate', 'checkstate', 'required');  
             $checked_status = $this->input->post('checkstate');
            // if ($this->form_validation->run() == true) {   

                $state_names = $this->input->post('state_name');

                if ($state_names) { 
	                    foreach ($state_names as $state_name) {
	                        $insert_states = array(
	                            'country_id' => $cid,
	                            'state_name' => $state_name,
	                            'status' => 1
	                        );
	                        $insertdb = $this->Common_model->insert_records('tbl_states', $insert_states);

	                        if($insertdb) {
	                        	$lastId = $this->db->insert_id();	
	                        	  foreach ($checked_status as $check_status) { print_r($check_status);
	                        	  	$cstatus = ($check_status == '1') ? '1' : '' ;
	                        	  	$updataevent = array('checked_status' => $cstatus);
									$this->Common_model->update_records("tbl_states", $updataevent, "stateid='$lastId'"); 	
	                        	  }
	                    	}
	                    }                     
                } 

                redirect(base_url().'admin/country/add-state/'.$cid,'refresh');
        }

        $this->load->view('admin/add_state', $data);
    }

	
}








   