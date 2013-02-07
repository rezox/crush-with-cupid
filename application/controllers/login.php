<?php

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('fb');
	}

	function index()
	{
		if (!$this->fb->is_logged_in())
			return redirect('/', 'refresh');

		$user = $this->fb->get_user();

		$this->load->model('users_model');
		if (!$user = $this->users_model->find_by_fbid($user['uid']))
			$user = $this->users_model->add($user);

		return redirect('/choose', 'refresh');
	}

}