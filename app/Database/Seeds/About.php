<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class About extends Seeder
{
    public function run()
    {
         // data kontak
        $data = [
            [
                'data' => 'gambar',
                'nilai' => 'xxx.jpg',
            ],
            [
                'data' => 'judul',
                'nilai' => 'PT. NUR LISAN SAKTI',
            ],
            [
                'data' => 'text',
                'nilai' => 'PT Nur Lisan Sakti adalah supplier terpercaya untuk kebutuhan body repair kendaraan. Kami menyediakan berbagai produk berkualitas tinggi dengan harga bersaing. Dengan pengalaman lebih dari 15 tahun di industri, kami memahami kebutuhan bengkel dan profesional body repair. Komitmen kami adalah memberikan produk terbaik dan layanan pelanggan yang memuaskan.',
            ],
        ];

        // insert data
        foreach ($data as $row) {
            $this->db->table('about')->insert($row);
        }
    }
}
