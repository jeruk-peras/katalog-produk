<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BannerModel;
use App\Models\KategoriModel;
use App\Models\KontakModel;
use App\Models\LayananModel;
use App\Models\PatnerModel;
use App\Models\ProdukModel;
use App\Models\ProdukSpesifikasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class PagesController extends BaseController
{

    private $ModelBanner;
    private $ModelKategori;
    private $ModelProduk;
    private $ModelLayanan;
    private $ModelPatner;
    private $kontakModel;

    public function __construct()
    {
        $this->ModelBanner = new BannerModel();
        $this->ModelKategori = new KategoriModel();
        $this->ModelProduk = new ProdukModel();
        $this->ModelLayanan = new LayananModel();
        $this->ModelPatner = new PatnerModel();
        $this->kontakModel = new KontakModel();
    }

    public function index() {}

    public function beranda()
    {
        $data = [
            'title' => 'Beranda',
            'nav' => 'beranda',
            'banner' => $this->ModelBanner->findAll(),
            'kategori' => $this->ModelKategori->findAll(),
            'produk' => $this->ModelProduk->getAllProduk(),
            'layanan' => $this->ModelLayanan->findAll(),
            'patner' => $this->ModelPatner->findAll()
        ];

        return view('pages/beranda', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'Tentang Kami',
            'nav' => 'about',
            'layanan' => $this->ModelLayanan->findAll(),
        ];

        return view('pages/tentang-kami', $data);
    }

    public function kontak()
    {
        $data = [
            'title' => 'Kontak',
            'nav' => 'kontak',
        ];

        foreach ($this->kontakModel->findAll() as $row) {
            $data[$row['kontak']] = $row['data'];
        }

        return view('pages/kontak', $data);
    }

    public function produk()
    {
        $data = [
            'title' => 'Produk',
            'nav' => 'produk',
            'produk' => $this->ModelProduk->getAllProduk(),
        ];

        return view('pages/produk', $data);
    }

    public function produk_kategori($slug)
    {
        $ModelKategori = new KategoriModel();

        $getId = $ModelKategori->where('slug_kategori', $slug)->first()['id_kategori'];
        $data = [
            'title' => 'Produk',
            'nav' => 'produk',
            'produk' => $this->ModelProduk->getAllProdukKategori($getId),
        ];

        return view('pages/produk', $data);
    }

    public function produk_detail($id_produk, $slug_kategori, $slug_produk)
    {
        $dataDetail = $this->ModelProduk->getFindProduk($id_produk, $slug_kategori, $slug_produk);

        if ($dataDetail) {
            $PSpesifikasiModel =  new ProdukSpesifikasiModel();
            $dataSpesifikasi = $PSpesifikasiModel->getProdukSpesifikasi($id_produk);
            $dataGambar = $this->ModelProduk->getGambarProduk($id_produk, $slug_kategori, $slug_produk);

            $data = [
                'title' => 'Detail Produk',
                'nav' => 'produk',
            ];

            $data['produk'] = $dataDetail;
            $data['gambar'] = $dataGambar;
            $data['spesifikasi'] = $dataSpesifikasi;

            return view('pages/produk-detail', $data);
        }

        return throw PageNotFoundException::forPageNotFound();
    }

    public function keranjang()
    {
        $data = [
            'title' => 'Keranjang',
            'nav' => '',
        ];

        return view('pages/keranjang', $data);
    }
}
