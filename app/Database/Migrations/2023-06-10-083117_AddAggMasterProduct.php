<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAggMasterProduct extends Migration
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
            'masterdata_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => false,
            ],
            'masterproduct_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => false,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('agg_masterdata_masterproduct');
        $this->forge->addForeignKey('id', 'masterdatas', 'masterdata_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id', 'master_product', 'masterproduct_id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('agg_masterdata_masterproduct', 'masterdata_id');
        $this->forge->dropForeignKey('agg_masterdata_masterproduct', 'masterproduct_id');
        $this->forge->dropTable('agg_masterdata_masterproduct');
    }
}
