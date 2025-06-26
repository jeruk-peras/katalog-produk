<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukMasukDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_masuk_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'masuk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'produk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'varian_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'harga' => [
                'type'           => 'double',
            ],
            'stok' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
        ]);
        $this->forge->addKey('id_masuk_detail', true);
        $this->forge->addForeignKey('masuk_id', 'produk_masuk', 'id_masuk', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('varian_id', 'produk_varian', 'id_varian', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('produk_masuk_detail');
    }

    public function down()
    {
        $this->forge->dropTable('produk_masuk_detail', true);
    }
}
