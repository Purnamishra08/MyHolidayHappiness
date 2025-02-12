<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

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
	}


	
		public function index()
	{
		$data['message'] = $this->session->flashdata('message'); $wheresearch = ""; $search = ""; $datemnthcond = "";
			$data['archivedmnth']='';
			if (isset($_REQUEST['archive']) && !empty($_REQUEST['archive'])) {
				$datemonthps = $_REQUEST['archive'];
				$datemnthcond=" and DATE_FORMAT(created_date, '%Y-%m')='$datemonthps'";
				$data['archivedmnth']=$datemonthps;
			}

			if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
			$search = $_REQUEST['search'];
			$wheresearch = "title LIKE '%$search%' OR content LIKE '%$search%' and status='1' $datemnthcond";
			}
			 else { 
			 	$wheresearch = "status=1 $datemnthcond"; 
			 }
		
		$pagesrch = "";
		if($search!='') {
			$pagesrch = "?search=".$search;
		}
		$data['search']=$search;
		/** Pagination Config **/
		$noof_record = $this->Common_model->noof_records("blogid","tbl_blog","$wheresearch");
		$config['suffix'] = $pagesrch;
		$config['base_url'] = base_url().'blog/page/';
		$config['first_url'] = base_url().'blog'.$pagesrch;
		$config["uri_segment"] = 3;
		$config['total_rows'] = $noof_record;
		$config['per_page'] = $this->Common_model->per_page;
		$config["num_links"] = $this->Common_model->num_links;
		$config["use_page_numbers"] = TRUE;
		//config for bootstrap pagination class integration
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = "&laquo First";
		$config['last_link'] = "Last &raquo";
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$per_page = $config["per_page"];
		$startm = $page;
		if($page>1)
			$startm = $page-1;
		$startfrom = $per_page*$startm;
		$data['startfrom'] = $startfrom;
		/** Pagination Config **/
		$data['row'] = $this->Common_model->get_records("*","tbl_blog","$wheresearch","blogid DESC","$per_page","$startfrom");
		$data['pagination'] = $this->pagination->create_links();
		$data['noofrecval']=$noof_record;
		$this->load->view('blog',$data);
	}

}
