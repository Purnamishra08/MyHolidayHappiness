<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('session');
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('Common_model');
		
		if($this->session->userdata('customer_id') == "")
		{
			redirect(base_url().'logout','refresh');
		}
    }

    public function index() {
        $customer_id = $this->session->userdata('customer_id');
		$data['bookings'] = $this->Common_model->get_records("*","tbl_bookings","customer_id='$customer_id'");
        $this->load->view('booking', $data);
    }

}
