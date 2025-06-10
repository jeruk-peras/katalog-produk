<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KontakSeeder extends Seeder
{
    public function run()
    {
        // data kontak
        $data = [
            [
                'kontak' => 'alamat',
                'data' => 'Jl. Raya No. 123, Jakarta',
            ],
            [
                'kontak' => 'google_maps',
                'data' => 'https://goo.gl/maps/xyz123',
            ],
            [
                'kontak' => 'embed_google_maps',
                'data' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.1234567890123!2d-122.4194154846814!3d37.7749292797598!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808c8c8c8c8c%3A0x123456789abcdefg!2sSan%20Francisco%20City%20Hall!5e0!3m2!1sen!2sus!4v1612345678900" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'kontak' => 'email',
                'data' => 'abc@example.com',
            ],
            [
                'kontak' => 'telepon',
                'data' => '021-12345678',
            ],
            [
                'kontak' => 'whatsApp',
                'data' => '08123456789',
            ],
            [
                'kontak' => 'instagram',
                'data' => 'link_instagram',
            ],
            [
                'kontak' => 'facebook',
                'data' => 'link_facebook',
            ],
            [
                'kontak' => 'youtube',
                'data' => 'link_youtube',
            ],
            [
                'kontak' => 'tiktok',
                'data' => 'link_tiktok',
            ],
        ];

        // insert data
        foreach ($data as $row) {
            $this->db->table('kontak')->insert($row);
        }
    }
}
