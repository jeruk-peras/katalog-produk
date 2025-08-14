<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    private $responseJSON;
    private $db;
    private $priode = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'Mei',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Agu',
        9 => 'Sep',
        10 => 'Okt',
        11 => 'Nov',
        12 => 'Des',
    ];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->responseJSON = new ResponseJSONCollection();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'nav' => 'dashboard'
        ];

        $dataTerlaris = $this->db->table('orders_detail od')
            ->select('o.id_order, od.produk_id, od.varian_id, p.nama_produk, v.nama_varian, k.nama_kategori')->selectSum('od.jumlah')
            ->join('produk p', 'p.id_produk = od.produk_id')
            ->join('kategori k', 'k.id_kategori = p.kategori_id')
            ->join('produk_varian v', 'v.id_varian = od.varian_id')
            ->join('orders o', 'o.id_order = od.order_id')
            ->join('order_sales os', 'os.id = o.sales_id')
            ->groupBy('od.varian_id')->orderBy('jumlah', 'DESC')->limit(60)
            ->get()->getResultArray();

        // dd($dataTerlaris);
        $data['terlaris'] = $dataTerlaris;

        return view('admin/dashboard', $data);
    }

    public function penjualanBulanan()
    {
        try {
            $tahun = $this->request->getGet('tahun') ?? date('Y');
            $data = [
                'title' => 'GRAFIK PENJUALAN PERBULAN TAHUN ' . $tahun,
                'series' => [
                    'name' => 'P',
                    'data' => [],
                ],
                'categories' => []
            ];

            // data sales
            $dataSales = $this->db->table('order_sales')->get()->getResultArray();


            foreach ($this->priode as $key => $periode) {
                $dataPenjualan = $this->db->table('orders_detail od')
                    ->select('o.id_order, o.no_order, od.produk_id, od.varian_id, od.harga_beli, od.harga, od.harga_diskon, od.jumlah')
                    ->join('orders o', 'o.id_order = od.order_id')
                    ->join('order_sales os', 'os.id = o.sales_id')
                    ->where("o.created_at BETWEEN '$tahun-$key-01' AND '$tahun-$key-31'")
                    ->get()->getResultArray();
                $totalPenjualan = 0;
                foreach ($dataPenjualan as $penjualan) {
                    $harga = !empty($penjualan['harga_diskon']) ? $penjualan['harga_diskon'] : $penjualan['harga'];

                    $totalPenjualan += ($harga * $penjualan['jumlah']);
                }
                $data['series']['data'][] = $totalPenjualan;
                $data['categories'][] = $periode;
            }

            return $this->responseJSON->success($data, 'success', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseJSON->error($th->getMessage(), 'success', ResponseInterface::HTTP_OK);
        }
    }

    public function penjualanBulananBySales()
    {
        try {
            $tahun = $this->request->getGet('tahun') ?? date('Y');
            $data = [
                'title' => 'GRAFIK PENJUALAN BY SALES PERBULAN TAHUN ' . $tahun,
                'series' => [],
                'categories' => []
            ];

            // data sales
            $dataSales = $this->db->table('order_sales')->get()->getResultArray();

            // loop data sales
            foreach ($dataSales as $i => $sales) {

                $totalPenjualan = [];
                $p = [];
                // loop untuk periode
                foreach ($this->priode as $key => $periode) {

                    // get data penjulan per sales, dengan range perbulan
                    $dataPenjualan = $this->db->table('orders_detail od')
                        ->select('o.id_order, o.no_order, od.produk_id, od.varian_id, od.harga_beli, od.harga, od.harga_diskon, od.jumlah')
                        ->join('orders o', 'o.id_order = od.order_id')
                        ->join('order_sales os', 'os.id = o.sales_id')
                        ->where("os.id = {$sales['id']} AND o.created_at BETWEEN '$tahun-$key-01' AND '$tahun-$key-31'")
                        ->get()->getResultArray();

                    $total = 0;
                    foreach ($dataPenjualan as $penjualan) {
                        // jika ada harga diskon maka gunakan harga diskon untuk perhitungan
                        $harga = !empty($penjualan['harga_diskon']) ? $penjualan['harga_diskon'] : $penjualan['harga'];
                        // perhitngan harga * jumlah, untuk menentukan total harga
                        $total += ($harga * $penjualan['jumlah']);
                    }

                    $totalPenjualan[] = $total;
                    $p[] = $periode;
                }

                // set data untuk response json
                $data['categories'] = $p;
                $data['series'][$i]['name'] = $sales['nama_sales'];
                $data['series'][$i]['data'] = $totalPenjualan;
            }

            return $this->responseJSON->success($data, 'success', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->responseJSON->error($th->getMessage(), 'success', ResponseInterface::HTTP_OK);
        }
    }
}
