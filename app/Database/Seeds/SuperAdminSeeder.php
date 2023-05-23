<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Entities\User;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = [
            'username' =>'superadmin',
            'employee_id' => '0001',
            'password' => 'fuzi',
        ];

        auth()->getProvider()->save($user);
    }
}
