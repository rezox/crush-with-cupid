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
			->where('to', $to);

		if ($this->db->count_all_results('crushes'))
			return true;

		return false;
	}

	function get_pairs($user)
	{
		$crushes = $this->get($user);
		$crushed_by = $this->get_on($user);
		$pairs = array_intersect($crushes, $crushed_by);

		$return = array();
		foreach ($pairs as $pair)
			$return[] = $pair;

		return $return;
	}

	function get($user)
	{
		$this->db->where('from', $user)
			->from('crushes')
			->select('to');

		$query = $this->db->get();

		$ids = array();
		foreach ($query->result_array() as $row)
			$ids[] = $row['to'];

		return $ids;
	}

	function get_on($user)
	{
		$this->db->where('to', $user)
			->from('crushes')
			->select('from');

		$query = $this->db->get();

		$ids = array();
		foreach ($query->result_array() as $row)
			$ids[] = $row['from'];

		return $ids;			
	}

	function remove($from, $to)
	{
		if (!$this->exists($from, $to))
			return;

		$this->db->where('from', $from)
			->where('to', $to);

		$this->db->delete('crushes');
	}

	function count()
	{
		return $this->db->count_all_results('crushes');
	}

}