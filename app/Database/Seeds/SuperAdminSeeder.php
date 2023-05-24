<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = new User([
            'username' => 'admin',
            'employee_id' => '0001',
            'password' => 'adminadmin1!',
            'email' => 'admin@admin.com',
            'first_name' => 'Superadmin',
            'last_name' => 'Sejati'
        ]);

        $userProvider = auth()->getProvider();
        $userProvider->save($user);
        $user = $userProvider->findById($userProvider->getInsertID());
        $user->activate();
        $user->addGroup('superadmin');
    }
}
