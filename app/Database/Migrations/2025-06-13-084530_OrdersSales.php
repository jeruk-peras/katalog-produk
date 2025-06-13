<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrdersSales extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
            ],
            'nama_sales' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'kode_sales' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order_sales');
    }

    public function down()
    {
        //
    }
}
