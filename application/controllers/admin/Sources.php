<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sources extends CI_Controller {
	
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
		if(!(in_array(20, $allusermodules))) 
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
			$this->form_validation->set_rules('source_name', 'Source', 'trim|required|xss_clean|is_unique[tbl_sources.name]');
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$source_name = $this->input->post('source_name'); 				

				if(!isset($showmenu))
					$showmenu = 0;
				
				$insert_data = array(
					'name'			=> $source_name,
					'status'		=> 1,
					'created_by'	=> $sess_userid,
					'created_date'	=> $date
				);
				
				$insertdb = $this->Common_model->insert_records('tbl_sources', $insert_data);
				if($insertdb)
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Source added successfully.</div>');
				else
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Source could not added. Please try again.</div>');
				redirect(base_url().'admin/sources','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
		
		if (isset($_POST['btnUpdate']) && !empty($_POST))
		{
			$this->form_validation->set_rules('source_name', 'Source', 'trim|required|xss_clean');
			
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$source_name = $this->input->post('source_name');
				$editid = $this->input->post('editid');

				$noof_duprec = $this->Common_model->noof_records("id","tbl_sources","name='$source_name' and id!='$editid'");
                if($noof_duprec < 1)
				{
				$query_data = array(
					'name'			=> $source_name,
					'updated_by'	=> $sess_userid,
					'updated_date'	=> $date
				);
				
				$querydb = $this->Common_model->update_records('tbl_sources', $query_data, "id='$editid'");
				if($querydb){
					$this->session->set_flashdata('m_message','<div class="successmsg notification"><i class="fa fa-check"></i> Source edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> Source could not edited. Please try again.</div>');
				}
			}

			  else
					{
						$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> The Source field must contain a unique value.</div>');
					
					}
				redirect(base_url().'admin/sources','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['m_message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
		/** Pagination Config **/
		
		/** Pagination Config **/

		$data['row'] = $this->Common_model->get_records("*","tbl_sources","","name ASC","","");
		
		$this->load->view('admin/sources',$data);
	}
	
	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("id","tbl_sources","id='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_sources","id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_sources",$updatedata,"id=$stsid");
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
		$noof_rec = $this->Common_model->noof_records("id","tbl_sources","id='$delid'");
		if($noof_rec>0)
		{
			
				$del = $this->Common_model->delete_records("tbl_sources","id=$delid");
				if($del){
					$this->session->set_flashdata('m_message','<div class="successmsg notification"><i class="fa fa-check"></i> Source has been deleted successfully.</div>');
				}
				else{
					$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> Source could not deleted. Please try again.</div>');
				}
			
		}
		redirect(base_url().'admin/sources','refresh');
	}
	
	public function edit_pop()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("id","tbl_sources","id='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_sources","id='$editid'");
			foreach ($data as $rows)
			{
				$source_name = $rows['name'];				
			}
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit Source</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/sources'), array( 'id' => 'form_sources', 'name' => 'form_sources', 'class' => 'col-md-12 modalform'));?>
						<div class="form-group">
							<label class="col-md-3">Source </label>
							<div class="col-md-9"><input type="text" class="form-control" placeholder="Enter Source" name="source_name" id="source_name" value="<?php echo $source_name; ?>" required></div>
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
