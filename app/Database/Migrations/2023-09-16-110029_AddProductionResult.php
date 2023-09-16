<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductionResult extends Migration
{
    public string $tableName = "production_result";

    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'production_plan_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'quantity_produced' => ['type' => 'BIGINT'],
            'quantity_rejected' => ['type' => 'BIGINT'],
            'production_date' => ['type' => 'DATE'],
            'checked_by' => ['type' => 'VARCHAR', 'constraint' => 20],
            'reported_by' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('production_plan_id', 'production_plans', 'id');
        $this->forge->addForeignKey('reported_by', 'users', 'employee_id');
        $this->forge->addForeignKey('checked_by', 'users', 'employee_id');
        $this->forge->createTable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropForeignKey('production_plans', 'production_plan_id');
        $this->forge->dropTable($this->tableName);
    }
}
