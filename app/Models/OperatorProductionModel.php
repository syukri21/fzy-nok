<?php

namespace App\Models;

use App\Entities\OperatorProduction;
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

}


