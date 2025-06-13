<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrdersDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'produk_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'harga' => [
                'type'           => 'double',
            ],
            'jumlah' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'total' => [
                'type'           => 'double',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id_order', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id_produk', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('orders_detail');
    }

    public function down()
    {
        $this->forge->dropTable('orders_detail', true);
    }
}
