<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ResponseJSONCollection;
use App\Libraries\UploadFileLibrary;
use App\Models\OrdersDetailModel;
use App\Models\OrderSelesModel;
use App\Models\OrdersModel;
use App\Models\ProdukModel;
use App\Models\ProdukVarianModel;
use App\Models\PromoDetailModel;
use App\Models\PromoProdukModel;
use CodeIgniter\HTTP\ResponseInterface;

use function PHPUnit\Framework\returnSelf;

class HelperController extends BaseController
{
    public function index()
    {
        //
    }

    public function fileponduploads()
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

    public function filepondupload()
    {
        $upload = new UploadFileLibrary();

        try {
            if ($imagefile = $this->request->getFile('gambar')) {
                $filename = $upload->uploadImage($imagefile, 'assets/images/produk/');
                return $this->response->setJSON($filename);
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
        $ModelSales = new OrderSelesModel();

        $postData =  $this->request->getPost(); 
        
        // validasi data
        if($postData == '') return $RESPONSEJSON->error('', 'Silahkan periksa permintaan anda', ResponseInterface::HTTP_BAD_REQUEST);
        // cek id sales
        if(empty($ModelSales->find($postData['id_sales']))) return $RESPONSEJSON->error('', 'Silahkan periksa permintaan anda', ResponseInterface::HTTP_BAD_REQUEST);

        $ModelOrders->db->transStart();
        try {
            $alamat = $postData['alamat'] . ', Kel/Ds.' . $postData['kelurahan'] . ' Kec.' . $postData['kecamatan'] . ' ' . $postData['kota_kabupaten'] . ', ' . $postData['provinsi'];

            $ordersHeader = [
                'no_order' => $ModelOrders->generateNoOrder(),
                'nama' => $postData['nama_lengkap'],
                'no_handphone' => $postData['no_handphone'],
                'email' => $postData['email'],
                'nama_tempat' => $postData['nama_tempat'],
                'alamat' => $alamat,
                'catatan' => $postData['catatan'],
                'metode_pembayaran' => $postData['metode_pembayaran'],
                'sales_id' => $postData['id_sales']
            ];

            // $id_orders = 0;
            $id_orders = $ModelOrders->insert($ordersHeader);
            $orderDetail = [];
            foreach ($postData['id_produk'] as $key => $value) {

                $item = $ModelProduk->getProdukVarian($value, (int)$postData['id_varian'][$key]);

                $orderDetail[] = [
                    'order_id' => $id_orders,
                    'produk_id' => $value,
                    'varian_id' => (int)$postData['id_varian'][$key],
                    'harga' => (int)$item['harga_varian'],
                    'harga_diskon' => (int)$this->__checkpromoproduk('harga_diskon', $value, (int)$postData['id_varian'][$key]),
                    'jumlah' => (int)$postData['jumlah'][$key],
                    'total' => (($postData['harga_diskon'][$key] == 0 ? (int)$postData['harga'][$key] : $postData['harga_diskon'][$key])) * (int)$postData['jumlah'][$key]
                ];
                // $detailsave = $ModelDetailOrders->insert($orderDetail);
                // var_dump($detailsave);
                // var_dump($orderDetail);

                // update stok
                $this->__stokupdate((int)$postData['jumlah'][$key], $value, (int)$postData['id_varian'][$key]);
            }
            $detailsave = $ModelDetailOrders->insertBatch($orderDetail);
            // var_dump($detailsave);

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

    private function __stokupdate($jumlah, $id_produk, $id_varian)
    {
        $ModelDetail = new ProdukVarianModel();
        $ModelProduk = new ProdukModel();

        $oldstok = $ModelProduk->getProdukVarian($id_produk, $id_varian)['stok_varian'];

        $newstok = ($oldstok - $jumlah);
        // var_dump($newstok);die;

        $set = ['stok_varian' => $newstok];

        $update = $ModelDetail
            ->set($set)
            ->where(['id_varian' => $id_varian, 'produk_id' => $id_produk])
            ->update();

        return $update;
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
                'stok_varian' => $item['stok_varian'],
                'harga' => (int)$item['harga_varian'],
                'harga_diskon' => (int)$this->__checkpromoproduk('harga_diskon', $row['id_produk'], $row['id_varian']),
                'jumlah' => (int)$row['jumlah'],
                'total' => (((int)$this->__checkpromoproduk('harga_diskon', $row['id_produk'], $row['id_varian']) == 0 ? (int)$item['harga_varian'] : (int)$this->__checkpromoproduk('harga_diskon', $row['id_produk'], $row['id_varian']))) * (int)$row['jumlah'],
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
