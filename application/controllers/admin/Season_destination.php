<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Season_destination extends CI_Controller {

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
		if(!(in_array(17, $allusermodules))) {
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['row'] = $this->Common_model->get_records("*","tbl_season_destinations","status=1","seadestinationid ASC","","");
		$this->load->view('admin/season_destination',$data);
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("seadestinationid","tbl_season_destinations","seadestinationid='$editid'");
		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['row'] = $this->Common_model->get_records("*","tbl_season_destinations","seadestinationid='$editid'","seadestinationid ASC");
			
			
			if (isset($_POST['btnSubmit']) && !empty($_POST))
			{
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");                      
				//$param_type = $this->input->post('param_type');				
				$destination_id = $this->input->post('destination_id');				
                $par_value= $this->Common_model->showname_fromid("par_value","tbl_season_destinations", "seadestinationid='$editid'");
                
					$bnrlogo_img = $par_value;
					
					if (isset($_FILES['bnrimg']) && $_FILES['bnrimg']['name'] != '') 
					{   
						
						/*if($param_type=='SD1')	{  
							$bnrimg = $this->Common_model->ddoo_upload('bnrimg', 730 , 300 );
						} else {
							$bnrimg = $this->Common_model->ddoo_upload('bnrimg', 500 , 300 );
						}*/
						                  
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
					  'destination_id'	=> $destination_id,
					  'par_value'		=> $bnrimg
					);
                
				
						$updatedb = $this->Common_model->update_records('tbl_season_destinations',$update_data,"seadestinationid=$editid");
						if($updatedb) {
							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Parameter value saved successfully.</div>');
						}
						else {
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Parameter value could not saved. Please try again.</div>');
						}
						redirect(base_url().'admin/season-destination/edit/'.$editid,'refresh');
				
			}
		
		$this->load->view('admin/edit_season_destination',$data);					
			
		} else {
			redirect(base_url().'admin/season-destination','refresh');
		}
			
			
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
