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
		// looking up current sex.
		$query = 'SELECT sex FROM user WHERE uid = me()';
		$sex_response = $this->fb->run_fql_query($query);

		// selecting opposite sex.
		$sex = 'female';
		if ($sex_response[0]['sex'] == 'female')
			$sex = 'male';

		// looking up opposite sex friends.
		$query = 'SELECT uid, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) AND sex = "' . $sex . '"';
		$friend_response = $this->fb->run_fql_query($query);

		$ids = array();
		$assoc = array();
		foreach ($friend_response as $key => $value)
		{
			$ids[] = $value['uid'];
			$assoc[$value['uid']] = $key;
		}

		// we need to get their square photos too
		$query = 'SELECT id, url FROM square_profile_pic WHERE id IN (' . implode(',', $ids) . ') AND size = 320';
		$picture_response = $this->fb->run_fql_query($query);

		foreach ($picture_response as $picture)
			$friend_response[$assoc[$picture['id']]]['pic_square'] = $picture['url'];
		
		unset($ids);
		unset($assoc);

		return $friend_response;
	}

}
