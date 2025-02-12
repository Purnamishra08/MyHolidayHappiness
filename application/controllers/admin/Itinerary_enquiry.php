<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itinerary_enquiry extends CI_Controller {
	
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
		// $data['row'] = $this->Common_model->get_records("*","tbl_tripcustomize","","tripcust_id desc","","");
		$this->load->view('admin/itinerary_enquiry', $data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$itinerary_id = isset($arrPageData['itinerary_id']) ? $arrPageData['itinerary_id'] : 0;
		$package_id = isset($arrPageData['package_id']) ? $arrPageData['package_id'] : "";
		$email_id = isset($arrPageData['email_id']) ? $arrPageData['email_id'] : "";
		$contact_no = isset($arrPageData['contact_no']) ? $arrPageData['contact_no'] : "";
		$from_date = ($arrPageData['from_date'] != "") ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['from_date']))) : "";
		$to_date = ($arrPageData['to_date'] != "") ? date('Y-m-d', strtotime(str_replace('/', '-', $arrPageData['to_date']))) : "";
		
		$whereCond = '';
		if($itinerary_id > 0){
			$whereCond .= "itinerary_id = ".$itinerary_id." and ";
		}
		if($package_id > 0){
			$whereCond .= "package_id = ".$package_id." and ";
		}
		if($email_id != ''){
			$whereCond .= "email like '%".$email_id."%' and ";
		}
		if($contact_no != ""){
			$whereCond .= "phone like '%".$contact_no."%' and ";
		}
		if($from_date != "" && $to_date != ""){
			$whereCond .= "(date(tsdate) between '".$from_date."' and '".$to_date."') and ";
		}
		
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("tripcust_id","tbl_tripcustomize","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_tripcustomize","$whereCond", " tripcust_id desc");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_tripcustomize","$whereCond", " tripcust_id desc",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];

				$packageId = $rows[$key]['package_id'];
				$itineraryId = $rows[$key]['itinerary_id'];
				$packageData = $this->Common_model->get_records("tpackage_name,tpackage_url","tbl_tourpackages","tourpackageid = $packageId and status='1'");
                                                        
				$itineraryData = $this->Common_model->get_records("itinerary_url,itinerary_name","tbl_itinerary","itinerary_id = $itineraryId and status='1'");
				
				if($itineraryData[0]){
					$rows[$key]['itinerary_url'] = base_url().'itinerary/'.(($itineraryData && $itineraryData[0])?$itineraryData[0]['itinerary_url']:'');	
					$rows[$key]['itinerary_name'] = $itineraryData[0]['itinerary_name'];
				}

				if($packageData[0]){
					$rows[$key]['tpackage_url'] = base_url().'packages/'.(($packageData && $packageData[0])?$packageData[0]['tpackage_url']:'');
					$rows[$key]['tpackage_name'] = $packageData[0]['tpackage_name'];
				}
				
				$rows[$key]['tnote'] = $this->Common_model->short_str($rows[$key]['tnote'], 140);
				$rows[$key]['tsdate'] = $this->Common_model->dateformat($rows[$key]['tsdate']);
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
		$noof_rec = $this->Common_model->noof_records("tripcust_id","tbl_tripcustomize","tripcust_id='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_tripcustomize","tripcust_id=$delid");
			if($del){

				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i>itinerary enquiry has been deleted successfully.</div>');				
			}
			else{
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i>itinerary enquiry could not deleted. Please try again.</div>');
			}
		}
		redirect(base_url().'admin/itinerary-enquiry','refresh');		
	}

	public function view()
	{
		$data['message'] = $this->session->flashdata('message');
		$viewid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("tripcust_id","tbl_tripcustomize","tripcust_id='$viewid'");
		if($noof_rec>0)
		{
			$data['ITIENQdETAIL'] = $this->Common_model->get_records("*","tbl_tripcustomize","tripcust_id=$viewid","");
			
				if (isset($_POST['btnReply']) && !empty($_POST)) {
					
					$this->form_validation->set_rules('reply', 'reply', 'trim|required|xss_clean');					
				    $sess_userid = $this->session->userdata('userid');
					$date = date("Y-m-d H:i:s");
					if ($this->form_validation->run() == true)
					{
						$message = $this->input->post('reply');
						$hdntripcust_id = $this->input->post('hdntripcust_id');
							$insert_data = array(
								'adminid'     => $sess_userid,
								'enq_id'      => $hdntripcust_id,
								'message'     => $message,
								'type'   	  => 2,
								'created_date'=> $date
							);
						  $insertdb = $this->Common_model->insert_records('tbl_reply_enquiry', $insert_data);
						                           
                          $email = $this->Common_model->showname_fromid("email","tbl_tripcustomize","tripcust_id='$hdntripcust_id' ");
                          
                          $cont_enquiry_details = $this->Common_model->showname_fromid("tnote","tbl_tripcustomize","tripcust_id='$hdntripcust_id' ");
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
									<p style='margin-top:30px;'>There is a reply to your last itinerary enquiry. Please have a look below details : </p>
									
									<div style='line-height:25px;font-size:14px'>									
										<div><strong>myholidayhappiness.com </strong></div>
										<div><strong>Message : </strong>$message</div>
									</div>
									
									<div style='margin-top:20px; text-decoration:underline;'><strong>Your last itinerary enquiry details : </strong><br></div>
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
				
								$subjectto = " Iternerary Enquiry Reply From Admin - myholidayhappiness.com";
								$from_mail = $this->Common_model->show_parameter(9);
							    //$to_mail = $this->Common_model->show_parameter(2);
							    
								// $this->load->library('email', $mailconfig);
								// $this->email->from($from_mail, "myholidayhappiness.com");
								// $this->email->to($email);
								// $this->email->subject($subjectto);
								// $this->email->message($messageto);
								// @$this->email->send();	
								
								
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
								redirect(base_url().'admin/itinerary-enquiry/view/'.$viewid, 'refresh');
					}
					else
					{
						$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
					}
				}

			$this->load->view('admin/view_itinerary_enquiry',$data);
		}
	}

	
}
