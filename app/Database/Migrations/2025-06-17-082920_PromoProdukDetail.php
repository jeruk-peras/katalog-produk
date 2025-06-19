<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PromoProdukDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'promo_id' => [
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
            'harga_awal' => [
                'type'       => 'double',
            ],
            'harga_diskon' => [
                'type'       => 'double',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('promo_id', 'produk_promo', 'id_promo', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('varian_id', 'produk_varian', 'id_varian', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('produk_promo_detail');
    }

    public function down()
    {
        $this->forge->dropTable('produk_promo_detail', true);
    }
}
