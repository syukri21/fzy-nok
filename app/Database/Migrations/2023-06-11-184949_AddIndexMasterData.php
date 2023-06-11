<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexMasterData extends Migration
{
    public function up()
    {
        $this->forge->addKey(['name', 'masterdata_type'], false, false, 'name__masterdata_type__masterdata_index');
        $this->forge->addKey(['name'], false, false, 'name__masterdata_index');
        $this->forge->addKey(['masterdata_type'], false, false, 'masterdata_type__masterdata_index');
        $this->forge->processIndexes('masterdatas');
    }

    public function down()
    {
        $this->forge->dropKey('masterdatas', 'name__masterdata_type__masterdata_index', false);
        $this->forge->dropKey('masterdatas', 'name__masterdata_index', false);
        $this->forge->dropKey('masterdatas', 'masterdata_type__masterdata_index', false);
    }
}
