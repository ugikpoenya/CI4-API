<?php

namespace App\Database\Migrations;

use App\Models\UsersModel;
use CodeIgniter\Database\Migration;

class CreateTableUsers extends Migration
{
	public function up()
	{
		$forge = \Config\Database::forge();
		$forge->addField(array(
			'user_id' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),

			'full_name VARCHAR(255)',
			'email VARCHAR(255)',
			'phone VARCHAR(25)',
			'password TEXT',

			'level VARCHAR(25)',
			'status VARCHAR(25)',
			'image TEXT',

			'created_at datetime default current_timestamp',
			'created_by INT(11)',
			'updated_at datetime default current_timestamp on update current_timestamp',
			'updated_by INT(11)',
			'deleted_at datetime',
			'deleted_by INT(11)',
			'restored_at datetime',
			'restored_by INT(11)',
			'verified_at datetime',
			'verified_by INT(11)',
			'approved_at datetime',
			'approved_by INT(11)',
		));
		$forge->addKey('user_id', TRUE);
		$forge->createTable('users', TRUE);

		$usersModel = new UsersModel();
		if ($usersModel->countAllResults() == 0) {
			$usersModel->insert([
				'full_name' => 'Administrator',
				'email' => 'admin@admin.com',
				'password' => 'admin',
				'level' => 'Admin',
				'status' => 'Active'
			]);
		}
	}

	public function down()
	{
		//
	}
}
