<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tour_packages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="errormsg notification"><i class="fa fa-times"></i> ', '</div>');
        $this->load->database();
        $this->load->library('pagination');
        $this->load->model('Common_model');
    }

    public function index() {
        $noof_rec = $this->Common_model->noof_records("DISTINCT(a.tagid) as tagid", "tbl_menutags as a, tbl_menucateories as b", "a.cat_id = b.catid and a.menuid=3 and a.status = 1 and a.tagid IN (SELECT tagid FROM `tbl_tags` WHERE type=3)");

        if ($noof_rec > 0) {
            $config['base_url'] = base_url() . 'tour-packages/page/';
            $config['first_url'] = base_url() . 'tour-packages';
            $config["uri_segment"] = 3;
            $config['total_rows'] = $noof_rec;
            $config['per_page'] = 20;
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
            if ($page > 1)
                $startm = $page - 1;
            $startfrom = $per_page * $startm;
            $data['startfrom'] = $startfrom;
            $data['pagination'] = $this->pagination->create_links();

            $data['allTpackages'] = $this->Common_model->join_records("a.*, b.cat_name", "tbl_menutags as a", "tbl_menucateories as b", "a.cat_id=b.catid", "a.menuid=3 and a.status=1 and a.tagid IN (SELECT tagid FROM `tbl_tags` WHERE type=3)", "tag_name asc", "$per_page", "$startfrom");

            $this->load->view('tour_packages', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

}
