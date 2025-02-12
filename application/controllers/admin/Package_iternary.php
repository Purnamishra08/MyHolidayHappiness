<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_iternary extends CI_Controller {

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
		if(!(in_array(10, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');		
		$data['row'] = $this->Common_model->get_records("*","tbl_tourpackages","","tourpackageid DESC","","");
		$this->load->view('admin/manage_tpackages',$data);
	}

	public function add()
	{	
		$tourPackId = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$tourPackId'");

        if ($noof_rec > 0) 
		{			
			$data['messageadd'] = $this->session->flashdata('messageadd');
			
			if (isset($_POST['btnSubmitIter']) && !empty($_POST))
			{			
				$this->form_validation->set_rules('destination_id[]', 'Destination ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('no_ofdays[]', 'No of Days', 'trim|required|xss_clean');	
				$this->form_validation->set_rules('no_ofnight[]', 'No of Nights', 'trim|required|xss_clean');
				$this->form_validation->set_rules('iternary_title[]', 'Iternary title', 'trim|required|xss_clean');

				if ($this->form_validation->run() == true)
				{			
					$destination_ids = $this->input->post('destination_id');	
					$no_ofdays = $this->input->post('no_ofdays');	
					$no_ofnights = $this->input->post('no_ofnight');
					$iternary_title = $this->input->post('iternary_title');
					$iternary_detais = $this->input->post('iternary_detais');
					
					/*print_r($destination_ids);
					echo "<br>";
					print_r($no_ofdays);
					echo "<br>";
					print_r($no_ofnights);
					echo "<br>";
					print_r($iternary_title);
					echo "<br>";
					print_r($iternary_detais);
					echo "<br>";
					die();*/
					
					if(count($destination_ids)>0)
					{									
						for ( $i = 0; $i < count($destination_ids); $i++ )
						{								
							$tour_pack_id = $tourPackId;
							$newdestination_id = $destination_ids[$i];
							$newno_ofdays = $no_ofdays[$i];
							$newno_ofnights = $no_ofnights[$i];	
														
							$insert_data = array(
								'tour_pack_id'		=> $tour_pack_id,
								'destination_id'	=> $newdestination_id,
								'no_ofdays'		    => $newno_ofdays,
								'no_ofnight'	    => $newno_ofnights
							);
							$insertdb = $this->Common_model->insert_records('tbl_pack_associate_dest', $insert_data);
						}
					}
							
					/* Start iternarary insertion*/
					if(count($iternary_title) > 0) {						  
						for ( $i = 0; $i < count($iternary_title); $i++ )
						{								
							$newiternary_title = $iternary_title[$i];
							$newiternary_detais   = $iternary_detais[$i];
							if(!empty($newiternary_detais))
								$iternary_str = implode(",",$newiternary_detais);
							else
								$iternary_str = NULL;
							
							$insert_data = array(
								'tour_pack_id'       => $tourPackId,
								'iternary_title'	 => trim($newiternary_title),
								'iternary_details'	 => $iternary_str
							);							
						   $insertdb = $this->Common_model->insert_records('tbl_package_iternary', $insert_data);
						}
					}
					//die();
					/* End iternarary insertion*/
						
					if($insertdb)
					{
						$itinerary_note = $this->input->post('itinerary_note');
						$updatedata = array('itinerary_note' => $itinerary_note);
						$updatepackage = $this->Common_model->update_records("tbl_tourpackages", $updatedata, "tourpackageid=$tourPackId");
						
						$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Iternary details added to tour package successfully.</div>');	
						redirect(base_url().'admin/tour-packages/add/','refresh');
					}
					else {
						$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Iternary details could not added. Please try again.</div>');
					}	
					redirect(base_url().'admin/package-iternary/add/'.$tourPackId,'refresh');				  
				}
				else
				{
					$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
				}
			}		
			$this->load->view('admin/add_packageiternary',$data);	
		}
		else
		{
			redirect(base_url().'admin/tour-packages/add/','refresh');
		}
	}	
	
	//////////////Edit/////////////
	
	public function edit() {
        $editid = $this->uri->segment(4);       
		$noof_rec = $this->Common_model->noof_records("tourpackageid", "tbl_tourpackages", "tourpackageid='$editid'");

        if ($noof_rec > 0) 
		{			
			$data['editmessage'] = $this->session->flashdata('editmessage');
			
			if (isset($_POST['btnSubmitIter']) && !empty($_POST))
			{			
				$this->form_validation->set_rules('destination_id[]', 'Destination ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('no_ofdays[]', 'No of Days', 'trim|required|xss_clean');	
				$this->form_validation->set_rules('no_ofnight[]', 'No of Nights', 'trim|required|xss_clean');
				$this->form_validation->set_rules('iternary_title[]', 'Iternary title', 'trim|required|xss_clean');

				if ($this->form_validation->run() == true)
				{	
					$destination_ids = $this->input->post('destination_id');	
					$no_ofdays = $this->input->post('no_ofdays');	
					$no_ofnights = $this->input->post('no_ofnight');
					$iternary_title = $this->input->post('iternary_title');
					$iternary_detais = $this->input->post('iternary_detais');
					
					if(count($destination_ids)>0)
					{			
						$this->Common_model->delete_records("tbl_pack_associate_dest", "tour_pack_id = $editid");						
						for ( $i = 0; $i < count($destination_ids); $i++ )
						{
							$newdestination_id = $destination_ids[$i];
							$newno_ofdays = $no_ofdays[$i];
							$newno_ofnights = $no_ofnights[$i];	
														
							$insert_data = array(
								'tour_pack_id'		=> $editid,
								'destination_id'	=> $newdestination_id,
								'no_ofdays'		    => $newno_ofdays,
								'no_ofnight'	    => $newno_ofnights
							);
						   $insertdb = $this->Common_model->insert_records('tbl_pack_associate_dest', $insert_data);
						}
					}
					
					/* Start iternarary insertion*/
					if(count($iternary_title) > 0) 
					{	
						$this->Common_model->delete_records("tbl_package_iternary", "tour_pack_id = $editid");					  
						for ( $i = 0; $i < count($iternary_title); $i++ )
						{								
							$newiternary_title = $iternary_title[$i];
							$newiternary_detais   = $iternary_detais[$i];
							if(!empty($newiternary_detais))
								$iternary_str = implode(",",$newiternary_detais);
							else
								$iternary_str = NULL;
							$insert_data = array(
								'tour_pack_id'       => $editid,
								'iternary_title'	 => trim($newiternary_title),
								'iternary_details'	 => $iternary_str
							);							
						   $insertdb = $this->Common_model->insert_records('tbl_package_iternary', $insert_data);
						}
					}
					/* End iternarary insertion*/
					
					if($insertdb)
					{
						$itinerary_note = $this->input->post('itinerary_note');
						$updatedata = array('itinerary_note' => $itinerary_note);
						$updatepackage = $this->Common_model->update_records("tbl_tourpackages", $updatedata, "tourpackageid=$editid");
							
						$this->session->set_flashdata('editmessage','<div class="successmsg notification"><i class="fa fa-check"></i> Iternary details updated successfully.</div>');						
					}
					else {
						$this->session->set_flashdata('editmessage','<div class="errormsg notification"><i class="fa fa-times"></i> Iternary details could not update. Please try again.</div>');
					}	
					
					redirect(base_url().'admin/package-iternary/edit/'.$editid,'refresh');
				}
				
				else
				{
					$data['editmessage'] = (validation_errors() ? validation_errors() : $this->session->flashdata('editmessage'));
				}
			}		
			$this->load->view('admin/edit_packageiternary', $data);
		}
		else
		{
			redirect(base_url().'admin/tour-packages/add/','refresh');
		}        
    }

	

}



