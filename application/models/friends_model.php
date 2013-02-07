<?php

class Friends_model extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('fb');
	}

	function lookup_opposite_sex_friends()
	{
		$query = 'SELECT sex FROM user WHERE uid = me()';
		$sex_response = $this->fb->run_fql_query($query);

		// selecting opposite sex.
		$sex = 'female';
		if ($sex_response[0]['sex'] == 'female')
			$sex = 'male';

		$query = 'SELECT uid, name, pic_big FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) AND sex = "' . $sex . '"';
		$friend_response = $this->fb->run_fql_query($query);

		return $friend_response;
	}

}
