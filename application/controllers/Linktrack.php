<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linktrack extends CI_Controller {
	
	public function __construct()
 	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->database();
		$this->load->model('Common_model');
 	}
	
	public function index()
	{		
		$data['message'] = ""; $valid = "";
		if(isset($_REQUEST['ekoPVBKRO4IWOBDYAY']))
		{
			$request = $_REQUEST['ekoPVBKRO4IWOBDYAY'];
			list($ide,$emaile) = explode("__",$request);
			$id = base64_decode($ide);
			$email = base64_decode($emaile);
			
			$noof_rec = $this->Common_model->noof_records("customer_id","tbl_customers","email_id='$email' and customer_id='$id' and status=0");
			if($noof_rec > 0)
			{
				$valid = 1;
				$updatedata = array('status' => 1);
				$updaterecord = $this->Common_model->update_records("tbl_customers",$updatedata,"email_id='$email' and customer_id='$id'");
				if($updaterecord) {
					$data['message'] = "success";
				}
				else {
					$data['message'] = "error";
				}
			}
		}
		
		if($valid == 1)
			$this->load->view('linktrack',$data);
		else
		{			
			$this->output->set_status_header('404');
			$data['pagetitle'] = '404 Page Not Found';
			$this->load->view('404error',$data);

		}
	}
}
