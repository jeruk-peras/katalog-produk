<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pesan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '320',
            ],
            'notlp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'subjek' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'pesan' => [
                'type'       => 'TEXT',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_pesan', true);
        $this->forge->createTable('pesan');
    }

    public function down()
    {
        $this->forge->dropTable('pesan', true);
    }
}
