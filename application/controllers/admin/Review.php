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

	// public function datatable1(){
	// 	$arrPageData = $_REQUEST;
	// 	$reviewer_name = isset($arrPageData['reviewer_name']) ? $arrPageData['reviewer_name'] : "";
	// 	$reviewer_loc = isset($arrPageData['reviewer_loc']) ? $arrPageData['reviewer_loc'] : "";
	// 	$ratings = isset($arrPageData['ratings']) ? $arrPageData['ratings'] : 0;
	// 	$whereCond = '';
	// 	if($reviewer_name != ''){
	// 		$whereCond .= "(reviewer_name like '%".$reviewer_name."%') and ";
	// 	}
	// 	if($reviewer_loc != ''){
	// 		$whereCond .= "(reviewer_loc like '%".$reviewer_loc."%') and ";
	// 	}
	// 	if($ratings > 0){
	// 		$whereCond .= "no_of_star = $ratings and ";
	// 	}
	// 	$whereCond = rtrim($whereCond, " and ");
	// 	$joinCond = "LEFT JOIN tbl_menutags 
	// 	ON FIND_IN_SET(tbl_menutags.tagid, tbl_reviews.tourtagid) > 0";

	// 	// $rowCnt = $this->Common_model->get_records("review_id", "tbl_reviews $joinCond", "$whereCond");
	// 	$sql = "SELECT DISTINCT review_id FROM tbl_reviews $joinCond";
	// 			if (!empty($whereCond)) {
	// 				$sql .= " WHERE $whereCond";
	// 			}

	// 	$query = $this->db->query($sql);
	// 	$rowCnt = $query->num_rows();
	// 	// if ($arrPageData['length'] == -1) {
	// 	// 	$rows = $this->Common_model->get_records("*","tbl_reviews $joinCond","$whereCond", " review_id DESC","tbl_reviews.review_id");
	// 	// } else {
	// 	// 	$rows = $this->Common_model->get_records("*","tbl_reviews $joinCond","$whereCond", " review_id DESC",$arrPageData['length'], $arrPageData['start']);
	// 	// }
	// 	if ($arrPageData['length'] == -1) {
	// 		$rows = $this->Common_model->get_records("*", "tbl_reviews $joinCond", "$whereCond", " review_id DESC", "tbl_reviews.review_id GROUP BY tbl_reviews.review_id");
	// 	} else {
	// 		$rows = $this->Common_model->get_records("*", "tbl_reviews $joinCond", "$whereCond", " review_id DESC", $arrPageData['length'], $arrPageData['start'], "tbl_reviews.review_id GROUP BY tbl_reviews.review_id");
	// 	}
	// 	// foreach ($rows as $row) {
	// 	// 	$reviewId = $row['review_id'];
		
	// 	// 	if (!isset($groupedRows[$reviewId])) {
	// 	// 		// Initialize a new entry
	// 	// 		$groupedRows[$reviewId] = $row;
	// 	// 		$groupedRows[$reviewId]['tag_name'] = !empty($row['tag_name']) ? $row['tag_name'] : "--";
	// 	// 	} else {
	// 	// 		// Concatenate tag_name and cat_name if multiple tags/categories exist for the same review_id
	// 	// 		if (!empty($row['tag_name'])) {
	// 	// 			$groupedRows[$reviewId]['tag_name'] .= ", " . $row['tag_name'];
	// 	// 		}
	// 	// 	}
	// 	// }
	// 	// $rows = array_values($groupedRows);
	// 	// print_r($rows);exit;
	// 	if(!empty($rows) && count((array)$rows) > 0) {
	// 		foreach ($rows as $key => $val) {
	// 			$rows[$key]['sl_no'] = ++$arrPageData['start'];
	// 			$no_of_star = $rows[$key]['no_of_star'];
	// 			$star_field = "";
	// 			$rows[$key]['tag_name'] = !empty($rows[$key]['tag_name']) ? $rows[$key]['tag_name'] : "--";
	// 			// $rows[$key]['cat_name'] = !empty($rows[$key]['cat_name']) ? $rows[$key]['cat_name'] : "--";
	// 			$rows[$key]['feedback_msg'] = $this->Common_model->short_str($rows[$key]['feedback_msg'], 140);
	// 			$rows[$key]['created_date'] = $this->Common_model->dateformat($rows[$key]['created_date']);
				
	// 			for ($x = 1; $x <= $no_of_star; $x++) {
	// 				$star_field .= '<i class="fa fa-star"></i> ';
	// 			}
	// 			if (fmod($no_of_star, 1) !== 0.00) {
	// 				$star_field .= '<i class="fa fa-star-half-o"></i> ';
	// 				$x++;
	// 			}
	// 			while ($x <= 5) {
	// 				$star_field .= '<i class="fa fa-star-o"></i> ';
	// 				$x++;
	// 			}
	// 			$star_field .= "</br>(".$no_of_star." Star)";
	// 			$rows[$key]['star_field'] = $star_field;
	// 		}
	// 	}
	
	// 	echo json_encode([
    //         'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
    //         'recordsTotal' => $rowCnt,
    //         'recordsFiltered' => $rowCnt, // For simplicity, assuming no filtering
    //         'data' => $rows
    //     ]);
	// 	exit;
	// }

	public function datatable() {
		$arrPageData = $_REQUEST;
		$reviewer_name = isset($arrPageData['reviewer_name']) ? $arrPageData['reviewer_name'] : "";
		$reviewer_loc = isset($arrPageData['reviewer_loc']) ? $arrPageData['reviewer_loc'] : "";
		$ratings = isset($arrPageData['ratings']) ? $arrPageData['ratings'] : 0;
	
		// Build WHERE conditions
		$whereCond = '';
		if ($reviewer_name != '') {
			$whereCond .= "(tbl_reviews.reviewer_name LIKE '%" . $reviewer_name . "%') AND ";
		}
		if ($reviewer_loc != '') {
			$whereCond .= "(tbl_reviews.reviewer_loc LIKE '%" . $reviewer_loc . "%') AND ";
		}
		if ($ratings > 0) {
			$whereCond .= "tbl_reviews.no_of_star = $ratings AND ";
		}
		$whereCond = rtrim($whereCond, " AND ");
	
		// Define JOIN condition
		$joinCond = "LEFT JOIN tbl_menutags 
					 ON FIND_IN_SET(tbl_menutags.tagid, tbl_reviews.tourtagid) > 0";
	
		// Fetch total record count (without pagination)
		$sql = "SELECT COUNT(DISTINCT tbl_reviews.review_id) AS total FROM tbl_reviews $joinCond";
		if (!empty($whereCond)) {
			$sql .= " WHERE $whereCond";
		}
		$query = $this->db->query($sql);
		$rowCnt = $query->row()->total;
	
		// Fetch paginated records with grouped tag names
		$sql = "SELECT tbl_reviews.review_id, 
					   tbl_reviews.reviewer_name, 
					   tbl_reviews.reviewer_loc, 
					   tbl_reviews.no_of_star, 
					   tbl_reviews.feedback_msg, 
					   tbl_reviews.created_date,
					   tbl_reviews.status,
					   GROUP_CONCAT(DISTINCT tbl_menutags.tag_name ORDER BY tbl_menutags.tag_name SEPARATOR ', ') AS tag_name
				FROM tbl_reviews 
				$joinCond";
	
		if (!empty($whereCond)) {
			$sql .= " WHERE $whereCond";
		}
	
		$sql .= " GROUP BY tbl_reviews.review_id ORDER BY tbl_reviews.review_id DESC";
	
		// Apply pagination
		if ($arrPageData['length'] != -1) {
			$sql .= " LIMIT " . intval($arrPageData['start']) . ", " . intval($arrPageData['length']);
		}
	
		$query = $this->db->query($sql);
		$rows = $query->result_array();
	
		// Process each row to format data
		foreach ($rows as $key => $val) {
			$rows[$key]['sl_no'] = $arrPageData['start'] + $key + 1;
			$no_of_star = $rows[$key]['no_of_star'];
			$star_field = "";
	
			// Ensure tag_name is set
			$rows[$key]['tag_name'] = !empty($rows[$key]['tag_name']) ? $rows[$key]['tag_name'] : "--";
	
			// Format feedback message and date
			$rows[$key]['feedback_msg'] = $this->Common_model->short_str($rows[$key]['feedback_msg'], 140);
			$rows[$key]['created_date'] = $this->Common_model->dateformat($rows[$key]['created_date']);
	
			// Create star rating display
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
			$star_field .= "</br>(" . $no_of_star . " Star)";
			$rows[$key]['star_field'] = $star_field;
		}
	
		// Return JSON response
		echo json_encode([
			'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
			'recordsTotal' => $rowCnt,
			'recordsFiltered' => $rowCnt, // Since filtering is done manually
			'data' => $rows
		]);
		exit;
	}
	
	public function validate_array($input)
	{
		if (empty($input)) {
			$this->form_validation->set_message('validate_array', 'The associated tour tags field is required.');
			return false;
		}
		return true;
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
			$this->form_validation->set_rules('getatagid[]', 'CategoryTags', 'callback_validate_array');
			

			if ($this->form_validation->run() == true)
			{  
				$reviewer_name 		= $this->input->post('reviewer_name');
				$reviewer_loc 		= $this->input->post('reviewer_loc');            
				$no_of_star 		= $this->input->post('no_of_star');
				$feedback_msg 		= $this->input->post('feedback_msg');
				$date 				= date("Y-m-d H:i:s");
				$tourtagid 		    = implode(',', $this->input->post('getatagid'));
				
				
				$noof_duprec = $this->Common_model->noof_records("reviewer_name","tbl_reviews","reviewer_name = '$reviewer_name'");
													
					if($noof_duprec < 1)	{	
				
								$insert_data = array(
									'reviewer_name'     => $reviewer_name,
									'reviewer_loc'      => $reviewer_loc,
									'no_of_star'        => $no_of_star,
									'feedback_msg'      => $feedback_msg,
									'created_date'      => $date,
									'status'            => 1,
									'tourtagid' 		=> $tourtagid
								);  
									$insertdb = $this->Common_model->insert_records('tbl_reviews', $insert_data);
									
									if($insertdb) {
										
										$this->session->set_flashdata('messageadd','<div class="successmsg notification"><i class="fa fa-check"></i> Review added successfully to destination.</div>');
									} else {
										$this->session->set_flashdata('messageadd','<div class="errormsg notification"><i class="fa fa-times"></i> Review could not added. Please try again.</div>');
									}
							} else  {
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
			$this->form_validation->set_rules('getatagid[]', 'CategoryTags', 'callback_validate_array');
			
			if ($this->form_validation->run() == true)
			{		
				$reviewer_name 			= $this->input->post('reviewer_name');
				$reviewer_loc 			= $this->input->post('reviewer_loc');				
				$no_of_star 			= $this->input->post('no_of_star');	
				$feedback_msg 			= $this->input->post('feedback_msg');	
				$date					= date("Y-m-d H:i:s");
				$tourtagid 		    	= implode(',', $this->input->post('getatagid'));
				
				$noof_duprec = $this->Common_model->noof_records("reviewer_name","tbl_reviews","reviewer_name = '$reviewer_name' and  review_id!='$editid'");
				
				
				
				
				if($noof_duprec < 1)
				{
					$date = date("Y-m-d H:i:s");
					$update_data = array(
						'reviewer_name'		=> $reviewer_name,
						'reviewer_loc'		=> $reviewer_loc,
						'no_of_star'	    => $no_of_star,
						'feedback_msg'	    => $feedback_msg,
						'created_date'		=> $date,
						'tourtagid' 		=> $tourtagid			
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
