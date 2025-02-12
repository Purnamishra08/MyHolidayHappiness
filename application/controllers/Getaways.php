<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getaways extends CI_Controller {

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
	}
	
 	public function index()
 	{
		$cat_slug = $this->uri->segment(2);
 		$getawayurl = $this->uri->segment(3);
 	
		if(!empty($getawayurl))
		{
			// fetch all categories to match it with the url segment
			$data_cat = $this->Common_model->get_records("*","tbl_menucateories","menuid=1 and status='1'","");
			$cat_arr = []; $final_catid = 0;
			if(!empty($data_cat)){
				foreach($data_cat as $row) {
					$catid = $row['catid'];
					$cat_name = $row['cat_name'];
					$seocat_name = $this->Common_model->makeSeoUrl($cat_name);
					$cat_arr[] = $seocat_name;
					if($seocat_name == $cat_slug) {
						$final_catid = $catid;
					}
				}
			}
			if( !in_array($cat_slug, $cat_arr) ) {
				redirect(base_url(),'refresh');
			}

			$getawayurl = $this->db->escape($getawayurl);
			$validgetaway = $this->Common_model->noof_records("tagid","tbl_menutags","tag_url=$getawayurl and cat_id=$final_catid and menuid=1 and status='1'");
			if($validgetaway>0)
			{
				$data['getawaydata']=$this->Common_model->get_records("*","tbl_menutags","tag_url=$getawayurl and cat_id=$final_catid and menuid=1 and status='1'","");
				
				$this->load->view('getaways', $data);
			}
			else
				redirect(base_url(),'refresh');
		} else if(!empty($cat_slug))
		{
		    $cat_arr = []; $final_catid = 0;
		    	$data_cat = $this->Common_model->get_records("*","tbl_menucateories","menuid=1 and status='1'","");
			if(!empty($data_cat)){
				foreach($data_cat as $row) {
					$catid = $row['catid'];
					$cat_name = $row['cat_name'];
					$seocat_name = $this->Common_model->makeSeoUrl($cat_name);
					$cat_arr[] = $seocat_name;
					if($seocat_name == $cat_slug) {
						$final_catid = $catid;
					}
				}
			}
		
		    
			$validgetaway = $this->Common_model->noof_records("tagid","tbl_menutags"," cat_id=$final_catid and menuid=1 and status='1'");
		
			if($validgetaway>0)
			{
				//$data['getawaydata']=$this->Common_model->get_records("*","tbl_menutags","  cat_id=$final_catid and menuid=1 and status='1'","");
				$data['getawaydata'] = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b", "a.cat_id=b.catid", "a.menuid=1 and a.status=1 ", "tag_name asc");
                  $data['cat_slug'] =$cat_slug;  
				
				$this->load->view('menu_getaways', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
		else{
		    
			$getawayurl = $this->db->escape($getawayurl);
			$validgetaway = $this->Common_model->noof_records("tagid","tbl_menutags","  menuid=1 and status='1'");
			if($validgetaway>0)
			{
			    //	$data['getawaydata']=$this->Common_model->get_records("*","tbl_menutags"," menuid=1 and status='1'","");
				 $data['getawaydata'] = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b", "a.cat_id=b.catid", "a.menuid=1 and a.status=1 ", "tag_name asc");
                 
				$this->load->view('menu_getaways', $data);
			}
			else
				redirect(base_url(),'refresh');
		}
		
	}
}


