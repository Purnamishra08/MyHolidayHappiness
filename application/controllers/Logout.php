<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url','form');
		$this->load->library('session');
		$this->load->database();
	}
	
	public function index()
	{
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}
}