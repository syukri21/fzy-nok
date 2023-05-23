<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmployeeID extends Migration
{
    public function up()
    {
        $fields = [
            'employee_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => TRUE,
            ],
        ];
        $this->forge->addColumn('users', $fields);
        $this->forge->addKey('employee_id', FALSE, TRUE, 'users_employeeId');
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'employee_id');
        $this->forge->dropKey('users', 'users_employeeId');
    }
}
