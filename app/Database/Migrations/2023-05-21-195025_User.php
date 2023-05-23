<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'password' => array(
                'type' => 'TEXT',
                'null' => false,
            ),
            'status' => array(
                'type'       => 'ENUM',
                'constraint' => ['new', 'active', 'non_active'],
                'default'    => 'new',
            ),
            'createdBy' => array(
                'type' => 'INT',
                'null' => true,
            ),
            'createdAt timestamp default now()',
            'updatedAt timestamp default now() on update now()'
        ));
        $this->forge->addKey('user_id', TRUE);
        $this->forge->addKey('status', FALSE, FALSE, 'nok_users_status');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }

}
