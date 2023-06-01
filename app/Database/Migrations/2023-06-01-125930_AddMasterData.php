<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMasterData extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'masterdata_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'masterdata_type' => [
                'type' => 'ENUM',
                'constraint' => ['MESIN', 'BAHAN', 'ALAT'],
                'default' => 'BAHAN'
            ],
            'weight' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'dimension' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('masterdata_id', true);
        $this->forge->createTable('masterdatas');
    }

    public function down()
    {
        $this->forge->dropTable('masterdatas');
    }
}
