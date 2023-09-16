<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Faker\Factory;
use Faker\Generator;

class OperatorModel extends UserModel
{
    private Generator $faker;

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->faker = Factory::create("id_ID");
    }

    public function generateFaker(int $total)
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
            $userEntity->setPassword("password");
            $userId = $this->insert($userEntity);
            $user = $this->find($userId);
            $user->activate();
            $user->addGroup('operator');
        }
    }


    public function findManyID(int $count): array
    {
        $resultArray = $this->builder()->select('users.id')->join('auth_groups_users group', "group.id = users.id AND group.group = 'operator' ", 'inner')->get($count)->getResultArray();
        return array_reduce($resultArray, function ($carry, $item) {
            $carry[] = $item['id'];
            return $carry;
        }, []);
    }


    /**
     * @param array $ids
     * @return array
     */
    public function finManyById(array $ids): array
    {

        $query = $this->builder()->select("users.*")->join('auth_groups_users group', "group.id = users.id AND group.group = 'operator' ", 'inner');
        return $query->whereIn('users.id', $ids)->get()->getResult(UserEntity::class);
    }
}