<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Models\BannerModel;
use App\Models\KategoriModel;
use App\Models\KontakModel;
use App\Models\LayananModel;
use App\Models\PatnerModel;
use App\Models\ProdukModel;
use App\Models\ProdukSpesifikasiModel;
use App\Models\ProdukVarianModel;
use App\Models\PromoDetailModel;
use App\Models\PromoProdukModel;
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
            'layanan' => $this->ModelLayanan->findAll(),
            'patner' => $this->ModelPatner->findAll()
        ];

        // produk promo
        $produk = $this->ModelProduk->getAllProduk('nama_produk', '');
        $dataproduk = [];
        foreach ($produk as $row) {
            if ($this->__checkpromoproduk('harga_awal', $row['id_produk'])) {

                $dataproduk[] = [
                    'id_produk' => $row['id_produk'],
                    'gambar' => $row['gambar'],
                    'nama_produk' => $row['nama_produk'],
                    'nama_varian' => $row['nama_varian'],
                    'slug_produk' => $row['slug_produk'],
                    'nama_kategori' => $row['nama_kategori'],
                    'slug_kategori' => $row['slug_kategori'],
                    'harga_varian' =>  $this->__checkpromoproduk('harga_awal', $row['id_produk']),
                    'harga_diskon' => $this->__checkpromoproduk('harga_diskon', $row['id_produk']),
                ];
            }
        }
        $data['promo'] = $dataproduk;

        // daftar produk
        // dd($produk);
        $produk = $this->ModelProduk->getAllProduk('nama_produk', '', 8, 0);
        $dataproduk = [];
        foreach ($produk as $row) {
            $dataproduk[] = [
                'id_produk' => $row['id_produk'],
                'gambar' => $row['gambar'],
                'nama_produk' => $row['nama_produk'],
                'nama_varian' => $row['nama_varian'],
                'slug_produk' => $row['slug_produk'],
                'nama_kategori' => $row['nama_kategori'],
                'slug_kategori' => $row['slug_kategori'],
                'harga_varian' => ($this->__checkpromoproduk('harga_awal', $row['id_produk']) ? $this->__checkpromoproduk('harga_awal', $row['id_produk']) : $row['harga_varian']),
                'harga_diskon' => $this->__checkpromoproduk('harga_diskon', $row['id_produk']),
            ];
        }

        // d($dataproduk);
        $data['produk'] = $dataproduk;

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
        ];

        $search_field = 'nama_produk';
        $search_value = $this->request->getGet('query') ?? '';

        $limit = 24;
        $offset = ($this->request->getGet('page') ? (($this->request->getGet('page') - 1) * $limit) : 0);

        $countAllProduk = $this->ModelProduk->like($search_field, $search_value)->countAllResults();
        $pages = ($countAllProduk / $limit);

        $data['page'] = floor($pages);

        $produk = $this->ModelProduk->getAllProduk($search_field, $search_value, $limit, $offset);
        $dataproduk = [];

        foreach ($produk as $row) {
            $dataproduk[] = [
                'id_produk' => $row['id_produk'],
                'gambar' => $row['gambar'],
                'nama_produk' => $row['nama_produk'],
                'nama_varian' => $row['nama_varian'],
                'slug_produk' => $row['slug_produk'],
                'nama_kategori' => $row['nama_kategori'],
                'slug_kategori' => $row['slug_kategori'],
                'harga_varian' => ($this->__checkpromoproduk('harga_awal', $row['id_produk']) ? $this->__checkpromoproduk('harga_awal', $row['id_produk']) : $row['harga_varian']),
                'harga_diskon' => $this->__checkpromoproduk('harga_diskon', $row['id_produk']),
            ];
        }

        // d($dataproduk);
        $data['produk'] = $dataproduk;

        return view('pages/produk', $data);
    }

    private function __checkpromoproduk($field, $id_produk, $id_varian = false)
    {
        $ModelPromo = new PromoProdukMOdel();
        $ModelPromoDetail = new PromoDetailModel();

        $where = ['produk_id' => $id_produk];
        $id_varian == false ?: $where = ['varian_id' => $id_varian];


        $checkpromo = $ModelPromoDetail
            ->where($where)
            ->where('status', 1)
            ->first();

        return $checkpromo[$field] ?? 0;
    }

    public function produk_kategori($slug)
    {
        $data = [
            'title' => 'Produk',
            'nav' => 'produk',
        ];

        $ModelKategori = new KategoriModel();
        $getId = $ModelKategori->where('slug_kategori', $slug)->first()['id_kategori'];

        $search_field = 'nama_produk';
        $search_value = $this->request->getGet('query') ?? '';

        $limit = 12;
        $offset = ($this->request->getGet('page') ? (($this->request->getGet('page') - 1) * $limit) : 0);

        $countAllData = $this->ModelProduk->getAllProdukKategori($search_field, $search_value, $getId);
        $countData = count($countAllData) >= $limit ? count($countAllData) : 0;
        $pages = ($countData / $limit);

        $data['page'] = floor($pages);

        $produk = $this->ModelProduk->getAllProdukKategori($search_field, $search_value, $getId, $limit, $offset);
        $dataproduk = [];
        foreach ($produk as $row) {
            $dataproduk[] = [
                'id_produk' => $row['id_produk'],
                'gambar' => $row['gambar'],
                'nama_produk' => $row['nama_produk'],
                'nama_varian' => $row['nama_varian'],
                'slug_produk' => $row['slug_produk'],
                'nama_kategori' => $row['nama_kategori'],
                'slug_kategori' => $row['slug_kategori'],
                'harga_varian' => ($this->__checkpromoproduk('harga_awal', $row['id_produk']) ? $this->__checkpromoproduk('harga_awal', $row['id_produk']) : $row['harga_varian']),
                'harga_diskon' => $this->__checkpromoproduk('harga_diskon', $row['id_produk']),
            ];
        }
        $data['produk'] = $dataproduk;

        return view('pages/produk', $data);
    }

    public function produk_detail($id_produk, $slug_kategori, $slug_produk)
    {
        $dataDetail = $this->ModelProduk->getFindProduk($id_produk, $slug_kategori, $slug_produk);

        if ($dataDetail) {
            $PSpesifikasiModel =  new ProdukSpesifikasiModel();
            $ModelVarian = new ProdukVarianModel();

            $dataSpesifikasi = $PSpesifikasiModel->getProdukSpesifikasi($id_produk);
            $dataGambar = $this->ModelProduk->getGambarProduk($id_produk, $slug_kategori, $slug_produk);
            $dataVarian = $ModelVarian->where(['produk_id' => $id_produk])->findAll();

            $data = [
                'title' => 'Detail Produk',
                'nav' => 'produk',
            ];

            $data['produk'] = [
                'id_produk' => $dataDetail['id_produk'],
                'nama_produk' => $dataDetail['nama_produk'],
                'deskripsi_produk' => $dataDetail['deskripsi_produk'],
                'kategori_id' => $dataDetail['kategori_id'],
                'gambar' => $dataDetail['gambar'],
                'nama_kategori' => $dataDetail['nama_kategori'],
                'slug_kategori' => $dataDetail['slug_kategori'],
                'id_varian' => $dataDetail['id_varian'],
                'nama_varian' => $dataDetail['nama_varian'],
                'harga_varian' => $dataDetail['harga_varian'],
                'stok_varian' => $dataDetail['stok_varian'],
                'harga_diskon' => $this->__checkpromoproduk('harga_diskon', $dataDetail['id_produk'], $dataDetail['id_varian']),
            ];
            $data['gambar'] = $dataGambar;
            $data['spesifikasi'] = $dataSpesifikasi;

            $variandata = [];
            foreach ($dataVarian as $row) {
                $variandata[] = [
                    'id_varian' => $row['id_varian'],
                    'nama_varian' => $row['nama_varian'],
                    'harga_varian' => $row['harga_varian'],
                    'stok_varian' => $row['stok_varian'],
                    'produk_id' => $row['produk_id'],
                    'harga_diskon' => $this->__checkpromoproduk('harga_diskon', $row['produk_id'], $row['id_varian']),
                ];
            }

            $data['varian'] = $variandata;

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
