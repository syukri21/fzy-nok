<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConfirmationCode extends Migration
{
    public function up()
    {
        $fields = [
            'confirmation_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'confirmation_code');
    }
}
