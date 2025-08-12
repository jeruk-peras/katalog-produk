<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Customer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'no_handphone' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'nama_perusahaan' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'provinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'kota_kabupaten' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'kelurahan' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'alamat' => [
                'type'       => 'TEXT',
            ],
            'sales_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            "created_at datetime default current_timestamp",
            "updated_at datetime NULL",
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customer');
    }

    public function down()
    {
        $this->forge->dropTable('customer', true);
    }
}
