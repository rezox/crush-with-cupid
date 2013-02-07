<?php
class Crush extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
		$this->load->model('crushes_model');
	}

	function index_post()
	{
		$from = $this->post('from');
		$to = $this->post('to');

		if (empty($from) || empty($to))
			return $this->response(array('error' => 'Parameters missing.'), 400);

		$this->crushes_model->add($from, $to);
		return $this->response(array('success' => 'Added.'));
	}

}