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
            'password' => 'adminadmin1!',
            'email' => 'admin@admin.com',
            'first_name' => 'Fuzi',
            'last_name' => 'Widiastuti'
        ]);

        $userProvider = auth()->getProvider();
        $userProvider->save($user);
        $user = $userProvider->findById($userProvider->getÍInsertID());
        $user->activate();
        $user->addGroup('superadmin');
    }
}


function haveProblem()
{

}

function trySolveProblem($live)
{

}

function stillWith($you)
{

}

function problemIsDone()
{

}

function celebrateTogetherWith($you)
{

}

while (live.haveProblem()) {
    Me.stillWith(you).trySolveProblem(live);
    if (live.problemIsDone()){
        Me.celebrateTogetherWith(you);
    }
}


