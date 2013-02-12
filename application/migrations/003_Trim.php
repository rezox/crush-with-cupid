<?php

class Migration_trim extends CI_Migration
{

	function up()
	{
		$this->dbforge->drop_column('users', 'pic_square');
	}

	function down()
	{
		$fields = array(
			'pic_square' => array(
				'type' => 'TEXT'
			),
		);

		$this->dbforge->add_column('users', $fields);
	}

}