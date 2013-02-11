<?php 

class How extends CI_Controller {

	function index()
	{
		$this->load->view('include/header');
		$this->load->view('how');
		$this->load->view('include/footer');
	}

}