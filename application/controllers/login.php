<?php

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
		$this->load->library('session');
	}

	function index()
	{
		if (!$this->fb->is_logged_in())
			return redirect('/', 'refresh');

		$user = $this->fb->get_user();
      if (!isset($user['uid']) || empty($user['uid']))
         redirect('/logout', 'refresh');

		$this->load->model('users_model');
		if (!$this->users_model->find($user['uid']))
			$this->users_model->add($user);

		$this->session->set_userdata('user', $user['uid']);

		return redirect('/search', 'refresh');
	}

}
