<?php

class Emails_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('email');
	}

	function send($to, $crush_name)
	{
		$template = $this->load->view('email', array('name' => $crush_name), true);

		$this->email->from('cupid@crushwithcupid.com', 'CrushWithCupid.com');
		$this->email->to($to);

		$this->email->subject('Love is in the air.');
		$this->email->message($template);

		$this->email->send();
	}

	function count()
	{
		if (!isset($_SERVER['MANDRILL_APIKEY']))
			return 0;

		$this->load->library('curl');
		$response = $this->curl->simple_post(
			'https://mandrillapp.com/api/1.0/senders/info.json', 
			array('key' => $_SERVER['MANDRILL_APIKEY'], 'address' => 'cupid@crushwithcupid.com')
		);

		$response = json_decode($response, TRUE);

		return $response['sent'];
	}

}