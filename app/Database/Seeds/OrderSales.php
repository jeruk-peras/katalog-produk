<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OrderSales extends Seeder
{
    public function run()
    {
        // data
        $data = [
            [
                'setting' => 'nama_penerima_order',
                'data' => 'xxxxxxxxxxx',
            ],
            [
                'setting' => 'nomor_penerima_order',
                'data' => '08xxxxxxx',
            ],
        ];

        // insert data
        foreach ($data as $row) {
            $this->db->table('order_sett')->insert($row);
        }
    }
}
