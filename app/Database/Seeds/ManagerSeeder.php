<?php

namespace App\Database\Seeds;

use App\Models\ManagerModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use Config\Database;

class ManagerSeeder extends Seeder
{

    public ManagerModel $managerModel;

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);

        $this->managerModel = new ManagerModel();
    }


    public function run()
    {
        try {
            $this->managerModel->generateFaker(10);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
