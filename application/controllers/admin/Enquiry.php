<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller {
	
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
		if(!(in_array(4, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}
 	
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		//$data['row'] = $this->Common_model->get_records("*","tbl_contact","","enq_id desc","","");
		$this->load->view('admin/enquiry', $data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$enquiry_name = isset($arrPageData['enquiry_name']) ? $arrPageData['enquiry_name'] : "";
		$email_id = isset($arrPageData['email_id']) ? $arrPageData['email_id'] : "";
		$contact_no = isset($arrPageData['contact_no']) ? $arrPageData['contact_no'] : "";
		$from_date = ($arrPageData['from_date'] != "") ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['from_date']))) : "";
		$to_date = ($arrPageData['to_date'] != "") ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['to_date']))) : "";
		
		$whereCond = '';
		if($enquiry_name != ''){
			$whereCond .= "(cont_name like '%".$enquiry_name."%') and ";
		}
		if($email_id != ''){
			$whereCond .= "cont_email like '%".$email_id."%' and ";
		}
		if($contact_no != ""){
			$whereCond .= "cont_phone like '%".$contact_no."%' and ";
		}
		if($from_date != "" && $to_date != ""){
			$whereCond .= "(date(cont_date) between '".$from_date."' and '".$to_date."') and ";
		}
		
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("enq_id","tbl_contact","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_contact","$whereCond", " enq_id desc");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_contact","$whereCond", " enq_id desc",$arrPageData['length'], $arrPageData['start']);
		}		

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];

				$rows[$key]['cont_enquiry_details'] = $this->Common_model->short_str($rows[$key]['cont_enquiry_details'], 140);
				$rows[$key]['cont_date'] = $this->Common_model->dateformat($rows[$key]['cont_date']);
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

	public function delete_contact()	
	{		
        $delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("enq_id","tbl_contact","enq_id='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_contact","enq_id=$delid");
			if($del){

				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i>Contact has been deleted successfully.</div>');				
			}
			else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>Contact could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/enquiry','refresh');		
	}

	public function view()
	{
		$data['message'] = $this->session->flashdata('message');
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("enq_id","tbl_contact","enq_id='$viewid'");
		if($noof_rec>0)
		{
			$data['contact'] = $this->Common_model->get_records("*","tbl_contact","enq_id=$viewid","");
				if (isset($_POST['btnReply']) && !empty($_POST)) {
					$this->form_validation->set_rules('reply', 'reply', 'trim|required|xss_clean');					
				    $sess_userid = $this->session->userdata('userid');
					$date = date("Y-m-d H:i:s");
					if ($this->form_validation->run() == true)
					{
						$message = $this->input->post('reply');
						$hdnenquiry_id = $this->input->post('hdnenquiry_id');
							$insert_data = array(
								'adminid'=> $sess_userid,
								'enq_id'=> $hdnenquiry_id,
								'message'=> $message,
								'type'   	  => 1,
								'created_date'=> $date
							);
						  $insertdb = $this->Common_model->insert_records('tbl_reply_enquiry', $insert_data);
                         
                          $getInquiryName=$this->Common_model->showname_fromid("cont_name","tbl_contact","enq_id='$hdnenquiry_id'");
                        
                          $email = $this->Common_model->showname_fromid("cont_email","tbl_contact","enq_id='$hdnenquiry_id' ");
                          $cont_enquiry_details = $this->Common_model->showname_fromid("cont_enquiry_details","tbl_contact","enq_id='$hdnenquiry_id' ");
							if($insertdb)
							{
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
									<p style='margin-top:30px;'>There is a reply to your last enquiry. Please have a look below details : </p>
									
									<div style='line-height:25px;font-size:14px'>									
										<div><strong>myholidayhappiness.com </strong></div>
										<div><strong>Message : </strong>$message</div>
									</div>
									
									<div style='margin-top:20px; text-decoration:underline;'><strong>Your last enquiry details : </strong><br></div>
										<div style='margin-left:10px; color:#696969; font-style: italic;'>$cont_enquiry_details
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
				
								$subjectto = "Enquiry Reply From Admin - myholidayhappiness	.com";
								$from_mail = $this->Common_model->show_parameter(9);
							    //$to_mail = $this->Common_model->show_parameter(2);
								$this->load->library('email', $mailconfig);
								$this->email->from($from_mail, "myholidayhappiness.com");
								$this->email->to($email);
								$this->email->subject($subjectto);
								$this->email->message($messageto);
								@$this->email->send();	                

								/** End - Send Mail **/	
								$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Message sent successfully .</div>');								
							}
							else
							{
								$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Unable to process your request. Please try again.</div>');
								
							}
								redirect(base_url().'admin/enquiry/view/'.$viewid, 'refresh');
					}
					else
					{
						$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
					}
				}

			$this->load->view('admin/view_contact_enquiry',$data);
		}
	}

	
}
