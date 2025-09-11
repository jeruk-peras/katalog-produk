<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanController extends BaseController
{
    private $db;
    private $responseJSON;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->responseJSON = new ResponseJSONCollection();
    }

    public function penjualan()
    {
        $data = [
            'title' => 'Laporan Penjualan',
            'nav' => 'dashboard'
        ];

        return view('admin/laporan/penjualan', $data);
    }

    public function data_penjualan()
    {
        try {
            $tanggal_awal = $this->request->getPost('tanggal_awal') ? $this->request->getPost('tanggal_awal') : date("Y-m-") . '1';
            $tanggal_akhir = $this->request->getPost('tanggal_akhir') ? $this->request->getPost('tanggal_akhir') : date("Y-m-") . '31';

            $dataPenjualan =  $this->db->table('orders o')
                ->select('o.created_at, o.no_order, os.nama_sales, o.nama, o.nama_tempat, o.metode_pembayaran, p.nama_produk, v.nama_varian, k.nama_kategori, od.harga, od.harga_diskon, od.jumlah')
                ->join('order_sales os', 'os.id = o.sales_id')
                ->join('orders_detail od', 'od.order_id = o.id_order')
                ->join('produk p', 'p.id_produk = od.produk_id')
                ->join('kategori k', 'k.id_kategori = p.kategori_id')
                ->join('produk_varian v', 'v.id_varian = od.varian_id')
                ->where("o.created_at BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir 23:59:00'")
                ->orderBy('o.created_at', 'DESC')
                ->get()->getResultArray();

            $html = view('admin/laporan/penjualan-side', ['data' => $dataPenjualan]);

            return $this->responseJSON->success(['html' => $html, 'data' => $dataPenjualan], 'Berhasil', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseJSON->error($th->getMessage(), 'Berhasil', ResponseInterface::HTTP_OK);
        }
    }

    public function stok_produk()
    {
        $data = [
            'title' => 'Laporan Stok Produk',
            'nav' => 'dashboard'
        ];

        return view('admin/laporan/stok-produk', $data);
    }

    public function data_stok_produk()
    {
        try {
            $dataProduk = $this->db->table('produk p')
                ->select('p.id_produk, p.nama_produk, k.nama_kategori, v.id_varian, v.nama_varian, v.stok_varian, v.harga_beli, v.harga_varian')
                ->join('kategori k', 'k.id_kategori = p.kategori_id')
                ->join('produk_varian v', 'v.produk_id = p.id_produk', 'left')
                ->orderBy('v.stok_varian', 'ASC')->orderBy('p.id_produk', 'ASC')
                ->get()->getResultArray();

            $html = view('admin/laporan/stok-produk-side', ['data' => $dataProduk]);

            return $this->responseJSON->success(['html' => $html, 'data' => $dataProduk], 'Berhasil', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseJSON->error($th->getMessage(), 'Berhasil', ResponseInterface::HTTP_OK);
        }
    }
}
