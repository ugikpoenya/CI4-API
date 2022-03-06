<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

		$data = array();
		for ($i = 0; $i < 100; $i++) {
			$start = strtotime(date("Y-m-d"));
			$end = strtotime("2021-10-01");
			$timestamp = rand($start, $end);
			$timestamp = date("Y-m-d H:i:s", $timestamp);


            $email=$faker->email;
			$data[] = [
				'full_name' => $faker->name,
				'email' => $email,
				'phone' => $faker->phoneNumber,
				'password' => password_hash($email, PASSWORD_BCRYPT),
				'level' => 'User',
				'status' => 'Active',
				'created_at' => $timestamp,
				'created_by' => 1,
				'updated_at' => $timestamp,
			];
		}

		array_multisort(array_column($data, 'created_at'), SORT_ASC, $data);
        print_r($data);

		$db      = \Config\Database::connect();
		$builder = $db->table('users');
	    $builder->insertBatch($data);

    }
}
