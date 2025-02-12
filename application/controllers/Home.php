<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->load->database();
		$this->load->model('Common_model');
	}

	public function index()
	{		
		$this->load->view('home');
	}
	
	public function send_customization()
	{	
		$status 	= "error";
		$message	= "";	

		$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
		if ($recaptchaResponse)  //Captcha Successfull
		{	
			$this->form_validation->set_message('required', '{field} can not be empty.');
			$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
			$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');
			$this->form_validation->set_message('regex_match', '{field} must be a valid 10 digit number.');

			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');
			$this->form_validation->set_rules('phone', 'Phone No', 'trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('tsdate', 'Trip Start Date', 'trim|required');
			$this->form_validation->set_rules('duration', 'Trip Duration', 'trim|required');
			$this->form_validation->set_rules('tnote', 'Trip Details', 'trim|required|max_length[550]');
			
			if ($this->form_validation->run() == FALSE) {
				$errorMsg	= "";

				if(!empty(form_error('email'))){
					$errorMsg	= form_error('email');
				} else if(!empty(form_error('phone'))){
					$errorMsg	= form_error('phone');
				} else if(!empty(form_error('tsdate'))){
					$errorMsg	= form_error('tsdate');
				} else if(!empty(form_error('duration'))){
					$errorMsg	= form_error('duration');
				} else if(!empty(form_error('tnote'))){
					$errorMsg	= form_error('tnote');
				} else {
					$errorMsg	= "Fill all mandatory fields with valid data.";
				}

				$status 	= "error";
				$message	= $errorMsg;
			} else {
				$c_email     = $this->Common_model->htmlencode($this->input->post('email'));
				$c_phone     = $this->Common_model->htmlencode($this->input->post('phone'));
				$c_tsdate11  = $this->Common_model->htmlencode($this->input->post('tsdate'));				
				$c_duration  = (int) $this->input->post('duration');
				$c_tnote 	 = $this->Common_model->htmlencode($this->input->post('tnote'));
				$c_itinerary_id = $this->Common_model->htmlencode($this->input->post('itinerary_id'));
				
				$c_tsdate11 = str_replace('/', '-', $c_tsdate11);
				$c_tsdate = date('Y-m-d H:i:s', strtotime($c_tsdate11));
				$date = date("Y-m-d H:i:s");
				
				$iti_duratn=$this->Common_model->showname_fromid("duration_name","tbl_package_duration","durationid='$c_duration'");
				$itinerary_url = $this->Common_model->showname_fromid("itinerary_url","tbl_itinerary","itinerary_id = $c_itinerary_id and status='1'");
				$packName11 = $this->Common_model->get_records("tourpackageid,tpackage_name","tbl_tourpackages","itinerary = $c_itinerary_id and status='1'");	
					
				$packName = $packName11[0]['tpackage_name'];
				$tourpackageid = $packName11[0]['tourpackageid'];
				
				$iURL = base_url().'itinerary/'.$itinerary_url;
				
				$query_data = array(
					'email'     => $c_email,
					'phone'		=> $c_phone,
					'tsdate	'	=> $c_tsdate,
					'duration'	=> $c_duration,
					'tnote'	    => $c_tnote,
					'itinerary_id' => $c_itinerary_id,
					'package_id'=> $tourpackageid,
				);	
				$insert_rec = $this->Common_model->insert_records("tbl_tripcustomize", $query_data);	

				if($insert_rec)
				{			
					$mailconfig   = Array(
						'mailtype' => 'html',
						'charset' => 'iso-8859-1',
						'wordwrap' => TRUE,
						'newline' => '\n',
						'crlf' => '\n'
					);
			
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
						<p style='margin-top:30px;'>There is a request from website for tour customization for the below package and itinerary :  </p>
						<strong> Package: $packName </strong>   <br>
						<strong>Itinerary: $iURL</strong>  
						<p>Please have a look below details : </p>
						<div style='line-height:25px;font-size:14px'>
							<div><strong>EMAIL : </strong>$c_email</div>
							<div><strong>PHONE : </strong>$c_phone</div>
							<div><strong>TRIP START DATE : </strong>$c_tsdate</div>
							<div><strong>DURATION : </strong>$iti_duratn</div>
							<div><strong>CUSTOMIZE DETAILS : </strong>$c_tnote</div>
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
							'Reply-To: '.$c_email."\r\n" .
							'X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";   
					mail($to_mail, $subject, $mailcontent, $headers);

					//	echo $this->email->print_debugger();
					/** End - Send Mail **/	
					$status 	= "success";
					$message	= "Your request for trip customize has been submitted successfully. We will contact you soon.";
				} else {
					$status 	= "error";
					$message	= "Your request for trip customize could not submitted. Please try again.";
				}   
			}	
		} else {
			$status 	= "error";
			$message	= "reCAPTCHA verification failed. Please try again.";
		}
		echo json_encode(array('status' => $status, 'message' => $message));
		exit();
	}

	public function getDuration()
	{		
		$options = "";
		if((isset($_REQUEST["destination"])) && ($_REQUEST["destination"] != ""))
		{	$destination = $_REQUEST["destination"];		
			$options = $this->Common_model->populate_duration($destination);
		}		
		
		echo '<option value="">Select Duration</option>'.$options;
	}
	
}
