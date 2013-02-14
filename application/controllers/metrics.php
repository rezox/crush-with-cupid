<?php 

class Metrics extends CI_Controller
{

	function index()
	{
		$ips = array(
			'97.107.130.57'
		);

		if (!in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $ips))
			show_404();

		$this->load->model(array(
			'crushes_model',
			'users_model',
			'emails_model'
		));

		echo json_encode(array(
			'users' => $this->users_model->count(),
			'crushes' => $this->crushes_model->count(),
			'emails' => $this->emails_model->count()
		));
	}

}