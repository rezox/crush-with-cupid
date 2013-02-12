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
		if (!$this->fb->is_logged_in())
			$this->response(array('error' => 'Requries authentication.'), 401);

		$user = $this->fb->get_user();
		$user = $user['uid'];

		$crushes = $this->crushes_model->get($user);
		$crushes[] = '0'; // hotfix

		$this->response($crushes);
	}

	function index_post()
	{
		if (!$this->fb->is_logged_in())
			$this->response(array('error' => 'Requries authentication.'), 401);

		// $from = $this->post('from');
		$to = $this->post('to');

		$user = $this->fb->get_user();
		$from = $user['uid'];

		if (empty($from) || empty($to))
			return $this->response(array('error' => 'Parameters missing.'), 400);

		$this->crushes_model->add($from, $to);

		$response = array('success' => 'Added.');
		if ($this->crushes_model->has_pair($from, $to))
		{
			$this->load->model(array('users_model', 'emails_model'));

			// send them an email
			$u1 = $this->users_model->find($from);
			$u2 = $this->users_model->find($to);

			$this->emails_model->send($u2['email'], $u1['name']);
			$this->emails_model->send($u1['email'], $u2['name']);

			// respond with pair found
			$response['paired'] = true;
		}

		return $this->response($response);
	}

	function index_delete()
	{
		if (!$this->fb->is_logged_in())
			$this->response(array('error' => 'Requries authentication.'), 401);

		$to = $this->delete('to');

		$user = $this->fb->get_user();
		$from = $user['uid'];

		if (empty($from) || empty($to))
			return $this->response(array('error' => 'Parameters missing.'), 400);

		if ($this->crushes_model->has_pair($from, $to))
			return $this->response(array('error' => 'Pair exists, cannot remove.'), 409);

		$this->crushes_model->remove($from, $to);
		return $this->response(array('success' => 'Removed.'));
	}
}