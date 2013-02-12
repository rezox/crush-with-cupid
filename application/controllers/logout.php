<?php

class Logout extends CI_Controller {

	function index()
	{
		$this->load->library('fb');
		$this->load->library('session');
		$this->fb->clear_session();
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}

}