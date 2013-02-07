<?php
class Crush extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('crushes_model');
	}

	function index_post()
	{

	}

}
