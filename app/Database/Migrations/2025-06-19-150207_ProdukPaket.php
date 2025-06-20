<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukPaket extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_paket' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'nama_paket' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'harga_awal' => [
                'type'       => 'DOUBLE',
            ],
            'harga_baru' => [
                'type'       => 'DOUBLE',
            ],
            'stok_paket' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_paket', true);
        $this->forge->createTable('produk_paket');
    }

    public function down()
    {
        $this->forge->dropTable('produk_paket', true);
    }
}
