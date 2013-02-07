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
			redirect('/', 'refresh');

		$user = $this->fb->get_user();

		$this->load->model('users_model');
		if (!$this->users_model->find($user['uid']))
			$this->users_model->add($user);

		$this->load->view('include/header');
		$this->load->view('choose');
		$this->load->view('include/footer');
	}

}