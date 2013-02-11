<?php

class Pairs extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
		$this->load->model('crushes_model');
	}

	function index_get()
	{
		if (!$this->fb->is_logged_in())
			$this->response(array('error' => 'Requries authentication.'), 401);

		$user = $this->fb->get_user();
		$user = $user['uid'];

		$pairs = $this->crushes_model->get_pairs($user);
		$pairs[] = '0'; // hotfix

		$this->response($pairs);
	}

}