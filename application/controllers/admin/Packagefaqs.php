<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packagefaqs extends CI_Controller {

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
		if(!(in_array(16, $allusermodules))) {
			redirect(base_url().'admin/dashboard','refresh');
		}
 	}

	public function index()
	{
		$data['message'] = $this->session->flashdata('message');
		// $data['row'] = $this->Common_model->join_records("a.*, b.tag_name","tbl_package_faqs as a","tbl_menutags as b", "a.tag_id = b.tagid", "","b.tag_name ASC, a.faq_order ASC");
		$this->load->view('admin/manage_packagefaqs',$data);
	}

	public function datatable(){
		$arrPageData = $_REQUEST;
		$packageid = isset($arrPageData['packageid']) ? $arrPageData['packageid'] : 0;
		$question = isset($arrPageData['question']) ? $arrPageData['question'] : "";
		$answer = isset($arrPageData['answer']) ? $arrPageData['answer'] : "";
		$statusid = isset($arrPageData['statusid']) ? $arrPageData['statusid'] : 0;
		$whereCond = '';
		if($packageid > 0){
			$whereCond .= "(tag_id = $packageid) and ";
		}
		if($question != ''){
			$whereCond .= "(faq_question like '%".$question."%') and ";
		}
		if($answer != ''){
			$whereCond .= "(faq_answer like '%".$answer."%') and ";
		}
		if($statusid > 0){
			if($statusid == 1){
				$whereCond .= "status = $statusid and ";
			} else {
				$whereCond .= "status = 0 and";
			}
		}
		$whereCond = rtrim($whereCond, " and ");
 
		$rowCnt = $this->Common_model->noof_records("faq_id","tbl_package_faqs","$whereCond");
		if ($arrPageData['length'] == -1) {
			$rows = $this->Common_model->get_records("*","tbl_package_faqs","$whereCond", " faq_order ASC");
		} else {
			$rows = $this->Common_model->get_records("*","tbl_package_faqs","$whereCond", " faq_order ASC",$arrPageData['length'], $arrPageData['start']);
		}

		if(!empty($rows) && count((array)$rows) > 0) {
			foreach ($rows as $key => $val) {
				$rows[$key]['sl_no'] = ++$arrPageData['start'];

				$packageid   	= $rows[$key]['tag_id'];
				$rows[$key]['tag_name'] = $this->Common_model->showname_fromid("tpackage_name","tbl_tourpackages","tourpackageid = $packageid");
				$rows[$key]['faq_answer'] = $this->Common_model->short_str($rows[$key]['faq_answer'], 251);
				$rows[$key]['created_date'] = $this->Common_model->dateformat($rows[$key]['created_date']);
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

	public function add()
	{
		$data['message'] = $this->session->flashdata('message');

		if (isset($_POST['btnSubmitFaq']) && !empty($_POST))
		{
			$this->form_validation->set_rules('tag_name', 'tag_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('faq_question', 'faq_question', 'trim|required|xss_clean');
			$this->form_validation->set_rules('faq_answer', 'faq_answer', 'trim|required');
			$sess_userid = $this->session->userdata('userid');
			$date = date("Y-m-d H:i:s");
			if ($this->form_validation->run() == true)
			{
				$tag_name 		= stripslashes($this->input->post('tag_name'));
				$faq_question 		= stripslashes($this->input->post('faq_question'));
				$faq_answer 		= stripslashes($this->input->post('faq_answer'));
				$faq_order 		= $this->input->post('faq_order');


				$insert_data = array(
					'tag_id'	=> $tag_name,
					'faq_question'	=> $faq_question,
					'faq_answer'	=> $faq_answer,
					'faq_order'	=> $faq_order,					
					'status'	=> 1,
					'created_date'	=> $date,
					'created_by'	=> $sess_userid
				);

				$insertdb = $this->Common_model->insert_records('tbl_package_faqs', $insert_data);
				if($insertdb)
				{
					$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Package Faqs added successfully.</div>');
				}
				else
				{
					$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Package Faqs could not added. Please try again.</div>');
				}
				redirect(base_url().'admin/packagefaqs/add','refresh');
			}
			else
			{
				//set the flash data error message if there is one
				$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
			}
		}
		$this->load->view('admin/add_packagefaqs',$data);
	}

	public function changestatus()
	{
		$stsid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("faq_id","tbl_package_faqs","faq_id='$stsid'");
		if($noof_rec>0)
		{
			$status = $this->Common_model->showname_fromid("status","tbl_package_faqs","faq_id=$stsid");
			if($status==1)
				$updatedata = array('status' => 0);
			else
				$updatedata = array('status' => 1);
			$updatestatus = $this->Common_model->update_records("tbl_package_faqs",$updatedata,"faq_id=$stsid");
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
		$noof_rec = $this->Common_model->noof_records("faq_id","tbl_package_faqs","faq_id='$delid'");
		if($noof_rec>0)
		{
			$del = $this->Common_model->delete_records("tbl_package_faqs","faq_id=$delid");
			if($del)
				$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Package Faqs has been deleted successfully.</div>');
			else
				$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Package Faqs could not deleted. Please try again.</div>');
		}
		redirect(base_url().'admin/packagefaqs','refresh');
	}

	public function edit()
	{
		$editid = $this->uri->segment(4);
		$noof_rec = $this->Common_model->noof_records("faq_id","tbl_package_faqs","faq_id='$editid'");

		if($noof_rec>0)
		{
			$data['message'] = $this->session->flashdata('message');
			$data['faq_details'] = $this->Common_model->get_records("*","tbl_package_faqs","faq_id = $editid","");

			if (isset($_POST['btnEditFaq']) && !empty($_POST))
			{
				$this->form_validation->set_rules('tag_name', 'tag_name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('faq_question', 'faq_question', 'trim|required|xss_clean');
			   $this->form_validation->set_rules('faq_answer', 'faq_answer', 'trim|required');

				$sess_userid = $this->session->userdata('userid');
				$date = date("Y-m-d H:i:s");
				if ($this->form_validation->run() == true)
				{
					$tag_name= stripslashes($this->input->post('tag_name'));
					$faq_question= stripslashes($this->input->post('faq_question'));
					$faq_answer = stripslashes($this->input->post('faq_answer'));
					$faq_order = $this->input->post('faq_order');

					$noof_duprec = $this->Common_model->noof_records("faq_id","tbl_package_faqs","tag_id = '$tag_name' and faq_question='$faq_question' and faq_id!='$editid'");
					if($noof_duprec < 1)
					{
						$update_data = array(
							'tag_id'=> $tag_name,
							'faq_question'=> $faq_question,
							'faq_answer' => $faq_answer,
							'faq_order'	=> $faq_order,	
							'updated_date'	=> $date,
							'updated_by'	=> $sess_userid
						);
						$updatedb = $this->Common_model->update_records('tbl_package_faqs',$update_data,"faq_id=$editid");
						if($updatedb)
						{

							$this->session->set_flashdata('message','<div class="successmsg notification"><i class="fa fa-check"></i> Package Faqs edited successfully.</div>');
						}
						else
						{
							$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> Package Faqs could not edited. Please try again.</div>');
						}
					}
					else
					{
						$this->session->set_flashdata('message','<div class="errormsg notification"><i class="fa fa-times"></i> The Question field must contain a unique value.</div>');
					}
					redirect(base_url().'admin/packagefaqs/edit/'.$editid,'refresh');
				}
				else
				{
					//set the flash data error message if there is one
					$data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
				}
			}
			$this->load->view('admin/edit_packagefaqs', $data);
		}
		else
			redirect(base_url().'admin/packagefaqs','refresh');

	}

	

}
