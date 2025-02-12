<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {

	public function __construct()
 	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
		$this->load->database();
		$this->load->library('pagination');
		$this->load->model('Common_model');
		if($this->session->userdata('userid') == "")
		{
			redirect(base_url().'admin/logout','refresh');
		}
		$allusermodules = $this->session->userdata('allpermittedmodules');
		if(!(in_array(3, $allusermodules))) 
		{
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{	
			$data['message'] = $this->session->flashdata('message');
		/** Pagination Config **/
		$data['row'] = $this->Common_model->get_records("*","tbl_comments","","commentid DESC","","");
		$this->load->view('admin/comments',$data);
	}
	


public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("commentid","tbl_comments","commentid='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_comments","commentid=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_comments",$updatedata,"commentid=$stsid");
			if($updatestatus)
				echo $status;
			else
				echo "error";
		}
		exit();
	}
	



	public function delete()
	{
		$delid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("commentid","tbl_comments","commentid='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_comments","commentid=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Comment has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Comment could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/comments','refresh');
	}



public function edit()
	{
		$data['message'] = $this->session->flashdata('message');
		$editid = $this->uri->segment(4);

		$noof_rec = $this->Common_model->noof_records("commentid", "tbl_comments", "commentid='$editid'");
		if($noof_rec > 0)
		{
			$data['row'] = $this->Common_model->get_records("*","tbl_comments","commentid=$editid","");
			if (isset($_POST['comment']) && !empty($_POST))
			{
				
				$this->form_validation->set_rules('comment', 'comment', 'trim|required|xss_clean');
				
				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
					$emailid = $this->input->post('emailid');
					$username = $this->input->post('username');
					$comment = $this->input->post('comment');
					
					
					$query_data = array(
						'email_id'			=>	$emailid,
						'user_name'			=>	$username,
						'comments'		=>	$comment,
						'updated_date'		=>	$date,
						'updated_by'		=>	$sess_userid
						
						
					);
					
					$updatedb = $this->Common_model->update_records('tbl_comments',$query_data,"commentid=$editid");
					if($updatedb)
						$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Comment edited successfully.</div>');
					else
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Comment could not edited. Please try again.</div>');
					
					redirect(base_url().'admin/comments/edit/'.$editid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_comments',$data);
		}
		else
		{
			redirect(base_url().'admin/comments','refresh');
		}
	}
	 

}