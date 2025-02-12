<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends CI_Controller {

	public function __construct()
 	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->helper('captcha');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->load->database();
		$this->load->model('Common_model');
 	}

	public function index() 
	{	    
		$this->load->view('contactus');
	}

	public function send_enquiry()
	{
		$status 	= "error";
		$message	= "";
		$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
		if ($recaptchaResponse){ //Captcha Successfull

			$this->form_validation->set_message('required', '{field} can not be empty.');
			$this->form_validation->set_message('min_length', '{field} must be at least {param} characters long.');
			$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
			$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');
			$this->form_validation->set_message('regex_match', '{field} must be a valid 10 digit number.');

			$this->form_validation->set_rules('cont_name', 'Name', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('cont_email', 'Email', 'trim|required|valid_email|max_length[80]');
			$this->form_validation->set_rules('cont_phone', 'Phone No', 'trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('cont_details', 'Message', 'trim|required|max_length[550]');
			
			if ($this->form_validation->run() == FALSE) {
				$errorMsg	= "";
				if(!empty(form_error('cont_name'))){
					$errorMsg	= form_error('cont_name');
				} else if(!empty(form_error('cont_email'))){
					$errorMsg	= form_error('cont_email');
				} else if(!empty(form_error('cont_phone'))){
					$errorMsg	= form_error('cont_phone');
				} else if(!empty(form_error('cont_details'))){
					$errorMsg	= form_error('cont_details');
				} else {
					$errorMsg	= "Fill all mandatory fields with valid data.";
				}

				$status 	= "error";
				$message	= $errorMsg;
			} else {

				$cont_name    = $this->Common_model->htmlencode($this->input->post('cont_name'));
				$cont_email   = $this->Common_model->htmlencode($this->input->post('cont_email'));
				$cont_phone   = $this->Common_model->htmlencode($this->input->post('cont_phone'));
				$cont_details = $this->Common_model->htmlencode($this->input->post('cont_details'));
				$pagename 	  = $this->Common_model->htmlencode($this->input->post('pagename'));
				$date 		  = date("Y-m-d H:i:s"); 

				$query_data = array(
					'cont_name'			    => $cont_name,
					'cont_email'		    => $cont_email,
					'cont_phone'			=> $cont_phone,
					'cont_enquiry_details'	=> $cont_details,
					'page_name'				=> $pagename,
					'cont_date'				=> $date
				);
			
				$insert_rec = $this->Common_model->insert_records("tbl_contact", $query_data);
				if($insert_rec) {					
					$mailcontent = "<!doctype html>
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
						<p style='margin-top:30px;'>There is an enquiry from website ($pagename). Please have a look below details : </p>
						<div style='line-height:25px;font-size:14px'>
						
							<div><strong>NAME : </strong>$cont_name</div>
							<div><strong>EMAIL : </strong>$cont_email</div>
							<div><strong>PHONE : </strong>$cont_phone</div>
							<div><strong>ENQUIRY DETAILS : </strong>$cont_details</div>
						</div>
						
					</div>				
					
					<div style='background:#f5f5f5; padding:10px 30px 5px; color:#000;'>
					<div style='color:#15c; font-size:13px; text-align:center; margin-bottom:10px;'>
						&copy; ".date("Y")." All right reserved. myholidayhappiness.com
					</div>
								
					</div>
					</body>
					</html>";
					
					$subject = "New enquiry from MyHolidayHapiness.";
					$from_mail = $this->Common_model->show_parameter(9);
					$to_mail = $this->Common_model->show_parameter(2);
					
					$headers = 'From:  myholidayhappiness.com <'.$from_mail.">\r\n" .
							'Reply-To: '.$cont_email."\r\n" .
							'X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
					mail($to_mail, $subject, $mailcontent, $headers);
			
					//echo $mailcontent ; exit;
					/** End - Send Mail **/		
					
					$status 	= "success";
					$message	= "Your enquiry has been submitted successfully. We will contact you soon.";
				} else {
					$status 	= "error";
					$message	= "Your enquiry could not submitted. Please try again.";
				}            
			}
		} else {
			$status 	= "error";
			$message	= "reCAPTCHA verification failed. Please try again.";
		} 
		echo json_encode(array('status' => $status, 'message' => $message));
		exit();
	}

}
