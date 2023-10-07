<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeProductionResultCheckedByIsNull extends Migration
{
    private string $tableName = "production_result";

    public function up()
    {
        $fields = [
            'checked_by' =>  ['type' => 'VARCHAR', 'constraint' => 20,'null' => true]
        ];
        $this->forge->modifyColumn($this->tableName, $fields);

    }

    public function down()
    {

        $fields = [
            'checked_by' =>  ['type' => 'VARCHAR', 'constraint' => 20]
        ];
        $this->forge->addColumn($this->tableName, $fields);
    }
}
