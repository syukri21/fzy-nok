<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDimensionOnMasterProduct extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('master_products', 'dimension');
    }

    public function down()
    {
        $field = [
            'dimension' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('master_products', $field);
    }
}
