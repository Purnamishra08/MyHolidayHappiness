<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends CI_Controller {

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

		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}
		
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(19, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['bookings'] = $this->Common_model->get_records("*","tbl_bookings","", " booking_id DESC");
		$this->load->view('admin/manage_booking',$data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$invoice_no = isset($arrPageData['invoice_no']) ? $arrPageData['invoice_no'] : "";
		$package_name = isset($arrPageData['package_name']) ? $arrPageData['package_name'] : 0;
		$customer_info = isset($arrPageData['customer_info']) ? $arrPageData['customer_info'] : 0;
		$booking_status = isset($arrPageData['booking_status']) ? $arrPageData['booking_status'] : 0;
		$whereCond = 'a.customer_id > 0 and ';
		if($invoice_no != ''){
			$whereCond .= "(a.invoice_no like '%".$invoice_no."%') and ";
		}
		if($package_name > 0){
			$whereCond .= "a.package_id = $package_name and ";
		}
		if($customer_info != ''){
			$whereCond .= "( (b.fullname like '%".$customer_info."%') or (b.contact like '%".$customer_info."%') or (b.email_id like '%".$customer_info."%') ) and ";
		}
		if($booking_status > 0){
			if($booking_status == 1 || $booking_status == 2){
				$whereCond .= "a.booking_status = $booking_status and ";
			} else {
				$whereCond .= "a.booking_status not in (1, 2) and";
			}
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("a.booking_id","tbl_bookings as a, tbl_customers as b","a.customer_id=b.customer_id and $whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->join_records("a.booking_id, a.invoice_no, a.customer_id, a.package_id, a.total_price, a.payment_status, a.payment_percentage, a.paid_amount, a.total_price, a.date_of_travel, a.booking_date, a.booking_status, b.fullname, b.contact, b.email_id","tbl_bookings as a","tbl_customers as b", "a.customer_id=b.customer_id", "$whereCond","a.booking_id desc");
		} else {
			$rows = $this->Common_model->join_records("a.booking_id, a.invoice_no, a.customer_id, a.package_id, a.total_price, a.payment_status, a.payment_percentage, a.paid_amount, a.total_price, a.date_of_travel, a.booking_date, a.booking_status, b.fullname, b.contact, b.email_id","tbl_bookings as a","tbl_customers as b", "a.customer_id=b.customer_id", "$whereCond","a.booking_id desc",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];
				$booking_encid = $this->Common_model->encode($rows[$key]['booking_id']);
				$package_id = $rows[$key]['package_id'];
				$rows[$key]['package_name'] = $this->Common_model->showname_fromid("tpackage_name", "tbl_tourpackages", "tourpackageid ='$package_id'");
				$tpackage_url = $this->Common_model->showname_fromid("tpackage_url", "tbl_tourpackages", "tourpackageid ='$package_id'");

				$rows[$key]['package_url'] = base_url().'packages/'.$tpackage_url;
				$rows[$key]['booking_url'] = base_url().'invoice/'.$rows[$key]['invoice_no'].'/'.$booking_encid;
				$rows[$key]['total_price'] = $this->Common_model->currency.$rows[$key]['total_price'];

				if($rows[$key]['payment_status'] == 1) { 
					$rows[$key]['payment_status'] = "PAID<br>".$this->Common_model->currency.$rows[$key]['paid_amount']." ( ".$rows[$key]['payment_percentage']."% )"; 
				}
				else {
					$rows[$key]['payment_status'] = "NOT PAID<br>".$this->Common_model->currency.$rows[$key]['paid_amount']." ( ".$rows[$key]['payment_percentage']."% )"; 
				}
				$rows[$key]['date_of_travel'] = $this->Common_model->dateformat($rows[$key]['date_of_travel']);
				$rows[$key]['booking_date'] = $this->Common_model->dateformat($rows[$key]['booking_date']);

				if($rows[$key]['booking_status'] == 1) { 
					$rows[$key]['booking_status'] = "Approved"; 
				} else if($rows[$key]['booking_status'] == 2) { 
					$rows[$key]['booking_status'] = "Cancelled"; 
				} else {
					$rows[$key]['booking_status'] = "Pending"; 
				}
			}
		} else {
			$rows = [];
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
	
	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("booking_id","tbl_bookings","booking_id='$delid'");
		if($noof_rec>0)
		{			
			$del = $this->Common_model->delete_records("tbl_bookings","booking_id=$delid");
			if($del)
			{
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Booking has been deleted successfully.</div>');
			}
			else
			{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Booking could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/bookings','refresh');
	}
	

	public function view()
	{
		$data['message'] = $this->session->flashdata('message');
		$data['pmessage'] = $this->session->flashdata('pmessage');
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("booking_id","tbl_bookings","booking_id='$viewid'");
		if($noof_rec>0)
		{
			$date = date("Y-m-d H:i:s");
		
			if (isset($_POST['btnSubBooking']) && !empty($_POST))
			{
				$this->form_validation->set_rules('booking_status','Status','trim|required');
            
				if ($this->form_validation->run() == true)
				{
					$bookingsts = $this->input->post('booking_status');

					$query_data = array(
						'booking_status'	=> $bookingsts,
						'modify_date'		=> $date
					);
					$updt_rec = $this->Common_model->update_records("tbl_bookings", $query_data," booking_id='$viewid'");
					if($updt_rec)
					{
						 $this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Booking status has been updated successfully.</div>');
					}
					else {						
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Booking status could not updated. Please try again.</div>');
					}
					redirect(base_url().'admin/bookings/view/'.$viewid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			
			if (isset($_POST['btnsubpaymnt']) && !empty($_POST))
			{
				$this->form_validation->set_rules('paymntsts','Status','trim|required');
            
				if ($this->form_validation->run() == true)
				{
					$paymntsts = $this->input->post('paymntsts');
					$transnumber = $this->input->post('transnumber');

					$query_data = array(
						'payment_status'	=> $paymntsts,
						'transactin_id'		=> $transnumber,
						'modify_date'		=> $date
					);
					$updt_rec = $this->Common_model->update_records("tbl_bookings", $query_data,"booking_id='$viewid'");
					if($updt_rec)
					{
						 $this->session->set_flashdata('pmessage','<div class="successmsg notification"><i class="fa fa-check"></i> Payment Details has been updated successfully.</div>');
					}
					else {						
						$this->session->set_flashdata('pmessage','<div class="errormsg notification"><i class="fa fa-times"></i> Payment Details could not updated. Please try again.</div>');
					}
					redirect(base_url().'admin/bookings/view/'.$viewid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['pmessage'] = (validation_errors() ? validation_errors() : $this->session->flashdata('pmessage'));
				}
			}
			
			$data['bookings'] = $this->Common_model->get_records("*","tbl_bookings","booking_id=$viewid","");
			$this->load->view('admin/view_booking',$data);
		}
	}


}
 
	
