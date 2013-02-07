<?php 

class Migration_users extends CI_Migration
{

	function up()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 8,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'fbid' => array(
				'type' => 'BIGINT',
				'constraint' => 64
			),
			'name' => array(
				'type' => 'TEXT'
			),
			'sex' => array(
				'type' => 'TEXT'
			),
			'email' => array(
				'type' => 'TEXT'
			),
			'pic_square' => array(
				'type' => 'TEXT'
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');
		$this->db->query("CREATE UNIQUE INDEX `fbid` ON `users` (`fbid`)");

	}

	function down()
	{
		$this->dbforge->drop_table('users');
	}

}