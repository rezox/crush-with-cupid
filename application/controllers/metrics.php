<?php 

class Metrics extends REST_Controller
{

	function index_get()
	{
		$ips = array(
			'97.107.130.57'
		);

		if (!in_array($_SERVER['REMOTE_ADDR'], $ips))
			show_404();

		$this->load->model(array(
			'crushes_model',
			'users_model',
			'emails_model'
		));

		$this->response(array(
			'users' => $this->users_model->count(),
			'crushes' => $this->crushes_model->count(),
			'emails' => $this->emails_model->count()
		));
	}

}