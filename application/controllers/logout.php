<?php

class Logout extends CI_Controller {

	function index()
	{
		$this->load->library('fb');
		$this->fb->clear_session();
		redirect('/', 'refresh');
	}

}