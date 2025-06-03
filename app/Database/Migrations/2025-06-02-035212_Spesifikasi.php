<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Spesifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_spesifikasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_spesifikasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kategori_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_spesifikasi', true);
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id_kategori', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('spesifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('spesifikasi', true);
    }
}
