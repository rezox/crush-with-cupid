<?php
class Friends extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
		$this->load->model('friends_model');
	}

	function index_get()
	{
		$this->response($this->friends_model->lookup_opposite_sex_friends());
	}

}
