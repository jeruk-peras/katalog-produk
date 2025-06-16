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

            'nama_varian' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'harga_varian' => [
                'type'       => 'DOUBLE',
            ],
            'stok_varian' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            'produk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_varian', true);
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_varian');
    }

    public function down()
    {
        $this->forge->dropTable('produk_varian', true);
    }
}
