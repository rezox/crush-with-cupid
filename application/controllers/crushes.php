<?php
class Crushes extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
		$this->load->model('crushes_model');
	}

	function index_get()
	{
		$user = $this->fb->get_user();
		$user = $user['uid'];

		$this->response($this->crushes_model->get($user));
	}

	function index_post()
	{
		// $from = $this->post('from');
		$to = $this->post('to');

		$user = $this->fb->get_user();
		$from = $user['uid'];

		if (empty($from) || empty($to))
			return $this->response(array('error' => 'Parameters missing.'), 400);

		$this->crushes_model->add($from, $to);
		return $this->response(array('success' => 'Added.'));
	}

}