<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class About extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
            ],
            'data' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
            ],
            'nilai' => [
                'type'       => 'TEXT',
                'null'       => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('about');
    }

    public function down()
    {
        //
    }
}
