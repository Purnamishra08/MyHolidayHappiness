<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menutabs extends CI_Controller {

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
		if(!(in_array(8, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
		
 	}

	public function index()
	{
		$data['messageadd'] = $this->session->flashdata('messageadd');
		
		$data['row'] = $this->Common_model->get_records("*","tbl_menucateories","","catid DESC","","");

		/*Add price*/
		
		if (isset($_POST['btnSubmitcats']) && !empty($_POST))
		{			
			$this->form_validation->set_rules('menuid', 'menuid', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cat_name', 'cat_name', 'trim|required|xss_clean');		
			
			if ($this->form_validation->run() == true)
			{				
				$menuid = $this->input->post('menuid');				 
				$cat_name = $this->input->post('cat_name');	

				$noof_duprec = $this->Common_model->noof_records("catid","tbl_menucateories","menuid = $menuid and cat_name ='$cat_name'");				
				$date = date("Y-m-d H:i:s");
				if($noof_duprec < 1)
				{
					$insert_data = array(
						'menuid'	=> $menuid,
						'cat_name'	=> $cat_name,
						'created'	        => $date,
						'status'		=> 1					
					);				

				$insertdb = $this->Common_model->insert_records('tbl_menucateories', $insert_data);
				if($insertdb) {
					$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Category added successfully.</div>');
				} else {
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Category could not added. Please try again.</div>');
				}
			}
			else
				{
					$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added category to this menus.</div>');
				}
				redirect(base_url().'admin/menutabs','refresh');
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
			$this->form_validation->set_rules('menuid', 'menu', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('cat_name', 'category name', 'trim|required|xss_clean');	
			
			if ($this->form_validation->run() == true)
			{
				
				$menuid = $this->input->post('menuid');				 
				$cat_name = $this->input->post('cat_name');	 
				$editid = $this->input->post('catid');	 

				$noof_duprec = $this->Common_model->noof_records("catid","tbl_menucateories","cat_name='$cat_name' and menuid ='$menuid' and catid!='$editid'");

				$noof_rec = $this->Common_model->noof_records("catid","tbl_menucateories","catid='$editid'");
                if($noof_duprec < 1)
				{

				$update_data = array(
					'cat_name'	     => $cat_name,	
					'menuid'	    => $menuid	
				);	
				
				$querydb = $this->Common_model->update_records('tbl_menucateories',$update_data,"catid=$editid");
				if($querydb){
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Category edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Category could not edited. Please try again.</div>');
				}
			}

			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this Category to menu</div>');
			
			}
				redirect(base_url().'admin/menutabs','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}

		$this->load->view('admin/manage_menutabs',$data);
	}	

	

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("catid","tbl_menucateories","catid='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_menucateories","catid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Category has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Category could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/menutabs','refresh');
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("catid","tbl_menucateories","catid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_menucateories","catid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_menucateories",$updatedata,"catid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}

	



	public function menucateditpopup()
	{
		$editid = $this->uri->segment(4);

		$noof_rec = $this->Common_model->noof_records("catid","tbl_menucateories","catid='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_menucateories","catid='$editid'");
			foreach ($data as $rows)
			{	
			    $catid = $rows['catid'];
			    $menuid = $rows['menuid'];
			    $cat_name = $rows['cat_name'];
			}
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit Menu Category</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/menutabs'), array( 'id' => 'form_editmenutabs', 'name' => 'form_editmenutabs', 'class' => 'col-md-12 modalform'));?>
						
											<div class="col-md-6"> 
                                                <div class="form-group">
                                                <label> Menu </label>
		                                            <select class="form-control fld" name="menuid" id="menuid">
				                                            <option value=""> --Select menutab--</option>		
				                                            
				                                            
				                                            <?php  echo $this->Common_model->populate_select($dispid = $menuid, "menuid", "menu_name", "tbl_menus", "", "menu_name asc", ""); ?> 	                                           
					                                           <!-- <option value="1" <?php echo ($menuid == '1') ? 'selected="selected"' :''; ?>>  Destinations </option>
					                                            <option value="2" <?php echo ($menuid == '2') ? 'selected="selected"' :''; ?>>  Getaways </option>
					                                            <option value="3" <?php echo ($menuid == '3') ? 'selected="selected"' :''; ?>>  Tours </option> -->

		                                        	</select>
                                                 <input type="hidden" name="catid" id="catid" value="<?php echo set_value('catid',$catid); ?>">
                                                </div>
                                            </div>
                                            
					     					<div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label> Category </label>
                                                  <input type="text" class="form-control fld" placeholder="Enter category" name="cat_name" id="cat_name" value="<?php echo $cat_name; ?>">  
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>
											<div class="form-group">
												<label class="col-md-3"></label>
												<div class="reset-button col-md-9">
												  <!-- <input type="hidden" name="editid" id="editid" value="<?php echo $editid; ?>" /> -->
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








   
