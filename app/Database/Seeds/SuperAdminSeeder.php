<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Models\UserIdentityModel;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = new User([
            'username' =>'admin3',
            'employee_id' => '0003',
            'password' => '123456789!',
            'email' => 'admin3@admin.com',
            'identities' => new UserIdentityModel()
        ]);

        $userProvider = auth()->getProvider();
        $userProvider->save($user);
        $user = $userProvider->findById($userProvider->getInsertID());
        $user->activate();
        $user->addGroup('superadmin');
    }
}
