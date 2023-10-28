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
        'evidence'
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

    public function findAllOperatorProductionResult(int $production_id, $limit, $offset): array
    {
        $user = auth()->getUser();
        $username = $user->username;
        return $this->select("production_result.*, checker.first_name as checker_first_name, reporter.first_name as reporter_first_name")
            ->join("users checker", "checker.username = production_result.checked_by", "left")
            ->join("users reporter", "reporter.username = production_result.reported_by", "left")
            ->where('production_plan_id', $production_id)
            ->where('reported_by', $username)->findAll($limit, $offset);
    }


    public function findAllManagerProductionResult(int $production_id, $limit, $offset): array
    {
        $user = auth()->getUser();
        return $this->select("production_result.*, checker.first_name as checker_first_name, reporter.first_name as reporter_first_name")
            ->join("users checker", "checker.username = production_result.checked_by", "left")
            ->join("users reporter", "reporter.username = production_result.reported_by", "left")
            ->join("production_plans pp", "pp.id = production_result.production_plan_id", "left")
            ->where('production_plan_id', $production_id)
            ->where("pp.manager_id", $user->id)->findAll($limit, $offset);
    }

    public function findAllPPICProductionResult($production_id, int $limit, int $offset): array
    {
        $user = auth()->getUser();
        return $this->select("production_result.*, checker.first_name as checker_first_name, reporter.first_name as reporter_first_name")
            ->join("users checker", "checker.username = production_result.checked_by", "left")
            ->join("users reporter", "reporter.username = production_result.reported_by", "left")
            ->join("production_plans pp", "pp.id = production_result.production_plan_id", "left")
            ->where('production_plan_id', $production_id)
            ->where("pp.ppic_id", $user->id)->findAll($limit, $offset);
    }


    public function getAllTimeProduction(): array
    {
        $all = $this
            ->selectSum("production_result.quantity_produced")
            ->select("mp.name")
            ->join("production_plans pp", "pp.id = production_result.production_plan_id")
            ->join("master_products mp", "mp.id = pp.master_products_id")
            ->where("production_result.checked_by !=")
            ->groupBy("pp.master_products_id")
            ->findAll();

        $allTime = [
            "label" => [],
            "data" => []
        ];
        foreach ($all as $item) {
            $allTime["label"] [] = $item->name;
            $allTime["data"] [] = $item->quantity_produced;
        }
        return $allTime;
    }


    public function getMonthProduction(): array
    {
        $data = $this
            ->selectSum("production_result.quantity_produced")
            ->select("mp.name")
            ->select("mp.id")
            ->select("month(pp.done_date) as month")
            ->join("production_plans pp", "pp.id = production_result.production_plan_id")
            ->join("master_products mp", "mp.id = pp.master_products_id")
            ->where("production_result.checked_by !=")
            ->groupBy("pp.master_products_id, month(pp.done_date)")
            ->findAll();


        $results = [
            "label" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            "id" => [],
            "dataset" => []
        ];

        $arrData = [];

        foreach ($data as $item) {
            $results["label"] [] = $item->month;
            if (empty($arrData[$item->id])) $arrData[$item->id] = [];
            if (empty($arrData[$item->id][$item->month])) $arrData[$item->id][$item->month] = [];
            $arrData[$item->id][$item->month] = $item->quantity_produced;
        }


        $color = ["red", "blue", "green"];
        $index = 0;
        foreach ($arrData as $arrDatum) {
            $results["dataset"] [] = [
                "data" => [],
                "borderColor" => $color[$index],
                "fill" => true
            ];
            foreach ($results["label"] as $r) {
                if (!empty($arrDatum[$r])) {
                    $results["dataset"][$index]["data"] [] = $arrDatum[$r];
                } else {
                    $results['dataset'][$index]["data"] [] = 0;
                }
            }
            $index++;
        }



        return $results;
    }

}
