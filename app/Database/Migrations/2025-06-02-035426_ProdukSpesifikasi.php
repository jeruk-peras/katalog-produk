<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukSpesifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'spesifikasi_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'produk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('spesifikasi_id', 'spesifikasi', 'id_spesifikasi', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_spesifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('produk_spesifikasi', true);
    }
}
