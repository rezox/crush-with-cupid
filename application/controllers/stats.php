<?php 

class Stats extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'crushes_model',
			'users_model'
		));
		$this->load->library('session');
	}

	function index()
	{
		$allowed = array(
			'1340490250' // steve
		);

		if (!is_logged_in() || !in_array($this->session->userdata('user'), $allowed))
			return redirect('/', 'refresh');

		$this->load->view('include/header');
		$this->load->view('stats', array(
			'users' => $this->users_model->count(),
			'crushes' => $this->crushes_model->count()
		));
		$this->load->view('include/footer');
	}

}