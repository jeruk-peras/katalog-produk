<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrdersSett extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
            ],
            'setting' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'data' => [
                'type'       => 'TEXT',
                'null'       => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order_sett');
    }

    public function down()
    {
        //
    }
}
