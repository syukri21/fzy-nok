<?php

namespace App\Database\Seeds;

use App\Models\OperatorProductionModel;
use CodeIgniter\Database\Seeder;

class OperatorProductionSeeder extends Seeder
{
    public function run()
    {
        $operatorProductionModel = new OperatorProductionModel();
        $operatorProductionModel->generateFaker(10);
    }
}
