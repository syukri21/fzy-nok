<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Shield\Authorization\AuthorizationException;
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

    public function findRunningProductionById(int $manager_id): \stdClass
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
            nok.users manager ON manager.id = ?
        LEFT JOIN 
            nok.users ppic ON ppic.id = pp.ppic_id
        LEFT JOIN 
            nok.master_products mp ON mp.id = pp.master_products_id
        WHERE 
            pp.status = 'ONPROGRESS'
        ORDER BY 
            pp.due_date
        LIMIT 1;
    ", [$manager_id])->getResult();

        if (count($runningProduction) === 0) {
            throw new DataException();
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

    /**
     * @param int $production_id
     * @return void
     * @throws \ReflectionException
     */
    public function finishRunningProductionById(int $production_id)
    {
        $user = auth()->getUser();
        if (!in_array('manager', $user->getGroups())) {
            throw new AuthorizationException();
        }

        $productionPlanModel = new ProductionPlanModel();
        $productionPlan = $productionPlanModel->where("id", $production_id)->first();

        if ($productionPlan->status != ONPROGRESS) {
            throw new \InvalidArgumentException();
        }

        $productionPlan->status = DONE;
        $productionPlanModel->save($productionPlan);
    }


    public function getAllManager(): array
    {
        $managerModel = new ManagerModel();
        $query = $managerModel->join("auth_groups_users", "auth_groups_users.user_id = users.id", "left")->where("auth_groups_users.group", "manager");
        return $query->findAll();

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
