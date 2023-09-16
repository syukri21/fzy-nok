<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Faker\Factory;
use Faker\Generator;

class ManagerModel extends UserModel
{
    private Generator $faker;

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->faker = Factory::create("id_ID");
    }

    public function generateFaker(int $total = 5)
    {
        for ($i = 0; $i < $total; $i++) {
            $userEntity = new UserEntity();
            $userEntity->fill([
                'email' => $this->faker->unique()->email(),
                'first_name' => $this->faker->unique()->firstName(),
                'last_name' => $this->faker->unique()->lastName(),
            ]);
            $number = $this->getNextEmployeeIdLastNumber();
            $userEntity->setUsername($number);
            $userEntity->setPassword("manager_password");
            $userId = $this->insert($userEntity);
            $user = $this->find($userId);
            $user->activate();
            $user->addGroup('manager');
        }
    }
}
