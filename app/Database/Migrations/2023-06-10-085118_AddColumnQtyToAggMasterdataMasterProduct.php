<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnQtyToAggMasterdataMasterProduct extends Migration
{
    public function up()
    {
        $fields = [
            'masterdata_qty' => [
                'type' => 'BIGINT',
                'DEFAULT' => 0,
            ],
        ];
        $this->forge->addColumn('agg_masterdata_masterproduct', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('agg_masterdata_masterproduct', 'masterdata_qty');
    }
}
