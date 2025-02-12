<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {
	
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
		if(!(in_array(13, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}
 	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['row'] = $this->Common_model->get_records("*","tbl_reviews","","review_id desc","","");
		$this->load->view('admin/manage_review', $data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$reviewer_name = isset($arrPageData['reviewer_name']) ? $arrPageData['reviewer_name'] : "";
		$reviewer_loc = isset($arrPageData['reviewer_loc']) ? $arrPageData['reviewer_loc'] : "";
		$ratings = isset($arrPageData['ratings']) ? $arrPageData['ratings'] : 0;
		$whereCond = '';
		if($reviewer_name != ''){
			$whereCond .= "(reviewer_name like '%".$reviewer_name."%') and ";
		}
		if($reviewer_loc != ''){
			$whereCond .= "(reviewer_loc like '%".$reviewer_loc."%') and ";
		}
		if($ratings > 0){
			$whereCond .= "no_of_star = $ratings and ";
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("review_id","tbl_reviews","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_reviews","$whereCond", " review_id DESC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_reviews","$whereCond", " review_id DESC",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];
				$no_of_star = $rows[$key]['no_of_star'];
				$star_field = "";
				$rows[$key]['feedback_msg'] = $this->Common_model->short_str($rows[$key]['feedback_msg'], 140);
				$rows[$key]['created_date'] = $this->Common_model->dateformat($rows[$key]['created_date']);
				
				for ($x = 1; $x <= $no_of_star; $x++) {
					$star_field .= '<i class="fa fa-star"></i> ';
				}
				if (fmod($no_of_star, 1) !== 0.00) {
					$star_field .= '<i class="fa fa-star-half-o"></i> ';
					$x++;
				}
				while ($x <= 5) {
					$star_field .= '<i class="fa fa-star-o"></i> ';
					$x++;
				}
				$star_field .= "</br>(".$no_of_star." Star)";
				$rows[$key]['star_field'] = $star_field;
			}
		}
	
		echo json_encode([
            'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
            'recordsTotal' => $rowCnt,
            'recordsFiltered' => $rowCnt, // For simplicity, assuming no filtering
            'data' => $rows
        ]);
		exit;
	}
	
	public function add()
	{
		$data['messageadd'] = $this->session->flashdata('messageadd');
					
		if (isset($_POST['btnSubmitPlace']) && !empty($_POST))
		{
			$this->form_validation->set_rules('reviewer_name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('reviewer_loc', 'Location', 'trim|required|xss_clean');						
			$this->form_validation->set_rules('no_of_star', 'Ratings', 'trim|required|xss_clean');
			$this->form_validation->set_rules('feedback_msg', 'Feedback', 'trim|required|xss_clean');
			

			if ($this->form_validation->run() == true)
			{	
				$reviewer_name = $this->input->post('reviewer_name');
				$reviewer_loc = $this->input->post('reviewer_loc');				
				$no_of_star = $this->input->post('no_of_star');	
				$feedback_msg = $this->input->post('feedback_msg');	
				$date = date("Y-m-d H:i:s");
				
				
				$noof_duprec = $this->Common_model->noof_records("reviewer_name","tbl_reviews","reviewer_name = '$reviewer_name'");
													
					if($noof_duprec < 1)	{	
				
								$insert_data = array(
									'reviewer_name'		=> $reviewer_name,
									'reviewer_loc'		=> $reviewer_loc,
									'no_of_star'	    => $no_of_star,
									'feedback_msg'	    => $feedback_msg,
									'created_date'		=> $date,				
									'status'			=> 1					
								);	
									$insertdb = $this->Common_model->insert_records('tbl_reviews', $insert_data);
									
									if($insertdb) {
										
										$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Review added successfully to destination.</div>');
									} else {
										$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Review could not added. Please try again.</div>');
									}
							} else	{
									$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this review.</div>');
							}
								redirect(base_url().'admin/review/add','refresh');
					}
					else
					{
						$data['messageadd'] = (validation_errors() ? validation_errors() : $this->session->flashdata('messageadd'));
					}
		}
		
		$this->load->view('admin/add_review',$data);
	}


	public function delete_rvw()	
	{		
        $delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("review_id","tbl_reviews","review_id='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_reviews","review_id=$delid");
			if($del){

				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i>Review has been deleted successfully.</div>');				
			}
			else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>Review could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/review','refresh');		
	}
	

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$data['message'] = $this->session->flashdata('message');
		$noof_rec = $this->Common_model->noof_records("review_id","tbl_reviews","review_id='$editid'");
		if($noof_rec > 0)
		{
		$data['editplace'] = $this->Common_model->get_records("*","tbl_reviews","review_id='$editid'");
			
		}
				
		if (isset($_POST['btnEditReview']) && !empty($_POST))
		{			
			$this->form_validation->set_rules('reviewer_name', 'Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('reviewer_loc', 'Location', 'trim|required|xss_clean');						
			$this->form_validation->set_rules('no_of_star', 'Ratings', 'trim|required|xss_clean');
			$this->form_validation->set_rules('feedback_msg', 'Feedback', 'trim|required|xss_clean');

			
			if ($this->form_validation->run() == true)
			{		
				$reviewer_name = $this->input->post('reviewer_name');
				$reviewer_loc = $this->input->post('reviewer_loc');				
				$no_of_star = $this->input->post('no_of_star');	
				$feedback_msg = $this->input->post('feedback_msg');	
				$date = date("Y-m-d H:i:s");
				
				$noof_duprec = $this->Common_model->noof_records("reviewer_name","tbl_reviews","reviewer_name = '$reviewer_name' and  review_id!='$editid'");
				
				
				
				
				if($noof_duprec < 1)
				{
					$date = date("Y-m-d H:i:s");
					$update_data = array(
						'reviewer_name'		=> $reviewer_name,
						'reviewer_loc'		=> $reviewer_loc,
						'no_of_star'	    => $no_of_star,
						'feedback_msg'	    => $feedback_msg,
						'created_date'		=> $date			
					);	
						
					
				$querydb = $this->Common_model->update_records('tbl_reviews',$update_data,"review_id=$editid");
				if($querydb){
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Review edited successfully.</div>');
				}
				else{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Review could not edited. Please try again.</div>');
				}
			}

			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> You have already added this Review. </div>');
				
			
			}
				redirect(base_url().'admin/review/edit/'.$editid,'refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
			
			
		}
		$this->load->view('admin/edit_review',$data);
		
	}
	

	public function view_pop() 
	{
        $viewid = $this->uri->segment(4);
        $rows1 = $this->Common_model->get_records("*","tbl_reviews","review_id='$viewid'","","","");
        if (!empty($rows1)) {
            foreach ($rows1 as $rowss1) {
            $review_id = $rowss1['review_id'];
            $reviewer_loc = $rowss1['reviewer_loc'];
            $no_of_star = $rowss1['no_of_star'];
            $feedback_msg = $rowss1['feedback_msg'];
        	}
        ?>
        <div class="modal-header">
			<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
			<h4 class="modal-title pupop-title">Review Details</h4>
		</div>
		<div class="modal-body">
			<div class="">
				<div class="row">

					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>  Name : </label></div>
							<div class="col-md-8"> <?php echo $rowss1['reviewer_name']; ?></div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>  Location :  </label></div>
							<div class="col-md-8"> <?php echo ucfirst($reviewer_loc); ?></div>
						</div>
					</div>					
					<div class="clearfix"></div>
					
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label>No of Stars : </label></div>
							<div class="col-md-8"> 
								
								<?php
									for ($x = 1; $x <= $no_of_star; $x++) {
										echo '<i class="fa fa-star"></i> ';
									}
									if (fmod($no_of_star, 1) !== 0.00) {
										echo '<i class="fa fa-star-half-o"></i> ';
										$x++;
									}
									while ($x <= 5) {
										echo '<i class="fa fa-star-o"></i> ';
										$x++;
									}
								?>	
									</br>
								    (<?php echo $no_of_star.' Star'; ?>)
								
								
							  
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> Feedback : </label></div>
							<div class="col-md-8"> <?php echo $feedback_msg ;?>  </div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="gap row">
							<div class="col-md-4"> <label> date  : </label></div>
							<div class="col-md-8"><?php echo $this->Common_model->dateformat($rowss1['created_date']); ?></div>
						</div>
					</div>
					
					
					
					
					<div class="clearfix"></div>
								  
				</div>
			</div>
			<div class="clearfix"></div>
		</div>            
		<?php
		}	
	}


	public function changestatus() {
        $stsid = $this->uri->segment(4);
        $noof_rec = $this->Common_model->noof_records("review_id", "tbl_reviews", "review_id='$stsid'");
        if ($noof_rec > 0) {
            $status = $this->Common_model->showname_fromid("status", "tbl_reviews", "review_id=$stsid");
            if ($status == 1)
                $updatedata = array('status' => 0);
            else
                $updatedata = array('status' => 1);
            $updatestatus = $this->Common_model->update_records("tbl_reviews", $updatedata, "review_id=$stsid");

            if ($updatestatus)
                echo $status;
            else
                echo "error";
        }
        exit();
    }
	
}
