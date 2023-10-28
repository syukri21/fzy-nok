<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Shield\Models\DatabaseException;
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

    public function findRunningProductionById(int $operator_id): \stdClass
    {
        $runningProduction = $this->db->query("
        SELECT 
            pp.*, 
            manager.employee_id AS manager_employee_id, 
            manager.first_name AS manager_first_name, 
            manager.last_name AS manager_last_name, 
            ppic.employee_id AS ppic_employee_id, 
            ppic.first_name AS ppic_first_name, 
            ppic.last_name AS ppic_last_name,
            mp.id AS master_product_id, 
            mp.name AS master_product_name, 
            mp.code AS master_product_code, 
            mp.price AS master_product_price, 
            mp.description AS master_product_description, 
            mp.image AS master_product_image
        FROM 
            production_plans pp
        LEFT JOIN 
            nok.agg__production_plans__operator appo ON pp.id = appo.production_plans_id AND appo.operator_id = ?
        LEFT JOIN 
            nok.users manager ON manager.id = pp.manager_id
        LEFT JOIN 
            nok.users ppic ON ppic.id = pp.ppic_id
        LEFT JOIN 
            nok.master_products mp ON mp.id = pp.master_products_id
        WHERE 
            pp.status = 'ONPROGRESS'
        ORDER BY 
            pp.due_date
        LIMIT 1;
    ", [$operator_id])->getResult();

        if (count($runningProduction) === 0) {
            throw new DatabaseException();
        }

        $value = $runningProduction[0];

        $materials = $this->db->query("
        SELECT 
            m.id,
            m.name,
            m.masterdata_type,
            m.weight,
            m.dimension,
            m.image
        FROM 
            masterdatas m
        LEFT JOIN 
            nok.agg_masterdata_masterproduct amm ON m.id = amm.masterdata_id
        WHERE 
            amm.masterproduct_id = ? 
            AND m.deleted_at IS NULL
        ORDER BY created_at;
    ", [$value->master_product_id])->getResult();

        $value->masterdatas = $materials;
        return $value;
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

    public function findAllOperator()
    {
        return $this
            ->select("users.first_name, users.last_name, users.username, users.id")
            ->join('auth_groups_users group', "group.user_id = users.id", 'left')
            ->where("active", 1)->where("group.group", "operator")->asArray()->find();
    }
}