<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PromoProduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_promo' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'nama_promo' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'tanggal_mulai' => [
                'type'       => 'date',
            ],
            'tanggal_selesai' => [
                'type'       => 'date',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_promo', true);
        $this->forge->createTable('produk_promo');
    }

    public function down()
    {
        $this->forge->dropTable('produk_promo', true);
    }
}
