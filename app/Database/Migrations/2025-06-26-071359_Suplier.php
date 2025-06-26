<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Suplier extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_suplier' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_suplier' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'nama_sales' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_suplier', true);
        $this->forge->createTable('suplier');
    }

    public function down()
    {
        $this->forge->dropTable('suplier', true);
    }
}
