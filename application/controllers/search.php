<?php

class Search extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
	}

	function index()
	{
		if (!is_logged_in())
			return redirect('/', 'refresh');

		$this->load->view('include/header');
		$this->load->view('search');
		$this->load->view('include/footer');
	}

}