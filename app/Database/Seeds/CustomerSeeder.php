<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CustomerSeeder extends Seeder
{
    public function run()
    {

        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nama' => $faker->name(),
                'alamat'    => $faker->address(),
                'telp'    => $faker->phoneNumber(),
                'email'    => $faker->email(),
                'diskon'    => mt_rand(0, 100),
                'created_at'    => Time::createFromTimestamp($faker->unixTime()),
                'updated_at'    => Time::now(),
            ];

            // Simple Queries
            // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

            // Using Query Builder
            $this->db->table('customer')->insertBatch($data);
        }
    }
}
