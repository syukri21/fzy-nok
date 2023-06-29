<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductionPlan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'master_products_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'production_ticket' => ['type' => 'VARCHAR', 'constraint' => 255],
            'quantity' => ['type' => 'INT'],
            'order_date' => ['type' => 'DATE'],
            'due_date' => ['type' => 'DATE'],
            'done_date' => ['type' => 'DATE', 'null' => true, 'default' => null],
            'ppic_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true,],
            'manager_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true,],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['TODO', 'ONPROGRESS', 'DONE'],
                'default' => 'TODO',
            ],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status', false);
        $this->forge->addForeignKey('ppic_id', 'users', 'id');
        $this->forge->addForeignKey('manager_id', 'users', 'id');
        $this->forge->addForeignKey('master_products_id', 'master_products', 'id');
        $this->forge->createTable('production_plans');
    }

    public function down()
    {
        $this->forge->dropForeignKey('production_plans', 'ppic_id');
        $this->forge->dropForeignKey('production_plans', 'manager_id');
        $this->forge->dropForeignKey('production_plans', 'master_products_id');
        $this->forge->dropTable('production_plans');
    }
}
