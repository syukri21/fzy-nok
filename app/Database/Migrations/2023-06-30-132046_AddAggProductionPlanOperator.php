<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAggProductionPlanOperator extends Migration
{
    private string $tableName = "agg__production_plans__operator";

    public function up()
    {
        $this->forge->addField([
            'operator_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'production_plans_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'shift' => ['type' => 'INT', 'constraint' => 5]
        ]);
        $this->forge->addPrimaryKey(['operator_id', 'production_plans_id'], $this->tableName . 'operator_id__production_plans_id');
        $this->forge->addForeignKey('operator_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('production_plans_id', 'production_plans', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey('shift', false);
        $this->forge->createTable($this->tableName);
    }

    public function down()
    {
        $this->forge->dropKey($this->tableName, $this->tableName . 'operator_id__production_plans_id');
        $this->forge->dropKey($this->tableName, 'shift');
        $this->forge->dropTable($this->tableName);
    }
}
