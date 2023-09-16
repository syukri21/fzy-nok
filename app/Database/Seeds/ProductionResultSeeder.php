<?php

namespace App\Database\Seeds;

use App\Models\ProductionResultModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class ProductionResultSeeder extends Seeder
{
    public ProductionResultModel $productionResultModel;

    /**
     * @param Database $config
     * @param BaseConnection|null $db
     */
    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        $this->productionResultModel = new ProductionResultModel();
        parent::__construct($config, $db);
    }


    public function run()
    {
        $generateFakeData = $this->productionResultModel->generateFakeData(20);
        try {
            $this->productionResultModel->insertBatch($generateFakeData);
        } catch (\ReflectionException $e) {
            dd($e);
        }
    }
}
