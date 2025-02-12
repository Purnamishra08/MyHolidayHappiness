<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Single_blog extends CI_Controller {

	public function __construct()
 	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Common_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		$this->load->library('pagination');
		$this->session->userdata('userid');
 	}

	public function index()
	{

		$data['message'] = $this->session->flashdata('message'); 
		$viewurl = $this->uri->segment(2);
		//echo "asdfsadf-$viewid";die();
		 $noof_rec = $this->Common_model->noof_records("blogid","tbl_blog","blog_url='$viewurl'");
		if($noof_rec>0)
		{
			$data['row'] = $this->Common_model->get_records("*","tbl_blog","blog_url='$viewurl' ","");
			$this->load->view('single_blog', $data);

		}
		else
			redirect(base_url().'blog','refresh');
	}

	public function comment()
	{
		if (isset($_POST['btnSubmit']) && !empty($_POST))
		{
			$status 	= "error";
			$message	= "";			
			$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
			if ($recaptchaResponse)  //Captcha Successfull
			{
				$this->form_validation->set_message('required', '{field} can not be empty.');
				$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
				$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');

				$this->form_validation->set_rules('comment', 'Comment', 'trim|required|max_length[550]');
				$this->form_validation->set_rules('username', 'Name', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('emailid', 'Email', 'trim|required|valid_email|max_length[80]');

				if ($this->form_validation->run() == FALSE) {
					$errorMsg	= "";
					if(!empty(form_error('comment'))){
						$errorMsg	= form_error('comment');
					} else if(!empty(form_error('username'))){
						$errorMsg	= form_error('username');
					} else if(!empty(form_error('emailid'))){
						$errorMsg	= form_error('emailid');
					} else {
						$errorMsg	= "Fill all mandatory fields with valid data.";
					}
	
					$status 	= "error";
					$message	= $errorMsg;
				} else {
					$comment = $this->Common_model->htmlencode($this->input->post('comment'));
					$username = $this->Common_model->htmlencode($this->input->post('username'));
					$emailid = $this->Common_model->htmlencode($this->input->post('emailid'));
					$disid = $this->Common_model->htmlencode($this->input->post('disid'));
					$date = date("Y-m-d H:i:s");
					
					$insert_data = array(
						'blogid'     => $disid,
						'user_name'     => $username,
						'email_id'		=> $emailid,
						'comments'		=> $comment,
						'status'		=> 0,
						'created_date'	=> $date
					);
					
					$insertdb = $this->Common_model->insert_records('tbl_comments', $insert_data);
					$status 	= "success";
					$message	= "Thanks for your Comment.";
				}
			} else {
				$status 	= "error";
				$message	= "reCAPTCHA verification failed. Please try again.";
			}	
			echo json_encode(array('status' => $status, 'message' => $message));		
		}
		exit();
	}

	public function comment_reply()
	{
		$status 	= "error";
		$message	= "";	

		$recaptchaResponse = $this->Common_model->verifyCaptcha($this->input->post('g-recaptcha-response'));
		if ($recaptchaResponse)  //Captcha Successfull
		{
			$this->form_validation->set_message('required', '{field} can not be empty.');
			$this->form_validation->set_message('max_length', '{field} cannot exceed {param} characters.');
			$this->form_validation->set_message('valid_email', 'Please provide a valid email id.');

			$this->form_validation->set_rules('comment1', 'Comment', 'trim|required|max_length[550]');
			$this->form_validation->set_rules('username1', 'Name', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('emailid1', 'Email', 'trim|required|valid_email|max_length[80]');

			if ($this->form_validation->run() == FALSE) {
				$errorMsg	= "";
				if(!empty(form_error('comment1'))){
					$errorMsg	= form_error('comment1');
				} else if(!empty(form_error('username1'))){
					$errorMsg	= form_error('username1');
				} else if(!empty(form_error('emailid1'))){
					$errorMsg	= form_error('emailid1');
				} else {
					$errorMsg	= "Fill all mandatory fields with valid data.";
				}

				$status 	= "error";
				$message	= $errorMsg;
			} else {				
				$reply_comment 	= $this->Common_model->htmlencode($this->input->post('comment1'));
				$username 		= $this->Common_model->htmlencode($this->input->post('username1'));
				$emailid 		= $this->Common_model->htmlencode($this->input->post('emailid1'));	
				$reply_disid 	= $this->Common_model->htmlencode($this->input->post('reply_disid'));
				$reply_commentid= $this->Common_model->htmlencode($this->input->post('reply_commentid'));
				$date = date("Y-m-d H:i:s");							
				
				$insert_data = array(
					'blogid'     	=> $reply_disid,
					'parentid'     => $reply_commentid,
					'user_name'     => $username,
					'email_id'		=> $emailid,
					'comments'		=> $reply_comment,
					'status'		=> 0,
					'created_date'	=> $date
				);
				
				$insertdb = $this->Common_model->insert_records('tbl_comments', $insert_data);
				$status 	= "success";
				$message	= "Thanks for your Comment.";
			}
		} else {
			$status 	= "error";
			$message	= "reCAPTCHA verification failed. Please try again.";
		}
		echo json_encode(array('status' => $status, 'message' => $message));
		exit();
	}

}
