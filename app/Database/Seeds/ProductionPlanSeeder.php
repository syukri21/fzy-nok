<?php

namespace App\Database\Seeds;

use App\Models\ProductionPlanModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class ProductionPlanSeeder extends Seeder
{
    public ProductionPlanModel $productionPlanModel;

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        $this->productionPlanModel = new ProductionPlanModel();
        parent::__construct($config, $db);
    }


    public function run()
    {
        $fakeData = $this->productionPlanModel->generateFakeData(162);
        try {
            $this->productionPlanModel->insertBatch($fakeData);
        } catch (\ReflectionException $e) {
            log_message('error', $e->getMessage());
        }
    }
}
