<?php

namespace App\Database\Seeds;

use App\Models\OperatorModel;
use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->findRunningProductionByOperatorId();
    }

    /**
     * @return void
     */
    public function findRunningProductionByOperatorId(): void
    {
        $operatorModel = new OperatorModel();
        try {
            $runningProductionByOperatorId = $operatorModel->findRunningProductionByOperatorId(264);
            dd($runningProductionByOperatorId);

        } catch (\Exception $e) {

            dd($e);
        }
    }
}
