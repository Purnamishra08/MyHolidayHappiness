<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Enquiries_report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url', 'form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->load->library('csv');
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
				$editid 		= $this->input->post('editid');
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
					'status_id' => $status_id,
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

				redirect(base_url() . 'admin/enquiries-report', 'refresh');
			} else {
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		if (isset($_POST['btnSubmitAssignTo']) && !empty($_POST)) {
			$this->form_validation->set_rules('assign_to', 'Assign To', 'trim|required|xss_clean');

			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true) {
				$editid 		= $this->input->post('editid');
				$assign_to 		= $this->input->post('assign_to');

				$update_data = array(
					'assign_to' => $assign_to,
					'updated_by' => $sess_userid,
					'updated_at' => $date
				);

				$updatedb = $this->Common_model->update_records('tbl_inquiries', $update_data, "id=$editid");
				if ($updatedb) {
					$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Assign to changed successfully.</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Assign to could not changed. Please try again.</div>');
				}

				redirect(base_url() . 'admin/enquiries-report', 'refresh');
			} else {
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('admin/manage_enquiries_report', $data);
	}

	public function datatable()
	{
		$arrPageData = $_REQUEST;
		$customer_name = isset($arrPageData['customer_name']) ? $arrPageData['customer_name'] : "";
		$phone_number = isset($arrPageData['phone_number']) ? $arrPageData['phone_number'] : "";
		$assign_to = isset($arrPageData['assign_to']) ? $arrPageData['assign_to'] : 0;
		$from_date = isset($arrPageData['from_date']) && $arrPageData['from_date'] != "" ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['from_date']))) : "";
		$to_date = isset($arrPageData['to_date']) && $arrPageData['to_date'] != "" ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['to_date']))) : "";
		$whereCond = '';
		if ($customer_name != '') {
			$whereCond .= "(customer_name like '%" . $customer_name . "%') and ";
		}
		if ($phone_number != '') {
			$whereCond .= "(phone_number like '%" . $phone_number . "%') and ";
		}
		if ($assign_to > 0) {
			$whereCond .= "assign_to = $assign_to and ";
		}
		if ($from_date != "" && $to_date != "") {
			$whereCond .= "(date(followup_date) between '" . $from_date . "' and '" . $to_date . "') and ";
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
				$followup_date = $rows[$key]['followup_date'];
				$assign_to1 = $rows[$key]['assign_to'];
				$rows[$key]['followup_date'] = $this->Common_model->dateformat($followup_date);
				$rows[$key]['assign_to'] = $this->Common_model->showname_fromid("admin_name", "tbl_admin", "adminid='$assign_to1'");
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

	public function edit_pop()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("id", "tbl_inquiries", "id='$editid' ");
		if ($noof_rec > 0) {
			$rows = $this->Common_model->get_records("*", "tbl_inquiries", "id='$editid'", "");

			foreach ($rows as $row) {
				$customer_name    = $row['customer_name'];
				$email_address     = $row['email_address'];
				$phone_number      = $row['phone_number'];
				$source_id  = $row['source_id'];
				$status_id = $row['status_id'];
				$trip_name    = $row['trip_name'];
				$trip_start_date     = date('m/d/Y', strtotime($row['trip_start_date']));
				$follow_up_date     = date('m/d/Y', strtotime($row['followup_date']));
				$no_of_travellers     = $row['travellers_count'];
				$comment     = $row['comments'];
				$inquiry_number     = $row['inquiry_number'];
			}
		?>

			<div class="modal-header">
				<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
				<h4 class="modal-title pupop-title">Edit Enquiries Details (<?php echo $inquiry_number; ?>)</h4>
			</div>
			<div class="modal-body">
				<div class="modal-sub-body">
					<div class="row">
						<?php echo form_open(base_url('admin/enquiries-report'), array('id' => 'form_edit_enquiry_report', 'name' => 'form_edit_enquiry_report', 'class' => 'col-md-12 modalform', 'enctype' => 'multipart/form-data')); ?>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Customer Name : </label></div>
								<div class="col-md-8"> <?php echo $customer_name; ?></div>
								<input type="hidden" class="form-control" name="customer_name" id="customer_name" value="<?php echo set_value('customer_name', $customer_name); ?>">
								<input type="hidden" class="form-control" name="inquiry_number" id="inquiry_number" value="<?php echo set_value('inquiry_number', $inquiry_number); ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Source : </label></div>
								<div class="col-md-8"> <?php echo $this->Common_model->showname_fromid("name", "tbl_sources", "id='$source_id'"); ?></div>
								<input type="hidden" class="form-control" name="source_id" id="source_id" value="<?php echo set_value('source_id', $source_id); ?>">
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Email Address : </label></div>
								<div class="col-md-8"> <?php echo $email_address; ?></div>
								<input type="hidden" class="form-control" name="email_address" id="email_address" value="<?php echo set_value('email_address', $email_address); ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Phone Number : </label></div>
								<div class="col-md-8"> <?php echo $phone_number; ?></div>
								<input type="hidden" class="form-control" name="phone_number" id="phone_number" value="<?php echo set_value('phone_number', $phone_number); ?>">
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Trip Name : </label></div>
								<div class="col-md-8"> <?php echo $trip_name; ?></div>
								<input type="hidden" class="form-control" name="trip_name" id="trip_name" value="<?php echo set_value('trip_name', $trip_name); ?>">
							</div>
						</div>						

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" id="status_id" name="status_id">
									<option value="">-- Select Status --</option>
									<?php echo $this->Common_model->populate_select($dispid = $status_id, "id", "name", " tbl_statuses", "", "name asc", ""); ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>No. of Travellers</label>
								<input type="number" class="form-control" placeholder="Enter No. of Travellers" name="no_of_travellers" id="no_of_travellers" min="0" value="<?php echo set_value('no_of_travellers', $no_of_travellers); ?>">
							</div>
						</div>

						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="form-group datepickerbox">
								<label for="date">Trip Start Date</label>
								<input type="text" class="form-control datepicker" id="trip_start_date" name="trip_start_date" value="<?php echo set_value('trip_start_date', $trip_start_date); ?>" placeholder="dd/mm/yyyy" readonly>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group datepickerbox">
								<label for="date">Follow Up Date</label>
								<input type="text" class="form-control datepicker" id="follow_up_date" name="follow_up_date" value="<?php echo set_value('follow_up_date', $follow_up_date); ?>" placeholder="dd/mm/yyyy" readonly>
							</div>
						</div>
						<div class="clearfix"></div>

						<div class="col-md-12">
							<div class="form-group">
								<label>Comment</label>
								<textarea class="form-control" rows="2" placeholder="Comment" name="comment" id="comment"><?php echo $comment ?></textarea>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="form-group">
							<label class="col-md-5"></label>
							<div class="reset-button col-md-7">
								<input type="hidden" name="editid" id="editid" value="<?php echo $editid; ?>" />
								<button type="submit" class="btn redbtn btnSubmit" name="btnSubmit" id="btnSubmit">Update</button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js"></script>
			<script>
				$(".datepicker").datepicker({
				    minDate: +2,
				    showOtherMonths: true,
				    autoclose: true,
				    showOn: "both",
				    buttonImage: "<?php echo base_url(); ?>assets/images/modal-small-calendar.jpg",
				    buttonImageOnly: true,
				    buttonText: "Select date",
				    changeMonth: true,
				    changeYear: true
				});
			</script>
		<?php
		}
		exit();
	}

	public function edit_assignto()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("id", "tbl_inquiries", "id='$editid' ");
		if ($noof_rec > 0) {
			$rows = $this->Common_model->get_records("*", "tbl_inquiries", "id='$editid'", "");

			foreach ($rows as $row) {
				$customer_name    = $row['customer_name'];
				$email_address     = $row['email_address'];
				$phone_number      = $row['phone_number'];
				$source_id  = $row['source_id'];
				$status_id = $row['status_id'];
				$assign_to = $row['assign_to'];
				$trip_name    = $row['trip_name'];
				$trip_start_date     = date('m/d/Y', strtotime($row['trip_start_date']));
				$follow_up_date     = date('m/d/Y', strtotime($row['followup_date']));
				$no_of_travellers     = $row['travellers_count'];
				$comment     = $row['comments'];
				$inquiry_number     = $row['inquiry_number'];
				$source_name = $this->Common_model->showname_fromid("name", "tbl_sources", "id='$source_id'");
				$status_name = $this->Common_model->showname_fromid("name", "tbl_statuses", "id='$status_id'");
			}
		?>

			<div class="modal-header">
				<button type="button" class="close-btn " data-dismiss="modal">&times;</button>
				<h4 class="modal-title pupop-title">Change Assign To - Enquiries Details (<?php echo $inquiry_number; ?>)</h4>
			</div>
			<div class="modal-body">
				<div class="modal-sub-body">
					<div class="row">
						<?php echo form_open(base_url('admin/enquiries-report'), array('id' => 'form_edit_assign_to', 'name' => 'form_edit_assign_to', 'class' => 'col-md-12 modalform', 'enctype' => 'multipart/form-data')); ?>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Customer Name : </label></div>
								<div class="col-md-8"> <?php echo $customer_name; ?></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Source : </label></div>
								<div class="col-md-8"> <?php echo $this->Common_model->showname_fromid("name", "tbl_sources", "id='$source_id'"); ?></div>
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
								<div class="col-md-4"> <label> Trip Name : </label></div>
								<div class="col-md-8"> <?php echo $trip_name; ?></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Status : </label></div>
								<div class="col-md-8"> <?php echo $status_name; ?></div>
							</div>
						</div>
						<div class="clearfix"></div>

						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> No. of Travellers : </label></div>
								<div class="col-md-8"> <?php echo $no_of_travellers; ?></div>
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
								<div class="col-md-4"> <label> Trip Start Date : </label></div>
								<div class="col-md-8"> <?php echo $trip_start_date; ?></div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="gap row">
								<div class="col-md-4"> <label> Follow Up Date : </label></div>
								<div class="col-md-8"> <?php echo $follow_up_date; ?></div>
							</div>
						</div>
						<div class="clearfix"></div>

						
						<div class="col-md-6">
							<div class="form-group">
								<label>Assign To</label>
								<select class="form-control" id="assign_to" name="assign_to">
									<option value="">-- Select Status --</option>
									<?php echo $this->Common_model->populate_select($dispid = $assign_to, "adminid", "admin_name", "tbl_admin", "status = 1 and adminid in (select adminid from tbl_admin_modules where moduleid = 20)", "admin_name asc", ""); ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="reset-button" style="margin-top: 25px;">
									<input type="hidden" name="editid" id="editid" value="<?php echo $editid; ?>" />
									<button type="submit" class="btn redbtn btnSubmitAssignTo" name="btnSubmitAssignTo" id="btnSubmitAssignTo">Update</button>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<script src="<?php echo base_url(); ?>assets/admin/js_validation/jquery.validate.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/admin/js_validation/validation.js?v=1.0"></script>
		<?php
		}
		exit();
	}

	public function export_data() {
        // Fetch data from your model
		$arrPageData = $_REQUEST;
		$customer_name = isset($arrPageData['customer_name']) ? $arrPageData['customer_name'] : "";
		$phone_number = isset($arrPageData['phone_number']) ? $arrPageData['phone_number'] : "";
		$assign_to = isset($arrPageData['assign_to']) ? $arrPageData['assign_to'] : 0;
		$from_date = isset($arrPageData['from_date']) && $arrPageData['from_date'] != "" ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['from_date']))) : "";
		$to_date = isset($arrPageData['to_date']) && $arrPageData['to_date'] != "" ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['to_date']))) : "";
		$whereCond = '';
		if ($customer_name != '') {
			$whereCond .= "(customer_name like '%" . $customer_name . "%') and ";
		}
		if ($phone_number != '') {
			$whereCond .= "(phone_number like '%" . $phone_number . "%') and ";
		}
		if ($assign_to > 0) {
			$whereCond .= "assign_to = $assign_to and ";
		}
		if ($from_date != "" && $to_date != "") {
			$whereCond .= "(date(followup_date) between '" . $from_date . "' and '" . $to_date . "') and ";
		}

		// if ($this->session->userdata('usertype') != 1) {
		// 	$sess_userid = $this->session->userdata('userid');
		// 	$whereCond .= "assign_to = $sess_userid and ";
		// }
		$whereCond = rtrim($whereCond, " and ");

		$data = $this->Common_model->get_records("inquiry_number, customer_name, email_address, phone_number, followup_date, (select admin_name from tbl_admin where adminid = assign_to) as assign_to_name, (select name from tbl_statuses where id = status_id) as status_name", "tbl_inquiries", "$whereCond", " id DESC", '');

        // Define CSV file name
        $file_name = 'exported_data_' . date('Y-m-d') . '.csv';

        // Set CSV file headers
        $csv_data = array(
            array('Sl#', 'Enquiry Number', 'Customer Name', 'Email Address', 'Phone Number', 'Followup Date', 'Followup By', 'Status'), // Header row
        );

        // Format data into CSV rows
		$i = 0;
        foreach ($data as $row) {
            $csv_data[] = array(++$i, $row['inquiry_number'], $row['customer_name'], $row['email_address'], $row['phone_number'], date("d-M-Y", strtotime($row['followup_date'])), $row['assign_to_name'], $row['status_name']); // Adjust according to your data structure
        }		

        // Generate CSV file
        $this->csv->create_csv(array(
            'filename' => $file_name,
            'data'     => $csv_data
        ));
        
        // Download the file
        $this->csv->create_csv();
		
        // You can redirect to a success page after exporting if needed
        // redirect('success_page');
    }
}
