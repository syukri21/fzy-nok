<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMasterProduct extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'price' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'dimension' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'due_date' => ['type' => 'datetime'],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('master_products');
    }

    public function down()
    {
        $this->forge->dropTable('master_products');
    }
}
