<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubKategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sub_kategori' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_sub_kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug_sub_kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kategori_id'=> [
                'type'           => 'INT',
                'constraint'     => 11,
            ],   
            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id_sub_kategori', true);
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id_kategori', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('sub_kategori');
    }

    public function down()
    {
        $this->forge->dropTable('sub_kategori', true);
    }
}
