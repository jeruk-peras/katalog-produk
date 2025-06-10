<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BannerModel;
use App\Models\KategoriModel;
use App\Models\KontakModel;
use App\Models\LayananModel;
use App\Models\PatnerModel;
use App\Models\ProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

class PagesController extends BaseController
{
    public function index()
    {
        //
    }

    public function beranda(){
        $ModelBanner = new BannerModel();
        $ModelKategori = new KategoriModel();
        $ModelProduk = new ProdukModel();
        $ModelLayanan = new LayananModel();
        $ModelPatner = new PatnerModel();

        $data = [
            'title' => '',
            'banner' => $ModelBanner->findAll(),
            'kategori' => $ModelKategori->findAll(),
            'produk' => $ModelProduk->getAllProduk(),
            'layanan' => $ModelLayanan->findAll(),
            'patner' => $ModelPatner->findAll()
        ];

        return view('pages/beranda', $data);
    }

    public function kontak(){
        $kontakModel = new KontakModel();
        $data = [
            'title' => '',
            'nav' => '',
        ];

        foreach ($kontakModel->findAll() as $row) {
            $data[$row['kontak']] = $row['data'];
        }

        return view('pages/kontak', $data);
    }
}
