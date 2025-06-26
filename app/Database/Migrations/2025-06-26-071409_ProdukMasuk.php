<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProdukMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_masuk' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'tanggal_masuk' => [
                'type'       => 'DATETIME',
            ],
            'suplier_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'no_delivery' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],
            'total_harga' => [
                'type'           => 'double',
            ],
            'keterangan' => [
                'type'           => 'double',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_masuk', true);
        $this->forge->addForeignKey('suplier_id', 'suplier', 'id_suplier', 'CASCADE', 'CASCADE');
        $this->forge->createTable('produk_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('produk_masuk', true);
    }
}
