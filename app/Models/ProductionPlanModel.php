<?php

namespace App\Models;

use App\Entities\ProductionPlan;
use Faker\Factory;

class ProductionPlanModel extends BaseModel
{
    protected $DBGroup = 'default';
    protected $table = 'production_plans';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = ProductionPlan::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'production_ticket',
        'quantity',
        'order_date',
        'due_date',
        'done_date',
        'ppic_id',
        'manager_id',
        'master_products_id',
        'status',
        'operators'
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


    /**
     * @param int $count
     * @return array
     */
    public function generateFakeData(int $count = 10): array
    {

        $faker = Factory::create("id_ID");
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'master_products_id' => $faker->randomElement([22, 23, 24, 25]),
                'production_ticket' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'quantity' => $faker->numberBetween(1, 100),
                'order_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'due_date' => $faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d H:i:s'),
                'done_date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'ppic_id' => 45,
                'manager_id' => 46,
                'status' => $faker->randomElement(['TODO', 'ONPROGRESS', 'DONE']),
            ];
        }

        return $data;
    }
}
