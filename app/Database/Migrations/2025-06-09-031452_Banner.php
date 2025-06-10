<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Banner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_banner' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_banner' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'deskripsi_banner' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_banner', true);
        $this->forge->createTable('banner');
    }

    public function down()
    {
        $this->forge->dropTable('banner', true);
    }
}
