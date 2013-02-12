<?php

class Frontpage extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
	}

	function index()
	{
		if (is_logged_in())
			return redirect('/search', 'refresh');

		$this->load->view('include/header');
		$this->load->view('frontpage');
		$this->load->view('include/footer');
	}

}
