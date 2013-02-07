<?php

class Find extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
		$this->load->model('friends_model');
	}

	function index()
	{
		if (!$this->fb->is_logged_in())
			redirect('/', 'refresh');

		$this->load->view('include/header');
		$this->load->view('include/footer');
	}

}