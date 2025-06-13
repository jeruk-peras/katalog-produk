<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_user' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
            "deleted_at datetime NULL",
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
