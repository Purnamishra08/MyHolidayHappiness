<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicletype extends CI_Controller {

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
		if(!(in_array(5, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}	
		
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['row'] = $this->Common_model->get_records("*","tbl_vehicletypes","","vehicle_name ASC","","");

		$data['addmessage'] = $this->session->flashdata('addmessage');
		if (isset($_POST['btnSubmitvehicle']) && !empty($_POST))
		{

			$this->form_validation->set_rules('vehicle_name', 'vehicle name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('capacity', 'capacity', 'trim|required|xss_clean');
			
			$sess_userid = $this->session->userdata('userid');
			if ($this->form_validation->run() == true)
			{				
				$vehicle_name = $this->input->post('vehicle_name');				 
				$capacity = $this->input->post('capacity');				 
				$noof_duprec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicle_name='$vehicle_name'");

				if($noof_duprec < 1)
				{
				$insert_data = array(
					'vehicle_name'	=> $vehicle_name,
					'capacity'	=> $capacity,
					'status'		=> 1					
				);
				// print_r($insert_data); exit;
				$insertdb = $this->Common_model->insert_records('tbl_vehicletypes', $insert_data);
				if($insertdb){
					$this->session->set_flashdata('addmessage','<div class="successmsg notification"><i class="fa fa-check"></i> Vehicle added successfully.</div>');
				}
				else{
					$this->session->set_flashdata('addmessage','<div class="errormsg notification"><i class="fa fa-times"></i> Vehicle could not added. Please try again.</div>');
				}
			}
			else
				{
					$this->session->set_flashdata('addmessage','<div class="errormsg notification"><i class="fa fa-times"></i> counrty field must contain a unique value.</div>');
				}
				redirect(base_url().'admin/vehicletype','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['addmessage'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}


		/*Update*/

			if (isset($_POST['btnUpdate']) && !empty($_POST))
		{
			$this->form_validation->set_rules('vehicle_name', 'vehicle name', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('capacity', 'capacity', 'trim|required|xss_clean');			
			
			if ($this->form_validation->run() == true)
			{
				$vehicle_name = $this->input->post('vehicle_name');
				$capacity = $this->input->post('capacity');
				$editid = $this->input->post('editid');

				$noof_duprec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicle_name='$vehicle_name' and vehicleid!='$editid'");

				$noof_rec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicleid='$editid'");
                if($noof_duprec < 1)
				{
				$query_data = array(					
					'vehicle_name'	=> $vehicle_name,	
					'capacity'		=> $capacity
				);
				// print_r($query_data); exit;
				
				$querydb = $this->Common_model->update_records('tbl_vehicletypes',$query_data,"vehicleid=$editid");
				if($querydb){
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> vehicle edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> vehicle could not edited. Please try again.</div>');
				}
			}

			  else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> The vehicle field must contain a unique value.</div>');
					
					}
				redirect(base_url().'admin/vehicletype','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		






		$this->load->view('admin/manage_vehicle',$data);
	}	

	public function view()
	{
		
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicleid='$viewid'");
		if($noof_rec>0)
		{
			
			$data['countrynm'] = $this->Common_model->get_records("*","tbl_vehicletypes","vehicleid=$viewid","");
			
			$this->load->view('admin/view_country',$data);
		}
	}

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicleid='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_vehicletypes","vehicleid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Vehicle has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Vehicle could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/vehicletype','refresh');
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicleid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_vehicletypes","vehicleid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_vehicletypes",$updatedata,"vehicleid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}



	public function vtypeeditpopup()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("vehicleid","tbl_vehicletypes","vehicleid='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_vehicletypes","vehicleid='$editid'");
			foreach ($data as $rows)
			{			

				$vehicleid = $rows['vehicleid'];
			    $vehicle_name = $rows['vehicle_name'];
			    $capacity = $rows['capacity'];
			    $status = $rows['status'];
				
			}
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit Vehicle Type</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/vehicletype'), array( 'id' => 'form_editvehicle', 'name' => 'form_editvehicle', 'class' => 'col-md-12 modalform'));?>
						<div class="form-group">
							<label class="col-md-3">Vehicle Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" placeholder="Enter Vehicle Name" name="vehicle_name" id="vehicle_name" value="<?php echo $vehicle_name; ?>">
								<input type="hidden" class="form-control" name="editid" id="editid" value="<?php echo $editid; ?>">
							 

							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<label class="col-md-3"> Capacity </label>
							<div class="col-md-9">
								
								 <input type="text" class="form-control fld" placeholder="Enter vehicle capacity" name="capacity" id="capacity" value="<?php echo $capacity; ?>">       

							</div>
							<div class="clearfix"></div>
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








   
