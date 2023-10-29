<?php

namespace App\Database\Seeds;

use App\Models\PPICModel;
use CodeIgniter\Database\Seeder;

class PPICSeeder extends Seeder
{
    public function run()
    {
        $PPICModel = new PPICModel();
        $PPICModel->generateFaker(10);
    }
}
