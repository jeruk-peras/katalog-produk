<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Layanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_layanan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'icon_layanan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_layanan' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'deskripsi_layanan' => [
                'type'       => 'TEXT',
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_layanan', true);
        $this->forge->createTable('layanan');
    }

    public function down()
    {
        $this->forge->dropTable('layanan', true);
    }
}
