<?php 

class Migration_crushes extends CI_Migration
{

	function up()
	{
		$fields = array(
			'from' => array(
				'type' => 'BIGINT',
				'constraint' => 64
			),
			'to' => array(
				'type' => 'BIGINT',
				'constraint' => 64
			)
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('from', TRUE);
		$this->dbforge->add_key('to', TRUE);
		$this->dbforge->create_table('crushes');

	}

	function down()
	{
		$this->dbforge->drop_table('crushes');
	}

}