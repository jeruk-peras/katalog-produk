<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Patner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_patner' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_patner' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'logo_patner' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_patner', true);
        $this->forge->createTable('patner');
    }

    public function down()
    {
        $this->forge->dropTable('patner', true);
    }
}
