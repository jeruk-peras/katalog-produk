<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukPaketDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_paket_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'paket_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'produk_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'varian_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_paket_detail', true);
        $this->forge->addForeignKey('paket_id', 'produk_paket', 'id_paket', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('varian_id', 'produk_varian', 'id_varian', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('produk_paket_detail');
    }

    public function down()
    {
        $this->forge->dropTable('produk_paket_detail', true);
    }
}
