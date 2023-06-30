<?php

namespace App\Database\Seeds;

use App\Models\OperatorModel;
use CodeIgniter\Database\Seeder;

class OperatorSeeder extends Seeder
{
    public function run()
    {
        $operatorModel = new OperatorModel();
        $operatorModel->generateFaker(100);
    }
}
