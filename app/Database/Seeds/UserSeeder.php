<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'darth@theempire.com',
            'password'    => 'good',
        ];

        // Simple Queries
        $this->db->query('INSERT INTO users (username, password) VALUES(:username:, :password:)', $data);

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
