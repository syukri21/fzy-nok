<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFirstNameAndLastNameAtUser extends Migration
{
    public function up()
    {
        $fields = [
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'first_name');
        $this->forge->dropColumn('users', 'last_name');
    }
}
