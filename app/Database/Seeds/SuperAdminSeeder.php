<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class SuperAdminSeeder extends Seeder
{

    public function run()
    {
        $user = new User([
            'username' => 'superadmin',
            'employee_id' => 'superadmin',
            'password' => 'superadmin',
            'email' => 'superadmin@nok.com',
            'first_name' => 'Super',
            'last_name' => 'Admin'
        ]);

        $userProvider = auth()->getProvider();
        $userProvider->save($user);
        $user = $userProvider->findById($userProvider->getInsertID());
        $user->activate();
        $user->addGroup('superadmin');
    }
}
