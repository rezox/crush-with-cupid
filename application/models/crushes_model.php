<?php

class Crushes_model extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->load->library('migration');
		if (!$this->migration->current())
		   show_error($this->migration->error_string());
	}

	function add($from, $to)
	{
		if ($this->exists($from, $to))
			return;

		$fields = array(
			'from' => $from,
			'to' => $to
		);

		$this->db->insert('crushes', $fields);
	}

	function has_pair($p1, $p2)
	{
		if ($this->exists($p1, $p2) && $this->exists($p2, $p1))
			return true;

		return false;
	}

	function exists($from, $to)
	{
		$this->db->where('from', $from)
			->where('to', $to)
			->from('crushes');

		if ($this->db->count_all())
			return true;

		return false;
	}

}