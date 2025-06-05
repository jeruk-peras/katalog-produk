<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukGambar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'gambar' => [
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
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey('gambar');
        $this->forge->createTable('produk_gambar');
    }

    public function down()
    {
        $this->forge->dropTable('produk_gambar', true);
    }
}
