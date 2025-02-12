<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_duration extends CI_Controller {

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
		$data['messageadd'] = $this->session->flashdata('messageadd');
		
		$data['row'] = $this->Common_model->get_records("*","tbl_package_duration","","durationid DESC","","");

		/*Add price*/


		if (isset($_POST['btnSubmitpduration']) && !empty($_POST))
		{			
			$this->form_validation->set_rules('duration_name', 'duration_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('no_ofdays', 'no_ofdays', 'trim|required|xss_clean');
			$this->form_validation->set_rules('no_ofnights', 'no_ofnights', 'trim|required|xss_clean');			
			
			if ($this->form_validation->run() == true)
			{				
				$duration_name = $this->input->post('duration_name');			
				$no_ofdays = $this->input->post('no_ofdays');				 
				$no_ofnights = $this->input->post('no_ofnights');				 

				$noof_duprec = $this->Common_model->noof_records("durationid","tbl_package_duration","duration_name ='$duration_name'");				

				if($noof_duprec < 1)
				{
					$insert_data = array(
						'duration_name' => $duration_name,
						'no_ofdays'	     => $no_ofdays,
						'no_ofnights'	 => $no_ofnights,
						'status'		 => 1					
					);				

				$insertdb = $this->Common_model->insert_records('tbl_package_duration', $insert_data);
				if($insertdb) {
					$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Duration added successfully.</div>');
				} else {
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Duration could not added. Please try again.</div>');
				}
			}
			else
				{
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this duration.</div>');
				}
				redirect(base_url().'admin/package-duration','refresh');
			}
			else
			{
				
				//set the flash data error message if there is one
				$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
			}
		}

		/*Edit price*/

		$data['message'] = $this->session->flashdata('message');
		if (isset($_POST['btnUpdate']) && !empty($_POST))
		{
			
			$this->form_validation->set_rules('duration_name', 'duration_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('no_ofdays', 'no_ofdays', 'trim|required|xss_clean');
			$this->form_validation->set_rules('no_ofnights', 'no_ofnights', 'trim|required|xss_clean');			
			
			if ($this->form_validation->run() == true)
			{
				
				$editid = $this->input->post('durationid');				 
				$duration_name = $this->input->post('duration_name');				 
				$no_ofdays = $this->input->post('no_ofdays');	 		 
				$no_ofnights = $this->input->post('no_ofnights');	

				$noof_duprec = $this->Common_model->noof_records("durationid","tbl_package_duration","duration_name='$duration_name' and durationid!='$editid'");

				$noof_rec = $this->Common_model->noof_records("durationid","tbl_package_duration","durationid='$editid'");
                if($noof_duprec < 1)
				{

				$update_data = array(
					'duration_name'	=> $duration_name,	
					'no_ofdays'	    => $no_ofdays,	
					'no_ofnights'	=> $no_ofnights		
					);	
				
				$querydb = $this->Common_model->update_records('tbl_package_duration',$update_data,"durationid=$editid");
				if($querydb){
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Duration edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Duration could not edited. Please try again.</div>');
				}
			}

			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this duration </div>');
			
			}
				redirect(base_url().'admin/package-duration','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}

		$this->load->view('admin/manage_pduration',$data);
	}	
	
	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("durationid","tbl_package_duration","durationid='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_package_duration","durationid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Duration Duration has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Duration could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/package-duration','refresh');
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("durationid","tbl_package_duration","durationid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_package_duration","durationid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_package_duration",$updatedata,"durationid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}

	



	public function vpriceeditpopup()
	{
		$editid = $this->uri->segment(4);

		$noof_rec = $this->Common_model->noof_records("durationid","tbl_package_duration","durationid='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_package_duration","durationid='$editid'");
			foreach ($data as $rows)
			{			
                    $duration_name = $rows['duration_name'];
				    $no_ofdays = $rows['no_ofdays'];
				    $no_ofnights = $rows['no_ofnights'];
				    $durationid = $rows['durationid'];
    
				
			}
			// echo $destination;
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit Package Duration</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/package_duration'), array( 'id' => 'form_editpduration', 'name' => 'form_editpduration', 'class' => 'col-md-12 modalform'));?>
						
											<div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> Duration Name </label>
                                              
                                               <input type="text" class="form-control fld" placeholder="Enter duration name capacity" name="duration_name" id="duration_name" value="<?php echo set_value('duration_name',$duration_name); ?>"> 
                                               
                                                 <input type="hidden" name="durationid" id="durationid" value="<?php echo set_value('durationid',$durationid); ?>">
                                                </div>
                                            </div>

                                             <div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> No of Days </label> 
                                               
                                                <input type="text" class="form-control fld" placeholder="Enter no of days" name="no_ofdays" id="no_ofdays" value="<?php echo set_value('no_ofdays',$no_ofdays); ?>"> 
                                                 </div>
                                            </div>


					     					<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> No. of Nights </label>
                                                    <input type="text" class="form-control fld" placeholder="Enter no of nights" name="no_ofnights" id="no_ofnights" value="<?php echo set_value('no_ofnights',$no_ofnights); ?>"> 
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>
											<div class="form-group">
												<label class="col-md-3"></label>
												<div class="reset-button col-md-9">
												  <input type="hidden" name="editid" id="editid" value="<?php echo $editid; ?>" />
												  <button type="submit" class="btn redbtn btnUpdate" name="btnUpdate" id="btnUpdate">Update</button>
												</div>
											</div>


					<?php echo form_close(); ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php
		}
		exit();
	}







	
	
}








   
