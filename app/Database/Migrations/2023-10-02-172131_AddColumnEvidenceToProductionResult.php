<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnEvidenceToProductionResult extends Migration
{
    public string $tableName = "production_result";

    public function up()
    {
        $fields = [
            'evidence' => [
                'type' => 'json',
                'null' => true,
            ],
        ];
        $this->forge->addColumn($this->tableName, $fields);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'evidence');
    }
}
