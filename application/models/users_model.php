<?php

class Users_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->library('migration');
		if (!$this->migration->current())
		   show_error($this->migration->error_string());
	}

	function find($fbid)
	{
		$this->db->where('fbid', $fbid)
			->from('users');

		$query = $this->db->get();

		return $query->row_array();
	}

	function add($user)
	{
		$fields = array(
			'fbid' => $user['uid'],
			'name' => $user['name'],
			'email' => $user['email'],
			'sex' => $user['sex']
		);

		$this->db->insert('users', $fields);

		return $this->find($user['uid']);
	}

	function count()
	{
		return $this->db->count_all_results('users');
	}

}