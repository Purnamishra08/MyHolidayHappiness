<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url', 'form');
		$this->load->helper('captcha');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		$this->load->model('Common_model');
	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');

		if (isset($_POST['btn_custsignup']) && !empty($_POST)) {
			$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
			if ($recaptchaResponse) {

				$this->form_validation->set_message('required', '{field} can not be empty.');
				$this->form_validation->set_message('min_length', '{field} must be at least {param} characters long.');
				$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
				$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');
				$this->form_validation->set_message('regex_match', '{field} must be a valid 10 digit number.');

				$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('emailida', 'Email id', 'trim|required|valid_email|max_length[80]|is_unique[tbl_customers.email_id]');
				$this->form_validation->set_rules('contact', 'Phone No', 'trim|required|regex_match[/^[0-9]{10}$/]');
				$this->form_validation->set_rules('passworda', 'Password', 'trim|required|min_length[6]|max_length[15]');
				$this->form_validation->set_rules('cpassworda', 'Confirm Password', 'trim|required|matches[passworda]');

				if ($this->form_validation->run() == true) {
					$company_mail = $this->Common_model->show_parameter(2);
					$date = date("Y-m-d H:i:s");

					$fullname 	= $this->Common_model->htmlencode($this->input->post('fullname'));
					$contact 	= $this->Common_model->htmlencode($this->input->post('contact'));
					$emailida 	= $this->Common_model->htmlencode($this->input->post('emailida'));
					$passworda 	= $this->Common_model->htmlencode($this->input->post('passworda'));

					$costvalue = $this->Common_model->costvalue;
					$options = ['cost' => $costvalue];
					$inspwdfrdb = password_hash("$passworda", PASSWORD_BCRYPT, $options);

					$query_data = array(
						'fullname'		=> $fullname,
						'contact'       => $contact,
						'email_id'	    => $emailida,
						'password'		=> $inspwdfrdb,
						'status'		=> 0,
						'created_date'	=> $date
					);

					$insert_rec = $this->Common_model->insert_records("tbl_customers", $query_data);
					if ($insert_rec) {
						$insertid = $this->db->insert_id();
						$link = base_url() . 'linktrack?ekoPVBKRO4IWOBDYAY=' . base64_encode($insertid) . '__' . base64_encode($emailida);
						$subjecto = "My Holiday Happiness - Verify your Email Address";

						$messages = "<!doctype html>
					<html>
					<head>
						<meta charset='utf-8'>
					</head>
					<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
					<div style='width: 100%;background:#F5F5F5;color: #000;'> 
					<div style='padding:30px 30px 30px 30px;'>       
					  <div style='text-align:center'><a href='" . base_url() . "'><img src='" . base_url() . "assets/images/logo.png' style='margin:auto; margin-top:12px; margin-bottom:12px'></a>
					  </div>
					  
					 <div style='background-color:#FFF;border:#EAEAEA 1px solid; padding:15px;'>

						<p style='margin-top:30px;'>
							Hi $fullname, <br>
							Thanks for signing up with My Holiday Happiness (MHH).You can browse through our website for travel/Honeymoon/Family/Leisure packages and get the best in quality service and lowest possible prices.<br>
							
							To finish signing up, please confirm your email address $emailida 
							
							<div style='clear:both'></div>
							<div style='text-align:center; margin-top:12px'>
								<a href='$link' style='display:inline-block; background-color:#e4222e;color:#fff; padding:8px 22px; text-decoration:none !important;' target='_blank'>Confirm email address</a>
							</div>
							<div style='clear:both'></div>
						
						</p>
						
							<div style='font-size:12px; color:#616161; text-align:center; margin-top:12px;padding-top:30px; padding-bottom:10px'>
							 Button not working? Use the link below: <br>
						  <a href='$link' style='text-decoration:none !important;'>$link</a>
						  </div>
					 </div>
						  
						  <div style='background-color:#FFF;border:#EAEAEA 1px solid; text-align:center; margin-top:12px; padding-top:30px; padding-bottom:10px'>
							If you need immediate assistance for any of the package you can write us on support@myholidayhappiness.com or call us @ +91 98865 25253
						  </div>
						  
						  <div style='font-size:12px; color:#616161; text-align:center; margin-top:12px;border-top:#E9E9E9 1px solid; padding-top:30px; padding-bottom:10px'>
						  <a href='" . base_url() . "contactus' style='color:#616161; text-decoration:underline'>Contact Us</a>
						  <span style='display:block;'>You're receiving this email as a registered user of <a href='" . base_url() . "' style='color:#616161; text-decoration:underline'>My Holiday Happiness</a></span>
						  </div>
					  </div>        
					</div>
					</body>";

						/** Start - Sending Mail **/
						$mailconfig = array(
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE,
							'newline' => '\n',
							'crlf' => '\n'
						);

						$from_mail = $this->Common_model->show_parameter(9);
						$this->load->library('email', $mailconfig);

						$headers = 'From:  myholidayhappiness.com <' . $from_mail . ">\r\n" .
							'Reply-To: Holidays Toor <' . $from_mail . ">\r\n" .
							'X-Mailer: PHP/' . phpversion();
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
						mail($emailida, $subjecto, $messages, $headers);

						$this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> You have created account successfully. We have sent you an email. Please check your in box or spam box to confirm email id.</div>');
						redirect(base_url() . 'register', 'refresh');
					} else {
						$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Account could not created. Please try again.</div>');
					}
				} else {
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			} else {
				$this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i>reCAPTCHA verification failed. Please try again.</div>');
				redirect(base_url() . 'register', 'refresh');
			}
		}
		$this->load->view('register', $data);
	}

	public function booking_signup()
	{
		$status 	= "error";
		$message	= "";	

		$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
		if ($recaptchaResponse)  //Captcha Successfull
		{
			$this->form_validation->set_message('required', '{field} can not be empty.');
			$this->form_validation->set_message('min_length', '{field} must be at least {param} characters long.');
			$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
			$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');
			$this->form_validation->set_message('regex_match', '{field} must be a valid 10 digit number.');

			$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('contact', 'Phone No', 'trim|required|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('emailida', 'Email id', 'trim|required|valid_email|max_length[80]|is_unique[tbl_customers.email_id]');			
			$this->form_validation->set_rules('passworda', 'Password', 'trim|required|min_length[6]|max_length[15]');
			$this->form_validation->set_rules('cpassworda', 'Confirm Password', 'trim|required|matches[passworda]');

			if ($this->form_validation->run() == FALSE) {
				$errorMsg	= "";

				if(!empty(form_error('fullname'))){
					$errorMsg	= form_error('fullname');
				} else if(!empty(form_error('contact'))){
					$errorMsg	= form_error('contact');
				} else if(!empty(form_error('emailida'))){
					$errorMsg	= form_error('emailida');
				} else if(!empty(form_error('passworda'))){
					$errorMsg	= form_error('passworda');
				} else {
					$errorMsg	= "Fill all mandatory fields with valid data.";
				}

				$status 	= "error";
				$message	= $errorMsg;
			} else {
				$fullname = $this->Common_model->htmlencode($this->input->post('fullname'));
				$contact = $this->Common_model->htmlencode($this->input->post('contact'));
				$emailida = $this->Common_model->htmlencode($this->input->post('emailida'));
				$passworda = $this->Common_model->htmlencode($this->input->post('passworda'));

				$noof_user = $this->Common_model->noof_records("email_id", "tbl_customers", "email_id='$emailida'");
				if ($noof_user < 1) {
					$company_mail = $this->Common_model->show_parameter(2);
					$date = date("Y-m-d H:i:s");

					$costvalue = $this->Common_model->costvalue;
					$options = ['cost' => $costvalue];
					$inspwdfrdb = password_hash("$passworda", PASSWORD_BCRYPT, $options);

					$query_data = array(
						'fullname'		=> $fullname,
						'contact'       => $contact,
						'email_id'	    => $emailida,
						'password'		=> $inspwdfrdb,
						'status'		=> 1,
						'created_date'	=> $date
					);

					$insert_rec = $this->Common_model->insert_records("tbl_customers", $query_data);
					if ($insert_rec) {
						$customer_id = $this->db->insert_id();
						$sess_array = array(
							'customer_id' => $customer_id,
							'fullname' => $fullname,
							'email_id' => $emailida,
							'sess_id' => session_id()
						);
						$this->session->set_userdata($sess_array);

						/*******************mail Start*********************/
						$subjecto = "My Holiday Happiness - Verify your Email Address";
						$messages = "<!doctype html>
						<html>
						<head>
							<meta charset='utf-8'>
						</head>
						<body style='font-family:sans-serif;font-size:13px; line-height:22px;'>
						<div style='width: 100%;background:#F5F5F5;color: #000;'> 
						<div style='padding:30px 30px 30px 30px;'>       
						<div style='text-align:center'><a href='" . base_url() . "'><img src='" . base_url() . "assets/images/logo.png' style='margin:auto; margin-top:12px; margin-bottom:12px'></a>
						</div>
						
						<div style='background-color:#FFF;border:#EAEAEA 1px solid; padding:15px;'>

							<p style='margin-top:30px;'>
								Hi $fullname, <br>
								Thank you for registration in My Holiday Happiness. Your email address has been confirmed.							
								<div style='clear:both'> $emailida </div>
							</p>
						</div>
							<div style='font-size:12px; color:#616161; text-align:center; margin-top:12px;border-top:#E9E9E9 1px solid; padding-top:30px; padding-bottom:10px'>
							<a href='" . base_url() . "contactus' style='color:#616161; text-decoration:underline'>Contact Us</a>
							<span style='display:block;'>You're receiving this email as a registered user of <a href='" . base_url() . "' style='color:#616161; text-decoration:underline'>My Holiday Happiness</a></span>
							</div>
						</div>        
						</div>
						</body>";

						/** Start - Sending Mail **/
						$mailconfig = array(
							'mailtype' => 'html',
							'charset' => 'iso-8859-1',
							'wordwrap' => TRUE,
							'newline' => '\n',
							'crlf' => '\n'
						);

						$from_mail = $this->Common_model->show_parameter(9);		
						$headers = 'From:  myholidayhappiness.com <' . $from_mail . ">\r\n" .
							'Reply-To: Holidays Toor <' . $from_mail . ">\r\n" .
							'X-Mailer: PHP/' . phpversion();
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
						mail($emailida, $subjecto, $messages, $headers);

						/********************End mail***********************/
						$status 	= "success";
						$message	= "Login successful";
					} else {
						$status 	= "error";
						$message	= "Could not proceed to signup. Please try again.";
					}
				} else {
					$status 	= "error";
					$message	= "Email id is already exist. Please enter another email id.";
				}
			}
		}else {
			$status 	= "error";
			$message	= "reCAPTCHA verification failed. Please try again.";
		}
		echo json_encode(array('status' => $status, 'message' => $message));
		exit();
	}

	public function check_email()
	{
		$chkemail = $_REQUEST["chkemail"];
		$num_dup = $this->Common_model->noof_records("customer_id", "tbl_customers", "email_id='$chkemail'");
		if ($num_dup > 0)
			echo (json_encode(false)); // if there's something matching
		else
			echo (json_encode(true)); // if there's nothing matching
		exit();
	}

}
