<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDueDateInMasterProduct extends Migration
{
    public function up()
    {
        $this->forge->dropColumn("master_products", "due_date");
    }

    public function down()
    {
        $this->forge->addColumn("master_products", ['due_date' => ['type' => 'datetime']]);
    }
}
