<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {
	
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
			$this->form_validation->set_rules('state_name', 'state_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('state_url', 'state url', 'trim|required|xss_clean|is_unique[tbl_state.state_url]');
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$state_name = $this->input->post('state_name'); 
				$state_url = $this->input->post('state_url');
				$showmenu = $this->input->post('showmenu'); 
				
			
				$alttag_banner = $this->input->post('alttag_banner');
					$imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
				    if (isset($_FILES['bannerimg']) && $_FILES['bannerimg']['name'] != '') {
						$filename = $this->Common_model->ddoo_upload('bannerimg', 1920, 488 , $imofilename);
					} else {
						$filename = NULL;
					}
				$state_meta_title = $this->input->post('state_meta_title');	
				$state_meta_keywords = $this->input->post('state_meta_keywords');	
				$state_meta_description = $this->input->post('state_meta_description');	

				if(!isset($showmenu))
					$showmenu = 0;
				
				$insert_data = array(
					'state_name'	=> $state_name,
					'state_url'	=> $state_url,
					'state_meta_title'		=> $state_meta_title,
					'state_meta_keywords'		=> $state_meta_keywords,
					'state_meta_description'	=> $state_meta_description,
					'bannerimg'		    => $filename,
					'alttag_banner'	=> $alttag_banner,
					'showmenu'        => $showmenu,
					'status'		=> 1,
					'created_by'	=> $sess_userid,
					'created_date'	=> $date
				);
				
				$insertdb = $this->Common_model->insert_records('tbl_state', $insert_data);
				if($insertdb)
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> State added successfully.</div>');
				else
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> State could not added. Please try again.</div>');
				redirect(base_url().'admin/state','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
		
		if (isset($_POST['btnUpdate']) && !empty($_POST))
		{
			$this->form_validation->set_rules('state_names', 'state_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('state_urls', 'state_url', 'trim|required|xss_clean');
			
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$state_names = $this->input->post('state_names');
				$state_urls = $this->input->post('state_urls');
				$showmenu1 = $this->input->post('showmenu1');
				$editid = $this->input->post('editid');
                
				$alttag_banner = $this->input->post('alttag_banner');
				$state_meta_title = $this->input->post('state_meta_title');	
				$state_meta_keywords = $this->input->post('state_meta_keywords');	
				$state_meta_description = $this->input->post('state_meta_description');	
				
				$imofilename = $this->Common_model->seo_friendly_url($alttag_banner);
				    if (isset($_FILES['bannerimg']) && $_FILES['bannerimg']['name'] != '') {
						$filename = $this->Common_model->ddoo_upload('bannerimg', 1920, 488 , $imofilename);
					} else {
						$filename = NULL;
					}
				
				$noof_duprec = $this->Common_model->noof_records("state_id","tbl_state","state_url='$state_urls' and state_id!='$editid'");
                if($noof_duprec < 1)
				{
				    if($filename){
				        $query_data = array(
        					'state_name'	=> $state_names,
        					'state_url'	=> $state_urls,
        					'state_meta_title'		=> $state_meta_title,
        					'state_meta_keywords'		=> $state_meta_keywords,
        					'state_meta_description'	=> $state_meta_description,
        					'bannerimg'		    => $filename,
        					'alttag_banner'	=> $alttag_banner,
        					'showmenu'        => $showmenu1,
        					'updated_by'	=> $sess_userid,
        					'updated_date'	=> $date
        				);
				    }else{
				        $query_data = array(
        					'state_name'	=> $state_names,
        					'state_url'	=> $state_urls,
        					'state_meta_title'		=> $state_meta_title,
        					'state_meta_keywords'		=> $state_meta_keywords,
        					'state_meta_description'	=> $state_meta_description,
        					'alttag_banner'	=> $alttag_banner,
        					'showmenu'        => $showmenu1,
        					'updated_by'	=> $sess_userid,
        					'updated_date'	=> $date
        				);
				    }
				
				
				$querydb = $this->Common_model->update_records('tbl_state', $query_data, "state_id='$editid'");
				if($querydb){
					$this->session->set_flashdata('m_message','<div class="successmsg notification"><i class="fa fa-check"></i> State edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> State could not edited. Please try again.</div>');
				}
			}

			  else
					{
						$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> The State field must contain a unique value.</div>');
					
					}
				redirect(base_url().'admin/state','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['m_message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		
		/** Pagination Config **/
		
		/** Pagination Config **/

		$data['row'] = $this->Common_model->get_records("*","tbl_state","","state_name ASC","","");
		
		$this->load->view('admin/state',$data);
	}
	
	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("state_id","tbl_state","state_id='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_state","state_id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_state",$updatedata,"state_id=$stsid");
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
		$noof_rec = $this->Common_model->noof_records("state_id","tbl_state","state_id='$delid'");
		if($noof_rec>0)
		{
			
				$del = $this->Common_model->delete_records("tbl_state","state_id=$delid");
				if($del){
					$this->session->set_flashdata('m_message','<div class="successmsg notification"><i class="fa fa-check"></i>State has been deleted successfully.</div>');
				}
				else{
					$this->session->set_flashdata('m_message','<div class="errormsg notification"><i class="fa fa-times"></i> State could not deleted. Please try again.</div>');
				}
			
		}
		redirect(base_url().'admin/state','refresh');
	}
	
	public function edit_pop()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("state_id","tbl_state","state_id='$editid'");
		if($noof_rec > 0)
		{
			$data = $this->Common_model->get_records("*","tbl_state","state_id='$editid'");
			foreach ($data as $rows)
			{
				$state_names = $rows['state_name'];
				$state_urls = $rows['state_url'];
				$showmenu = $rows['showmenu'];
				$alttag_banner = $rows['alttag_banner'];
				
				$state_meta_title = $rows['state_meta_title'];
				$state_meta_keywords = $rows['state_meta_keywords'];
				$state_meta_description = $rows['state_meta_description'];
				
			}
	?>

        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Edit State</h4>
		</div>
		<div class="modal-body">
			<div class="modal-sub-body">
				<div class="row">
						<?php echo form_open(base_url('admin/state'), array( 'id' => 'form_states', 'name' => 'form_states', 'class' => 'col-md-12 modalform' ,'enctype' => 'multipart/form-data'));?>
						<div class="form-group">
							<label class="col-md-3">State Name</label>
							<div class="col-md-9"><input type="text" class="form-control" placeholder="Enter State Name" name="state_names" id="state_names" value="<?php echo $state_names; ?>"></div>
							<div class="clearfix"></div>
						</div>

						<div class="form-group">
							<label class="col-md-3">State Url</label>
							<div class="col-md-9"><input type="text" class="form-control" placeholder="Enter State Url" name="state_urls" id="state_urls" value="<?php echo $state_urls; ?>"></div>
							<div class="clearfix"></div>
						</div>
						<div class="row"> 
						<div class="col-md-12"> 
                               <div class="form-group">
                                    <label class="col-md-3"> Banner Image</label>
                                   	<div class="col-md-9"> <input type="file" name="bannerimg" id="bannerimg" >
                                    <span>Image size should be 1920px X 488px </span>
                                </div></div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label class="col-md-3"> Alt Tag For Banner Image</label>
                                   	<div class="col-md-9"> <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner"  maxlength="60" value="<?php echo $alttag_banner; ?>">
                                </div></div>
                            </div>
    							<div class="col-md-12"> 
    								<div class="form-group">
    									<label class="col-md-3">Meta Title</label>
    									<div class="col-md-9"><textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="state_meta_title" id="state_meta_title"><?php echo $state_meta_title; ?></textarea>
    									</div></div>
    							</div>
    							<div class="col-md-12"> 
    								<div class="form-group">
    									<label class="col-md-3">Meta Keywords</label>
    									<div class="col-md-9">	<textarea name="state_meta_keywords" id="state_meta_keywords"  placeholder="Meta Keywords..." class="form-control textarea1"><?php echo $state_meta_keywords; ?></textarea>
    							</div>	</div>
    							</div>
    							
    							<div class="clearfix"></div>
    							
    							<div class="col-md-12"> 
    								<div class="form-group">
    								<label class="col-md-3">Meta Description</label>
    								  	<div class="col-md-9"><textarea name="state_meta_description" id="state_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea"><?php echo $state_meta_description; ?></textarea>
    								</div></div>
    							</div>
                            <div class="clearfix"></div>
                        </div> 

				    <div class="chkbx-inner">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="checkbox checkbox-info">
                                    <input name="showmenu1" id="showmenu1" type="checkbox" value="1" <?php if($showmenu==1) { echo "checked=checked";}?>>
                                    <label for="showmenu1"><strong>Show this state on menu<strong></label>
                                </div>
                            </div>
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

		<script>
    $(document.body).on('keyup change', '#state_names', function() {
        $("#state_urls").val(name_to_url($(this).val()));
    });
    function name_to_url(name) {
        name = name.toLowerCase(); // lowercase
        name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
        name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
        name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
        return name;
    }
    </script>

	<?php
		}
		exit();
	}
	
}