<?php

namespace App\Models;

use App\Entities\ProductionResult;
use CodeIgniter\Shield\Authorization\AuthorizationException;
use Faker\Factory;

class ProductionResultModel extends BaseModel
{
    protected $DBGroup = 'default';
    protected $table = 'production_result';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ProductionResult::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'production_plan_id',
        'quantity_produced',
        'quantity_rejected',
        'production_date',
        'checked_by',
        'reported_by',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function validateAuthorization(string $action)
    {
        if (!auth()->user()->can($this->table . $action)) throw new AuthorizationException();
    }

    public function generateFakeData(int $count = 10): array
    {
        $faker = Factory::create("id_ID");
        $data = [];

        // get all operator employee_id
        $queryOperatorManager = $this->db->query("
            SELECT u.employee_id
            FROM auth_groups_users AS agu
            LEFT JOIN nok.users u ON u.id = agu.user_id
            WHERE agu.`group` = 'operator'
        ");
        $operatorsEmployeeIds = $queryOperatorManager->getResult();
        $operatorsEmployeeIdArrays = array_map(fn($item) => $item->employee_id, $operatorsEmployeeIds);

        // get all manager employee_id
        $queryOperatorManager = $this->db->query("
            SELECT u.employee_id
            FROM auth_groups_users AS agu
            LEFT JOIN nok.users u ON u.id = agu.user_id
            WHERE agu.`group` = 'manager'
        ")->getResult();
        $operatorsManagerIdsArray = array_map(fn($item) => $item->employee_id, $queryOperatorManager);

        // get all production_plan_id
        $queryProductionPlanIds = $this->db->query("
            select pp.id
            from production_plans pp
            where pp.status
            limit 10
        ")->getResult();
        $productionPlansIds = array_map(fn($item) => $item->id, $queryProductionPlanIds);

        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'production_plan_id' => $faker->randomElement($productionPlansIds),
                'quantity_produced' => $faker->numberBetween(60, 100),
                'quantity_rejected' => $faker->numberBetween(0, 30),
                'production_date' => $faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d H:i:s'),
                'checked_by' => $faker->randomElement($operatorsManagerIdsArray),
                'reported_by' => $faker->randomElement($operatorsEmployeeIdArrays),
            ];
        }

        return $data;

    }

}
