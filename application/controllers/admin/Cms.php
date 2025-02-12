<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
        $this->load->database();
        $this->load->model('Common_model');
        if ($this->session->userdata('userid') == "") {
            redirect(base_url() . 'admin/logout', 'refresh');
        }
        $allusermodules = $this->session->userdata('allpermittedmodules');
        if (!(in_array(3, $allusermodules))) {
            redirect(base_url() . 'admin/dashboard', 'refresh');
        }
    }

    public function index() {
        $content_id = $this->uri->segment(3);
        if ($content_id == '') {
            $content_id = 1;
        }
        $noof_rec = $this->Common_model->noof_records("content_id", "tbl_contents", "content_id='$content_id'");
        if ($noof_rec > 0) {
            $data['message'] = $this->session->flashdata('message');
            $data['row'] = $this->Common_model->get_records("*", "tbl_contents", "content_id='$content_id'", "content_id ASC");
            if (isset($_POST['btnSubmit']) && !empty($_POST)) {
                //$this->form_validation->set_rules('editor', 'Description', 'trim|required');

                $sess_userid = $this->session->userdata('userid');
                $date = date("Y-m-d H:i:s");
                //if ($this->form_validation->run() == true)
                //{
                $page_content = $this->input->post('editor');
                $seo_title = $this->input->post('seo_title');
                $seo_description = $this->input->post('seo_description');
                $seo_keywords = $this->input->post('seo_keywords');

                 if ($seo_description == '') {
                     $seo_description = NULL;
                 }
                 if ($seo_keywords == '') {
                     $seo_keywords = NULL;
                 }
                $update_data = array(
                    'page_content' => $page_content,
                    'seo_title' => $seo_title,
                    'seo_description' => $seo_description,
                    'seo_keywords' => $seo_keywords
                );

                $updatedb = $this->Common_model->update_records('tbl_contents', $update_data, "content_id='$content_id'");
                if ($updatedb) {
                    $this->session->set_flashdata('message', '<div class="successmsg notification"><i class="fa fa-check"></i> Page details saved successfully.</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="errormsg notification"><i class="fa fa-times"></i> Page details could not saved. Please try again.</div>');
                }
                redirect(base_url() . 'admin/cms/' . $content_id, 'refresh');
                /* }
                  else
                  {
                  //set the flash data error message if there is one
                  $data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
                  } */
            }
            $this->load->view('admin/cms', $data);
        } else
            redirect(base_url() . 'admin/cms', 'refresh');
    }

}
