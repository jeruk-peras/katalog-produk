<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
use App\Models\OrdersDetailModel;
use App\Models\OrderSelesModel;
use App\Models\OrdersModel;
use App\Models\ProdukModel;
use App\Models\PromoDetailModel;
use App\Models\PromoProdukMOdel;
use CodeIgniter\HTTP\ResponseInterface;

class HelperController extends BaseController
{
    public function index()
    {
        //
    }

    public function filepondupload()
    {
        $upload = new UploadFileLibrary();

        try {
            if ($imagefile = $this->request->getFiles()) {
                foreach ($imagefile['filepond'] as $img) {
                    $filename = $upload->uploadImage($img, 'assets/images/produk/');
                    return $this->response->setJSON($filename);
                }
            };
        } catch (\Throwable $th) {
            return 'Gagal mengunggah file.' . $th->getMessage();
        }
    }

    public function filepondrevert()
    {
        $fileName = $this->request->getBody(); // Ambil nama file dari request

        if (unlink('assets/images/produk/' . $fileName)) { // Hapus file
            return $this->response->setJSON([
                'status' => 200,
                'message' => 'File berhasil dihapus.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 400,
            'message' => 'Gagal menghapus file.',
        ]);
    }

    public function Orders()
    {
        $RESPONSEJSON = new ResponseJSONCollection();
        $ModelOrders = new OrdersModel();
        $ModelDetailOrders = new OrdersDetailModel();
        $ModelProduk = new ProdukModel();

        $postData =  $this->request->getPost();

        $ModelOrders->db->transStart();
        try {
            $alamat = $postData['alamat'] . ', Kel/Ds.' . $postData['kelurahan'] . ' Kec.' . $postData['kecamatan'] . ' ' . $postData['kota_kabupaten'] . ', ' . $postData['provinsi'];

            $ordersHeader = [
                'no_order' => 'ODR' . date('ymdHis'),
                'nama' => $postData['nama_lengkap'],
                'no_handphone' => $postData['no_handphone'],
                'email' => $postData['email'],
                'nama_tempat' => $postData['nama_tempat'],
                'alamat' => $alamat,
                'catatan' => $postData['catatan'],
                'sales_id' => $postData['id_sales']
            ];

            $id_orders = $ModelOrders->insert($ordersHeader);
            $orderDetail = [];
            foreach ($postData['id_produk'] as $key => $value) {

                $item = $ModelProduk->getProdukVarian($value, (int)$postData['id_varian'][$key]);

                $orderDetail = [
                    'order_id' => $id_orders,
                    'produk_id' => $value,
                    'varian_id' => (int)$postData['id_varian'][$key],
                    'harga' => (int)$item['harga_varian'],
                    'harga_diskon' => (int)$this->__checkpromoproduk('harga_diskon', $value, (int)$postData['id_varian'][$key]),
                    'jumlah' => (int)$postData['jumlah'][$key],
                    'total' => (($postData['harga_diskon'][$key] == 0 ? (int)$postData['harga'][$key] : $postData['harga_diskon'][$key])) * (int)$postData['jumlah'][$key]
                ];
                $detailsave = $ModelDetailOrders->insert($orderDetail);
                // var_dump($detailsave);
                // var_dump($orderDetail);
            }

            // die;

            $data = [
                'header' => $ordersHeader,
                'detail' => $orderDetail
            ];

            $ModelOrders->db->transComplete();
            return $RESPONSEJSON->success($data, 'Berhasil', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            $ModelOrders->db->transRollback();
            return $RESPONSEJSON->error('', $th->getMessage(), ResponseInterface::HTTP_BAD_REQUEST);
        }
    }

    public function refreshproduk()
    {
        $ModelProduk = new ProdukModel();

        $datapost = $this->request->getPost()['cart'];
        // var_dump($datapost); die;
        $datakeranjang = [];
        foreach ($datapost as $row) {

            $item = $ModelProduk->getProdukVarian($row['id_produk'], $row['id_varian']);

            // var_dump($row);
            $datakeranjang[] = [
                'gambar' => base_url('assets/images/produk/') . $item['gambar'],
                'id_produk' => (int)$item['id_produk'],
                'nama_produk' => $item['nama_produk'],
                'id_varian' => (int)$item['id_varian'],
                'nama_varian' => $item['nama_varian'],
                'harga' => (int)$item['harga_varian'],
                'harga_diskon' => (int)$this->__checkpromoproduk('harga_diskon', $row['id_produk'], $row['id_varian']),
                'jumlah' => (int)$row['jumlah'],
                'total' => 0,
            ];
        }

        return response()->setJSON($datakeranjang);
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

    public function hendleSalesCode()
    {
        $RESPONSEJSON = new ResponseJSONCollection();
        $postdata = $this->request->getPost();
        $ModelSales = new OrderSelesModel();

        try {
            $salesData = $ModelSales->where('kode_sales', $postdata['kode_sales'])->first();

            $data = [
                'id'  => $salesData['id'],
                'nama_sales' => $salesData['nama_sales'],
                'kode_sales' => $salesData['kode_sales'],
            ];

            return $RESPONSEJSON->success($data, 'Kode sales valid!', ResponseInterface::HTTP_OK);
        } catch (\Throwable $th) {
            return $RESPONSEJSON->success([], 'Kode sales tidak valid!', ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
}
