<?php

namespace App\Models;

use App\Entities\Operator;
use App\Entities\OperatorProduction;
use App\Entities\Shift;
use CodeIgniter\Model;
use Faker\Factory;

class OperatorProductionModel extends Model
{

    protected $DBGroup = 'default';
    protected $table = 'agg__production_plans__operator';
    protected $returnType = OperatorProduction::class;
    protected $protectFields = true;
    protected $allowedFields = [
        'production_plans_id',
        'operator_id',
        'shift'
    ];

    // Dates
    protected $useTimestamps = false;

    public function generateFaker(int $count)
    {
        $faker = Factory::create("id_iD");

        $operatorModel = new OperatorModel();
        $ids = $operatorModel->findManyID(1000);
        $productionPlanModel = new ProductionPlanModel();
        $result = $productionPlanModel->builder()->select('id')->get(100)->getResult();

        $data = [];

        foreach ($result as $item) {
            for ($i = 0; $i < $count; $i++) {
                $data[] = [
                    "production_plans_id" => $item->id,
                    'operator_id' => $faker->unique()->randomElement($ids),
                    'shift' => $faker->randomElement([1, 2, 3, 4, 5])
                ];
            }
            $faker->unique(true)->randomElement($ids);
        }

        try {
            $this->insertBatch($data);
        } catch (\ReflectionException $e) {
            log_message('error', $e);
        }

    }


    public function findOperatorProduction(int $productionPlan): array
    {

        $query = $this->builder()->select("operators.*, shift");
        $query = $query->join("users operators", "operators.id = agg__production_plans__operator.operator_id");
        $result = $query->where("agg__production_plans__operator.production_plans_id", $productionPlan)->get()->getResult();


        $operator_shift = [];
        foreach ($result as $item) {
            $operator = new Operator();
            $operator->setFirstName($item->first_name);
            $operator->setLastName($item->last_name);
            $operator->setEmployeeId($item->employee_id);
            $operator->setId($item->id);
            if (!array_key_exists($item->shift, $operator_shift)) {
                $operator_shift[$item->shift] = [];
            }
            $operator_shift[$item->shift][] = $operator;
        }

        $shift = [];
        foreach ($operator_shift as $key => $item) {
            $new_shift = new Shift();
            $new_shift->id = $key;
            $new_shift->setOperators($item);
            $arrayShift = $new_shift->toArray();
            $arrayShift["operators"] = $new_shift->getOperators();
            $arrayShift["data"] = $new_shift->getShiftData();
            $shift[] = $arrayShift;
        }

        return $shift;

    }

}


