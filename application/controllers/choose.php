<?php

class Choose extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
	}

	function index()
	{
		if (!$this->fb->is_logged_in())
			return redirect('/', 'refresh');

		$this->load->view('include/header');
		$this->load->view('choose');
		$this->load->view('include/footer');
	}

}