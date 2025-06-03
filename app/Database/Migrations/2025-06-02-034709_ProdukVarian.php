<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukVarian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_varian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_varian_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'harga_varian_produk' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'stok_varian_produk' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0, // Default stock is 0
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 1, // 1 for active, 0 for inactive
            ],
            'produk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_varian', true);
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('produk_varian');
    }

    public function down()
    {
        $this->forge->dropTable('produk_varian', true);
    }
}
