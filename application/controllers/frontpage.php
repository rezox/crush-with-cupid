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
		if ($this->fb->is_logged_in())
			redirect('/find', 'refresh');

		$this->load->view('include/header');
		$this->load->view('frontpage', array(
			'facebook_auth_url' => $this->fb->get_auth_url(site_url('/find'))
		));
		$this->load->view('include/footer');
	}

}