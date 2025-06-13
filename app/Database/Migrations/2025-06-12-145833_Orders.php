<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Orders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_order' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'no_order' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'nama_tempat' => [
                'type'       => 'VARCHAR',
                'constraint' => '400',
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'catatan' => [
                'type'       => 'TEXT',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_order', true);
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('order', true);
    }
}
