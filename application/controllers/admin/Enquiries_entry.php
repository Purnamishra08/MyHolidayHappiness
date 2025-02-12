<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Enquiries_entry extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url', 'form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		$this->load->model('Common_model');

		if ($this->session->userdata('userid') == "") {
			redirect(base_url() . 'admin/logout', 'refresh');
		}

		$allusermodules = $this->session->userdata('allpermittedmodules');
		if (!(in_array(20, $allusermodules))) {
			redirect(base_url() . 'admin/dashboard', 'refresh');
		}
	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['row'] = $this->Common_model->get_records("*","tbl_destination","", " destination_id DESC","","");
		$this->load->view('admin/manage_enquiries_entry', $data);
	}

	public function datatable()
	{
		$arrPageData = $_REQUEST;
		$customer_name = isset($arrPageData['customer_name']) ? $arrPageData['customer_name'] : "";
		$enquiry_number = isset($arrPageData['enquiry_number']) ? $arrPageData['enquiry_number'] : "";
		$email_address = isset($arrPageData['email_address']) ? $arrPageData['email_address'] : "";
		$phone_number = isset($arrPageData['phone_number']) ? $arrPageData['phone_number'] : "";
		$t_status = isset($arrPageData['t_status']) ? $arrPageData['t_status'] : 0;
		$assign_to = isset($arrPageData['assign_to']) ? $arrPageData['assign_to'] : 0;
		$from_date = isset($arrPageData['from_date']) && $arrPageData['from_date'] != "" ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['from_date']))) : "";
		$to_date = isset($arrPageData['to_date']) && $arrPageData['to_date'] != "" ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['to_date']))) : "";
		$whereCond = '';
		if ($customer_name != '') {
			$whereCond .= "(customer_name like '%" . $customer_name . "%') and ";
		}
		if ($enquiry_number != '') {
			$whereCond .= "(inquiry_number like '%" . $enquiry_number . "%') and ";
		}
		if ($email_address != '') {
			$whereCond .= "(email_address like '%" . $email_address . "%') and ";
		}
		if ($phone_number != '') {
			$whereCond .= "(phone_number like '%" . $phone_number . "%') and ";
		}

		if ($t_status > 0) {
			$whereCond .= "status_id = $t_status and ";
		}
		if ($assign_to > 0) {
			$whereCond .= "assign_to = $assign_to and ";
		}

		if ($from_date != "" && $to_date != "") {
			$whereCond .= "(date(created_at) between '" . $from_date . "' and '" . $to_date . "') and ";
		}

		// if ($this->session->userdata('usertype') != 1) {
		// 	$sess_userid = $this->session->userdata('userid');
		// 	$whereCond .= "assign_to = $sess_userid and ";
		// }
		$whereCond = rtrim($whereCond, " and ");

		$rowCnt = $this->Common_model->noof_records("id", "tbl_inquiries", "$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*", "tbl_inquiries", "$whereCond", " id DESC");
		} else {
			$rows = $this->Common_model->get_records("*", "tbl_inquiries", "$whereCond", " id DESC", $arrPageData['length'], $arrPageData['start']);
		}

		if (!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];
				$status_id = $rows[$key]['status_id'];
				$created_by = $rows[$key]['created_by'];
				$created_at = $rows[$key]['created_at'];
				$rows[$key]['created_by'] = $this->Common_model->showname_fromid("admin_name", "tbl_admin", "adminid='$created_by'");
				$rows[$key]['created_at'] = $this->Common_model->dateformat($created_at);
				$rows[$key]['status'] = $this->Common_model->showname_fromid("name", "tbl_statuses", "id='$status_id'");
			}
		}

		echo json_encode([
			'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
			'recordsTotal' => $rowCnt,
			'whereCond' => $whereCond,
			'recordsFiltered' => $rowCnt, // For simplicity, assuming no filtering
			'data' => $rows
		]);
		exit;
	}

	public function add()
	{
		$data['message'] = $this->session->flashdata('message');

		if (isset($_POST['btnSubmit']) && !empty($_POST)) {
			$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('source_id', 'Source', 'trim|required|xss_clean');
			$this->form_validation->set_rules('status_id', 'Status', 'trim|required|xss_clean');
			$this->form_validation->set_rules('trip_name', 'Trip Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('trip_start_date', 'Trip Start Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('follow_up_date', 'Follow up Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('no_of_travellers', 'No. of Travellers', 'trim|required|xss_clean');
			$this->form_validation->set_rules('comment', 'comment', 'trim|required|xss_clean');

			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true) {
				$customer_name 		= $this->input->post('customer_name');
				$email_address 		= $this->input->post('email_address');
				$phone_number 	= $this->input->post('phone_number');
				$source_id = $this->input->post('source_id');
				$status_id		= $this->input->post('status_id');
				$trip_name 	= $this->input->post('trip_name');
				$trip_start_date      = $this->input->post('trip_start_date');
				$follow_up_date      = $this->input->post('follow_up_date');
				$no_of_travellers      = $this->input->post('no_of_travellers');
				$comment      = $this->input->post('comment');
				$c_trip_start_date 		= date('Y-m-d H:i:s', strtotime($trip_start_date));
				$c_follow_up_date 		= date('Y-m-d H:i:s', strtotime($follow_up_date));

				$insert_data = array(
					'customer_name' => $customer_name,
					'email_address' => $email_address,
					'phone_number' => $phone_number,
					'source_id' => $source_id,
					'status_id' => $status_id,
					'trip_name' => $trip_name,
					'trip_start_date' => $c_trip_start_date,
					'followup_date' => $c_follow_up_date,
					'travellers_count' => $no_of_travellers,
					'comments' => $comment,
					'assign_to' => $sess_userid,
					'created_by' => $sess_userid,
					'updated_by' => $sess_userid,
					'created_at' => $date
				);

				$insertdb = $this->Common_model->insert_records('tbl_inquiries', $insert_data);
				if ($insertdb) {
					$last_id = $this->db->insert_id();
					$enquiry_no = 'INQ' . str_pad($last_id, '5', "0", STR_PAD_LEFT);
					$update_data = array(
						'inquiry_number' => $enquiry_no
					);
					$this->Common_model->update_records('tbl_inquiries', $update_data, "id=$last_id");

					$insert_data = array(
						'inquiries_id' => $last_id,
						'customer_name' => $customer_name,
						'email_address' => $email_address,
						'phone_number' => $phone_number,
						'source_id' => $source_id,
						'status_id' => $status_id,
						'trip_name' => $trip_name,
						'trip_start_date' => $c_trip_start_date,
						'followup_date' => $c_follow_up_date,
						'travellers_count' => $no_of_travellers,
						'comments' => $comment,
						'inquiry_number' => $enquiry_no,
						'assign_to' => $sess_userid,
						'created_by' => $sess_userid,
						'updated_by' => $sess_userid,
						'created_at' => $date,
						'updated_at' => $date
					);

					$this->Common_model->insert_records('tbl_inquiries_log', $insert_data);

					$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Enquiry added successfully.</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Enquiry could not added. Please try again.</div>');
				}

				redirect(base_url() . 'admin/enquiries-entry/add', 'refresh');
			} else {
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('admin/add_enquiries_entry', $data);
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("id", "tbl_inquiries", "id='$editid' ");
		if ($noof_rec > 0) {
			$data['message'] = $this->session->flashdata('message');
			$data['row'] = $this->Common_model->get_records("*", "tbl_inquiries", "id='$editid'", "");
			if (isset($_POST['btnSubmit']) && !empty($_POST)) {
				$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|xss_clean');
				$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
				$this->form_validation->set_rules('source_id', 'Source', 'trim|required|xss_clean');
				$this->form_validation->set_rules('status_id', 'Status', 'trim|required|xss_clean');
				$this->form_validation->set_rules('trip_name', 'Trip Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('trip_start_date', 'Trip Start Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('follow_up_date', 'Follow up Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('no_of_travellers', 'No. of Travellers', 'trim|required|xss_clean');
				$this->form_validation->set_rules('comment', 'comment', 'trim|required|xss_clean');

				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true) {
					$inquiry_number 		= $this->input->post('inquiry_number');
					$customer_name 		= $this->input->post('customer_name');
					$email_address 		= $this->input->post('email_address');
					$phone_number 	= $this->input->post('phone_number');
					$source_id = $this->input->post('source_id');
					$status_id		= $this->input->post('status_id');
					$trip_name 	= $this->input->post('trip_name');
					$trip_start_date      = $this->input->post('trip_start_date');
					$follow_up_date      = $this->input->post('follow_up_date');
					$no_of_travellers      = $this->input->post('no_of_travellers');
					$comment      = $this->input->post('comment');
					$c_trip_start_date 		= date('Y-m-d H:i:s', strtotime($trip_start_date));
					$c_follow_up_date 		= date('Y-m-d H:i:s', strtotime($follow_up_date));

					$update_data = array(
						'customer_name' => $customer_name,
						'email_address' => $email_address,
						'phone_number' => $phone_number,
						'source_id' => $source_id,
						'status_id' => $status_id,
						'trip_name' => $trip_name,
						'trip_start_date' => $c_trip_start_date,
						'followup_date' => $c_follow_up_date,
						'travellers_count' => $no_of_travellers,
						'comments' => $comment,
						'updated_by' => $sess_userid,
						'updated_at' => $date
					);

					$updatedb = $this->Common_model->update_records('tbl_inquiries', $update_data, "id=$editid");
					if ($updatedb) {
						$insert_data = array(
							'inquiries_id' => $editid,
							'customer_name' => $customer_name,
							'email_address' => $email_address,
							'phone_number' => $phone_number,
							'source_id' => $source_id,
							'status_id' => $status_id,
							'trip_name' => $trip_name,
							'trip_start_date' => $c_trip_start_date,
							'followup_date' => $c_follow_up_date,
							'travellers_count' => $no_of_travellers,
							'comments' => $comment,
							'inquiry_number' => $inquiry_number,
							'created_by' => $sess_userid,
							'updated_by' => $sess_userid,
							'created_at' => $date,
							'updated_at' => $date
						);

						$this->Common_model->insert_records('tbl_inquiries_log', $insert_data);

						$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Enquiry edited successfully.</div>');
					} else {
						$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Enquiry could not edited. Please try again.</div>');
					}

					redirect(base_url() . 'admin/enquiries-entry/edit/' . $editid, 'refresh');
				} else {
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_enquiries_entry', $data);
		} else
			redirect(base_url() . 'admin/enquiries-entry', 'refresh');
	}

	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("id", "tbl_inquiries", "id='$delid'");
		if ($noof_rec > 0) {
			$del = $this->Common_model->delete_records("tbl_inquiries", "id=$delid");

			if ($del) {
				$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Enquiry has been deleted successfully.</div>');
			} else {
				$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Enquiry could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url() . 'admin/enquiries-entry', 'refresh');
	}

	public function view()
	{
		$viewid = $this->uri->segment(4);
		$rows = $this->Common_model->get_records("*", "tbl_inquiries", "id='$viewid'", "", "", "");
		$rows_log = $this->Common_model->get_records("*", "tbl_inquiries_log", "inquiries_id='$viewid'", "", "", "");
		if (!empty($rows)) {
			foreach ($rows as $row) {
				$customer_name = $row['customer_name'];
				$email_address = $row['email_address'];
				$phone_number = $row['phone_number'];
				$source_id = $row['source_id'];
				$trip_name = $row['trip_name'];
				$inquiry_number = $row['inquiry_number'];
				$created_by = $row['created_by'];
				$created_at = date('m/d/Y', strtotime($row['created_at']));
				$source_name = $this->Common_model->showname_fromid("name", "tbl_sources", "id='$source_id'");
				$created_name = $this->Common_model->showname_fromid("admin_name", "tbl_admin", "adminid='$created_by'");
				$status_id = $row['status_id'];
				$status_name = $this->Common_model->showname_fromid("name", "tbl_statuses", "id='$status_id'");
				$trip_start_date = $this->Common_model->dateformat($row['trip_start_date']);
				$followup_date = $this->Common_model->dateformat($row['followup_date']);				
				$travellers_count = $row['travellers_count'];
				$comments = $row['comments'];
			}

?>
			<div class="modal-header">
				<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
				<h4 class="modal-title pupop-title">Enquiry Details (<?php echo $inquiry_number; ?>)</h4>
			</div>
			<div class="modal-body">
				<div class="modal-sub-body">
					<div class="row">

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Customer Name : </label></div>
								<div class="col-md-8"> <?php echo $customer_name; ?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Source : </label></div>
								<div class="col-md-8"> <?php echo $source_name; ?></div>
							</div>
						</div>						

						<div class="clearfix"></div>	
						
						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Email Address : </label></div>
								<div class="col-md-8"> <?php echo $email_address; ?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Phone Number : </label></div>
								<div class="col-md-8"> <?php echo $phone_number; ?></div>
							</div>
						</div>						

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Trip Start Date : </label></div>
								<div class="col-md-8"> <?php echo $trip_start_date; ?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> No. of Travellers : </label></div>
								<div class="col-md-8"> <?php echo $travellers_count; ?></div>
							</div>
						</div>
						
						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Status : </label></div>
								<div class="col-md-8"> <?php echo $status_name; ?></div>
							</div>
						</div>		

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Follow Up Date : </label></div>
								<div class="col-md-8"> <?php echo $followup_date; ?></div>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Trip Name : </label></div>
								<div class="col-md-8"> <?php echo $trip_name; ?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Comment : </label></div>
								<div class="col-md-8"> <?php echo $comments; ?></div>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Created By : </label></div>
								<div class="col-md-8"> <?php echo $created_name; ?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Created On : </label></div>
								<div class="col-md-8"> <?php echo $created_at; ?></div>
							</div>
						</div>

						<div class="clearfix"></div>

						<?php
							if (!empty($rows_log)) {							
						?>
						<div class="col-md-12">
							<h3>Previous Followup(s)</h3>
							<table class="table table-bordered table-striped">
								<tr>	
									<th>Updated Date</th>									
									<th>Status</th>
									<th>Trip Details</th>
									<th>Comments :</th>		
									<th>Followup Date</th>						
									<th>Updated By</th>									
								</tr>
								<?php
									foreach ($rows_log as $row_log) {
										$status_id = $row_log['status_id'];
										$updated_by = $row_log['updated_by'];
										$trip_start_date = $this->Common_model->dateformat($row_log['trip_start_date']);
										$followup_date = $this->Common_model->dateformat($row_log['followup_date']);
										$travellers_count = $row_log['travellers_count'];
										$comments = $row_log['comments'];
										$updated_at = $this->Common_model->dateformat($row_log['updated_at']);
										$status_name = $this->Common_model->showname_fromid("name", "tbl_statuses", "id='$status_id'");
										$updated_name = $this->Common_model->showname_fromid("admin_name", "tbl_admin", "adminid='$updated_by'");
								?>
								<tr>	
									<td><?php echo $updated_at; ?></td>		
									<td><?php echo $status_name; ?></td>
									<td>
										Trip Start Date : <?php echo $trip_start_date; ?><br>
										No. of Travellers : <?php echo $travellers_count; ?>
									</td>
									<td><?php echo $comments; ?></td>		
									<td><?php echo $followup_date; ?></td>						
									<td><?php echo $updated_name; ?></td>									
								</tr>
								<?php } ?>
							</table>
						</div>
						<?php } ?>
						<!-- <div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Trip Start Date : </label></div>
								<div class="col-md-8"> <?php //echo $trip_start_date; 
														?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Followup Date : </label></div>
								<div class="col-md-8"> <?php //echo $followup_date; 
														?></div>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> No. of Travellers : </label></div>
								<div class="col-md-8"> <?php //echo $travellers_count; 
														?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Status : </label></div>
								<div class="col-md-8"> <?php //echo $status_name; 
														?></div>
							</div>
						</div>


						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Last Updated By : </label></div>
								<div class="col-md-8"> <?php //echo $updated_name; 
														?></div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Last Updated On : </label></div>
								<div class="col-md-8"> <?php //echo $updated_at; 
														?></div>
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Comments : </label></div>
								<div class="col-md-8"> <?php //echo $comments; 
														?></div>
							</div>
						</div> -->

					</div>
				</div>
				<div class="clearfix"></div>
			</div>
<?php
		}
	}
}
