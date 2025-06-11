<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_produk' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'deskripsi_produk' => [
                'type'       => 'TEXT',
            ],
            'harga_produk' => [
                'type'       => 'double',
            ],
            'stok_produk' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0, // Default stock is 0
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 1, // 1 for active, 0 for inactive
            ],
            'slug_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'kategori_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_produk', true);
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id_kategori', 'CASCADE', 'RESTRICT');
        $this->forge->addUniqueKey('slug_produk');
        $this->forge->createTable('produk');
    }   

    public function down()
    {
        $this->forge->dropTable('produk', true);
    }
}
