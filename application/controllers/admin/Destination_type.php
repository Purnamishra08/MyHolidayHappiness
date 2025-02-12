<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination_type extends CI_Controller {
	
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
		if(!(in_array(6, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}
 	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['m_message'] = $this->session->flashdata('m_message');
		
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{
			$this->form_validation->set_rules('destination_type_name', 'Destination Type', 'trim|required|xss_clean|is_unique[tbl_destination_type.destination_type_name]');
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$destination_type_name = $this->input->post('destination_type_name'); 
				

				if(!isset($showmenu))
					$showmenu = 0;
				
				$insert_data = array(
					'destination_type_name'	=> $destination_type_name,
					'status'		=> 1,
					'created_by'	=> $sess_userid,
					'created_date'	=> $date
				);
				
				$insertdb = $this->Common_model->insert_records('tbl_destination_type', $insert_data);
				if($insertdb)
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Destination Type added successfully.</div>');
				else
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Destination Type could not added. Please try again.</div>');
				redirect(base_url().'admin/destination_type','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
		
		if (isset($_POST['btnUpdate']) && !empty($_POST))
		{
			$this->form_validation->set_rules('destination_type_name', 'Destination Type', 'trim|required|xss_clean');
			
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$destination_type_name = $this->input->post('destination_type_name');
				$editid = $this->input->post('editid');

				$noof_duprec = $this->Common_model->noof_records("destination_type_id","tbl_destination_type","destination_type_name='$destination_type_name' and destination_type_id!='$editid'");
                if($noof_duprec < 1)
				{
				$query_data = array(
					'destination_type_name'	=> $destination_type_name,
					'updated_by'	=> $sess_userid,
					'updated_date'	=> $date
				);
				
				$querydb = $this->Common_model->update_records('tbl_destination_type', $query_data, "destination_type_id='$editid'");
				if($querydb){
					$this->session->set_flashdata('m_message','<div class="successmsg notification"><i class="fa fa-check"></i> Destination Type edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> Destination Type could not edited. Please try again.</div>');
				}
			}

			  else
					{
						$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> The Destination Type field must contain a unique value.</div>');
					
					}
				redirect(base_url().'admin/destination_type','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['m_message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
		/** Pagination Config **/
		
		/** Pagination Config **/

		$data['row'] = $this->Common_model->get_records("*","tbl_destination_type","","destination_type_name ASC","","");
		
		$this->load->view('admin/destination_type',$data);
	}
	
	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("destination_type_id","tbl_destination_type","destination_type_id='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_destination_type","destination_type_id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_destination_type",$updatedata,"destination_type_id=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}
	
	public function delete()	
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("destination_type_id","tbl_destination_type","destination_type_id='$delid'");
		if($noof_rec>0)
		{
			
				$del = $this->Common_model->delete_records("tbl_destination_type","destination_type_id=$delid");
				if($del){
					$this->session->set_flashdata('m_message','<div class="successmsg notification"><i class="fa fa-check"></i>Destination type has been deleted successfully.</div>');
				}
				else{
					$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> Destination type could not deleted. Please try again.</div>');
				}
			
		}
		redirect(base_url().'admin/destination_type','refresh');
	}
	
	public function edit_pop()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("destination_type_id","tbl_destination_type","destination_type_id='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_destination_type","destination_type_id='$editid'");
			foreach ($data as $rows)
			{
				$destination_type_name = $rows['destination_type_name'];
				
			}
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit Destination Type</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/destination_type'), array( 'id' => 'form_destination_types', 'name' => 'form_destination_types', 'class' => 'col-md-12 modalform'));?>
						<div class="form-group">
							<label class="col-md-3">Destination Type</label>
							<div class="col-md-9"><input type="text" class="form-control" placeholder="Enter Destination Type" name="destination_type_name" id="destination_type_name" value="<?php echo $destination_type_name; ?>" required></div>
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
