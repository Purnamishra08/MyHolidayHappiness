<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends CI_Controller {

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
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(2, $allusermodules))) {
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['row'] = $this->Common_model->get_records("*","tbl_parameters","param_type='CS' and status=1","parid ASC","","");
		$this->load->view('admin/general_settings',$data);
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("parid","tbl_parameters","parid='$editid'");
		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['row'] = $this->Common_model->get_records("*","tbl_parameters","parid='$editid'","parid ASC");
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
                      
				$input_type = $this->input->post('input_type');

				if ( $input_type==1) {
					$par_value = $this->input->post('par_value'); 
					$update_data = array(
						'par_value'		=> $par_value						
					);
                } 
				else if ($input_type==2) 
				{
					$text_area = $this->input->post('text_area');
					$update_data = array(
						'par_value'		=> $text_area						
					);                
                } 
				else if($input_type==3)
				{
                	$getrecord= $this->Common_model->get_records("par_value","tbl_parameters", "parid='$editid'");
					foreach ($getrecord as $getrecords)
					{
						$bnrlogo_img = $getrecords['par_value'];						
					}

					if (isset($_FILES['bnrimg']) && $_FILES['bnrimg']['name'] != '') 
					{                       
                        $bnrimg = $this->ddoo_upload('bnrimg');
                        if($bnrlogo_img!='' && $bnrlogo_img!=' ')
						{
							$path_bnrlogo_img="uploads/$bnrlogo_img";
							if(file_exists($path_bnrlogo_img))
								unlink($path_bnrlogo_img);
						}
					} else {
                        $bnrimg=$bnrlogo_img;
                    }

                    $update_data = array(
						'par_value'		=> $bnrimg
					);
                } 
				else 
				{                       
					$short_desc = $this->input->post('short_desc');
					$update_data = array(
						'par_value'		=> $short_desc					
					);
                }
				$updatedb = $this->Common_model->update_records('tbl_parameters',$update_data,"parid=$editid");
				if($updatedb) {
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Parameter value saved successfully.</div>');
				}
				else {
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Parameter value could not saved. Please try again.</div>');
				}
				redirect(base_url().'admin/general_settings/edit/'.$editid,'refresh');
			}
			$this->load->view('admin/edit_general_settings',$data);
		}
		else
			redirect(base_url().'admin/general_settings','refresh');
	}

	function ddoo_upload($filename)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = '0';
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = FALSE;

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($filename)) {
			//echo $this->upload->display_errors();die();
			return NULL;
		} else {
			$data = $this->upload->data();
			$filename = $data['file_name'];
			return $filename;
		}
	}

}
