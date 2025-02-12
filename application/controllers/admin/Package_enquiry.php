<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_enquiry extends CI_Controller {
	
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
		if(!(in_array(18, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}
 	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['row'] = $this->Common_model->get_records("*","tbl_package_inquiry","","enq_id desc","","");
		$this->load->view('admin/package_enquiry', $data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$enquiry_name = isset($arrPageData['enquiry_name']) ? $arrPageData['enquiry_name'] : 0;
		$package_id = isset($arrPageData['package_id']) ? $arrPageData['package_id'] : "";
		$email_id = isset($arrPageData['email_id']) ? $arrPageData['email_id'] : "";
		$contact_no = isset($arrPageData['contact_no']) ? $arrPageData['contact_no'] : "";
		$from_date = ($arrPageData['from_date'] != "") ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['from_date']))) : "";
		$to_date = ($arrPageData['to_date'] != "") ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['to_date']))) : "";
		
		$whereCond = '';
		if($package_id > 0){
			$whereCond .= "packageid = ".$package_id." and ";
		}
		if($enquiry_name != ''){
			$whereCond .= "(first_name like '%".$enquiry_name."%' OR last_name like '%".$enquiry_name."%') and ";
		}
		if($email_id != ''){
			$whereCond .= "emailid like '%".$email_id."%' and ";
		}
		if($contact_no != ""){
			$whereCond .= "phone like '%".$contact_no."%' and ";
		}
		if($from_date != "" && $to_date != ""){
			$whereCond .= "(date(inquiry_date) between '".$from_date."' and '".$to_date."') and ";
		}
		
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("enq_id","tbl_package_inquiry","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_package_inquiry","$whereCond", " enq_id desc");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_package_inquiry","$whereCond", " enq_id desc",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];

				$packageId = $rows[$key]['packageid'];
				$packageData = $this->Common_model->get_records("tpackage_name,tpackage_url","tbl_tourpackages","tourpackageid = $packageId and status='1'");
                                       
				if($packageData[0]){
					$rows[$key]['tpackage_url'] = base_url().'packages/'.$packageData[0]['tpackage_url'];
					$rows[$key]['tpackage_name'] = $packageData[0]['tpackage_name'];
				}
				$rows[$key]['full_name'] = $rows[$key]['first_name']." ".$rows[$key]['last_name'];
				$rows[$key]['inquiry_date'] = $this->Common_model->dateformat($rows[$key]['inquiry_date']);
				$rows[$key]['tour_date'] = $this->Common_model->dateformat($rows[$key]['tour_date']);
			}
		} else {
			$rows = [];
		}
	
		echo json_encode([
            'draw' => isset($arrPageData['draw']) ? intval($arrPageData['draw']) : 0,
            'recordsTotal' => $rowCnt,
            // 'whereCond' => $whereCond,
            'recordsFiltered' => $rowCnt, // For simplicity, assuming no filtering
            'data' => $rows
        ]);
		exit;
	}

	public function delete()	
	{		
        $delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("enq_id","tbl_package_inquiry","enq_id='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_package_inquiry","enq_id=$delid");
			if($del){
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i>Package enquiry has been deleted successfully.</div>');
			}
			else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>Package enquiry could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/package-enquiry','refresh');		
	}

	public function view()
	{
		$data['message'] = $this->session->flashdata('message');
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("enq_id","tbl_package_inquiry","enq_id='$viewid'");
		if($noof_rec>0)
		{
			$data['inquiry_details'] = $this->Common_model->get_records("*","tbl_package_inquiry","enq_id=$viewid","");
			
			if (isset($_POST['btnReply']) && !empty($_POST)) {					
				$this->form_validation->set_rules('reply', 'reply', 'trim|required|xss_clean');					
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
					$message = $this->input->post('reply');
					$enq_id = $this->input->post('enq_id');
					$insert_data = array(
						'adminid'     => $sess_userid,
						'enq_id'      => $enq_id,
						'message'     => $message,
						'type'   	  => 3,
						'created_date'=> $date
					);
					$insertdb = $this->Common_model->insert_records('tbl_reply_enquiry', $insert_data);										   
					
					if($insertdb)
					{
						$email = $this->Common_model->showname_fromid("emailid","tbl_package_inquiry","enq_id='$enq_id' ");
						$package_enquiry_details = $this->Common_model->showname_fromid("message","tbl_package_inquiry","enq_id='$enq_id' ");
						
						$mailconfig   = Array(
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE,
							'newline' => '\n',
							'crlf' => '\n'
						);
			
						$messageto = "<!doctype html>
						<html>
							<head>
								<meta charset='utf-8'>
							</head>
							<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
								<div style='width: 100%;background: #F5F5F5;color: #000;'>
									<div style='text-align:center'><a href='".base_url()."'><img src='".base_url()."assets/images/logo.png'></a></div>				
									<div style='clear:both'></div>
								</div>
							
								<div style='padding:10px 30px;'>				  	
									<p style='margin-top:30px;'>There is a reply to your last package enquiry. Please have a look below details : </p>
									
									<div style='line-height:25px;font-size:14px'>									
										<div><strong>myholidayhappiness.com </strong></div>
										<div><strong>Message : </strong>$message</div>
									</div>
									
									<div style='margin-top:20px; text-decoration:underline;'><strong>Your last package enquiry details : </strong><br></div>
										<div style='margin-left:10px; color:#696969; font-style: italic;'>$package_enquiry_details
									</div>	
												
									<div style='line-height:25px; font-size:14px; margin-top:20px'>
										<div>Sincerely,</div>
										<div>myholidayhappiness.com</div>
									</div>
								</div>				
							
								<div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
									<div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
									&copy; ".date("Y")." All right reserved. myholidayhappiness.com </div>											
								</div>
							</body>
						</html>";
		
						$subjectto = "Package Enquiry Reply From Admin - myholidayhappiness.com";
						$from_mail = $this->Common_model->show_parameter(9);
				// 		$this->load->library('email', $mailconfig);
				// 		$this->email->from($from_mail, "myholidayhappiness.com");
				// 		$this->email->to($email);
				// 		$this->email->subject($subjectto);
				// 		$this->email->message($messageto);
				// 		@$this->email->send();	
				
        				$headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
                                'Reply-To: Holidays Toor <'.$from_mail.">\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                         $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
                        mail($email, $subjectto, $messageto, $headers);
						
						/** End - Send Mail **/	
						$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Message sent successfully .</div>');								
					}
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Unable to process your request. Please try again.</div>');
						
					}
						redirect(base_url().'admin/package-enquiry/view/'.$viewid, 'refresh');
				}
				else
				{
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}

			$this->load->view('admin/view_package_enquiry',$data);
		}
	}

	
}
